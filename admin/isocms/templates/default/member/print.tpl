{if 1 eq 2}
<center>
	<div style="margin:10px 0px">
    	<a href="{$PCMS_URL}/index.php?mod={$mod}&act=edit&booking_id={$core->encryptID($pvalTable)}" class="Quay lại trang booking">&laquo; Quay lại trang booking</a>
    </div>
</center>
<div class="container-fluid">
    <form id="newitem" method="post" action="" enctype="multipart/form-data" class="validate-form">
        <div class="row-field">
            <div class="coltrols">
            	<div class="printDIV" id="printDIV">
                	{$clsClassTable->getBookingHTML($booking_id)}
                </div>
				<div id="rendererPDF"></div>
				<div class="pull-right btn-group btn-group-sm hidden-print" style="margin-top:10px">
					<a href="javascript:void(0);" class="btn btn-default printClick"><i class="fa fa-print"></i> In ra</a>
					<a href="javascript:void(0);" class="btn btn-default cmdexportpdf"><i class="fa fa-download"></i> Tải bản PDF</a>
				</div>
            </div>
        </div>
    </form>
</div>
<center>
	<a href="{$PCMS_URL}" class="Quay lại trang quản trị">&laquo; Quay lại trang quản trị</a>
</center>
<br />
<script type="text/javascript" src="{$URL_JS}/extension/printArea/jquery.PrintArea.js"></script>
<link rel="stylesheet" type="text/css" href="{$URL_JS}/extension/printArea/PrintArea.css" />
<script type="text/javascript" src="//cdn.rawgit.com/MrRio/jsPDF/master/dist/jspdf.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/niklasvh/html2canvas/0.5.0-alpha2/dist/html2canvas.min.js"></script>
<script type="text/javascript">
	var booking_id = '{$booking_id}';
</script>
{literal}
<style type="text/css">
td{ font-size:13px !important}
.hidden { display:none !important}
</style>
<script type="text/javascript">
	$(function(){
		$('.printClick').click(function(){
			$('#printDIV').printArea();
			return false;
		});
		var pdf = $('#printDIV'),
			ww = pdf.width(),
			a4  =[ 595.28,  841.89];
		$('.cmdexportpdf').on('click',function(){
			createPDF();
		});
		function createPDF(){
			getCanvas().then(function(canvas){
				var img = canvas.toDataURL("image/png"),
				doc = new jsPDF({
				  unit:'px', 
				  format:'a4'
				});     
				doc.addImage(img, 'JPEG', 20, 20);
				doc.save('booking_'+booking_id+'.pdf');
				form.width(ww);
			});
		}
		function getCanvas(){
			pdf.width((a4[0]*1.33333) -80).css('max-width','none');
			return html2canvas(pdf,{
				imageTimeout:2000,
				removeContainer:true
			});	
		}
	});
