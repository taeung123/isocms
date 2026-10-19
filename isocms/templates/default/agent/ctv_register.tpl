<div class="page_container">
	<div class="breadcrumb-main bg_f5f5f5">
        <div class="container">
            <ol class="breadcrumb bg_f5f5f5 hidden-xs mt0" itemscope itemtype="http://schema.org/BreadcrumbList">
				<li itemprop="name"><a itemprop="url" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}"><span class="reb">{$core->get_Lang('Home')}</span></a></li>
				<li itemprop="name"><a itemprop="url" href="{$curl}" title="{$core->get_Lang('Cộng tác viên')}">{$core->get_Lang('Cộng tác viên')}</a></li>
				<li itemprop="name"><a itemprop="url" href="{$curl}" title="{$core->get_Lang('Register')}">{$core->get_Lang('Register')}</a></li>
            </ol>
        </div>
    </div>
    <div id="contentPage" class="pageAgent pageAgentRegister">
		<div class="container">
			<h1 class="size35 text-center">{$core->get_Lang('Đăng ký cộng tác viên')}</h1>
			<div class="box_agent_register">
				<p class="title_box_register">{$core->get_Lang('Cung cấp những thông tin cần thiết cho chúng tôi')}</p>
				<form id="agent_register_form" class="agent_register_form" method="post" enctype="multipart/form-data">
					{if $errMsg ne ''}
					<div class="error msg_error">
					{$errMsg}
					</div>
					{/if}
					<div class="form-group">
						<label>{$core->get_Lang('Full Name')}<span class="color_f00">*</span></label>
						<span class="icon full_name"><input class="form-control" type="text" name="full_name" id="full_name" placeholder="{$core->get_Lang('Enter your Name')}"/></span>
						<div class="error" id="error_full_name"></div>
					</div>
					<div class="form-group">
						<label>{$core->get_Lang('Email')}<span class="color_f00">*</span></label>
						<span class="icon email"><input class="form-control" type="text" name="email" id="email" placeholder="{$core->get_Lang('Enter your Email')}"/></span>
						<div class="error" id="error_email"></div>
					</div>
					<div class="form-group">
						<label>{$core->get_Lang('Phone')}<span class="color_f00">*</span></label>
						<span class="icon phone"><input class="form-control" type="text" name="phone" id="phone" placeholder="{$core->get_Lang('Enter your Phone')}"/></span>
						<div class="error" id="error_phone"></div>
					</div>
					<div class="form-group">
						<label>{$core->get_Lang('Password')}<span class="color_f00">*</span></label>
						<span class="icon password"><input class="form-control" type="password" name="password" id="password" placeholder="{$core->get_Lang('Enter Password')}"/></span>
						<div class="error" id="error_password"></div>
					</div>
					<div class="form-group">
						<label>{$core->get_Lang('Confirm Password')}<span class="color_f00">*</span></label>
						<span class="icon password"><input class="form-control" type="password" name="re_password" id="re_password" placeholder="{$core->get_Lang('Enter Confirm Password')}"/></span>
						<div class="error" id="error_re_password"></div>
					</div>
					<div class="form-group">
						<label>{$core->get_Lang('Identification')}<span class="color_f00">*</span></label>
						<span class="icon code"><input class="inputfile form-control mgr20 bg_f5f5f5" type="file" name="identity_card_file" id="identity_card_file" style="width:300px; display:none" value=""/>
						<label class="icon code text_upload" for="identity_card_file">{$core->get_Lang('Upload your Identification')} <span></span></label><span class="text_hidden"> {$core->get_Lang('No File')}</span></span>
						<div class="error" id="error_re_password"></div>
					</div>
					<div class="error" id="agent_email_exits_msg"></div>
					<div class="form-group mb20">
						<input class="form-control btn_register" id="btn_register" type="submit" value="{$core->get_Lang('Next')} >>">
						<input type="hidden" name="ctv_register" value="ctv_register">
						<input type="hidden" name="type" value="CTV">
					</div>
					<div class="bottom-form">
						<p class="text-right">{$core->get_Lang('Already have an account')}? <a href="/travel-agent/signin.html" title="{$core->get_Lang('Signin')}">{$core->get_Lang('Signin')}</a></p>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var msg_fullname_required = "{$core->get_Lang('Your full name should not be empty')}!";
	var msg_email_required = "{$core->get_Lang('Your email should not be empty')}!";
	var msg_email_not_valid = "{$core->get_Lang('Please enter a valid email address')}!";
	var msg_phone_required = "{$core->get_Lang('Your telephone should not be empty')}!";
	var msg_company_name_required = "{$core->get_Lang('Your company name should not be empty')}!";
	var msg_position_required = "{$core->get_Lang('Your position should not be empty')}!";
	var msg_tax_code_required = "{$core->get_Lang('Your tax code should not be empty')}!";
	
	var msg_password_required = "{$core->get_Lang('Your password should not be empty')}!";
	var msg_re_password_required = "{$core->get_Lang('Your confirm password should not be empty')}!";
	var msg_confirmpassword_not_valid = "{$core->get_Lang('Please enter the same value again password')}!";
	var msg_exits = "{$core->get_Lang('Email address already exists')}!";

</script>
{literal}
<script type="text/javascript">
var inputs = document.querySelectorAll('.inputfile');
Array.prototype.forEach.call( inputs, function(input)
{
	var label	 = input.nextElementSibling,
		labelVal = label.innerHTML;

	input.addEventListener( 'change', function( e )
	{
		var fileName = '';
		fileName = e.target.value.split( '\\' ).pop();
		if(fileName){
			label.innerHTML = fileName;
			$('.text_hidden').hide();
		}else{
			label.innerHTML = labelVal;
			$('.text_hidden').show();
		}
	});
});
</script>
<script type="text/javascript">
	$(function(){
		$("#btn_register").click(function(){
			var $fullname = $("#full_name").val();
			var $email = $("#email").val();
			var $phone = $("#phone").val();
			var $password = $("#password").val();
			var $confirmpassword = $("#re_password").val();
			
			if($("#full_name").val()==''){
				$('#error_full_name').html(msg_fullname_required).fadeIn().delay(3000).fadeOut();
				$("#full_name").focus();
				return false;
			}
			if($("#email").val()==''){
				$('#error_email').html(msg_email_required).fadeIn().delay(3000).fadeOut();
				$("#email").focus();
				return false;
			}
			if(checkValidEmail($email)==false){
				$('#error_email').html(msg_email_not_valid).fadeIn().delay(3000).fadeOut();
				$("#email").focus();
				return false;
			}
			if($("#phone").val()==''){
				$('#error_phone').html(msg_phone_required).fadeIn().delay(3000).fadeOut();
				$("#phone").focus();
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
	function checkValidEmail(email){
		var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return regex.test(email);
	}
</script>
{/literal}