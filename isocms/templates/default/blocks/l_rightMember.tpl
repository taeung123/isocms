<article class="main-shader pas mbmm">
    <h3 class="h5 mbs">{$PAGE_NAME} {$core->get_Lang('Customer Support')}</h3>
	{assign var=site_member_intro value=site_member_intro_|cat:$_LANG_ID}
	{assign var=site_member_intro2 value=site_member_intro2_|cat:$_LANG_ID}
    <div class="xsmall mtn">{$clsConfiguration->getValue($site_member_intro)|html_entity_decode}</div>
    <p class="txtR"><a href="{$extLang}/account/my-booking.html" class="xsmall" title="{$core->get_Lang('Go to My Bookings')}">{$core->get_Lang('Go to My Bookings')}<i class="via-caret-right"></i></a></p>
</article>
<article class="main-shader pas mbmm">
    <h3 class="h5 mbs">{$core->get_Lang('Passwords &amp; Profile Questions')}</h3>
    <div class="xsmall mtn">{$clsConfiguration->getValue($site_member_intro2)|html_entity_decode}</div>
    <p class="txtR"><a href="#" class="xsmall" title="{$core->get_Lang('Password or Profile Question')}">{$core->get_Lang('Password or Profile Question')}<i class="via-caret-right"></i></a></p>
</article>