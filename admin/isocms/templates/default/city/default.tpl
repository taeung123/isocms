<div class="page_container">
	<div class="page-title d-flex">
        <div class="title">
			<h2>{$core->get_Lang('City List')} <div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách các {$core->get_Lang('City List')} trong hệ thống isoCMS">i</div>
			</h2>
			<p>{$number_all} {$core->get_Lang('City List')}</p>
		</div>
		<div class="button_right">
			<a class="btn btn-main btn-addnew add_new_city" title="{$core->get_Lang('Add city')}">{$core->get_Lang('Add city')}</a>
			{*<a href="{$PCMS_URL}/?mod={$mod}&act=edit" class="btn btn-main btn-addnew" title="{$core->get_Lang('Add city')}">{$core->get_Lang('Add city')}</a>*}
		</div>
    </div>
	<div class="container-fluid">
		<div class="wrap">
			<div class="filter_box">
				<form id="forums" method="post" class="filterForm" action="">
					<div class="form-group form-keyword">
						<input class="form-control" type="text" name="keyword" value="{$keyword|default:''}" placeholder="{$core->get_Lang('search')}..." />
					</div>
					{if $lstContinent && $clsISO->getCheckActiveModulePackage($package_id,'continent','default','default') and $core->checkAccess('continent')}
						<div class="form-group form-country">
							<select name="continent_id" class="form-control iso-selectbox slb_Chauluc_Id" data-width="100%" id="slb_continent" toId="slb_country">
								<option value="">-- {$core->get_Lang('Select Continent')} --</option>
								{section name=i loop=$lstContinent}
									<option {if $continent_id eq $lstContinent[i].continent_id}selected="selected"{/if} value="{$lstContinent[i].continent_id}">{$clsContinent->getTitle($lstContinent[i].continent_id)}</option>
								{/section}
							</select>
						</div>
					{/if}
					{if $lstCountryEx && $clsISO->getCheckActiveModulePackage($package_id,'country','default','default') and $core->checkAccess('country')}
						<div class="form-group form-country">
							<select name="country_id" class="form-control iso-selectbox slb_Country_Id" data-width="100%" id="slb_country">
								<option value="">-- {$core->get_Lang('Select Country')} --</option>
								{section name=i loop=$lstCountryEx}
									<option {if $country_id eq $lstCountryEx[i].country_id}selected="selected"{/if} value="{$lstCountryEx[i].country_id}">{$clsCountryEx->getTitle($lstCountryEx[i].country_id)}</option>
								{/section}
							</select>
						</div>
					{/if}
					{if $clsISO->getCheckActiveModulePackage($package_id,'region','default','default') and $core->checkAccess('region')}
						<div class="form-group form-country">
							
							<select name="region_id" class="form-control iso-selectbox" data-width="100%" id="slb_RegionID">
								<option value="">-- {$core->get_Lang('Select Region')} --</option>
								{foreach from=$lstRegion key=key item=item} 
									<option {if $region_id eq $item.region_id}selected{/if} value="{$item.region_id}">{$clsRegion->getTitle($item.region_id)}</option>
								{/foreach}
							</select>
						</div>
					{/if}
					<div class="form-group form-button">
						<button type="submit" class="btn btn-main" id="findtBtn">{$core->get_Lang("Search")}</button>
						<input type="hidden" name="filter" value="filter" />
					</div>
					<div class="form-group form-button">
						<a class="btn btn-delete-all" id="btn_delete" clsTable="City" style="display:none">
							{$core->get_Lang('Delete')}
						</a>
					</div>
					<div class="fr group_buttons full_width_767 text_right mt10_767">
                        <a href="{$PCMS_URL}/?mod={$mod}{$pUrl|default:''}" class="btn btn-warning btnNew"> <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')} ({$number_all})</span> </a>
                        <a href="{$PCMS_URL}/?mod={$mod}{$pUrl|default:''}&type_list=Trash" class="btn btn-danger btnNew"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span> </a>
                    </div>
				</form>	
			</div>			
			<div class="statistical mb5">
				<table width="100%" border="0" cellpadding="3" cellspacing="0">
					<tr>
						<td width="50%" align="left">&nbsp;</td>
						<td width="50%" align="right">
							{$core->get_Lang('Record/page')}:
							{$clsISO->getRecordPerPage2($recordPerPage,$totalRecord,$mod,$pUrl,'','')}
						</td>
					</tr>
				</table>
			</div>
			<div class="clearfix"></div>
			<div class="tabbox">
				<div class="hastable">
					<table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
						<thead>
							<tr>
								<th class="gridheader" style="width:40px"><input id="check_all" type="checkbox"  class="el-checkbox" /></th>
								<th class="gridheader hiden767">{$core->get_Lang('ID')}</th>
								<th class="gridheader name_responsive" style="text-align:left;">{$core->get_Lang('City name')}</th>
								{if $clsISO->getCheckActiveModulePackage($package_id,'region','default','default')}
								<th class="gridheader hiden_responsive" style="text-align:left;">{$core->get_Lang('Region')}</th>
								{/if}
								<th class="gridheader hiden_responsive" style="width:6%;">{$core->get_Lang('status')}</th>
								<th class="gridheader hiden_responsive">{$core->get_Lang('func')}</th>
							</tr>
						</thead>
						{if $allItem[0].city_id ne ''}
						<tbody id="SortAble">
							{section name=i loop=$allItem}
							{assign var = city_id value = $allItem[i].city_id}
							<tr style="cursor:move" id="order_{$city_id}" class="{cycle values="row1,row2"}" >
								<td class="check_40 has-checkbox text-center"><input name="p_key[]" class="chkitem el-checkbox" type="checkbox" value="{$city_id}" /></td>
								<td class="index hiden767">{$city_id} </td>
								<td class="name_service">
									<span class="title mr10">{if $clsClassTable->getOneField('is_online',$city_id) eq 0}<span style="color:#F90">[PRIVATE]</span>{/if} <span style="font-size:16px">{$clsClassTable->getTitle($city_id)}</span></span>
									{if $clsConfiguration->getValue('SiteHasChild_slide')}
									<a href="{$PCMS_URL}/index.php?mod=slide&mod_page={$mod}&act_page={$act}&target_id={$allItem[i].$pkeyTable}" title="{$core->get_Lang('listslide')}">
										<i class="fa fa-folder-open"></i>  {$core->get_Lang('listslide')} <strong style="color:#c00000;">({$clsISO->countTotalSlide($mod,$act,$allItem[i].$pkeyTable)})</strong>
									</a>
									{/if}
									{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
									<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
								</td>
								{if $clsISO->getCheckActiveModulePackage($package_id,'region','default','default')}
								<td data-title="{$core->get_Lang('Region')}" class="block_responsive">{$clsRegion->getTitle($allItem[i].region_id)} </td>
								{/if}
								<td data-title="{$core->get_Lang('status')}" class="block_responsive" style="text-align:center">
									<a href="javascript:void(0);" class="SiteClickPublic" clsTable="City" pkey="city_id" sourse_id="{$city_id}" rel="{$clsClassTable->getOneField('is_online',$city_id)}" title="{$core->get_Lang('Click to change status')}">
										{if $clsClassTable->getOneField('is_online',$city_id) eq '1'}
										<i class="fa-solid fa-circle-check green"></i>
										{else}
										<i class="fa-solid fa-circle-minus red"></i>
										{/if}
									</a>
								</td>
								<td data-title="{$core->get_Lang('func')}" class="block_responsive" align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
									<div class="btn-group">
										<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
											<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
										</button>
										<ul class="dropdown-menu dropdown-menu-end">
											{if $allItem[i].is_trash eq '0'}
												<li>
													<a href="{$DOMAIN_NAME}{$clsClassTable->getLink($city_id)}" target="_blank" title="{$core->get_Lang('view')}" class="dropdown-item">
														<i class="icon-eye-open"></i> {$core->get_Lang('view')}
													</a>
												</li>
												<li>
													<a title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/{$mod}/insert/{$city_id}/overview" class="dropdown-item">
														<i class="icon-edit"></i> {$core->get_Lang('edit')}
													</a>
												</li>
												<li>
													<a title="{$core->get_Lang('trash')}" href="{$PCMS_URL}/?mod={$mod}&act=trash&city_id={$core->encryptID($city_id)}{$pUrl|default:''}&page={$currentPage}" class="dropdown-item">
														<i class="icon-trash"></i> {$core->get_Lang('trash')}
													</a>
												</li>
											{else}
												<li>
													<a title="{$core->get_Lang('restore')}" href="{$PCMS_URL}/?mod={$mod}&act=restore&city_id={$core->encryptID($city_id)}{$pUrl|default:''}&page={$currentPage}" class="dropdown-item">
														<i class="icon-refresh"></i> {$core->get_Lang('restore')}
													</a>
												</li>
												<li>
													<a title="{$core->get_Lang('delete')}" class="confirm_delete dropdown-item" href="{$PCMS_URL}/?mod={$mod}&act=delete&city_id={$core->encryptID($city_id)}{$pUrl|default:''}&page={$currentPage}">
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
			{$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type|default:'')}
		</div>
	</div>
</div>
<script type="text/javascript">
	var $boxID = "";
	var $cat_id = `{$cat_id|default:0}`;
	var $city_id= `{$city_id|default:0}`;
	var $country_id= `{$country_id|default:0}`;
	var $region_id= `{$region_id|default:0}`;
	var $departure_point_id= `{$departure_point_id|default:0}`;
	var $is_set= `{$is_set|default:''}`;
	var $recordPerPage = `{$recordPerPage|default:0}`;
	var $currentPage = `{$currentPage|default:0}`;
</script>
<script type="text/javascript" src="{$URL_THEMES}/city/jquery.city.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_THEMES}/city/jquery.city.new.js?v={$upd_version}"></script>
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
			$.post(path_ajax_script+"/index.php?mod=city&act=ajUpdPosSortCity", order,

			function(html){
				vietiso_loading(0);
				// location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}