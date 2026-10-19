{assign var=title_service value=$clsService->getTitle($service_id)}
<div class="page_container">
	<div class="breadcrumb-main bg_fff">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="https://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$clsISO->getLink('service')}" title="{$core->get_Lang('Travel services')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Travel services')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
				{if $clsISO->getCheckActiveModulePackage($package_id,'service','category','default')}
					{if $clsServiceCategory->getTitle($servicecat_id)}
						<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
							<a itemprop="item" href="{$clsServiceCategory->getLink($servicecat_id)}" title="{$clsServiceCategory->getTitle($servicecat_id)}">
								<span itemprop="name" class="reb">{$clsServiceCategory->getTitle($servicecat_id)}</span></a>
							<meta itemprop="position" content="3" />
						</li>
					{/if}
				 <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$curl}" title="{$title_service}">
						<span itemprop="name" class="reb">{$title_service}</span></a>
					<meta itemprop="position" content="4" />
				</li>
				{else}
				 <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$curl}" title="{$title_service}">
						<span itemprop="name" class="reb">{$title_service}</span></a>
					<meta itemprop="position" content="3" />
				</li>
				{/if}
			</ol>
        </div>
    </div>
    <div id="contentPage" class="servicePage pageServiceDefault bg_f1f1f1">
		<div class="container">
			<h1 class="title32 color_333 mb20">{$title_service}</h1>
			<div class="row">
				<div class="col-lg-9 serviceLeft mb768_30">
					<div class="serviceContent">
						{*<div class="submitted"> 
						<i class="fa fa-clock-o" aria-hidden="true"></i> {$clsISO->converTimeToText($clsService->getOneField('reg_date',$service_id))} 
						<div class="sharethis-inline-share-buttons" data-image="{$DOMAIN_NAME}{$clsISO->getPageImageShare($service_id,'Service')}" data-url="{$DOMAIN_NAME}{$curl}" data-title="{$title_service}"></div>
						</div>*}
						<div class="content">
							<div class="field-items maxWidthImage tinymce_Content">
								{$clsService->getIntro($service_id)|html_entity_decode}
								<div class="clearfix"></div>
								{$clsService->getContent($service_id)}
							</div>
						</div>
						{*<div class="cleafix"></div>
						<div class="sharethis-bottom"  style="display:none !important">
							<div class="sharethis-buttons">
								<div class="sharethis-wrapper">
									<div class="addthis_toolbox addthis_default_style" addthis:url="{$DOMAIN_NAME}{$clsService->getLink($service_id)}" addthis:title="{$title_service}">
									<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
									<a class="addthis_button_tweet"></a>
									<a class="addthis_button_pinterest_pinit"></a>
									<a class="addthis_counter addthis_pill_style"></a>
								</div>
								<script src="//s7.addthis.com/js/300/addthis_widget.js#pubid=thiembv"></script>
								</div>
							</div>
						</div>*}
					</div>
					<div class="clearfix mb30"></div>
					<div class="h-form-book-event">
					<fieldset class="bg_fff">
						<legend>{$title_service}</legend>
						<form action="{$clsService->getLink($service_id)}" method="post" id="EventsForm" class="">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
									<input type="hidden" name="service_id" value="{$service_id}">
										<label>{$core->get_Lang('Full name')}<span style="color:red"> *</span></label>
										<input type="text" name="fullname" class="form-control required" placeholder="{$core->get_Lang('Ex: John Smith')}" value="{$fullname}" />
									</div>
									<div class="form-group">
										<label>{$core->get_Lang('Address')}<span style="color:red"> *</span></label>
										<input type="text" name="address" class="form-control required" placeholder="{$core->get_Lang('Ex')}: {$clsConfiguration->getValue('CompanyAddress')}" value="{$address}" />
									</div>
									<div class="form-group">
										<label>{$core->get_Lang('Email')}<span style="color:red"> *</span></label>
										<input type="text" name="email" class="form-control required" placeholder="{$core->get_Lang('Ex')}: {$clsConfiguration->getValue('CompanyEmail')}" value="{$email}" />
									</div>
									<div class="form-group">
										<label>{$core->get_Lang('Phone Number')}<span style="color:red"> *</span></label>
										<input type="text" name="phone" class="form-control required" placeholder="{$core->get_Lang('Ex')}: {$clsConfiguration->getValue('CompanyPhone')}" value="{$phone}" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>{$core->get_Lang('Message')}<span style="color:red"> *</span></label>
										<textarea name="message" placeholder="{$core->get_Lang('Enter the message here')}..." rows="5" class="form-control required">{$message}</textarea>
									</div>
							 
									{if $clsISO->getVar('_ISOCMS_CAPTCHA') eq 'IMG'}
									<div class="form-group">
										<label>{$core->get_Lang('Secure')} <font color="red">*</font></label>
										<div class="clearfix"></div>
										<input type="text" autocomplete="off" class="form-control inputSecure inline-block" name="security_code" maxlength="5" placeholder="{$core->get_Lang('Secure')}" style="width:150px; vertical-align:top" > <img class="Secure" src="{$PCMS_URL}/captcha.php?sid={$sid}" onclick="this.src='{$PCMS_URL}/captcha.php?'+Math.random()+'&sid={$sid}'" width="80px" height="34px" alt="Secure" />	  
									</div>
									{else}
									<div class="form-group">
										<div class="g-recaptcha" data-sitekey="{$clsISO->getVar('reCAPTCHA_KEY')}"></div>
										{if $errMsg ne ''}
											<div id="error_recaptcha" class="error text_left">{$errMsg}</div>
										{else}
											<div id="error_recaptcha" class="error text_left"></div>
										{/if}
									</div>
									{/if}
									<div class="form-group mt10">
									  	<button type="submit" class="btn-info h-read-more btn_main" id="SubmitEvents">
											{$core->get_Lang('Confirm &amp; Submit')}
										</button>
										<input type="hidden" name="Hid_Events" value="Hid_Events" />
									</div>
								</div>
							</div>
						</form>
					</fieldset>
					</div>
				</div>
				<div class="col-lg-3 sidebar rightService">
                   <div class="sticky_fix">
					{$core->getBlock('l_boxcolService')}
                    </div>
				</div>
			</div>
        </div>
	</div>
</div>
<script defer src="{$URL_JS}/jquery.validate.js?v={$upd_version}" ></script>
<script>
	var msg_recapcha = "{$core->get_Lang('You must check Recaptcha')}";
</script>
{literal}
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$(function () {
			$("#EventsForm").validate();
			if(grecaptcha.getResponse() == "") {
				ev.preventDefault();
				$('#error_recaptcha').html(msg_recapcha).fadeIn().delay(3000).fadeOut();
				return false;
			} else {
				$('#EventsForm').submit();
			}
		});
	})
</script>
{/literal}