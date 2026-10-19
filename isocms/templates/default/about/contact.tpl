<script src="{$URL_JS}/jquery.validate.js?ver={$upd_version}"></script>
{assign var=adultTxt value=$core->get_Lang('adult')}
{assign var=adultsTxt value=$core->get_Lang('adults')}
{assign var=childTxt value=$core->get_Lang('child')}
{assign var=childrenTxt value=$core->get_Lang('children')}
{assign var=babyTxt value=$core->get_Lang('baby')}
{assign var=babiesTxt value=$core->get_Lang('babies')}
{assign var=roomTxt value=$core->get_Lang('room')}
{assign var=roomsTxt value=$core->get_Lang('rooms')}
<div class="page_container">
    <nav class="breadcrumb-main  breadcrumb-{$mod} bg-default breadcrumb-more bg_fff">
        <div class="container">
            <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
                {if $tour_id ne ''}
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$curl}" title="{$core->get_Lang('Enquiry')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Enquiry')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$curl}" title="{$clsTour->getTitle($tour_id)}">
						<span itemprop="name" class="reb">{$clsTour->getTitle($tour_id)}</span></a>
					<meta itemprop="position" content="3" />
				</li>
                {else}
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="active">
					<a itemprop="item" href="{$curl}" title="{$core->get_Lang('Contact us')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Contact us')}</span></a>
					<meta itemprop="position" content="4" />
				</li>
                {/if}
			</ol>
		</div>
	</nav>
	<section id="contentPage" class="contact-us contactPage pd50_0">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-7 floatRight_992 mb991_30">
					<div class="formCustomer bg_fff pd15_10">
						{if 1 eq 2}
						<div id="Validation" style="color:red">
							<span style="display:inline"></span>
						</div>
						{/if}
						<div id="enquiry-form">
							<form action="{$clsISO->getLink('contact')}" method="post" id="EnquiryForm" class="cmxform">
								{if $tour_id gt '0'}
								<fieldset>
									<h4>{$core->get_Lang('Tour Details')}</h4>
									<ol>
										<li>
											<label for="Title">{$core->get_Lang('Tour Name')}:</label>
											<p>{$clsTour->getTitle($tour_id)}</p>
										</li>
										<li>
											<label for="FirstName">{$core->get_Lang('Trip code')}:</label>
											<p>{$clsTour->getTripCode($tour_id)}</p>
										</li>
										<li>
											<label for="LastName">{$core->get_Lang('Trip duration')}:</label>
											<p>{$clsTour->getTripDuration($tour_id)}</p>
										</li>
									</ol>
								</fieldset>
								{/if}
								{if $cruise_id gt '0'}
								<fieldset>
									<h4>{$core->get_Lang('Cruise Details')}</h4>
									<ol>
										<li>
											<label for="Title">{$core->get_Lang('Cruise Name')}:</label>
											<p>{$clsCruise->getTitle($cruise_id)}</p>
										</li>
										{if $cruise_itinerary_id gt '0'}
										<li>
											<label for="LastName">{$core->get_Lang('Cruise Itinerary')}:</label>
											<p>{$clsCruiseItinerary->getTitleDay($cruise_itinerary_id)}</p>
										</li>
										{/if}
									</ol>
								</fieldset>
								{/if}
								<fieldset>
									<h4 class="mt_mb_15">{$core->get_Lang('Your Details')}</h4>
									<ol>
										<li>
											<label for="title">{$core->get_Lang('Title')}:<span style="color:red"> *</span>
											</label>
											<select id="title" name="title" class="required">
												{$clsISO->makeSelectTitle($title)}
											</select>
										</li>
										<li>
											<label for="firstname">{$core->get_Lang('First name')}:<span style="color:red"> *</span>
											</label>
											<input id="firstname" name="firstname" type="text" value="">
											<div class="clearfix"></div>
											<div id="error_firstname" class="error text_right"></div>
										</li>
										<li>
											<label for="lastname">{$core->get_Lang('Last name')}:<span style="color:red"> *</span>
											</label>
											<input id="lastname" name="lastname" type="text" value="">
											<div class="clearfix"></div>
											<div id="error_lastname" class="error text_right"></div>
										</li>
										<li>
											<label for="phone">{$core->get_Lang('Telephone')}:<span id="TelephoneAsterisk" style="color:red"> *</span>
											</label>
											<input id="phone" name="phone" type="text" value="">
											<div class="clearfix"></div>
											<div id="error_phone" class="error"></div>
										</li>
										<li>
											<label for="email">{$core->get_Lang('Email address')}:<span style="color:red"> *</span>
											</label>
											<input id="email" name="email" type="text" value="">
											<div class="clearfix"></div>
											<div id="error_email" class="error text_right"></div>
										</li>
										<li>
											<label for="countryex_id">{$core->get_Lang('Country of residence')}:<span style="color:red"> *</span>
											</label>
											<select name="countryex_id" id="countryex_id" class="required">
												<option value="">-- {$core->get_Lang('Select')} -- </option>
												{section name=i loop=$lstCountryRegion}
												<option {if $country_id eq $lstCountryRegion[i].country_id}selected="selected" {/if} value="{$lstCountryRegion[i].country_id}">{$lstCountryRegion[i].title}</option>
												{/section}
											</select>
										</li>
									</ol>
									<div class="clearfix"></div>
									<div class="row">
										<div class="col-sm-8">
											<div class="g-recaptcha" data-sitekey="{$clsISO->getVar('reCAPTCHA_KEY')}"></div>
											{if $errMsg ne ''}
											<div id="error_recaptcha" class="error text_left">{$errMsg}</div>
											{else}
											<div id="error_recaptcha" class="error text_left"></div>
											{/if}
										</div>
										<div class="col-sm-4">
											<input type="hidden" name="plantrip" value="plantrip" />
											<input type="hidden" name="hidden_field" value="" />
											<input type="hidden" name="type" id="tabtype"
											value="{if $type eq ''}1{else}{$type}{/if}" />
											<input type="hidden" name="tour_id" value="{$tour_id}" />
											<input type="hidden" name="cruise_id" value="{$cruise_id}" />
											<input type="hidden" name="cruise_itinerary_id" value="{$cruise_itinerary_id}" />
											<input type="hidden" name="hotel_id" value="{$hotel_id}" />
											<button type="submit" class="send" id="SubmitEnquiry">
												{$core->get_Lang('Confirm &amp; Submit')}
											</button>
										</div>
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-5">
					<div class="details contactInfo bg_fff pd15_10">
						<div>
						<ul>
							{if $clsConfiguration->getValue('CompanyHotline') ne ''}
							<li class="phone">
								<p>{$core->get_Lang('Give us a call')}</p>
								<p class="phone">
									<a href="tel:{$clsConfiguration->getValue('CompanyHotline')}">{$clsConfiguration->getValue('CompanyHotline')}</a>
								</p>
							</li>
							{/if}
							{if $clsConfiguration->getValue('CompanyEmail') ne ''} 
							<li class="email">
								<p>{$core->get_Lang('Send us an email')}</p>
								<p class="mail"><a href="mailto:{$clsConfiguration->getValue('CompanyEmail')}">{$clsConfiguration->getValue('CompanyEmail')}</a>
								</p>
							</li>
							{/if}
						</ul>
						{assign var=CompanyAddress value=CompanyAddress_|cat:$_LANG_ID}
						{if $clsConfiguration->getValue($CompanyAddress) ne ''}
							<h3>{$core->get_Lang('Mailing Address')}</h3>
							<p class="address">{$clsConfiguration->getValue($CompanyAddress)}</p>
							{if $clsConfiguration->getValue('CompanySkype')}
							<p class="skype">{$core->get_Lang('Skype')}: {$clsConfiguration->getValue('CompanySkype')}</p>
							{/if}
							<p class="opening">{$core->get_Lang('Opening hours')}: {$clsConfiguration->getValue('CompanyOpeningHours')}</p> 
						{/if}
						</div>
					</div>
				</div>
			</div>
			{literal}
			<script>
			$(document).ready(function() {
				var hash = window.location.hash;
				if ($('#HeardAboutUs OPTION').length > 1) {
					$('#heardAboutUsContainer').show();
					
					$('#HeardAboutUs').change(function() {
						ShowSubCategoryFieldsFields($(this).val());
					});
					
					$('#AboutUsSubCategories').change(function() {
						ShowSubCategoryFieldsFields($(this).val());
					});
				}
			});
			function ShowSubCategoryFieldsFields(val) {
				if ((val == 'Other' || val.indexOf('Other') == 0)) {
					$("#OtherSubCat").show();
					} else {
					$('#AboutUsSubCategoriesOther').val('');
					$("#OtherSubCat").hide();
				}
			}
			</script>
			{/literal}
		</div>
	</section>

</div>
<script>
	var city_list = '{$city_list}';
</script>
{literal}
<script>
	$().ready(function () {
		$('#EnquiryForm').validate();
	});
</script>
{/literal}
<script>
	var msg_firstname_required = "{$core->get_Lang('Your first name should not be empty')}!";
	var msg_lastname_required = "{$core->get_Lang('Your last name should not be empty')}!";
	var msg_phone_required = "{$core->get_Lang('Your telephone should not be empty')}!";
	var msg_email_required = "{$core->get_Lang('Your email should not be empty')}!";
	var msg_email_not_valid = "{$core->get_Lang('Please enter a valid email address')}!";
	var msg_confirmemail_not_valid = "{$core->get_Lang('Email addresses do not match')}!";
	var showInfo = "{$core->get_Lang('Show more information')}";
	var hideInfo = "{$core->get_Lang('information hidden')}";
	var msg_recapcha = "{$core->get_Lang('You must check Recaptcha')}";
</script>
{literal}
<script>
	$(function(){
		$("#SubmitEnquiry").click(function(ev){
			var $firstname = $("#firstname").val();
			var $lastname = $("#lastname").val();
			var $phone = $("#phone").val();
			var $email = $("#email").val();
			
			if($("#firstname").val()==''){
				$('#error_firstname').html(msg_firstname_required).fadeIn().delay(3000).fadeOut();
				$("#firstname").focus();
				return false;
			}
			if($("#lastname").val()==''){
				$('#error_lastname').html(msg_lastname_required).fadeIn().delay(3000).fadeOut();
				$("#lastname").focus();
				return false;
			}
			if($("#phone").val()==''){
				$('#error_phone').html(msg_phone_required).fadeIn().delay(3000).fadeOut();
				$("#phone").focus();
				return false;
			}
			if($("#email").val()==''){
				$('#error_email').html(msg_email_required).fadeIn().delay(3000).fadeOut();
				$("#email").focus();
				return false;
			}
			if(checkValidEmail($email)==false){
				$('#error_email').html(msg_email_not_valid).fadeIn().delay(3000).fadeOut();
				$("#email").focus();
				return false;
			}
			if(grecaptcha.getResponse() == "") {
				ev.preventDefault();
				$('#error_recaptcha').html(msg_recapcha).fadeIn().delay(3000).fadeOut(); 
				return false;
			} else {
				$('#EnquiryForm').submit();
			}
		});
	});
	function checkValidEmail(email){
		var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return regex.test(email);
	}
</script>
{/literal}																		