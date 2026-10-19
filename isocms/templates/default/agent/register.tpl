<link rel="stylesheet" href="{$URL_CSS}/homepagenew.css?v={$upd_version}"/>
<link rel="stylesheet" href="{$URL_CSS}/fontawesome/css/all.css?v={$upd_version}"/>
<main id="signin_main">
	<section class="signin_form signup_form">
		<div class="container">
			<div class="d-flex justify-content-center">
				<div class="border_iconi">
					<i id="icon" class="fa-solid fa-user-plus fa-2xl" style="color: #00818a;"></i>
					<i id="icon-awesome" class="fa-regular fa-face-hand-peeking fa-2xl"
					   style="display: none;color: #00818a;"></i>
				</div>
			</div>
			<h2 class="txt_signin">{$core->get_Lang('Sign Up')}</h2>
			<h5 class="txt_des_signin">{$core->get_Lang('Register an account to easily manage your booking')}</h5>
			<div class="form_email_pass d-flex justify-content-center align-items-center">
				<form class="w-100" style="max-width: 530px" method="post" action="" enctype="multipart/form-data">
					<div class="form-group form_mailpass">
						<div class="inner-addon left-addon">
							<input type="name" class="form-control" id="fullname" required
								   onblur="resetIcon()" name="full_name">
							<label for="name" class="form-label txt_emailpass">{$core->get_Lang('Full name')} *</label>
						</div>
						<div class="error_tip" id="error_fullname" style="display: none;"></div>
					</div>
					<div class="form-group form_mailpass">
						<div class="inner-addon left-addon">
							<input type="email" class="form-control" id="useremail" name="email" required
								   onblur="resetIcon()">
							<label for="email" class="form-label txt_emailpass">{$core->get_Lang('Email')} *</label>
						</div>
						<div class="error_tip" id="error_email" style="display: none;"></div>
					</div>
					<div class="form-group form_mailpass">
						<div class="inner-addon left-addon">
							<input type="text" class="form-control" id="phone" name="phone" required
								   onblur="resetIcon()">
							<label for="phone" class="form-label txt_emailpass">{$core->get_Lang('Phone')} *</label>
						</div>
						<div class="error_tip" id="error_phone" style="display: none;"></div>
					</div>
					<div class="form-group form_mailpass">
						<div class="inner-addon left-addon">
							<input type="text" class="form-control" id="company" name="company_name"  required
								   onblur="resetIcon()">
							<label for="company" class="form-label txt_emailpass">{$core->get_Lang('Company')} *</label>
						</div>
						<div class="error_tip" id="error_company" style="display: none;"></div>
					</div>
					<div class="row">
						<div class="col-md-6 col-12">
							<div class="form-group form_mailpass">
								<div class="inner-addon left-addon">
									<select class="form-select" name="country_id" aria-label="Default select example">
										<option value="0" selected>Choose nationality</option>
										option
										{foreach from=$listCountryEx key=key item=item}
										<option value="{$item.country_id}">{$item.title}</option>
										{/foreach}
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-12">
							<div class="form-group form_mailpass">
								<div class="inner-addon left-addon">
									<select class="form-select" name="market_id" aria-label="Default select example">
										<option value="0" selected>Choose market</option>
										{foreach from=$listMarket key=key item=item}
											<option value="{$item.country_id}">{$item.title}</option>
										{/foreach}
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group form_mailpass">
						<div class="inner-addon left-addon">
							<input type="text" class="form-control" id="website" name="website"
								   onblur="resetIcon()">
							<label for="website" class="form-label txt_emailpass">{$core->get_Lang('Website')}</label>
						</div>
					</div>
					<div class="form-group form_mailpass">
						<div class="inner-addon leftaddon">
							<input type="password" class="form-control" id="userpass" name="password" required
								   onclick="changeIcon()" onfocus="changeIcon()" onblur="resetIcon()">
							<label for="enterpassword" class="form-label txt_emailpass">{$core->get_Lang('Enter Password')} *</label>
							<span class="toggle-password" onclick="togglePassword('userpass', 'toggleIcon1')">
                                <i id="toggleIcon1" class="fa-regular fa-eye"></i>
                            </span>
						</div>
						<div class="error_tip" id="error_password" style="display: none;"></div>
					</div>
					<div class="form-group form_mailpass">
						<div class="inner-addon leftaddon">
							<input type="password" class="form-control" id="confirmpass" name="re_password" required
								   onclick="changeIcon()" onfocus="changeIcon()" onblur="resetIcon()">
							<label for="repassword" class="form-label txt_emailpass">{$core->get_Lang('Repeat Password')} *</label>
							<span class="toggle-password" onclick="togglePassword('confirmpass', 'toggleIcon2')">
                                    <i id="toggleIcon2" class="fa-regular fa-eye"></i>
                            </span>
						</div>
						<div class="error_tip" id="error_re_password" style="display: none;"></div>
					</div>
					<div class="form-group" style="text-align:-webkit-center">
						{if $clsISO->getVar('_ISOCMS_CAPTCHA') eq 'IMG'}
							<label class=" title" for="secure_code">
								<abbr class="required" title="required">*</abbr> {$core->get_Lang('securecode')}
							</label>
							<div>
								<input autocomplete="off" type="text" class="form-control security_code required"
									   name="secure_code" value="" maxlength="5"/>
								<img src="{$PCMS_URL}/captcha.php?sid={$sid}" width="80" height="36" alt="Secure"/>
							</div>
						{else}
							<div class="g-recaptcha" data-sitekey="{$clsISO->getVar('reCAPTCHA_KEY')}"></div>
							{if $msgSubmitForm ne ''}
								<div class="error text_left">{$msgSubmitForm}</div>
							{/if}
						{/if}
					</div>

					<input type="hidden" name="submit" value="SignUp">
					<div id="error_tip" class="error_tip mb-3">{$msg_error}</div>
					<button type="submit" class="btn-signIn btn w-100 btn_login">{$core->Get_Lang('Sign up')}</button>
					<div class="mt-4 mb-3 text-end">
						<h5 class="txt_doaccount">{$core->get_Lang("Already have an account ?")}
							<a href="{$clsISO->getLink("agent_signin")}" class="text-info txt_signup ms-2">{$core->get_Lang('Login in here')}
							</a>
						</h5>
					</div>
					<div class="term_privacy">
						<h6 class="txt_termprivacy">{$core->get_Lang("By creating an account, you agree to our")}
							<a href="{$clsISO->getLink('term_condition')}" title="{$core->get_Lang("Terms & Conditions")}">{$core->get_Lang("Terms & Conditions")}
							</a>,
							<a href="{$clsISO->getLink('term_security')}" title="{$core->get_Lang('Privacy Policy')}">{$core->get_Lang('Privacy Policy')}
							</a> {$core->get_Lang('and')}
							<a href="#" title="{$core->get_Lang('Agreement with isoCMS')}">{$core->get_Lang('Agreement with isoCMS')}.
							</a>
						</h6>
					</div>
					<input type="hidden" name="type" value="AGENT">
				</form>
			</div>
		</div>
	</section>
