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
			  <li class="list-group-item"><a href="">Action log</a></li>
			</ul>
		</div>
		<div class="col-md-9 col-sx-12 col-sm-12" style="padding-left:0;">
			<h4 style="margin-top:0px;"><strong>Danh sách hóa đơn</strong></h4>
			<div class="card-box">
              <div class="row">
                <div class="col-md-12">
                    <h4 class="m-t-0 header-title"><b>Search</b></h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <form class="form-inline" name="SearchForm" id="SearchForm" role="form">								
                    <div class="form-group insize">					
                      <input type="text" name="fdate" class="form-control datepicker" value="{$gets.fdate}" placeholder="From Date" autocomplete="off">
                    </div>
                    <div class="form-group m-l-6 insize">
                      <input type="text" name="tdate" class="form-control datepicker" value="{$gets.tdate}" placeholder="To Date" autocomplete="off">
                    </div>
                    <div class="form-group m-l-6 insize" style="display:none">
                      <input type="text" name="name" class="form-control" disabled="disabled" value="" placeholder="Name" autocomplete="off">
                    </div>
					<div class="form-group m-l-6 insize">
                      <input type="text" name="number_bill" class="form-control" value="{$gets.number_bill}" placeholder="Invoice#" autocomplete="off">
                    </div>                   
                    <div class="form-group m-l-6 insize1">
						<button class="btn btn-primary" href="javascript: void(0);" onclick="submitForm('CustomerList');" title="Click me to search for entered search criteria in list."><i class="fa fa-search"></i></button> 
					</div>
                  </form>
                  <br>
                </div>
              </div>
            </div>
			<table cellspacing="0" class="tbl-grid table" width="100%">
				<tr>
					<td class="gridheader" style="text-align:center"><strong>STT</strong></td>
					<td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('Mã hóa đơn')}</strong></td>
					<td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('Ngày được tạo')}</strong></td>
					<td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('Tạo bởi')}</strong></td>          			
					<td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('Thành tiền')}</strong></td>					
					<td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('Còn thiếu')}</strong></td>					
					<td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('func')}</strong></td>
				 </tr>
				{if !empty($lstInvoice)}
					{section name=i loop=$lstInvoice}	
						<tr>
						<td class="gridheader" style="text-align:center"><strong>{$smarty.section.i.iteration}</strong></td>
						<td class="gridheader" style="text-align:center"><strong>{$lstInvoice[i].number_bill}</strong></td>
						<td class="gridheader" style="text-align:center"><strong>{$clsISO->formatTimeDateEn($lstInvoice[i].reg_date)}</strong></td>
						<td class="gridheader" style="text-align:center"><strong>{$clsUser->getOneField('user_name',$lstInvoice[i].user_id)}</strong></td>          			
						<td class="gridheader" style="text-align:center"><strong>{$lstInvoice[i].amount}</strong></td>					
						<td class="gridheader" style="text-align:center"><strong>{$clsTaInvoices->getOwed($lstInvoice[i].invoice_id)}</strong></td>					
						<td class="gridheader" style="text-align:center"><strong>
							<a href="{$PCMS_URL}profile/print_invoice/{$core->encryptID($lstInvoice[i].invoice_id)}" class="btn btn-success">
							  <span class="glyphicon glyphicon-print"></span> {$core->get_Lang('')}
							</a>
						</td>
						</tr>
					{/section}
				{else}
					<tr>
						<td colspan="7" style="text-align:center;">Chưa có hóa đơn nào</td>
					</tr>
				{/if}	
			</table>					
		</div>
	</div>	
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="exampleModal" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
		<form class="appForm" action="" method="post" enctype="multipart/form-data">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="gridSystemModalLabel">Create ticket</h4>
		  </div>
		  <div class="modal-body">
			<div class="row">
			  <div class="col-md-12">
			  <textarea rows="4" style="width:100%" name="data[message]" required></textarea>
			  </div>
			</div>	
			<div class="row">
			  <div class="col-md-12">
			 <input type="file" name="attachment">
			  </div>
			</div>				
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary clickCreateTicket">Save</button>
		  </div>
		 </form> 
	</div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{literal}
<style>
.card-box {
    padding: 20px;
    border: 1px solid #CCC;
    -webkit-border-radius: 5px;
    border-radius: 5px;
    -moz-border-radius: 5px;
    background-clip: padding-box;
    margin-bottom: 20px;
    background-color: #f9f9f9;
}
</style>
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$('.datepicker').datepicker({
			dateFormat: 'dd/mm/yy',changeMonth: true,
			changeYear: true,		
			},
			$.datepicker.regional['vn']
		);
		$(document).ready(function(){	
			
			$('.clickCreateTicket').click(function(event){			
				var $_this = $(this);
				if( $_this.closest('form').valid() ) {
					$_this.closest('form').ajaxSubmit({
						type: "POST",
						url: path_ajax_script+'profile/createTicket',
						dataType: "html",
						success: function(data){
							data = $.parseJSON(data);
							if( data.ok ){
								location.reload();
							}else{
								
							}
						}
					}); 
				}
			});
		}); 
	})
</script>
{/literal}