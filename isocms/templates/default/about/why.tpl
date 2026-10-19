<div class="page_container">
	<nav class="breadcrumb-main breadcrumb-{$mod} bg_fff">
		<div class="container">
			<ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="https://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="current">
					<a itemprop="item" href="{$curl}" title="{$core->get_Lang('Why travel with us')}">
						<span itemprop="name" class="reb">{$core->get_Lang('Why travel with us')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
			</ol>
		</div>
	</nav>
	<div id="contentPage" class="aboutPage whyPage pd50_0">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 mb992_30">
					<article class="Aboutcontent bg_fff">
						<h1 class="title">{$core->get_Lang('Why travel with us')}?</h1>
						<dl class="list-group-FAQs">
							{section name=k loop=$lstWhy}
							<dt class="clickFAQ {if $smarty.section.k.first}current{/if}"> <a href="javascript:void(0);">{$clsWhy->getTitle($lstWhy[k].why_id)}</a> <i class="fa {if $smarty.section.k.first}fa-minus-circle{else}fa-plus-circle{/if} pull-right"></i> </dt>
							{assign var=Intro_Why value=$clsWhy->getIntro($lstWhy[k].why_id)}
							{if $Intro_Why}
							<dd id="FAQ-{$lstWhy[k].why_id}" {if !$smarty.section.k.first}style="display:none"{/if}>
								<div class="formatTextStandard"> {$Intro_Why} </div>
							</dd>
							{/if}
							{/section}
						</dl>
					</article>
				</div>
				<aside class="col-lg-4 AboutRight">
					<div class="sticky_fix">
						{$core->getBlock('aboutRight')}											
						{$core->getBlock('company')}
					</div>
				</aside>
			</div>
		</div>
	</div>
</div>
{literal}
<script type="text/javascript">
(function ($) {
    'use strict';

    $(document)
        .off('click.whyFaq', '.list-group-FAQs .clickFAQ')
        .on('click.whyFaq', '.list-group-FAQs .clickFAQ', function (event) {
            event.preventDefault();

            var $current = $(this);
            var $content = $current.next('dd');
            var $icon = $current.find('i.fa');

            if (!$content.length) {
                return false;
            }

            /*
             * Accordion:
             * đóng các mục khác trước khi mở mục hiện tại.
             */
            $('.list-group-FAQs .clickFAQ')
                .not($current)
                .removeClass('current')
                .find('i.fa')
                .removeClass('fa-minus-circle')
                .addClass('fa-plus-circle');

            $('.list-group-FAQs .clickFAQ')
                .not($current)
                .next('dd')
                .stop(true, true)
                .slideUp(250);

            /*
             * Toggle mục đang click.
             */
            if ($content.is(':visible')) {
                $content.stop(true, true).slideUp(250);

                $current.removeClass('current');

                $icon
                    .removeClass('fa-minus-circle')
                    .addClass('fa-plus-circle');
            } else {
                $content.stop(true, true).slideDown(250);

                $current.addClass('current');

                $icon
                    .removeClass('fa-plus-circle')
                    .addClass('fa-minus-circle');
            }

            return false;
        });

})(window.jQuery);
</script>
{/literal}