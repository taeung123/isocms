<?php
function default_default()
{
	global $assign_list, $_CONFIG, $clsISO, $_SITE_ROOT, $dbconn, $mod, $_LANG_ID, $act, $core, $clsModule, $clsButtonNav, $oneSetting, $clsConfiguration;
	#

	$return = (isset($_GET["return"])) ? base64_decode($_GET["return"]) : "";
	if ($core->_SESS->isLoggedin()) {
		redirect(PCMS_URL);
	}
		//session_destroy();
	;
	if (ADMIN_LOGIN_CLIENTAREA) {
		#================= Validate Login Session From Time ================#
		$k = $_GET['k'];
		$t = $_GET['t'];
		if ($t - time() > 24 * 60 * 60 || time() - $t > 24 * 60 * 60) {
			redirect('https://go.vietiso.com/clientarea.php?error=expired');
		}
		#================= Validate Login Session From CGI ================#
		$current = $t . '-VIETISO-' . ($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
		$DOMAIN_SECURE = md5($current . DOMAIN_SESSION);
		if ($k != $DOMAIN_SECURE) {
			/*vnSessionDelVar("LOGGEDIN");
            vnSessionDelVar("NVC_USERNAME");
            vnSessionDelVar("NVC_PASSWORD");
            vnSessionDelVar("K_SESSION"); */
			redirect('https://go.vietiso.com/clientarea.php?error=expired');
		} else {
			vnSessionSetVar("K_SESSION", $k);
			vnSessionSetVar("DOMAIN_SESSION", DOMAIN_SESSION);
		}
	}
	#
	$btnLogin = isset($_POST["btnLogin"]) ? $_POST["btnLogin"] : "";
	$txtUsername = isset($_POST["txtUsername"]) ? $_POST["txtUsername"] : "";
	$txtPassword = isset($_POST["txtPassword"]) ? $_POST["txtPassword"] : "";
	$isValid = 1;
	if ($btnLogin != "") {
		$isValid = ($txtUsername != "" && $txtPassword != "");
		$arrUser = $dbconn->GetAll("select * from " . DB_PREFIX . "user where user_name='$txtUsername' and type='OKRS'");
		#
		if (!empty($arrUser)) {
			$isValid = 0;
		}
		if ($isValid) {
			if ($core->_SESS->checkUser($txtUsername, $txtPassword)) {
				$isValid = 1;
				$core->_SESS->doLogin($txtUsername, $txtPassword);
				redirect(PCMS_URL . "/index.php?admin&lang=" . $_POST['language']);
			} else {
				$isValid = 0;
				$from = 'no-reply@vietiso.com';
				$subject = 'ISOCMS Admin Failed Login Attempt';
				$message = '<font style="font-family:Verdana;font-size:11px"><p></p><p>A recent login attempt failed.  Details of the attempt are below.</p><p>Date/Time: ' . date('d/m/Y H:i:s', time()) . '<br>Username: <a href="mailto:' . $txtUsername . '" target="_blank">' . $txtUsername . '</a><br>IP Address: ' . $_SERVER['REMOTE_ADDR'] . '<br>Hostname: ' . $_SERVER['SERVER_ADDR'] . '</p><p></p><p><a href="' . PCMS_URL . '" target="_blank">' . PCMS_URL . '</a></p></font>';
				$headers = "MIME-Version: 1.0\r\n" .
					"Content-type: text/html; charset=utf-8\r\n" .
					"From:  VietISO Technical Team<" . $from . ">\r\n" .
					"Subject: " . $subject . "\r\n";
				$is_send_mail = @mail('support@vietiso.com', $subject, $message, $headers);
			}
		}
	}
	$assign_list["btnLogin"] = $btnLogin;
	$assign_list["txtUsername"] = $txtUsername;
	$assign_list["isValid"] = $isValid;
	#
	#-- Khóa admin
	$cfg_lock_admin = $clsConfiguration->getValue('cfg_lock_admin');
	$assign_list["cfg_lock_admin"] = $cfg_lock_admin;
	$cfg_lock_admin_date = $clsConfiguration->getValue('cfg_lock_admin_date') ?: 0;
	$assign_list["cfg_lock_admin_date"] = $cfg_lock_admin_date;
	if ($cfg_lock_admin == 1 && time() > $cfg_lock_admin_date) {
		$assign_list["hnv_lock_page"] = 1;
	} else {
		$assign_list["hnv_lock_page"] = 0;
	}
}

function default_logout()
{
	global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $core, $clsModule, $clsButtonNav, $oneSetting;
	if ($core->_SESS->isLoggedin()) {
		$core->_SESS->doLogout();
	}
	#
	if (ADMIN_LOGIN_CLIENTAREA) {
		$t = time();
		$current = $t . '-VIETISO-' . ($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
		$DOMAIN_SECURE = md5($current . DOMAIN_SESSION);
		redirect(PCMS_URL . '/index.php?mod=login&k=' . $DOMAIN_SECURE . '&t=' . $t);
	} else {
		redirect(PCMS_URL . '/index.php?mod=login');
	}
}

function default_ajaxForgotPasswordAdmin()
{
	global $clsISO, $core, $dbconn, $email_template_reset_pass_id, $extLang;
	$clsEmailTemplate = new EmailTemplate();
	$email_template_id = 130;
	$email = isset($_POST['email']) ? $_POST['email'] : '';
	if ($email == '') {
		echo 'email_empty_error';
		die();
	} else {
		$sql = "SELECT user_id,user_name,first_name,last_name FROM " . DB_PREFIX . "user WHERE email = '" . $email . "' OR user_name='" . $email . "' LIMIT 0,1";
		$checkExistEmail = $dbconn->GetAll($sql);

		if (count($checkExistEmail) == 0) {
			echo 'email_not_correct';
			die();
		} else {
			$user_id = $checkExistEmail[0]['user_id'];
			$full_name = $checkExistEmail[0]['first_name'] . ' ' . $checkExistEmail[0]['last_name'];
			$time = time();
			$code = md5(md5($email . 'VIETISO' . $time));
			$sql_update = "UPDATE " . DB_PREFIX . "user SET reset_code = '$code',reset_time='$time' WHERE user_id='$user_id'";
			$dbconn->Execute($sql_update);
			$url_forgot = PCMS_URL . $extLang . '?mod=login&act=resetPassword&code=' . md5($user_id . 'VietISO');
			/*send mail*/
			$message = '<table style="width: 100%; max-width: 580px;" border="0" width="100%" cellspacing="0" cellpadding="0" align="center">
						<tbody>
							<tr>
								<td style="padding: 0px 0px 0px 0px; color: #000000; text-align: left;" role="modules-container" align="left" bgcolor="#ffffff" width="100%">
									<table style="display: none !important; opacity: 0; color: transparent; height: 0; width: 0;" role="module" border="0" width="100%" cellspacing="0" cellpadding="0">
										<tbody>
											<tr>
												<td role="module-content">&nbsp;</td>
											</tr>
										</tbody>
									</table>
									<table style="table-layout: fixed;" role="module" border="0" width="100%" cellspacing="0" cellpadding="0">
										<tbody>
											<tr>
												<td valign="top" height="100%">
													<table
														id="m_-2898233414669558578m_7268126013150070510email-container"
														dir="ltr"
														style="
															direction: ltr;
															border-collapse: collapse;
															color: #444444;
															font-size: 16px;
															font-family: \'Roboto\', Arial, Helvetica, sans-serif;
															border-top: 7px solid #fdd835;
															border-right-width: 0;
															border-left-width: 0;
															border-bottom: 1px solid #ededed;
														"
														role="presentation"
														width="100%"
														cellspacing="0"
														cellpadding="0"
														align="center"
														bgcolor="#ffffff"
													>
														<tbody>
															<tr>
																<td style="padding: 20px 20px 25px;" align="left" valign="center" bgcolor="#ffffff">
																	<a
																		style="text-decoration: none !important; padding-top: 7px; padding-bottom: 0px; display: inline-block;"
																		href="https://u5884587.ct.sendgrid.net/ls/click?upn=aj7znpJXyX9Be2M-2BApLEhBQz9i09Y5goorjGd5fm2Rw-3DjaS7_T7tmL8nd6QlLBGtJzObmyHaXsPhsfOlqsLw74dVfCgHj3q5FF3DTDIHth52YL0CPterWpeUuitJRfuKzCz38aNxXn9ZZj0Sj4GSzOyfkP0UOayG5RCvDwE-2Bc4vy4yPpdwPVp8RTo1YHtLihFX9cUT7G86wTm2XRho-2BLtfN4hpUvxlZz5lI90d9d5CnqRpcNYtGKx0C2N-2BR7MgcS0fVvNr8kX2x3lpEKAqtB0rFa6g-2BI-3D"
																		rel="noopener"
																		target="_blank"
																		data-saferedirecturl="https://www.google.com/url?q=https://u5884587.ct.sendgrid.net/ls/click?upn%3Daj7znpJXyX9Be2M-2BApLEhBQz9i09Y5goorjGd5fm2Rw-3DjaS7_T7tmL8nd6QlLBGtJzObmyHaXsPhsfOlqsLw74dVfCgHj3q5FF3DTDIHth52YL0CPterWpeUuitJRfuKzCz38aNxXn9ZZj0Sj4GSzOyfkP0UOayG5RCvDwE-2Bc4vy4yPpdwPVp8RTo1YHtLihFX9cUT7G86wTm2XRho-2BLtfN4hpUvxlZz5lI90d9d5CnqRpcNYtGKx0C2N-2BR7MgcS0fVvNr8kX2x3lpEKAqtB0rFa6g-2BI-3D&amp;source=gmail&amp;ust=1666930422670000&amp;usg=AOvVaw3lf0fwyxcnodAbTd41C8u3"
																	>
																		<img src="https://isocms.com/admin/isocms/templates/default/skin/images/logo.png" style="outline: none; text-decoration: none; display: block !important; max-width: 171px; text-align: left;" alt="website du lich isoCMS" width="120" />
																	</a>
																</td>
																<td style="padding-right: 20px;" align="right" valign="center" bgcolor="#ffffff">
																	<strong dir="ltr" style="font-weight: normal;">
																		<span style="color: #2e3543; text-decoration: none;">
																			<strong style="font-weight: normal;">
																				<a style="color: #444444; text-decoration: none;" href="#m_-2898233414669558578_m_7268126013150070510_">
																					<span style="color: #2e3543; text-decoration: none;"><span style="color: #2e3543; white-space: nowrap; text-decoration: none;">https://isocms.com</span></span>
																				</a>
																			</strong>
																		</span>
																	</strong>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
									<table style="table-layout: fixed;" role="module" border="0" width="100%" cellspacing="0" cellpadding="0">
										<tbody>
											<tr>
												<td style="padding: 30px 20px 40px 22px; line-height: 28px; text-align: justify;" valign="top" bgcolor="" height="100%">
													<div style="text-align: left;">
														<span style="font-size: 16px;">
															<strong><span style="color: #2e3543;">Xin chào ' . $full_name . '</span></strong>
														</span>
													</div>
													<div style="text-align: left;">&nbsp;</div>
													<div style="text-align: left;">
														<span style="color: #2e3543;">
															<span style="font-family: arial, sans-serif; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; text-align: left;">
																Một yêu cầu thay đổi mật khẩu đăng nhập đã được gửi tới email bạn đăng ký. Vui lòng click vào đường dẫn sau để thay đổi mật khẩu và hoàn tất quy trình:
															</span>
														</span>
														<span style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 16px; color: #2e3543; text-align: left;">
															<a
																href="' . $url_forgot . '"
																target="_blank"
																data-saferedirecturl="https://www.google.com/url?q=https:' . $url_forgot . '&amp;source=gmail&amp;ust=1666930422670000&amp;usg=AOvVaw0E_ZRa-258ibx88HtoDLcO"
															>
																' . $url_forgot . '<wbr />3b
															</a>
														</span>
													</div>
													<div style="text-align: left;">&nbsp;</div>
													<div style="text-align: left;">
														<span style="font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; font-family: arial, sans-serif; font-size: 16px; color: #2e3543; text-align: left;">
															<strong><u>*LƯU Ý:</u></strong> Yêu cầu thay đổi mật khẩu được gửi từ người sử dụng tài khoản. Nếu không phải bạn thao tác, chúng tôi cho rằng ai đó đang cố truy cập tài khoản của bạn. Trong trường
															hợp này, vui lòng không click vào đường dẫn phía trên để bảo vệ tài khoản.
														</span>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
									<table style="table-layout: fixed;" role="module" border="0" width="100%" cellspacing="0" cellpadding="0">
										<tbody>
											<tr>
												<td style="padding: 0px 0px 0px 0px;" role="module-content" valign="top" bgcolor="" height="100%">
													<table style="line-height: 10px; font-size: 10px;" border="0" width="100%" cellspacing="0" cellpadding="0" align="center">
														<tbody>
															<tr>
																<td style="padding: 0px 0px 10px 0px;" bgcolor="#ededed">&nbsp;</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
									<table style="table-layout: fixed;" role="module" border="0" width="100%" cellspacing="0" cellpadding="0">
										<tbody>
											<tr>
												<td style="padding: 30px 20px 15px 22px; line-height: 24px; text-align: justify;" valign="top" bgcolor="" height="100%">
													<div style="text-align: left;">
														<p style="color: #222222; font-family: Arial, Helvetica, sans-serif; font-size: small; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">
															<span style="color: #888888;">NỀN TẢNG KINH DOANH DU LỊCH TRỰC TUYẾN - ISOCMS</span>
														</p>
														<p style="color: #222222; font-family: Arial, Helvetica, sans-serif; font-size: small; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400;">
															<span style="color: #888888;">Điện thoại: +84 243 829 3838 | Địa chỉ: Tầng 18, Toà nhà VTC Online, 18 Tam Trinh, Hai Bà Trưng, Hà Nội, Việt Nam | Email: </span>
															<span style="color: #0066cc;"><a href="mailto:info@vietiso.com" target="_blank">info@vietiso.com</a></span><span style="color: #888888;"> | Website: </span>
															<a
																style="color: #1155cc;"
																href="https://u5884587.ct.sendgrid.net/ls/click?upn=aj7znpJXyX9Be2M-2BApLEhB-2FYd2DrgpIQKC8ulb6aJZZZ04DcEmE98-2F96DYVeBHlDkUKr_T7tmL8nd6QlLBGtJzObmyHaXsPhsfOlqsLw74dVfCgHj3q5FF3DTDIHth52YL0CPterWpeUuitJRfuKzCz38aOi1nOEvhGHt0YZEPUHDG5kjteP5Z3oThDmW6WXULjR3ha-2BNdcrdmhq-2F7gZjF15yPn73PZLf7FBRTrcS51TiTsCNhgn6wT8DoDtfjlkp3TRkY1fA1ok3uwGax-2B0wasCx-2BaHrV41fJQANjV2YOvEMAkI-3D"
																rel="noopener"
																target="_blank"
																data-saferedirecturl="https://www.google.com/url?q=https://u5884587.ct.sendgrid.net/ls/click?upn%3Daj7znpJXyX9Be2M-2BApLEhB-2FYd2DrgpIQKC8ulb6aJZZZ04DcEmE98-2F96DYVeBHlDkUKr_T7tmL8nd6QlLBGtJzObmyHaXsPhsfOlqsLw74dVfCgHj3q5FF3DTDIHth52YL0CPterWpeUuitJRfuKzCz38aOi1nOEvhGHt0YZEPUHDG5kjteP5Z3oThDmW6WXULjR3ha-2BNdcrdmhq-2F7gZjF15yPn73PZLf7FBRTrcS51TiTsCNhgn6wT8DoDtfjlkp3TRkY1fA1ok3uwGax-2B0wasCx-2BaHrV41fJQANjV2YOvEMAkI-3D&amp;source=gmail&amp;ust=1666930422670000&amp;usg=AOvVaw3NFLli6fgMUbfRdtD2-_qY"
															>
																<span style="color: #0066cc;">https://isocms.com</span>
															</a>
														</p>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
									<table style="table-layout: fixed;" role="module" border="0" width="100%" cellspacing="0" cellpadding="0" align="left">
										<tbody>
											<tr>
												<td style="padding: 0px 15px 55px 18px; font-size: 6px; line-height: 10px;" valign="top">
													<table align="left">
														<tbody>
															<tr>
																<td style="padding: 0px 5px;">
																	<a
																		style="border-radius: 2px; display: inline-block;"
																		title="Facebook "
																		role="social-icon-link"
																		href="https://u5884587.ct.sendgrid.net/ls/click?upn=aj7znpJXyX9Be2M-2BApLEhA7prQslKsMs343tOrsVPInR8yzV-2FHmL7c-2FgtAzKzWxAMRm1_T7tmL8nd6QlLBGtJzObmyHaXsPhsfOlqsLw74dVfCgHj3q5FF3DTDIHth52YL0CPterWpeUuitJRfuKzCz38aLKe29pYPMqE3cbCtilMCo-2F4GI0xOhZdtRgDTFqYQOrfytXekg8UV-2FDU5aKEuMs4K9zBU0FRoUPpHK5ZaMgXn9-2Bse8hQagOP40SkIiRQtGhhYU9duVN9rlIWHHgMvT4RYhHgKwIzTBQyuw4sL-2Fd813U-3D"
																		rel="noopener"
																		target="_blank"
																		data-saferedirecturl="https://www.google.com/url?q=https://u5884587.ct.sendgrid.net/ls/click?upn%3Daj7znpJXyX9Be2M-2BApLEhA7prQslKsMs343tOrsVPInR8yzV-2FHmL7c-2FgtAzKzWxAMRm1_T7tmL8nd6QlLBGtJzObmyHaXsPhsfOlqsLw74dVfCgHj3q5FF3DTDIHth52YL0CPterWpeUuitJRfuKzCz38aLKe29pYPMqE3cbCtilMCo-2F4GI0xOhZdtRgDTFqYQOrfytXekg8UV-2FDU5aKEuMs4K9zBU0FRoUPpHK5ZaMgXn9-2Bse8hQagOP40SkIiRQtGhhYU9duVN9rlIWHHgMvT4RYhHgKwIzTBQyuw4sL-2Fd813U-3D&amp;source=gmail&amp;ust=1666930422670000&amp;usg=AOvVaw2rAL__BtIEtU1hUpZBqYzc"
																	>
																		<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/05/Facebook_Logo_%282019%29.png/600px-Facebook_Logo_%282019%29.png" title="Facebook " role="social-icon" alt="Facebook" width="30" height="30" />
																	</a>
																</td>
																<td style="padding: 0px 5px;">
																	<a
																		style="border-radius: 2px; display: inline-block;"
																		title="Pinterest "
																		role="social-icon-link"
																		href="https://u5884587.ct.sendgrid.net/ls/click?upn=aj7znpJXyX9Be2M-2BApLEhFMvQKH-2BCgCRfFKo4RNpjdgYBo3bYYxtFe2DtwxyyTdv9iqv_T7tmL8nd6QlLBGtJzObmyHaXsPhsfOlqsLw74dVfCgHj3q5FF3DTDIHth52YL0CPterWpeUuitJRfuKzCz38aKxkqd-2Fo7h7Ula9J-2BqyVI5muu8oARQX2OOWg5vAjsm-2FYE56UWK5yQmNJvFnBf59DbMKoGKOwtXyLdpoCRyRtJlr0Urzp4lNICdQ81-2FsCkrgZHtDgj1Qiy5Bt7b-2BsNNbgrY9N90vKh2qE7qgxPeyU5Kk-3D"
																		rel="noopener"
																		target="_blank"
																		data-saferedirecturl="https://www.google.com/url?q=https://u5884587.ct.sendgrid.net/ls/click?upn%3Daj7znpJXyX9Be2M-2BApLEhFMvQKH-2BCgCRfFKo4RNpjdgYBo3bYYxtFe2DtwxyyTdv9iqv_T7tmL8nd6QlLBGtJzObmyHaXsPhsfOlqsLw74dVfCgHj3q5FF3DTDIHth52YL0CPterWpeUuitJRfuKzCz38aKxkqd-2Fo7h7Ula9J-2BqyVI5muu8oARQX2OOWg5vAjsm-2FYE56UWK5yQmNJvFnBf59DbMKoGKOwtXyLdpoCRyRtJlr0Urzp4lNICdQ81-2FsCkrgZHtDgj1Qiy5Bt7b-2BsNNbgrY9N90vKh2qE7qgxPeyU5Kk-3D&amp;source=gmail&amp;ust=1666930422670000&amp;usg=AOvVaw3nGOEsJPHliXDQ-su4WXMm"
																	>
																		<img src="https://upload.wikimedia.org/wikipedia/commons/0/08/Pinterest-logo.png" title="Pinterest " role="social-icon" alt="Pinterest" width="30" height="30" />
																	</a>
																</td>
																<td style="padding: 0px 5px;">
																	<a
																		style="border-radius: 2px; display: inline-block;"
																		title="LinkedIn "
																		role="social-icon-link"
																		href="https://u5884587.ct.sendgrid.net/ls/click?upn=aj7znpJXyX9Be2M-2BApLEhIVJBkVAZXJtRo44M1UPinrCH5tvzeH1N8ztK8OBAUcjUiWofpVapr6uTh0UujyL6Q-3D-3DaBcP_T7tmL8nd6QlLBGtJzObmyHaXsPhsfOlqsLw74dVfCgHj3q5FF3DTDIHth52YL0CPterWpeUuitJRfuKzCz38aIjp3E3Wwg2n90ZhrKRlaLSdFGD6XzzeH-2BFUyHdRzrMo6W8hkWMsuFQapd9IlXF-2BqeZkOwBO0-2FGYI5QNsGVW00BJxxn0WEJcwlFrRSF-2FzTOMmti-2Fs6NPBHhHTWRo516b3RYfkLsQ661C0FxeTY-2FdseE-3D"
																		rel="noopener"
																		target="_blank"
																		data-saferedirecturl="https://www.google.com/url?q=https://u5884587.ct.sendgrid.net/ls/click?upn%3Daj7znpJXyX9Be2M-2BApLEhIVJBkVAZXJtRo44M1UPinrCH5tvzeH1N8ztK8OBAUcjUiWofpVapr6uTh0UujyL6Q-3D-3DaBcP_T7tmL8nd6QlLBGtJzObmyHaXsPhsfOlqsLw74dVfCgHj3q5FF3DTDIHth52YL0CPterWpeUuitJRfuKzCz38aIjp3E3Wwg2n90ZhrKRlaLSdFGD6XzzeH-2BFUyHdRzrMo6W8hkWMsuFQapd9IlXF-2BqeZkOwBO0-2FGYI5QNsGVW00BJxxn0WEJcwlFrRSF-2FzTOMmti-2Fs6NPBHhHTWRo516b3RYfkLsQ661C0FxeTY-2FdseE-3D&amp;source=gmail&amp;ust=1666930422670000&amp;usg=AOvVaw3enxuLD5qE-OrORHlINTpD"
																	>
																		<img src="https://upload.wikimedia.org/wikipedia/commons/c/ca/LinkedIn_logo_initials.png" title="LinkedIn " role="social-icon" alt="LinkedIn" width="30" height="30" />
																	</a>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>';
			global $clsConfiguration;
			$from = $clsConfiguration->getValue('CompanyEmail');

			#Send email to customer
			$to = $email;
			$owner = PAGE_NAME;
			$subject = $core->get_Lang('Reset password admin');
			//			var_dump($from,$to,$subject,$message,$owner);die;
			$clsISO->sendEmail($from, $to, $subject, $message, $owner);
			/*end send mail*/
			echo 'reset_success';
			die();
		}
	}
}

function default_resetPassword()
{
	global $assign_list, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $clsISO, $extLang, $_lang;
	$code = isset($_GET['code']) ? $_GET['code'] : '';
	if ($code == '') {
		header("Location: " . PCMS_URL . $extLang . "?mod=login");
	}
	$clsUser = new User();
	$assign_list["clsUser"] = $clsUser;
	$lstUser = $clsUser->getAll();

	for ($i = 0; $i < count($lstUser); $i++) {
		if ($code == md5($lstUser[$i]['user_id'] . 'VietISO')) {
			$user_id = $lstUser[$i]['user_id'];
			break;
		}
	}
	$assign_list['link_login'] = PCMS_URL . $extLang . "?mod=login";
	$oneUser = $clsUser->getOne($user_id);
	$username = $oneUser['user_name'];
	if ($user_id == '' || $oneUser['reset_code'] == '' || $oneUser['reset_time'] < time() - 48 * 60 * 60) {
		header('location:' . $extLang . '/reset/failed/');
	}
	if (isset($_POST['resetP']) && $_POST['resetP'] == 'reset') {
		$new_password = $_POST['new_password'];
		$renew_password = $_POST['renew_password'];
		if ($new_password == $renew_password && $new_password != '') {
			$encryptPassword = $clsUser->encrypt($new_password);
			$sql_update = "UPDATE " . DB_PREFIX . "user SET user_pass='$encryptPassword', reset_code = '',reset_time='',upd_date='" . time() . "' WHERE user_id='$user_id'";
			if ($dbconn->Execute($sql_update)) {
				$assign_list["result"] = 'true';
			} else {
				$assign_list["result"] = 'false';
			}
		} else {
			$assign_list["result"] = 'false';
		}
	}
}
