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
			
				
			<form method="post" action="" enctype="multipart/form-data">
				<table class="table" style="width:100%;float:left">
					<tr>
						<td><h2 style="width:100%;padding:0px;margin:0px;;float:left;">{$core->get_Lang('booking_edit')}</h2></td>
						<td>
							<select class="form-control slbVersion" style="width:100%;float:right;">
								{section name=i loop=$listAllDetails}
									{assign var=book_detail_id value=$listAllDetails[i].book_detail_id}
									{assign var=en_book_detail_id value=$core->encryptID($book_detail_id)}
									<option {if $gets.book_detail_id eq $en_book_detail_id}selected{/if} {$book_detail_id} value="{$core->encryptID($book_detail_id)}">
									 {$core->get_Lang('version_booking')} {$smarty.section.i.iteration}
									 </option>
								{/section}
							</select>
						</td>
					</tr>
				</table>				
			<div class="clear"></div>	
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
					<tr>
					  <th scope="row">{$core->get_Lang('Purchaser_name')}</th>
					  <td>
					  <input type="text" class="form-control" value="{$oneBookingDetail.purchaser}" name="data[{$oneBookingDetail.book_detail_id}][purchaser]" style="width:120px" autocomplete="off">
					  </td>				 
					</tr>
					<tr>
					  <th scope="row">{$core->get_Lang('default_choice')}</th>
					  <td>
					  <select class="form-control sbl_choice" book_detail_id="{$core->encryptID($oneBookingDetail.book_detail_id)}"
					  name="data[{$oneBookingDetail.book_detail_id}][default_choice]">
							<option value="0" {if $oneBookingDetail.default_choice eq '0'}selected{/if}>{$core->get_Lang('off')}</option>
							<option value="1" {if $oneBookingDetail.default_choice eq '1'}selected{/if}>{$core->get_Lang('on')}</option>						
					  </select>					 
					  </td>				 
					</tr>
				  </tbody>
				</table>
				<table cellspacing="0" class="tbl-grid table-bordered table-hover" width="100%">
					<tr>					
						<th class="gridheader" style="text-align:center">{$core->get_Lang('Tour')}</th>
						<th class="gridheader" style="text-align:center">{$core->get_Lang('start_date')}</th>
						<th class="gridheader" style="text-align:center;">{$core->get_Lang('Adult')}</th>
						<th class="gridheader" style="text-align:center;">{$core->get_Lang('Children')}</th>
						<th class="gridheader" style="text-align:center;">{$core->get_Lang('Infant')}</th>
						<th class="gridheader" style="text-align:center">{$core->get_Lang('Amount')}</th>
					</tr>
					{if !empty($oneBookingDetail)}
						{assign var=tour_id value=$oneBookingDetail.tour_id}
						{assign var=oneTour value=$clsTaTour->getOne($tour_id)}						
						{assign var=book_detail_id value=$oneBookingDetail.book_detail_id}
						<tr class="{cycle values="row1,row2"}">												
							<td>
							<a href="{$DOMAIN_NAME}{$clsTaTour->getLink($oneTour.tour_id)}" rel="nofollow" target="_blank">
							{$oneTour.title}
							</a>
							<a href="{$DOMAIN_NAME}{$clsTaTour->getLink($oneTour.tour_id)}" title="View tour" class="btn btn-info">
							<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
							</a>
							<a href="{$PCMS_URL}index.php?mod=tour_agency&act=edit&tour_id={$core->encryptID($oneTour.tour_id)}&book_detail_id={$core->encryptID($oneBookingDetail.book_detail_id)}" 
							class="btn btn-danger" title="Edit tour">
							<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
							</a>
							</td>
							<td>
							<input type="text" class="form-control datepicker" value="{$clsISO->formatDateDMY($oneBookingDetail.start_date)}"
							 name="data[{$book_detail_id}][start_date]" style="width:120px" autocomplete="off" readonly="readonly">
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
											if ($.inArray(dmy, availableDates) != -1) {
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
							<input type="number" class="form-control" value="{$oneBookingDetail.adult}" 
							name="data[{$book_detail_id}][adult]" style="width:80px" autocomplete="off">
							</td>
							<td>
							<input type="number" class="form-control" value="{$oneBookingDetail.children}" 
							name="data[{$book_detail_id}][children]" style="width:80px" autocomplete="off">
							</td>
							<td>
							<input type="number" class="form-control" value="{$oneBookingDetail.infant}" 
							name="data[{$book_detail_id}][infant]" style="width:80px" autocomplete="off">
							</td>
							<td>{$clsISO->getRateSign()} {$clsISO->formatNumberToEasyRead($oneBookingDetail.total)}</td>														
						</tr>						
					
					{/if}			
				 </table>
				 <div class="clear"></div>
				 <br />
				 <button type="submit" class="btn btn-info">
					<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {$core->get_Lang('Update_booking')}
				 </button>
				 <a href="{$PCMS_URL}profile/your_order.html" class="btn btn-danger" title="Cancel">
					<span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span> Cancel
				 </a>
			</form>
		</div>	
	</div>
</div>
{literal}
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$(".slbVersion").live('change',function(event){
			event.preventDefault();
			var $_this = $(this);		
			window.location.assign( path_ajax_script+'your_order/agency_booking_edit/'+$_this.val() );
		});	
		$(".sbl_choice").live('change',function(event){
			event.preventDefault();
			var $_this = $(this);				
			$.ajax({
				type: "POST",
				url: path_ajax_script+'index.php?mod='+mod+'&act=ajUpdateChoiceBooking',	
				data:{'book_detail_id':$_this.attr('book_detail_id'),'default_choice':$_this.val()},
				dataType: "html",
				success: function(data){
					data = $.parseJSON(data);
					if( data.ok ){
						alertify.success(data.message);
					}else{
						alertify.error(data.error);
					}
				}
			});
		});	
	})
</script>
{/literal}