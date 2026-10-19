<script defer type="text/javascript" src="{$URL_JS}/jquery.validate.js?v={$upd_version}"></script>
<div class="page mtl" style="margin-top:70px; padding:20px 0">
	<div class="container">
		<div id="ModalResetPass" class="full-width pd40_0">
			<div class="omniture"> </div>
			<div> <span class="h2 mb10 title">{$core->get_Lang('Enter a New Password')}</span> </div>
			<div class="line mbl">
				<div class="main-narrow unit">
					<div class="line">
						<p class="mtn mhn"> </p>
						<div><span class="strong">{$core->get_Lang('Please note')}:</span> {$core->get_Lang('Passwords are case sensitive and must be 6 characters or longer')}.</div>
						<div id="fieldErrors"></div>
						<form id="frmResetPass" class="form-horizontal" method="post">
							<p class="mb10">{$core->get_Lang('This form help you return your password. Please, enter your password, and send request')}</p>
							<div class="line mb20">
								<label>{$core->get_Lang('Password')}</label>
								<input type="password" name="login_password" id="login_password" placeholder="{$core->get_Lang('Password')}" class="isoTxt required input-full"/>
							</div>
							<div class="line mb20">
								<label>{$core->get_Lang('Confirm Password')}</label>
								<input type="password" name="c_login_password" id="c_login_password" placeholder="{$core->get_Lang('Confirm Password')}" class="isoTxt required input-full"/>              
							</div>   
							<div class="line buttonLast">
									<a href="{$clsProfile->getLink('signin')}">{$core->get_Lang('Cancel')}</a>
									<button type="submit" id="requestForgot" class="btn-block btn_main">{$core->get_Lang('Submit')}</button> 
									<input type="hidden" name="val" value="val" />
							</div>       
							{literal}
							<script type="text/javascript">
								document.addEventListener("DOMContentLoaded", function () {
									$('#frmResetPass').validate();
								})
							</script>
							{/literal}
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
