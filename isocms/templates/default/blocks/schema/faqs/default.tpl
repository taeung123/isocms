{$clsISO->getTemplate("blocks/schema/component/faqs")}
{literal}
	<script type="application/ld+json">
		{
		  "@context": "https://schema.org",
		  "@type": "QAPage",
		  "mainEntity": [
			  {/literal}
			  {if $lstFAQCat && $clsConfiguration->getValue('SiteHasCat_FAQ')}
				  {section name=i loop=$lstFAQCat}
						{assign var = faqcat_id value = $lstFAQCat[i].faqcat_id}
						{assign var = lstFAQ value = $clsFAQ->getListFAQs($faqcat_id)}
						{if $lstFAQ[0].faq_id ne ''}
						{section name=k loop=$lstFAQ}{literal}
						  {
							"@type": "Question",
							"name": "{/literal}{$clsFAQ->getTitle($lstFAQ[k].faq_id,$lstFAQ[i])}{literal}",
							"acceptedAnswer": {
							  "@type": "Answer",
							  "text": "{/literal}{$clsFAQ->getContent($lstFAQ[k].faq_id,$lstFAQ[k])|strip_tags|strip_tags|replace:'"':'\''}{literal}"
							}
						  }{/literal}{if !$smarty.section.k.last}{literal},{/literal}{/if}
				  {/section}{/if}{/section}
			  {else}
				  {section name=k loop=$listFAQs}
					  {literal}
						{
							"@type": "Question",
							"name": "{/literal}{$clsFAQ->getTitle($listFAQs[k].faq_id,$listFAQs[k])}{literal}",
							"acceptedAnswer": {
							  "@type": "Answer",
							  "text": "{/literal}{$clsFAQ->getContent($listFAQs[k].faq_id,$listFAQs[k])|strip_tags|replace:'"':'\''}{literal}"
							}
						  }{/literal}{if !$smarty.section.k.last}{literal},{/literal}{/if}
				  {/section}
			  {/if}{literal}
		  ]
		}
    </script>
{/literal}