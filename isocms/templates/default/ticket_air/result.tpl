<div class="page_container">
	<div class="breadcrumb-main bg_fff">
		<div class="container">
			<ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="http://schema.org/BreadcrumbList">
				<li itemprop="name"><a itemprop="url" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}"><span class="reb">{$core->get_Lang('Home')}</span></a></li>
				<li  itemprop="name" class="current"><a itemprop="url" href="{$curl}" title="{$core->get_Lang('Đặt vé máy bay')}">{$core->get_Lang('Đặt vé máy bay')}</a></li>
			</ol>
		</div>
	</div>
 	<div class="ibe_searchresult_Page">
		{$core->getBlock('find_ticket_air')}
	</div>
</div>