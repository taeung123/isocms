<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('hotels pro')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}">{$core->get_Lang('hoteltop')}</a>
    <!-- Begin back-->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('hoteltopmanagement')}.</h2>
        <p>{$core->get_Lang('systemmanagementtophotels')}</p>
    </div>
    <div class="clearfix"><br /></div>
	<form id="forums" method="post" action="" name="filter" class="filterForm">
	{literal}
		<script type="text/javascript">
			$().ready(function() {
				$('.filterForm select').change(function() {
					$('#forums').submit();
				});
			});
		</script>
	{/literal}
	<table class="form" cellpadding="3" cellspacing="3">
		<tr>
			<td class="fieldlabel">{$core->get_Lang('country')}</td>
			<td class="fieldarea">
				<select class="slb" onchange="$('#slb_City').val(0);" name="country_id" id="slb_Country">
					{$clsCountry->makeSelectboxOption($country_id)}
				</select>
			</td>
			<td class="fieldlabel">{$core->get_Lang('cities')}</td>
			<td class="fieldarea">
				<select class="slb" name="city_id" id="slb_City">
					{$clsCity->getSelectCity($country_id,0,$city_id)}
				</select>
			</td>
			<td class="fieldlabel span15">{$core->get_Lang('search')}</td>
			<td class="fieldarea">
				<div class="searchbox">
					<input autocomplete="off" type="text" class="text SearchKey" placeholder="{$core->get_Lang('search')}..." /> 
					<a href="javascript:void();" class="btn btn-success" id="SiteClickSearch">
						<i class="icon-search icon-white"></i>
					</a>
					<a href="javascript:void();" class="iso-button-primary" id="ClickOpenSearchHotel">
						<i class="icon-search icon-white"></i> {$core->get_Lang('add')}
					</a>
					<input type="hidden" name="filter" value="filter" />
				</div>
			</td>
		</tr>
	</table>
	</form>
    <div class="clearfix"><br /></div>
    <div class="wrap">
		<table cellspacing="0" class="tbl-grid">
		<tr>
			<td class="gridheader"><strong>{$core->get_Lang('index')}</strong></td>
			<td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('nameofhotels')}</strong></td>
            <td class="gridheader" style="width:8%"><strong>{$core->get_Lang('rating')}</strong></td>
            <td class="gridheader" style="width:8%"><strong>{$core->get_Lang('hotelstyles')}</strong></td>
            <td class="gridheader" style="text-align:center;"><strong>{$core->get_Lang('pricefrom')}</strong></td>
			<td class="gridheader" colspan="4" style="width:8%">{$core->get_Lang('move')}</td>
			<td class="gridheader" style=" width:3%;text-align:center"><i class="icon-remove"></i></td>
		</tr>
		<tbody id="tblHoderHotel">
			<tr>
				<td colspan="10">{$core->get_Lang('loading')}</td>
			</tr>
		</tbody>
		</table>
		<div class="pagination_box mt5">
			<div class="wrap" id="dataTable_paginate">
			</div>
		</div>
    </div>
</div>
<script type="text/javascript">
	var aj_search='';
	var $fromid = '{$fromid}';
	var $target_id = "{$target_id}";
</script>
{literal}
<style>
	.listSearchQuick{ max-height:400px;}
