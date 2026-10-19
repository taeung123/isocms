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
				
				<li class="py-2 {if $act eq 'detail_ticket'}bg-success{/if}"><a class="a_list_ticket" href="{$clsISO->getLinkTicket('list_ticket')}">{makeIMO('format_list_bulleted',__('My ticket'),'font-20')}<span class="badge-unread-ticket"></span></a></li>
				<li class="py-2 {if $act eq 'my_ticket'}bg-success{/if}"><a href="{$clsISO->getLinkTicket('my_ticket')}">{makeIMO('live_help',__('Request support'),'font-20')}</a></li>
			</ul>
		</div>	
	</div>
	<div class="d-flex">
		<div class="ticket-menu-left">
			<ul>
				<li {if $act eq 'home'}class="active"{/if}><a href="{$clsISO->getLinkTicket('ticket')}">{makeIMO('support',__('Help center'),'font-20')}</a></li>
				
				<li {if $act eq 'detail_ticket'}class="active"{/if}><a class="a_list_ticket" href="{$clsISO->getLinkTicket('list_ticket')}">{makeIMO('format_list_bulleted',__('My ticket'),'font-20')}<span class="badge-unread-ticket"></span></a></li>
				<li {if $act eq 'my_ticket'}class="active"{/if}><a href="{$clsISO->getLinkTicket('my_ticket')}">{makeIMO('live_help',__('Request support'),'font-20')}</a></li>
			</ul>
		</div>
		<div class="ticket-content-right detail_ticket">
			{*<div class="detail_ticket_breadcrumb">
			<div class="row">
				<div class="col-md-9">
					<div class="row">
						<div class="col-md-2"><a href="{$clsISO->getLinkTicket('list_ticket')}">{makeIMO('arrow_back_ios','','mr-2')} {$clsISO->getLabelStatusTicket($oneTicket.status)}</a></div>
						<div class="col-md-10">
							<span class="color-0479B9">#{$oneTicket.code} [{$clsISO->getCatNameTicket($oneTicket.status,$oneTicket)}]</span>
						</div>
					</div>
				</div>
				<div class="col-md-3 text-right"><a href="javascript:void(0)" class="btn btn-primary btn-submit-ticket">{makeIMO('edit',__('Reply'))}</a></div>
			</div>
			</div>*}
			<div class="detail_ticket_breadcrumb">
				<div class="d-flex flex-wrap">
					<div class="d-flex" style="align-items: flex-start"><a class="back-list-ticket" href="{$clsISO->getLinkTicket('list_ticket')}">{makeIMO('arrow_back_ios','','mr-2 font-20')} </a>{$clsISO->getLabelStatusTicket($oneTicket.status)}</div>
					<div>
						<p class="mb-2"><span class="color-0479B9 mx-2">#{$oneTicket.code} [{$clsISO->getCatNameTicket($oneTicket.cat,$oneTicket)}]</span>- {$oneTicket.title}</p>
						<p class="mb-20 font-13 mb-sm-0">{makeIMO('person','','mr-1','style="transform:translateY(3px)"')}{$full_name}{makeIMO('date_range','','mr-1 ml-3','style="transform:translateY(3px)"')}{__('SendDate')}: {$oneTicket.reg_date|date_format:"%d/%m/%Y %H:%M"}</p>
					</div>
				</div>
				<div class="text-right d-flex" style="align-items: center;">
					<a href="javascript:void(0)" class="btn btn-primary mr-2 btn-submit-ticket reply-ticket" ticket_id="{$ticket_id}">{makeIMO('edit',__('Reply'))}</a>
					{if $oneTicket.status ne '6closed'}<a href="javascript:void(0)" class="btn close-ticket" ticket_id="{$ticket_id}">{makeIMO('close',__('Close'))}</a>
					{else}
					{*<a href="javascript:void(0)" class="btn btn-danger disabled" >{makeIMO('close',__('Closed'))}</a>*}
					{/if}
					
				</div>
			</div>
			<div class="detail_ticket_content">
				{if $oneTicket.status eq '6closed'}<div class="alert alert-warning text-center">{__('This ticket is closed. You can respond to the ticket to open it.')}</div>{/if}
				<form action="" class="form-reply hide" ticket_id="{$ticket_id}" enctype="multipart/form-data">
					<div class="row mb-20">
						<div class="col-md-6">
							<input type="text" class="form-control" name="user_name" value="{$full_name}" readonly placeholder="{__('Name')}">
						</div>
						<div class="col-md-6">
							<input type="text" class="form-control" name="user_email" value="{$oneUser.email}" readonly placeholder="{__('Email')}">
						</div>
					</div>
					<div class="form-group">
						<label for="">{__('Content')}</label>
						<textarea class="form-control isoTextArea required" id="content_reply" name="content_reply" placeholder="{__('Please enter your content')}"></textarea>
					</div>
					<div class="d-flex" style="align-items: center; justify-content: space-between">
						<div class="cif">
						<input class="input-file" id="AddFileAttach" type="file" name="file_attach">
						<label for="AddFileAttach" class="input-file-trigger" id="FileAttachTrigger">{__('SelectFileToUpload')}...</label>
						<span class="file-return" id="returnFileAttach">{__('No files have been selected')}</span>
						</div>
						<a href="javascript:void(0)" class="btn btn-primary btn-submit-ticket submitReplyTicket" ticket_id="{$ticket_id}">{__('Send request')}</a>
					</div>
				</form>
				{foreach $lst_reply as $reply_id=>$oneReply}
				{if $oneReply.user_id}
				<div class="box-user_ticket">
					<div class="box-user_ticket_info">
						<div class="d-flex" style="align-items: center;">
							{if !empty($oneReply.user_avatar)}
							<div class="d-flex pr-2" style="justify-content: center">
								<div class="m-avatar m-avatar-bg m-avatar-40" style="background: url({$oneReply.user_avatar})"></div>
							</div>
							{else}
							<div class="d-flex pr-2" style="justify-content: center">
								<div class="m-avatar m-avatar-bg m-avatar-40 bold font-20" style="background: #D9D9D9">{$oneReply.user_name|substr:0:1}</div>
							</div>	
							{/if}
							<div class="pt-1">
								<p class="mb-0 font-18">{$oneReply.user_name}</p>
								<p class="mb-1 font-12">{$oneReply.user_email}</p>
							</div>
						</div>
						<div class="info_update_ticket font-12"><span>{__('Update')}</span><span>{$oneReply.reg_date|date_format:"%d/%m/%Y (%H:%M)"}</span></div>
					</div>
					<div class="box-ticket_content box-user_ticket_content">
						{$oneReply.content}
						{if $oneReply.file_attach}
							{$file_attach_name = "/"|explode:$oneReply.file_attach|@end}
						<p class="mt-2"> <a href="{$oneReply.file_attach}">{makeIMO('attachment',$file_attach_name)}</a></p>
						{/if}
					</div>
				</div>
				{else}
				<div class="box-admin_ticket">
					<div class="box-admin_ticket_info">
						<div class="d-flex" style="align-items: center;">
							{if 0}
								{if !empty($oneReply.admin_avatar)}
								<div class="d-flex pr-2" style="justify-content: center">
									<div class="m-avatar m-avatar-bg m-avatar-40" style="background: url({$oneReply.admin_avatar})"></div>
								</div>
								{else}
								<div class="d-flex pr-2" style="justify-content: center">
									<div class="m-avatar m-avatar-bg m-avatar-40 bold font-20" style="background: #D9D9D9">{$oneReply.admin_name|substr:0:1}</div>
								</div>	
								{/if}
								<div class="pt-1">
									<p class="mb-0 font-18">{$oneReply.admin_name}</p>
									<p class="mb-1 font-12">{$oneReply.admin_email}</p>
								</div>
							{/if}
							<div class="d-flex pr-2" style="justify-content: center">
								<div class="m-avatar m-avatar-bg m-avatar-40" style="background: url({$URL_IMAGES}/ticket/viso-logo.png)"></div>
							</div>
							<div class="pt-1">
								<p class="mb-0 font-18">VietISO Support Team</p>
								<p class="mb-1 font-12">support@vietiso.com</p>
							</div>
						</div>
						<div class="font-12 text-right">{__('Update')}<br>{$oneReply.reg_date|date_format:"%d/%m/%Y (%H:%M)"}</div>
					</div>
					<div class="box-ticket_content box-admin_ticket_content">
						{$oneReply.content}
						{if $oneReply.file_attach}
							{$file_attach_name = "/"|explode:$oneReply.file_attach|@end}
						<p class="mt-2"> <a href="{$oneReply.file_attach}">{makeIMO('attachment',$file_attach_name)}</a></p>
						{/if}
					</div>
				</div>
				{/if}
				{/foreach}
				{if $oneTicket.user_id}
				<div class="box-user_ticket">
					<div class="box-user_ticket_info">
						<div class="d-flex" style="align-items: center;">
							{if !empty($oneTicket.user_avatar)}
							<div class="d-flex pr-2" style="justify-content: center">
								<div class="m-avatar m-avatar-bg m-avatar-40" style="background: url({$oneTicket.user_avatar})"></div>
							</div>
							{else}
							<div class="d-flex pr-2" style="justify-content: center">
								<div class="m-avatar m-avatar-bg m-avatar-40 bold font-20" style="background: #D9D9D9">{$oneTicket.user_name|substr:0:1}</div>
							</div>	
							{/if}
							<div class="pt-1">
								<p class="mb-0 font-18">{$oneTicket.user_name}</p>
								<p class="mb-1 font-12">{$oneTicket.user_email}</p>
							</div>
						</div>
						<div class="font-12 text-right">{__('Update')}<br>{$oneTicket.reg_date|date_format:"%d/%m/%Y (%H:%M)"}</div>
					</div>
					<div class="box-ticket_content box-user_ticket_content">
						{$oneTicket.content}
					</div>
				</div>
				{else}
				<div class="box-admin_ticket">
					<div class="box-admin_ticket_info">
						<div class="d-flex" style="align-items: center;">
							{if 0}
								{if !empty($oneTicket.admin_avatar)}
								<div class="d-flex pr-2" style="justify-content: center">
									<div class="m-avatar m-avatar-bg m-avatar-40" style="background: url({$oneTicket.admin_avatar})"></div>
								</div>
								{else}
								<div class="d-flex pr-2" style="justify-content: center">
									<div class="m-avatar m-avatar-bg m-avatar-40 bold font-20" style="background: #D9D9D9">{$oneTicket.admin_name|substr:0:1}</div>
								</div>	
								{/if}
								<div class="pt-1">
									<p class="mb-0 font-18">{$oneTicket.admin_name}</p>
									<p class="mb-1 font-12">{$oneTicket.admin_email}</p>
								</div>
							{/if}
							<div class="d-flex pr-2" style="justify-content: center">
								<div class="m-avatar m-avatar-bg m-avatar-40" style="background: url({$URL_IMAGES}/ticket/viso-logo.png)"></div>
							</div>
							<div class="pt-1">
								<p class="mb-0 font-18">VietISO Support Team</p>
								<p class="mb-1 font-12">support@vietiso.com</p>
							</div>
						</div>
						<div class="font-12 text-right">{__('Update')}<br>{$oneTicket.reg_date|date_format:"%d/%m/%Y (%H:%M)"}</div>
					</div>
					<div class="box-ticket_content box-admin_ticket_content">
						{$oneTicket.content}
					</div>
				</div>
				{/if}
			</div>
		</div>
	</div>
</div>
{literal}
<script type="text/javascript">
	$(function(){
		/*custom input file*/
		var AddFileAttach  = document.querySelector( "#AddFileAttach" ),  
			FileAttachTrigger     = document.querySelector( "#FileAttachTrigger" ),
			returnFileAttach = document.querySelector("#returnFileAttach");
			  
		FileAttachTrigger.addEventListener( "keydown", function( event ) {  
			if ( event.keyCode == 13 || event.keyCode == 32 ) {  
				AddFileAttach.focus();  
			}  
		});
		FileAttachTrigger.addEventListener( "click", function( event ) {
			AddFileAttach.focus();
		   return false;
		});  
		AddFileAttach.addEventListener( "change", function( event ) {  
			returnFileAttach.innerHTML = this.value;  
		}); 
	});
</script>
{/literal}