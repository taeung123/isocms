<div class="page_container" id="tour_page_container">
    <section id="booking" class="pd40_0 color_f9f9f9">
		<div class="container">
			<form action="" method="post" id="formBookingTour" class="formBookingTour">
				<h1 class="mb20 size35">{$core->get_Lang('Payment details')}</h1>
				<div class="row">
					<div class="col_right_fixed" id="sidebar">
							<div class="btn-booking">
							<input type="hidden" name="totalFinal" class="totalFinal" value="{$totalPricePaymentNowFinal}">
								<button id="btn_booking" class="btn-bookinggroup btn_main" type="button">
									{$core->get_Lang('Payment')}
								</button>
								<input type="hidden" name="booking" value="booking">
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
</div>
{literal}
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$('#btn_booking').click(function(){
			var $_this = $(this);
			$.ajax({
				type: 'POST',
				url: path_ajax_script+'/index.php?mod=cart&act=vtcpay_link',
				data:{'clsTable' : $_this.data('clsTable'),'target_id': $_this.data('data')},
				dataType:'html',
				success: function(html){
					
				}
			});
		});
	})
</script>
{/literal}