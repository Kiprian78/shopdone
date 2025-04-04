
<div class="w-shop-top-right d-sm-flex align-items-center justify-content-xl-end">
<div class="w-shop-top-select">
   <select id="sortBy" onchange="javascript:window.location=$('#sortBy').val();">
   {loop $item=$sortBy}
      <option value="{$item.link_url}" {$item.selected}>{$item.label}</option>
   {/loop}   
   </select>
</div>
</div>