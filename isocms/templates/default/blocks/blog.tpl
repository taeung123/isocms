{if $lstBlogHome[0].blog_id}
<section class="blog-home {if $mod eq 'home'} bgf3f3f3 {/if}">
	<div class="container">
    	<div class="row"> 
        	<div class="blog-title">
                <h3><a href="{$clsISO->getLink('blog')}" title="Blogs">{$core->get_Lang('Travel Blog')}</a></h3>
            </div>     
            {section name=i loop=$lstBlogHome}
            {assign var=title value=$clsBlog->getTitle($lstBlogHome[i].blog_id)}
            {assign var=link value=$clsBlog->getLink($lstBlogHome[i].blog_id)}
            {assign var=cat value=$clsBlogCategory->getTitle($lstBlogHome[i].cat_id)}
            <article class="blog-index"> 
               <a class="col-xs-12 col-sm-6 col-md-6 col-lg-6" href="{$link}" title="{$title}">
                    <img src="{$clsBlog->getImage($lstBlogHome[i].blog_id,530,350)}" width="100%" alt="{$title}"  />
               </a>
               <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
               		<div class="cap1"><a href="{$link}" title="{$title}">{$title}</a></div>
                    <div class="cap2">{$clsISO->converTimeToText($lstBlogHome[i].reg_date)} | {$core->get_Lang('Blog category')} : <a href="{$clsBlogCategory->getLink($lstBlogHome[i].cat_id)}" title="{$cat}">{$cat}</a></div>
                    <div class="cap3">{$clsBlog->getIntro($lstBlogHome[i].blog_id)|strip_tags|truncate:240}</div>
                    <div class="cap4"><a href="{$link}" title="{$core->get_Lang('View detail')}">{$core->get_Lang('View detail')}</a></div>
                    <div class="cap5">{$core->get_Lang('Relate Blogs')}</div>
                    <ul class="cap6">
                    {section name=i loop=$lstRelated}
                    <li class="cap7">
                        <a href="{$clsBlog->getLink($lstRelated[i].blog_id)}">{$clsBlog->getTitle($lstRelated[i].blog_id)}</a>                   	</li>
                    {/section}
                    </ul>
                </div>                
            </article>
            {/section}
        </div>
    </div>
</section>
{/if}