</script>
{/literal}
{else}
{assign var=BookingStore value=$clsClassTable->getBookingValue($pvalTable)}
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="main-table" style="height: 100%; background-color: #f4f6f8; font-size: 12px; font-family: Arial;">
	<tbody>
		<tr>
			<td align="center" style="width: 100%; height: 100%;">
			<table cellpadding="0" cellspacing="0" border="0" style=" width: 720px; table-layout: fixed; margin:  24px 0 24px 0;" >
					<tbody>
						<tr class="printDIV" id="printDIV">
							<td style="background-color: #ffffff; border: 1px solid #e6e6e6; margin: 0px auto 0px auto; padding: 0px 44px 0px 46px; text-align: left;">
							<table cellpadding="0" cellspacing="0" border="0" width="100%" style="padding: 27px 0px 0px 0px; border-bottom: 1px solid #868686; margin-bottom: 8px;">
									<tbody>
										<tr>
											<td align="left" style="padding-bottom: 3px;" valign="middle"><img src="{$clsConfiguration->getValue('HeaderLogo')}" alt="{$PAGE_NAME}"></td>
											<td width="100%" valign="bottom" style="text-align: right;  font: bold 26px Arial; text-transform: uppercase;  margin: 0px;">Invoice</td>
										</tr>
									</tbody>
								</table>
								<table cellpadding="0" cellspacing="0" border="0" width="100%">
									<tbody>
										<tr valign="top">
											<td style="width: 50%; padding: 14px 0px 0px 2px; font-size: 12px; font-family: Arial;"><h2 style="font: bold 12px Arial; margin: 0px 0px 3px 0px;">{$PAGE_NAME}</h2>
												{$clsConfiguration->getValue('CompanyAddress')}
												<table cellpadding="0" cellspacing="0" border="0">
													<tbody>
														<tr valign="top">
															<td style="font-size: 12px; font-family: verdana, helvetica, arial, sans-serif; text-transform: uppercase; color: #000000; padding-right: 10px;    white-space: nowrap;">{$core->get_Lang('Phone')}:</td>
															<td width="100%" style="font-size: 12px; font-family: Arial;">{$clsConfiguration->getValue('CompanyPhone')}</td>
														</tr>
														<tr valign="top">
															<td style="font-size: 12px; font-family: verdana, helvetica, arial, sans-serif; text-transform: uppercase; color: #000000; padding-right: 10px; white-space: nowrap;">{$core->get_Lang('Website')}:</td>
															<td width="100%" style="font-size: 12px; font-family: Arial;">{$clsConfiguration->getValue('CompanyWebsite')}</td>
														</tr>
														<tr valign="top">
															<td style="font-size: 12px; font-family: verdana, helvetica, arial, sans-serif; text-transform: uppercase; color: #000000; padding-right: 10px; white-space: nowrap;">{$core->get_Lang('Email')}:</td>
															<td width="100%" style="font-size: 12px; font-family: Arial;"><a href="mailto:info@odctravel.com.vn,thusam@odctravel.com.vn">{$clsConfiguration->getValue('CompanyEmail')}</a></td>
														</tr>
													</tbody>
												</table>
											</td>
											<td style="padding-top: 14px;"><h2 style="font: bold 17px Tahoma; margin: 0px;"> Order&nbsp;{$clsClassTable->getOneField('booking_code',$pvalTable)}</h2>
												<table cellpadding="0" cellspacing="0" border="0">
													<tbody>
														<tr valign="top">
															<td style="font-size: 12px; font-family: verdana, helvetica, arial, sans-serif; text-transform: uppercase; color: #000000; padding-right: 10px; white-space: nowrap;">{$core->get_Lang('Status')}:</td>
															<td width="100%" style="font-size: 12px; font-family: Arial;">Complete</td>
														</tr>
														<tr valign="top">
															<td style="font-size: 12px; font-family: verdana, helvetica, arial, sans-serif; text-transform: uppercase; color: #000000; padding-right: 10px; white-space: nowrap;">{$core->get_Lang('Date')}:</td>
															<td style="font-size: 12px; font-family: Arial;">{$clsISO->formatDateMinute($clsClassTable->getOneField('reg_date',$pvalTable))}</td>
														</tr>
														<tr valign="top">
															<td style="font-size: 12px; font-family: verdana, helvetica, arial, sans-serif; text-transform: uppercase; color: #000000; padding-right: 10px; white-space: nowrap;">{$core->get_Lang('Payment method')}:</td>
															<td style="font-size: 12px; font-family: Arial;">{$clsISO->getPaymentMethod($BookingStore.payment_method)}</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
								<table cellpadding="0" cellspacing="0" border="0" width="100%" style="padding: 32px 0px 24px 0px;">
									<tbody>
										<tr valign="top">
											<td width="34%" style="font-size: 12px; font-family: Arial; padding-right: 10px; "><h3 style="font: bold 17px Tahoma; padding: 0px 0px 3px 1px; margin: 0px;">Bill to:</h3>
												<p style="margin: 2px 0px 3px 0px;"> {$BookingStore.address}
												</p>
												<p style="margin: 2px 0px 3px 0px;">{$clsCountry->getTitle($BookingStore.country_id)}</p>
												<p style="margin: 2px 0px 3px 0px;">{$BookingStore.phone}</p>
											</td>
										</tr>
									</tbody>
								</table>
								<table width="100%" cellpadding="0" cellspacing="1" style="background-color: #dddddd;">
									<tbody>
										<tr>
											<th width="70%" style="background-color: #eeeeee; padding: 6px 10px; white-space: nowrap; font-size: 12px; font-family: Arial;">{$core->get_Lang('Product')}</th>
											<th style="background-color: #eeeeee; padding: 6px 10px; white-space: nowrap; font-size: 12px; font-family: Arial;">{$core->get_Lang('Quantity')}</th>
											<th style="background-color: #eeeeee; padding: 6px 10px; white-space: nowrap; font-size: 12px; font-family: Arial;">{$core->get_Lang('Price')}</th>
											<th style="background-color: #eeeeee; padding: 6px 10px; white-space: nowrap; font-size: 12px; font-family: Arial;">{$core->get_Lang('Discount')}</th>
											<th style="background-color: #eeeeee; padding: 6px 10px; white-space: nowrap; font-size: 12px; font-family: Arial;">{$core->get_Lang('Pickup')}</th>
											<th style="background-color: #eeeeee; padding: 6px 10px; white-space: nowrap; font-size: 12px; font-family: Arial;">{$core->get_Lang('Subtotal')}</th>
										</tr>
										<tr>
											<td style="padding: 5px 10px; background-color: #ffffff; font-size: 12px; font-family: Arial;"> {$clsTable->getTitle($target_id)}
												<p style="margin: 2px 0px 3px 0px;">{$core->get_Lang('CODE')}: {$clsTable->getTripCode($target_id)}</p>
												{$core->get_Lang('Product option')}:&nbsp;GROUP TOUR <br>
												{$core->get_Lang('Departure date')}:&nbsp;<strong>{$BookingStore.departure_date}</strong> <br>
												
												<!--pickup-detail--> 
												{$core->get_Lang('Pickup address')}:&nbsp;{$BookingStore.pickup_address}
												<!--/pickup-->
											</td>
											<td style="padding: 5px 10px; background-color: #ffffff; text-align: center; font-size: 12px; font-family: Arial;"><table style="padding: 3px; white-space: nowrap; font-size: 12px; font-family: Arial;">
													<tbody>
														<tr>
															<td> {$core->get_Lang('Adult')} </td>
															<td class="ty-right"> {$BookingStore.adult} </td>
														</tr>
														<tr>
															<td> {$core->get_Lang('Child')} </td>
															<td class="ty-right"> {$BookingStore.child} </td>
														</tr>
														<tr>
															<td> {$core->get_Lang('Baby')} </td>
															<td class="ty-right"> {$BookingStore.baby} </td>
														</tr>
													</tbody>
												</table>
											</td>
											<td style="padding: 5px 10px; background-color: #ffffff; text-align: right; font-size: 12px; font-family: Arial;"><table style="padding: 3px; white-space: nowrap; font-size: 12px; font-family: Arial;">
													<tbody>
														<tr>
															<td class="ty-right"> $<span>{$BookingStore.people_price16}</span></td>
														</tr>
														<tr>
															<td class="ty-right"> $<span>{$BookingStore.people_price17}</span></td>
														</tr>
														<tr>
															<td class="ty-right"> $<span>{$BookingStore.people_price18}</span></td>
														</tr>
													</tbody>
												</table>
											</td>
											<td style="padding: 5px 10px; background-color: #ffffff; text-align: right; font-size: 12px; font-family: Arial;"><table style="padding: 3px; white-space: nowrap; font-size: 12px; font-family: Arial;">
													<tbody>
														<tr>
															<td class="ty-right"> $<span>{$BookingStore.discount_adult}</span></td>
														</tr>
														<tr>
															<td class="ty-right">$<span>{$BookingStore.discount_child}</span></td>
														</tr>
														<tr>
															<td class="ty-right">$<span>{$BookingStore.discount_baby}</span></td>
														</tr>
													</tbody>
												</table>
											</td>
											<td style="padding: 5px 10px; background-color: #ffffff; text-align: right; font-size: 12px; font-family: Arial;"><table style="padding: 3px; white-space: nowrap; font-size: 12px; font-family: Arial;">
													<tbody>
														<tr>
															<td class="ty-right">$<span>{$BookingStore.people_price16*$BookingStore.adult-$BookingStore.discount_adult}</span></td>
														</tr>
														<tr>
															<td class="ty-right">$<span>{$BookingStore.people_price17*$BookingStore.child-$BookingStore.discount_child}</span></td>
														</tr>
														<tr>
															<td class="ty-right">$<span>{$BookingStore.people_price18*$BookingStore.baby-$BookingStore.discount_baby}</span></td>
														</tr>
													</tbody>
												</table></td>
											<td style="padding: 5px 10px; background-color: #ffffff; text-align: right; white-space: nowrap; font-size: 12px; font-family: Arial;"><b> $<span>{$BookingStore.totalgrand}</span> </b>&nbsp; </td>
										</tr>
									</tbody>
								</table>
								<table cellpadding="0" cellspacing="0" border="0" width="100%">
									<tbody>
										<tr>
											<td align="right"><table border="0" style="padding: 3px 0px 12px 0px;">
													<tbody>
														<tr>
															<td style="text-align: right; white-space: nowrap; font-size: 12px; font-family: Arial;"><b>{$core->get_Lang('Total amount')}:</b>&nbsp;</td>
															<td style="text-align: right; white-space: nowrap; font-size: 12px; font-family: Arial;"><strong>$<span>{$BookingStore.people_price16*$BookingStore.adult+$BookingStore.people_price17*$BookingStore.child+$BookingStore.people_price18*$BookingStore.baby}</span></strong></td>
														</tr>
														<tr>
															<td style="text-align: right; white-space: nowrap; font-size: 12px; font-family: Arial;"><b>{$core->get_Lang('Including discount')}:</b>&nbsp;</td>
															<td style="text-align: right; white-space: nowrap; font-size: 12px; font-family: Arial;"> $<span>{$BookingStore.discount_adult+$BookingStore.discount_child+$BookingStore.discount_baby}</span></td>
														</tr>
														<tr>
															<td style="text-align: right; white-space: nowrap; font-size: 12px; font-family: Arial;">{$core->get_Lang('Payment surcharge')}:&nbsp;</td>
															<td style="text-align: right; white-space: nowrap; font-size: 12px; font-family: Arial;"><b>$<span>{$BookingStore.total_surcharge}</span></b></td>
														</tr>
														<tr>
															<td style="text-align: right; white-space: nowrap; font-size: 12px; font-family: Arial;">{$core->get_Lang('Deposit')}:&nbsp;</td>
															<td style="text-align: right; white-space: nowrap; font-size: 12px; font-family: Arial;"><b>$<span>{$clsClassTable->getOneField('deposit',$pvalTable)}</span></b></td>
														</tr>
														<tr>
															<td colspan="2"><hr style="border: 0px solid #d5d5d5; border-top-width: 1px;"></td>
														</tr>
														<tr>
															<td style="text-align: right; white-space: nowrap; font: 15px Tahoma; text-align: right;">{$core->get_Lang('Remaining amount')}:&nbsp;</td>
															<td style="text-align: right; white-space: nowrap; font: 15px Tahoma; text-align: right;">
															{assign var=priceA value=$BookingStore.people_price16*$BookingStore.adult-$BookingStore.discount_adult}	
															{assign var=priceC value=$BookingStore.people_price17*$BookingStore.child-$BookingStore.discount_child}	
															{assign var=priceB value=$BookingStore.people_price18*$BookingStore.baby-$BookingStore.discount_baby}	
															<strong style="font: bold 17px Tahoma;">$<span>
															{$priceA+$priceB+$priceC-$clsClassTable->getOneField('deposit',$pvalTable)}</span></strong></td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
								<div class="center" style="text-align:center"><img src="{$URL_IMAGES}/admin199.png" alt="BarCode" width="250" height="60"> </div></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
