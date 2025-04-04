<?php
class Sabloane {
/*****************************************************************/	
	function  __construct($use_caching=false,$cache_id=NULL,$cache_auto_display=true,$cache_allow_override=true,$cache_prefix="",$retain_expired_cachefiles=false) {
		$this->cache_prefix = $cache_prefix;
		$this->page_prev = "&lt; Prev";
		$this->page_next = "Next &gt;";
		$this->page_show_all = "Show All";
		$this->page_show_pages = "Show Pages";
		$this->plugins = array();
		$this->transforms = array();
		$this->retain_expired_cachefiles = $retain_expired_cachefiles;
		if (is_null($cache_id)) $cache_id = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		$this->cache_id = $cache_id;

		if ($use_caching && !(defined('DISABLE_TEMPLATE_CACHING') && DISABLE_TEMPLATE_CACHING) ) {
			if (!($cache_allow_override and isset($_REQUEST["nocache"]))) {
				if ($this->load_cache($this->cache_id)) {
					$this->cached = true;
					if ($cache_auto_display) {
						$this->display_cached_page();
						die;
					}
				} else {
					if (defined('TEMPLATE_CACHE_DEBUG') && TEMPLATE_CACHE_DEBUG) {
						echo "<div align='center'>Cache miss (\"$this->cache_id\"".($this->cache_prefix?"; prefix: \"{$this->cache_prefix}\"":"").")</div>";
					}
				}
			}
		}
		
		$this->cached = false;
		$this->cache_content_type = false;
		$this->auto_store_cache = true;
		$this->nocache_semaphore = false;
		$this->display_undefined = false;		
		$this->set_server_variables();
		$this->filters = array();
		$this->template_fallback_dirs = array();
		$this->template_override_dirs = array();
		$this->template_override_subdirs = array();
		$this->stored_template_dirs = array();
		$this->stored_template_fallback_dirs = array();
		$this->internal_i18n = false;
		$this->utf8 = false;
		$this->cache_expire_time = NULL;
		$this->debug_load = false;
	}
	
	function xlat($s) {
		if ($this->internal_i18n && function_exists('__')) {
			$s = __($s);
		} elseif (function_exists('_')) {
			$s = _($s);
		}
		
		return $s;
	}
	
	function display_cached_page() {
		if ($this->cache_content_type && !headers_sent()) Header('Content-type: '.$this->cache_content_type);
		echo $this->output;
		if (TEMPLATE_CACHE_DEBUG) {
			echo "<div align='center'>Cache hit (\"$this->cache_id\"".($this->cache_prefix?"; prefix: \"{$this->cache_prefix}\"":"").")</div>";
		}
	}
	
	function set_cache_lifetime($cache_expire_time) {
		$this->cache_expire_time = $cache_expire_time;
	}
	
	function set_nocache_semaphore($permanent=false,$temporary=false,$timeout=28800) {
		$this->nocache_perm_semaphore = $permanent;
		$this->nocache_temp_semaphore = $temporary;
		$this->nocache_temp_timeout = $timeout; // 8 hours
	}

	function set_server_variables() {
		$this->variables = array(
			"server_php_self"=>$_SERVER["PHP_SELF"],
			"server_request_uri"=>$_SERVER["REQUEST_URI"],
			"server_server_name"=>$_SERVER["SERVER_NAME"],
			"server_script_name"=>$_SERVER["SCRIPT_NAME"],
			"server_remote_addr"=>$_SERVER["REMOTE_ADDR"],
			"server_unix_time"=>time(),
			"server_date"=>strftime("%b %d, %Y"),
			"server_time"=>strftime("%I:%M:%S%p"),
			"_nil"=>0,
			"_null"=>0,
			"_"=>0,
		);
		$this->assign_by_ref("_REQUEST",$_REQUEST);
		$this->assign_by_ref("_SERVER",$_SERVER);
		$this->assign_by_ref("_ENV",$_ENV);
		$this->assign_by_ref("_COOKIE",$_COOKIE);
		$this->assign_by_ref("_SESSION",$_SESSION);

		if (defined("TPL_CUSTOM_PLUGINS")) {
			$plugins = explode("|",TPL_CUSTOM_PLUGINS);
			foreach ($plugins as $k=>$plugin) {
				list($plugin_name,$plugin_function) = explode(":",$plugin);
				$this->plugins[$plugin_name] = $plugin_function;
			}
		}
		if (defined("TPL_CUSTOM_TRANSFORMS")) {
			$transforms = explode("|",TPL_CUSTOM_TRANSFORMS);
			foreach ($transforms as $k=>$transform) {
				list($transform_name,$transform_function) = explode(":",$transform);
				$this->transforms[$transform_name] = $transform_function;
			}
		}
		
	}
	
	function get_template_filename($filename,$absolute_path = false) {
		if ($this->template_dir && !$absolute_path) {
			
			$pathname = false;
			
			if ($this->template_override_dirs && count($this->template_override_dirs)) {
				reset($this->template_override_dirs);
				foreach ($this->template_override_dirs as $k=>$dir) {
					if (substr($dir,-1)!="/") $dir .= "/";
					$pathname = $dir.$filename;
					if (is_readable($pathname)) {
						break;
					} else {
						$pathname = '';
					}
				}
			}
			
			if ($this->template_override_subdirs && count($this->template_override_subdirs)) {
				if (substr($this->template_dir,-1)!="/") $this->template_dir .= "/";

				reset($this->template_override_subdirs);
				foreach ($this->template_override_subdirs as $k=>$dir) {
					if (substr($dir,-1)!="/") $dir .= "/";
					$pathname = $this->template_dir . $filename;
					$pathname = dirname($pathname) . '/' . $dir . basename($pathname);

					if (is_readable($pathname)) {
						break;
					} else {
						$pathname = '';
					}
				}
			}
			
			if (!strlen($pathname)) {
				if (substr($this->template_dir,-1)!="/") $this->template_dir .= "/";
				$pathname = $this->template_dir.$filename;
				
				if ($this->template_fallback_dirs && count($this->template_fallback_dirs)) {
					if (!is_readable($pathname)) {
						reset($this->template_fallback_dirs);
						foreach ($this->template_fallback_dirs as $k=>$dir) {
							if (substr($dir,-1)!="/") $dir .= "/";
							$pathname = $dir.$filename;
							if (is_readable($pathname)) break;
						}
					}
				}
			}
			$filename = $pathname;
			
		} elseif (defined("TEMPLATE_BASE") && !$absolute_path) {
			$filename = TEMPLATE_BASE.$filename;
		}
		
		return $filename;
	}

	function include_template($filename) {
		if (substr($filename,0,2)=='./') {
			$currentdir = dirname($this->current_filename);
			if (substr($currentdir,-1)!='/') $currentdir .= '/';
			$filename = $currentdir . substr($filename,2);
			
			$absolute = true;
		} else {
			$absolute = false;
		}
		
		$filename = $this->get_template_filename($filename,$absolute);
		$result = $this->read_template($filename);
		if ($result===false) $result = "";
    	
    	return $result;
	}
	
	function load_template($filename,$absolute_path = false) {
		$filename = $this->get_template_filename($filename,$absolute_path);
		$this->template = $this->read_template($filename);
		if ($this->template===false) {
			$this->template = "";
		} else {
			$this->current_filename = $filename;
		}
		return $this->template;
	}

	function read_template($filename) {
		if ($this->debug_load) echo "Template::read_template({$filename})\n";
		$fp = @fopen($filename,"r");
		if ($fp) {
			$template = "";
			while (!feof($fp)) {
				$template .= fread($fp,4096);
			}
			fclose($fp);
			
			return $template;
		} else {
			$this->error = "Template $filename not found";
			return false;
		}
	}

	function assign($variable,$value="") {
		if (is_array($variable)) {
			foreach ($variable as $var=>$val) {
				$var = strtolower($var);
				$this->variables[$var] = $val;
			}
		} else {
			$this->variables[strtolower($variable)] = $value;
		}
	}

	function assign_by_ref($variable,&$value) {
		$this->variables[strtolower($variable)] = &$value;
	}

