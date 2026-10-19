<div class="page_container">
	<div id="contentPage" class="faqsPage">
		<section class="section_box section_faq_top text-center">
			<div class="container">
				<h1 class="titlePage">{$core->get_Lang('FAQs')}</h1>
				{if $clsISO->getModIntro('faqs')}
				<div class="formatTextStandard size20"><h2 class="size20">{$clsISO->getModIntro('faqs')}</h2></div>
				{/if}
			</div>
		</section>
		<section class="section_faq_page mb60">
			<div class="container">
				<div class="col-lg-8 offset-lg-2">
					{if $lstFAQCat && $clsConfiguration->getValue('SiteHasCat_FAQ')}
					<div class="faqs-box-typ1 mvl terms-list" id="faq-box-cat">
						<div class="lnk-bdl">
							<ol class="term-points">
								{section name=i loop=$lstFAQCat}
								<li class="col-st-6"><a class="gotoFAQ" href="javascript:void(0);" rel="{$lstFAQCat[i].faqcat_id}">{$smarty.section.i.index+1}.&nbsp;&nbsp;&nbsp;{$clsFAQCategory->getTitle($lstFAQCat[i].faqcat_id,$lstFAQCat[i])}</a></li>
								{/section}
							</ol>
						</div>
					</div>
					<div class="wrap box-list-faq"> 
						{section name=i loop=$lstFAQCat}
						{assign var = faqcat_id value = $lstFAQCat[i].faqcat_id}
						{assign var = lstFAQ value = $clsFAQ->getListFAQs($faqcat_id)}
						{if $lstFAQ[0].faq_id ne ''}
						<div class="group mb30" id="FAQ-BOX-{$faqcat_id}">
							<h3 class="new-hd-typ3 mb10">{$clsFAQCategory->getTitle($faqcat_id,$lstFAQCat[i])}</h3>
							<div class="accordion" id="accordionFAQs">
								{section name=k loop=$lstFAQ}
								<div class="card">
									<div class="card-header" id="faqs_{$smarty.section.k.iteration}">
										<h3 class="title">
											<a class="collapsed" data-toggle="collapse" data-bs-target="#collapsefaqs_{$smarty.section.k.iteration}" aria-expanded="false" aria-controls="collapsefaqs_{$smarty.section.k.iteration}">
											{$clsFAQ->getTitle($lstFAQ[k].faq_id,$lstFAQ[k])}
											<i class="fa fa-angle-up pull-right"></i>
											</a>
										</h3>
									</div>
									<div id="collapsefaqs_{$smarty.section.k.iteration}" class="collapse" aria-labelledby="faqs_{$smarty.section.k.iteration}">
										<div class="card-body">
											<div class="detail tinymce_Content">
												{$clsFAQ->getContent($lstFAQ[k].faq_id,$lstFAQ[k])}
											</div>
										</div>
									</div>
								</div>
								{/section}
							</div>
						</div>
						{/if}
						{/section} 
					</div>
					{else}
					<div class="accordion" id="accordionFAQs">
						{section name=k loop=$listFAQs}
						<div class="card">
							<div class="card-header" id="faqs_{$smarty.section.k.iteration}">
								<h3 class="title">
									<a class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapsefaqs_{$smarty.section.k.iteration}" aria-expanded="false" aria-controls="collapsefaqs_{$smarty.section.k.iteration}">
									{$clsFAQ->getTitle($listFAQs[k].faq_id,$listFAQs[k])}
									<i class="fa fa-angle-up pull-right"></i>
									</a>
								</h3>
							</div>
							<div id="collapsefaqs_{$smarty.section.k.iteration}" class="collapse" aria-labelledby="faqs_{$smarty.section.k.iteration}">
								<div class="card-body">
									<div class="detail tinymce_Content">
										{$clsFAQ->getContent($listFAQs[k].faq_id,$listFAQs[k])}
									</div>
								</div>
							</div>
						</div>
						{/section}
					</div>
					{/if}
				</div>
			</div>
		</section>
	</div>
</div>

{literal}
	<style>
		.section_faq_top {
			background: #E8F8F8;
		}
	</style>
	{/literal}