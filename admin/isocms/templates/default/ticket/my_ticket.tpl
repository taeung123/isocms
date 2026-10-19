<div class="container-ticket mb-0">
	<div class="div_information_bar">
		<div class="h_information_bar" data-submenu="sub-menu-information">
			<span></span>
			<span></span>
			<span></span>
			<span></span>
		</div>
		<div class="role_session bold font-14">{__('Request support')}</div>
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
		<div class="ticket-content-right my_ticket">
			<div class="ticket_breadcrumb">{makeIMO('arrow_back_ios','','mr-2')} {__('Request support')}</div>
			<div class="form_my_ticket">
				<p class="text-center what-can-do my_ticket">{__('What can we do for you')}</p>
				<hr>
				<form action="">
					<div class="form-group">
						<label for="">{__('Let us your question')}</label>
						<input type="text" class="form-control required" name="title_ticket" placeholder="{__('Please enter your question title')}">
					</div>
					<div class="form-group">
						<label for="">{__('Explain the problem you are having')}</label>
						<textarea class="form-control isoTextArea required" id="content_ticket" name="content_ticket" placeholder="{__('Please enter your content')}"></textarea>
					</div>
					{$getInfoCatTicket = $clsISO->getInfoCatTicket()}
					<div class="form-group">
						<label for="">{__('Category')}</label>
						<select name="cat_ticket" class="form-control required">
							<option value="">{__('Select')}</option>
							{foreach $getInfoCatTicket as $k=>$v}
							<option value="{$k}">{$v}</option>
							{/foreach}
						</select>
					</div>
					<div class="form-group">
						<label for="">{__('Other Category')}</label>
						<input type="text" class="form-control" name="other_cat_ticket" placeholder="{__('Other')}...">
					</div>
					<div class="form-group text-center">
						<a href="javascript:void(0)" class="btn btn-primary mt-3 submitMyTicket">{__('Send request')}</a>
					</div>
				</form>
			</div>
		</div>		
	</div>
</div>