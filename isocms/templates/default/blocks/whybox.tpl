{if $lstWhy[0].why_id ne ''}
<div class="widget widget-book-us">
    <h4 class="widget-tit">{$core->get_Lang('Why book with us')}? <i class="fa fa-chevron-down hidden-lg hidden-md"></i></h4>
    <div class="w-body">
        <p>{$core->get_Lang('There are at least 6 reasons why you should book Halong Bay cruise and tour on our website')}.</p>
        <p><a href="{$PCMS_URL}/why-book-with-us.html" class="btn btn-style-1 btn-block text-bold">{$core->get_Lang('Learn More')}</a></p>
        <ul class="list-check">
        	{section name=i loop=$lstWhy}
            <li>
            <strong>{$clsWhy->getTitle($lstWhy[i].why_id)}</strong>
            {$clsWhy->getIntro($lstWhy[i].why_id)|truncate:60}
            </li>
            {/section}
        </ul>
        <a href="{$PCMS_URL}/why-book-with-us.html" target="_blank" class="more">{$core->get_Lang('View more')}</a>
    </div>
</div>
{/if}