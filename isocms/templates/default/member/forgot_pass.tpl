<div class="page_container">
	 <div class="container">
    	<div id="ModalForgotPass" class="full-width pd40_0">
			<div class="body page-bg round-bottom pal">
				<h1 class="mt0 mb20">{$core->get_Lang('Password reset')}</h1>
				<div class="note size18 mb10">{$core->get_Lang('We will send instruction for creating a new password to the email address associated with your account')}.</div>
				<form novalidate="" class="ng-pristine ng-valid">
					<div class="mtm mbm">
						<label for="emailAddress">{$core->get_Lang('Email')}</label>
						<br>
						<input type="email" class="isoTxt required txt350" placeholder="{$core->get_Lang('Your Email')}" name="user_email" value="" />
						<div id="message_box" class="mb10 mt05" style="display:none"></div>
					</div>
					<div class="line mt10">
						<div class="unitRight">
							<button type="button" id="forgotBtn" class="fl mr10 submitClick">{$core->get_Lang('Reset')} &raquo;</button>
							<input type="hidden" name="forgotVal" value="forgotVal" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
var require_email = "{$core->get_Lang('Error &#33; Please enter your email')}.";
var require_invalid_email = "{$core->get_Lang('Error &#33; Please enter your email valid')}.";
var reset_success = "{$core->get_Lang('Reset success &#33; Please check your email and active your account')}.";
</script>
{literal}
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function () {
		$(document).on('click','#forgotBtn',function(e){
			var $_this = $(this);
			var $user_email = $('#ModalForgotPass input[name=user_email]');
			var $forgotVal = $('#ModalForgotPass input[name=forgotVal]');
			/* Valid */
			if($user_email.val()== '' || !checkVaidEmail($user_email.val())){
				$('#ModalForgotPass #message_box').html(require_invalid_email);
				$('#ModalForgotPass #message_box').addClass('text-danger').show();
				$user_email.focus();
				return false;
			}
			/**/
			var adata = {
				'user_email': $user_email.val(),
				'forgotVal': $forgotVal.val(),
			};
			$.ajax({
				type: "POST",
				url: path_ajax_script+'/index.php?mod=member&act=ajAjaxForgotGlobal',
				data: adata,
				dataType: "html",
				success: function(html){
					if(html.indexOf('email_empty_error')>=0){
						$('#ModalForgotPass #message_box').html(require_email);
						$('#ModalForgotPass #message_box').removeClass('text-success').addClass('text-danger').show();
						$user_email.focus();
						return false;
					}
					if(html.indexOf('email_not_correct')>=0){
						$user_email.focus();
						$('#ModalForgotPass #message_box').html(require_invalid_email);
						$('#ModalForgotPass #message_box').removeClass('text-success').addClass('text-danger').show();
						return false;
					}
					if(html.indexOf('reset_success')>=0){
						$('#ModalForgotPass #message_box').html(reset_success);
						$('#ModalForgotPass #message_box').removeClass('text-danger').addClass('text-success').show();
						$('#ModalForgotPass input[class=isoTxt]').val('');
					}
				}
			});
			return false;
		});
	})
</script>
{/literal}