{if $clsISO->getCheckActiveModulePackage($package_id,'subscription','default','default')}
<section class="subscribe_Home section_box bgc-F5F5F5">
	<div class="container box_subscribe d-flex">
		<div class="box-left_subscribe">
			
			<div class="box_text_subscribe">
				<h2 class="title">{$core->get_Lang('Sign up for notifications')} & {$core->get_Lang('offers')}</h2>
				<p class="text_subscribe">{$core->get_Lang('Choosing to register means that you agree to our Privacy Policy')}.</p>
			</div>			
		</div>
		
		<div class="box-right_subscribe regiter_email">
			<form method="post" action="{$extLang}" class="subscribe__form">
				<input type="text" id="email_subscribe" placeholder="{$core->get_Lang('Your email')}" class="isoTxt txt required" >
				<input type="text" id="subscribe_check" class="subscribe_check" value="">
				<input class="btn_Subscribe btn_main" id="submitSubscribeHome" type="button" name="btnSubmit" value="{$core->get_Lang('Register')}">
				<input type="hidden" value="Sign me up" name="Submit">
			</form>
			<div id="subcribe_msg" class="subcribe_msg"></div>
		</div>
	</div>
	<script>
		var path_ajax_script = '{$PCMS_URL}';
		var msg_email_required = "{$core->get_Lang('Your email should not be empty')}!";
		var msg_email_not_valid = "{$core->get_Lang('Your email is not valid')}!";
		var msg_success = "{$core->get_Lang('Sign up for email success')}!";
		var msg_exits = "{$core->get_Lang('Email address already exists')}!";
		var subscribe_error = "{$core->get_Lang('subscribe error')}!";
	</script>
	{literal}
	<script>
		$(function(){
			$("#submitSubscribeHome").click(function(){
				var $subscribe_email = $("#email_subscribe").val();
				var $subscribe_check = $("#subscribe_check").val();

				if($("#email_subscribe").val()==''){
					$('#subcribe_msg').html(msg_email_required).fadeIn().delay(3000).fadeOut();
					$("#email_subscribe").focus();
					return false;
				}
				if(checkValidEmail($subscribe_email)==false){
					$('#subcribe_msg').html(msg_email_not_valid).fadeIn().delay(3000).fadeOut();
					$("#email_subscribe").focus();
					return false;
				}

				$.post(`${path_ajax_script}index.php?mod=home&act=ajGetSubs_totalSe&lang=${LANG_ID}`, (res) => {
					let a_se_subs = res.a_se_subs;
					let b_se_subs = res.b_se_subs;
					let subs_totalSe = res.subs_totalSe;
					Swal.fire({
						title: title_question,
						text: `${text_question}: ${a_se_subs} + ${b_se_subs}`,
						input: 'text',
						showCancelButton: true,
						confirmButtonText: "OK",
					}).then((result) => {
						if (result.isConfirmed) {
							if (parseInt(result.value) === parseInt(subs_totalSe)) {
								isLoadingSwal()
								let adata = {
									'email' : $subscribe_email,
									'subscribe_check' : $subscribe_check,
									'subs_totalSe' : result.value,
									'subs_uid' : res.subs_uid
								};
								$.ajax({
									type:'POST',
									url:path_ajax_script+'/index.php?mod=home&act=ajSubmitSubscribe&lang='+LANG_ID,
									data : adata,
									dataType:'json',
									success:function(res){
										Swal.fire({
											title: Object.values(res)[0],
											icon: Object.keys(res)[0],
											timer:3000
										});
										// $('#subcribe_msg').html(html).fadeIn().delay(3000).fadeOut();
									}
								});
							} else {
								Swal.fire({
									title: wrong_answer,
									icon: "error"
								});
							}
						}
					});
				}, "json")
			});
		});
		function checkValidEmail(e) {
			var a = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return a.test(e)
		}
	</script>
	{/literal}
</section>
{/if}