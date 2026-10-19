<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$curl}" title="{$mod}">{$core->get_Lang('Tour')} {$clsTourStore->getTitle($type)}</a>    
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
	<div class="page-title">
		<h2>{$core->get_Lang('Tour')} {$clsTourStore->getTitle($type)}</h2>
		<p>Chức năng quản lý danh sách các {$core->get_Lang('Tour')} {$clsTourStore->getTitle($type)} trong hệ thống isoCMS</p>
		<p>This function is intended to manage {$core->get_Lang('Tour')} {$clsTourStore->getTitle($type)} in isoCMS system</p>
	</div>
    <div class="wrap">
        <div class="hastable fl" style="width:52%">
        	<form id="forums" method="post" class="filterForm" action="">
                <div class="fiterbox">
                    <div class="wrap">
                        <div class="searchbox" style="float:left !important; width:100%">
                            <input type="text" class="m-wrap short" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}..." />
                            <a class="btn btn-success fileinput-button" href="javascript:void();" id="searchbtn" style="padding:5px">
                                <i class="icon-search icon-white"></i>
                            </a>
                            <input type="hidden" name="filter" value="filter" />
                        </div>
                    </div>
                </div>
            </form>
            <table cellspacing="0" class="tbl-grid" width="100%">
                <tr>
                	<td class="gridheader"></td>
                    <td class="gridheader"><strong>{$core->get_Lang('index')}</strong></td>
                    <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('nameofcity')}</strong></td>
                    <td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('func')}</strong></td>
                </tr>
                {if $listItem[0].tour_id ne ''}
                {section name=i loop=$listItem}
                <tr class="{cycle values="row1,row2"}">
                	<td class="index"><input class="chkitem" name="chkid_tour[]" value="{$listItem[i].tour_id}" type="checkbox"></td>
                    <td class="index">{$smarty.section.i.iteration+$stt}</td>
                    <td><strong style="font-size:18px; line-height:24px">{$clsClassTable->getTitle($listItem[i].tour_id)}</strong></td>
                    </td>
                    <td style="vertical-align:middle; width:65px; text-align:right; white-space:nowrap;">
                        <a class="iso-button-action" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Add&type={$core->encryptID($type)}&tour_id={$listItem[i].tour_id}" title="{$core->get_Lang('Add this tour')}"><i class="icon-plus-sign icon-white"></i> {$core->get_Lang('Add')}</a>
                    </td>
                </tr>
                {/section}
                {else}
                <tr><td colspan="6" style="text-align:center">{$core->get_Lang('No Data')}!</td></tr>
                {/if}
            </table>
            <input type="hidden" id="list_selected_chkitem" />
            <div class="clearfix" style="height:10px"></div>
            <div style="width:100%; padding:2%; background: #fff;border:1px solid #ccc">
                <label><input type="checkbox" id="check_all" /> {$core->get_Lang('selectall')}</label>
                <a _type="{$type}" class="btn btn-success fileinput-button clickToSaveTourStore"> 
                    <i class="icon-plus icon-white"></i> 
                    <span>{$core->get_Lang('Save')}</span>
                </a>
            </div>
            <div class="clearfix"></div>
            <div class="adminPaging">
                <ul class="lstAdminPaging">
                {section name=i loop=$listPageNumber}
                    <li>
                        <a href="{$PCMS_URL}/{$link_page_current}&page={$listPageNumber[i]}" {if $listPageNumber[i] eq $currentPage}class="active"{/if}>{$listPageNumber[i]}</a>
                    </li>
                {/section}
                </ul>
                <div class="report">
                    <strong>{$core->get_Lang('statistical')}</strong>: <strong>{$totalRecord}</strong> {$core->get_Lang('records')}/<strong>{$totalPage}</strong> {$core->get_Lang('page')}. {$core->get_Lang('youareonpagenumber')} <strong>{$currentPage}</strong>.
                </div>
            </div>
        </div>
        <div class="hastable fr" style="width:46%">
            <div class="fiterbox">
                <div class="wrap">
                    <div class="searchbox" style="float:left !important; width:100%">
                    	<h1 style="font-family:Cambria; font-weight:bold; font-style:italic;">{$clsTourStore->getTitle($type)} {$core->get_Lang('selected')}</h1>
                    </div>
                </div>
            </div>
            <table cellspacing="0" class="tbl-grid">
                <tr>
                    <td class="gridheader"><strong>{$core->get_Lang('index')}</strong></td>
                    <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('nameofcity')}</strong></td>
                    <!--<td class="gridheader" colspan="4" style="width:4%"><strong>{$core->get_Lang('move')}</strong></td>-->
                    <td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('func')}</strong></td>
                </tr>
                {if $listSelected[0].tour_id ne ''}
				<tbody id="SortAble">
					{section name=i loop=$listSelected}
					<tr style="cursor:move" id="order_{$listSelected[i].tour_id}" class="{cycle values="row1,row2"}">
						<td class="index">{$smarty.section.i.index+1}</td>
						<td><strong style="font-size:18px; line-height:24px">{$clsClassTable->getTitle($listSelected[i].tour_id)}</strong></td>
						</td>
						<td style="vertical-align: middle; width: 65px; text-align: right; white-space: nowrap;">
							<div class="btn-group">
								<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> 
								<i class="icon-cog"></i> <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" style="right:0px !important">
									<li><a href="{$DOMAIN_NAME}{$clsClassTable->getLink($listSelected[i].tour_id)}" target="_blank" title="{$core->get_Lang('view')}"><i class="icon-eye-open"></i> <span>{$core->get_Lang('view')}</span></a></li>
									<li><a title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/tour/insert/{$listSelected[i].tour_id}/overview"><i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span></a></li>
									<li><a title="{$core->get_Lang('delete')}" class="clkDeleteTourStore"  _tour_store_id="{$listSelected[i].tour_store_id}" href="javascript:void(0);"><i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span></a></li>
								</ul>
							</div>
						</td>
					</tr>
					{/section}
                </tbody>
				{else}
                <tr><td colspan="7" style="text-align:center">{$core->get_Lang('No Data')}!</td></tr>
                {/if}
            </table>
        </div>
    </tr>
