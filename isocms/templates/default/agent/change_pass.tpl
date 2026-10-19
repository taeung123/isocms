<div class="page_container bg_fff">
	<div class="nav_agent">
		<div class="container">
			<ul class="nav_ul_agent">
				<li><a class="current" href="{$curl}" title="{$core->get_Lang('Thông tin cá nhân')}">{$core->get_Lang('Thông tin cá nhân')}</a></li>
				<li><a href="/dai-ly-du-lich/dat-dich-vu.html" title="{$core->get_Lang('Tour đã đặt')}">{$core->get_Lang('Tour đã đặt')}</a></li>
				<li><a href="/dai-ly-du-lich/danh-gia-va-anh.html" title="{$core->get_Lang('Đánh giá và ảnh')}">{$core->get_Lang('Đánh giá và ảnh')}</a></li>
			</ul>
		</div>
	</div>
    <div id="contentPage" class="pageAgent pageAgentLogin pdt0">
		<div class="container">
			<div class="box_change_pass">
				<div class="col_Left">
					<ul class="ul_nav_agent2">
						<li><a href="/dai-ly-du-lich/thong-tin-tai-khoan.html" title="{$core->get_Lang('Chỉnh sửa thông tin')}">{$core->get_Lang('Chỉnh sửa thông tin')}</a></li>
						<li><a class="current" href="{$curl}" title="{$core->get_Lang('Thay đổi mật khẩu')}">{$core->get_Lang('Thay đổi mật khẩu')}</a></li>
					</ul>
				</div>
				<div class="col_Right">
					<div class="box_agent_register">
						<h1 class="size25 text_left mb10">{$core->get_Lang('Change Password')}</h1>
						<div class="note mb30">{$core->get_Lang('Passwords must be at least 6 characters long')}. {$core->get_Lang('Forgot your old password')}? <a class="color_f7941d" href="/dai-ly-du-lich/quen-mat-khau.html" style="cursor:pointer">{$core->get_Lang('Click here')}</a> {$core->get_Lang('and we will resend it to your confirmed email address')}.</div>

						<form id="agent_register_form" method="post" action="" enctype="multipart/form-data">
							{if $msg ne ''}
							<div class="alert alert-warning">
							  <strong>{$core->get_Lang('Warning')}!</strong> {$msg}
							</div>
							{/if}
							<div class="form-group">
								<label>{$core->get_Lang('Mật khẩu hiện tại')}</label>
								<span class="icon password"><input class="form-control" type="password" name="current_password" id="current_password" placeholder="Nhập mật khẩu hiện tại của bạn"/></span>
								<div class="error" id="error_current_password"></div>
							</div>
							<div class="form-group">
								<label>{$core->get_Lang('Mật khẩu mới')}</label>
								<span class="icon password"><input class="form-control" type="password" name="password" id="password" placeholder="Nhập mật khẩu mới của bạn"/></span>
								<div class="error" id="error_password"></div>
							</div>
							<div class="form-group">
								<label>{$core->get_Lang('Xác nhận mật khẩu mới')}</label>
								<span class="icon password"><input class="form-control" type="password" name="re_password" id="re_password" placeholder="Nhập lại mật khẩu mới của bạn"/></span>
								<div class="error" id="error_re_password"></div>
							</div>
							<div class="form-group mb20">
								<input class="form-control btn_register" id="btn_change_pass" type="submit" value="{$core->get_Lang('Change')}">
								<input type="hidden" name="CHANGE_PASS" value="CHANGE_PASS">
								<div class="success" id="send_success_email"></div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var msg_current_password_required = "{$core->get_Lang('Your current password should not be empty')}!";
	var msg_password_required = "{$core->get_Lang('Your password should not be empty')}!";
	var msg_re_password_required = "{$core->get_Lang('Your confirm password should not be empty')}!";
	var msg_confirmpassword_not_valid = "{$core->get_Lang('Please enter the same value again password')}!";
	var msg_error = "{$core->get_Lang('Reset password not success')}!";
	var msg_success = "{$core->get_Lang('Reset password success')}!";
</script>
{literal}
<script type="text/javascript">
$(function(){
	$("#btn_change_pass").click(function(){
		var $current_password = $("#current_password").val();
		var $password = $("#password").val();
		var $confirmpassword = $("#re_password").val();

		if($("#current_password").val()==''){
			$('#error_current_password').html(msg_current_password_required).fadeIn().delay(3000).fadeOut();
			$("#current_password").focus();
			return false;
		}

		if($("#password").val()==''){
			$('#error_password').html(msg_password_required).fadeIn().delay(3000).fadeOut();
			$("#password").focus();
			return false;
		}
		if($("#re_password").val()==''){
			$('#error_re_password').html(msg_re_password_required).fadeIn().delay(3000).fadeOut();
			$("#re_password").focus();
			return false;
		}

		if($confirmpassword!=$password){
			$('#error_re_password').html(msg_confirmpassword_not_valid).fadeIn().delay(3000).fadeOut();
			$("#re_password").focus();
			return false;
		}
	});
});
</script>
{/literal}