<div class="container" style="margin-top:100px;">				
	<div class="content-info"> 
		<div class="col-md-3 col-sx-12 col-sm-12">
			<ul class="list-group">
			  <li class="list-group-item"><a href="{$PCMS_URL}">Trang chủ</a></li>
			  <li class="list-group-item"><a href="{$PCMS_URL}profile/my-profile.html">Thông tin của bạn</a></li>
			  <li class="list-group-item"><a href="{$PCMS_URL}profile/list_tour.html">Tour</a></li>
			  <li class="list-group-item"><a href="{$PCMS_URL}profile/your_order.html">Your order</a></li>
			  <li class="list-group-item"><a href="{$PCMS_URL}profile/your_ticket.html">Your ticket</a></li>
			  <li class="list-group-item"><a href="">Action log</a></li>
			</ul>
		</div>
		<div class="col-md-9 col-sx-12 col-sm-12" style="padding-left:0;">						
			<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">Create ticket</button>						
			
			{section name=i loop=$allTicket}	
				<br />								
				<div style="max-width: 95%;margin: auto;padding: 12px;color: #f2f2f2;background: #74cfae;">
					{$allTicket[i].message}
					{if $allTicket[i].attachment ne ''} 
						{$PCMS_URL}{$allTicket[i].attachment}
					{/if}
				</div>
			{/section}			
			
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
<script>
	document.addEventListener("DOMContentLoaded", function () {
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