<div id="rendererPDF"></div>
<div class="pull-right btn-group btn-group-sm hidden-print" style="position: absolute;margin-top:10px;z-index: 111;right: 0;top: 0;">
	<a href="javascript:void(0);" class="btn btn-default printClick"><i class="fa fa-print"></i> In ra</a>
	<a href="javascript:void(0);" class="btn btn-default cmdexportpdf"><i class="fa fa-download"></i> Tải bản PDF</a>
</div>
<script type="text/javascript" src="{$URL_JS}/extension/printArea/jquery.PrintArea.js"></script>
<link rel="stylesheet" type="text/css" href="{$URL_JS}/extension/printArea/PrintArea.css" />
<script type="text/javascript" src="//cdn.rawgit.com/MrRio/jsPDF/master/dist/jspdf.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/niklasvh/html2canvas/0.5.0-alpha2/dist/html2canvas.min.js"></script>
<script type="text/javascript">
	var booking_id = '{$booking_id}';
</script>
{literal}
<style type="text/css">
td{ font-size:13px !important}
.hidden { display:none !important}
</style>
<script type="text/javascript">
	$(function(){
		$('.printClick').click(function(){
			$('#printDIV').printArea();
			return false;
		});
		var pdf = $('#printDIV'),
			ww = pdf.width(),
			a4  =[ 750,  841.89];
		$('.cmdexportpdf').on('click',function(){
			createPDF();
		});
		function createPDF(){
			getCanvas().then(function(canvas){
				var img = canvas.toDataURL("image/png"),
				doc = new jsPDF({
				  unit:'px', 
				  format:'a4'
				});     
				doc.addImage(img, 'JPEG', 20, 20);
				doc.save('booking_'+booking_id+'.pdf');
			});
		}
		function getCanvas(){

			return html2canvas(pdf,{
				imageTimeout:2000,
				removeContainer:true
			});	
		}
	});
</script>
{/literal}
{/if}