	function unassign($variable) {
	  	if (is_array($variable)) {
	      foreach ($variable as $var=>$val) {
	      	$var = strtolower($var);
	        unset($this->variables[$var]);
	      }
	    } else {
	  		$variable = strtolower($variable);
	      unset($this->variables[$variable]);
	  	}
	}

	// Appends a value to the current value of the specified template variable.
	//
	// Accepts:
	//	$variable - the name of the variable in the template (eg: {VARIABLENAME})
	//	$value - the value that should replace {VARIABLENAME} when the template is parsed
	function append($variable,$value) {
		$variable = strtolower($variable);
		$this->variables[$variable] .= $value;
	}

	function begin_capture($variable) {
		$this->capturing = $variable;

		ob_start(); 
		ob_implicit_flush(0); 
	}
	
	function end_capture($append=false) {
		if ($append) {
			$this->append($this->capturing,ob_get_contents());
		} else {
			$this->assign($this->capturing,ob_get_contents());
		}
		ob_end_clean(); 	
	}
	
	function preg_lookup($matches) {
		return $this->lookup($matches[1]);
	}

	function var_or_lit($expression,$brace_if_unquoted = true) {
		$specialchars = '$*=?';
		$firstchar = substr($expression,0,1);
		if (strpos($specialchars,$firstchar)!==false) {
			return $this->lookup($expression);
		} elseif ( ($firstchar=='"') || ($firstchar=="'") ) {
			$lit = substr($expression,1,strlen($expression)-2);
			
			$lit = preg_replace("/\%([0-9A-Fa-f]{2})/e", "''.chr(hexdec('\\1')).''", $lit);
//			$lit = preg_replace("/\{(.*?)\}/e", "\$this->lookup('\\1')", $lit);
			$lit = preg_replace_callback("/\{(.*?)\}/", array(&$this,"preg_lookup"), $lit);
			// %7B = [
			// %7D = ]
			
			return $lit;
		} else {
			if ($brace_if_unquoted) $expression = '{'.$expression.'}';
			return $expression;
		}
	}
	
	function lookup($variable) {
		if (substr($variable,0,1)==" ") { return "{".$variable."}"; } // not to be parsed!
		
		$x = substr($variable,0,1);
		if ($x=="=") {
			// gettext translation
			//	$variable = stripslashes($variable);
			if (preg_match("/^\=\"(.*?)\"(?:\,(.*?))?$/",$variable,$match)) {
				@list(,$msg,$arguments) = $match;
			} else {
				$msg = $this->lookup(substr($variable,1));
			}
						
			$msg = $this->xlat($msg);
			if ($arguments) {
		        $args = preg_split('/,(?=[\"\=\$])/',$arguments);
		        if (is_array($args)) {
			        foreach ($args as $k=>$v) {
			        	$translate_arg = (substr($v,0,1)=='=');
			        	if ($translate_arg) $v = substr($v,1);
	
			        	$v = $this->evaluate_expression($v);
			        	
			        	if ($translate_arg) $v = $this->xlat($v);
			        	
			        	$args[$k] = $v;
			        }
				}
		      	$msg = @vsprintf($msg,$args);
			}
			$res = $msg;

		} elseif ($x=="$") {
			// variable
			$transform = "";
			
			// remove the $
			$variable = substr($variable,1);
						
			$p = strpos($variable,"|");
			if ($p!==false) {
				$transform = substr($variable,$p+1);
				$variable = substr($variable,0,$p);
			}			

			while(($p = strpos($variable,"["))!==false) {
				$q = strpos($variable,"]");
				if ($q<$p) break;
				
				$subvar = substr($variable,$p+1,$q-$p-1);
				$subvar = $this->evaluate_expression($subvar);
				
				$var_pre = substr($variable,0,$p);
				$var_post = substr($variable,$q+1);
				$variable = $var_pre.".".$subvar.$var_post;
			}
			
			if (($p = strpos($variable,"."))!==false) {
				$v = substr($variable,0,$p);
				$variable = strtolower($v).substr($variable,$p);
			} else {
				$variable = strtolower($variable);
			}

			$varset = false;
			if (strpos($variable,".")!==false) {
				$keys = explode(".",$variable);
				
				switch($keys[0]) {
					case '_constants':
						$varset = @defined($keys[1]);
						$res = $varset? @constant($keys[1]) : '';
						break;
					default:
						$res = isset($this->variables[$keys[0]]) ? $this->variables[$keys[0]] : NULL;
						$varset = isset($this->variables[$keys[0]]);

						if ($varset) {
							$needclosebracket = false;
							$bracketkey = "";
							
							for ($i=1; $i<count($keys); $i++) {
								$key = $keys[$i];
								if (substr($key,0,1)=="$") $key = $this->lookup($key); 
								if (is_object($res)) {
									$res = $res->$key;
								} else {
									$res = isset($res[$key]) ? $res[$key] : NULL;
								}
							}
						}
				}
			} else {
				$varset = isset($this->variables[$variable]);
				$res = $this->variables[$variable];	
			}
			if (!$varset) {
				$this->error = "Undefined variables encountered during parsing";
				$this->warnings .= "Template variable {$variable} undefined";
				if ($this->display_undefined)
					$res = "{Undefined:".strtoupper($variable)."}";
			} 
			if ($transform) {
				$res = $this->transform($transform,$res);
			}
		
		} elseif ($x=="*") {
			if (substr($variable,-1)=="*") $res="";
		} elseif ($x=='?') {
			if (preg_match(
				'/^'.
					'\?('.
						'(?:\$?[A-Za-z0-9_\.\|]+)'.
							'(?:[\>|\<|\=]?[\=]?)'.
						'(?:\".*\"|\$?[A-Za-z0-9_\.\|]+)'.
					')'.
					'\?'.
						'(\".*\"|\$?[A-Za-z0-9_\.\|]+)'.
					'\:'.
						'(\".*\"|\$?[A-Za-z0-9_\.\|]+)'.
				'$/',$variable,$match)
			) {
				list(,$condition,$iftrue,$iffalse) = $match;
				$res = $this->var_or_lit(
					$this->evaluate_condition($condition) ? $iftrue : $iffalse
				);
				
			}
			
		} else {
  			$res = "{".$variable."}";
  		}
		return $res;
	}

	function time_text($time,$method) {
		$durations = array(
			1=>			array('second','seconds','sec','secs'),
			60=>		array('minute','minutes','min','mins'),
			60*60=>		array('hour','hours','hr','hrs'),
			24*60*60=>	array('day','days','day','days')
		);
		
		$output = array();
		
		$nosecs = in_array('nosecs',$method);
		
		$textindex = in_array('full',$method) ? 0 : 2;
		foreach (array_reverse($durations,true) as $seconds=>$texts) {
			if ( $nosecs && ($seconds==1) ) continue;
			$amount = $seconds>0 ? floor($time / $seconds) : 0;
			$time -= $amount*$seconds;
			
			$pluralindex = (int) ($amount != 1);
			$text = $texts[ $textindex+$pluralindex ];
			$text = $this->xlat($text);
			
			if ($amount>0) $output[] = sprintf("%d %s",$amount,$text);
		}
		if (!count($output)) $output[] = sprintf("%d %s",0,$durations[1][ $textindex+1 ]);
		
		return implode(', ',$output);
	}
	
	function mysql_timestamp_to_time($dt) {
		if ($dt=="00000000000000") { return "None"; }
	    $yr = substr($dt,0,4);
	    $mo = substr($dt,4,2);
	    $dy = substr($dt,6,2);
	    $hr = substr($dt,8,2);
	    $mn = substr($dt,10,2);
	    $sc = substr($dt,12,2);
	    return mktime($hr,$mn,$sc,$mo,$dy,$yr);
	}

	function mysql_datetime_to_time($dt) {
	    if ($dt=="0000-00-00 00:00:00") { return "None"; }
	    $yr = substr($dt,0,4);
	    $mo = substr($dt,5,2);
	    $dy = substr($dt,8,2);
	    $hr = substr($dt,11,2);
	    $mn = substr($dt,14,2);
	    $sc = substr($dt,17,2);
	    return mktime($hr,$mn,$sc,$mo,$dy,$yr);
	}

