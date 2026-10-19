<section class="destination-easy"> 
	<h2 class="title">{$core->get_Lang('Information')}</h2> 
		<ul> 
			{section name=i loop=$lstPage}
      {assign var = title value = $clsPage->getTitle($lstPage[i].page_id)}
			<li><a  href="{$clsPage->getLink($lstPage[i].page_id)}" title="{$title}">{$title}</a></li>
			{/section}
			<li><a href="{$extLang}/faqs.html" title="{$core->get_Lang('FAQs')}">{$core->get_Lang('FAQs')}</a></li>  
			<li><a href="{$extLang}/sitemap.html" title="{$core->get_Lang('Sitemap')}">{$core->get_Lang('Sitemap')}</a></li>
		</ul> 
</section>
