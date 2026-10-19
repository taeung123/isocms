<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('gallery')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('gallery')} <a class="btn btn-success" href="{$PCMS_URL}/?mod={$mod}&act=edit" title="{$core->get_Lang('add')}"> <i class="icon-plus icon-white"></i></a></h2>
        {assign var = setting value = 'SiteIntroModule_'|cat:$mod|cat:'_'|cat:$_LANG_ID}
		{if $clsConfiguration->getValue($setting) ne ''}
        <p>{$clsConfiguration->getValue($setting)}</p>
		{/if}
        <div class="permalinkbox">
            <div class="wrap permalink_show">
            	<strong><a href="{$DOMAIN_NAME}{$clsISO->getLink('gallery')}" target="_blank"><img align="absmiddle" src="{$URL_IMAGES}/v2/link.png" /> {$DOMAIN_NAME}{$clsISO->getLink('gallery')}</a></strong>
            </div>
        </div>
    </div>
	<div class="clearfix"><br /></div>
    <div class="wrap">
        <form id="forums" method="post" action="" name="filter" class="filterForm">
            <div class="ui-action">
               <div class="fl fiterbox" style="width:100%">
                    <div class="wrap">
                        <div class="searchbox">
                            {if $clsConfiguration->getValue('SiteHasCat_Gallery') eq 1}
                              <select name="gallerycat_id" class="slb mr5 fl" style="padding:5px;">
                                  {$clsGalleryCategory->makeSelectboxOption($gallerycat_id)}
                              </select>
                             {/if}
                            <input type="text" class="m-wrap short" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}" />
                            <a class="btn btn-success fileinput-button" href="javascript:void();" id="searchbtn" style=" padding:5px">
                                <i class="icon-search icon-white"></i>
                            </a>
                            
                        </div>
                        
                        <div class="fr group_buttons">
                            <a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-warning" style="color:#fff"> <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')} ({$number_all})</span> </a>
                            <a href="{$PCMS_URL}/?mod={$mod}&type_list=Trash" class="btn btn-danger" style="color:#fff"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span> </a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="Gallery" style="color:#fff; display:none"> <i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span> </a>
							 {if $clsConfiguration->getValue('SiteHasCat_Gallery') eq 1}
							<a href="{$PCMS_URL}/index.php?mod={$mod}&act=cat" class="btn btn-success">
								<i class="icon-list icon-white"></i> <span>{$core->get_Lang('Category')}</span>
							</a>
							{/if}
                            <a href="{$PCMS_URL}/?mod={$mod}&act=setting" class="btn btn-danger" title="{$core->get_Lang('settings')}"><i class="icon-cog icon-white"></i> <span>{$core->get_Lang('settings')}</span> </a>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="filter" value="filter" />
        </form>
        <input id="list_selected_chkitem" style="display:none" value="0" />
		<div class="statistical mb5">
			<table width="100%" border="0" cellpadding="3" cellspacing="0">
				<tr>
					<td width="50%" align="left">&nbsp;</td>
					<td width="50%" align="right">
						{$core->get_Lang('Record/page')}:
						{$clsISO->getRecordPerPage($recordPerPage,$totalRecord,$mod)}
					</td>
				</tr>
			</table>
		</div>
        <table cellspacing="0" class="tbl-grid table-striped table_responsive" width="100%">
			<thead>
				<tr>
					<td class="gridheader"><input id="check_all" type="checkbox" /></td>
					<td class="gridheader"><strong>{$core->get_Lang('index')}</strong></td>
					<td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('titleofarticle')}</strong></td>
					<td class="gridheader" style="width:6%"><strong>{$core->get_Lang('status')}</strong></td>
					<td class="gridheader" style="width:12%;" align="center"><strong>{$core->get_Lang('update')}</strong></td>
					<td class="gridheader"><strong>{$core->get_Lang('func')}</strong></td>
				</tr>
			</thead>
			<tbody id="SortAble">
				{section name=i loop=$allItem}
				<tr style="cursor:move" id="order_{$allItem[i].gallery_id}" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
					<td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].gallery_id}" /></td>
					<td class="index">{$smarty.section.i.index+1}</td>
					<td>
						<strong class="title">{if $clsClassTable->getOneField('is_online',$allItem[i].gallery_id) eq 0}<span style="color:#F90">[PRIVATE]</span>{/if} {$clsClassTable->getTitle($allItem[i].gallery_id)}</strong>
						{if $allItem[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
					</td>
					<td style="text-align:center">
						<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Gallery" pkey="gallery_id" sourse_id="{$allItem[i].gallery_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].gallery_id)}" title="{$core->get_Lang('Click to change status')}">
							{if $clsClassTable->getOneField('is_online',$allItem[i].gallery_id) eq '1'}
							<i class="fa-solid fa-circle-check green"></i>
							{else}
							<i class="fa-solid fa-circle-minus red"></i>
							{/if}
						</a>
					</td>
					<td style="text-align:center">{$allItem[i].upd_date|date_format:"%d/%m/%Y %H:%M"}</td>
					<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
						<div class="dropdown">
							<button class="btn btn_dropdown dropdown-toggle"
									type="button"
									data-bs-toggle="dropdown"
									aria-expanded="false">
								<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
							</button>

							<ul class="dropdown-menu dropdown-menu-end">
								{if $allItem[i].is_trash eq '0'}

								<li>
									<a class="dropdown-item"
									title="{$core->get_Lang('edit')}"
									href="{$PCMS_URL}/?mod={$mod}&act=edit&gallery_id={$core->encryptID($allItem[i].gallery_id)}">
										<i class="icon-edit"></i> {$core->get_Lang('edit')}
									</a>
								</li>

								<li>
									<a class="dropdown-item"
									title="{$core->get_Lang('trash')}"
									href="{$PCMS_URL}/?mod={$mod}&act=trash&gallery_id={$core->encryptID($allItem[i].gallery_id)}{$pUrl}">
										<i class="icon-trash"></i> {$core->get_Lang('trash')}
									</a>
								</li>

								{else}

								<li>
									<a class="dropdown-item"
									title="{$core->get_Lang('restore')}"
									href="{$PCMS_URL}/?mod={$mod}&act=restore&gallery_id={$core->encryptID($allItem[i].gallery_id)}{$pUrl}">
										<i class="icon-refresh"></i> {$core->get_Lang('restore')}
									</a>
								</li>

								<li>
									<a class="dropdown-item confirm_delete"
									title="{$core->get_Lang('delete')}"
									href="{$PCMS_URL}/?mod={$mod}&act=delete&gallery_id={$core->encryptID($allItem[i].gallery_id)}{$pUrl}">
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
        </table>
        {$clsISO->getPaginationAdmin($totalRecord,$totalPage,$currentPage,$listPageNumber,$link_page_current,$type)}
	</div>
</div>
<script type="text/javascript">
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}';
</script>
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
			$.post(path_ajax_script+"/index.php?mod=gallery&act=ajUpdPosSortList", order, 
			
			function(html){
				vietiso_loading(0);
				location.href = REQUEST_URI;
			});
		}
	});
</script>
{/literal}