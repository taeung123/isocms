<link rel="stylesheet" href="{$URL_CSS}/bootstrap-3.3.7/css/bootstrap.min.css?v={$upd_version}" type="text/css" media="all">
<link rel="stylesheet" href="{$URL_CSS}/bootstrap-3.3.7/bootstrap-theme.min.css?v={$upd_version}" type="text/css" media="all">
<div class="container" style="margin-top:100px;"> 
<a href="{$PCMS_URL}profile/your_invoice.html"> 
	<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back Your Invoices
</a>
	<form name="online" id="form_print_invoice" method="post" enctype="multipart/form-data">
		<input type="hidden" value="Save" name="action">
		<input type="hidden" value="b435f346-e3b8-5cd8-b539-516fa19a8fc5" name="country">
		<input type="hidden" value="Asia/Ho_Chi_Minh" name="timezone">
		<input type="hidden" value="1428094440" name="logo_id" id="id">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body pay-border style2-padding">
						<div class="clearfix">
							<div class="col-md-12">
								<div class="pull-left gen-inv3 col-md-6 style2-h2 style2-h5">
									<div class="form-group">
										<label for="first_name" class="col-md-3 form-control-label" style="padding-left:0;">User name:</label>
										<div class="col-md-9" style="margin-bottom: 10px;">
											<input name="profile_id" required id="profile_id" value="{$oneProfile.profile_id}" class="form-control" placeholder="" type="hidden">
											<input name="data[user][first_name]" required id="first_name" value="{$oneProfile.username}" class="form-control" placeholder="User name" type="text">
										</div>
									</div>
									<div class="form-group">
										<label for="first_name" class="col-md-3 form-control-label" style="padding-left:0;">Full name:</label>
										<div class="col-md-9" style="margin-bottom: 10px;">
											<input name="data[user][full_name]" required id="full_name" value="{$oneProfile.full_name}" class="form-control" placeholder="Full name" type="text">
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
								<div class="col-md-4"></div>
								<div class="col-md-2 pull-right">
									<div id="logo_prev">
										<div id="logo" class="box"> <a href="#">
											<div class="overlay"> <span class="add"><img src="images/edit-overlay.png"></span> </div>
											</a></div>
									</div>
									<input type="file" name="logo" id="logo-upload" class="display-none" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="pull-left col-md-6"> </div>
								<div class="col-md-5 pull-right">
									<div class="pull-right pull-right-pclr gen-edt-detail-div"> 
										<a title="You may optionally enter an alpha numeric prefix to your invoice." rel='tooltip' data-placement='top' data-html='true' class="tltpcolor">
										<input type="text" disabled placeholder="Invoice#" class="signup-control edit-inp-td">
										</a>
										<input type="text" name="invoice_no" placeholder="Invoice#" id="invoice_no" readonly="readonly"
												 value="{$oneInvoice.number_bill}" class="signup-control">
										<br />
										<input type="text" class="signup-control edit-inp-td" placeholder="Date" disabled>
										<input type="text" class="signup-control" name="date" value="2016-09-23" placeholder="Date" id="datepicker-autoclose">
										<br />
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table id="price_summary" class="table-bordered table invoice">
										<thead>
											<tr>
												<th class="edit-inv-th1">Nội dung dịch vụ</th>
												<th class="edit-inv-th print-inv-th-wd" width="11%">Ngày khởi hành</th>
												<th class="edit-inv-th print-inv-th-wd" width="11%">Khách hàng</th>
												<th class="edit-inv-th print-inv-th-wd" width="11%">Người lớn</th>
												<th class="edit-inv-th print-inv-th-wd" width="11%">Người trẻ con</th>
												<th class="edit-inv-th print-inv-th-wd" width="11%">Trẻ sơ sinh</th>
												<th class="edit-inv-th print-inv-th-wd" width="11%">Amount</th>
											</tr>
										</thead>
										<tbody>
										{assign var=totalPayment value=0}
										{assign var=owed value=0}
										{section name=i loop=$lstInvoiceContent}
										{assign var=amount value=$lstInvoiceContent[i].amount}
										{math assign="totalPayment" equation='x+y' x=$totalPayment y=$lstInvoiceContent[i].total} 
										{assign var=owed value=$lstInvoiceContent[i].owed}
										<tr valign="top" id="tr_pr_new">
											<td>
											<textarea name="pr_new[]" id="pr_new" class="form-control" />
												{$clsTaTour->getTitle($lstInvoiceContent[i].tour_id)}
												</textarea>
											</td>
											<td><input type="text" name="qty_new[]" id="qty_new" onfocus="if(this.value == 0) this.value='';" onblur="if(this.value == '') this.value=0;" onkeyup="checkValue('new');"  value="{$clsISO->formatTimeDate($lstInvoiceContent[i].start_date)}"  class="form-control edit-inp-td number-format" /></td>
											<td><input type="text" name="qty_new[]" id="qty_new" onfocus="if(this.value == 0) this.value='';" onblur="if(this.value == '') this.value=0;" onkeyup="checkValue('new');"  value="{$lstInvoiceContent[i].purchaser}"  class="form-control edit-inp-td number-format" /></td>
											<td><input type="text" name="qty_new[]" id="qty_new" onfocus="if(this.value == 0) this.value='';" onblur="if(this.value == '') this.value=0;" onkeyup="checkValue('new');"  value="{$lstInvoiceContent[i].adult}"  class="form-control edit-inp-td number-format" /></td>
											<td><input type="text" name="qty_new[]" id="qty_new" onfocus="if(this.value == 0) this.value='';" onblur="if(this.value == '') this.value=0;" onkeyup="checkValue('new');"  value="{$lstInvoiceContent[i].children}"  class="form-control edit-inp-td number-format" /></td>
											<td><input type="text" name="qty_new[]" id="qty_new" onfocus="if(this.value == 0) this.value='';" onblur="if(this.value == '') this.value=0;" onkeyup="checkValue('new');"  value="{$lstInvoiceContent[i].infant}"  class="form-control edit-inp-td number-format" /></td>
											<td align="right"><input type="text" name="amt_new[]" onfocus="if(this.value == 0) this.value='';" onblur="if(this.value == '') this.value=0;" onkeyup="changeAmt('new');" id="amt_new" value="{$lstInvoiceContent[i].total}" class="form-control edit-inp-td number-format" /></td>
										</tr>
										{/section}
											<tr id="tot_tr">
												<td colspan="6">
												
												<div class="pull-right"><b>Thành tiền</b></div></td>
												<td align="right"><input type="text" name="tot_amt" disabled="disabled" id="amt" class="form-control edit-inp-td number-format" value="{$totalPayment}" autocomplete="off" data-parsley-id="120"></td>												
											</tr>
											<tr>
												<td colspan="6"><div class="pull-right"><b>Đã trả</b></div></td>
												<td align="right"><input type="text" name="discount" class="form-control edit-inp-td number-format" onkeyup="changeTax();" value="{$amount}" autocomplete="off" data-parsley-id="122"></td>
												
											</tr>
											<tr>
												<td colspan="6"><div class="pull-right"><b>Còn thiếu</b></div></td>
												<td align="right"><input type="text" name="abt" disabled="disabled" id="abt" class="form-control edit-inp-td number-format" value="{$owed}" autocomplete="off" data-parsley-id="124"></td>
												
											</tr>																				
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h4>Notes</h4>
								<textarea name="notes" class="form-control" id="notes" placeholder="Notes - any relevant information not already covered"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h4>Terms & Conditions </h4>
								<div id="edit-terms">
									<textarea id="elm1" name="invoice_terms" placeholder="Terms and conditions- late fees, payment methods, delivery schedule ..." class="form-control"></textarea>
								</div>
							</div>
						</div>
						<br>
					</div>
				</div>
			</div>
		</div>
		<div class="hidden-print pay-print-margin pull-center">
			<button type="button" name="manifest" class="btn btn-success btn-mrgn-right waves-effect create_print waves-light">I'm done! Generate Invoice</button>
		</div>
		<div class="form-group signup-chck" style="text-align:center"> <span> By clicking on above button, you agree to our <a target="_blank" href="https://topnotepad.com/terms-and-conditions">Terms & Conditions</a> </span> </div>
		<br>
	</form>
</div>
</div>
</div>
</div>
{literal} 
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$(document).ready(function(){	
			$('.create_print').click(function(event){	
				$('#form_print_invoice').print();		
			});
		}); 
	})
</script> 
{/literal}