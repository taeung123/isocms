<section class="contactHome">
       <div class="container">
       	<section class="col-md-8 col-md-offset-2">
        	<h2 class="headPage text-center">Contact us</h2>
        	<div class="row">
            	<form class="form-light mt-20" id="form-contactHome" method="post" action="" enctype="multipart/form-data" role="form">
                    <div class="col-md-6">
                        <div class="form-group">
                                <input class="isoTxt required form-control f-line" placeholder="{$core->get_Lang('Your Name')}" type="text" name="full_name" value="{$full_name}" style="width:100%" />
                            </div>
                        </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="email" name="email" value="{$email}" class="isoTxt form-control" placeholder="{$core->get_Lang('Your Email')}" />
                        </div>
                    </div>
                    <div class="col-md-12">
                         <div class="form-group">
                            <textarea class="form-control" id="message" name="message" style="height:100px;" placeholder="{$core->get_Lang('Message')}">{$message}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12" style="display:none">
                        <div class="form-group">
                            <input type="text" autocomplete="off" class="form-control" name="security_code" maxlength="5" placeholder="Secure" style="width:120px; float:left; margin-right:5px"> <img src="{$PCMS_URL}/captcha.php?sid={$sid}" onclick="this.src='{$PCMS_URL}/captcha.php?'+Math.random()+'&sid={$sid}'" width="80px" height="34px" alt="Secure" />	
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn-base btn-icon btn-icon-right btn-fly linkContact">
                            <span>{$core->get_Lang('Send')}</span>
                        </button>
                        <input type="hidden" name="Hid_HomeContact" value="Hid_HomeContact">
                    </div>
                </form>
        	</div>
       </section>
    </div>
</section>
{literal}
<script type="text/javascript">
    $(document).ready(function(){
		$('#form-contactHome').validate({
			rules:{
				fullname:{
					required:true 
				},
				email:{
					required:true 
				},
				
				message:{
					required:true 
				}
			},messages:{
				fullname:{
					required:'Your Name should not be empty!' 
				},
				email:{
					required:'Your email should not be empty!' 
				},
				message:{
					required:'Your message should not be empty!' 
				}
			},
			errorElement:'label',
			errorClass:'error'
		});
    });
</script>
{/literal}