<script type="text/javascript" src="{$URL_JS}/chart/highcharts.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/chart/series-label.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/chart/exporting.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/chart/export-data.js?v={$upd_version}"></script>
{$clsCity->getCategoriesChart()|var_dump}
<script type="text/javascript">
	var category_char='{$clsCity->getCategoriesChart()}';
</script>
<div class="page_container">
	<div class="container">
		<div id="container"></div>
		{literal}
		<style type="text/css">
		#container {
			min-width: 310px;
			max-width: 800px;
			height: 400px;
			margin: 0 auto
		}
		</style>
		<script type="text/javascript">
		$(function () {
            (function getAjaxData(){
			$.getJSON(DOMAIN_NAME+'/chart/chart_data/?city_id=1', function(chartData) {
				Highcharts.chart('container', {
				
					title: {
						text: 'Solar Employment Growth by Sector, 2010-2016'
					},
				
					subtitle: {
						text: 'Source: thesolarfoundation.com'
					},
				
					yAxis: {
						title: {
							text: 'Number of Employees'
						}
					},
					legend: {
						layout: 'vertical',
						align: 'right',
						verticalAlign: 'middle'
					},
					plotOptions: {
						series: {
							label: {
								connectorAllowed: false
							},
							pointStart: 0
						}
					},
				
					series:chartData,
				
					responsive: {
						rules: [{
							condition: {
								maxWidth: 500
							},
							chartOptions: {
								legend: {
									layout: 'horizontal',
									align: 'center',
									verticalAlign: 'bottom'
								}
							}
						}]
					}
				});
			});
            })();
        });
		</script>
		{/literal}
		
		<div id="container2"></div>


{literal}
		<script type="text/javascript">
Highcharts.chart('container2', {

    chart: {
        polar: true,
        type: 'line'
    },

    accessibility: {
        description: 'A spiderweb chart compares the allocated budget against actual spending within an organization. The spider chart has six spokes. Each spoke represents one of the 6 departments within the organization: sales, marketing, development, customer support, information technology and administration. The chart is interactive, and each data point is displayed upon hovering. The chart clearly shows that 4 of the 6 departments have overspent their budget with Marketing responsible for the greatest overspend of $20,000. The allocated budget and actual spending data points for each department are as follows: Sales. Budget equals $43,000; spending equals $50,000. Marketing. Budget equals $19,000; spending equals $39,000. Development. Budget equals $60,000; spending equals $42,000. Customer support. Budget equals $35,000; spending equals $31,000. Information technology. Budget equals $17,000; spending equals $26,000. Administration. Budget equals $10,000; spending equals $14,000.'
    },

    title: {
        text: 'Budget vs spending',
        x: -80
    },

    pane: {
        size: '80%'
    },

    xAxis: {
        categories: [category_char],
        tickmarkPlacement: 'on',
        lineWidth: 0
    },

    yAxis: {
        gridLineInterpolation: 'polygon',
        lineWidth: 0,
        min: 0
    },

    tooltip: {
        shared: true,
        pointFormat: '<span style="color:{series.color}">{series.name}: <b>${point.y:,.0f}</b><br/>'
    },

    legend: {
        align: 'right',
        verticalAlign: 'middle'
    },

    series: [{
        name: 'Allocated Budget',
        data: [43000, 19000, 60000, 35000, 17000, 10000],
        pointPlacement: 'on'
    }, {
        name: 'Actual Spending',
        data: [50000, 39000, 42000, 31000, 26000, 14000],
        pointPlacement: 'on'
    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    align: 'center',
                    verticalAlign: 'bottom'
                },
                pane: {
                    size: '70%'
                }
            }
        }]
    }

});
		</script>
		{/literal}
	</div>
</div>