</main>

<script>
	var msg_fullname_required = "{$core->get_Lang('Your fullname should not be empty')}!";
	var msg_email_required = "{$core->get_Lang('Your email should not be empty')}!";
	var msg_company_required = "{$core->get_Lang('Your company should not be empty')}!";
	var msg_phone_required = "{$core->get_Lang('Your phone should not be empty')}!";
	var msg_phone_not_valid = "{$core->get_Lang('Please enter a valid phone number')}!";
	var msg_email_not_valid = "{$core->get_Lang('Please enter a valid email address')}!";
	var msg_email_exits = "{$core->get_Lang('Email Exits')}!";
	var msg_password_required = "{$core->get_Lang('Your password should not be empty')}!";
	var msg_re_password_required = "{$core->get_Lang('Your comfirm password should not be empty')}!";
	var msg_match_password_required = "{$core->get_Lang('Confirm password do not match')}!";
	var msg_signup_error = "{$core->get_Lang('Account or password was incorrect')}!";
	var msg_signup_success = "{$core->get_Lang('Signup success')}!";
	var msg_recapcha = "{$core->get_Lang('You must check Recaptcha')}";
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
			document.getElementById('icon').style.display = 'none';
			document.getElementById('icon-awesome').style.display = 'inline';
		}

		function resetIcon() {
			document.getElementById('icon').style.display = 'inline';
			document.getElementById('icon-awesome').style.display = 'none';
		}

		$(function () {
			$(".btn-signIn").click(function () {
				var $fullname = $("#fullname").val();
				var $email = $("#useremail").val();
				var $password = $("#userpass").val();
				var $phone = $("#phone").val();
				var $company = $("#company").val();
				var $confirmpass = $("#confirmpass").val();

				if ($fullname == '') {
					$('#error_fullname').html(msg_fullname_required).fadeIn().delay(3000).fadeOut();
					$("#fullname").focus();
					return false;
				}
				if ($email == '') {
					$('#error_email').html(msg_email_required).fadeIn().delay(3000).fadeOut();
					$("#useremail").focus();
					return false;
				}
				if ($phone == '' || !isValidPhone($phone)) {
					$('#error_phone').html(msg_phone_required).fadeIn().delay(3000).fadeOut();
					$("#phone").focus();
					return false;
				}
				if (!isValidPhone($phone)) {
					$('#error_phone').html(msg_phone_not_valid).fadeIn().delay(3000).fadeOut();
					$("#phone").focus();
					return false;
				}
				if ($company == '') {
					$('#error_company').html(msg_company_required).fadeIn().delay(3000).fadeOut();
					$("#company").focus();
					return false;
				}
				if (checkValidEmail($email) == false) {
					$('#error_email').html(msg_email_not_valid).fadeIn().delay(3000).fadeOut();
					$("#useremail").focus();
					return false;
				}
				if ($password == '') {
					$('#error_password').html(msg_password_required).fadeIn().delay(3000).fadeOut();
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

		function checkValidEmail(email) {
			var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(email);
		}

		function isValidPhone(phone) {
			const regex = /^\+?\d{7,15}$/;
			return regex.test(phone);
		}

	</script>
	<style>
		.error_tip {
			color: var(--primary-18-babd, #18BABD);
			margin-top: 10px;
		}
	</style>
{/literal}