	function mysql_time_transform($datetime,$method,$data) {
		switch($datetime) {
			case 3:
				$dt = (int) $data;
				break;
			case 2:
				$dt = time();
				break;
			case 1:
				$dt = $this->mysql_datetime_to_time($data);
				break;
			default:
				$dt = $this->mysql_timestamp_to_time($data);
				break;
		}
		if (isset($method[3])) {
			$offset = $method[3];
			if (substr($offset,0,1)=='+') $offset = substr($offset,1);
			if ($offset=='Z') $offset = date('Z');
			$offset = (int) $offset;
			$dt += $offset;
		}
		
		$datestyle = strtolower($method[1]);
		
		if (preg_match('/^([a-z]+)([+-])([0-9]+)$/i',$datestyle,$matches)) {
			$datestyle = $matches[1];
			$offset = (int) $matches[3] * ( ($matches[2]=='-') ? -1 : 1 );
			$dt += $offset;
		}
		
		if (!$datestyle) $datestyle="verbose";
		if ($datestyle=="full") {
			$dateformat = "l, F d, Y";
			$timeformat = "h:i:sa";
			$monthformat = "F, Y";
		} if ($datestyle=="verbose") {
			$dateformat = "M d, Y";
			$timeformat = "h:i:sa";
			$monthformat = "M, Y";
		} elseif ($datestyle=="numeric") {
			$dateformat = "m-d-Y";
			$timeformat = "H:i:s";
			$monthformat = "m/Y";
		} elseif ($datestyle=="verbosenosecs") {
			$dateformat = "M d, Y";
			$timeformat = "h:ia";
			$monthformat = "M, Y";
		} elseif ($datestyle=="formatted") {
			array_shift($method);
			array_shift($method);
			$datestr = implode(":",$method);
			$datestr = str_replace("_"," ",$datestr);
			
			if (substr($datestr,0,1)=='[') {
				$p = strpos($datestr,']');
				if ($p!==false) {
					$remainder = substr($datestr,$p+2);
					$datestr = substr($datestr,1,$p-1);
					$method = explode(':',$remainder);
				}
			}
		} elseif ($datestyle=="unix") {
			return $dt;
		}
		
		if ($datestyle!="formatted") {
			$datedetails = strtolower($method[2]);
			if (!$datedetails) $datedetails="full";
			switch($datedetails) {
				case "full":
				  	$datestr = "$dateformat $timeformat";
				    break;
				case "date":
				  	$datestr = $dateformat;
				    break;
				case "monthyear":
				  	$datestr = $monthformat;
				    break;
				case "time":
				  	$datestr = $timeformat;
				    break;
			}
		}
		return @date($datestr,$dt);
	}

	function date_select($method,$data) {
		$date = $data;
		array_shift($method);
		$basename = array_shift($method);
		$flags = $method;

		$allownull = in_array("allownull",$flags);
		$datetype = array_shift($flags);
		$options = array();
		$null_date = array(
			"mon"=>-1,
			"mday"=>-1,
			"year"=>-1,
			"hours"=>-1,
			"minutes"=>-1
		);

		
		foreach ($flags as $k=>$flag) {
			if (strpos($flag,'=')!==false) {
				list($flagname,$flagvalue) = explode('=',$flag);
				if (substr($flagvalue,0,1)=='$') $flagvalue = $this->lookup($flagvalue);
				$options[$flagname] = $flagvalue;
			}
		}
		
		if (!$options['minyear']) $options['minyear'] = date('Y');
		if (!$options['maxyear']) $options['maxyear'] = date('Y')+10;
		
		if (substr($date,0,1)=='$') $date = $this->lookup($date);
		switch($datetype) {
			case "datetime":
				$time = $this->mysql_datetime_to_time($date);
				break;
			case 'nulldatetime':
				list($datearray["year"],$datearray["mon"],$datearray["mday"],$datearray["hours"],$datearray["minutes"],$datearray["seconds"]) = sscanf($date,'%04d-%02d-%02d %02d:%02d:%02d');
				break;
			case "timestamp":
				$time = $this->mysql_timestamp_to_time($date);
				break;
			case "unix":
				$time = (int) $date;
				break;
			case "null":
				$time = -1;
				break;
			case "now":
				$time = time();
				break;
			default:
				return "Invalid date type: $datetype";
				break;
		}
		if ($datearray) {
			$date = $datearray;
		} elseif ($time<=0) {
			$date = $null_date;
		} else {
			$date = getdate($time);
		}
		
		
		$months = array(
			$this->xlat("Jan"),
			$this->xlat("Feb"),
			$this->xlat("Mar"),
			$this->xlat("Apr"),
			$this->xlat("May"),
			$this->xlat("Jun"),
			$this->xlat("Jul"),
			$this->xlat("Aug"),
			$this->xlat("Sep"),
			$this->xlat("Oct"),
			$this->xlat("Nov"),
			$this->xlat("Dec")
		);
		
		$output = "";
		if (!in_array("timeonly",$flags)) {

			if (in_array("nomonth",$flags)) {
				$output .= "<input type='hidden' name='{$basename}_month' id='{$basename}_month' value='1'>\n";
			} else {
				$output = "<select name='{$basename}_month' id='{$basename}_month' size='1'>\n";
				if ($allownull) $output .= "<option value='0' /> ---\n";
				foreach ($months as $k=>$month) {
					$output .= "<option value='".($k+1)."'".($k+1==$date["mon"]?" selected='selected'":"")." /> $month\n";
				}
				$output .= "</select>\n";
			}
	
			if (in_array("noday",$flags)) {
				$output .= "<input type='hidden' name='{$basename}_day' id='{$basename}_day' value='1'>\n";
			} else {
				$output .= "<select name='{$basename}_day' id='{$basename}_day' size='1'>\n";
				if ($allownull) $output .= "<option value='0' /> --\n";
				for ($i=1; $i<32; $i++) {
					$output .= "<option value='$i'".($i==$date["mday"]?" selected='selected'":"")." /> $i\n";
				}
				$output .= "</select>\n";
			}
			
			if (in_array("noyear",$flags)) {
				$output .= "<input type='hidden' name='{$basename}_year' id='{$basename}_year' value='".date('Y')."'>\n";
			} else {
				$output .= "<select name='{$basename}_year' id='{$basename}_year' size='1'>\n";
				if ($allownull) $output .= "<option value='0' /> ----\n";
	
				for ($i=$options['minyear']; $i<=$options['maxyear']; $i++) {
					$output .= "<option value='$i'".($i==$date["year"]?" selected='selected'":"")." /> $i\n";
				}
				$output .= "</select>\n";
			}
		}

		if (in_array("showtime",$flags) || in_array("timeonly",$flags)) {
			$houronly = in_array("houronly",$flags);
			$ampm = in_array("ampm",$flags);
			$anytime = in_array("anytime",$flags);
			
			if (!in_array("timeonly",$flags)) $output .= "&nbsp;";
			$output .= "<select name='{$basename}_hour' id='{$basename}_hour' size='1'>\n";
			if ($allownull) $output .= "<option value='' /> ".($anytime ? "Any Time" : "--")."\n";
			
			$hourvalue = (int) $date["hours"];
			if ($ampm) {
				if ($hourvalue==0) {
					$hourvalue = 12;
				} elseif ($hourvalue>11) {
					$hourvalue -= 12;
				}
			}
			
			for ($i=($ampm?1:0); $i<($ampm?13:24); $i++) {
				$h = $i;
				$timeformat = ($h<10?"0":"").$h.($houronly?":00":"");
				
				$output .= "<option value='$i'".($i==$hourvalue?" selected='selected'":"")." /> $timeformat\n";
			}

			$output .= "</select>\n";
			
			if (!$houronly) {
				$output .= " : <select name='{$basename}_min' id='{$basename}_min' size='1'>\n";
				if ($allownull) $output .= "<option value='' /> --\n";
				for ($i=0; $i<60; $i++) {
					$output .= "<option value='$i'".($i==$date["minutes"]?" selected='selected'":"")." /> ".($i<10?"0":"").$i."\n";
				}
				$output .= "</select>\n";
			}
			
			if ($ampm) {
				$ampmvalue = $date['hours']>11 ? 1 : 0;
				$options = array(
					0=>$this->xlat('AM'),
					1=>$this->xlat('PM')
				);
				
				$output .= " <select name='{$basename}_ampm' id='{$basename}_ampm' size='1'>\n";
				foreach ($options as $k=>$v) {
					$output .= "<option value='{$k}'".($ampmvalue==$k?" selected='selected'":"")." /> {$v}\n";
				}
				$output .= "</select>\n";
			}
		}
		
		return $output;
		
	}
	
