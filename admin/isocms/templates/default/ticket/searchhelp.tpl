<p class="bold color-444">{__('Browse help topics')}</p>
<div id="accordion">
	{foreach from=$listDocs item=item name=item}
		{if !empty($item.listItems)}
		<div class="card card-ticket">
			<div class="card-header">
			  <a class="card-link" data-toggle="collapse" href="#collapse{$item.news_id}">
				{$item.title}
			  </a>
			</div>
			<div id="collapse{$item.news_id}" class="collapse {if $smarty.foreach.item.first}show{/if}" data-parent="#accordion">
			  <div class="card-body">
				<div class="row row5">
					{foreach from=$item.listItems item=items name=items}
					<div class="col-md-3 col-sm-4 col-xs-6">
						<div class="items-help openHelp" href="{$items.link}">
							<img src="{$items.img}" alt="{$items.title}">
							<p class="mb-0">{$items.title}</p>
						</div>
					</div>
					{/foreach}
				</div>
			  </div>
			</div>
		</div>
		{else}
		<div class="card card-ticket">
			<div class="card-header">
			  <a class="card-link openHelp" href="{$item.link}">
				{$item.title}
			  </a>
			</div>
		</div>
		{/if}
	{/foreach}
</div>