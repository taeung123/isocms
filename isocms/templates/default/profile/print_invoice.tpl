<link rel="stylesheet" href="{$URL_CSS}/bootstrap-3.3.7/css/bootstrap.min.css?v={$upd_version}" type="text/css" media="all">
<link rel="stylesheet" href="{$URL_CSS}/bootstrap-3.3.7/bootstrap-theme.min.css?v={$upd_version}" type="text/css" media="all">
<div class="container" style="margin-top:100px;"> 
<a href="{$PCMS_URL}profile/your_invoice.html"> 
	<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back Your Invoices
</a>
<div class="row print_invoice" id="DivIdToPrint">
	{literal} 
		<style>
		@page {
			size: A4;
			margin: 0;
		}
		@media print{
			.container{
				width: 210mm;
    			height: 297mm;
				max-width:950px;
			}
			.panel{
				color: #797979;
				font-family: 'Noto Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;
			}
			.gridheader {
				text-align: center;
				background: #A9A9A9;
				color:#fff;
				white-space:nowrap;
			}
			.print-inv-amount{
				background-color: #ddd;
			}
			.pull-left {
				float: left!important;
			}
		}
		.panel{
			color: #797979;
			font-family: 'Noto Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;
		}
		.gridheader {
			text-align: center;
			background: #A9A9A9;
			color:#fff;
			white-space:nowrap;
		}
		.print-inv-amount{
			background-color: #ddd;
		}
		.pull-left {
			float: left!important;
		}
		</style>
	{/literal}
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-body pay-border style2-padding">
              <div class="clearfix">
				  <div class="col-md-12">
					<div class="pull-left style2-h2 style2-h5">
					  <h2>{$oneProfile.company}</h2>
						  {$oneProfile.address}						 
						  <br> {$oneProfile.username}
						  <br> {$oneProfile.website}
					</div>
					<div class="pull-right">
						{if !empty($oneProfile.avatar)}
							<img src="{$oneProfile.avatar}">
						{/if}
					</div>
				  </div>
			  </div>	
			  <br /><br />		  
			  <div class="row">
				  <div class="col-md-12 pull-left-pclr" style="padding-left: 30px;">
					
				  
					<div class="pull-right m-t-30 style2-invc-number">
					  <p>
					  <strong>Invoice # : </strong> <span>{$oneInvoice.number_bill}</span><br>
					  <strong>Invoice Date : </strong> <span>{$clsISO->formatTimeDateEn($oneInvoice.reg_date)}</span> 
					  </p>
					</div>
				  </div>
				</div>
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table class="table-bordered table m-t-30 invoice">
                      <thead>
                        <tr>
							<th class="gridheader" width="40px;">#</th>
							<th class="gridheader" style="text-align:left;">Nội dung dịch vụ</th>
							<th class="gridheader" style="max-width:11%">Ngày khởi hành</th>
							<th class="gridheader" style="max-width:11%"">KH</th>
							<th class="gridheader" style="max-width:11%">N L</th>
							<th class="gridheader" style="max-width:11%">T C</th>
							<th class="gridheader" style="max-width:11%">T SS</th>
							<th class="gridheader" style="max-width:11%">Amount</th>                          
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
								<td style="text-align:center;">{$smarty.section.i.iteration}</td>
								<td style="text-align:left;"> 
									{$clsTaTour->getTitle($lstInvoiceContent[i].tour_id)}
								</td>
								<td style="text-align:right;">{$clsISO->formatTimeDate($lstInvoiceContent[i].start_date)}</td>
								<td style="text-align:right;">{$lstInvoiceContent[i].purchaser}</td>
								<td style="text-align:right;">{$lstInvoiceContent[i].adult}</td>
								<td style="text-align:right;">{$lstInvoiceContent[i].children}</td>
								<td style="text-align:right;">{$lstInvoiceContent[i].infant}</td>
								<td style="text-align:right;">{$lstInvoiceContent[i].total}</td>
							</tr>
						{/section}						
                        <tr class="print-inv-amount">
                          <td colspan="7"><div class="pull-right"><b>Thành tiền</b></div></td>
                          <td><b><span class="dt_cur">{$clsISO->getRateSign()}</span> <span class="dt_amt">{$totalPayment}</span></b></td>
                        </tr>
						<tr class="print-inv-amount">
                          <td colspan="7"><div class="pull-right"><b>Đã trả</b></div></td>
                          <td><b><span class="dt_cur">{$clsISO->getRateSign()}</span> <span class="dt_amt">{$amount}</span></b></td>
                        </tr>
						<tr class="print-inv-amount">
                          <td colspan="7"><div class="pull-right"><b>Còn thiếu</b></div></td>
                          <td><b><span class="dt_cur">{$clsISO->getRateSign()}</span> <span class="dt_amt">{$owed}</span></b></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <br><hr>			               			 
              <br>             
            </div>
          </div>
		  <div class="hidden-print pay-print-margin pull-center">
			<button type="button" name="manifest" onclick="printContent('DivIdToPrint')" class="btn btn-success btn-mrgn-right waves-effect create_print waves-light">I'm done! Generate Invoice</button>
		  </div>      
      </div>
	<form name="online" id="form_print_invoice" method="post" enctype="multipart/form-data" style="display:none;">
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
<style>
.panel{
	color: #797979;
	font-family: 'Noto Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;
}
.gridheader {
    text-align: center;
    background: #A9A9A9;
	color:#fff;
	white-space:nowrap;
}
.print-inv-amount{
	background-color: #ddd;
}
.pull-left {
    float: left!important;
}
</style>
<script>
	document.addEventListener("DOMContentLoaded", function () {
		function printContent(el){
			var restorepage = document.body.innerHTML;
			var printcontent = document.getElementById(el).innerHTML;
			document.body.innerHTML = printcontent;
			window.print();
			document.body.innerHTML = restorepage;
		}
	})
</script> 
{/literal}