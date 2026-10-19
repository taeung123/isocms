<div class="container-ticket mb-0">
	<div class="div_information_bar">
		<div class="h_information_bar" data-submenu="sub-menu-information">
			<span></span>
			<span></span>
			<span></span>
			<span></span>
		</div>
		<div class="role_session bold font-14">{__('My ticket')}</div>
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
			<div class="ticket_breadcrumb">{makeIMO('arrow_back_ios','','mr-2')} {__('My ticket')}</div>
			<div class="box_list_ticket">
				<div class="box-filter-ticket p-2">
					<div class="input-group group-search-keyword">
						<span class="input-group-text bold no-border" style="background: #fff;flex:0 0 20px">{makeIMO('search','','font-20')}</span>
						<input type="text" class="form-control txtSearchISOCMSTicket no-border filterTicket" data-column="keyword" placeholder="{__('Search')}" />
					</div>
					<div class="dropdown mega-dropdown dropdown-toolbar">
						<a class="btn btn-default dropdown-toggle no-border" style="padding:7px 10px; border-left: 1px solid #D7D7D7!important" title="{__('Advanced search')}">{makeIMO('filter_list','','font-26','')}</a>{*style="transform: translateY(5px);"*}
						<ul class="dropdown-menu dropdown-menu-advanced-search min-w-340 p-3">
							<li class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label for="" class="col-form-label">{__('FromDate')}</label>
										<input type="text" value="" class="form-control datepicker filterTicket" data-column="start_date" placeholder="{__('FromDate')}">
									</div>
									<div class="col-md-6">
										<label for="" class="col-form-label">{__('ToDate')}</label>
										<input type="text" value="" class="form-control datepicker filterTicket" data-column="to_date" placeholder="{__('ToDate')}">
									</div>
								</div>
							</li>
							<li class="form-group">
								{$getInfoCatTicket = $clsISO->getInfoCatTicket()}
								<select name="cat_ticket" class="form-control filterTicket" data-column="cat">
									<option value="">{__('Ticket type')}</option>
									{foreach $getInfoCatTicket as $k=>$v}
									<option value="{$k}">{$v}</option>
									{/foreach}
								</select>
							</li>
							<li class="form-group">
								{$getInfoStatusTicket = $clsISO->getInfoStatusTicket()}
								<select name="status_ticket" class="form-control filterTicket" data-column="status">
									<option value="">{__('Status')}</option>
									<option value="unread">{__('UnRead')}</option>
									{foreach $getInfoStatusTicket as $k=>$v}
									<option value="{$k}">{$v.title}</option>
									{/foreach}
								</select>
							</li>
							<li class="form-group">
								<label for="" class="col-form-label">{__('Creators')}</label>
								<select name="user_id_ticket" class="form-control filterTicket iso-selectbox" data-column="user_id" style="width: 100%">
								{$clsISO->getSelectUserOptions(0, __('All'))}
								</select>
							</li>
						</ul>
					</div>
					{*<div class="input-group ml-2"><button class="btn btn-success filterISOCMSTicket"><i class="fa fa-search"></i></button></div>*}
				</div>
				<div id="holderISOCMSTicketGlobe"></div>
			</div>		
		</div>		
	</div>
</div>