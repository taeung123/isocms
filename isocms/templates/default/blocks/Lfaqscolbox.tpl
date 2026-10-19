{if $lstFaqs}
<div class="box__Faqs">
    <h2 class="box__Faqs--title title_section text_bold"><a href="{$clsISO->getLink('faqs')}" class="color_1c1c1c" title="{$core->get_Lang('FAQs')}"><span>{$core->get_Lang('FAQs')}</span></a></h2>
	<ul class="list__Faqs list__item list_style_none">
		{section name=i loop=$lstFaqs}
		{assign var=titleFaq value=$clsFAQ->getTitle($lstFaqs[i].faq_id,$lstFaqs[i])}
		<li class="item"><a class="color_1c1c1c" title="{$titleFaq}" href="{$clsISO->getLink('faqs')}#{$clsFAQ->getSlug($lstFaqs[i].faq_id,$lstFaqs[i])}">{$titleFaq}</a></li>
		{/section}
	</ul>
    <a href="{$clsISO->getLink('faqs')}" class="more_faqs d-block text-center color_5f93e7" target="_blank">{$core->get_Lang('View more')}</a>
</div>
{/if}