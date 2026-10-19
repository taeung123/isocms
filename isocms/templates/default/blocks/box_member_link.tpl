<aside class="col-lg-3 col-xs-12 tabControl">
	<ul  class="clienttabs">
		<li>
			<a {if $act eq 'my_profile'} class="current"{/if} href="{$clsProfile->getLink('my_profile')}" title="{$core->get_Lang('My Profile')}">{$core->get_Lang('My Profile')}</a>
		</li>
		<li>
			<a {if $act eq 'my_booking'} class="current"{/if} href="{$clsProfile->getLink('my_booking')}" title="{$core->get_Lang('My Booking')}">{$core->get_Lang('My Booking')}</a>
		</li>
		 <li>
			<a {if $act eq 'my_review'} class="current"{/if} href="{$clsProfile->getLink('my_review')}" title="{$core->get_Lang('My Tour Reviews')}">{$core->get_Lang('My Tour Reviews')}</a>
		 </li>
		 <li>
			<a {if $act eq 'my_offer'} class="current"{/if} href="{$clsProfile->getLink('my_offer')}" title="{$core->get_Lang('My Offers &amp; Discounts')}">{$core->get_Lang('My Offers &amp; Discounts')}</a>
		 </li>
		<li><a href="{$clsProfile->getLink('logout')}" title="{$core->get_Lang('Logout')}">{$core->get_Lang('Logout')}</a></li>
	</ul>
</aside>