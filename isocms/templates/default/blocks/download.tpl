{if $mod eq 'home'}
<section class="homeDownload text-center mobile" style="display:none">
    <div class="container">
        <h3>{$core->get_Lang('Download Photo & Beyond Ebook')}</h3>
    <a class="linkDownload" href="{$extLang}/brochure.html" title="{$core->get_Lang('Download')}">{$core->get_Lang('Download')}</a>
    </div>
</section>
<section class="homeDownload text-center  desktop">
    <div class="container">
        <div class="intro14_f">
        Are you ready to travel with us? Let's find the destination you want to visit and discover, we are always willing to help you enjoy the most wonderful time as well as get unforgettable experience.</div>
        <h3>{$core->get_Lang('Download Photo & Beyond Ebook')}</h3>
    <a class="linkDownload" href="{$extLang}/brochure.html" title="{$core->get_Lang('Download')}">{$core->get_Lang('Download')}</a>
    </div>
</section>
{elseif $mod ne 'home'}
 <section class="brochure mb40">
    <h3 class="h3_16_Bold_007f75 mb20">{$core->get_Lang('Order or download our brochure')}</h3>
    <p class="intro14_3 mb20">Find inspiration for your Vietnam holiday plans by exploring our latest brochure.</p>
    <a class="photo" href="{$extLang}/brochure.html" title="{$core->get_Lang('Order or download our brochure')}"><img src="{$URL_IMAGES}/brochure.jpg" width="251" height="273" alt="{$core->get_Lang('Order or download our brochure')}" /></a>
    
    <a class="linkDownLoad" href="{$extLang}/brochure.html" title="{$core->get_Lang('Download a copy')}">{$core->get_Lang('Download a copy')}</a>
    <a class="linkPrint" href="" title="">{$core->get_Lang('Order a printed version')}</a>
</section>
{/if}