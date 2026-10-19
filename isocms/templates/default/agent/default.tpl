<div class="page_container">
    <div class="banner">
		{$core->getBlock('slider2019')}
    </div>
	<div class="breadcrumb-main bg_fff">
        <div class="container">
            <ol class="breadcrumb bg_fff hidden-xs mt0" itemscope itemtype="http://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" >
					<a itemtype="http://schema.org/Thing" itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemtype="http://schema.org/Thing" itemprop="item" href="{$curl}" title="{$core->get_Lang('Blog')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Travel Agent')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
            </ol>
        </div>
    </div>
    <div id="contentPage" class="pageAgentDefault">
		<div class="boxAgent bg_f5f5f5">
			<div class="container">
				<div class="head_text_box text-center">
					<h2 class="size35 text_bold mb15">{$core->get_Lang('Why choose us for your business?')}</h2>
					{assign var = Site_WhyAgent value = Site_WhyAgent_|cat:$_LANG_ID}
					<div class="intro">{$clsConfiguration->getValue($Site_WhyAgent)|html_entity_decode}</div>
				</div>
				<div class="why_agent_box">
					<div class="jcarousel-box owl-carousel owl_slide_3item_container_width">
						<div class="why_agent_item">
							{assign var = Site_WhyAgentTitle_box_1 value = Site_WhyAgentTitle_box_1_|cat:$_LANG_ID}
							{assign var = Site_WhyAgentIntro_box_1 value = Site_WhyAgentIntro_box_1_|cat:$_LANG_ID}
							<img src="{$clsConfiguration->getValue('Site_WhyAgentIcon_box_1')}" alt="{$clsConfiguration->getValue($Site_WhyAgentTitle_box_1)}" width="" height="" />
							<div class="body">
								<h3>{$clsConfiguration->getValue($Site_WhyAgentTitle_box_1)}</h3>
								<div class="intro">{$clsConfiguration->getValue($Site_WhyAgentIntro_box_1)|html_entity_decode}</div>
							</div>
						</div>
						<div class="why_agent_item">
							{assign var = Site_WhyAgentTitle_box_2 value = Site_WhyAgentTitle_box_2_|cat:$_LANG_ID}
							{assign var = Site_WhyAgentIntro_box_2 value = Site_WhyAgentIntro_box_2_|cat:$_LANG_ID}
							<img src="{$clsConfiguration->getValue('Site_WhyAgentIcon_box_2')}" alt="{$clsConfiguration->getValue($Site_WhyAgentTitle_box_1)}" width="" height="" />
							<div class="body">
								<h3>{$clsConfiguration->getValue($Site_WhyAgentTitle_box_2)}</h3>
								<div class="intro">{$clsConfiguration->getValue($Site_WhyAgentIntro_box_2)|html_entity_decode}</div>
							</div>
						</div>
						<div class="why_agent_item">
							{assign var = Site_WhyAgentTitle_box_3 value = Site_WhyAgentTitle_box_3_|cat:$_LANG_ID}
							{assign var = Site_WhyAgentIntro_box_3 value = Site_WhyAgentIntro_box_3_|cat:$_LANG_ID}
							<img src="{$clsConfiguration->getValue('Site_WhyAgentIcon_box_3')}" alt="{$clsConfiguration->getValue($Site_WhyAgentTitle_box_3)}" width="" height="" />
							<div class="body">
								<h3>{$clsConfiguration->getValue($Site_WhyAgentTitle_box_3)}</h3>
								<div class="intro">{$clsConfiguration->getValue($Site_WhyAgentIntro_box_3)|html_entity_decode}</div>
							</div>
						</div>
					</div>
				</div>
				<a href="javascript:void(0);" class="btn_book_now" id="btn_book_now" title="{$core->get_Lang('Register now')}">{$core->get_Lang('Register now')}</a>
			</div>
		</div>
		<div class="boxAgent bg_fff" id="boxOffset">
			<div class="container">
				<div class="head_text_box text-center">
					<h2 class="size35 text_bold mb15">{$core->get_Lang('Choose the form of links')}</h2>
					{assign var = Site_WhyAgent2 value = Site_WhyAgent2_|cat:$_LANG_ID}
					<div class="intro">{$clsConfiguration->getValue($Site_WhyAgent2)|html_entity_decode}</div>
				</div>
				<div class="agent_box_link_register">
					<div class="row">
						<div class="col-sm-6 mb30_767">
							<div class="box_link_register_item">
								{assign var = Site_WhyAgentTitle_box_4 value = Site_WhyAgentTitle_box_4_|cat:$_LANG_ID}
								{assign var = Site_WhyAgentIntro_box_4 value = Site_WhyAgentIntro_box_4_|cat:$_LANG_ID}
								<img src="{$clsConfiguration->getValue('Site_WhyAgentIcon_box_4')}" alt="{$clsConfiguration->getValue($Site_WhyAgentTitle_box_4)}" />
								<div class="body">
									<h3>{$clsConfiguration->getValue($Site_WhyAgentTitle_box_4)}</h3>
									<div class="intro">{$clsConfiguration->getValue($Site_WhyAgentIntro_box_4)|html_entity_decode}</div>
								</div>
								<a class="btn_book_now" href="{$extLang}/travel-agent/signup.html" title="{$core->get_Lang('Register now')}">{$core->get_Lang('Register now')}</a>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="box_link_register_item">
								{assign var = Site_WhyAgentTitle_box_5 value = Site_WhyAgentTitle_box_5_|cat:$_LANG_ID}
								{assign var = Site_WhyAgentIntro_box_5 value = Site_WhyAgentIntro_box_5_|cat:$_LANG_ID}
								<img src="{$clsConfiguration->getValue('Site_WhyAgentIcon_box_5')}" alt="{$clsConfiguration->getValue($Site_WhyAgentTitle_box_4)}" />
								<div class="body">
									<h3>{$clsConfiguration->getValue($Site_WhyAgentTitle_box_5)}</h3>
									<div class="intro">{$clsConfiguration->getValue($Site_WhyAgentIntro_box_5)|html_entity_decode}</div>
								</div>
								<a class="btn_book_now" href="{$extLang}/collaborators/signup.html" title="{$core->get_Lang('Register now')}">{$core->get_Lang('Register now')}</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{literal}
<script type="text/javascript">
$("#btn_book_now").click(function() {
	var s = $(this),
		i = $("#boxOffset").offset().top;
	$("body,html").animate({
		scrollTop: i
	}, 800)
})
</script>
{/literal}