<link rel="stylesheet" type="text/css" href="{$URL_CSS}/bootstrap.css" />
<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$mod|capitalize}</a>
     <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}&{$pkeyTable}={$pvalTable}" title="{$act}">{$act|capitalize} #{$pvalTable}</a>
    <!--// -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">	
        <h2>{$core->get_Lang('Price Table Managerment')}</h2>
        <p>
        	{$core->get_Lang('System managerment')} &nbsp;&nbsp;&nbsp;
        	<a class="btn btn-success fileinput-button" href="{$clsClassTable->getLink($pvalTable)}" target="_blank" style="color:#fff" title="Xem"> 
            	<i class="icon-eye-open icon-white"></i> 
            </a>
        </p>
    </div>
    <div class="clearfix"></div>
	<script type="text/javascript">
        var hotel_id='{$pvalTable}';
        var mod='{$mod}';
        var path_ajax_request='{$PCMS_URL}';
    </script>
    <div class="widget">
        <h2 class="header">{$core->get_Lang('pricetablehotels')} - {$clsClassTable->getTitle($pvalTable)}  </h2>
        <div class="content">
            <div class="wrap">
                <div class="btn-group">                                       
                    <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" style="margin:0 0 10px">
                    	{$core->get_Lang('action')} <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                    	<li><a href="#" id="addHotelPriceRow"><i class="icon-list"></i> {$core->get_Lang('addrooms')}</a></li>
                        <li><a href="#" id="addHotelPriceCol"><i class="icon-barcode"></i> {$core->get_Lang('addbed')}</a></li>
                    </ul>
                </div>
            </div>
            <br />
            <div id="HotelPriceTable">{$core->get_Lang('No data')} !</div>
        </div>
    </div>
