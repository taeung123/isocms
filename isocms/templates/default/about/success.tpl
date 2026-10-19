<div class="page_container">
{if $show ne 'bookTour'}
	<nav class="breadcrumb-main breadcrumb-more bg_fff pt-5">
		<div class="container">
			<ol class="breadcrumb hidden-xs bg_fff mt0" itemscope itemtype="http://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemtype="http://schema.org/Thing" itemprop="item" href="{$PCMS_URL}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="hidden-xs"> 
					<a itemtype="http://schema.org/Thing" itemprop="item" {if $show eq 'Feedback'}href="{$clsISO->getLink('contact')}"{/if}  title="{if $show eq 'registerAgent'}{$core->get_Lang('Register')} {$core->get_Lang('Travel Agent')}{/if}{if $show eq 'registerCTV'}{$core->get_Lang('Register')} {$core->get_Lang('Cộng tác viên')}{/if}{if $show eq 'ResetPassSuccess'}{$core->get_Lang('Password reset')}{/if}{if $show eq 'Feedback'}{$core->get_Lang('Contact Us')}{/if}{if $show eq 'bookTour' || $show eq 'bookHotel' || $show eq 'bookTailor' || $show eq 'bookCruise'}{$core->get_Lang('Booking')}{/if}"> 
						<span itemprop="name" class="reb">{if $show eq 'Feedback'}{$core->get_Lang('Contact Us')}{/if}
				{if $show eq 'registerAgent'}{$core->get_Lang('Register')} {$core->get_Lang('Travel Agent')}{/if}
				{if $show eq 'registerCTV'}{$core->get_Lang('Register')} {$core->get_Lang('Cộng tác viên')}{/if}
				{if $show eq 'ResetPassSuccess'}{$core->get_Lang('Password reset')}{/if}
				{if $show eq 'bookTour' || $show eq 'bookHotel' || $show eq 'bookTailor' || $show eq 'bookCruise' || $show eq 'Bookingservices'}{$core->get_Lang('Booking')}{/if}</span> </a> 
					<meta itemprop="position" content="2" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active"> 
					<a itemtype="http://schema.org/Thing" itemprop="item" title="{$core->get_Lang('Success')}"> 
						<span itemprop="name" class="reb">{$core->get_Lang('Success')}</span> </a> 
					<meta itemprop="position" content="3" />
				</li>
			</ol>
		</div>
	</nav>
{/if}
	<section id="contentPage" class="successPage pd20_0">
		<div class="container">
			<section class="bore-right bg_fff">
				{*<h1 class="title"> 
				{if $show eq 'Feedback'}{$core->get_Lang('Contact Us')}{/if}
				{if $show eq 'bookTour' || $show eq 'bookHotel' || $show eq 'bookTailor' || $show eq 'bookCruise'}{$core->get_Lang('Booking')}{/if}
				{if $show eq 'registerAgent'}{$core->get_Lang('Register')} {$core->get_Lang('Travel Agent')}{/if}
				{if $show eq 'registerCTV'}{$core->get_Lang('Register')} {$core->get_Lang('Cộng tác viên')}{/if}
				{if $show eq 'ResetPassSuccess'}{$core->get_Lang('Password reset')}{/if}
				{$core->get_Lang('Success')}
				 </h1>*}
				<div class="formatTextStandard"> 
					
					{assign var=SiteMsg_ResetPassSuccess value=SiteMsg_ResetPassSuccess_|cat:$_LANG_ID}
					{if $show eq 'bookTour'}
						{$SiteMsgTourSuccess|html_entity_decode}
					{/if}
					{if $show eq 'Feedback'}
						{$messageFeedbackSuccess|html_entity_decode}
					{/if}
					{if $show eq 'bookCruise'}
						{$SiteMsgCruiseSuccess|html_entity_decode}
					{/if}
					{if $show eq 'bookHotel'}
						{$SiteMsgHotelSuccess|html_entity_decode}
					{/if}
					{if $show eq 'bookTailor'}
						{$SiteMsgTailorSuccess|html_entity_decode}
					{/if}
					{if $show eq 'Bookingservices'}
						{$SiteMsgServiceSuccess|html_entity_decode}
					{/if}
					{if $show eq 'registerAgent'}
						{$SiteMsgAgentSuccess|html_entity_decode}
					{/if}
					{if $show eq 'ResetPassSuccess'}{$clsConfiguration->getValueAutoInfo($SiteMsg_ResetPassSuccess)|html_entity_decode}{/if}
				</div>
			</section>
		</div>
	</section>
</div>