<div id="loader"></div>
<div class="ListGuide">
   {if $lstGuide}
   <div class="tringle"></div>
   <div class="row">
      {section name=i loop=$lstGuide}
      {assign var=linkGuide value=$clsGuide->getLink($lstGuide[i].guide_id)}
      {assign var=titleGuide value=$clsGuide->getTitle($lstGuide[i].guide_id)}
      <div class="col-md-3 col-sm-6">
         <div class="ItemGuide">
            <a class="photo" href="{$linkGuide}" title="{$titleGuide}">
            <img class="img100" src="{$clsGuide->getImage($lstGuide[i].guide_id,295,180)}" alt="{$titleGuide}" >
            </a>
            <div class="body">
               <h3 class="title">
                  <a href="{$linkGuide}" title="{$titleGuide}">{$clsGuide->getTitle($lstGuide[i].guide_id)}</a>
               </h3>
               <span class="regdate">{$clsGuide->getRegDate($lstGuide[i].guide_id)}</span>
               <div class="intro">{$clsGuide->getIntro($lstGuide[i].guide_id)|strip_tags}</div>
            </div>
         </div>
      </div>
      {/section}
   </div>
   {if $totalRecord gt '4'}
   <a class="seemore seeclick text_center ViewmoreGuide" href="javascript:void(0);" title="{$core->get_Lang('Xem thêm')}">{$core->get_Lang('Xem thêm')}</a>
   <a class="seeless seeclick text_center ViewmoreGuide" href="javascript:void(0);" title="{$core->get_Lang('Ẩn bớt')}" style="display: none">{$core->get_Lang('Ẩn bớt')}</a>
   {/if}
   {/if}
</div>

{literal}
<script>
   $('.seemore').on('click',function () {
   	$(this).closest('.ListGuide').find('.row').css('height','100%');
   	$(this).closest('.ListGuide').find('.seeless').show();
   	$(this).hide();
   });
   $('.seeless').on('click',function () {
   	$(this).closest('.ListGuide').find('.row').removeAttr('style');
   	$(this).closest('.ListGuide').find('.seemore').show();
   	$(this).hide();
   });
</script>
{/literal}