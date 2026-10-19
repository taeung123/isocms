<link rel="stylesheet" href="{$URL_CSS}/homepagenew.css?v={$upd_version}"/>
<main id="signin_main">
	<section class="signin_form">
		<div class="container">
			<div class="d-flex justify-content-center">
				<div class="border_iconi">
					<i id="icon" class="fa-regular fa-face-smile fa-2xl" style="color: #00818a;"></i>
					<i id="icon-awesome" class="fa-regular fa-face-hand-peeking fa-2xl"
					   style="display: none;color: #00818a;"></i>
				</div>
			</div>
			<h2 class="txt_signin">{$core->get_Lang('Enter a New Password')}</h2>
			<h5 class="txt_des_signin">{$core->get_Lang('Passwords are case sensitive and must be 8 characters or longer')}.
				<br>
				{$core->get_Lang('This form help you return your password. Please, enter your password, and send request')} !
			</h5>
			<div class="form_email_pass d-flex justify-content-center align-items-center"
				 style="flex-direction: column">
				<form id="signformM_form" method="post" class="w-100" action="" enctype="multipart/form-data"
					  class="AppForm signformM_form" style="max-width: 530px">
					<div class="form-group form_mailpass">
						<div class="addon_form inner-addon left-addon">
							<input type="password" name="password" autocomplete="off" class="form-control" id="userpass"
								   placeholder=" " required
								   onclick="changeIcon()" onfocus="changeIcon()" onblur="resetIcon()">
							<label for="password"
								   class="form-label txt_emailpass">{$core->get_Lang('Password')}</label>
							<span class="toggle-password" onclick="togglePassword('userpass', 'toggleIcon1')">
                                <i id="toggleIcon1" class="fa-regular fa-eye"></i>
                            </span>
						</div>
					</div>
					<div class="form-group form_mailpass">
						<div class="addon_form inner-addon left-addon">
							<input type="password" name="re_password" autocomplete="off" class="form-control" id="confirmpass"
								   placeholder=" " required
								   onclick="changeIcon()" onfocus="changeIcon()" onblur="resetIcon()">
							<label for="password"
								   class="form-label txt_emailpass">{$core->get_Lang('Confirm password')}</label>
							<span class="toggle-password" onclick="togglePassword('confirmpass', 'toggleIcon2')">
                                <i id="toggleIcon2" class="fa-regular fa-eye"></i>
                            </span>
						</div>
						<div class="error_tip" id="error_re_password" style="display: none;"></div>
					</div>
					<div class="error_tip mb-3" id="error_password">{$msgSubmitForm}</div>
					<input type="hidden" name="RESET_PASS" value="RESET_PASS">
					<button type="submit"
							class="btn w-100 btn_login btn-cmd-submit">{$core->get_Lang('Submit')}</button>
					<input type="hidden" id="return_url" name="return_url" value="{$return_url}"/>
					<input type="hidden" name="submit" value="Login"/>
					<div id="error_tip" class="error_tip"></div>
				</form>
			</div>
		</div>
	</section>
</main>

<script>
	var msg_password_required = "{$core->get_Lang('Your password should not be empty')}!";
	var msg_re_password_required = "{$core->get_Lang('Your comfirm password should not be empty')}!";
	var msg_match_password_required = "{$core->get_Lang('Confirm password do not match')}!";
	var msg_password_weak = "{$core->get_Lang('Password must be more than 8 characters')}";
</script>

{literal}
	<script>
		function togglePassword(inputId, iconId) {
			const passwordInput = document.getElementById(inputId);
			const toggleIcon = document.getElementById(iconId);

			if (passwordInput.type === "password") {
				passwordInput.type = "text";
				toggleIcon.classList.remove("fa-eye");
				toggleIcon.classList.add("fa-eye-slash");
			} else {
				passwordInput.type = "password";
				toggleIcon.classList.remove("fa-eye-slash");
				toggleIcon.classList.add("fa-eye");
			}
		}

		function changeIcon() {
			// Ẩn icon mặt cười và hiển thị icon awesome
			document.getElementById('icon').style.display = 'none';
			document.getElementById('icon-awesome').style.display = 'inline'; // Hoặc 'block'
		}

		function resetIcon() {
			// Hiển thị lại icon mặt cười và ẩn icon awesome
			document.getElementById('icon').style.display = 'inline'; // Hoặc 'block'
			document.getElementById('icon-awesome').style.display = 'none';
		}

		$(function () {
			$(".btn-cmd-submit").click(function () {
				var $password = $("#userpass").val();
				var $confirmpass = $("#confirmpass").val();
				if ($password == '') {
					$('#error_password').html(msg_password_required).fadeIn().delay(3000).fadeOut();
					$("#userpass").focus();
					return false;
				}
				if ($password.length <= 8) {
					$('#error_password').html(msg_password_weak).fadeIn().delay(3000).fadeOut();
					$("#userpass").focus();
					return false;
				}
				if ($confirmpass == '') {
					$('#error_re_password').html(msg_re_password_required).fadeIn().delay(3000).fadeOut();
					$("#confirmpass").focus();
					return false;
				}
				if ($confirmpass != $password) {
					$('#error_re_password').html(msg_match_password_required).fadeIn().delay(3000).fadeOut();
					$("#confirmpass").focus();
					return false;
				}
				return true;
			});
		});
	</script>
	<style>
		.error_tip {
			color: var(--primary-18-babd, #18BABD);
			margin-top: 10px;
		}
	</style>
{/literal}

