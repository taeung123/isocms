<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')}:</strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('customers')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>
        	{if $is_active ne ''}
            	{if $is_active eq 0}{$core->get_Lang('Customers Reminding List')}{/if}
                {if $is_active eq 1}{$core->get_Lang('Customers Active List')}{/if}
                {if $is_active eq 2}{$core->get_Lang('Customers Reviewed List')}{/if}
          	{else}
            	{$core->get_Lang('Customers List')}
            {/if}
        </h2>
		{assign var = setting value = 'SiteIntroModule_'|cat:$mod|cat:'_'|cat:$_LANG_ID}
		{if $clsConfiguration->getValue($setting) ne ''}
        <p>{$clsConfiguration->getValue($setting)|html_entity_decode}</p>
		{/if}
    </div>
    <div class="clearfix"><br /></div>
	<div class="wrap fiterbox">
		<div class="group_buttons fl">
			<a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-success">
				<i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('total')} ({$totalItem})</span>
			</a>
			<a href="{$PCMS_URL}/?mod={$mod}&is_active=1" class="btn btn-success" style="background:#06C;border-color:#06C">
				<i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('Active')} ({$number_active})</span>
			</a>
			<a href="{$PCMS_URL}/?mod={$mod}&is_active=0" class="btn btn-success" style="background:#FC0;border-color:#FC0">
				<i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('Un Active')} ({$number_unactive})</span>
			</a>
			{*<a href="{$PCMS_URL}/?mod={$mod}&act=setting" class="btn btn-danger" title="{$core->get_Lang('setting')}"><i class="icon-list icon-white"></i> <span>{$core->get_Lang('setting')}</span> </a>*}
		</div>  
	</div>
	
	<div id="isotabs">
		 <ul>
            <li class="tabchild"><a><i class="iso-option"></i> {$core->get_Lang('searchfilter')}</a></li>
        </ul>
	</div>
    <div id="isotabs_content">
		<div class="isotabbox">
			<form id="forums" method="post" class="filterForm" action="">
				<div class="searchbox wrap" style="float:none">
					<table class="form" cellpadding="3" cellspacing="3">
						<tr>
                            <td class="fieldlabel">{$core->get_Lang('Name')}</td>
                            <td class="fieldarea">
                               <input style="width:190px" type="text" class="text" name="name" value="{$name}" placeholder="{$core->get_Lang('Name')}..." />
                            </td>
							<td class="fieldlabel">{$core->get_Lang('Email')}</td>
							<td class="fieldarea">
								<input style="width:190px" type="text" class="text" name="email" value="{$email}" placeholder="{$core->get_Lang('Email')}..." />
							</td>
						</tr>
						<tr>
							<td class="fieldlabel">{$core->get_Lang('Phone number')}</td>
							<td class="fieldarea">
								<input style="width:190px" type="text" class="text" name="phoneNumber" value="{$phonenumber}" placeholder="{$core->get_Lang('Phone number')}..." />
							</td>
						</tr>
					</table>
				</div>
				<div class="mt10"></div>
				<center>
					<div class="group_buttons">
						<a class="btn btn-success" href="javascript:void();" id="searchbtn" >
							<i class="icon-search icon-white"></i> <span>{$core->get_Lang('search')}</span>
						</a>
						<input type="hidden" name="filter" value="filter" />
					</div>
				</center>
            </form>
		</div>
	</div>	

    <div class="clearfix"></div>
    <div class="hastable">
    	<div style="width:100%;">
            <table width="100%" cellspacing="0" class="tbl-grid table-striped table_responsive" style="overflow:auto">
                <tr>
                    <td class="gridheader" style="width:40px"><strong>{$core->get_Lang('id')}</strong></td>
					<td class="gridheader text-left" style="white-space:nowrap"><strong>{$core->get_Lang('Full Name')}</strong></td>
                    <td class="gridheader text-left" style="white-space:nowrap"><strong>{$core->get_Lang('Email')}</strong></td>
                    <td class="gridheader text-left" style="white-space:nowrap"><strong>{$core->get_Lang('Phone Number')}</strong></td>
					{if $type eq 'AGENT'}
                    <td class="gridheader text-left" style="white-space:nowrap"><strong>{$core->get_Lang('Company')}</strong></td>
					<td class="gridheader text-left" style="white-space:nowrap"><strong>{$core->get_Lang('Nationality')}</strong></td>
                    <td class="gridheader text-left" style="white-space:nowrap"><strong>{$core->get_Lang('Market')}</strong></td>
					{/if}
                    <td class="gridheader" style="width:10%"><strong>{$core->get_Lang('status')}</strong></td>
                    <td class="gridheader" style="width:6%"><strong>{$core->get_Lang('action')}</strong></td>
                </tr>
                {if $listItem[0].agent_id ne ''}
                {section name=i loop=$listItem}
                <tr class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
                    <td class="index">{$listItem[i].agent_id}</td>
					<td style="white-space:nowrap"><a href="{$PCMS_URL}/?mod={$mod}&act=edit&agent_id={$core->encryptID($listItem[i].agent_id)}">{$listItem[i].full_name}</a></td>
                    <td style="white-space:nowrap">{$listItem[i].email}</td>
                    <td style="white-space:nowrap">{$listItem[i].phone}</td>
					{if $type eq 'AGENT'}
                    <td style="white-space:nowrap">{$listItem[i].company_name}</td>
					<td style="white-space:nowrap">{$clsCountry->getTitle($listItem[i].country_id)}</td>
                    <td style="white-space:nowrap">{$clsCountryEx->getTitle($listItem[i].market_id)}</td>
					{/if}   
                    <td align="center" style="text-align:center;" >
                        {if $listItem[i].is_active eq '0'}
                        <span class="status_pending">{$core->get_Lang('Un Active')}</span>
                        {elseif $listItem[i].is_active eq '2'}
                        <span class="status_lock">{$core->get_Lang('Reviewed')}</span>
                        {else}
                        <span class="status_approved">{$core->get_Lang('Active')}</span>
                        {/if}
                    </td>
                    <td style="vertical-align: middle; width:40px; text-align: center; white-space: nowrap;">
                        <div class="btn-group">
							<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
							</button>
							<ul class="dropdown-menu" style="right:0px !important">
								<li>
									<a title="{$core->get_Lang('view')}" href="{$PCMS_URL}/?mod={$mod}&act=edit&agent_id={$core->encryptID($listItem[i].agent_id)}">
										<i class="icon-edit"></i> {$core->get_Lang('view')}
									</a>
								</li>
								<li>
									<a title="{$core->get_Lang('delete')}" class="confirm_delete" href="{$PCMS_URL}/?mod={$mod}&act=delete&agent_id={$core->encryptID($listItem[i].agent_id)}">
										<i class="icon-remove"></i> {$core->get_Lang('delete')}
									</a>
								</li>
							</ul>
						</div>
                    </td>
                </tr>	
                {/section}
                {else}
                <tr>
                    <td colspan="20" style="text-align:center">{$core->get_Lang('nodata')}</td>
                </tr>
                {/if}
            </table>
        </div>
        <div class="clearfix" style="height:5px"></div>
        <table width="100%" border="0" cellpadding="3" cellspacing="0">
			<tr>
				<td width="50%" align="left">{$core->get_Lang('statistical')} <strong>{$totalRecord}</strong> {$core->get_Lang('records')}/<strong>{$totalPage}</strong> {$core->get_Lang('page')}. {$core->get_Lang('youareonpagenumber')} <strong>{$currentPage}</strong></td>
				<td width="50%" align="right">
					{$core->get_Lang('gotopage')}:
					<select name="page" onchange="window.location = this.options[this.selectedIndex].value">
						{section name=i loop=$listPageNumber}
						<option {if $listPageNumber[i] eq $currentPage}selected="selected"{/if} value="{$PCMS_URL}/{$link_page_current}&page={$listPageNumber[i]}">{$listPageNumber[i]}</option>
						{/section}
					</select>
                    <a class="btn btn-danger btn-delete-all" clsTable="Tour" style="display:none">
                        <i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span>
                    </a>
				</td>
			</tr>
		</table>
        </div>
    </div>
</div>