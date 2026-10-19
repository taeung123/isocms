<section class="rowbox primary mt30 mb40">
	<div class="container">
    	<div class="box_our_blog">
            <div class="{if $mod eq 'home'}col-sm-7{else}col-sm-9{/if} mbl">
                <div class="blog_regdate">{$clsBlog->getRegDate($blog_id)}</div>
                <div class="blog_title"><a href="{$clsBlog->getLink($blog_id)}" title="{$clsBlog->getTitle($blog_id)}">{$clsBlog->getTitle($blog_id)}</a></div>
                <div class="blog_intro">{$clsBlog->getStripIntro($blog_id)|truncate:450}</div>
                <div class="update_from">{$core->get_Lang('Update from the')} <u>{$PAGE_NAME} {$core->get_Lang('blog')}</u></div>
                <div class="sharebox hide_s"> 
                    <!-- Go to www.addthis.com/dashboard to customize your tools --> 
                    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=thiembv"></script> 
                    <!-- Go to www.addthis.com/dashboard to customize your tools --> 
                    <div class="addthis_sharing_toolbox fr" style="height:16px" data-url="{$PCMS_URL}{$clsBlog->getLink($blog_id)}" data-title="{$clsBlog->getTitle($blog_id)}"></div>
                </div>
            </div>
            <div class="{if $mod eq 'home'}col-sm-5 phn{else}col-sm-3{/if}">
                <a href="{$clsBlog->getLink($blog_id)}" title="{$clsBlog->getTitle($blog_id)}"><img class="img-responsive" src="{$clsBlog->getImage($blog_id,600,350)}" alt="{$clsBlog->getTitle($blog_id)}" width="100%"  /></a>
            </div>
        </div>
    </div>
</section>
{if $mod ne 'home'}
{literal}
<style type="text/css">
.box_our_blog{padding:15px 0 0;background:#f9f9f9;display:inline-block}
</style>
{/literal}
{/if}