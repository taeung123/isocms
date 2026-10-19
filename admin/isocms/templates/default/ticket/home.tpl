<div class="container-ticket">
	<div class="div_information_bar">
		<div class="h_information_bar" data-submenu="sub-menu-information">
			<span></span>
			<span></span>
			<span></span>
			<span></span>
		</div>
		<div class="role_session bold font-14">{__('Help center')}</div>
		<div class="sub-menu-information">
			<ul>
				<li class="py-2 {if $act eq 'home'}bg-success{/if}"><a href="{$clsISO->getLinkTicket('ticket')}">{makeIMO('support',__('Help center'),'font-20')}</a></li>
				
				<li class="py-2 {if $act eq 'list_ticket'}bg-success{/if}"><a class="a_list_ticket" href="{$clsISO->getLinkTicket('list_ticket')}">{makeIMO('format_list_bulleted',__('My ticket'),'font-20')}<span class="badge-unread-ticket"></span></a></li>
				<li class="py-2 {if $act eq 'my_ticket'}bg-success{/if}"><a href="{$clsISO->getLinkTicket('my_ticket')}">{makeIMO('live_help',__('Request support'),'font-20')}</a></li>
			</ul>
		</div>	
	</div>
	<div class="d-flex">
		<div class="ticket-menu-left">
			<ul>
				<li {if $act eq 'home'}class="active"{/if}><a href="{$clsISO->getLinkTicket('ticket')}">{makeIMO('support',__('Help center'),'font-20')}</a></li>
				
				<li {if $act eq 'list_ticket'}class="active"{/if}><a class="a_list_ticket" href="{$clsISO->getLinkTicket('list_ticket')}">{makeIMO('format_list_bulleted',__('My ticket'),'font-20')}<span class="badge-unread-ticket"></span></a></li>
				<li {if $act eq 'my_ticket'}class="active"{/if}><a href="{$clsISO->getLinkTicket('my_ticket')}">{makeIMO('live_help',__('Request support'),'font-20')}</a></li>
			</ul>
		</div>
		<div class="ticket-content-right">
			<p class="text-center what-can-do">{__('What can we do for you')}</p>
			<div class="input-group-search-help mt-4"><input type="text" class="input-search-help" placeholder="{__('The problem you have')}"></div>
			<div class="holder-content-help">
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
							<div id="collapse{$item.news_id}" class="collapse {if $item.news_id eq 191}show{/if}" data-parent="#accordion">
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
				<div class="mt-3 box-not-satisfy">
					<div class="font-15 d-flex" style="align-items: center">
						<div class="d-flex pr-2" style="justify-content: center">
							<div class="m-avatar m-avatar-bg m-avatar-40 bold font-20 no-border" style="background: #007AB3; color: #fff;">{makeIM('headset_mic')}</div>
						</div>
					<strong class="mr-2">{__('Content still not satisfy you')}</strong> {__('Contact our support team')}</div>
					<div class="font-14"><a class="d-flex" style="align-items: center" href="{$clsISO->getLinkTicket('my_ticket')}">{__('Contact now')}{makeIMO('east','','ml-2')}</a></div>
				</div>
			</div>
			
		</div>		
	</div>
</div>