<link rel="stylesheet" href="{$URL_JS}/alertify/alertify.core.css?v={$upd_version}" type="text/css" media="all">
<link rel="stylesheet" href="{$URL_JS}/alertify/alertify.default.css?v={$upd_version}" type="text/css" media="all">
<script defer type="text/javascript" src="{$URL_JS}/alertify/alertify.min.js?v={$upd_version}"></script>
<div class="container" style="margin-top:40px;padding-top:20px;">
	<div class="col-md-3 col-sx-12 col-sm-12">
			<ul class="list-group">
			  <li class="list-group-item"><a href="{$PCMS_URL}">Trang chủ</a></li>
			  <li class="list-group-item"><a href="{$PCMS_URL}profile/my-profile.html">Thông tin của bạn</a></li>
			  <li class="list-group-item"><a href="{$PCMS_URL}profile/list_tour.html">Tour</a></li>
			   <li class="list-group-item"><a href="{$PCMS_URL}profile/your_order.html">Your order</a></li>
			  <li class="list-group-item"><a href="">Action log</a></li>
			</ul>
		</div>
		<div class="col-md-9 col-sx-12 col-sm-12" style="padding-left:0;">
			<h2>{$core->get_Lang('booking_info')}</h2>
			<table class="table" style="width:43%;float:left">			
			  <tbody>
			  	<tr>
				  <th scope="row">{$core->get_Lang('booking_code')}</th>
				  <td>{$oneBooking.booking_code}</td>				 
				</tr>
				<tr>
				  <th scope="row">{$core->get_Lang('created_date')}</th>
				  <td>{$clsISO->formatDateDMY($oneBooking.reg_date)}</td>				 
				</tr>				
			  </tbody>
			</table>
			<table class="table" style="width:43%;float:right;">			
			  <tbody>			  	
				<tr>
				  <th scope="row">{$core->get_Lang('fullname')}</th>
				  <td>{$oneBooking.full_name}</td>				 
				</tr>
				<tr>
				  <th scope="row">{$core->get_Lang('user_name')}</th>
				  <td>{$oneBooking.username}</td>				  
				</tr>
				<tr>
				  <th scope="row">{$core->get_Lang('company')}</th>
				  <td>{$oneBooking.company}</td>				 
				</tr>
				<tr style="display:none">
				  <th scope="row">{$core->get_Lang('address')}</th>
				  <td>Larry</td>				 
				</tr>
				<tr  style="display:none">
				  <th scope="row">{$core->get_Lang('email')}</th>
				  <td>Larry</td>				 
				</tr>
				<tr style="display:none">
				  <th scope="row">{$core->get_Lang('job')}</th>
				  <td>Larry</td>				 
				</tr>
				<tr style="display:none">
				  <th scope="row">{$core->get_Lang('phone')}</th>
				  <td>Larry</td>				 
				</tr>
				<tr style="display:none">
				  <th scope="row">{$core->get_Lang('fax')}</th>
				  <td>Larry</td>				 
				</tr>
				<tr style="display:none">
				  <th scope="row">{$core->get_Lang('website')}</th>
				  <td>Larry</td>				 
				</tr>
			  </tbody>
			</table>
			
			<form method="post" action="" enctype="multipart/form-data">
				<table cellspacing="0" class="tbl-grid table-bordered table-hover" width="100%">
					<tr>
						<th class="gridheader" style="text-align:center; width:40px;">ID</th>
						<th class="gridheader" style="text-align:center">{$core->get_Lang('Tour')}</th>
						<th class="gridheader" style="text-align:center">{$core->get_Lang('start_date')}</th>
						<th class="gridheader" style="text-align:center;">{$core->get_Lang('Adult')}</th>
						<th class="gridheader" style="text-align:center;">{$core->get_Lang('Children')}</th>
						<th class="gridheader" style="text-align:center;">{$core->get_Lang('Infant')}</th>
						<th class="gridheader" style="text-align:center">{$core->get_Lang('Amount')}</th>
						<th class="gridheader" style="text-align:center; width:80px;">{$core->get_Lang('func')}</th>	
					</tr>
					{if !empty($lstBooking)}
					{section name=i loop=$lstBooking}
						{assign var=oneTour value=$clsTaTour->getOne($lstBooking[i].tour_id)}
						{assign var=tour_id value=$lstBooking[i].tour_id}
						<tr class="{cycle values="row1,row2"}">					
							<td style="text-align:center">{$smarty.section.i.iteration}</td>
							<td>
							<a href="{$DOMAIN_NAME}{$clsTaTour->getLink($oneTour.tour_id)}" rel="nofollow" target="_blank">
							{$oneTour.title}
							</a>
							<a href="{$DOMAIN_NAME}{$clsTaTour->getLink($oneTour.tour_id)}" title="View tour" class="btn btn-info">
							<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
							</a>
							<a href="{$PCMS_URL}index.php?mod=tour_agency&act=edit&tour_id={$core->encryptID($oneTour.tour_id)}&book_detail_id={$core->encryptID($lstBooking[i].book_detail_id)}" class="btn btn-danger" title="Edit tour">
							<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
							</a>
							</td>
							<td>
							<input type="text" class="form-control datepicker" value="{$clsISO->formatDateDMY($lstBooking[i].start_date)}"
							 name="data[{$lstBooking[i].tour_id}][start_date]" style="width:120px" autocomplete="off" readonly="readonly">
							 <script>
							var $tour_id = '{$tour_id}';
							var $arrDateTour = '{$arrDateTour}';
							var availableDates = $arrDateTour;
							var availableDates = $.parseJSON(availableDates);
							</script>
							{literal}
								<script>
									document.addEventListener("DOMContentLoaded", function () {
										function available(date) {
											dmy = date.getDate() + "-" + (date.getMonth()+1) + "-" + date.getFullYear();
											if ($.inArray(dmy, availableDates[$tour_id]) != -1) {
												return [true, "","Available"];
											} else {
												return [false,"","unAvailable"];
											}
										}

										$('.datepicker').datepicker({
											dateFormat: 'dd/mm/yy',
											changeMonth: true,
											changeYear: true,
											beforeShowDay: available
											}
										);
									})
								</script>	
							{/literal}
							</td>
							<td>
							<input type="number" class="form-control" value="{$lstBooking[i].adult}" 
							name="data[{$lstBooking[i].tour_id}][adult]" style="width:80px" autocomplete="off">
							</td>
							<td>
							<input type="number" class="form-control" value="{$lstBooking[i].children}" 
							name="data[{$lstBooking[i].tour_id}][children]" style="width:80px" autocomplete="off">
							</td>
							<td>
							<input type="number" class="form-control" value="{$lstBooking[i].infant}" 
							name="data[{$lstBooking[i].tour_id}][infant]" style="width:80px" autocomplete="off">
							</td>
							<td>{$clsISO->getRateSign()} {$clsISO->formatNumberToEasyRead($lstBooking[i].total)}</td>
							<td>
							<a class="btn btn-danger" href="{$PCMS_URL}your_order/agency_booking_edit/{$core->encryptID($lstBooking[i].book_detail_id)}"
							 rel="nofollow" title="{$core->get_Lang('Edit')}"><span class="glyphicon glyphicon-edit" aria-hidden="true" style="margin-top:2px;"></span> 
								{$core->get_Lang('Edit')}
							</a>
							</td>
						</tr>						
					{/section}
					{/if}			
				 </table>
				 <div class="clear"></div>
				 <br />
				 <a href="{$PCMS_URL}profile/your_order.html" class="btn btn-danger" title="{$core->get_Lang('Cancel')}">
					<span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span> {$core->get_Lang('Cancel')}
				 </a>
				 {if !epmty($oneBooking.create_invoice)}
				 <button class="btn btn-info Create_order" booking_id="{$core->encryptID($oneBooking.booking_id)}" title="{$core->get_Lang('Create_order')}">
					<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {$core->get_Lang('Create_order')}
				 </button>
				 {/if}		 
			</form>
		</div>	
	</div>
</div>
{literal}
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			$(".Create_order").live("click",function(){
				var $_this = $(this);					
				$.ajax({
					type: "POST",
					url: path_ajax_script+'index.php?mod='+mod+'&act=ajAddOrder',
					data:{'booking_id':$_this.attr('booking_id')},
					dataType: "html",
					success: function(data){
						data = $.parseJSON(data);
						if( data.ok ){
							alertify.success(data.message);
							location.reload();
						}else{
							alertify.error(data.error);
						}
					}
				}); 
				return false;
			});
		})
	</script>
{/literal}