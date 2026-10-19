<link rel="stylesheet" href="{$URL_CSS}/isotailor.css?v={$upd_version}" type="text/css">	
<script defer type="text/javascript" src="{$URL_JS}/jquery.validate.js"></script>
{assign var=adultTxt value=$core->get_Lang('adult')}
{assign var=adultsTxt value=$core->get_Lang('adults')}
{assign var=childTxt value=$core->get_Lang('child')}
{assign var=childrenTxt value=$core->get_Lang('children')}
{assign var=babyTxt value=$core->get_Lang('baby')}
{assign var=babiesTxt value=$core->get_Lang('babies')}
{assign var=roomTxt value=$core->get_Lang('room')}
{assign var=roomsTxt value=$core->get_Lang('rooms')}
<div class="breadcrumb-main  breadcrumb-cruise bg-default breadcrumb-more">
        <div class="container">
            <ol class="breadcrumb hidden-xs" itemscope itemtype="http://schema.org/BreadcrumbList">
               <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				   <a itemtype="http://schema.org/Thing" itemprop="item" href="{$PCMS_URL}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
               {if $tour_id ne ''}
               <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				   <a itemtype="http://schema.org/Thing" itemprop="item" href="{$clsISO->getLink('tailor')}" title="{$core->get_Lang('Tailor made tour')}" itemprop="url">
					   <span itemprop="name" class="reb">{$core->get_Lang('Tailor made tour')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
                <li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemtype="http://schema.org/Thing" itemprop="item" href="{$curl}" title="{$clsTour->getTitle($tour_id)}" itemprop="url">
						<span itemprop="name" class="reb">{$clsTour->getTitle($tour_id)}</span></a>
					<meta itemprop="position" content="3" />
				</li>
               {else}
                <li class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemtype="http://schema.org/Thing" itemprop="item" href="{$curl}" title="{$core->get_Lang('Tailor made tour')}" itemprop="url">
						<span itemprop="name" class="reb">{$core->get_Lang('Tailor made tour')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
                {/if}
            </ol>
        </div>
    </div>
<div class="main-container">
    <section id="main-contents">
        <article>
            <div class="main-body">
                <div class="contact-us">
                    <div class="clearfix">
                        <div class="details">
                            <div>
                                <ul>
                                    <li class="phone">
                                   		<p>{$core->get_Lang('Give us a call')}</p>
                                        <p class="phone">
                                        	<a href="tel:{$clsConfiguration->getValue('CompanyHotline')}">{$clsConfiguration->getValue('CompanyHotline')}</a>
                                        </p>
                                    </li>
                                    <li class="email">
                                        <p>{$core->get_Lang('Send us an email')}</p>
                                        <p class="mail"><a href="mailto:{$clsConfiguration->getValue('CompanyEmail')}">{$clsConfiguration->getValue('CompanyEmail')}</a></p>
                                    </li>
                                </ul>
                                <h3>{$core->get_Lang('Mailing Address')}</h3>
                                <p class="address">{$clsConfiguration->getValue('CompanyAddress')}</p>
                            </div>
                        </div>
                        <div class="form">
                        <div>
                        <div id="Validation" style="color:red">
                             <span style="display:inline"></span>
                        </div>
          <section id="enquiry-form">
            <form action="" method="post" id="EnquiryForm" class="cmxform">
                <fieldset>
                   <input id="ReferrerUrl" name="ReferrerUrl" type="hidden" value="">
                </fieldset>
				 <fieldset>
                     <h4>Your Details</h4>
				 	<ol>
						<li>
							<label for="Title">Title:<span style="color:red"> *</span></label>
                            <select id="title" name="title" class="required">
                                {$clsISO->makeSelectTitle($title)}
                            </select>
						</li>
						<li>
							  <label for="FirstName">{$core->get_Lang('First name')}:<span style="color:red"> *</span></label>
                              <input id="firstname" name="firstname" type="text" value="">
                              <div id="error_firstname" class="error"></div>	
                        </li>
                         <li>
                            <label for="LastName">Last name:<span style="color:red"> *</span></label>
                            <input id="lastname" name="lastname"  type="text" value=""> 
                            <div id="error_lastname" class="error"></div>
						</li>
						<li>
                            <label for="Telephone">Telephone:<span id="TelephoneAsterisk" style="color:red"> *</span></label>
                            <input id="phone" name="phone" type="text" value="">
                            <div id="error_phone" class="error"></div>
						</li>
						<li>
                            <label for="Email">Email address:<span style="color:red"> *</span></label>
                            <input id="email" name="email" type="text" value="">
                            <div id="error_email" class="error_email"></div>
                        </li>
                         <li>
                            <label for="ConfirmationEmail">Confirm email address:<span style="color:red"> *</span></label>
                            <input id="confirmemail" name="confirmemail" type="text" value="">
                            <div id="error_confirmemail" class="error_email"></div>
						</li>
                         <li>
                            <label for="Country">Country of residence:<span style="color:red"> *</span></label>
                            <select name="countryex_id" id="countryex_id" class="required">
                                <option value="">-- {$core->get_Lang('Select')} -- </option>
                                {section name=i loop=$lstCountryRegion}
                                <option {if $country_id eq $lstCountryRegion[i].country_id}selected="selected"{/if} value="{$lstCountryRegion[i].country_id}">{$lstCountryRegion[i].title}</option>
                                {/section}
                            </select>
                        </li>
                    </ol>
                     <ol>
						<li class="checkbox-list clearfix">
							<label for="ContactPreference">How do you wish to be contacted?:</label><br>
                            <strong>
                                <input {if $please eq '1'}checked="checked"{/if} name="please" type="checkbox" value="1">Email
                            </strong>
                            <strong>
                                <input {if $please eq '2'}checked="checked"{/if} name="please" type="checkbox" value="2">Call
                            </strong>
                            <strong>
                                <input {if $please eq '3'}checked="checked"{/if} name="please" type="checkbox" value="3">Don't Mind
                            </strong>
						</li>
                    </ol>
                     <ol>
                        <li>
							<label for="DepartureDate">When would you like to travel?:</label>
                            <div class="date clearfix">
								<select id="departuremonth" name="departuremonth">
                                	{$clsISO->makeSelectMonth($month)}
                                    
                                </select>
                                <select id="departureyear" name="departureyear">
                                	{$clsISO->makeSelectYear($year)}
                                </select>
                            </div>
						</li>
                        <li>
                            <label for="TravelDuration">And for how long?:</label>
                            <select id="travelduration" name="travelduration">
                            	{$clsISO->makeSelectTravelDuration($travelduration)}
                            </select>
                        </li>
                    </ol>
                    <ol>
						<li class="checkbox-list clearfix">					
							<label for="WhereToGo">Where would you like to go?:</label>
                            {section name=i loop=$lstCountryEx}
                            <strong>
                                <input {if $clsISO->checkInArray($lst_country_id,$lstCountryEx[i].country_id)}checked="checked"{/if} value="{$lstCountryEx[i].country_id}" type="checkbox" name="country_id[]" />{$clsCountryEx->getTitle($lstCountryEx[i].country_id)}
                            </strong>
                            {/section}
                            <input type="hidden" id="lst_country_id" name="lst_country_id" value="{if $lst_country_id ne ''}{$lst_country_id}{else}{$lstCountryEx[0].country_id}{/if}" />
						</li>
                    </ol>
                    <ol>
						<li class="checkbox-list">
                            <label for="NewsletterSignup">Newsletter signup:</label><br>
                            <input id="NewsletterSignup" name="NewsletterSignup" type="checkbox" value="true"><input name="NewsletterSignup" type="hidden" value="false">Subscribe to our newsletter, Journeys. <a href="" target="_blank">See recent editions</a>.
						</li>
                    </ol>
                    <ol>
						<li id="heardAboutUsContainer" class="hidden-boxes">
                        <label for="HearAboutUs">How did you hear about us?:</label>
                            <select id="HeardAboutUs" name="HearAboutUs"><option value="">-- Select --</option>
                                <option value="Travel Agent event">Travel Agent event</option>
                                <option value="Ensemble Oasis 2016">Ensemble Oasis 2016</option>
                                <option value="Search Engine">Search Engine</option>
                                <option value="Website">Website</option>
                                <option value="Traveled with us before">Traveled with us before</option>
                                <option value="Newspapers">Newspapers</option>
                                <option value="Magazine">Magazine</option>
                                <option value="Travel show">Travel show</option>
                                <option value="E-newsletters">E-newsletters</option>
                                <option value="Travel agent">Travel agent</option>
                                <option value="Friends/ Family">Friends/ Family</option>
                                <option value="Other">Other</option>
                            </select>
                        </li>
                        <li id="HearAboutUsSubCategories" style="display:none">
                            <label for="AboutUsSubCategories">Source:<span style="color:red"> *</span></label>
                            <select id="AboutUsSubCategories" name="AboutUsSubCategories">
                           		<option value="">-- Select --</option>
        					</select>	
                        </li>
                        <li id="OtherSubCat" style="display:none">
                            <label for="textboxAboutUsSubCategories">Other:<span style="color:red"> *</span></label>
                            <input id="AboutUsSubCategoriesOther" name="AboutUsSubCategoriesOther" type="text" value="">
						</li>
                    </ol>
                    <ol>
						<li><label for="Comments">Further comments/ itinerary you are interested in:</label><textarea class="textbox2" cols="20" id="Comments" name="Comments" rows="2"></textarea></li>
                    </ol>
                    <p>
                    	<input type="hidden" name="plantrip" value="plantrip" />
                        <input type="hidden" name="type" id="tabtype" value="{if $type eq ''}1{else}{$type}{/if}" />
                        <input type="hidden" name="tour_id" value="{$tour_id}" />
                        <button type="submit" class="send" id="SubmitEnquiry">
                            {$core->get_Lang('Confirm &amp; Submit')}
                        </button>
                    </p>
				</fieldset>
                </form>
 				
 			</section>
            </div>
            </div>
            </div>
            </div>           
		    </div>
        </article>
	</section>
	{literal}
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            $(document).ready(function () {
                var hash = window.location.hash;
                if ($('#HeardAboutUs OPTION').length > 1) {
                    $('#heardAboutUsContainer').show();

                    $('#HeardAboutUs').change(function () {
                        ShowSubCategoryFieldsFields($(this).val());
                    });

                    $('#AboutUsSubCategories').change(function () {
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
        })
    </script>
	{/literal}
</div>
<script type="text/javascript">
    var city_list = '{$city_list}';
    var msg_firstname_required = "{$core->get_Lang('Your first name should not be empty ')}!";
	var msg_lastname_required = "{$core->get_Lang('Your last name should not be empty ')}!";
	var msg_phone_required = "{$core->get_Lang('Your telephone should not be empty ')}!";
    var msg_email_required = "{$core->get_Lang('Your email should not be empty ')}!";
    var msg_email_not_valid = "{$core->get_Lang('Please enter a valid email address')}!";
	var msg_confirmemail_not_valid = "{$core->get_Lang('Email addresses do not match')}!";
</script>
{literal}
<style type="text/css">
    .form-horizontal .checkbox{min-height: 22px !important}
</style>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        $().ready(function () {
            $('#EnquiryForm').validate();
        });
        $(function(){
		    $("#SubmitEnquiry").click(function(){
                var $firstname = $("#firstname").val();
                var $lastname = $("#lastname").val();
                var $phone = $("#phone").val();
                var $email = $("#email").val();
                var $confirmemail = $("#confirmemail").val();
                
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
                if($confirmemail!=$email){
                    $('#error_confirmemail').html(msg_confirmemail_not_valid).fadeIn().delay(3000).fadeOut();
                    $("#confirmemail").focus();
                    return false;
                }
            });
        });
        function checkValidEmail(email){
            var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }
    })
</script>