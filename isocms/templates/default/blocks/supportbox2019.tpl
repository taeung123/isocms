<section class="box_home_2019 boxContactUs">
	<div class="container">
		<div class="title text_center mb30">
			<h2 class="h2_title mb10">{$core->get_Lang('title_support_box')}</h2>
			{assign var = SiteIntroContactUsBox value = SiteIntroContactUsBox_|cat:$_LANG_ID}
			<div class="color_666">{$clsConfiguration->getValue($SiteIntroContactUsBox)|html_entity_decode}</div>
		</div>
		<div class="contact_box">
			<div class="col_box">
				<i class="icon icon_phone_larger"></i>
				<p class="size32 mb0 text_larger">{$core->get_Lang('Call us')}</p>
				<p><a href="tel:{$clsConfiguration->getValue('CompanyPhone')}" title="{$clsConfiguration->getValue('CompanyPhone')}">{$clsConfiguration->getValue('CompanyPhone')}</a></p>
			</div>
			<div class="col_box">
				<i class="icon icon_email_larger"></i>
				<p class="size32 mb0 text_larger">{$core->get_Lang('Email us')}</p>
				<p><a href="mailto:{$clsConfiguration->getValue('CompanyEmail')}" title="{$clsConfiguration->getValue('CompanyEmail')}">{$clsConfiguration->getValue('CompanyEmail')}</a></p>
			</div>
		</div>
	</div>
</section>