	function parse_date_select($basename,$timeonly = false) {
		$mo = (int) $_REQUEST[$basename."_month"];
		$dy = (int) $_REQUEST[$basename."_day"];
		$yr = (int) $_REQUEST[$basename."_year"];
		$hr = (int) $_REQUEST[$basename."_hour"];
		$mn = (int) $_REQUEST[$basename."_min"];
		if (isset($_REQUEST[$basename."_ampm"])) {
			$ispm = ((int) $_REQUEST[$basename."_ampm"]) > 0;
			if ($ispm) {
				$hr += 12;
				if ($hr>23) $hr = 0;
			} else {
				if ($hr>11) $hr = 0;
			}
		}
		
		if ($timeonly) {
			$mo = date('m');
			$dy = date('d');
			$yr = date('Y');
		}
		
		if ($mo<=0 || $dy<=0 || $yr<=0) return 0;
		
		return mktime($hr,$mn,0,$mo,$dy,$yr);
	}
	
	function arithmetic_op($variable,$operand,$operator,$postprocess,$postprocessinfo) {
		if (!is_numeric($operand)) $operand = $this->evaluate_expression($operand);
		switch($operator) {
			case "and": $res = ($variable and $operand); break;
			case "xor": $res = ($variable xor $operand); break;
			case "or": $res = ($variable or $operand); break;
			case "mod": $res = $variable % $operand; break;
			case "add": $res = $variable + $operand; break;
			case "sub": $res = $variable - $operand; break;
			case "mul": $res = $variable * $operand; break;
			case "div": $res = ($operand!=0) ? $variable / $operand : '(DIV0)'; break;
			default:
				return 0;
		}
		
		switch($postprocess) {
			case "floor": return floor($res);
			case "ceil": return ceil($res);
			case "round": return round($res,(int) $postprocessinfo);
			default: return $res;
		}
	}

	function transform($method,$data) {
		if (strpos($method,"|")!==false) { 
			$transforms = explode("|",$method);
			foreach ($transforms as $k=>$method) {
				$data = $this->transform($method,$data);
			}
			return $data;
		}
		$method = explode(":",$method);
		foreach ($method as $varname=>$varvalue) {
			$method[$varname] = $this->var_or_lit($varvalue,false);		
		}
		

		$requested_transform = strtolower($method[0]);
		switch($requested_transform) {
			case "ucfirst":
				$output = ucfirst($data);
				break;
			case "strtolower":
				$output = strtolower($data);
				break;
			case "strtoupper":
				$output = strtoupper($data);
				break;
			case "ucwords":
				$output = ucwords($data);
				break;
			case "urlencode":
				if ($method[1]=='raw') {
					$output = rawurlencode($data);
				} else {
					$output = urlencode($data);
				}
				break;
			case "urldecode":
				if ($method[1]=='raw') {
					$output = rawurldecode($data);
				} else {
					$output = urldecode($data);
				}
				break;
			case "htmlentities":
				$output = $this->utf8 ? htmlentities($data,ENT_QUOTES,'UTF-8') : htmlentities($data);
				break;
			case "currency":
				if (!defined('CURRENCY_FORMAT')) define('CURRENCY_FORMAT','%.2f');
				$output = sprintf(CURRENCY_FORMAT,$data);
				break;
			case "addslashes":
				$output = addslashes($data);
				break;
			case "jsescape":
				$from = array("\\\\","\n","\r","\"","'","&","<",">");
				$to = array("\\\\\\\\","\\n","\\r","\\\"","\\'","\\x26","\\x3C","\\x3E");
				$output = str_replace($from,$to,$data);
				break;
			case "stripslashes":
				$output = stripslashes($data);
				break;
			case "striptags":
			case "strip_tags":
				$output = strip_tags($data);
				break;
			case "trim":
				$output = trim($data);
				break;
			case "count":
				$output = is_array($data) ? count($data) : 0;
				break;
			case "abs":
				$output = abs($data);
				break;
			case "min":
				$limit = (float) $method[1];
				$value = (float) $data;
				$output = min($value,$limit);
				break;
			case "max":
				$limit = (float) $method[1];
				$value = (float) $data;
				$output = max($value,$limit);
				break;
			case "round":
				$precision = (int) $method[1];
				$output = round($data,$precision);
				break;
			case "floor":
				$output = floor($data);
				break;
			case "ceil":
				$output = ceil($data);
				break;
			case "filesize":
				$precision = (int) $method[1];
				$data = (int) $data;
				if ($data>1024*1024*1024) {
					$data = round($data / 1024*1024*1024,$precision).'G';
				} elseif ($data>1024*1024) {
					$data = round($data / 1024*1024,$precision).'M';
				} elseif ($data>1024) {
					$data = round($data / 1024,$precision).'K';
				}
				return $data;
				break;
			case "substr":
				if(count($method)==2) {
					$output = substr($data,(int) $method[1]);
				} else {
					$output = substr($data,(int) $method[1],(int) $method[2]);
				}
				break;
			case "preg_replace":
				$output = preg_replace(urldecode($method[1]),$method[2],$data);
				break;
			case "str_replace":
				$keyword = trim($method[1]);
				if ( (substr($keyword,0,1)!='$') && (substr($keyword,0,1)!='"') ) $keyword = "\"$keyword\"";
				$keyword = $this->evaluate_expression($keyword);

				$replacement = trim($method[2]);
				if ( (substr($replacement,0,1)!='$') && (substr($replacement,0,1)!='"') ) $replacement = "\"$replacement\"";
				$replacement = $this->evaluate_expression($replacement);

				$replacement = preg_replace_callback("/\{(.*?)\}/", array(&$this,"preg_lookup"), $replacement);

				$output = str_replace($keyword,$replacement,$data);
				break;
			case "preg_match":
				$output = preg_match(urldecode($method[1]),$data);
				break;
			case "contains":
				$keyword = preg_replace(array('/^"/','/"$/'),"",$method[1]);
				if (is_array($data)) {
					$output = in_array($keyword,$data);
				} else {
					$output = (strpos($data,$keyword)!==false);
				}
				break;
			case "default":
				$fallback = $method[1];
				$c = substr($fallback,0,1);
				if ($c=='$' || $c=='=') $fallback = $this->lookup($fallback);

				$output = strlen($data) ? $data : $fallback;
				break;				
			case "sprintf":
				$format = preg_replace(array('/^"/','/"$/'),"",$method[1]);
				$output = sprintf($format,$data);
				break;
			case "mysqldatetime":
				$output = $this->mysql_time_transform(1,$method,$data);
				break;
			case "mysqltimestamp":
				$output = $this->mysql_time_transform(0,$method,$data);
				break;
			case "unixtimestamp":
				$output = $this->mysql_time_transform(3,$method,$data);
				break;
			case "timetext":
				$output = $this->time_text($data,$method);
				break;
			case "gettime":
				$output = $this->mysql_time_transform(2,$method,$data);
				break;
			case "yesno":
				$output = ((int) $data>0?"Yes":"No");
				break;
			case "truefalse":
				$output = ((int) $data>0?"True":"False");
				break;
			case "null":
				$output = $data;
				break;
			case "noquotes":
				$output = str_replace("\"","&quot;",$data);
				break;
			case "quoteconvert":
				$output = str_replace("\"","''",$data);
				break;
			case "nbsp":
				$output = str_replace(' ',"&nbsp;",$data);
				break;
			case "wordwrap":
				$width = $method[1]; if (strlen($width)) { $width = (int) $width; } else { $width = 75; }
				$break = $method[2]; if (!strlen($break)) $break = "\n";
				$cut = $method[3]; if (strlen($cut)) { $cut = (int) $cut; } else { $cut = true; }
				$filename_wrap = ($method[4]=='filename');
				
				if ($filename_wrap) {
					$data = str_replace(" ","\xFF",$data);
					$data = str_replace("/"," ",$data);

					$break = str_replace(" ","\xFF",$break);
					$break = '/' . $break;
				}
				$output = wordwrap($data,$width,$break,$cut);
				if ($filename_wrap) {
					$output = str_replace(" ","/",$output);
					$output = str_replace("\xFF"," ",$output);
				}
				break;	
			case "ellipsis":
				$maxlen = (int) $method[1];
				if (strlen($data)>$maxlen) $data = substr($data,0,$maxlen-3)."...";
				$output = $data;
				break;
			case "midellipsis":
				$ellipsis = ' ... ';
				$maxlen = (int) $method[1];
				$endingchars = $method[2];
				if ($endingchars=="filename") {
					$p = strrpos($data,'/');
					if ($p!==false) {
						$endingchars = strlen($data) - $p;
						$ellipsis = trim($ellipsis);
					} else {
						$endingchars = false;
					}
				} else {
					$endingchars = (int) $endingchars;
				}
				if (!$endingchars) $endingchars = 8;
				if (strlen($data)>$maxlen) {
					$ending = substr($data,-$endingchars);
					$data = substr($data,0,$maxlen-3-$endingchars). $ellipsis . $ending;
				}
				$output = $data;
				break;
			case "dateselect":
				$output = $this->date_select($method,$data);
				break;
			case "random":
				$output = rand();
				break;
			case "nl2br":
				$output = nl2br($data);
				break;
			case "base64_encode":
				$output = base64_encode($data);
				break;
			case "strpad":
				$char = $method[1];
				$len = $method[2];
				$output = $data;
				
				$padright = ($len<0);
				$len = abs($len);

				if ($len>strlen($output)) {
					if ($padright) {
						$output = $output . str_repeat($char,$len - strlen($output));
					} else {
						$output = str_repeat($char,$len - strlen($output)) . $output;
					}
				}
				break;
			case "chr":
				$output = chr($data);
				break;
			case "ord":
				$output = ord($data);
				break;
			case "or":
			case "and":
			case "xor":
			case "mod":
			case "add":
			case "sub":
			case "mul":
			case "div": 
				@list($operator,$operand,$postprocess,$postprocessinfo) = $method;
				$output = $this->arithmetic_op($data,$operand,strtolower($operator),$postprocess,$postprocessinfo); 
				break;
			case "vardump":
				ob_start();
				var_dump($this->lookup('$'.$data));
				$output = "<pre>\n".ob_get_contents()."</pre>";
				ob_end_clean();
				break;
			case "in_keys":
				$arrayname = $method[1];
				$array = $this->lookup('$'.$arrayname);
				
				return isset($array[$data]);
				break;
			case "in_array":
				$arrayname = $method[1];
				$array = $this->lookup('$'.$arrayname);
				
				return in_array($data,$array);
				break;
			case "in_set":
				return in_array($data,$method);
				break;
			case "range":
				$lo = $method[1];
				$hi = $method[2];
				$output = range($lo,$hi);
				break;
			case "implode":
				array_shift($method);
				$separator = array_shift($method);
				
				if (count($method)) {
					if (is_array($data)) {
						foreach ($data as $key=>$value) {
							reset($method);
							foreach ($method as $k=>$thismethod) {
								$data[$key] = $this->transform($thismethod,$data[$key]);
							}
						}
					}
				}
				
				$output = is_array($data) ? implode($separator,$data) : '';
				break;
			case "explode":
				array_shift($method);
				$separator = array_shift($method);
				$pieces = count($method) ? array_shift($method) : NULL;
				
				$output = explode($separator,$data,$pieces);
				break;
			default:
		  		if (!defined("DT_NO_CUSTOMTRANSFORMS")) {
					if (is_array($this->transforms)) {
						array_shift($method);
						if ($func = $this->transforms[$requested_transform]) {
							if (is_callable($func)) $output = call_user_func($func,$data,$method);
						}
					}
				}			
			
		}
		return $output;
	}
	
