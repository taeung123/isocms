<div class="page_container bg_fff">
	<div class="nav_agent">
		<div class="container">
			<ul class="nav_ul_agent">
				<li><a href="/dai-ly-du-lich/thong-tin-tai-khoan.html" title="{$core->get_Lang('Thông tin cá nhân')}">{$core->get_Lang('Thông tin cá nhân')}</a></li>
				<li><a href="/dai-ly-du-lich/dat-dich-vu.html" title="{$core->get_Lang('Tour đã đặt')}">{$core->get_Lang('Tour đã đặt')}</a></li>
				<li><a class="current" href="{$curl}" title="{$core->get_Lang('Đánh giá và ảnh')}">{$core->get_Lang('My Reviews')}</a></li>
			</ul>
		</div>
	</div>
    <div id="contentPage" class="pageAgent pageAgentRegister pdt0">
		<div class="container">
			<div class="wishlist-media">
				<h1 class="title24">{$core->get_Lang('My Reviews')}</h1>
				{if $lstReview}
				<div class="cruise-review-tab">
					<div class="review-list">
						<ul class="load_result-review" id="commentCrx">
							{section name=i loop=$lstReview}
							
							<li id="Reviews{$lstReview[i].reviews_id}" class="box item boder_bottom" {if $smarty.section.i.iteration gt '5'} style="display:none"{/if}>
								<div class="block-rate-num text-center">
									<label class="rate-number text-normal">
									{$clsReviews->getRates($lstReview[i].reviews_id)}</label>
									<p class="cus-rate">
										<span class="block text_bold">{$clsReviews->getFullName($lstReview[i].reviews_id)}</span>
										<span class="block">{$clsReviews->getCountry($lstReview[i].reviews_id)}</span>
										<span class="block">{$clsISO->converTimeToTextShort($lstReview[i].reg_date)}</span>
									</p>
								</div>
								<div class="body">
									<div class="cus-desc">
										<div class="review_title">
											"{$clsReviews->getTitle($lstReview[i].reviews_id)}"
										</div>
										<div class="review-content">				
										 {$clsReviews->getContent($lstReview[i].reviews_id)|html_entity_decode}
										</div>	               
									</div>
								</div>
							</li>
							{/section}  
						</ul>
					</div>
				</div>
				{/if}
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
	var msg_success = "{$core->get_Lang('Update profile for agent success')}!";
	var msg_error = "{$core->get_Lang('Update profile for agent not success')}!";
</script>
{literal}
<script type="text/javascript">
	$(function(){
		$("#btn_register").click(function(){
			var $fullname = $("#full_name").val();
			var $email = $("#email").val();
			var $phone = $("#phone").val();
			var $company_name = $("#company_name").val();
			var $position = $("#position").val();
			var $tax_code = $("#tax_code").val();
			
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
			if($("#company_name").val()==''){
				$('#error_company_name').html(msg_company_name_required).fadeIn().delay(3000).fadeOut();
				$("#company_name").focus();
				return false;
			}
			if($("#position").val()==''){
				$('#error_position').html(msg_position_required).fadeIn().delay(3000).fadeOut();
				$("#position").focus();
				return false;
			}
			if($("#tax_code").val()==''){
				$('#error_tax_code').html(msg_tax_code_required).fadeIn().delay(3000).fadeOut();
				$("#tax_code").focus();
				return false;
			}
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod=agent&act=update_profile_agent&lang='+LANG_ID,
				data : $('#agent_register_form').serialize(),
				dataType:'html',
				success:function(html){
					if(html.indexOf("_ERRORUPDATE") >= 0) {
						$('#agent_update_error_msg').html(msg_error).fadeIn().delay(3000).fadeOut();
					}else if(html.indexOf("_SUCCESSUPDATE") >= 0){
						$('#agent_update_success_msg').html(msg_success).fadeIn().delay(3000).fadeOut();
					}
    			}
    		});
    		return false;
		});
	});
	function checkValidEmail(email){
		var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return regex.test(email);
	}
</script>
{/literal}