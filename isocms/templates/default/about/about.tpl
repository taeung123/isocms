{if $page_id}
<div class="page_container">
	{assign var=itemPage value= $clsPage->getOne($page_id,'title,intro')}
	{assign var=titlePage value= $clsPage->getTitle($page_id,$itemPage)}
	{assign var=introPage value= $clsPage->getIntro($page_id,$itemPage)}
	<nav class="breadcrumb-main bg_fff">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="https://schema.org/BreadcrumbList">
						<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
							<a itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
								<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
							<meta itemprop="position" content="1" />
						</li>
						<li  itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="current">
							<a itemprop="item" href="{$curl}" title="{$titlePage}">
								<span itemprop="name" class="reb">{$titlePage}</span></a>
							<meta itemprop="position" content="2" />
						</li>
					</ol>
				</div>
			</div>
		</div>
	</nav>
 	<section class="aboutPage whyPage">
		<div class="container ">
			<div class="row">
				<div class="col-lg-8 offset-lg-2">
					<div class="Aboutcontent">
						<h1 class="titlePage">{$titlePage}</h1>
						<div class="tinymce_Content">{$introPage}</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
{else}
<div class="page_container bg_fff">
	<nav class="breadcrumb-main breadcrumb-cruise bg-default breadcrumb-more bg_fff">
		<div class="container">
			<ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="https://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="active">
					<a itemprop="item" href="{$curl}" title="{$core->get_Lang('About us')}">
						<span itemprop="name" class="reb">{$core->get_Lang('About us')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
			</ol>
		</div>
	</nav>
	<div class="main_about_us">
		<section class="sec_tab_content_about">
			{assign var = SiteIntroBannerAbout value = SiteIntroBannerAbout_|cat:$_LANG_ID}
			<div class="container">
				<h1 class="title_about_us">{$clsConfiguration->getValue($SiteIntroBannerAbout)|html_entity_decode}</h1>
				<div class="box_image_about_top">
					<img src="{$clsConfiguration->getImage("site_about_page_banner",1280,600)}" class="img100" alt="image">
                    {assign var = Link_Youtube_About_Us value = Link_Youtube_About_Us_|cat:$_LANG_ID}
                    {if $clsConfiguration->getValue($Link_Youtube_About_Us)}
					<div class="icon_on_img">
						
						<a href="{$clsConfiguration->getValue($Link_Youtube_About_Us)}" title="video about" data-fancybox="gallery">
							<img src="{$URL_IMAGES}/icon/icon_play_video.png" width="100" height="100" alt="icon">
						</a>
					</div>
                    {/if}
				</div>
				{if $deviceType eq 'phone'}
					<div class="itineraty__box">
						{section name=i loop=$listReasons}
							<div class="itineraty_content">
								<h2 class="title">{$clsYearJourney->getTitle($listReasons[i].year_journey_id,$listReasons[i])}</h2>
								<div class="detail tinymce_Content">
									{$clsYearJourney->getIntro($listReasons[i].year_journey_id,$listReasons[i])|html_entity_decode}
								</div>
							</div>
						{/section}
					</div>
				{else}
					<div class="itineraty__box d-flex flex-wap">
						<div class="box__left">
							<ul class="mt-nav-tabs nav-stacked list_style_none" role="tablist">
								{section name=i loop=$listReasons}
									<li role="presentation">
										<a href="javascript:void(0);" class="nav-link {if $smarty.section.i.index==0}active{/if}" id="tab{$listReasons[i].year_journey_id}" data-bs-toggle="tab" data-bs-target="#tab{$listReasons[i].year_journey_id}-pane" role="tab" aria-controls="tab{$listReasons[i].year_journey_id}-pane" aria-selected="true">
											{$clsYearJourney->getTitle($listReasons[i].year_journey_id,$listReasons[i])}
										</a>
									</li>
								{/section}
							</ul>
						</div>
						<div class="box__right">
							<div class="tab-content"><!-- overview tab content -->
								{section name=i loop=$listReasons}
									<div class="tab-pane fade {if $smarty.section.i.index==0}active show{/if}" id="tab{$listReasons[i].year_journey_id}-pane" role="tabpanel" aria-labelledby="tab{$listReasons[i].year_journey_id}" tabindex="0">
										<div class="detail tinymce_Content">
											{$clsYearJourney->getIntro($listReasons[i].year_journey_id,$listReasons[i])|html_entity_decode}
										</div>
									</div>
								{/section}
							</div>
						</div>
					</div>
				{/if}

			</div>
		</section>

		<section class="achievement">
			<div class="container">
				<h2>{$core->get_Lang('Achievements')}</h2>
				<div class="owl_achievement owl-carousel">
					{section name=i loop=$listYearJourney}
						{assign var=year_journey_id value=$listYearJourney[i].year_journey_id}
						{assign var=introYearJourney value= $clsYearJourney->getIntro($year_journey_id,$listYearJourney[i])}
						<div class="achievement_item">
							<div class="icon">
								<img src="{$clsYearJourney->getImage($year_journey_id,65,65,$listYearJourney[i])}" class="img100" width="65" height="65" alt="icon">
							</div>
							<p class="time">{$listYearJourney[i].business_year}</p>
							<h3>{$clsYearJourney->getTitle($year_journey_id)}</h3>
							<div class="intro">
								<p>{$introYearJourney|html_entity_decode}</p>
							</div>
						</div>
					{/section}

{*					<div class="achievement_item">*}
{*						<div class="icon">*}
{*							<img src="{$URL_IMAGES}/icon/icon_achievement.png" class="img100" width="65" height="65" alt="icon">*}
{*						</div>*}
{*						<p class="time">Tháng 5 năm 2022</p>*}
{*						<h3>Trở thành Công ty Lữ hành nhiều dịch vụ nhất</h3>*}
{*						<div class="intro">*}
{*							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.*}
{*								Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took</p>*}
{*						</div>*}
{*					</div>*}
				</div>
			</div>
		</section>
		{if $listTeam}
			<section class="indispensable_employees">
				<div class="container">
					<h2>{$core->get_Lang('Indispensable employees')}</h2>
					<div class="list_employee">
						<div class="row">
							{section name=i loop=$listTeam}
								<div class="col-lg-3">
									<div class="employee_item">
										<div class="employee_image">
											<img src="{$clsTeam->getImage($listTeam[i].team_id,298,298)}" class="img100 img_scale"
												 width="298" height=298" alt="image">
										</div>
										<div class="employee_item_body">
											<h3 class="employee_name">{$clsTeam->getName($listTeam[i].team_id,$listTeam[i])}</h3>
											<p class="role">{$listTeam[i].position}</p>
											<div class="employee_item_text">
												{$clsTeam->getAbout($listTeam[i].team_id,$listTeam[i])}
											</div>
											<div class="readmore mb0"><a class="venoboxinline vbox-item" data-gall="gall1" data-maxwidth="991px" data-title="inline content" data-vbtype="inline" href="#staff_{$listTeam[i].team_id}">{$core->get_Lang('View More')}</a></div>
										</div>
									</div>
								</div>
							{/section}
						</div>
					</div>
					{section name=i loop=$listTeam}
						<div id="staff_{$listTeam[i].team_id}" class="employee_popup" style="display: none">
							<div class="vbox-close">x</div>
							<div class="employee_item employee_popup">
								<div class="employee_image">
									<img src="{$clsTeam->getImage($listTeam[i].team_id,298,298)}" class="img100" width="298" height="298" alt="{$clsTeam->getName($listTeam[i].team_id,$listTeam[i])}"/>
								</div>
								<div class="employee_item_body">
									<h3 class="employee_name">{$clsTeam->getName($listTeam[i].team_id,$listTeam[i])}</h3>
									<p class="role">{$listTeam[i].position}</p>
									<div class="employee_item_text">
										{$clsTeam->getAbout($listTeam[i].team_id,$listTeam[i])}
									</div>
								</div>
							</div>
						</div>
					{/section}
				</div>
			</section>
		{/if}
	</div>
</div>

{literal}
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			Fancybox.bind("[data-fancybox]", {});
			$('.owl_achievement').owlCarousel({
				loop:true,
				margin:30,
				nav:true,
				center: true,
				dots:false,
				autoplay:false,
				items:3,
				responsive:{
					0:{
						center: true,
						dots:false,
						margin: 20,
						items:1
					},
					767:{
						items:1.5
					},
					992:{
						items:2
					},
					1025:{
						items:3
					}
				}
			});
			$('.employee_item_text').each(function(){
				var $_this = $(this);
				if($_this.height()>84){
					$_this.css("height","84px");
					$_this.closest(".employee_item_body").find(".readmore").show();
				}else{
					$_this.closest(".employee_item_body").find(".readmore").hide();
				}
			});
			$('.venoboxinline').venobox({
				numeratio: false,
				framewidth: '991px',
				frameheight: 'auto',
				border: '0px',
				bgcolor: '#fff',
				titleattr: '',
				infinigall: false,
				htmlNext : '',
				htmlPrev : '',
				htmlClose : '',
			})
		})
		

	</script>
{/literal}
{/if}