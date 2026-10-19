<script src="{$URL_JS}/highchart/highcharts.js?v={$upd_version}"></script>
<script src="{$URL_JS}/highchart/exporting.js?v={$upd_version}"></script>
<script src="{$URL_JS}/highchart/export-data.js?v={$upd_version}"></script>
<script src="{$URL_JS}/highchart/accessibility.js?v={$upd_version}"></script>
<div id="booking_chart"></div>

{literal}
<style>
.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-top {
    right: auto;
    left: 305px !important;
}
</style>
<script>
	$(document).ready(function(){
		fillter_chart('all');
		$('.year_chart_booking').change(function(){
			var cat = $('.right_chart_booking input[type=radio]:checked').val();
			fillter_chart(cat);
		});
		$('.right_chart_booking .checkmark').click(function(){
			var cat = $(this).prev().val();
			fillter_chart(cat);
		});
	});

	
	function fillter_chart(cat){
		var year = $('.year_chart_booking').val();
		
		$.ajax({
			type: "POST",
			data: {year:year,cat:cat},
			dataType:'json',
			async:false,
			url: path_ajax_script+"/index.php?mod=home&act=ajaxChartBooking",
			success: function(json){
				setTimeout(function () {
					var width_booking_chart=$(".performance_box").width() - 438;
					Highcharts.chart('booking_chart', {
						chart: {
							type: 'area',
							 width: width_booking_chart,
						},
						accessibility: {
							description: 'Booking'
						},
						title: {
							text: ''
						},
						subtitle: {
							text: ''
						},
						xAxis: {
							allowDecimals: false,
							labels: {
								formatter: function () {
									return this.value; // clean, unformatted number for year
								}
							},
							accessibility: {
								rangeDescription: 'Range: 1 to 12.'
							}
						},
						yAxis: {
							title: {
								text: ''
							},
							labels: {
								formatter: function () {
									return this.value;
								}
							}
						},
						tooltip: {
							pointFormat: '{series.name} <b>{point.y:,.0f}</b>'
						},
						plotOptions: {
							area: {
								pointStart: 1,
								marker: {
									enabled: false,
									symbol: 'circle',
									states: {
										hover: {
											enabled: false
										}
									}
								}
							}
						},
						series: [{
							name: 'Booking thành công',
							color: 'rgba(116, 174, 118, 1)',
							data: json.itemSuccess,
						}, {
							name: 'Booking đã hủy',
							color: 'rgba(246, 164, 118, 1)',
							data: json.itemFail,
						}],
						legend: {
							layout: 'vertical',
							align: 'right',
							verticalAlign: 'bottom',
							symbolRadius: 0 
							
						  },
						exporting: {
							enabled: false
						},
						credits: {
							 enabled: false
						},
					});
					}, 2000);

			},
		});
		
	}

</script>
<style>
.highcharts-container{
  width: 100% !important;
}

.highcharts-root{
  width: 100% !important;
}
</style>
{/literal}