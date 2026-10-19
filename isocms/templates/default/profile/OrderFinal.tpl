<div class="container" style="margin-top:40px;padding-top:20px;">
	<form id="edititem" method="post" action="" enctype="multipart/form-data">		
		<a href="{$PCMS_URL}profile/your_order.html" class="btn btn-danger" title="Cancel" style="float:right;">
			<span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span> Cancel
		</a>
		<br />
		<br /><br />
		<div class="col-md-6" style="margin:0;padding:0px;">
			<div class="form-group">
				<label for="first_name" class="col-md-3 form-control-label" style="padding-left:0;">User name:</label>
				<div class="col-md-9" style="margin-bottom: 10px;">
					<input name="profile_id" required id="profile_id" value="{$oneProfile.profile_id}" class="form-control w220" placeholder="" type="hidden">							
					<input name="data[user][first_name]" required id="first_name" value="{$oneProfile.username}" class="form-control w220" placeholder="User name" type="text">							
				</div>
			</div>
			<div class="form-group">
				<label for="first_name" class="col-md-3 form-control-label" style="padding-left:0;">Full name:</label>
				<div class="col-md-9" style="margin-bottom: 10px;">	
					<input name="data[user][full_name]" required id="full_name" value="{$oneProfile.full_name}" class="form-control w220" placeholder="Full name" type="text">							
				</div>
			</div>
			<div class="form-group">
				<label for="last_name" class="col-md-3 form-control-label" style="padding-left:0;">Company name:</label>
				<div class="col-md-9" style="margin-bottom: 10px;">
					<input name="data[user][company]" id="company" value="{$oneProfile.company}" class="form-control w220" placeholder="Company name" type="text">
				</div>
			</div>      
			<div class="form-group">
				<label for="address" class="col-md-3 form-control-label" style="padding-left:0;">Address:</label>
				<div class="col-md-9" style="margin-bottom: 10px;">
					<input name="data[user][address]" id="address" value="{$oneProfile.address}" class="form-control fullwidth" placeholder="Your Address" type="text">
				</div>
			</div> 
			  <div class="form-group">
				<label for="phone" class="col-md-3 form-control-label" style="padding-left:0;">Your job:</label>
				<div class="col-md-9" style="margin-bottom: 10px;">
					<input name="data[user][job]" id="job" required value="{$oneProfile.job}" class="form-control fullwidth" placeholder="Job" type="text">
				</div>
			</div>           
			<div class="form-group">
				<label for="phone" class="col-md-3 form-control-label" style="padding-left:0;">Phone Number:</label>
				<div class="col-md-9" style="margin-bottom: 10px;">
					<input name="data[user][phone]" id="phone" required value="{$oneProfile.phone}" class="form-control fullwidth" placeholder="Phone" type="text">
				</div>
			</div>
			 <div class="form-group">
				<label for="phone" class="col-md-3 form-control-label" style="padding-left:0;">Fax:</label>
				<div class="col-md-9" style="margin-bottom: 10px;">
					<input name="data[user][fax]" id="fax" required value="{$oneProfile.fax}" class="form-control fullwidth" placeholder="fax" type="text">
				</div>
			</div>
		</div>
		<div class="col-md-6"></div>
		<div class="clear" style="height:20px;clear:both;"><br /><br /></div>		
		{assign var=totalPayment value=0}
        <table cellspacing="0" class="tbl-grid table-bordered table-hover" width="100%">
			<tr>
				<th class="gridheader" style="text-align:center;">ID</th>
				<th class="gridheader" style="text-align:center">{$core->get_Lang('Tour')}</th>
				<th class="gridheader" style="text-align:center">{$core->get_Lang('start_date')}</th>
				<th class="gridheader" style="text-align:center;">{$core->get_Lang('Adult')}</th>
				<th class="gridheader" style="text-align:center;">{$core->get_Lang('Children')}</th>
				<th class="gridheader" style="text-align:center;">{$core->get_Lang('Infant')}</th>
				<th class="gridheader" style="text-align:center;">{$core->get_Lang('Purchaser')}</th>
				<th class="gridheader" style="text-align:center">{$core->get_Lang('Amount')} ( {$clsISO->getRateSign()} )</th>									
			</tr>			
			{if !empty($tourCard)}
			{section name=i loop=$tourCard}
			<tr class="{cycle values="row1,row2"}">
				<td class="index">
				<span class="glyphicon glyphicon-trash clkRemoveTourStore" style="cursor:pointer;" aria-hidden="true" key="{$smarty.section.i.index}" title="{$core->get_Lang('Delete')}" >
				</span>				
				</td>
				<td>
					<strong class="title">{if $clsTour->getOneField('is_online',$tourCard[i].tour_id) eq 0}
					<span style="color:#F90">[PRIVATE]</span>{/if} {$clsTour->getTitle($tourCard[i].tour_id)}
					</strong>( {$clsTour->getTripDuration($tourCard[i].tour_id)} )
				</td>
				{foreach from=$tourCard[i] key=k item=v}
					{if $k eq 'start_date'}
						<td>
							<input type="text" class="form-control datepicker" value="{$v}" readonly="readonly" name="data[{$smarty.section.i.index}][start_date]" style="width:120px">
							<script>
							var $tour_id = '{$smarty.section.i.index}';
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
					{/if}
					{if $k eq 'adult'}
						<td>
							<input type="number" class="form-control" value="{$v}" disabled="disabled" name="data[{$smarty.section.i.index}][adult]" style="width:80px">
						</td>
					{/if}
					{if $k eq 'children'}
						<td>
							<input type="number" class="form-control" value="{$v}" disabled="disabled" name="data[{$smarty.section.i.index}][children]" style="width:80px">
						</td>
					{/if}
					{if $k eq 'infant'}
						<td>
							<input type="number" class="form-control" value="{$v}" disabled="disabled" name="data[{$smarty.section.i.index}][infant]" style="width:80px">
						</td>
					{/if}				   
				{/foreach}
				<td>					
					<input type="text" class="form-control" value="{$tourCard[i].purchaser}" disabled="disabled" name="data[{$smarty.section.i.index}][purchaser]" style="width:80px">
				</td>				
				<td>
					{assign var=tour_id value=$tourCard[i].tour_id} 						
					{assign var=trip_price value=$tourCard[i].total}
					{assign var=type_promo value=$tourCard[i].type_promo}
					{assign var=val_discount value=$tourCard[i].val}
					{if $type_promo eq $PROMO_VALUE}
						{*assign var=trip_price value=math equation='x - y' x=$trip_price y=$val_discount*}
					{/if}
					{if $type_promo eq $PROMO_PERCENT}
						{*math assign="trip_price" equation='x-y*x/100' x=$trip_price y=$val_discount*} 
					{/if}
					{math assign="totalPayment" equation='x+y' x=$trip_price y=$totalPayment} 
					{$clsISO->formatNumberToEasyRead($tourCard[i].total)}
				</td>							
			</tr>			
			{/section}
			{else}<tr><td colspan="15">{$core->get_Lang('nodata')}!</td></tr>{/if}
		</table>
		{if !empty($tourCard)}	
		<div class="mid"> 
		<br />
			<ul class="costing" style="float: right;"> 
				<li class="full">Full Payment<span class="detail">{$clsISO->getRateSign()} {$totalPayment}</span></li> 			
				<li class="total">Total Price<span class="detail">{$clsISO->getRateSign()} {$totalPayment}</span></li> 
			</ul>
		<br />
		</div>									
		{/if}	
		<div class="form-group">						
			<div class="col-md-12">
				<button type="submit" class="btn btn-danger">Press to book</button>
			</div>
		</div>	
    </form>	
</div>
{literal}
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			$('.datepicker').datepicker({dateFormat: 'dd/mm/yy'});	
			$(".clkRemoveTourStore").live('click',function(event){	
				var r = confirm("You are sure delete!");
				if (r == true) {
					var $_this = $(this);
					$.ajax({
						type: "POST",
						url: path_ajax_script+'booking/RemoveItemOrder',	
						dataType: "html",
						data:{'key':$_this.attr('key')},
						success: function(data){
							data = $.parseJSON(data);
							if( data.ok ){
								window.location.assign( path_ajax_script+'booking/OrderFinal' );
							}else{
								alert(data.error);
								window.location.assign( path_ajax_script+'booking/OrderFinal' );
							}
						}
					}); 
				} else {			
				}		
			});
		})
	</script>
{/literal}