	function compound_evaluation($expression) {
		$expression = substr($expression,1);
		if (substr($expression,-1)==')') $expression = substr($expression,0,strlen($expression)-1);
		
		$conditions = preg_split('/\)\s*(or|and|\&\&|\|\|)\s*\(/i',$expression,-1,PREG_SPLIT_DELIM_CAPTURE);		
		
		$first = true;
		$lastresult = NULL;
		$lastoperator = '';

		while (count($conditions)) {
			$condition = trim(array_shift($conditions));

			$result = $this->evaluate_condition($condition);

			if (count($conditions)) $operator = strtolower(trim(array_shift($conditions)));

			if ($first) {
				$lastresult = $result;
				$first = false;
			} else {
				switch($lastoperator) {
					case 'or':
					case '||':
						$lastresult = $lastresult || $result;
						break;
					case 'and':
					case '&&':
						$lastresult = $lastresult && $result;
						break;
					default:
						$lastresult = false;
						break;
				}
			}
			$lastoperator = $operator;
		}
		return $lastresult;
 	}

	function preg_compare($matches) {
		return $this->compare($matches[1],$matches[2],$matches[3],$matches[4]);
	}

	function parse_tags($s) {

		
		if (!defined("DT_NO_CONDITIONALS") && (strpos($s,'{compare')!==false) ) {
		    $s = preg_replace_callback("/\{compare (\\\$[A-Za-z0-9\[\]\\\$_\.]+|\".*?\"|[0-9]+)\,(\\\$[A-Za-z0-9\[\]\\\$_\.]+|\".*?\"|[0-9]+),(\\\$[A-Za-z0-9\[\]\\\$_\.]+|\".*?\"|[0-9]+),(\\\$[A-Za-z0-9\[\]\\\$_\.]+|\".*?\"|[0-9]+)\}/i",array(&$this,"preg_compare"),$s);
		}
		
		$s = preg_replace_callback("/\{(.*?)\}/", array(&$this,"preg_lookup"), $s);
		$s = preg_replace("/\{\*(.*?)\*\}/","",$s);
		
		if (!defined("DT_NO_TRANSFORMS") && (strpos($s,'{transform')!==false) ) {
		  	$s = preg_replace("/\{transform (.*?)\}([\s\S]*?)\{\/transform\}/ie","\$this->transform('\\1','\\2')",$s);
		}
		return $s;
	}

	function evaluate_expression($expr) {
		if (preg_match("/^\"(.*?)\"$/",$expr,$matches)) {
			return $matches[1];
		
		} elseif (preg_match("/^(\\\$[A-Za-z0-9\[\]\\\$_\.]+|\".*?\"|[0-9]+)([\+|\-|\/|\*])(\\\$[A-Za-z0-9\[\]\\\$_\.]+|\".*?\"|[0-9]+)$/",$expr,$matches)) {
			return "expression";
		
		} elseif (substr($expr,0,1)=="$") {
			return $this->lookup($expr);
		
		} elseif (is_numeric($expr)) {
			return (int) $expr;
		
		} else {
			return "";
		
		}
	}

	function evaluate_condition($condition) {
		$this->debug_conditions = false;		
		if (substr($condition,0,1)=='(') return $this->compound_evaluation($condition);
		if (
			preg_match(
				"/^".
					"(\\\$[A-Za-z0-9\[\]\\\$_\.\|\:\\\"\s]+|\".*?\"|[0-9]+)". 
					"(?:".
						"([\>\<\=]{1,2}|\!\=)". 								
						"(\\\$[A-Za-z0-9\[\]\\\$_\.\|\:]+|\".*?\"|[0-9]+)". 		
					")?".
				"$/"
				,
				$condition,
				$matches
			)
		) {
			@list(,$expr1,$operator,$expr2) = $matches;

			if ($this->debug_conditions) echo "[$expr1::$operator::$expr2]\n";
			
			$expr1 = $this->evaluate_expression($expr1);
			$expr2 = $this->evaluate_expression($expr2);
			
			if ($this->debug_conditions) echo "[$expr1::$operator::$expr2]\n";
			
			$evaltrue = false;
			switch ($operator) {
				case "===":		$evaltrue = ($expr1===$expr2); break;
				case "==":
				case "=":		$evaltrue = ($expr1==$expr2); break;
				case "<":		$evaltrue = ($expr1<$expr2); break;
				case "<=":	$evaltrue = ($expr1<=$expr2); break;
				case ">":		$evaltrue = ($expr1>$expr2); break;
				case ">=":	$evaltrue = ($expr1>=$expr2); break;
				case "<>":
				case "!=":	$evaltrue = ($expr1!=$expr2); break;
				case "":	$evaltrue = $expr1; break;
				default:
					echo "[Invalid operator: $operator]";
					return false;
					// TODO: Error! invalid comparison operator
					break;
			}
	
			if ($this->debug_conditions) echo "[".($evaltrue?"true":"false")."]<br>\n";
			return $evaltrue;
		} else {
			return $this->evaluate_expression($condition);
		}
	}

