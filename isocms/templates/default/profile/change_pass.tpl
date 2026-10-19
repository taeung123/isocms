<div class="container" style="margin-top:100px;">				
	<div class="content-info"> 
		<div class="col-md-3 col-sx-12 col-sm-12">
			<ul class="list-group">
				  <li class="list-group-item"><a href="{$PCMS_URL}">Trang chủ</a></li>
				  <li class="list-group-item"><a href="{$PCMS_URL}profile/my-profile.html">Thông tin của bạn</a></li>
				  <li class="list-group-item"><a href="{$PCMS_URL}profile/list_tour.html">Tour</a></li>
				  <li class="list-group-item"><a href="{$PCMS_URL}profile/your_order.html">Your order</a></li>
				  <li class="list-group-item"><a href="">Action log</a></li>
			</ul>
		</div>
		<div class="col-md-9 col-sx-12 col-sm-12" style="padding-left:0;box-shadow: -2px 0px 0px 0px #b3b3b3;">					
		  	<form class="appForm" action="" method="post">
				{if !empty($msg)}
					 <div class="alert alert-warning">
					 <strong>Warning!</strong>
					{foreach from=$msg key=i item=topic name=foo}						
						  {$topic}						
					{/foreach}	
					</div>
				{/if}
				{if !empty($message)}
					 <div class="alert alert-success">
					 <strong>Success!</strong>										
						  {$message}												
					</div>
				{/if}
				<div class="form-group row">
					<label for="old_pass" class="col-sm-3 form-control-label"> Current Password <font class="required">*</font>: </label>
					<div class="col-sm-9">
						<input class="form-control" required type="password" name="old_pass" autocomplete="off">
					</div>
				</div>
				<div class="form-group row">
					<label for="pass2" class="col-sm-3 form-control-label"> Password <font class="required">*</font>: </label>
					<div class="col-sm-9">
						<input class="form-control" id="pass2" required type="password" name="pass2" autocomplete="off">
					</div>
				</div>
				<div class="form-group row">
					<label for="pass3" class="col-sm-3 form-control-label"> Retype Password <font class="required">*</font>: </label>
					<div class="col-sm-9">
						<input class="form-control" id="pass3" required type="password" name="pass3" autocomplete="off">
					</div>
				</div>
				<div class="form-group row">
					<label for="website" class="col-sm-3 form-control-label"></label>
					<div class="col-sm-9">
						<input type="hidden" name="Update" value="ChangePass" />
						<button type="submit" class="btn btn-danger">Update</button>
					</div>
				</div>
			</form>			 
		</div>
		<div class="col-md-2 col-sx-12 col-sm-12"></div>
	</div>	
</div>
{literal} 
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$('.appForm').validate({
		rules: {
				pass2: "required",
				pass3: {
				equalTo: "#pass2"
				}
			}
		}); 
	})
</script> 
{/literal} 