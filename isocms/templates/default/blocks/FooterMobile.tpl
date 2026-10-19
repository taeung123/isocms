{assign var=Copyright value=Copyright_|cat:$_LANG_ID}
{assign var=CompanyAddress value=CompanyAddress_|cat:$_LANG_ID}
{assign var=CompanyName value=CompanyName_|cat:$_LANG_ID}
{assign var=CompanyAddress1 value=CompanyAddress1_|cat:$_LANG_ID}
{assign var = DescriptionZoneFooter value = DescriptionZoneFooter_|cat:$_LANG_ID}
<div id="footerMobile">
   <div class="container">
<!--
     <div class="logo__footer">
		<a href="{$PCMS_URL}" title="{$PAGE_NAME}"><img class="img100" src="{$clsConfiguration->getImageValue('FooterLogo')}" alt="{$PAGE_NAME}" /></a>
	</div>
-->
      <div class="InfoCompany">
		  <h2 class="title_footer">{$clsConfiguration->getValue($CompanyName)}</h2>
         <p class="footer_com mb20 address">
			 <a target="_blank" class="" href="https://maps.google.it/maps?q={$clsConfiguration->getValue($CompanyAddress1)}" title="{$clsConfiguration->getValue($CompanyAddress)}">
				 {$clsConfiguration->getValue($CompanyAddress)}
			 </a>
		 </p>
         <p class="footer_com mb20 phone"><span class="label">{$core->get_Lang('Hotline')}</span><a href="tel:{$clsConfiguration->getValue('CompanyHotline')}" title="{$clsConfiguration->getValue('CompanyHotline')}" class="">{$clsConfiguration->getValue('CompanyHotline')}</a> {*/ <a href="tel:{$clsConfiguration->getValue('CompanyPhone')}" title="{$clsConfiguration->getValue('CompanyPhone')}" class="">{$clsConfiguration->getValue('CompanyPhone')}</a>*}
         </p>
         <p class="footer_com mb20 email"><span class="label">{$core->get_Lang('Email')}</span><a href="mailto:{$clsConfiguration->getValue('CompanyEmail')}" title="{$clsConfiguration->getValue('CompanyEmail')}" class="">{$clsConfiguration->getValue('CompanyEmail')}</a></p>
      </div>
	   <div class="panel-group" id="accordion_F">
      <div class="panel panel-default">
         <div class="panel-heading ">
            <h3 class="title_footer">
               <a class="panel-title collapsed" data-bs-toggle="collapse" aria-expanded="false" data-bs-target="#tab_ft_1" aria-controls="tab_ft_1" role=link aria-disabled=true >
               <span>{$core->get_Lang('About us')} </span>
               <i class="fa fa-chevron-up pull-right"></i>
               </a>
            </h3>
         </div>
         <div id="tab_ft_1" class="panel-collapse collapse" aria-labelledby="tab_ft" data-bs-parent="accordion_F">
            <div class="panel-body color_666">
               <ul class="footer_Link list_style_none">
                  {if $clsISO->getCheckActiveModulePackage($package_id,'page','about','default')}
				  <li><a href="{$clsISO->getLink('about')}" title="{$core->get_Lang('About Us')}"> {$core->get_Lang('About Us')}</a></li>
				  {/if}
                  <li><a href="{$clsISO->getLink('contact')}" title="{$core->get_Lang('Contact')}"> {$core->get_Lang('Contact')}</a></li>
				  {if $clsISO->getCheckActiveModulePackage($package_id,'testimonial','default','default')}
                  <li><a href="{$clsISO->getLink('testimonial')}" title="{$core->get_Lang('Testimonials')}"> {$core->get_Lang('Testimonials')}</a></li>
				  {/if}
                  {section name=i loop=$listAllpage}
                  {assign var = title_page value = $listAllpage[i].title}
                  <li><a href="{$clsPage->getLink($listAllpage[i].page_id)}" title="{$title_page}"> {$title_page}</a></li>
                  {/section}
				  {if $clsISO->getCheckActiveModulePackage($package_id,'faqs','default','default')}
                  <li><a href="{$clsISO->getLink('faqs')}" title="{$core->get_Lang('Faqs')}"> {$core->get_Lang('Faqs')}</a></li>
				  {/if}
				  {if $clsISO->getCheckActiveModulePackage($package_id,'download','default','default')}
                  <li><a href="{$clsISO->getLink('download')}" title="{$core->get_Lang('Trade Brochures')}"> {$core->get_Lang('Trade Brochures')}</a></li>
				  {/if}
               </ul>
            </div>
         </div>
		 </div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="title_footer">
					<a class="panel-title collapsed" data-bs-toggle="collapse" aria-expanded="false" data-bs-target="#tab_ft_4" aria-controls="tab_ft_4" role=link aria-disabled=true >
						<span>{$core->get_Lang('Travel Styles')} </span>
						<i class="fa fa-chevron-up pull-right"></i>
					</a>
				</h3>
			</div>
			<div id="tab_ft_4" class="panel-collapse collapse" data-bs-parent="accordion_F">
				<div class="panel-body color_666">
					<ul class="footer_Link list_style_none">
                        {section name=i loop=$lstCatTour}
                        {assign var = title_category value = $lstCatTour[i].title}
						<li><a href="{$clsTourCategory->getLink($lstCatTour[i].tourcat_id,$lstCatTour[i])}" title="{$title_category}"> {$title_category}</a></li>
					    {/section}
					</ul>
				</div>
			</div>
		</div>
    	<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="title_footer">
					<a class="panel-title collapsed" data-bs-toggle="collapse" aria-expanded="false" data-bs-target="#tab_ft_5" aria-controls="tab_ft_5" role=link aria-disabled=true >
						<span>{$core->get_Lang('Other')} </span>
						<i class="fa fa-chevron-up pull-right"></i>
					</a>
				</h3>
			</div>
			<div id="tab_ft_5" class="panel-collapse collapse" data-bs-parent="accordion_F">
				<div class="panel-body color_666">
					<ul class="footer_Link list_style_none">
						<li><a href="{$clsISO->getLink('tailor')}" title="{$core->get_Lang('Tailor made tour')}"> {$core->get_Lang('Tailor made tour')}</a></li>
						{if $clsISO->getCheckActiveModulePackage($package_id,'news','default','default')}
							<li><a href="{$clsISO->getLink('news')}" title="{$core->get_Lang('Experience')}"> {$core->get_Lang('Experience')}</a></li>
						{/if}
						{if $clsISO->getCheckActiveModulePackage($package_id,'blog','default','default')}
							<li><a href="{$clsISO->getLink('blog')}" title="{$core->get_Lang('Blog')}"> {$core->get_Lang('Blogs')}</a></li>
						{/if}
					</ul>
				</div>
			</div>
		</div>
     	<div class="panel panel-default box-follow">
			<div class="panel-heading">
				<h3 class="title_footer">
					<a class="panel-title collapsed" data-bs-toggle="collapse" aria-expanded="false" data-bs-target="#tab_ft_6" aria-controls="tab_ft_6" role=link aria-disabled=true >
						<span>{$core->get_Lang('Follow Us')} </span>
					</a>
				</h3>
			</div>
			<div id="" class="panel-collapse " data-bs-parent="accordion_F">
				<div class="panel-body color_666">
					<ul class="footer_Link list_style_none list_follow">
						{if $clsConfiguration->getValue('Facebook_Link')}
                        <li>
                            <a class="facebook" href="http://www.facebook.com/{$clsConfiguration->getValue('SiteFacebookLink')}" target="_blank" title="{$core->get_Lang('Facebook')}">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                            </a>
                        </li>
                        {/if}
                        {if $clsConfiguration->getValue('Twitter_Link')}
                        <li>
                            <a class="twitter" href="http://www.twitter.com/{$clsConfiguration->getValue('SiteTwitterLink')}" target="_blank" title="{$core->get_Lang('Twitter')}">
                                <i class="fa fa-twitter" aria-hidden="true"></i>
                            </a>
                        </li>
                        {/if}
                        {if $clsConfiguration->getValue('Youtube_Link')}
                        <li>
                            <a class="youtube" href="http://www.youtube.com/{$clsConfiguration->getValue('SiteYoutubeLink')}" target="_blank" title="{$core->get_Lang('Youtube')}">
                                <i class="fa fa-youtube-play" aria-hidden="true"></i>
                            </a>
                        </li>
                        {/if}
                        {if $clsConfiguration->getValue('Google_Plus_Link')}
                        <li>
                            <a class="google" href="http://plus.google.com/{$clsConfiguration->getValue('SiteGoogleLink')}" target="_blank" title="{$core->get_Lang('Google +')}">
                                <i class="fa fa-google-plus" aria-hidden="true"></i>
                            </a>
                        </li>
                        {/if}
                        {if $clsConfiguration->getValue('Instagram_Link')}
                        <li>
                            <a class="instagram" href="https://www.instagram.com/{$clsConfiguration->getValue('SiteInstagramLink')}" target="_blank" title="{$core->get_Lang('Instagram')}">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                            </a>
                        </li>
                        {/if}
                        {if $clsConfiguration->getValue('Printest_Link')}
                        <li>
                            <a class="pinterest" href="http://pinterest.com/{$clsConfiguration->getValue('SitePrintestLink')}" target="_blank" title="{$core->get_Lang('Printest')}">
                                <i class="fa fa-pinterest-p" aria-hidden="true"></i>
                            </a>
                        </li>
                        {/if}
                        {if $clsConfiguration->getValue('LinkedIn_Link')}
                        <li>
                            <a class="linkedin" href="https://www.linkedin.com/{$clsConfiguration->getValue('SiteLinkInLink')}" target="_blank" title="{$core->get_Lang('LinkedIn')}">
                                <i class="fa fa-linkedin" aria-hidden="true"></i>
                            </a>
                        </li>
                        {/if}
                        {if $clsConfiguration->getValue('TripAdvisor_Link')}
                        <li>
                            <a class="tripadvisor" href="http://www.tripadvisor.com/{$clsConfiguration->getValue('SiteTripAdvisorLink')}" target="_blank" title="{$core->get_Lang('TripAdvisor')}">
                                <i class="fa fa fa-tripadvisor" aria-hidden="true"></i>
                            </a>
                        </li>
                        {/if}
					</ul>
				</div>
			</div>
		</div>
		 <div class="panel panel-default box_pay">
				<div class="panel-heading">
					<h3 class="title_footer">
						<a class="panel-title collapsed" data-bs-toggle="collapse" aria-expanded="false" data-bs-target="#tab_ft_7" aria-controls="tab_ft_7" role=link aria-disabled=true >
							<span>{$core->get_Lang('Payment Channel')} </span>
						</a>
					</h3>
				</div>
				<div id="" class="panel-collapse" data-bs-parent="accordion_F">
					<div class="panel-body color_666">
						<div class="footer_Link list_style_none list_follow">
							<p class="payment">
								<img src="{$clsConfiguration->getImage('default_image_pixel',1,1)}" data-src="{$URL_IMAGES}/icon/onepay_f.png" class="lazy" alt="onepay" width="50" height="35">
								<img src="{$clsConfiguration->getImage('default_image_pixel',1,1)}" data-src="{$URL_IMAGES}/icon/visa_f.png" class="lazy" alt="visa" width="50" height="35">
								<img src="{$clsConfiguration->getImage('default_image_pixel',1,1)}" data-src="{$URL_IMAGES}/icon/master_card_f.png" class="lazy" alt="MasterCard" width="50" height="35">
							</p>
						</div>
					</div>
				</div>
			</div>
      </div>
	</div>
     
   </div>
   <div class="copy__right bg_main">
		<div class="container">
			<div class="copy__right--content">
				{$clsConfiguration->getCopyRight()}
				<a title="{$core->get_Lang('Travel website design')}" href="https://www.vietiso.com/thiet-ke-website-du-lich.html" class="">{$core->get_Lang('Travel website design')}</a>  {$core->get_Lang('by')} <a class="" href="https://www.vietiso.com" title="VIETISO">VIET<span class="color_f58220">ISO</span></a>
			</div>
		</div>
	</div>
</div>