</div>
{literal}<style>.disabled{-moz-opacity:.8;-webkit-opacity:.8;-o-opacity:.8;opacity:.8;filter:anpha(opacity=80)}</style>{/literal}
<script type="text/javascript">
var required_country = "{$core->get_Lang('You not selected country')}";
var required_city = "{$core->get_Lang('You not selected city')}";
</script>
{literal}
<script type="text/javascript">
$().ready(function(){
	$(document).on('click', '.clkDeleteTourStore', function(ev){
		if(confirm(confirm_delete)){
			var $_this = $(this);
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajDeleteTourStore',
				data: {'tour_store_id': $_this.attr('_tour_store_id')},
				dataType: "html",
				success: function(html){
					window.location.reload(true);
				}
			});
		}
	});
	
	$(document).on('click', '.clickToSaveTourStore', function(ev){
		var _this = $(this);
		if($('#list_selected_chkitem').val()==''){
			alertify.error(required_city);
			return false;
		}
		var adata = {
			'list_tour_id' : $('#list_selected_chkitem').val(),
			'type' : _this.attr('_type')
		};
		_this.find('span').text(loading);
		$.ajax({
			type: "POST",
			url: path_ajax_script+"/index.php?mod="+mod+"&act=ajSaveStoreForTour",
			data: adata,
			dataType: "html",
			success: function(html){
				_this.find('span').text(save);
				$('#check_all').removeAttr('checked');
				window.location.reload(true);
			}
		});
	});
});
</script>
{/literal}

<script type="text/javascript">
	var $type = '{$type}';
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
			var type = $type;
			var recordPerPage = $recordPerPage;
			var currentPage = $currentPage;
			var order = $(this).sortable("serialize")+'&update=update'+'&recordPerPage='+recordPerPage+'&currentPage='+currentPage+'&type='+type;
			$.post(path_ajax_script+"/index.php?mod=tour&act=ajUpdPosSortTourStore", order, 
			
			function(html){
				vietiso_loading(0);
				window.location.reload(true);
			});
		}
	});
</script>
{/literal}