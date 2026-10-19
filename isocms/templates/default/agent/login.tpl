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
			<h2 class="txt_signin">{$core->get_Lang('Log in and get exploring')}</h2>
			<h5 class="txt_des_signin">{$core->get_Lang('One single account to explore everywhere and manage your bookings')}.
				<br>
				{$core->get_Lang('Quick andeasy')} !
			</h5>
			<div class="form_email_pass d-flex justify-content-center align-items-center"
				 style="flex-direction: column">
				<form id="signformM_form" method="post" class="w-100" action="" enctype="multipart/form-data"
					  class="AppForm signformM_form" style="max-width: 530px">
					<div class="form-group form_mailpass">
						<div class="addon_form inner-addon left-addon">
							<input type="text" name="email" autocomplete="off" id="emaillogin" class="form-control"
								   placeholder=" " required
								   onblur="resetIcon()">
							<label for="email" class="form-label txt_emailpass">{$core->get_Lang('Email')}</label>
						</div>
						<div class="error_tip" id="error_email" style="display: none;"></div>
					</div>
					<div class="form-group form_mailpass">
						<div class="addon_form inner-addon left-addon">
							<input type="password" name="password" autocomplete="off" class="form-control" id="pwd"
								   placeholder=" " required
								   onclick="changeIcon()" onfocus="changeIcon()" onblur="resetIcon()">
							<label for="password"
								   class="form-label txt_emailpass">{$core->get_Lang('Enter password')}</label>
							<span class="toggle-password" onclick="togglePassword()">
                                <i id="toggleIcon" class="fa-regular fa-eye"></i>
                            </span>
						</div>
					</div>
					<div class="error_tip mb-3" id="error_password">{$msgSubmitForm}</div>
					<input type="hidden" name="LOGIN" value="LOGIN">
					<button type="submit"
							class="btn w-100 btn_login btn-cmd-submit">{$core->get_Lang('Sign in')}</button>
					<input type="hidden" id="return_url" name="return_url" value="{$return_url}"/>
					<input type="hidden" name="submit" value="Login"/>
					<div id="error_tip" class="error_tip"></div>

					<div class="mt-4 mb-3 {if $deviceType !="phone"}d-flex justify-content-between flex-wrap{/if}">
						<div class="button_forgot">
							<a id="ForgotPassLink" href="javascript:void(0);" data-bs-toggle="modal"
							   data-bs-target="#exampleModal"
							   class="txt_forgotpass" title="{$core->get_Lang('Forgot Your Password')}">
								{$core->get_Lang('Forgot Your Password')}
							</a>
						</div>
						<h5 class="txt_doaccount">{$core->get_Lang("Don't have account?")}
							<a href="{$clsISO->getLink('agent_signup')}" class="text-info txt_signup ms-2"
							   title="{$core->get_Lang('Sign up')}">
								{$core->get_Lang('Sign up')}
							</a>
						</h5>
					</div>

					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
						 aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered"" role="document">
							<div class="modal-content">
								<div class="text-right mt-3 me-3">
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
										<i class="fa fa-times"></i>
									</button>
								</div>
								<div class="modal-body">
									<div class="body page-bg round-bottom pal">
										<h2 class="title_pwd_reset">{$core->get_Lang('Password reset')}</h2>
										<div class="note size16">
											{$core->get_Lang('We will send instruction for creating a new password to the email address associated with your account')}.
										</div>
										<form novalidate class="ng-pristine ng-valid">
											<div class="mtm mbm">
												<input type="email" class="isoTxt required txt350 form-control revert_pd_bst"
													   placeholder="{$core->get_Lang('Your Email')}" name="user_email"
													   value=""/>
												<div id="message_box" class="mb10 mt05" style="display:none"></div>
											</div>
											<div class="line mt10">
												<button type="button" id="forgot_Btn"
														class=" submitClick btn w-100 btn-cmd-submit">
													{$core->get_Lang('Reset')} <i class="fa-light fa-arrow-right"></i>
												</button>
												<input type="hidden" name="forgotVal" value="forgotVal"/>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
</main>

