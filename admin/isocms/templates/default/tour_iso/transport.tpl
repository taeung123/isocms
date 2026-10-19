<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('tours')}</a>
	<a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act=setting">{$core->get_Lang('setting')}</a>
	<a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('transport')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('transport')}</h2>
        <p>{$core->get_Lang('systemmanagementtransport')}</p>
    </div>
    <div class="fiterbox" style="width:80%">
        <div class="wrap">
            <div class="searchbox" style="float:left !important; width:100%">
                <input type="text" class="m-wrap short" name="keyword" id="keyword" placeholder="{$core->get_Lang('search')}" />
                <a href="javascript:void(0);" class="btn btn-success btnCreateNewTransport" _type="TRANSPORT">
                    <i class="icon-plus icon-white"></i> <span>{$core->get_Lang('add')}</span> 
                </a>
            </div>
        </div>
    </div>
    <div class="hastable">
        <table class="tbl-grid" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td class="gridheader" style=" width:4%"><strong>{$core->get_Lang('images')}</strong></td>
                <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></td>
                <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('description')}</strong></td>
                <td class="gridheader" colspan="4" style="width:3%"><strong>{$core->get_Lang('move')}</strong></td>
                <td class="gridheader" style="width:3%;text-align:center"><strong>{$core->get_Lang('func')}</strong></td>
            </tr>
            <tbody id="tblHolderTransport">
            </tbody>
        </table>
        <div class="clearfix" style="height:5px"></div>
            <div class="pagination_box">
            <div class="wrap holderEvent_tbl" id="dataTable_paginate">
            <!-- Ajax Loading pagination -->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">var insert_error_exist = '{$core->get_Lang("insert_error_exist")}';</script>
{literal}
<script type="text/javascript">
$(document).ready(function(){
	var aj_search = '';
	loadTransport('',1,20);
	$('#keyword').bind('keyup change',function(){
		var $_this = $(this);
		loadTransport($_this.val(),1,20);
	});
	$(document).on('click', '.btnCreateNewTransport', function(ev){
		var $_this = $(this);
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajOpenTransport',
			data :  {
				'type' : $_this.attr('_type'),
				'tp' : 'F'
			},
			dataType:'html',
			success:function(html){
				vietiso_loading(0);
				makepopupnotresize(600,'auto',html,'pop_OpenTransport');
			}
		});
		return false;
	});
	$(document).on('click', '.btnedit_transport', function(ev){
		var $_this = $(this);
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url:path_ajax_script+'/index.php?mod='+mod+'&act=ajOpenTransport',
			data : {'tour_property_id' : $_this.attr('data'),'tp':'F'},
			dataType:'html',
			success:function(html){
				vietiso_loading(0);
				makepopupnotresize(600,'auto',html,'pop_OpenTransport');
			}
		});
		return false;
	});
	$(document).on('click', '.ajSubmitTransport', function(ev){
		var $_this = $(this);
		var $title = $('input[name=title]');
		var $intro = $('textarea[name=intro]');
		var $order_no = $('input[name=order_no]');
		var $image = $('input[name=image]');
		/**/
		if($title.val()==''){
			$title.focus();
			alertify.error(field_is_required);
			return false;
		}
		if($order_no.val()==''){
			$order_no.focus();
			alertify.error(field_is_required);
			return false;
		}
		var adata = {
			'title'		: $title.val(),
			'intro'		: $intro.val(),
			'order_no' 	: $order_no.val(),
			'image' 	: $image.val(),
			'type' : $_this.attr('_type'),
			'tour_property_id' : $_this.attr('tour_property_id'),
			'tp' : 'S'
		};
		vietiso_loading(1);
		$.ajax({
			type:'POST',
			url : path_ajax_script+'/index.php?mod='+mod+'&act=ajOpenTransport',
			data:adata,
			dataType:'html',
			success:function(html){
				vietiso_loading(0);
				if(html.indexOf('_INSUCCESS')>=0){
					loadTransport('',1,10);
					$('#pop_OpenTransport .close_pop').trigger('click');
				}
				if(html.indexOf('_UPSUCCESS')>=0){
					var $keyword = $('#keyword').val();
					var $page = $('.paginate_current_page').val();
					var $number_per_page = $('.paginate_length').val();
					loadTransport($keyword,$page,$number_per_page);
					$('#pop_OpenTransport .close_pop').trigger('click');
				}
				if(htm=='_ERROR'){
					alertify.error(insert_error);
				}
				if(htm=='_EXIST'){
					alertify.error(insert_error_exist);
				}
			}
		});
	});
	$(document).on('click', '.btndelete_transport', function(ev){
		var $_this = $(this);
		if(confirm(confirm_delete)){
			vietiso_loading(1);
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajOpenTransport',
				data : {'tour_property_id': $_this.attr('data'), 'tp':'D'},
				dataType:'html',
				success:function(html){
					var $keyword = $('#keyword').val();
					var $page = $('.paginate_current_page').val();
					var $number_per_page = $('.paginate_length').val();
					loadTransport($keyword,$page,$number_per_page);
					vietiso_loading(0);
				}
			});
		}
		return false;
	});
	$(document).on('click', '.btnmove_transport', function(ev){
		var $_this = $(this);
		vietiso_loading(1);
		$.ajax({
			type: "POST",
			url: path_ajax_script+"/?mod="+mod+"&act=ajOpenTransport",
			data: {'tour_property_id' : $_this.attr('data'),'direct' : $_this.attr('direct'),'tp':'M'},
			dataType: "html",
			success: function(html){
				vietiso_loading(0);
				var $keyword = $('#keyword').val();
				var $page = $('.paginate_current_page').val();
				var $number_per_page = $('.paginate_length').val();
				loadTransport($keyword,$page,$number_per_page);
			}
		});
		return false;
	});
	$('.paginate_length').live('change',function(){
		var $_this = $(this);
		var $keyword = $('#keyword').val();
		var $page = 1;
		var $number_per_page = $_this.val();
		loadTransport($keyword,$page,$number_per_page);
	});
	$('.paginate_button').live('click',function(){
		var $_this = $(this);
		if(!$_this.hasClass('disabled')){
			var $keyword = $('#keyword').val();
			var $page = $_this.attr('page');
			var $number_per_page = $('.paginate_length').val();
			loadTransport($keyword,$page,$number_per_page);
		}
		return false;
	});
});
function loadTransport($keyword,$page, $number_per_page){
	var adata = {
		'keyword' : $keyword,
		'page'	: $page,
		'number_per_page' : $number_per_page,
		'tp' : 'L'
	};
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/?mod="+mod+"&act=ajOpenTransport",
		data: adata,
		dataType: "html",
		success: function(html){
			vietiso_loading(0);
			var $htm = html.split('$$');
			$('#tblHolderTransport').html($htm[0]);
			$('#dataTable_paginate').html($htm[1]);
		}
	});
}
</script>
{/literal}