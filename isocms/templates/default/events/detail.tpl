{assign var=link_event value=$clsISO->getLinkEvent($oneEvent.slug,$oneEvent.title)}
<div class="page_container newsDetail eventsDetail">
   <div class="banner {if empty($oneEvent.banner)}hidden{/if}">
     {if $clsISO->getBrowser() eq 'computer' }
      <img class="full-width height-auto" src="{$oneEvent.banner}" alt="">
      {else}
      <img class="full-width height-auto" src="{$oneEvent.banner_mobile}" alt="">
      {/if}
      <div class="titlePage">
         <h1 class="TitlePage">{$oneEvent.title}</h1>
      </div>
   </div>
   <div class="newsPage pageNewsDetail bg_f1f1f1 {if empty($oneEvent.banner)}pdt10{/if}">
      <div class="container">
         <div class="row box_col">
            {if $clsISO->getBrowser() eq 'computer' }
            <div class="col-sm-2 col-md-1 hidden-sm">
               <div class="submitted">
                  <p class="shareText">{$core->get_Lang('Share')}</p>
                  <ul class="list_social_footer list-style-none">
                     <li>
                        <a class="facebook" href="javascript:void(0);" rel="nofollow" onclick="javascript:generic_social_share('https://www.facebook.com/sharer/sharer.php?u={$DOMAIN_NAME}{$link_event}&title={$oneEvent.title}');" title="{$core->get_Lang('Facebook')}">
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                        </a>
                     </li>
                     <li>
                        <a class="twitter"  href="javascript:void(0);" rel="nofollow" onclick="javascript:generic_social_share('https://twitter.com/home?status={$DOMAIN_NAME}{$link_event}');" title="{$core->get_Lang('Twitter')}">
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                        </a>
                     </li>
                     <li>
                        <a class="pinterest"  href="javascript:void(0);" rel="nofollow" onclick="javascript:generic_social_share('/https://www.linkedin.com/shareArticle?mini=true&url={$DOMAIN_NAME}{$link_event}');" title="{$core->get_Lang('Linkedin')}">
                        <i class="fa fa-linkedin" aria-hidden="true"></i>
                        </a>
                     </li>
                  </ul>
               </div>
            </div>
            {/if}
            <div class="col-md-11 col-sm-12" >
               <div class="breadcrumb-main bg_fff">
                  <ol class="breadcrumb hidden-xs hidden-sm mt0 bg_fff" itemscope itemtype="http://schema.org/BreadcrumbList">
                     <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemtype="http://schema.org/Thing" itemprop="item" href="{$DOMAIN_NAME}{$extLang}" title="{$core->get_Lang('Home')}">
                        <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
                        <meta itemprop="position" content="1" />
                     </li>
                     <!--
                        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                           <a itemtype="http://schema.org/Thing" itemprop="item" href="{$clsISO->getLink('events')}" title="{$core->get_Lang('Events')}">
                           <span itemprop="name" class="reb">{$core->get_Lang('Events')}</span></a>
                           <meta itemprop="position" content="2" />
                        </li>
                        {if $oneEvent.eventcat_id}
                        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                           <a itemtype="http://schema.org/Thing" itemprop="item" href="{$clsISO->getLinkEventCat($oneEvent.slug_cat,$oneEvent.eventcat_id)}" title="{$oneEvent.title_cat}">
                           <span itemprop="name" class="reb">{$oneEvent.title_cat}</span></a>
                           <meta itemprop="position" content="3" />
                        </li>
                        {/if}
                        -->
                     <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemtype="http://schema.org/Thing" class="active" itemprop="item" href="javascript:void(0);" title="{$oneEvent.title}">
                        <span itemprop="name" class="reb">{$oneEvent.title|truncate:80}</span></a>
                        <meta itemprop="position" content="2" />
                     </li>
                  </ol>
               </div>
               <div class="BookEvent">
                  <div class="row">
                     <div class="col-md-9">
                        <div class="topContentLeft">
                           <div class="TimeEvent">
                              <p class="monthEvent">{if $_LANG_ID eq 'vn'}
                                      {$core->get_Lang('Month')}
                                      {$oneEvent.start_date|date_format:"%m"}
                                  {else}
                                      {$oneEvent.start_date|date_format:"%b"}
                                  {/if}
                              </p>
                              <p class="dateEvent">{$oneEvent.start_date|date_format:"%d"}</p>
                               {assign var=weekday value=$oneEvent.start_date|date_format:"%A"}
                              <p class="dayEvent">{$core->get_Lang($weekday)}</p>

                           </div>
                           <div class="AddressAndTime">
                              <div class="addressBox">
                                 <p class="addressTitle"><i class="fa fa-map-marker" aria-hidden="true"></i> {$core->get_Lang('Address event')}</p>
                                 <p class="addressEvent">{$oneEvent.address}</p>
                              </div>
                              <div class="timeBox">
                                 <p class="timeTitle"><i class="fa fa-calendar-o" aria-hidden="true"></i> {$core->get_Lang('Time event')}</p>
                                 <p class="timeEvent">{if $oneEvent.start_date|date_format:"%d" eq $oneEvent.due_date|date_format:"%d"}{$oneEvent.start_date|date_format:"%d/%m/%Y"}{else}{$oneEvent.start_date|date_format:"%d/%m/%Y"} - {$oneEvent.due_date|date_format:"%d/%m/%Y"}{/if}</p>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="bookingBox">
                           <a id="registration--link" class="BookTicket" href="javascript:void(0)" title="{$core->get_Lang('Book ticket now')}">{$core->get_Lang('Book ticket now')}</a>
                           <p class="or">hoặc</p>
                           <a id="sponsorRegistration--link" class="BecomeSponsor" href="#" title="{$core->get_Lang('Become a sponsor')}">{$core->get_Lang('Become a sponsor')}</a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class=" newsLeft mb768_30">
                  <div class="row">
                     <div class="col-md-3 col-md-push-9">
                        <div class="menuTabRight">
                           <p class="titleBoxRight">{$core->get_Lang('Category Event')}</p>
                           <div id="tabsk" class="box__menu tabskEvent">
                              <ul class="clienttabs list_style_none" >
                                 <li><a id="overview--link" href="#overview">{$core->get_Lang('Overview event')}</a></li>
                                  {if $oneEvent.content_participants}
                                      <li><a id="participants--link" href="#participants">{$core->get_Lang('Participants')}</a></li>
                                  {/if}
                                  {if $schedule}
                                 <li><a id="ContentEvent--link" href="#ContentEvent">{$core->get_Lang('Content Event')}</a></li>
                                  {/if}
                                  {if !empty($listYield)}
                                      <li><a id="registration--link" href="#registration">{$core->get_Lang('registration')}</a></li>
                                  {/if}
                                  {if !empty($sponsor_package)}    
                                      <li><a id="sponsorRegistration--link" href="#sponsorRegistration">{$core->get_Lang('Sponsor Registration')}</a></li>
                                  {/if}
                                  {if $oneEvent.content_payments}
                                      <li><a id="payment--link" href="#payment">{$core->get_Lang('Payment Guide')}</a></li>
                                  {/if}
                                  {if $oneEvent.content_checkin}
                                      <li><a id="checkin--link" href="#checkin">{$core->get_Lang('instructions to check in')}</a></li>
                                  {/if}
                                  {if $album}
                                      <li><a id="image--link" href="#image">{$core->get_Lang('Image Gallery')}</a></li>
                                  {/if}
                                  {if $listSponsor}
                                 <li><a id="sponsor--link" href="#sponsor">{$core->get_Lang('Sponsor')}</a></li>
                                  {/if}
                                  {if !empty($content_news)}
                                 <li class=""><a id="news--link"  href="#news">{$core->get_Lang('Event News')}</a></li>
                                 {/if}
                                 <li><a id="contactinfo--link" href="#contactinfo">{$core->get_Lang('Contact information')}</a></li>
                                 <li><a id="faqs--link" class="hidden" href="#faqs">{$core->get_Lang('Frequently asked Questions')}</a></li>
                              </ul>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-9 col-md-pull-3">
                        <article class="NewsContent">
                           <div class="content list_tab" >
                              <div id="overview" class="over_view">
                                 <h2 class="title_section">
                                    {$core->get_Lang('Overview event')}
                                 </h2>
                                 <div class="IntroView">
                                    {$oneEvent.intro|html_entity_decode}
                                 </div>
                                 <div class="images_box" style="display: none">
                                    {$core->getBlock('jssor_images')}
                                 </div>
                              </div>
                              <div id="participants" class="participantsBox">
                                {if !empty($oneEvent.content_participants)}
                                 <h2 class="title_section">
                                    {$core->get_Lang('Participants')}
                                 </h2>
                                 <div class="IntroBox">
                                     {$oneEvent.content_participants|html_entity_decode}
                                 </div>
                                 {/if}
                              </div>
                              {if $schedule}
                              <div id="ContentEvent" class="calendar_accordion">
                                 <h2 class="title_section">
                                    {$core->get_Lang('Content Event')}
                                    <a class="more_news view_all" href="javascript:void(0);" title="{$core->get_Lang('View all')}">{$core->get_Lang('View all')}</a>
                                 </h2>
                                 <div class="accordion" id="accordionCalendar">
                                    {foreach name=k key=k item=item from=$schedule}
                                    <div class="card">
                                       <div class="card-header" id="day_{$k}">
                                          <h3 class="title"> 
                                             <a {if $smarty.foreach.k.first}{else}class="collapsed"{/if} data-parent="#accordionCalendar"  data-toggle="collapse" data-target="#collapseday_{$k}" aria-expanded="{if $smarty.foreach.k.first}true{else}false{/if}" aria-controls="collapseday_{$k}" title="{$item.title}">
                                             {$item.title}
                                             <span class="date">{$clsISO->convertTimeToTextFull($item.time)}</span>
                                             </a>
                                          </h3>
                                       </div>
                                       <div id="collapseday_{$k}" class="collapse {if $smarty.foreach.k.first}in{/if}" aria-labelledby="day_{$k}" data-parent="#accordionCalendar">
                                          <div class="card-body">
                                             <div class="detail tinymce_Content">
                                                {$item.intro|html_entity_decode}
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    {/foreach}
                                 </div>
                              </div>
                              {/if}
                               {if !empty($listYield)}
                                <div id="registration" class="register_event_box">
                                 <h2 class="title_section">
                                    {$core->get_Lang('registration')}
                                 </h2>
                                 <div class="registrationBox">
                                    <p class="timing"> {$core->get_Lang('Deadline')}: <span>{$oneEvent.due_date_register|date_format:"%d/%m/%Y"}</span></p>
                                     <div class="listTicket accordion" id="accordionTick">
                                         <form action="" method="post" class="form_event" id="register_form">
                                             {section name=i loop=$listYield}
                                                 {assign var=info_price value=$listYield[i].info_price|json_decode:true}
                                                 <div class="card">
                                                     <div class="Item card-header" id="tick_{$listYield[i].yield_id}">
                                                         <div class="TopItem">
                                                             <div class="AboutLeft {if $smarty.section.i.first}{else}collapsed{/if}"
                                                                  data-parent="#accordionTick" data-toggle="collapse"
                                                                  data-target="#collapseday_{$listYield[i].yield_id}"
                                                                  aria-expanded="{if $smarty.section.i.first}true{else}false{/if}"
                                                                  aria-controls="collapseday_{$listYield[i].yield_id}">
                                                                 <input type="checkbox" id="join_{$listYield[i].yield_id}" class="yield_id" name="yield_id"
                                                                        value="{$listYield[i].yield_id}"
                                                                        {if $smarty.section.i.first}checked{/if}>
                                                                 <label for="join_{$listYield[i].yield_id}" class="titleTicket panel-title">{$listYield[i].title}</label>

                                                             </div>
                                                             <div class="NumberTicket">
                                                                 <p class="PriceTick">{if $info_price.standard.$currency_id eq 0}{$core->get_Lang('Free')}{else}{$info_price.standard.$currency_id|number_format:0:",":"."} {$core->get_Lang('đ')}{/if}</p>
                                                                 <p class="remainingTicket">
                                                                     {if $listYield[i].ticket_remaining gt 0 && $oneEvent.due_date_register gte $now_day}
                                                                         <span>{$core->get_Lang('Only')}:</span> {$listYield[i].ticket_remaining} {$core->get_Lang('ticket(s)')}
                                                                         {else}
                                                                         {$core->get_Lang('Sold out')}
                                                                     {/if}

                                                                 </p>
                                                             </div>
                                                         </div>
                                                         <div class="intro collapse {if $smarty.section.i.first}in{/if}"
                                                              aria-labelledby="tick_{$listYield[i].yield_id}"
                                                              data-parent="#accordionTick"
                                                              id="collapseday_{$listYield[i].yield_id}">
                                                             {$listYield[i].intro|html_entity_decode}
                                                         </div>
                                                     </div>
                                                 </div>
                                             {/section}
                                             <div class="BookingBox">
                                                 <img src="{$URL_IMAGES}/payment.png">
                                                 
                                                 <div class="BookingRight">
                                                    
                                                     <a href="javascript:void(0);"
                                                        class="buttonBookTicket btnRegisterJoin {if $oneEvent.due_date_register lt $now_day}pointer-events-none opacity-05{/if}">{$core->get_Lang('Book ticket now')}</a>
                                                        
                                                 </div>
                                                 
                                             </div>
                                         </form>
                                     </div>
                                 </div>
                              </div>
                               {/if}
                               {if !empty($sponsor_package)}
                                   <div id="sponsorRegistration" class="SponsorRegistrationBox">
                                       <h2 class="title_section">
                                           {$core->get_Lang('Sponsor Registration')}
                                       </h2>
                                       <div class="registrationBox">
                                           <p class="timing"> {$core->get_Lang('Deadline')}: <span>{$oneEvent.due_date_sponsor|date_format:"%d/%m/%Y"}</span></p>
                                           <div class="ListPack panel-group" id="accordion">
                                               <form action="" method="post" class="form_event" id="sponsor_package_form">
                                                   <input type="hidden" name="event_id" value="{$event_id}">
                                                   {foreach item=item key=key name=stt from=$sponsor_package}
                                                       <div class="Item panel ">
                                                           <div class="TopItem panel-heading">
                                                               <div class="PackLeft" data-parent="#accordion"
                                                                    data-toggle="collapse"
                                                                    data-target="#collapse{$key}"
                                                                    aria-controls="collapse{$key}">
                                                                   <input type="radio" id="input_sponsor{$key}" name="sponsor_package" value="{$key}"
                                                                          {if $smarty.foreach.stt.first}checked{/if}>
                                                                   <label for="input_sponsor{$key}" class="titlePack panel-title cursor">{$item.title}</label>
                                                               </div>
                                                               <div class="PackRight">
                                                                   <p class="pricePack">{if $item.price eq 0}{$core->get_Lang('Free')}{else}{$item.price|number_format:0:",":"."} {$core->get_Lang('đ')}{/if}</p>
                                                                   <p class="remainingPacket">
                                                                       {if $item.slot_remaining gt 0 && $oneEvent.due_date_sponsor gte $now_day}
                                                                           <span>{$core->get_Lang('Only')}:</span> {$item.slot_remaining} {$core->get_Lang('ticket(s)')}
                                                                       {else}
                                                                           {$core->get_Lang('Sold out')}
                                                                       {/if}
                                                                   </p>

                                                               </div>
                                                           </div>
                                                           <div class="IntroPack panel-collapse collapse {if $smarty.foreach.stt.first}in{/if}"
                                                                id="collapse{$key}">
                                                               <div class="content">
                                                                   {$item.intro|html_entity_decode}
                                                               </div>
                                                               {if $item.slot_remaining}
                                                                   <a class="bookingPack btnRegisterSponsor {if $oneEvent.due_date_sponsor lt $now_day}pointer-events-none opacity-05{/if}"
                                                                      href="javascript:void(0);"
                                                                      title="{$core->get_Lang('Choose a sponsorship package')}">{$core->get_Lang('Choose a sponsorship package')}</a>
                                                               {/if}

                                                           </div>
                                                       </div>
                                                   {/foreach}
                                               </form>
                                           </div>
                                       </div>
                                   </div>
                               {/if}
                              <div id="payment" class="PaymentBox">
                                {if !empty($oneEvent.content_payments)}
                                 <h2 class="title_section">
                                    {$core->get_Lang('Payment Guide')}
                                 </h2>
                                 <div class="IntroBox">
                                     {$oneEvent.content_payments|html_entity_decode}
                                 </div>
                                 {/if}
                              </div>
                              <div id="checkin" class="CheckinBox">
                                 {if !empty($oneEvent.content_checkin)}
                                 <h2 class="title_section">
                                    {$core->get_Lang('instructions to check in')}
                                 </h2>
                                 <div class="IntroBox">
                                     {$oneEvent.content_checkin|html_entity_decode}
                                 </div>
                                 {/if}
                              </div>
                               {if $album}
                                   <div id="image" class="ImageBox">
                                       <h2 class="title_section">
                                           {$core->get_Lang('Image Gallery')}
                                       </h2>
                                       <div class="listImage">
                                           {if $clsISO->getBrowser() eq 'computer'}
                                               <div class="row">
                                                   {foreach item=item key=key from=$album}
                                                       <div class="col-md-4">
                                                           <img class="img100" alt="{$item.title}" src="{$item.url_img}">
                                                       </div>
                                                   {/foreach}
                                               </div>
                                                {*<div class="shadow"></div>
                                                <div class="showmore">{$core->get_Lang('Show more')}</div>*}
                                                {literal}
											   <script type="text/javascript">
													$(function() {
														$('.listImage').expandable({
															height: 625
														});
													   /* $('.description2').expandable({
															height: 210,
															expand_responsive : 960,
															no_less: true,
															offset: 30
														});*/
													});
												</script>
												{/literal}
                                           {else}
                                               <div class="owl_image owl-carousel">
                                                   {foreach item=item key=key from=$album}
                                                       <img class="img100" alt="{$item.title}" src="{$item.url_img}">
                                                   {/foreach}
                                               </div>
                                           {/if}

                                       </div>
                                   </div>
                                   
                               {/if}

                               {if $listSponsor}
                                   <div id="sponsor" class="SponsorBox">
                                       <h2 class="title_section">{$core->get_Lang('Sponsor')}</h2>
                                       <div class="ListSponsor">
                                           {if $clsISO->getBrowser() eq 'computer'}
                                               {foreach key=key item=item from=$listSponsored}
                                                   <div class="{$item.slug}">
                                                       <p class="titleBoxSponsor">{$item.title}</p>
                                                       {section name=i loop=$listSponsor}
                                                           {if $listSponsor[i].sponsor_package_id eq $key && !empty($listSponsor[i].image)}
                                                               <img src="{$listSponsor[i].image}"
                                                                    alt="{$listSponsor[i].title}">
                                                           {/if}
                                                       {/section}
                                                   </div>
                                               {/foreach}
                                           {else}
                                               {foreach key=key item=item from=$listSponsored}
                                                   <div class="{$item.slug}">
                                                       <p class="titleBoxSponsor">{$item.title}</p>
                                                       <div class="owl_sponsor owl-carousel">
                                                           {section name=i loop=$listSponsor}
                                                               {if $listSponsor[i].sponsor_package_id eq $key && !empty($listSponsor[i].image)}
                                                                   <img src="{$listSponsor[i].image}"
                                                                        alt="{$listSponsor[i].title}">
                                                               {/if}
                                                           {/section}
                                                       </div>
                                                   </div>
                                               {/foreach}
                                           {/if}
                                       </div>
                                   </div>
                               {/if}
                              <div id="news" class="EventNewsBox">
                              {if !empty($content_news)}
                              	<h2 class="title_section">
                                    {$core->get_Lang('Event News')}
                                 </h2>
                                 <div class="listNews">
                                     <div class="owl-carousel owl_news">
                                         {foreach item=item key=key from=$content_news}
                                             {assign var=link_new value=$clsISO->getLinkEventNews($item.slug,$key,$event_id)}
                                             <div class="Item">
                                                 <a href="{$link_new}" title="{$item.title}"> <img src="{$item.image}" alt="{$item.title}" class="img100"></a>
                                                 <div class="body">
                                                     <p class="regdate"><span class="text-uppercase color_main">{$item.user_id_name} <span class="midde_span">|</span> </span>{$item.upd_date|date_format:"%d/%m/%Y"}</p>
                                                     <h3 class="title">
                                                         <a class="limit_2line" href="{$link_new}" title="{$item.title}">{$item.title}</a>
                                                     </h3>
                                                     <div class="intro limit_3line">{$item.intro|html_entity_decode|strip_tags}</div>
                                                     <a href="javascript:void(0)" title="" class="readmoreNews">{$core->get_Lang('read more')} <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                                 </div>
                                             </div>
                                         {/foreach}
                                     </div>
                                 </div>
                                 {/if}
                              </div>
                              <div id="contactinfo" class="InforEventBox">
                              	<h2 class="title_section">
                                    {$core->get_Lang('Contact information')}
                                 </h2>
                                 <div class="eventInfor">
									<p class="phone">
										<i class="fa fa-phone w_25px" aria-hidden="true"></i> <span><strong>{$core->get_Lang('Phone')}: </strong> <a href="tel:{$more_information.contact_phone}" title="{$more_information.contact_phone}" class="color_1c1c1c">{$more_information.contact_phone}</a></span>
									</p>
									<p class="email mb0">
										<i class="fa fa-envelope-o w_25px" aria-hidden="true"></i> <span><strong>{$core->get_Lang('Email')}: </strong> <a href="mailto:{$more_information.contact_email}" title="{$more_information.contact_email}" class="color_1c1c1c">{$more_information.contact_email}</a></span>
									</p>
									</div>
								 <div class="map ">
									 <div class="frame_map">
										 <iframe frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0" src="https://maps.google.it/maps?q={$oneEvent.address}&output=embed"></iframe>
									 </div>
								 </div>
                              </div>
                              <div id="faqs" class="FAQsBox hidden">
                              	<h2 class="title_section">
                                    {$core->get_Lang('Frequently asked Questions')}
                                 </h2>
                               <div class="accordion" id="accordionFAQ">
                                    {section name=i loop=8}
                                    <div class="card">
                                       <div class="card-header" id="day_{$smarty.section.i.iteration}">
                                          <h3 class="title">
                                             <a {if $smarty.section.i.first}{else}class="collapsed"{/if} data-parent="#accordionFAQ"  data-toggle="collapse" data-target="#collapseday_{$smarty.section.i.iteration}" aria-expanded="{if $smarty.section.i.first}true{else}false{/if}" aria-controls="collapseday_{$smarty.section.i.iteration}" title="">
                                             Lorem Ipsum is simply dummy text of the printing and typesetting industry
                                             </a>
                                          </h3>
                                       </div>
                                       <div id="collapseday_{$smarty.section.i.iteration}" class="contentFaq collapse {if $smarty.section.i.first}in{/if}" aria-labelledby="day_{$smarty.section.i.iteration}" data-parent="#accordionFAQ">
                                          <div class="card-body">
                                             <div class="detail tinymce_Content">
                                                abcc
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    {/section}
                                 </div>
                              </div>
                              {if $clsISO->getBrowser() ne 'computer'}
                              <div class="submitted visible-xs">
                                 <p class="shareText">{$core->get_Lang('Share')}</p>
                                 <ul class="list_social_footer list-style-none">
                                    <li>
                                       <a class="facebook" href="javascript:void(0);" rel="nofollow" onclick="javascript:generic_social_share('https://www.facebook.com/sharer/sharer.php?u={$DOMAIN_NAME}{$link_event}&title={$oneEvent.title}');" title="{$core->get_Lang('Facebook')}">
                                       <i class="fa fa-facebook" aria-hidden="true"></i>
                                       </a>
                                    </li>
                                    <li>
                                       <a class="twitter"  href="javascript:void(0);" rel="nofollow" onclick="javascript:generic_social_share('https://twitter.com/home?status={$DOMAIN_NAME}{$link_event}');" title="{$core->get_Lang('Twitter')}">
                                       <i class="fa fa-twitter" aria-hidden="true"></i>
                                       </a>
                                    </li>
                                    <li>
                                       <a class="pinterest"  href="javascript:void(0);" rel="nofollow" onclick="javascript:generic_social_share('/https://www.linkedin.com/shareArticle?mini=true&url={$DOMAIN_NAME}{$link_event}');" title="{$core->get_Lang('Linkedin')}">
                                       <i class="fa fa-linkedin" aria-hidden="true"></i>
                                       </a>
                                    </li>
                                 </ul>
                              </div>
                              {/if}
                           </div>
                        </article>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
   var event_id = '{$event_id}';
   var registration = '{$clsISO->getLink('registration')}';
   var registration_sponsor = '{$clsISO->getLink('registration_sponsor')}';
   var Max = '{$core->get_Lang('Max')}';
   var alert_sponsor = '{$core->get_Lang('Please select 1 of the sponsorship packages')}!';
   var alert_join = '{$core->get_Lang('Please select minimum 1 event ticket')}!';
   var Warning = '{$core->get_Lang('Warning')}';
   var ticket = '{$core->get_Lang('ticket(s)')}';
   var Notification = '{$core->get_Lang('Notification')}';
   var AlertExist = '{$core->get_Lang('Your organization sponsored this event. Please sponsor another event')}.';