	function conditional($condition,$expr,$tagelse="else",$tagelseif="elseif") {
		$expr1 = '';
		$expr2 = '';

		$iselseif = preg_match("/^([\s\S]*?)\{".$tagelseif." (.*?)\}([\s\S]*)$/",$expr,$matches);
		if ($iselseif) {
			$expr1 = &$matches[1];
			$condelseif = $matches[2];
			$expr2 = &$matches[3];
			$iselse = true;
		} else {
			$iselse = preg_match("/^([\s\S]*)\{".$tagelse."\}([\s\S]*)$/",$expr,$matches);
			if ($iselse) {
				$expr1 = &$matches[1];
				$expr2 = &$matches[2];
			}
		}
		if (!$iselse) {
			$expr2 = &$expr;
		}
		
		$evaltrue = $this->evaluate_condition($condition);

		if ($evaltrue==($iselse>0)) {
			return $this->parse_tags($expr1);
		} else {
			if ($iselseif>0) {
				return $this->conditional($condelseif,$expr2,$tagelse,$tagelseif);
			}
			return $this->parse_tags($expr2);
		}
	}

	function compare($expr1,$expr2,$data1,$data2) {
		$data1 = $this->evaluate_expression($data1);
		$data2 = $this->evaluate_expression($data2);
		return $this->conditional($expr1."==".$expr2,"$data1{else}$data2");
	}

	function evaluate_assignment($expression) {
		
		if (preg_match("/\\\$([A-Za-z0-9\[\]\\\$_\.]+)\=((\\\$[A-Za-z0-9\[\]\\\$_\.]+)|(\".*?\")|([0-9]+))/",$expression,$matches)) {
			list(,$variable,$assignment) = $matches;
			$assignment = $this->evaluate_expression($assignment);
			$this->assign($variable,$assignment);
			return array($variable,$assignment);
		} else {
			return array("[*INVALID_EXPRESSION*]","$expression");
		}
	}

	function loop($iterator,$records,$data) {
		$records = $this->lookup('$'.strtolower($records));
		if ( !is_array($records) || !count($records) ) return "";
		
		$output = "";
		$iteration = 0;
		$last_key = "";
		if (is_array($records)) {
			$iterations = count($records);
		  	foreach ($records as $k=>$v) {
				$iteration++;
				$this->assign(
					"_loop",
					array(
		  				"key"=>$k,
		  				"iteration"=>$iteration,
						"iterations"=>$iterations,
		  				"odd"=>$iteration%2,
		  				"first"=>($iteration==1),
		  				"last"=>($iteration==$iterations),
		  				"lastodd"=>($iteration%2) && ($iteration==$iterations),
		  				"prev_iteration"=>$iteration-1,
		  				"next_iteration"=>$iteration+1,
		  				"prev_key"=>$last_key
					)
				);
		  		$this->assign_by_ref(
		  			$iterator,
	  				$v
		  		);
		  		
		  		$parsediteration = $data;
			    if (!defined("DT_NO_TRANSFORMS")) {
				    $parsediteration = preg_replace_callback("/\{loopset\s+\\\$([A-Za-z0-9\[\]\\\$_\.]+)\}([\s\S]*?)\{\/loopset\}/i",array(&$this,"preg_set"),$parsediteration);
			    }
		  		
				$parsediteration = $this->parse_loops($parsediteration,true);
				$parsediteration = $this->parse_tpl($parsediteration);
				
				$output .= $parsediteration;
				
				$last_key = $k;
	    	}
		}
   		$this->unassign($iterator);
   		$this->unassign("_loop");
		return $output;
	}
	
	function custom_plugin($name,$func,$parameters,$data = false) {
		if ($data!==false) $data = stripslashes($data);
		$parameters = stripslashes($parameters);
		$parameters .= " ";
		if (!preg_match_all("/(.*?)\=(\"[^\"?]*\"|[^\s?]+)\s+/i",$parameters,$params,PREG_SET_ORDER)) {
			$params = array();
		}
		$parameter_list = array();
		
		foreach ($params as $pkey=>$param) {
			list(,$k,$v) = $param;
			$parameter_list[$k] = $this->evaluate_expression($v);
		}
		if (is_callable($func)) {
			$output = call_user_func($func,$parameter_list,$data);
		} else {
			$output = "[Error: Custom plug-in function {$func}() does not exist]";
		}
		
		return $output;
	}

	function preg_conditional_check($matches) {
		$x = $this->conditional($matches[1],$matches[2],'otherwise','otherwisecheck');
		return $x;
	}

	function preg_conditional_if($matches) {
		return $this->conditional($matches[1],$matches[2]);
	}
	
	function parse_tpl($tpl) {
  		if (!defined("DT_NO_CONDITIONALS")) {
			if (strpos($tpl,'{check')!==false) $tpl = preg_replace_callback("/\{check (.*?)\}([\s\S]*?)\{\/check\}/i", array(&$this,"preg_conditional_check"),$tpl);
	    	if (strpos($tpl,'{if')!==false) $tpl = preg_replace_callback("/\{if (.*?)\}([\s\S]*?)\{\/if\}/i", array(&$this,"preg_conditional_if"),$tpl);
    	}

		$tpl = $this->parse_tags($tpl);
		
    	
  		if (!defined("DT_NO_CUSTOMPLUGINS")) {
			if (is_array($this->plugins)) {
				foreach ($this->plugins as $name=>$func) {
					$encapsulate = (substr($name,-2)=='[]');
					if ($encapsulate) {
						$name = substr($name,0,strlen($name)-2);
						$regex = "/\{$name\s*(.*?)\}([\s\S]*?)\{\/$name\}/i";
					} else {
						$regex = "/\{$name\s*(.*?)\}/i";
					}
					if (is_callable($func)) {
						$tpl = preg_replace($regex."e", "\$this->custom_plugin('$name',\$func,'\\1'".($encapsulate?",'\\2'":"").")",$tpl);
					} else {
						$tpl = preg_replace($regex, "[Error: Custom function {$func}() does not exist]",$tpl);
					}
				}
			}
		}

		return $tpl;
	}

	function set($variable,$data) {
      	$output = $this->parse_tags($data);
	    $variable = trim($variable);
    	$this->assign($variable,$output);
	}
	
	function preg_loop($matches) {
		list(,$loopindex,$iterator,$records,$data) = $matches;
		$data = $this->parse_loops($data);

		return $this->loop($iterator,$records,$data);
	}
	
	function parse_loops($parsed,$subloops = false) {
    	$parsed = preg_replace_callback("/\{".($subloops?'sub':'')."loop([0-9]?)\s+\\\$(.*?)\s*\=\s*\\\$(.*?)\}([\s\S]*?)\{\/".($subloops?'sub':'')."loop\\1\}/i",array(&$this,"preg_loop"),$parsed);
    	
    	return $parsed;
	}
	
	function preg_include_template($matches) {
		$this->preg_includes++;
		
		$condition = $matches[2];
		if ( strlen($condition) && preg_match('/if\s*=\s*(.*?)$/i',$condition,$condmatches) ) {
			if (!$this->evaluate_condition($condmatches[1])) return "";
		}		
		return $this->include_template($matches[1]);
	}
	
	function preg_set($matches) {
		return $this->set($matches[1],$matches[2],$matches[5]);
	}
	
