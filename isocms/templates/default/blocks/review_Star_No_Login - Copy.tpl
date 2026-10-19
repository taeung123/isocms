<div class="stories bg_f7f7f7" id="stories">
	{if $clsISO->getBrowser() eq 'phone_'}
		{if empty($lstReview)}
		<div class="full-width inline-block mb20"><a class="btn_write_review full-width inline-block btn_write_review_no_login d-block mt0" href="javascript:void(0);" title="{$core->get_Lang('Reviews')}">{$core->get_Lang('Reviews')}</a></div>
				
		{/if}
	{/if}
	{if $clsISO->getBrowser() ne 'phone'}
	<div id="writeTourReview" style="display:none">
		<form action="" class="simple_form new_review" enctype="multipart/form-data" id="frmCommentCrx" method="post">
			<div class="rating_block">
				<div class="rating-body">
					<div class="rate">
						<span class="title">{$core->get_Lang('Your Rating')}: </span><div class="rate_row"></div>
					</div>
					<div class="details">
						<div class="control-group text optional review_content mt10">
							<div class="controls mb10">
								<input class="full-width required" name="fullname" id="fullname" value="" maxlength="255" type="text" placeholder="{$core->get_Lang('Enter Full Name')}"/>
							</div>
							<div class="controls mb10">
								<input class="full-width email" name="email_reviews" id="email" maxlength="255" type="text" placeholder="{$core->get_Lang('Enter Email')}"/>
							</div>
							<div class="controls mb10">
								<select name="country_id" id="country_id" class="form-control required">
									{$clsCountry->getSelectByCountry($country_id)}
								</select>
							</div>
							<div class="controls">
								<textarea class="text optional textarea full-width"  name="message" id="message" minlength="100" placeholder="{$core->get_Lang('Please write at least 100 characters about your experience at this destination')}." rows="10" data-validate="true"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="media-preview" id="media-preview"></div>
				<div class="bottom">
					<div class="right">
						<button type="button" id="btnClick" class="btn_green btn_main">{$core->get_Lang('Publish Review')}</button>
						<input type="hidden" value="Review" name="Review"> 
						<input type="hidden" value="{$profile_id}" id="member_id" name="member_id"> 
						<input type="hidden" value="{$table_id}" id="table_id" name="table_id"> 
						<input type="hidden" value="{$type}" id="type" name="type">
					</div>
				</div>
			</div>
		</form>
	</div>
	{/if}
	<div class="read_stories">
		{if $mod eq 'tour' || $mod eq 'tour_new' || $mod eq 'voucher' || $mod eq 'hotel' || $mod eq 'cruise'}
		<div class="bg_f7f7f7 {if $lstReview}mb40{else}mb40{/if} totlalReview">
			<h3 class="title_review_box">{$core->get_Lang('Overall rating')}</h3>
			{if $clsISO->getBrowser() eq 'phone'}
				<div class="overall__rating d-flex {if $lstReview}mb40{else}mb40{/if}">
					{if $lstReview}
					<div class="box__left">
						{if $mod eq 'voucher'}
						<span class="review_text">{$clsReviews->getRateAvgNoLogin($voucher_id,'voucher')}</span>

						<label class="rate-2019 rate_star_big block mb05">{$clsReviews->getStarNewNoLogin($voucher_id,'voucher')}</label>
						{else}
						<span class="review_text">{$clsReviews->getRateAvgNoLogin($tour_id,'tour')}</span>
						<label class="rate-2019 rate_star_big block mb05">{$clsReviews->getStarNewNoLogin($tour_id,'tour')}</label>
						{/if}
						<span class="total__reviews">{$getToTalReview} {$core->get_Lang('reviews')}</span>
						<a class="btn_write_review btn_write_review_no_login" href="javascript:void(0);" title="{$core->get_Lang('Reviews')}">{$core->get_Lang('Reviews')}</a>
					</div>
					{else}
					<div class="box__left align-items-center d-flex">
						<a class="btn_write_review btn_write_review_no_login mt50" href="javascript:void(0);" title="{$core->get_Lang('Reviews')}">{$core->get_Lang('Reviews')}</a>
					</div>
					{/if}
					<div class="starReview text_left {if empty($lstReview)}pd0{/if}">
						<p class="inline-block full-width">
							<span class="text_left">5 <i class="fa fa-star color_fec533" aria-hidden="true"></i> </span>
							<span class="pdl_10">{$core->get_Lang('Excellent')} ({$clsReviews->getToTalReviewByTableNoLogin($table_id,'tour','Excellent')})</span>
						</p>
						<p class="inline-block full-width">
							<span class="text_left">4 <i class="fa fa-star color_fec533" aria-hidden="true"></i> </span>
							<span class="pdl_10">{$core->get_Lang('Very good')} ({$clsReviews->getToTalReviewByTableNoLogin($table_id,'tour','Very good')})</span>
						</p>
						<p class="inline-block full-width">
							<span class="text_left">3 <i class="fa fa-star color_fec533" aria-hidden="true"></i> </span>
							<span class="pdl_10">{$core->get_Lang('Good')} ({$clsReviews->getToTalReviewByTableNoLogin($table_id,'tour','Good')})</span>
						</p>
						<p class="inline-block full-width">
							<span class="text_left">2 <i class="fa fa-star color_fec533" aria-hidden="true"></i> </span>
							<span class="pdl_10">{$core->get_Lang('Average')} ({$clsReviews->getToTalReviewByTableNoLogin($table_id,'tour','Average')})</span>
						</p>
						<p class="inline-block full-width mb0">
							<span class="text_left">1 <i class="fa fa-star color_fec533" aria-hidden="true"></i> </span>
							<span class="pdl_10">{$core->get_Lang('Poor')} ({$clsReviews->getToTalReviewByTableNoLogin($table_id,'tour','Poor')})</span>
						</p>
					</div>
				</div>
				<div id="writeTourReview" style="display:none">
					<form action="" class="simple_form new_review" enctype="multipart/form-data" id="frmCommentCrx" method="post">
						<div class="rating_block">
							<div class="rating-body">
								<div class="rate">
									<span class="title">{$core->get_Lang('Your Rating')}: </span><div class="rate_row"></div>
								</div>
								<div class="details">
									<div class="control-group text optional review_content mt10">
										<div class="controls mb10">
											<input class="full-width required" name="fullname" id="fullname" value="" maxlength="255" type="text" placeholder="{$core->get_Lang('Enter Full Name')}"/>
										</div>
										<div class="controls mb10">
											<input class="full-width email" name="email_reviews" id="email" maxlength="255" type="text" placeholder="{$core->get_Lang('Enter Email')}"/>
										</div>
										<div class="controls mb10">
											<select name="country_id" id="country_id" class="form-control required">
												{$clsCountry->getSelectByCountry($country_id)}
											</select>
										</div>
										<div class="controls">
											<textarea class="text optional textarea full-width"  name="message" id="message" minlength="100" placeholder="{$core->get_Lang('Please write at least 100 characters about your experience at this destination')}." rows="10" data-validate="true"></textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="media-preview" id="media-preview"></div>
							<div class="bottom">
								<div class="right">
									<button type="button" id="btnClick" class="btn_green btn_main">{$core->get_Lang('Publish Review')}</button>
									<input type="hidden" value="Review" name="Review"> 
									<input type="hidden" value="{$profile_id}" id="member_id" name="member_id"> 
									<input type="hidden" value="{$table_id}" id="table_id" name="table_id"> 
									<input type="hidden" value="{$type}" id="type" name="type">
								</div>
							</div>
						</div>
					</form>
				</div>
				{else}
				<div class="overall__rating d-flex">
					{if $mod eq 'voucher'}
						<div class="box__left">
							<span class="review_text">{$clsReviews->getRateAvgNoLogin($voucher_id,'voucher')}</span>
							<label class="rate-2019 rate_star_big block mb05">{$clsReviews->getStarNewNoLogin($voucher_id,'voucher')}</label>
							<span class="total__reviews">{$getToTalReview} {$core->get_Lang('reviews')}</span>
							{if $clsISO->getBrowser() ne 'phone'}
								<a class="btn_write_review btn_write_review_no_login fr" href="javascript:void(0);" title="{$core->get_Lang('Write review')}">{$core->get_Lang('Write review')}</a>
							{/if}
						</div>
					{elseif $mod eq 'tour'}
						{if $lstReview}
							<div class="box__left">
								<span class="review_text">{$clsReviews->getRateAvgNoLogin($tour_id,'tour')}</span>
								<label class="rate-2019 rate_star_big block mb05">{$clsReviews->getStarNewNoLogin($tour_id,'tour')}</label>
								<span class="total__reviews">{$getToTalReview} {$core->get_Lang('reviews')}</span>
							</div>
						{/if}
					
					{elseif $mod eq 'hotel'}
						{if $lstReview}
							<div class="box__left">
								<span class="review_text">{$clsReviews->getRateAvgNoLogin($hotel_id,'hotel')}</span>
								<label class="rate-2019 rate_star_big block mb05">{$clsReviews->getStarNewNoLogin($hotel_id,'hotel')}</label>
								<span class="total__reviews">{$getToTalReview} {$core->get_Lang('reviews')}</span>
							</div>
						{/if}
					
					{elseif $mod eq 'cruise'}
						{if $lstReview}
							<div class="box__left">
								<span class="review_text">{$clsReviews->getRateAvgNoLogin($cruise_id,'cruise')}</span>
								<label class="rate-2019 rate_star_big block mb05">{$clsReviews->getStarNewNoLogin($cruise_id,'cruise')}</label>
								<span class="total__reviews">{$getToTalReview} {$core->get_Lang('reviews')}</span>
							</div>
						{/if}
					{/if}
					
					<div class="starReview text_left {if empty($lstReview)}pd_not_Review{/if}">
						<p class="inline-block full-width">
							<span class="txt_rate text_left">{$core->get_Lang('Excellent')}</span>
							<span class="txt_rate text_right"><label class="rate-2019 text_left"><span style="width:100%"></span></label></span>
							{if $mod eq 'voucher'}
							<span class="process_bar"><i style="width:{$clsReviews->getRateProcessNoLogin(5,$table_id,'voucher')}%"></i></span>
							<span class="w145">{$clsReviews->getToTalReviewByTableNoLogin($table_id,'voucher','Excellent')}</span>
							{else}
							<span class="process_bar"><i style="width:{$clsReviews->getRateProcessNoLogin(5,$table_id,'tour')}%"></i></span>
							<span class="w145">{$clsReviews->getToTalReviewByTableNoLogin($table_id,'tour','Excellent')}</span>
							{/if}
						</p>
						<p class="inline-block full-width">
							<span class="txt_rate text_left">{$core->get_Lang('Very good')}</span>
							<span class="txt_rate text_right"><label class="rate-2019 text_left"><span style="width:80%"></span></label></span>
							{if $mod eq 'voucher'}
							<span class="process_bar"><i style="width:{$clsReviews->getRateProcessNoLogin(4,$table_id,'voucher')}%"></i></span>
							<span class="w145">{$clsReviews->getToTalReviewByTableNoLogin($table_id,'voucher','Very good')}</span>
							{else}
							<span class="process_bar"><i style="width:{$clsReviews->getRateProcessNoLogin(4,$table_id,'tour')}%"></i></span>
							<span class="w145">{$clsReviews->getToTalReviewByTableNoLogin($table_id,'tour','Very good')}</span>
							{/if}
						</p>
						<p class="inline-block full-width">
							<span class="txt_rate text_left">{$core->get_Lang('Good')}</span>
							<span class="txt_rate text_right"><label class="rate-2019 text_left"><span style="width:60%"></span></label></span>
							{if $mod eq 'voucher'}
							<span class="process_bar"><i style="width:{$clsReviews->getRateProcessNoLogin(3,$table_id,'voucher')}%"></i></span>
							<span class="w145">{$clsReviews->getToTalReviewByTableNoLogin($table_id,'voucher','Good')}</span>
							{else}
							<span class="process_bar"><i style="width:{$clsReviews->getRateProcessNoLogin(3,$table_id,'tour')}%"></i></span>
							<span class="w145">{$clsReviews->getToTalReviewByTableNoLogin($table_id,'tour','Good')}</span>
							{/if}
						</p>
						<p class="inline-block full-width">
							<span class="txt_rate text_left">{$core->get_Lang('Average')}</span>
							<span class="txt_rate text_right"><label class="rate-2019 text_left"><span style="width:40%"></span></label></span>
							{if $mod eq 'voucher'}
							<span class="process_bar"><i style="width:{$clsReviews->getRateProcessNoLogin(2,$table_id,'voucher')}%"></i></span>
							<span class="w145">{$clsReviews->getToTalReviewByTableNoLogin($table_id,'voucher','Average')}</span>
							{else}
							<span class="process_bar"><i style="width:{$clsReviews->getRateProcessNoLogin(2,$table_id,'tour')}%"></i></span>
							<span class="w145">{$clsReviews->getToTalReviewByTableNoLogin($table_id,'tour','Average')}</span>
							{/if}
						</p>
						<p class="inline-block full-width mb0">
							<span class="txt_rate text_left">{$core->get_Lang('Poor')}</span>
							<span class="txt_rate text_right"><label class="rate-2019 text_left"><span style="width:20%"></span></label></span>
							{if $mod eq 'voucher'}
							<span class="process_bar"><i style="width:{$clsReviews->getRateProcessNoLogin(1,$table_id,'voucher')}%"></i></span>
							<span class="w145">{$clsReviews->getToTalReviewByTableNoLogin($table_id,'voucher','Poor')}</span>
							{else}
							<span class="process_bar"><i style="width:{$clsReviews->getRateProcessNoLogin(1,$table_id,'tour')}%"></i></span>
							<span class="w145">{$clsReviews->getToTalReviewByTableNoLogin($table_id,'tour','Poor')}</span>
							{/if}
						</p>
					</div>
				</div>
			{/if}
			{/if}
			
			{if $lstReview}
			<div class="clearfix"></div>
			<div class="cruise-review-tab">
			<div class="review-list">
				<h3 class="title_review_box">{$core->get_Lang('Review details')}</h3>
				<ul class="load_result-review list_style_none" id="commentCrx">
					{section name=i loop=$lstReview}
					{assign var=rates 		value=$clsReviews->getRates($lstReview[i].reviews_id,$lstReview[i])}
					{assign var=full_name 	value=$clsReviews->getFullName($lstReview[i].reviews_id,$lstReview[i])}
					{assign var=dateSecond 	value=$clsISO->formatDateSecond($lstReview[i].review_date)}
					{assign var=timeToText 	value=$clsISO->converTimeToTextShort($lstReview[i].review_date)}
					{assign var=rateStar 	value=$clsReviews->getRatesStar($lstReview[i].reviews_id,$lstReview[i])}
					{assign var=rateOne 	value=$clsReviews->getTextRateOne($lstReview[i].reviews_id,$lstReview[i])}
					{assign var=content 	value=$clsReviews->getContent($lstReview[i].reviews_id,400,true,$lstReview[i])|html_entity_decode}
						
                    <li id="Reviews{$lstReview[i].reviews_id}" class="box item boder_bottom d-flex" {if $smarty.section.i.iteration gt '3'} style="display:none"{/if}>
                        <div class="member">
                            <div class="image"><span class="bg_main">{$rates}</span>
                            </div>
                        </div>
                        <div class="body">
                            <div class="name mb05">
                                {$full_name} 
                                <span class="inline-block color_666 size16 fr" title="{$dateSecond}">{$timeToText}</span>
                            </div>
                            <p class="inline-block full-width mb10">
                                <span class="rate inline-block "><label class="rate-2019 text_left">{$rateStar}</label> &nbsp;<span class="btn_rate text_bold">{$rateOne}</span></span>

                            </p>
                            <div class="cus-desc">
                                <div class="review-content">
                                    {$content}
                                </div>
                            </div>
                        </div>
                    </li>
					{/section}  
				</ul>
			</div>
			{if $lstReview|@count > 3}
            <div class="cleafix"></div>
            <div id="exploreWorldLoadMore" class="mt20">
                <div id="load_more_collections">
                    <div class="loader"></div>
                    <a href="javascript:void(0);" rel="nofollow" page="1" class="d-block color_1c1c1c show_more_review btn_yellow show-loader" id="show-more">{$core->get_Lang('See more')}</a>
                </div>
            </div>  
			{/if}
		</div>
		{/if}
		</div>
	</div>