</script>
<script src="{$URL_JS}/jquery-confirm.min.js?v={$upd_version}"></script>
{literal}
<script type="text/javascript">
    var $windown_w = $(window).width();
    if ($windown_w > 1200) {
        $(document).on("scroll", onScroll);

        function onScroll(event) {
            var scrollPos = $(document).scrollTop();
            $('#tabsk > ul li a').each(function () {
                var currLink = $(this);
                var refElement = $(currLink.attr("href"));
                if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
                    $('#tabsk > ul li a').removeClass("active");
                    currLink.addClass("active");
                } else {
                    currLink.removeClass("active");
                }
            });
        }
    }

    function goToByScroll(id) {
        id = id.replace("--link", "");
        $('html,body').animate({
                scrollTop: $("#" + id).offset().top - 150
            },
            'slow');
    }

    $("#tabsk > ul li a").click(function (e) {
        e.preventDefault();
        goToByScroll($(this).attr("id"));
    });
    $(".bookingBox a").click(function (e) {
        e.preventDefault();
        goToByScroll($(this).attr("id"));
    });
    //	 $.lockfixed(".BookEvent", {offset: {top:100,bottom:500}});

    if ($windown_w > 1200) {
        $.lockfixed(".menuTabRight", {offset: {top: 110, bottom: 700}});
        $.lockfixed(".submitted", {offset: {top: 110, bottom: 500}});
    }

    $(function () {
//        $('.IntroPack .content').each(function () {
//            var $_this = $(this);
//            if ($_this.height() > 50) {
//                $_this.css("height", "50px");
//                $_this.closest(".IntroPack").find(".read__more").show();
//            } else {
//                $_this.closest(".IntroPack").find(".read__more").hide();
//                $_this.closest(".IntroPack").find(".content").removeClass("bg_transparent");
//            }
//        });
//        $(document).on("click", ".IntroPack .read__more", function () {
//            var $_this = $(this);
//            if (!$_this.hasClass("less")) {
//                $_this.addClass("less");
//                $_this.closest(".IntroPack").find(".content").css("height", "auto");
//                $_this.html('{/literal}{$core->get_Lang("Less more")}{literal}');
//                $_this.closest(".IntroPack").find(".content").removeClass("bg_transparent");
//            } else {
//                $_this.removeClass("less");
//                $_this.closest(".IntroPack").find(".content").css("height", "50px");
//                $_this.closest(".IntroPack").find(".content").addClass("bg_transparent");
//                $_this.html('{/literal}{$core->get_Lang("Show more")}{literal}');
//            }
//        });
        $(document).on('change','.number_ticket',function () {
            var $_this = $(this),
                yield_id = $_this.attr('yield_id'),
                max = parseInt(this.max),
                 min = parseInt(this.min);
            if (parseInt(this.value) < min) {
                this.value = min;
            }
            if (this.value==''){
                this.value = 0;
            }
            if (parseInt(this.value) > max) {
                $.alert({
                    title: Warning,
                    type: 'red',
                    typeAnimated: true,
                    content: Max+': '+max+' '+ticket,
                });
                this.value = max;
            }
        })
        if ($('.owl_sponsor').length > 0) {
            var $owl = $('.owl_sponsor');
            $owl.owlCarousel({
                loop: true,
                nav: false,
                dots: false,
                margin: 20,
                autoplay: true,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 3,
                    },
                    600: {
                        items: 3,
                    },
                    1024: {
                        items: 4,
                    }
                }
            });
        }
		if ($('.owl_image').length > 0) {
            var $owl = $('.owl_image');
            $owl.owlCarousel({
                loop: true,
                nav: false,
                dots: false,
				center:true,
                margin: 5,
                autoplay: true,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    600: {
                        items: 1,
                    },
                    1024: {
                        items: 4,
                    }
                }
            });
        }
		if ($('.owl_news').length > 0) {
            var $owl = $('.owl_news');
            $owl.owlCarousel({
                loop: true,
                nav: true,
                dots: false,
                margin: 30,
                autoplay: false,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    600: {
                        items: 1,
                    },
                    992: {
                        items: 2,
                        nav: true
                    }
                }
            });
        }
        $('.calendar_accordion .view_all').on('click', function () {
            $('#accordionCalendar .collapse').collapse('show');
            $('#accordionCalendar .title .collapsed').removeClass('collapsed');
        });
        $('#accordionRegister .collapse').on('show.bs.collapse', function () {
            $('#accordionRegister .collapse').not(this).collapse('hide');
        });
        $(document).on('click', '.btnRegisterJoin', function () {
            /*alert('Đã hết hạn đăng ký!');
            return false;*/
            if (!$('.yield_id:checked').length) {
                alert(alert_join);
                return false;
            }
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajRegisterJoinStepOne',
                data: {register_join: getCheckBoxValueByClass('yield_id'), 'event_id': event_id},
                dataType: 'html',
                success: function (html) {
                    window.location.href = registration;
                }
            });
        });

        function getCheckBoxValueByClass(classname) {
            var names = [];
            $('.' + classname + ':checked').each(function () {
                names.push(this.value);
            });
            return names;
        }

        $(document).on('click', '.btnRegisterSponsor', function () {
            if (!$("input[name='sponsor_package']").is(':checked')) {
                alert(alert_sponsor);
                return false;
            }
            $.ajax({
                type: 'POST',
                url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajRegisterSponsorStepOne',
                data: {'event_id': event_id, sponsor_package_id: $("input[name='sponsor_package']:checked").val()},
                dataType: 'json',
                success: function (res) {
                    if(res.msg=='exist'){
                        $.alert({
                            title: Notification,
                            height:100,
                            type: 'red',
                            typeAnimated: true,
                            content: AlertExist,
                        });
                        return false;
                    }else{
                        window.location.href = path_ajax_script + registration_sponsor;
                    }

                }
            });
        });
    });
</script>
{/literal}