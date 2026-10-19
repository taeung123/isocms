<div class="panel-panel-inner aboutRight">
    <div class="panel-pane pane-views-panes clearfix no-title">
        <div class="pane-content">
            <p class="h3">{$core->get_Lang('Information')}</p>
            <ul class="d2-page">
            	{section name=i loop=$lstPage}
                {assign var = title value = $lstPage[i].title}
                <li  class="page-link {if $page_id eq $lstPage[i].page_id} current{/if}"><a href="{$clsPage->getLink($lstPage[i].page_id,$lstPage[i])}" title="{$title}">{$title}</a></li>
                {/section}
            </ul>
        </div>
    </div>
</div>

