<div class="page-tour_setting">
	{$core->getBlock('header_title_tour_setting')}
	<div class="container-fluid container-fluid-2 d-flex">
		{$core->getBlock('menu_tour_setting')}
		<div class="content_setting_box">
			<div class="page_detail-title">
				<h2>{$core->get_Lang('Tour')} {$clsTourStore->getTitle($type)}</h2>
				<p>Chức năng quản lý danh sách các {$core->get_Lang('Tour')} {$clsTourStore->getTitle($type)} trong hệ thống isoCMS</p>
				<p>This function is intended to manage {$core->get_Lang('Tour')} {$clsTourStore->getTitle($type)} in isoCMS system</p>
			</div>
			<div class="wrap">
				<div class="filterbox mt10">
					<div class="wrap">
						<div class="searchbox searchbox_new">
							<input id="searchkey_store" placeholder="{$core->get_Lang('Tour name or tour id')}..." type="text" class="text" style="width:285px" />
							<input type="hidden" id="tour_store_id" value="0"/>
							<input type="hidden" id="type_store" value="{$type}"/>
							<a class="btn btn-add_new" id="add_tour_store" href="javascript:void(0);">
								 <span>{$core->get_Lang('Thêm vào')}</span>
							</a>
							<div class="autosugget" id="autosugget">
								<ul class="HTML_sugget"></ul>
								<div class="clearfix"></div>
								<a class="close_Div">{$core->get_Lang('close')}</a>
							</div>
						</div>
					</div>
				</div>
				<table cellspacing="0" class="tbl-grid full-width">
					<thead>
						<tr>
							<th class="gridheader boder_top_none"><strong>{$core->get_Lang('ID')}</strong></th>
							<th class="gridheader boder_top_none" style="text-align:left"><strong>{$core->get_Lang('Title')}</strong></th>
							<th class="gridheader boder_top_none" style="text-align:left"><strong>{$core->get_Lang('Duration')}</strong></th>
							<th class="gridheader boder_top_none" style="text-align:right"><strong>{$core->get_Lang('pricefrom')}</strong></th>
							<th class="gridheader boder_top_none" style="text-align:center"><strong></strong></th>
						</tr>
					</thead>
					{if $listSelected[0].tour_id ne ''}
					<tbody id="SortAble">
						{section name=i loop=$listSelected}
						<tr style="cursor:move" id="order_{$listSelected[i].tour_id}" class="{cycle values="row1,row2"}">
							<td class="index">{$listSelected[i].tour_id}</td>
							<td><span class="title">{$clsClassTable->getTitle($listSelected[i].tour_id)}</span></td>
							</td>
							<td style="text-align: left">{$clsClassTable->getTripDuration2020($listSelected[i].tour_id,'/ ')}</td>
							<td class="block_responsive" style="text-align:right; white-space:nowrap" data-title="{$core->get_Lang('pricefrom')}">
								{if $clsClassTable->getTripPriceNewPro($listSelected[i].tour_id,$now_day,0,'value') gt '0'}
									<span class="format_price">
									{$clsClassTable->getTripPriceNewPro($listSelected[i].tour_id,$now_day,0,'value')} <u>{$clsISO->getShortRate()}</u>
									</span>
								{else}
									<span class="format_price">
									0 <u>{$clsISO->getShortRate()}<u>
									</span>
								{/if}
							</td>

							<td style="vertical-align: middle; width: 65px; text-align: right; white-space: nowrap;">
								<div class="btn-group">
									<a title="{$core->get_Lang('delete')}" class="clkDeleteTourStore"  _tour_store_id="{$listSelected[i].tour_store_id}" href="javascript:void(0);"><i class="icon-trash"></i></a>

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
		</div>
	</div>
</div>
{literal}<style>.disabled{-moz-opacity:.8;-webkit-opacity:.8;-o-opacity:.8;opacity:.8;filter:anpha(opacity=80)}</style>{/literal}
<script type="text/javascript">
var required_country = "{$core->get_Lang('You not selected country')}";
var required_city = "{$core->get_Lang('You not selected city')}";
var type = "{$type}";
</script>
{literal}
<script type="text/javascript">
	
$().ready(function(){
	var aj_search = '';
	$("#searchkey_store").bind('keyup change', function() {
		var $_this = $(this);
		if ($_this.val() != '') {
			clearTimeout(aj_search);
			search_tour_store();
		} else {
			$("#autosugget").stop(false, true).slideUp();
		}
	});
	$(document).on('click', '.clickChooseTourStore', function(ev) {
		var $_this = $(this);
		var title=$_this.data('title');
		var tour_id=$_this.data('tour_id');
		var href=$_this.data('link');
		$('#searchkey_store').val(title);
		$('#tour_store_id').val(tour_id);
		$('#add_tour_store').attr('href',href);
		search_tour_store('Hidden');
		return false;
		
	});
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
function search_tour_store(check) {
	aj_search = setTimeout(function() {
		$.ajax({
			type: 'POST',
			url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajGetSearchStore',
			data: {
				"keyword": $("#searchkey_store").val(),
				"type": type,
				"check": check,
			},
			dataType: 'html',
			success: function(html) {
				if (html.indexOf('_EMPTY') >= 0) {
					$('#autosugget').hide();
				} else {
					$('#autosugget').stop(false, true).slideDown();
					$('#autosugget').find('.HTML_sugget').html(html);
				}
			}
		});
	}, 500);
}
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