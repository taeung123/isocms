<div class="page_container">
	<div class="page-title d-flex">
        <div class="title">
			<h2>{$core->get_Lang('Combo')} <div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách các combo trong hệ thống isoCMS">i</div>
			</h2>
			<p>{$number_all} {$core->get_Lang('combo')}</p>
		</div>
		<div class="button_right">
			<a class="btn btn-main btn-addnew createNewCombo" title="{$core->get_Lang('Create combo')}">{$core->get_Lang('Create combo')}</a>
			<div class="btn btn-setting"><a href="{$PCMS_URL}/?mod={$mod}&act=setting" title="{$core->get_Lang('Setting')}"><i class="fa fa-cog" aria-hidden="true"></i></a></div>
		</div>
    </div>
	<div class="container-fluid">
		<div class="wrap">
			<div class="statistical mb5">
			<div class="filter_box">
				<form id="forums" method="post" class="filterForm" action="">
					<div class="form-group form-keyword">
						<input class="form-control" type="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}..." />
					</div>
					
					<div class="form-group form-country">
						<select name="country_id" class="form-control" data-width="100%" id="slb_country">
							{$clsCountry->makeSelectboxOption($country_id, $continent_id)}
						</select>
					</div>
					<div class="form-group form-city">
						<select name="city_id" class="form-control" data-width="100%" id="slb_city">
							{$clsCity->getSelectCity($country_id, $region_id, $city_id,'title')}
						</select>
					</div>
					<div class="form-group form-button">
						<button type="submit" class="btn btn-main" id="findtBtn">Tìm kiếm</button>
						<input type="hidden" name="filter" value="filter" />
					</div>
					<div class="form-group form-button hidden">
						<button type="button" class="btn btn-export" id="btn_export">Export</button>
					</div>
					<div class="form-group form-button">
						<a class="btn btn-delete-all" id="btn_delete" clsTable="Combo" style="display:none">
							{$core->get_Lang('Delete')}
						</a>
					</div>
				</form>	
				<div class="record_per_page">
					<label>{$core->get_Lang('Record/page')}</label>
					{$clsISO->getRecordPerPage2($recordPerPage,$totalRecord,$mod,$pUrl)}
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="tabbox">
				<div class="hastable">
					<table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
						<thead><tr>
							<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" class="el-checkbox" /></th>
							<th class="gridheader hiden767" style="width:70px">{$core->get_Lang('Image')}</th>
							<th class="gridheader hiden767" style="width:80px"><strong>ID</strong></th>
							<th class="gridheader name_responsive" style="text-align:left"><strong>{$core->get_Lang('Comboname')}</strong></th>
							<th class="gridheader text-left hiden_responsive" style="width: 170px"><strong>{$core->get_Lang('Thời gian hiệu lực')}</strong></th>
							<th class="gridheader text-right hiden_responsive" style="width: 130px"><strong>{$core->get_Lang('pricefrom')}</strong></th>
							<th class="gridheader text-center hiden_responsive" style="width: 120px"><strong>{$core->get_Lang('public')}</strong></th>
							<th class="gridheader text-center hiden_responsive" width="40px"></th>
						</tr></thead>
						{if $allItem}
						<tbody id="SortAble">
							{section name=i loop=$allItem}
							{assign var = combo_id value = $allItem[i].combo_id}
							<tr style="cursor:move" id="order_{$combo_id}" class="{cycle values="row1,row2"}" >
								<td class="check_40 has-checkbox text-center"><input name="p_key[]" class="chkitem el-checkbox" type="checkbox" value="{$combo_id}" /></td>
								<td class="index hiden767"><img src="{$clsClassTable->getImage($combo_id,60,40)}" alt="Image" width="60"/></td>
								<td class="index hiden767" data-title="ID"><span>{$combo_id}</span></td>
								<td class="text-left name_service">
									<span class="title" title="{if $clsClassTable->getOneField('is_online',$combo_id) eq 0}{$core->get_Lang('Combo PRIVATE')}{/if}">{$clsClassTable->getTitle($combo_id)}</span>
									{if $allItem[i].is_online eq 0}
									<span class="color_r" title="{$core->get_Lang('Combo PRIVATE')}">[P]</span>{/if}
									{if $allItem[i].is_trash eq '1'}
									<span class="pull-right text-muted">{$core->get_Lang('intrash')}</span>
									{/if}
									<button type="button" class="toggle-row inline_block767" style="display:none">
										<i class="fa fa-caret fa-caret-down"></i>
									</button>
								</td>
								<td class="block_responsive text-left" data-title="{$core->get_Lang('Thời gian hiệu lực')}">
									20/07/2021 - 01/01/2021
								</td>
								<td class="block_responsive" style="text-align:right; white-space:nowrap" data-title="{$core->get_Lang('pricefrom')}">
									<span class="format_price">
										{$clsClassTable->getPrice($allItem[i].combo_id)}
										</span>
								</td>
								<td class="block_responsive" style="text-align:center" data-title="{$core->get_Lang('public')}">
									<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Combo" pkey="combo_id" sourse_id="{$combo_id}" rel="{$allItem[i].is_online}" title="{$core->get_Lang('Click to change status')}">
										{if $allItem[i].is_online eq '1'}
										<i class="fa-solid fa-circle-check green"></i>
										{else}
										<i class="fa-solid fa-circle-minus red"></i>
										{/if}
									</a>
								</td>
								<td class="block_responsive text-center" style="white-space:nowrap;" data-title="{$core->get_Lang('func')}">
									<div class="dropdown">
										<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
											<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
										</button>

										<ul class="dropdown-menu dropdown-menu-end">
											{if $allItem[i].is_trash eq '0'}

											<li>
												<a class="dropdown-item"
												href="{$DOMAIN_NAME}{$clsClassTable->getLink($combo_id)}"
												target="_blank"
												title="{$core->get_Lang('view')}">
													<i class="icon-eye-open"></i> {$core->get_Lang('view')}
												</a>
											</li>

											<li>
												<a class="dropdown-item"
												title="{$core->get_Lang('edit')}"
												href="{$PCMS_URL}/combo/insert/{$combo_id}/overview">
													<i class="icon-edit"></i> {$core->get_Lang('edit')}
												</a>
											</li>

											<li>
												<a class="dropdown-item"
												title="{$core->get_Lang('trash')}"
												href="{$PCMS_URL}/?mod={$mod}&act=trash&combo_id={$core->encryptID($combo_id)}{$pUrl}&page={$currentPage}">
													<i class="icon-trash"></i> {$core->get_Lang('trash')}
												</a>
											</li>

											{else}

											<li>
												<a class="dropdown-item"
												title="{$core->get_Lang('edit')}"
												href="{$PCMS_URL}/combo/insert/{$combo_id}/overview">
													<i class="icon-edit"></i> {$core->get_Lang('edit')}
												</a>
											</li>

											<li>
												<a class="dropdown-item"
												title="{$core->get_Lang('restore')}"
												href="{$PCMS_URL}/?mod={$mod}&act=restore&combo_id={$core->encryptID($combo_id)}{$pUrl}&page={$currentPage}">
													<i class="icon-refresh"></i> {$core->get_Lang('restore')}
												</a>
											</li>

											<li>
												<a class="dropdown-item confirm_delete"
												title="{$core->get_Lang('delete')}"
												href="{$PCMS_URL}/?mod={$mod}&act=delete&combo_id={$core->encryptID($combo_id)}{$pUrl}&page={$currentPage}">
													<i class="icon-remove"></i> {$core->get_Lang('delete')}
												</a>
											</li>

											{/if}
										</ul>
									</div>
								</td>
							</tr>
							{/section}
						</tbody>
						{else}<tr><td colspan="15">{$core->get_Lang('nodata')}!</td></tr>{/if}
					</table>
				</div>
			</div>
			<div class="clearfix"></div>
			{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type)}
		</div>
	</div>
	<script type="text/javascript">
		var $boxID = "";
		var $cat_id = '{$cat_id}';
		var $city_id= '{$city_id}';
		var $departure_point_id= '{$departure_point_id}';
		var $is_set= '{$is_set}';
		var $recordPerPage = '{$recordPerPage}';
		var $currentPage = '{$currentPage}';
	</script>
	<script type="text/javascript" src="{$URL_THEMES}/combo/jquery.combo.js?v={$upd_version}"></script>
	{literal}
	<script type="text/javascript">
		$("#SortAble").sortable({
			opacity: 0.8,
			cursor: 'move',
			start: function(){
				vietiso_loading(1);
			},
			stop: function(){
				vietiso_loading(0);
			},
			update: function(){
				var recordPerPage = $recordPerPage;
				var currentPage = $currentPage;
				var order = $(this).sortable("serialize")+'&update=update'+'&recordPerPage='+recordPerPage+'&currentPage='+currentPage;
				$.post(path_ajax_script+"/index.php?mod=combo&act=ajUpdPosCombo", order,

				function(html){
					vietiso_loading(0);
					location.href = REQUEST_URI;
				});
			}
		});
	</script>
	{/literal}
</div>