</style>
<script type="text/javascript">
	$().ready(function(){
		loadHotelTop($target_id, $fromid, '', 1, 20);
		
		$(document).on('click', '#ClickOpenSearchHotel', function(ev){
			var $_this = $(this);
			var adata = {};
			adata['fromid'] = $fromid;
			adata['target_id'] = $target_id;
			adata['tp'] = 'F';
			
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script+"/index.php?mod="+mod+"&act=PopSearchHotel",
				data: adata,
				dataType: "html",
				success: function(html){
					vietiso_loading(0);
					makepopup('460px','auto',html,'pop_SiteSearchHotel');
					$('#pop_SiteSearchHotel').css('top','60px');
				}
			});
			return false;
		});
		$(document).on('keyup', '#SitePopSeachHotel', function(ev){
			var $_this = $(this);
			var $_key = $.trim($_this.val());
			if($_key != ''){
				var adata = {};
				adata['keyword'] = $_key;
				adata['target_id'] = $_this.attr('target_id');
				adata['fromid'] = $_this.attr('fromid');
				adata['tp'] = 'S';
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script+"/index.php?mod="+mod+"&act=PopSearchHotel",
					data: adata,
					dataType: "html",
					success: function(html){
						vietiso_loading(0);
						var $htm = html.split('$$');
						if($htm != 'EMPTY'){
							$('#listSearchQuick').html($htm[0]);
						}
					}
				});
				return false;
			}else{
				$('#listSearchQuick').html('');
			}
		});
		$(document).on('click', '.ClickChoiceHotel', function(ev){
			var $_this = $(this);
			var adata = {};
			adata['target_id'] = $_this.attr('target_id');
			adata['fromid'] = $_this.attr('fromid');
			adata['hotel_id'] = $_this.attr('data');
			
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script+"/index.php?mod="+mod+"&act=SiteSaveHotelTop",
				data: adata,
				dataType: "html",
				success: function(html){
					vietiso_loading(0);
					if(html.indexOf('_SUCCESS') >= 0){
						$_this.slideUp();
						loadHotelTop($_this.attr('target_id'), $_this.attr('fromid'),'',1,20);
					}
				}
			});
			return false;
		});
		$(document).on('click', '#SiteClickSearch', function(ev){
			var $SearchKey = $.trim($('.SearchKey').val());
			vietiso_loading(1);
			loadHotelTop($target_id, $fromid, $SearchKey ,1,20);
			return false;
		});
		$(document).on('click', '.btn_delete_hoteltop', function(ev){
			if(confirm(confirm_delete)){
				var $_this = $(this);
				var $target_id = $_this.attr('target_id');
				var $fromid = $_this.attr('fromid');
				var adata = {
					'hoteltop_id' : $_this.attr('data'),
					'tp': 'D'
				};
				vietiso_loading(1);
				$.ajax({
					type:'POST',	
					url:path_ajax_script+'/index.php?mod='+mod+'&act=PopSearchHotel',	
					data: adata,	
					dataType:'html',	
					success:function(html){
						vietiso_loading(0);
						var $page = $('.Hid_CurrentPage').val();
						var $number_per_page = $('.paginate_length').val();
						loadHotelTop($target_id, $fromid, '', $page, $number_per_page);
					}
				});
			}
			return false;
		});
		$(document).on('click', '.paginate_button', function(ev){
			if($(this).hasClass('disabled')){
				return false;
			}
			var $number_per_page = $('.paginate_length').val();
			loadHotelTop($target_id, $fromid, '', $(this).attr('page'), $number_per_page);
			return false;
		});
		$(document).on('change', '.paginate_length', function(ev){
			var $page = $('.Hid_CurrentPage').val();
			loadHotelTop($target_id, $fromid, '', $page, $(this).val());
		});
		$(document).on('click', '.btn_move_hoteltop', function(ev){
			var $_this = $(this);
			var $target_id = $_this.attr('target_id');
			var $fromid = $_this.attr('fromid');
			var adata = {
				'hoteltop_id' : $_this.attr('data'),
				'direct' : $_this.attr('direct'),
				'target_id' : $target_id,
				'fromid' : $fromid
			};
			vietiso_loading(1);
			$.ajax({
				type:'POST',	
				url:path_ajax_script+'/index.php?mod='+mod+'&act=SiteMoveHotelTop',	
				data: adata,	
				dataType:'html',	
				success:function(html){
					vietiso_loading(0);
					var $page = $('.Hid_CurrentPage').val();
					var $number_per_page = $('.paginate_length').val();
					loadHotelTop($target_id, $fromid, '', $page, $number_per_page);
				}
			});
			return false;
		});
	});
	function loadHotelTop($target_id, $fromid, $keyword, $page, $number_per_page){
		var adata = {};
		adata['target_id'] = $target_id;
		adata['fromid'] = $fromid;
		adata['keyword'] = $keyword;
		adata['page'] = $page;
		adata['number_per_page'] = $number_per_page;
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=SiteLoadHotelTop',
			data: adata,
			dataType:'html',	
			success:function(html){
				vietiso_loading(0);
				var $htm = html.split('$$');
				$('#tblHoderHotel').html($htm[0]);
				$('#dataTable_paginate').html($htm[1]);
			}
		});
	}
</script>
{/literal}