	function parse_includes($parsed) {
		$this->preg_includes = 0;
		while (true) {
			$parsed = preg_replace_callback("/\{include\s+(?:file\=)?\"(.*?)\"\s*(.*?)\/?\}/i",array(&$this,"preg_include_template"),$parsed);
			if (!$this->preg_includes) break;
			
			$this->preg_includes = 0;
		}
		return $parsed;
	}

	function parse() {
		$this->warnings = "";

	    $parsed = $this->template;
	    if (!defined("DT_NO_TRANSFORMS")) {
		    $parsed = preg_replace_callback("/\{set\s+\\\$([A-Za-z0-9\[\]\\\$_\.]+)\}([\s\S]*?)\{\/set\}/i",array(&$this,"preg_set"),$parsed);
	    }
		if (!defined("DT_NO_LOOPINC")) {
			$parsed = $this->parse_includes($parsed);
			$parsed = $this->parse_loops($parsed);
    	}
	    if (!defined("DT_NO_TRANSFORMS")) {
		    $parsed = preg_replace_callback("/\{postset\s+\\\$([A-Za-z0-9\[\]\\\$_\.]+)\}([\s\S]*?)\{\/postset\}/i",array(&$this,"preg_set"),$parsed);
	    }
		$this->output = $this->parse_tpl($parsed);
		
		foreach ($this->filters as $name=>$function) {
			$this->output = $function($this->output);
		}
	}

	// Parses the template if necessary, then displays the result.
	function display($template_file,$absolute_path = false) {
		if (!$this->loaded = $this->load_template($template_file,$absolute_path)) return false;
		

		$this->parse();
		echo $this->output;
		

		// if caching is enabled, then cache the document
		if ($this->cache_expire_time && $this->auto_store_cache) $this->cache($this->cache_id);
		
		if (!(defined('DISABLE_TEMPLATE_CACHING') && DISABLE_TEMPLATE_CACHING) && (defined('TEMPLATE_CACHE_DEBUG') && TEMPLATE_CACHE_DEBUG) ) {
			echo "<div align='center'>Cache miss (\"$this->cache_id\"".($this->cache_prefix?"; prefix: \"{$this->cache_prefix}\"":"").")</div>";
		}
		

		return true;
	}

	function get($template_file,$absolute_path = false) {
		if (!$this->loaded = $this->load_template($template_file,$absolute_path)) return false;
		
		$this->parse();
		return $this->output;
	}

	function get_from_var($template) {
		$this->template = $template;
		
		$this->parse();
		return $this->output;
	}

	function cache($id) {
		
		if (!is_dir(CACHE_PATH) || !is_writeable(CACHE_PATH)) {
			$this->error = "Cache path does not exist or is not writable";
			return false;
		}
		
		if ($this->nocache_perm_semaphore) {
			if (file_exists($this->nocache_perm_semaphore)) {
				$this->error = "Permanent no-cache semaphore exists; not caching page";
				return false;
			}
		}
		if ($this->nocache_temp_semaphore) {
			if (file_exists($this->nocache_temp_semaphore)) {
				if (filectime($this->nocache_temp_semaphore)+$this->nocache_temp_timeout<time()) {
					@unlink($this->nocache_temp_semaphore);
				} else {
					$this->error = "Permanent no-cache semaphore exists; not caching page";
					return false;
				}
			}
		}
		$this->nocache_perm_semaphore = $permanent;
		$this->nocache_temp_semaphore = $temporary;
		
		
		$cache_content_type = $this->cache_content_type ? '_' . str_replace('/','!',$this->cache_content_type) : '';
		$expire_time = time() + $this->cache_expire_time;
		$cachefile = CACHE_PATH."/dtcache_".$this->cache_prefix.md5($id)."{$cache_content_type}_{$expire_time}.dat";
		
		$fp = @fopen($cachefile,"w");
		if ($fp) {
			fwrite($fp,$this->output);
			fclose($fp);
			return true;
		} else {
			$this->error = "Unable to create cache file: [$cachefile]";
			return false;
		}
	}
	function load_cache($id) {
		$cachename = "dtcache_".$this->cache_prefix.md5($id)."_"; 
		$cachename_len = strlen($cachename);
		$cachefile = "";
		if (!is_dir(CACHE_PATH) || !is_readable(CACHE_PATH)) return false;
		$this->expired_cachefiles = array();
		$d = dir(CACHE_PATH); 
		while (false !== ($entry = $d->read())) { 
			if (substr($entry,0,$cachename_len)==$cachename) {
				$page_cache_data = substr($entry,$cachename_len,strlen($entry) - $cachename_len - 4);
				if (($p = strpos($page_cache_data,'_'))!==false) {
					$cache_content_type = str_replace('!','/',substr($page_cache_data,0,$p));
					$expire_time = (int) substr($page_cache_data,$p+1);
				} else {
					$expire_time = (int) $page_cache_data;
				}
				
				if ($expire_time > time()) {
					$cachefile = CACHE_PATH.$entry;
					$this->cache_content_type = $cache_content_type;
					break;
				} else {
					$this->expired_cachefiles[ CACHE_PATH.$entry ] = $cache_content_type;
				}
			}
		} 
		$d->close();

		if ($cachefile) {
			$this->clear_expired_cache();
			return $this->load_contents($cachefile);
		} else {
			if (!$this->retain_expired_cachefiles) $this->clear_expired_cache();
		}
		return false;
	}
	