</div>  
{literal}
<script type="text/javascript">

	$('.frmPop .clickToClose').live('click',function(){
		var idtmp =$(this).closest('.frmPop');
		$('#isoblanketpop_'+idtmp.attr('id')).remove();
		idtmp.remove();	
	});
	$("tr:odd").css("background-color","#f9f9f9");
	
	$('#addHotelPriceRow').live('click',function(){
		var _this = $(this);
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_request+'/index.php?mod=hotelpro&act=ajLoadNewHotelPriceRow', 
			dataType:'html', 
			data: {'hotel_id':hotel_id},
			success: function(html){
				vietiso_loading(0);
				$('.dropdown-toggle').trigger('click');
				makepopup('400','',html,'NewHotelPriceRow');
			}
		});
		return false;
	});
	$('#addHotelPriceCol').live('click',function(){
		var _this = $(this);
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_request+'/index.php?mod=hotelpro&act=ajLoadNewHotelPriceCol', 
			dataType:'html', 
			data: {'hotel_id':hotel_id},
			success: function(html){
				vietiso_loading(0);
				$('.dropdown-toggle').trigger('click'); 
				makepopup('400','',html,'NewHotelPriceCol');
			}
		});
		return false;
	});
	loadHotelPrice();
	function loadHotelPrice(){
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_request+'/index.php?mod=hotelpro&act=ajLoadHotelPrice', 
			data: {'hotel_id':hotel_id},
			dataType:'html',
			success: function(html){
				vietiso_loading(0);
				$('#HotelPriceTable').html(html);
			}
		});
	}
	$('#clickToAddHotelPriceCol').live('click',function(){
		var _this = $(this);
		var adata = {
			'hotel_id':hotel_id,
			'title': $('#titleCol').val()
		};
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_request+'/index.php?mod=hotelpro&act=ajAddHotelPriceCol', 
			data: adata,
			dataType:'html',
			success: function(html){
				vietiso_loading(0);
				loadHotelPrice();
				_this.closest('.frmPop').find('.close_pop').click(); 
			}
		});
		return false;
	});
	$('#clickToAddHotelPriceRow').live('click',function(){
		var _this = $(this);
		var adata = {
			'hotel_id':hotel_id,
			'title': $('#titleRow').val()
		};
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_request+'/index.php?mod=hotelpro&act=ajAddHotelPriceRow', 
			data: adata,
			dataType:'html',
			success: function(html){
				vietiso_loading(0);
				loadHotelPrice();
				_this.closest('.frmPop').find('.close_pop').click(); 
			}
		});
		return false;
	});
	
	$('.editHotelPriceCol').live('click',function(){
		var _this = $(this);
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_request+'/index.php?mod=hotelpro&act=ajLoadEditHotelPriceCol', 
			dataType:'html', 
			data: {'id':_this.attr('data')},
			success: function(html){
				vietiso_loading(0);
				makepopup('400','',html,'EditHotelPriceCol');
			}
		});
		return false;
	});
	$('.editHotelPriceRow').live('click',function(){
		var _this = $(this);
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_request+'/index.php?mod=hotelpro&act=ajLoadEditHotelPriceRow', 
			dataType:'html', 
			data: {'id':_this.attr('data')},
			success: function(html){
				vietiso_loading(0);
				makepopup('400','',html,'EditHotelPriceRow');
			}
		});
		return false;
	});
	
	$('#clickToEditHotelPriceRow').live('click',function(){
		var _this = $(this);
		var adata = {
			'id':_this.attr('data'),
			'title': $('#titleRow').val()
		};
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_request+'/index.php?mod=hotelpro&act=ajUpdateHotelPriceRow', 
			data: adata,
			dataType:'html',
			success: function(html){
				vietiso_loading(0);
				loadHotelPrice();
				_this.closest('.frmPop').find('.close_pop').click(); 
			}
		});
		return false;
	});
	$('#clickToEditHotelPriceCol').live('click',function(){
		var _this = $(this);
		var adata = {
			'id':_this.attr('data'),
			'title': $('#titleCol').val()
		};
		vietiso_loading(1);
		$('#clickToCloseEditHotelPriceCol').click();
		$.ajax({
			type: 'POST',
			url: path_ajax_request+'/index.php?mod=hotelpro&act=ajUpdateHotelPriceCol', 
			data: adata,
			dataType:'html',
			success: function(html){
				vietiso_loading(0);
				loadHotelPrice();
			}
		});
		return false;
	});
	$('.deleteHotelPriceRow').live('click',function(){
		if(confirm(confirm_delete)){
			var _this = $(this);
			vietiso_loading(1);
			$.ajax({
				type: 'POST',
				url: path_ajax_request+'/index.php?mod=hotelpro&act=ajDeleteHotelPriceRow', 
				data: {'id':_this.attr('data')},
				dataType:'html',
				success: function(html){
					vietiso_loading(0);
					loadHotelPrice();
				}
			});
		}
		return false;
	});
	$('.deleteHotelPriceCol').live('click',function(){
		if(confirm(confirm_delete)){
			var _this = $(this);
			vietiso_loading(1);
			$.ajax({
				type: 'POST',
				url: path_ajax_request+'/index.php?mod=hotelpro&act=ajDeleteHotelPriceCol', 
				data: {'id':_this.attr('data')},
				dataType:'html',
				success: function(html){
					vietiso_loading(0);
					loadHotelPrice();
				}
			});
		}
		return false;
	});
	
	$('.editHotelPriceVal').live('click',function(){
		var _this = $(this);
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_request+'/index.php?mod=hotelpro&act=ajLoadEditHotelPriceVal', 
			dataType:'html', 
			data: {
				'hotel_price_col_id':_this.attr('hotel_price_col_id'),
				'hotel_price_row_id':_this.attr('hotel_price_row_id')
			},
			success: function(html){
				vietiso_loading(0);
				makepopup('400','',html,'EditHotelPriceVal');
			}
		});
		return false;
	});
	$('#clickToEditHotelPriceVal').live('click',function(){
		var _this = $(this);
		var adata = {
			'hotel_id':hotel_id,
			'hotel_price_col_id':_this.attr('hotel_price_col_id'),
			'hotel_price_row_id':_this.attr('hotel_price_row_id'),
			'price': $('#titleVal').val()
		};
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_request+'/index.php?mod=hotelpro&act=ajUpdateHotelPriceVal', 
			data: adata,
			dataType:'html',
			success: function(html){
				vietiso_loading(0);
				loadHotelPrice();
				_this.closest('.frmPop').find('.close_pop').click(); 
			}
		});
		return false;
	});
	$('.moveHotelPriceRow').live('click',function(){
		var _this = $(this);
		var adata = {
			'id':_this.attr('data'),
			'direct': _this.attr('direct')
		};
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_request+'/index.php?mod=hotelpro&act=ajMoveHotelPriceRow', 
			data: adata,
			dataType:'html',
			success: function(html){
				vietiso_loading(0);
				loadHotelPrice();
			}
		});
		return false;
	});
	$('.moveHotelPriceCol').live('click',function(){
		var _this = $(this);
		var adata = {
			'id':_this.attr('data'),
			'direct': _this.attr('direct')
		};
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_request+'/index.php?mod=hotelpro&act=ajMoveHotelPriceCol', 
			data: adata,
			dataType:'html',
			success: function(html){
				vietiso_loading(0);
				loadHotelPrice();
			}
		});
		return false;
	});
</script>
{/literal}  
