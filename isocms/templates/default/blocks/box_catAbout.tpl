{if $lstAboutCategory}
<section class="menuCat">
    <ul>
    	{section name=i loop=$lstAboutCategory}
        <li><a href="{$clsBlogCategory->getLink($lstAboutCategory[i].blog_category_id)}" title="{$clsBlogCategory->getTitle($lstAboutCategory[i].blog_category_id)}">{$clsBlogCategory->getTitle($lstAboutCategory[i].blog_category_id)}</a></li>
        {/section}
    </ul>
</section>
{/if}