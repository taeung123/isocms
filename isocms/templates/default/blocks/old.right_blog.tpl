<div class="blogCat">
    <div class="heading_box"><h2>{$core->get_Lang('Categories')}</h2></div>
    <ul>
		{section name=i loop=$lstCategory}
        <li><a href="{$clsBlogCategory->getLink($lstCategory[i].blogcat_id)}" title="{$clsBlogCategory->getTitle($lstCategory[i].blogcat_id)}">{$clsBlogCategory->getTitle($lstCategory[i].blogcat_id)}</a></li>
      {/section}
    </ul>
</div>
<div class="blogCat">
    <div class="heading_box"><h2>{$core->get_Lang('Recent articles')}</h2></div>
    <ul>
    	{section name=i loop=$lstLatestBlog}
        <li><a href="{$clsBlog->getLink($lstLatestBlog[i].blog_id)}" title="{$clsBlog->getTitle($lstLatestBlog[i].blog_id)}">{$clsBlog->getTitle($lstLatestBlog[i].blog_id)}</a></li>
        {/section}
    </ul>
</div>
{if $lstTag}
<div class="blogCat">
    <div class="heading_box"><h2>{$core->get_Lang('Tags')}</h2></div>
    {section name=i loop=$lstTag}
    <a href="{$clsTag->getLinkBlog($lstTag[i].tag_id)}" title="{$clsTag->getTitle($lstTag[i].tag_id)}" class="{$lstTag[i].class}">{$clsTag->getTitle($lstTag[i].tag_id)} ({$lstTag[i].number}) {if !$smarty.section.i.last},{/if} </a>
    {/section}
</div>
{/if}