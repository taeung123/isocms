
{if $lstCategory[0].newscat_id  != '' }
<div class="blogCat">
    <div class="heading_box"><h2>{$core->get_Lang('Browse By')}</h2></div>
    <ul>
		{section name=i loop=$lstCategory}
        <li><a href="{$clsNewsCategory->getLink($lstCategory[i].newscat_id)}" title="{$clsNewsCategory->getTitle($lstCategory[i].newscat_id)}">{$clsNewsCategory->getTitle($lstCategory[i].newscat_id)}</a></li>
      {/section}
    </ul>
</div>
{/if}