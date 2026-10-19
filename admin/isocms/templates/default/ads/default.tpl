<div class="page_container">
	<div class="page-title d-flex">
        <div class="title">
			<h2>{$core->get_Lang('advert')} <div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách các {$core->get_Lang('advert')} trong hệ thống isoCMS">i</div>
			</h2>
		</div>
		<div class="button_right">
			<a class="btn btn-main add_new_ads" title="{$core->get_Lang('Add')} {$core->get_Lang('advert')}">{$core->get_Lang('Add')} {$core->get_Lang('advert')}</a>
		</div>
    </div>
	<div class="container-fluid">
		<div class="wrap">
			<div class="filter_box">
				<form id="forums" method="post" class="filterForm" action="">
					{assign var=blog_category_check value=$clsISO->getCheckActiveModulePackage($package_id,$mod,'category','default')}
					<div class="form-group form-keyword">
						<input class="form-control" type="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}" />
					</div>
					<div class="form-group form-button">
						<button type="submit" class="btn btn-main" id="findtBtn">Tìm kiếm</button>
						<input type="hidden" name="filter" value="filter" />
					</div>
					<div class="form-group form-button">
						<a class="btn btn-delete-all" id="btn_delete" clsTable="Ads" style="display:none">
							{$core->get_Lang('Delete')}
						</a>
					</div>
					<div class="fr group_buttons">
						<a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-warning btnNew" style="color:#fff"> <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')}({$number_all})</span> </a>
						<a href="{$PCMS_URL}/?mod={$mod}&type_list=Trash" class="btn btn-danger btnNew" style="color:#fff"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span> </a>
                    </div>
				</form>	
			</div>
		</div>
		<div class="clearfix"><br /></div>
		<table cellspacing="0" class="tbl-grid table-striped table_responsive" style="width:100%">
			<thead>
				<tr>
					<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></th>
					<th class="gridheader hiden767" style="width:4%;text-align:left;"><strong>{$core->get_Lang('index')}</strong></th>
					<th class="gridheader name_responsive text_left" style="text-align:center" width="50"><strong>{$core->get_Lang('images')}</strong></th>
					<th class="gridheader hiden_responsive" style="text-align:left"><strong>{$core->get_Lang('nameofads')}</strong></th>
					<th class="gridheader hiden_responsive" style="text-align:left"><strong>{$core->get_Lang('link')}</strong></th>
					<th class="gridheader hiden_responsive" style="width:6%"><strong>{$core->get_Lang('status')}</strong></th>
					<th class="gridheader hiden_responsive" style="width:12%;" align="center"><strong>{$core->get_Lang('update')}</strong></th>
					<th class="gridheader hiden_responsive" style="text-align:center;"><strong>{$core->get_Lang('func')}</strong></th>
				</tr>
			</thead>
			{section name=i loop=$allItem}
			<tr class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
				<th class="check_40"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].ads_id}" /></th>
				<th class="index hiden767">{$smarty.section.i.index+1}</th>
				<td class="name_service full_width_767" style=" text-align:center;width:250px"><img src="{$clsClassTable->getOneField('image',$allItem[i].ads_id)}" width="200" />
				<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
				</td>
				<td data-title="{$core->get_Lang('nameofads')}" class="block_responsive border_top_responsive">
					<strong class="title">{if $clsClassTable->getOneField('is_online',$allItem[i].ads_id) eq 0}<span style="color:#F90">[PRIVATE]</span>{/if} {$clsClassTable->getTitle($allItem[i].ads_id)}</strong>
					{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
				</td>
				<td data-title="{$core->get_Lang('link')}" class="block_responsive">{$clsClassTable->getOneField('url',$allItem[i].ads_id)}</td>
				<td data-title="{$core->get_Lang('status')}" class="block_responsive" style="text-align:center">
					<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Ads" pkey="ads_id" sourse_id="{$allItem[i].ads_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].ads_id)}" title="{$core->get_Lang('Click to change status')}">
						{if $clsClassTable->getOneField('is_online',$allItem[i].ads_id) eq '1'}
						<i class="fa-solid fa-circle-check green"></i>
						{else}
						<i class="fa-solid fa-circle-minus red"></i>
						{/if}
					</a>
				</td>
				<td data-title="{$core->get_Lang('update')}" class="block_responsive" style="text-align:center">{$allItem[i].upd_date|date_format:"%d/%m/%Y %H:%M"}</td>
				<td data-title="{$core->get_Lang('func')}" class="block_responsive" align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
					<div class="btn-group">
						<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
						</button>
						<ul class="dropdown-menu dropdown-menu-end">
							{if $allItem[i].is_trash eq '0'}
								<li>
									<a href="{$PCMS_URL}/ads/insert/{$allItem[i].ads_id}/overview" class="dropdown-item" title="{$core->get_Lang('Edit')}">
										<i class="icon-edit"></i> <span>{$core->get_Lang('Edit')}</span>
									</a>
								</li>
								<li>
									<a href="{$PCMS_URL}/?mod={$mod}&act=trash&ads_id={$core->encryptID($allItem[i].ads_id)}{$pUrl}" class="dropdown-item" title="{$core->get_Lang('Trash')}">
										<i class="icon-trash"></i> <span>{$core->get_Lang('Trash')}</span>
									</a>
								</li>
							{else}
								<li>
									<a href="{$PCMS_URL}/?mod={$mod}&act=restore&ads_id={$core->encryptID($allItem[i].ads_id)}{$pUrl}" class="dropdown-item" title="{$core->get_Lang('Refresh')}">
										<i class="icon-refresh"></i> <span>{$core->get_Lang('Refresh')}</span>
									</a>
								</li>
								<li>
									<a href="{$PCMS_URL}/?mod={$mod}&act=delete&ads_id={$core->encryptID($allItem[i].ads_id)}{$pUrl}" class="dropdown-item confirm_delete" title="{$core->get_Lang('Delete')}">
										<i class="icon-remove"></i> <span>{$core->get_Lang('Delete')}</span>
									</a>
								</li>
							{/if}
						</ul>
					</div>
				</td>
			</tr>
			{/section}
		</table>
		<div class="adminPaging">
			<ul class="lstAdminPaging">
				{section name=i loop=$listPageNumber}
				<li><a href="{$PCMS_URL}/{$link_page_current}&page={$listPageNumber[i]}" {if $listPageNumber[i] eq $currentPage}class="active"{/if}>{$listPageNumber[i]}</a>
				</li>
				{/section}
			</ul>
			<div class="report">
				<strong>{$core->get_Lang('statistical')}</strong>: <strong>{$totalRecord}</strong> {$core->get_Lang('records')}/<strong>{$totalPage}</strong> {$core->get_Lang('page')}. {$core->get_Lang('youareonpagenumber')} <strong>{$currentPage}</strong>.
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
var $SiteHasGroup_Ads = "{$clsConfiguration->getValue('SiteHasGroup_Ads')}";
</script>
<script type="text/javascript" src="{$URL_JS}/jquery.ads.new.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_THEMES}/ads/jquery.ads.js?v={$upd_version}"></script>