<div id="information" style="margin-top:0">
    <ul class="clienttabs">
        {section name=i loop=$lstPage}
        {assign var = title value = $clsPage->getTitle($lstPage[i].page_id)}
        <li><a  class="{if $page_id eq $lstPage[i].page_id}current{/if}" href="{$clsPage->getLink($lstPage[i].page_id)}" title="{$title}">{$title}</a></li>
        {/section}
        <li ><a class="{if $mod eq 'about' && $act eq 'FAQ'}current{/if}" href="{$extLang}/faqs.html" title="{$core->get_Lang('FAQs')}"> {$core->get_Lang('FAQs')}</a></li>
        <li><a class="{if $mod eq 'about' && $act eq 'sitemap'}current{/if}" href="{$extLang}/sitemap.html" title="{$core->get_Lang('Sitemap')}">{$core->get_Lang('Sitemap')}</a></li>
    </ul>
</div>