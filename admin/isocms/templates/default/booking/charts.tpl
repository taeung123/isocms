<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act=charts">{$core->get_Lang('bookingmanagement')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
		<h2>{$core->get_Lang('Charts')}</h2>
        <p>{$core->get_Lang('Here you can find all the important figures regarding your revenue and fees')}</p>
    </div>
	<div class="clearfix"></div>
    <div class="hastable">
    	<div class="demo-container" id="demo-container">
						
		</div>
    </div>
</div>
{literal}
<script type="text/javascript">
	$(function(){
		loadChartBooking();
	});
	function loadChartBooking(){
		vietiso_loading(1);
		$.ajax({
			type: "POST",
			url: path_ajax_script+'/?mod=home&act=ajLoadChartBooking2',
			dataType: "html",
			success: function(html){
				vietiso_loading(0);
				$('#demo-container').html(html);
			}
		});
	}
</script>
{/literal}