<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>Login to ISOCMS Administrator</title>
	<meta name='robots' content='noindex,nofollow'/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/ico" href="{$PCMS_URL}/favicon.ico?v={$upd_version}">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
			integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
			crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/css/bootstrap.min.css"
		  integrity="sha512-Ez0cGzNzHR1tYAv56860NLspgUGuQw16GiOOp/I2LuTmpSK9xDXlgJz3XN4cnpXWDmkNBKXR/VDMTCnAaEooxA=="
		  crossorigin="anonymous" referrerpolicy="no-referrer"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/js/bootstrap.min.js"
			integrity="sha512-EKWWs1ZcA2ZY9lbLISPz8aGR2+L7JVYqBAYTq5AXgBkSjRSuQEGqWx8R1zAX16KdXPaCjOCaKE8MCpU0wcHlHA=="
			crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<link rel="stylesheet" href="{$URL_CSS}/font-awesome.min.css?v={$upd_version}" type="text/css" media="all">
	{*    <link rel="stylesheet" href="{$URL_CSS}/admin_login.css" type="text/css" media="all">*}
	<link rel="stylesheet" href="{$URL_CSS}/admin_login_2.css?v={$upd_version}" type="text/css" media="all">
	<script>var path_ajax_script = '{$PCMS_URL}';</script>

</head>
<body>
<script type="text/javascript" src="{$URL_JS}/jquery.validate.js?v={$upd_version}"></script>
<div class="page mtl" style="margin-top:70px; padding:20px 0">
	<div class="container">
		<div id="ModalResetPass" class="full-width pd40_0">
			<div class="omniture"></div>
			<div><span class="h2 mb10 title">{$core->get_Lang('Enter a New Password')}</span></div>
			<div class="line mbl">
				<div class="main-narrow unit">
					<div class="line">
						<p class="mtn mhn"></p>
						<div>
							<span class="strong">{$core->get_Lang('Please note')}:</span>
							{$core->get_Lang('Passwords are case sensitive and must be 6 characters or longer')}
						</div>
						<div id="fieldErrors"></div>
						<form id="frmResetPass" class="form-horizontal" method="post" onsubmit="return validate()">
							<p class="mb10">{$core->get_Lang('This form help you return your password. Please, enter your password, and send request')}</p>
							<p class="message text-center {if $result && $result =='true'}text-success {else}text-danger{/if}"></p>
							<div class="line mb20">
								<label>{$core->get_Lang('Password')}</label>
								<input type="password" name="new_password" id="new_password"
									   placeholder="{$core->get_Lang('Password')}" class="isoTxt required input-full"/>
							</div>
							<div class="line mb20">
								<label>{$core->get_Lang('Confirm Password')}</label>
								<input type="password" name="renew_password" id="renew_password"
									   placeholder="{$core->get_Lang('Confirm Password')}"
									   class="isoTxt required input-full"/>
							</div>
							<div class="line buttonLast">
								<a href="{$link_login}">{$core->get_Lang('Cancel')}</a>
								<button type="submit" id="requestForgot"
										class="btn-block btn_main">{$core->get_Lang('Submit')}</button>
								<input type="hidden" name="resetP" value="reset"/>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
<script type="text/javascript" src="{$URL_JS}/bootstrap/js/bootstrap.min.js?v={$upd_version}"></script>
<script>
	var err_newpassword_empty = "{$core->get_Lang('This field is required')}";
	var err_newpassword_short = "{$core->get_Lang('Password must be 6 characters or more')}";
	var err_renewpassword_empty = "{$core->get_Lang('This field is required')}";
	var err_renewpassword_match = "{$core->get_Lang('Confirm password does not match')}";
	var msg_success = "{$core->get_Lang('Password changed successfully')}";
</script>
{literal}
	<script type="text/javascript">
		function validate() {
			var frm = $('#frmResetPass');
			var newpassword = frm.find("input[name='new_password']");
			var renewpassword = frm.find("input[name='renew_password']");
			flag = true;
			if (newpassword.val() == '') {
				if (newpassword.next().hasClass('error_pass')) {
					newpassword.next().text(err_newpassword_empty);
				} else {
					newpassword.parent().append(`<label for="new_password" generated="true" class="error error_pass">` + err_newpassword_empty + `</label>`);
				}
				flag = false;

			}
			if (newpassword.val().length < 6) {
				if (newpassword.next().hasClass('error_pass')) {
					newpassword.next().text(err_newpassword_short);
				} else {
					newpassword.parent().append(`<label for="new_password" generated="true" class="error error_pass">` + err_newpassword_short + `</label>`);
				}
				flag = false;
			} else {
				newpassword.next().remove();
			}
			if (renewpassword.val() == '') {
				if (renewpassword.next().hasClass('error_repass')) {
					renewpassword.next().text(err_renewpassword_empty);
				} else {
					renewpassword.parent().append(`<label for="renew_password" generated="true" class="error error_repass">` + err_renewpassword_empty + `</label>`);
				}

				flag = false;
			} else if (newpassword.val() != renewpassword.val()) {
				if (renewpassword.next().hasClass('error_repass')) {
					renewpassword.next().text(err_renewpassword_match);
					flag = false;
				} else {
					renewpassword.parent().append(`<label for="renew_password" generated="true" class="error error_repass">` + err_renewpassword_match + `</label>`);
					flag = false;
				}
			} else {
				renewpassword.next().remove();
			}
			return flag;
		}

		$(document).ready(function () {
			$('#requestForgot').click(function () {
				if (validate()) {
					$('#frmResetPass').submit();
				} else {
					return false;
				}
			});
			var message = $('.message');
			if (message.hasClass('text-success')) {
				message.text(msg_success);
				setTimeout(function () {
					window.location.href = path_ajax_script + "/index.php?mod=login";
				}, 3000);
			}
		});
	</script>
{/literal}
</html>