<script>
	var msg_email_required = "{$core->get_Lang('Your email should not be empty')}!";
	var msg_email_not_valid = "{$core->get_Lang('Please enter a valid email address')}!";
	var msg_password_required = "{$core->get_Lang('Your password should not be empty')}!";
	var msg_signin_error = "{$core->get_Lang('Account or password was incorrect')}!";
	var msg_signin_success = "{$core->get_Lang('Signin success')}!";
	var mess_change_pwd = "{$mess_change_pwd}";
	var icon_swal = "{$icon_swal}";
</script>

{literal}
	<script>
		function togglePassword() {
			const passwordInput = document.getElementById("pwd");
			const toggleIcon = document.getElementById("toggleIcon");

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
		if (mess_change_pwd) {
			Swal.fire({
				title: mess_change_pwd,
				icon: icon_swal
			}).then((result) => {
				if (result.isConfirmed) {
					// Xóa toàn bộ query string, giữ lại origin + pathname
					const baseUrl = window.location.origin + window.location.pathname;
					window.history.replaceState({}, '', baseUrl);
				}
			});
		}
	</script>
	<style>
		.popup {
			display: none; /* Ẩn pop-up theo mặc định */
			position: fixed;
			z-index: 1000;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.5);
			align-content: center;
		}

		.popup-content {
			background-color: white;
			margin: 5% auto; /* Giảm khoảng cách từ trên và dưới cho phù hợp với màn hình nhỏ */
			padding: 20px;
			border: 1px solid #888;
			max-width: 500px; /* Chiều rộng tối đa cho pop-up */
			width: 90%; /* Chiếm 90% chiều rộng của màn hình */
			text-align: center;
		}

		.close {
			color: #aaa;
			float: right;
			font-size: 28px;
			font-weight: bold;
		}

		.button_mailreset {
			display: flex;
			gap: 10px;
			justify-content: center;
		}

		#emailInput {
			height: 42px;
		}

		.close:hover,
		.close:focus {
			color: black;
			text-decoration: none;
			cursor: pointer;
		}

		.error_tip {
			color: var(--primary-18-babd, #18BABD);
			margin-top: 10px;
		}

		.modal-content .isoTxt {
			min-height: 60px;
			height: 100%;
		}

		.modal-dialog .note {
			line-height: 25px;
			margin-bottom: 18px;
		}
		.modal-dialog h2 {
			margin-bottom: 15px;
		}
	</style>
{/literal}

<script type="text/javascript">
	var require_email = "{$core->get_Lang('Error &#33; Please enter your email')}.";
	var require_invalid_email = "{$core->get_Lang('Error &#33; Please enter your email valid')}.";
	var reset_success = "{$core->get_Lang('Submit request successful &#33; Please check your email and reset your new password')}.";
</script>

{literal}
	<script type="text/javascript">
		$(document).on('click', '#forgot_Btn', function (e) {
			var $_this = $(this);
			var $user_email = $('input[name=user_email]');
			var $forgotVal = $('input[name=forgotVal]');
			/* Valid */
			if ($user_email.val() == '') {
				$('#message_box').html(require_invalid_email);
				$('#message_box').addClass('text-danger').show();
				$user_email.focus();
				return false;
			}
			/**/
			var adata = {
				'email': $user_email.val(),
				'forgotVal': $forgotVal.val(),
			};
			$.ajax({
				type: "POST",
				url: `${path_ajax_script}/index.php?mod=${mod}&act=ajAjaxForgotPass&lang=${LANG_ID}`,
				data: adata,
				dataType: "html",
				success: function (html) {
					if (html.indexOf('email_empty_error') >= 0) {
						$('#message_box').html(require_email);
						$('#message_box').removeClass('text-success').addClass('text-danger').show();
						$user_email.focus();
						return false;
					}
					if (html.indexOf('email_not_correct') >= 0) {
						$user_email.focus();
						$('#message_box').html(require_invalid_email);
						$('#message_box').removeClass('text-success').addClass('text-danger').show();
						return false;
					}
					if (html.indexOf('reset_success') >= 0) {
						$('#message_box').html(reset_success);
						$('#message_box').removeClass('text-danger').addClass('text-success').show();
						$('input[class=isoTxt]').val('');
						/*setTimeout(function () {
							location.reload()
						}, 3000);*/
					}
				}
			});
			return false;
		});

		$('.close').on('click', function () {
			$('#exampleModal').modal('hide');
		});

	</script>
{/literal}