<div class="container" style="margin-top:40px;padding-top:20px;">
	<div class="col-md-3 col-sx-12 col-sm-12">
			<ul class="list-group">
			  <li class="list-group-item"><a href="{$PCMS_URL}">Trang chủ</a></li>
			  <li class="list-group-item"><a href="{$PCMS_URL}profile/my-profile.html">Thông tin của bạn</a></li>
			  <li class="list-group-item"><a href="{$PCMS_URL}profile/list_tour.html">Tour</a></li>
			   <li class="list-group-item"><a href="{$PCMS_URL}profile/your_order.html">Your booking</a></li>
			  <li class="list-group-item"><a href="">Action log</a></li>
			</ul>
		</div>
		<div class="col-md-9 col-sx-12 col-sm-12" style="padding-left:0;">
			<form class="form-inline" method="get" action="">
				 <div class="control-group col-md-3" style="padding-left:0;">
					  <label class="control-label">{$core->get_Lang('tourcategory')}</label>
					  <div class="controls">
						<select onchange="_reload()" name="cat_id" class="slb form-control" id="slb_Category" style="width:200px;">
											{$clsTourCat->makeSelectboxOption($tour_group_id, $get.cat_id, $is_set)}
							</select>
					  </div>
				</div>
				<div class="control-group col-md-3">
					  <label class="control-label">{$core->get_Lang('depart_start')}</label>
					  <div class="controls">
						<td class="fieldarea">
							<input type="text" value="{$get.depart_start}" readonly="readonly" name="depart_start" 
							class="form-control datepicker" placeholder="{$core->get_Lang('depart_start')}" autocomplete="off" width="120px" />
						</td>		
					  </div>
				</div>
				<div class="control-group col-md-3">
					  <label class="control-label">{$core->get_Lang('depart_end')}</label>
					  <div class="controls">
						<td class="fieldarea">
							<input type="text" value="{$get.depart_end}" readonly="readonly" name="depart_end" 
							class="form-control datepicker" placeholder="{$core->get_Lang('depart_end')}" autocomplete="off" width="120px" />
						</td>		
					  </div>
				</div>
				<div class="control-group col-md-3">
					  <label class="control-label">{$core->get_Lang('Purchaser')}</label>
					  <div class="controls">
						<td class="fieldarea">
							<input type="text" value="{$get.purchaser}" name="purchaser" class="form-control" 
							placeholder="{$core->get_Lang('Purchaser')}" autocomplete="off" width="200px" />
						</td>		
					  </div>
				</div>
				<div class="control-group col-md-3" style="padding-left:0;">
					  <label class="control-label">&nbsp;</label>
					  <div class="controls">
						<td class="fieldarea">
							&nbsp;<button type="submit" class="btn btn-info">
							  <span class="glyphicon glyphicon-search"></span> Search
							</button>
						</td>	
						<br /><br />	
					  </div>
				</div>
				<br /><br />
			</form>
			
			<form method="post" action="" enctype="multipart/form-data">
				{assign var=totalAdult value=0}
				{assign var=totalChildren value=0}
				{assign var=totalInfant value=0}
				{assign var=totalAmount value=0}
				<table cellspacing="0" class="tbl-grid" width="100%">
					<th class="gridheader" style="text-align:center;">{$core->get_Lang('booking_code')}</th>					
					<th class="gridheader" style="text-align:center;">{$core->get_Lang('Adult')}</th>
					<th class="gridheader" style="text-align:center;">{$core->get_Lang('Children')}</th>
					<th class="gridheader" style="text-align:center;">{$core->get_Lang('Infant')}</th>					
					<th class="gridheader" style="text-align:center">{$core->get_Lang('Amount')}({$clsISO->getRateSign()})</th>					
					<th class="gridheader" style="text-align:center;"></th>
					{if !empty($lstBooking)}
					
					{section name=i loop=$lstBooking}
						
						{math assign="totalAdult" equation='x + y' x=$totalAdult y=$lstBooking[i].adult}
						{math assign="totalChildren" equation='x + y' x=$totalChildren y=$lstBooking[i].children}
						{math assign="totalInfant" equation='x + y' x=$totalInfant y=$lstBooking[i].infant}
						{math assign="totalAmount" equation='x + y' x=$totalAmount y=$lstBooking[i].amount}
						<tr class="{cycle values="row1,row2"}">
							<td style="text-align:left">							
								<a href="{$PCMS_URL}your_order/agency_booking_details/{$core->encryptID($lstBooking[i].booking_id)}">
									<strong>
									{$lstBooking[i].booking_code} 
									{if $lstBooking[i].totalDetails ne 1}
										( <strong style="color:#ff0000;">{$lstBooking[i].totalDetails}</strong> )
									{/if}
									</strong>
								</a>
							</td>							
							<td style="text-align:center">{$lstBooking[i].adult}</td>
							<td style="text-align:center">{$lstBooking[i].children}</td>
							<td style="text-align:center">{$lstBooking[i].infant}</td>
							<td ><strong style="color:#ff0000;">{$clsISO->formatNumberToEasyRead($lstBooking[i].amount)}</strong></td>											
							<td style="text-align:center;">
							<a class="btn btn-danger" href="{$PCMS_URL}your_order/agency_booking_details/{$core->encryptID($lstBooking[i].booking_id)}"
							 rel="nofollow" title="{$core->get_Lang('Detail')}"><span class="glyphicon glyphicon-eye-open" aria-hidden="true" style="margin-top:2px;"></span> 
								{$core->get_Lang('Detail')}
							</a>							
						</td>			
						</tr>
					{/section}
					{/if}
					<tr>						
						<td style="text-align:center"><strong>{$core->get_Lang('Total')}</strong></td>
						<td style="text-align:center"> <strong style="color:#ff0000;">{$totalAdult}</strong></td>
						<td style="text-align:center"> <strong style="color:#ff0000;">{$totalChildren}</strong></td>
						<td style="text-align:center"> <strong style="color:#ff0000;">{$totalInfant}</strong></td>
						<td><strong style="color:#ff0000;">{$totalAmount}</strong></td>
						<td></td>
					</tr>
				 </table>
			</form>
		</div>
	</div>		
</div>
{literal}
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			$('.datepicker').datepicker({
				dateFormat: 'dd/mm/yy',changeMonth: true,
				changeYear: true,
				},
				$.datepicker.regional['vn']
			);
		})
	</script>
{/literal}