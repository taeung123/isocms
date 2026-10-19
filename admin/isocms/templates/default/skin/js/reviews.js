$(document).ready(function(){
	$(".nav_tab_reviews li a").click(function(){
		var $url = $(this).data('url');
		$("#view_all").attr('href',$url);
	});
});
function loadChartReviewAll(data){
	$('#box_chart_all').highcharts({
		chart: {
			animation: false,
			type: 'pie',
			backgroundColor: null
		},
		title: {
			text: null
		},
		tooltip: {
			valueSuffix: $title_chart_column,
			enabled: true
		},
		plotOptions: {
			pie: {
				animation: {
					duration: 750,
					easing: 'easeOutQuad'
				},
				shadow: false,
				center: ['50%', '50%'],
				cursor: 'pointer',
				dataLabels: {
					enabled: false
				}
			},
			series: {
				animation: {
					duration: 750,
					easing: 'easeOutQuad'
				}
			}
		},
		series: [{
			animation: {
				duration: 750,
				easing: 'easeOutQuad'
			},
			name: '',
			data: data,
			size: '100%',
			innerSize: '85%',
			dataLabels: {
				formatter: function () {
					return this.y > 5 ? this.point.name : null;
				},
				color: '#ffffff',
				distance: -50
			}
		}]
	});
}
function loadChartByColumn(option,type,labelSeries=true){
	let data = option.data;
	let colorColumn = option.color;	
	let titleChartColum = option.title;	
	$('#box_chart_'+type).highcharts({
		chart: {
			type: 'column'
		},
		title: {
			align: 'left',
			text: titleChartColum,
			style: {
				fontSize: "13px",
			},			
		},
		subtitle: {
			align: 'left',
			text: ''
		},
		accessibility: {
			announceNewData: {
				enabled: true
			}
		},
		xAxis: {
			type: 'category'
		},
		yAxis: {
			title: {
				text: ''
			},
			allowDecimals: false,

		},
		legend: {
			enabled: false
		},
		plotOptions: {
			series: {
				borderWidth: 0,
				dataLabels: {
					enabled: labelSeries,
				}
			}
		},

		tooltip: {
			headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
			pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> lượt<br/>'
		},

		series: [
			{
				name: "",
				color: colorColumn,
				data: data
			}
		]
	});
}
function loadChartByLine(data,type){
	var color = '#F58321';
	if(type == 'hotel'){
		var color = '#2EA963';
	}
	$('#box_chart_'+type).highcharts({
		chart: {
			type: 'line'
		},
		title: {
			align: 'left',
			text: 'điểm',
			style: {
				fontSize: "13px",
			},			
		},
		xAxis: {
			type: 'category',
			labels: {
				style: {
					whiteSpace: 'normal',
					rotation: 0
				}
			}
		},
		yAxis: {
			title: {
				text: ''
			}

		},
		legend: {
			enabled: false
		},
		plotOptions: {
			series: {
				borderWidth: 1,
				dataLabels: {
					enabled: false,
				},
				lineWidth:1
			},
			line: {
				marker: {
					radius: 4,
					lineColor: color,
					lineWidth: 1,
					fillColor: "#FFFFFF"
				}
			}
		},

		tooltip: {
			headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
			pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> lượt<br/>'
		},

		series: [
			{
				name: "",
				color: color,
				data: data
			}
		]
	});
}