	function load_expired_cache($recache_time = false) {
		if (!$this->expired_cachefiles) return false;
		
		$keys = array_keys($this->expired_cachefiles);
		sort($keys);
		$lastkey = array_pop($keys);
		
		$lasttype = $this->expired_cachefiles[ $lastkey ];
		
		$cachefile = $lastkey;
		
		$ok = $this->load_contents($cachefile);
		if ($ok && $recache_time) {
			$this->cache_content_type = $lasttype;
			$this->set_cache_lifetime($recache_time);
			$this->cache($this->cache_id);
		}
		return $ok;
	}
	function clear_expired_cache() {
		if (is_array($this->expired_cachefiles)) {
			foreach ($this->expired_cachefiles as $expired_cachefile=>$content_type) {
				@unlink($expired_cachefile);
			}		
		}
	}
	function clear_cache($prefix="") {
		$cachename = "dtcache_".$prefix;
		$cachename_len = strlen($cachename);
		$d = dir(CACHE_PATH); 
		
		while (false !== ($entry = $d->read())) { 
			if (substr($entry,0,$cachename_len)==$cachename) {
				@unlink(CACHE_PATH.$entry);
			}
		} 
		$d->close(); 		
	}
	function load_contents($filename) {
		$this->output = "";
		
		if ($this->debug_load) echo "Template::load_contents({$filename})\n";
		$fp = fopen($filename,"r");
		if ($fp) {
			while (!feof($fp)) {
				$this->output .= fread($fp,4096);
			}
			fclose($fp);
			
			return true;
		} else {
			$this->error = "Input file $filename not found";
			return false;
		}
	}
	function prepare_multipage(&$default_pagelimit,$itemcount,$baseurl,$sef = false,$show_showall = false) {
		$startindex = isset($_REQUEST["pstart"]) ? (int) $_REQUEST["pstart"] : 0;
		if ($startindex<0) $startindex = 0;
		$pagelimit = isset($_REQUEST["plimit"]) ? $_REQUEST["plimit"] : $default_pagelimit;
		if (!$pagelimit && !$show_showall) $pagelimit = $default_pagelimit;
		if (!$pagelimit && !$show_showall) $pagelimit = 5;		
		$this->multipage["itemcount"] = $itemcount;
		$this->multipage["pagelimit"] = $pagelimit;
		if ($pagelimit==0) {
			$this->multipage["currentpage"] = 1;
			$this->multipage["totalpages"] = 1;
		} else {		
			$this->multipage["currentpage"] = $currentpage = ceil($startindex / $pagelimit) + 1;
			$this->multipage["totalpages"] = $totalpages = ceil($itemcount / $pagelimit);
		}

		if ($startindex>$itemcount) $startindex = $itemcount - $pagelimit;
		$this->multipage["startindex"] = $startindex = $startindex<0?0:$startindex;
		
		$eq = $sef ? '/' : '=';
		$amp = $sef ? '/' : '&amp;';
		
		$nav = "";
		$previdx = -1;
		$nextidx = -1;

		$individuallimit = 10;
		
		$overtenstep = 5;
		if ($totalpages>20) {
			$overtenstep = max(1,floor($totalpages/5));
			$individuallimit = 6;
		}
		if ($overtenstep+$individuallimit>$totalpages) $overtenstep = max(1,$totalpages - $individuallimit);

		
		$individualstart = floor($currentpage / $overtenstep) * $overtenstep - $overtenstep;
		$individualstart = $currentpage - floor($individuallimit/2);
		if ($individualstart<0) $individualstart = 0;
		
		$individualend = $individualstart + $individuallimit;
		if ($individualend>$totalpages) {
			$individualend = $totalpages;
			if ($individualend - $individuallimit >= 0) $individualstart = $individualend - $individuallimit;
		}		
		if ($sef) {
			if (substr($baseurl,-1)!="/") $baseurl .= "/";
		} else {
			$baseurl .= (strpos($baseurl,"?")!==false) ? "&amp;" : "?";
		}

		$baseurl = preg_replace('/&p(start|limit)=[0-9]+/i','',$baseurl);
		$baseurl = preg_replace('/\?p(start|limit)=[0-9]+/i','?',$baseurl);
		
		$pagenumber = 1;
		while(true) {
			$pagestart = ($pagenumber - 1) * $pagelimit;
			
			if ($pagenumber==$currentpage) {
				$nav .= $pagenumber;
			} else {
				$nav .= "<a href=\"{$baseurl}pstart{$eq}{$pagestart}{$amp}plimit{$eq}{$pagelimit}\">".($pagenumber)."</a>";
			}
			$nav .= " | ";
	
			$lastpagenumber = $pagenumber;
			
			if ($totalpages>10) {
				if ($pagenumber<$individualstart) {
					$pagenumber += $overtenstep;
					if ($pagenumber>$individualstart) $pagenumber = $individualstart;
				}
				elseif ($pagenumber>=$individualend) $pagenumber += $overtenstep;
				else $pagenumber++;
			} else {
				$pagenumber++;
			}

			if ($pagenumber>$totalpages) {
				if ($lastpagenumber!=$totalpages) {
					$pagenumber = $totalpages;
				} else {
					break;
				}
			}
			if ($itemcount==0) break;
		}
		
 		$nav = substr($nav,0,strlen($nav)-3);
		
		if ( ($pagelimit>0) && ($startindex!=0) ) {
			$previdx = $startindex - $pagelimit;
			if ($previdx<0) $previdx = 0;
						
			$nav = "<a href=\"{$baseurl}pstart{$eq}{$previdx}{$amp}plimit{$eq}{$pagelimit}\">{$this->page_prev}</a> | ".$nav;
		}
		if ( ($pagelimit>0) && ($startindex+$pagelimit<$itemcount) ) {
			$nextidx = $currentpage * $pagelimit;
			
			$nav .= " | <a href=\"{$baseurl}pstart{$eq}{$nextidx}{$amp}plimit{$eq}{$pagelimit}\">{$this->page_next}</a>";
		}
		
		if ($show_showall) {
			if ($pagelimit>0) {
				$nav .= " | <a href=\"{$baseurl}pstart{$eq}0{$amp}plimit{$eq}0\">{$this->page_show_all}</a>";
			} else {
				$nav .= " | <a href=\"{$baseurl}pstart{$eq}0{$amp}plimit{$eq}{$default_pagelimit}\">{$this->page_show_pages}</a>";
			}
		}

		$this->multipage["nav"] = $nav;
		
		$this->assign_by_ref("_multipage",$this->multipage);
		return $startindex;
	}
	
	function load_plugin($name) {
		$filename = dirname(__FILE__)."/plugin_{$name}.php";
		if (is_readable($filename) && include($filename)) {
			$registerfunc = "dt_register_{$name}";
			if (function_exists($registerfunc)) {
				return $registerfunc($this);
			}
		}
		
		return false;
	}
	
	function set_fallback($dirs = false) {
		if ($dirs && !is_array($dirs)) $dirs = array($dirs);
		$this->template_fallback_dirs = $dirs;
	}
	
	function add_fallback($dirs = false) {
		if ($dirs && !is_array($dirs)) $dirs = array($dirs);
		if (!is_array($dirs)) $dirs = array();
		if (!is_array($this->template_fallback_dirs)) $this->template_fallback_dirs = array();
		$this->template_fallback_dirs = array_merge($this->template_fallback_dirs,$dirs);
	}
	
	function set_override($dirs = false) {
		if ($dirs && !is_array($dirs)) $dirs = array($dirs);
		$this->template_override_dirs = $dirs;
	}
	
	function add_override($dirs = false) {
		if ($dirs && !is_array($dirs)) $dirs = array($dirs);
		if (!is_array($dirs)) $dirs = array();
		if (!is_array($this->template_override_dirs)) $this->template_override_dirs = array();
		$this->template_override_dirs = array_merge($this->template_override_dirs,$dirs);
	}
	
	function set_relative_override($dirs = false) {
		if ($dirs && !is_array($dirs)) $dirs = array($dirs);
		if (!is_array($dirs)) $dirs = array();
		$this->template_override_subdirs = $dirs;
	}
	
	function add_relative_override($dirs = false) {
		if ($dirs && !is_array($dirs)) $dirs = array($dirs);
		if (!is_array($dirs)) $dirs = array();
		if (!is_array($this->template_override_subdirs)) $this->template_override_subdirs = array();
		$this->template_override_subdirs = array_merge($this->template_override_subdirs,$dirs);
	}	

	function push_template_dir($dir,$fallback_dirs=false) {
		array_push($this->stored_template_dirs,$this->template_dir);
		array_push($this->stored_template_fallback_dirs,$this->template_fallback_dirs);
		
		$this->template_dir = $dir;
		if ($fallback_dirs && !is_array($fallback_dirs)) $fallback_dirs = array($fallback_dirs);
		if (!is_array($fallback_dirs)) $fallback_dirs = array();
		$this->template_fallback_dirs = $fallback_dirs;
	}
	
	function pop_template_dir() {
		$this->template_dir = array_pop($this->stored_template_dirs);
		$this->template_fallback_dirs = array_pop($this->stored_template_fallback_dirs);
	}
	
	function save_template_dir() {
		return serialize(array($this->template_dir,$this->template_fallback_dirs,$this->stored_template_dirs,$this->stored_template_fallback_dirs));
	}
	
	function restore_template_dir($saved) {
		$res = @unserialize($saved);
		if ( (!$res) || (!is_array($res)) || (count($res)!=4) ) return false;
		list($this->template_dir,$this->template_fallback_dirs,$this->stored_template_dirs,$this->stored_template_fallback_dirs) = $res;
	}
	
	function &singleton($use_caching=false,$cache_id=NULL,$cache_auto_display=true,$cache_allow_override=true,$cache_prefix="",$retain_expired_cachefiles=false) {
		if (!isset($GLOBALS['singletons']['directemplate'])) {
			$GLOBALS['singletons']['directemplate'] = new Kipo_Sabloane($use_caching,$cache_id,$cache_auto_display,$cache_allow_override,$cache_prefix,$retain_expired_cachefiles);
		}
		
		return $GLOBALS['singletons']['directemplate'];
	}
}

function display_template($filename,$cache_expire_time=NULL,$cache_id=NULL,$cache_allow_override=true) {
	$tpl = new Kipo_Sabloane($cache_expire_time>0,$cache_id,true,$cache_allow_override);

	$tpl->set_cache_lifetime($cache_expire_time);
	if (!$tpl->display($filename)) {
		echo "Error: $tpl->error\n";
	}
	unset($tpl);
}
function get_template($filename,$cache_expire_time=NULL,$cache_id=NULL,$cache_allow_override=true) {
	$tpl = new Kipo_Sabloane($cache_expire_time>0,$cache_id,true,$cache_allow_override);

	$tpl->set_cache_lifetime($cache_expire_time);
	$res = $tpl->get($filename);
	if ($res===false) {
		echo "Error: $tpl->error\n";
	}
	unset($tpl);
	
	return $res;
}

?>
