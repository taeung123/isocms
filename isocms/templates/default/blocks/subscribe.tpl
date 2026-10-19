 <div class="subscribe_home">
  <form action="{$extLang}" method="post" class="subscribeform">
         <input type="text" id="subscribe_email"  name="email" placeholder="{$core->get_Lang('Email Address')}" class="subscribe_email">
         <input type="button"  id="submitSubscribe" class="subscribe_Submit" name="subscribe_Submit">
         <input type="hidden" value="Sign me up" name="Submit" />
         <div class="clearfix"></div>
         <div id="subcribe_msg2" class="subcribe_msg mt05 color_fff"></div>
   </form> 
  </div> 
<script type="text/javascript">
	var path_ajax_script = '{$PCMS_URL}';    
    var msg_name_required = "{$core->get_Lang('Your name should not be empty')}!";
    var msg_email_required = "{$core->get_Lang('Your email should not be empty')}!";
	var msg_email_not_valid = "{$core->get_Lang('Your email is not valid')}!";
	var msg_success = "{$core->get_Lang('Sign up for email success')}!";
	var msg_exits = "{$core->get_Lang('Email address already exists')}!";
</script>
{literal}
<style type="text/css">
p.title{color:#ed6e32 !important;font-weight:100;font-size:13px;width:100%}
.subscribe_home{margin-top:30px; position:relative;width:100%; max-width:305px;}
#subcribe_msg2{color:#FFF;font-size:12px}
.subscribe_home #submitSubscribe{
    position:absolute; 
	width:15px; height:15px;
	top:16px;
	right:20px;
	border:0;
	content: "";
	background:url(/isocms/templates/default/skin/images/icon/bg_subscribe.png) no-repeat center center;
	color:#049fe2;
	font-family:'FontAwesome';
	}
#subscribe_email {
    border: 1px solid #ddd;
    padding: 0 10px;
    line-height: 46px;
    border-radius: 5px;
    color: #555;
    width: 100%;
    max-width: 305px;
    background: #fff;
}
</style>
<script type="text/javascript">
function checkValidEmail(e) {
	var a = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return a.test(e)
}
$(function() {
    $("#submitSubscribe").click(function() {
        var e = $("#subscribe_email").val(),
            a = $("#subscribe_email").val();
        if ("" == $("#subscribe_name").val()) return $("#subcribe_msg2").html(msg_name_required).fadeIn().delay(4e3).fadeOut(),
            $("#subscribe_name").focus(), !1;
        if ("" == $("#subscribe_email").val()) return $("#subcribe_msg2").html(msg_email_required).fadeIn().delay(4e3).fadeOut(),
            $("#subscribe_email").focus(), !1;
        if (0 == checkValidEmail(a)) return $("#subcribe_msg2").html(msg_email_not_valid).fadeIn().delay(4e3).fadeOut(), $("#subscribe_email").focus(), !1;
        var s = {
            name: e,
            email: a
        };
        return $.ajax({
            type: "POST",
            url: path_ajax_script + "/index.php?mod=home&act=ajSubmitSubscribe&lang="+LANG_ID,
            data: s,
            dataType: "html",
            success: function(e) {
                e.indexOf("_SUCCESS") >= 0 ? ($("#subscribe_email").html(""), $(".subcribe_msg").css({
                    color: "blue"
                }), $("#subcribe_msg2").html(msg_success).fadeIn().delay(3e3).fadeOut()) : ($("#subscribe_email").html(""), $("#subcribe_msg2").html(msg_exits).fadeIn().delay(3e3).fadeOut())
            }
        }), !1
    })
});
</script>
{/literal}