</div>
<script >
	var msg_fullname_required = "{$core->get_Lang('Your full name should not be empty')}!";
	var msg_email_required = "{$core->get_Lang('Your email should not be empty')}!";
	var msg_message_required = "{$core->get_Lang('Your message should not be empty')}!";
	var msg_login = "{$core->get_Lang('Sign in saved to review')}!";
	var msg_rating = "{$core->get_Lang('Your rating should not be empty')}!";
	var msg_insert_success = "{$core->get_Lang('Your Review is submit success')}!";
	var msg_email_not_valid = "{$core->get_Lang('Your email is not valid')}!";
	var process = "{$core->get_Lang('Processing')}......";
	var Publish_Review = "{$core->get_Lang('Publish Review')}";
	var Completed = "{$core->get_Lang('Completed')}....";
	
</script>
<script  src="{$URL_JS}/jquery.form.js?ver={$upd_version}"></script>
{literal}
<script >
$(function(){
	$(document).on('click', '#btnClick', function(ev){
		var e = $("#email").val(),
            a = $("#email").val();
		var $_this = $(this);
		if($.trim($('input[name=fullname]').val())==''){
			alert(msg_fullname_required);
			$('input[name=fullname]').addClass('error');
			$('input[name=fullname]').focus();
			return false;
		}
		if($.trim($('input[name=email_reviews]').val())==''){
			alert(msg_email_required);
			$('input[name=email_reviews]').addClass('error');
			$('input[name=email_reviews]').focus();
			return false;
		}
		if (0 == checkValidEmail(a)) {
			alert(msg_email_not_valid);
			$('input[name=email_reviews]').addClass('error');
			$('input[name=email_reviews]').focus();
			return false;
		}
		if($.trim($('textarea[name=message]').val())==''){
			alert(msg_message_required);
			$('input[name=message]').addClass('error');
			$('textarea[name=message]').focus();
			return false;
		}
		if($.trim($('input[name=rates]').val())==''){
			alert(msg_rating);
			$('input[name=rates]').focus();
			return false;
		}
		$_this.closest('form.simple_form').ajaxSubmit({
			type: "POST",
			url: path_ajax_script+'/index.php?mod=home&act=ajSaveReviewsNoLogin&lang='+LANG_ID,
			beforeSend: function(xhr){
				$('button[id^=btnClick]').text(process);
			},
			dataType: "html",
			success: function(html){
				$('button[id^=btnClick]')
					.text(Completed)
					.delay(2000)
					.text(Publish_Review);
				$_this.closest('form.simple_form').resetForm();
				$_this.closest('form.simple_form').clearForm();
				
				if(html.indexOf("_ERROR") >= 0) {
					$('#message_box').html(msg_insert_error).show();
					return false;
				}else if(html.indexOf('_SUCCESS') >=0){
					alert(msg_insert_success);
					$('#media-preview').empty().hide();
					$(".rate_row .rate_star").removeClass('checked');
					$("#rates").val('');
					$("#fullname").val('');
					$("#email").val('');
					$("#message").val('');
					$('#commentCrx li:first').fadeIn().delay(10000).fadeOut();
				}
			}
		});
		return false;
	});
	var $number_per_page = 3;
	var $page = 1;
	$page_aj = 0;
	var timer = '';
	/*loadPage();*/
	$('#show-more').click(function(e) {
		var $totalRecord = $('#commentCrx .box').size();
		if($page_aj){
			$page = $page_aj + 1;
			$page_aj=0;	
		}
		else $page = $page + 1;
		e.preventDefault();
		var $this = $(this);
		clearTimeout(timer);
		$('.loader').show();
		timer = setTimeout(function(){
			var $start = ($page-1) * $number_per_page;
			var $end = $start + $number_per_page;

			for(var i = $start; i < $end; i++) {
				$('.box').eq(i).show();
			}

			$('.loader').hide();
			if($end>=$totalRecord)
				$('#exploreWorldLoadMore').hide();
		}, 500);
	});
	
});
function checkValidEmail(e) {
    var a = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return a.test(e)
}
</script>
{/literal}
<script type="text/htmlpreview" src="{$URL_JS}/reviewstar/starwarsjs.js?v={$upd_version}"></script>
<script src="{$URL_JS}/reviewstar/htmlpreview.min.js?v={$upd_version}"></script>
<script src="{$URL_JS}/reviewstar/yql?v={$upd_version}"></script>
<link rel="stylesheet"  href="{$URL_JS}/reviewstar/style.css?v={$upd_version}">
{literal}
<script >
	HTMLPreview.replaceAssets();
	$(function(){
		$('.rate_row').starwarsjs({
			stars : 5,
			count : 1
		});
	});
</script>
{/literal}
{literal}
<style >
#writeTourReview{margin-bottom:40px}
#writeTourReview .bottom {
    overflow: hidden;
    padding: 10px 0;
}
#writeTourReview .bottom .upload_image {
    float: left;
    margin-top: 0;
    width: 200px;
}
#writeTourReview .bottom .upload_image input {
    display: none;
    position: absolute;
}
#writeTourReview .bottom .upload_image label {
    display: block;
    height: 21px;
    color: #3b444e;
    font-size: 12px;
	line-height:21px;
    text-transform: uppercase;
    font-weight: 400;
    opacity: .8;
    margin: 5px 0 0 0;
}
#writeTourReview .bottom .right {
    float: right;
    width: 310px;
    text-align: right;
}
.btn_green {
    border: 0;
    text-transform: uppercase;
    padding: 8px 15px;
    display: inline-block;
    font-size: 14px;
    line-height: 20px;
    vertical-align: middle;
}
#writeTourReview textarea{padding:10px 15px}
.review_content input,.review_content select{width:100%; max-width:320px; line-height:36px; height:36px; padding:0 10px; border-radius:0; border:1px solid #ccc}
</style>
{/literal}





