<script defer type="text/javascript" src="{$URL_JS}/Chart.js-master/dist/Chart.bundle.js"></script>
<div class="container" style="margin-top:100px;">			
	<div class="content-info"> 
		<div class="col-md-3 col-sx-12 col-sm-12">
			<ul class="list-group">
			  <li class="list-group-item"><a href="{$PCMS_URL}">Trang chủ</a></li>
			  <li class="list-group-item"><a href="{$PCMS_URL}profile/my-profile.html">Thông tin của bạn</a></li>
			  <li class="list-group-item"><a href="{$PCMS_URL}profile/list_tour.html">Tour</a></li>
			  <li class="list-group-item"><a href="{$PCMS_URL}profile/your_order.html">Your order</a></li>
			  <li class="list-group-item"><a href="{$PCMS_URL}profile/your_invoice.html">Your Invoices</a></li>
			  <li class="list-group-item"><a href="{$PCMS_URL}profile/your_ticket.html">Your ticket</a></li>
			  <li class="list-group-item"><a href="{$PCMS_URL}profile/report.html">Report</a></li>
			  <li class="list-group-item"><a href="">Action log</a></li>
			</ul>
		</div>
		<div class="col-md-9 col-sx-12 col-sm-12" style="padding-left:0;box-shadow: -2px 0px 0px 0px #b3b3b3;">		
				{if !empty($message)}
					 <div class="alert alert-success">
					 <strong>Success!</strong>									
						  {$message}											
					</div>
				{/if}			
				<form class="appForm" action="" method="post" enctype="multipart/form-data">
				  		 <canvas id="canvas"></canvas>
				</form>
			 
		</div>
		<div class="col-md-2 col-sx-12 col-sm-12"></div>
	</div>	
</div>
{literal}
<script>
	document.addEventListener("DOMContentLoaded", function () {
		var barChartData = {
			labels: ["January", "February", "March", "April", "May", "June", "July"],
			datasets: [
				{
					label: "My First dataset",
					backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
						'rgba(54, 162, 235, 0.2)',
						'rgba(255, 206, 86, 0.2)',
						'rgba(75, 192, 192, 0.2)',
						'rgba(153, 102, 255, 0.2)',
						'rgba(255, 159, 64, 0.2)'
					],
					borderColor: [
						'rgba(255,99,132,1)',
						'rgba(54, 162, 235, 1)',
						'rgba(255, 206, 86, 1)',
						'rgba(75, 192, 192, 1)',
						'rgba(153, 102, 255, 1)',
						'rgba(255, 159, 64, 1)'
					],
					borderWidth: 1,
					data: [65, 59, 80, 81, 56, 55, 40],
				}
			]
		};
		window.onload = function() {
			var ctx = document.getElementById("canvas").getContext("2d");
			window.myBar = new Chart(ctx, {
				type: 'bar',
				data: barChartData,	
				options: {
					scales: {
						xAxes: [{stacked: true}],
						yAxes: [{
							stacked: true,
							ticks: {
								beginAtZero:true
							}
						}]
					}
				}		
			});
		};
	})
</script>
{/literal}