{if $_ISOCMS_CLIENT_LOGIN eq '1'}
<div class="review_content">
	<div class="totlalReview">
		{if $clsISO->getBrowser() eq 'phone'}
		<div class="overall__rating d-flex">
			{if $lstReview}
			<div class="box__left">
				<span class="review_text">{$clsReviews->getRateAVG($combo_id,'combo')}</span>
				<label class="rate-2019 rate_star_big block mb05">{$clsReviews->getStarNew($combo_id,'combo')}</label>
				<span class="total__reviews">{$getToTalReview} {$core->get_Lang('reviews')}</span>
				<a class="btn_write_review btn_write_review_no_login" href="javascript:void(0);" title="{$core->get_Lang('Reviews')}">{$core->get_Lang('Reviews')}</a>
			</div>
			{else}
			<div class="box__left">
				<a class="btn_write_review btn_write_review_no_login mt50" href="javascript:void(0);" title="{$core->get_Lang('Reviews')}">{$core->get_Lang('Reviews')}</a>
			</div>
			{/if}
			<div class="starReview text_left {if empty($lstReview)}pd0{/if}">
				<p class="inline-block full-width">
					{if $mod eq 'combo'}
					<span class="text_left">5 <i class="fa fa-star color_fec533" aria-hidden="true"></i> </span>
					<span class="pdl_10">{$core->get_Lang('Excellent')} ({$clsReviews->getToTalReviewByTable($table_id,'combo','Excellent')})</span>
					{else}
					<span class="text_left">5 <i class="fa fa-star color_fec533" aria-hidden="true"></i> </span>
					<span class="pdl_10">{$core->get_Lang('Excellent')} ({$clsReviews->getToTalReviewByTable($table_id,'tour','Excellent')})</span>
					{/if}
				</p>
				<p class="inline-block full-width">
					{if $mod eq 'combo'}
					<span class="text_left">4 <i class="fa fa-star color_fec533" aria-hidden="true"></i> </span>
					<span class="pdl_10">{$core->get_Lang('Very good')} ({$clsReviews->getToTalReviewByTable($table_id,'combo','Very good')})</span>
					{else}
					<span class="text_left">4 <i class="fa fa-star color_fec533" aria-hidden="true"></i> </span>
					<span class="pdl_10">{$core->get_Lang('Very good')} ({$clsReviews->getToTalReviewByTable($table_id,'tour','Very good')})</span>
					{/if}
				</p>
				<p class="inline-block full-width">
					{if $mod eq 'combo'}
					<span class="text_left">3 <i class="fa fa-star color_fec533" aria-hidden="true"></i> </span>
					<span class="pdl_10">{$core->get_Lang('Good')} ({$clsReviews->getToTalReviewByTable($table_id,'combo','Good')})</span>
					{else}
					<span class="text_left">3 <i class="fa fa-star color_fec533" aria-hidden="true"></i> </span>
					<span class="pdl_10">{$core->get_Lang('Good')} ({$clsReviews->getToTalReviewByTable($table_id,'tour','Good')})</span>
					{/if}
				</p>
				<p class="inline-block full-width">
					{if $mod eq 'combo'}
					<span class="text_left">2 <i class="fa fa-star color_fec533" aria-hidden="true"></i> </span>
					<span class="pdl_10">{$core->get_Lang('Average')} ({$clsReviews->getToTalReviewByTable($table_id,'combo','Average')})</span>
					{else}
					<span class="text_left">2 <i class="fa fa-star color_fec533" aria-hidden="true"></i> </span>
					<span class="pdl_10">{$core->get_Lang('Average')} ({$clsReviews->getToTalReviewByTable($table_id,'tour','Average')})</span>
					{/if}
				</p>
				<p class="inline-block full-width mb0">
					{if $mod eq 'combo'}
					<span class="text_left">1 <i class="fa fa-star color_fec533" aria-hidden="true"></i> </span>
					<span class="pdl_10">{$core->get_Lang('Poor')} ({$clsReviews->getToTalReviewByTable($table_id,'combo','Poor')})</span>
					{else}
					<span class="text_left">1 <i class="fa fa-star color_fec533" aria-hidden="true"></i> </span>
					<span class="pdl_10">{$core->get_Lang('Poor')} ({$clsReviews->getToTalReviewByTable($table_id,'tour','Poor')})</span>
					{/if}
				</p>
			</div>
		</div>
		{else}
		<div class="overall__rating d-flex">
			{if $lstReview}
			<div class="box__left">
				<span class="review_text">{$clsReviews->getRateAVG($combo_id,'combo')}</span>
				<label class="rate-2019 rate_star_big block mb05">{$clsReviews->getStarNew($combo_id,'combo')}</label>
				<span class="total__reviews">{$getToTalReview} {$core->get_Lang('reviews')}</span>
				<a class="btn_write_review btn_write_review_no_login" href="javascript:void(0);" title="{$core->get_Lang('Reviews')}">{$core->get_Lang('Reviews')}</a>
			</div>
			{else}
			<div class="box__left">
				<a class="btn_write_review btn_write_review_no_login mt50" href="javascript:void(0);" title="{$core->get_Lang('Reviews')}">{$core->get_Lang('Reviews')}</a>
			</div>
			{/if}
			<div class="starReview text_left {if empty($lstReview)}pd_not_Review{/if}">
				<p class="inline-block full-width">
					<span class="txt_rate text_left">{$core->get_Lang('Excellent')}</span>
					<span class="txt_rate text_right"><label class="rate-2019 text_left"><span style="width:100%"></span></label></span>
					{if $mod eq 'combo'}
					<span class="process_bar"><i style="width:{$clsReviews->getRateProcess(5,$table_id,'combo')}%"></i></span>
					<span class="w145">{$clsReviews->getToTalReviewByTable($table_id,'combo','Excellent')}</span>
					{else}
					<span class="process_bar"><i style="width:{$clsReviews->getRateProcess(5,$table_id,'tour')}%"></i></span>
					<span class="w145">{$clsReviews->getToTalReviewByTable($table_id,'tour','Excellent')}</span>
					{/if}
				</p>
				<p class="inline-block full-width">
					<span class="txt_rate text_left">{$core->get_Lang('Very good')}</span>
					<span class="txt_rate text_right"><label class="rate-2019 text_left"><span style="width:80%"></span></label></span>
					{if $mod eq 'combo'}
					<span class="process_bar"><i style="width:{$clsReviews->getRateProcess(4,$table_id,'combo')}%"></i></span>
					<span class="w145">{$clsReviews->getToTalReviewByTable($table_id,'combo','Very good')}</span>
					{else}
					<span class="process_bar"><i style="width:{$clsReviews->getRateProcess(4,$table_id,'tour')}%"></i></span>
					<span class="w145">{$clsReviews->getToTalReviewByTable($table_id,'tour','Very good')}</span>
					{/if}
				</p>
				<p class="inline-block full-width">
					<span class="txt_rate text_left">{$core->get_Lang('Good')}</span>
					<span class="txt_rate text_right"><label class="rate-2019 text_left"><span style="width:60%"></span></label></span>
					{if $mod eq 'combo'}
					<span class="process_bar"><i style="width:{$clsReviews->getRateProcess(3,$table_id,'combo')}%"></i></span>
					<span class="w145">{$clsReviews->getToTalReviewByTable($table_id,'combo','Good')}</span>
					{else}
					<span class="process_bar"><i style="width:{$clsReviews->getRateProcess(3,$table_id,'tour')}%"></i></span>
					<span class="w145">{$clsReviews->getToTalReviewByTable($table_id,'tour','Good')}</span>
					{/if}
				</p>
				<p class="inline-block full-width">
					<span class="txt_rate text_left">{$core->get_Lang('Average')}</span>
					<span class="txt_rate text_right"><label class="rate-2019 text_left"><span style="width:40%"></span></label></span>
					{if $mod eq 'combo'}
					<span class="process_bar"><i style="width:{$clsReviews->getRateProcess(2,$table_id,'combo')}%"></i></span>
					<span class="w145">{$clsReviews->getToTalReviewByTable($table_id,'combo','Average')}</span>
					{else}
					<span class="process_bar"><i style="width:{$clsReviews->getRateProcess(2,$table_id,'tour')}%"></i></span>
					<span class="w145">{$clsReviews->getToTalReviewByTable($table_id,'tour','Average')}</span>
					{/if}
				</p>
				<p class="inline-block full-width mb0">
					<span class="txt_rate text_left">{$core->get_Lang('Poor')}</span>
					<span class="txt_rate text_right"><label class="rate-2019 text_left"><span style="width:20%"></span></label></span>
					{if $mod eq 'combo'}
					<span class="process_bar"><i style="width:{$clsReviews->getRateProcess(1,$table_id,'combo')}%"></i></span>
					<span class="w145">{$clsReviews->getToTalReviewByTable($table_id,'combo','Poor')}</span>
					{else}
					<span class="process_bar"><i style="width:{$clsReviews->getRateProcess(1,$table_id,'tour')}%"></i></span>
					<span class="w145">{$clsReviews->getToTalReviewByTable($table_id,'tour','Poor')}</span>
					{/if}
				</p>
			</div>
		</div>
		{/if}
	</div>
	<div class="stories" id="stories">
		{if $clsISO->getBrowser() ne 'phone'}
		<div id="writeTourReview" style="display:none">
			<form action="/" class="simple_form new_review" enctype="multipart/form-data" id="frmCommentCrx" method="post">
				<div class="rating_block">
					<div class="rating-body">
						<div class="rate">
							<span class="title">{$core->get_Lang('Your Rating')}: </span><div class="rate_row"></div>
						</div>
						<div class="details">
							<div class="control-group text optional mt10">
								<div class="controls">
									<textarea class="text optional textarea full-width"  name="message" id="message" minlength="100" placeholder="{$core->get_Lang('Please write at least 100 characters about your experience at this destination')}." rows="8" data-validate="true" {if $loggedIn ne '1'} disabled="disabled"{/if}></textarea>
								</div>
							</div>
						</div>
					</div>
					{if $loggedIn eq '1'}
					<div class="media-preview" id="media-preview"></div>
					<div class="bottom">
						<div class="upload_image" style="display:none">
							<input id="media-files" multiple name="media_images[]" type="file" data-role="media-upload">
							<label for="media-files"><i class="fa fa-picture-o size21" aria-hidden="true"></i> {$core->get_Lang('Add Photos')}</label>
						</div>
						<div class="right">
							<button type="button" id="btnClick" class="btn_green btn_main">{$core->get_Lang('Publish Review')}</button>
							<input type="hidden" value="Review" name="Review"> 
							<input type="hidden" value="{$profile_id}" id="member_id" name="member_id"> 
							<input type="hidden" value="{$table_id}" id="table_id" name="table_id"> 
							<input type="hidden" value="{$mod}" id="type" name="type"> 
	<!--						<input type="hidden" value="tour" id="type" name="type">-->
							<input type="hidden" value="{$_LANG_ID}" id="_LANG_ID" name="_LANG_ID">
						</div>
					</div>
					{else}
					<p class="msg">{$core->get_Lang('You have already had an account? Please')} <a href="{$clsProfile->getLink('signin_r')}r={$REQUEST_URI}">{$core->get_Lang('Sign In')}</a> {$core->get_Lang('or')} <a href="{$clsProfile->getLink('signup')}">{$core->get_Lang('Sign Up')}</a> {$core->get_Lang('to send reviews')}.</p>
					{/if}
				</div>
			</form>
		</div>
		{/if}
		{if $mod ne 'cruise'}

		{if $clsISO->getBrowser() eq 'phone'}
		<div id="writeTourReview" style="display:none">
			<form action="/" class="simple_form new_review" enctype="multipart/form-data" id="frmCommentCrx" method="post">
				<div class="rating_block">
					<div class="rating-body">
						<div class="rate">
							<span class="title">{$core->get_Lang('Your Rating')}: </span><div class="rate_row"></div>
						</div>
						<div class="details">
							<div class="control-group text optional review_content mt10">
								<div class="controls">
									<textarea class="text optional textarea full-width"  name="message" id="message" minlength="100" placeholder="{$core->get_Lang('Please write at least 100 characters about your experience at this destination')}." rows="8" data-validate="true" {if $loggedIn ne '1'} disabled="disabled"{/if}></textarea>
								</div>
							</div>
						</div>
					</div>
					{if $loggedIn eq '1'}
					<div class="media-preview" id="media-preview"></div>
					<div class="bottom">
						<div class="upload_image" style="display:none">
							<input id="media-files" multiple name="media_images[]" type="file" data-role="media-upload">
							<label for="media-files"><i class="fa fa-picture-o size21" aria-hidden="true"></i> {$core->get_Lang('Add Photos')}</label>
						</div>
						<div class="right">
							<button type="button" id="btnClick" class="btn_green btn_main">{$core->get_Lang('Publish Review')}</button>
							<input type="hidden" value="Review" name="Review"> 
							<input type="hidden" value="{$profile_id}" id="member_id" name="member_id"> 
							<input type="hidden" value="{$table_id}" id="table_id" name="table_id"> 
							<input type="hidden" value="{$mod}" id="type" name="type"> 
	<!--						<input type="hidden" value="tour" id="type" name="type">-->
							<input type="hidden" value="{$_LANG_ID}" id="_LANG_ID" name="_LANG_ID">
						</div>
					</div>
					{else}
					<p class="msg">{$core->get_Lang('You have already had an account? Please')} <a href="{$clsProfile->getLink('signin_r')}r={$REQUEST_URI}">{$core->get_Lang('Sign In')}</a> {$core->get_Lang('or')} <a href="{$clsProfile->getLink('signup')}">{$core->get_Lang('Sign Up')}</a> {$core->get_Lang('to send reviews')}.</p>
					{/if}
				</div>
			</form>
		</div>
		{/if}
		<div class="clearfix"></div>
		{if $lstReview}
		<div class="cruise-review-tab">
		<div class="review-list">
			<h3 class="title_review_box">{$core->get_Lang('Du khách nói gì')}</h3>

			<ul class="load_result-review list_style_none" id="commentCrx">
				{section name=i loop=$lstReview}


					{if $clsISO->getBrowser() eq 'phone'}
						<li id="Reviews{$lstReview[i].reviews_id}" class="box item boder_bottom" {if $smarty.section.i.iteration gt '3'} style="display:none"{/if}>
						<div class="d-flex">
							<div class="member">
								<div class="image"><img alt="{$clsProfile->getFullname($lstReview[i].profile_id)}" src="{$clsProfile->getImageAvatar($lstReview[i].profile_id,58,58)}" width="58" height="58" />
								</div>
							</div>
							<div class="body">
								<div class="name">{$clsProfile->getFullname($lstReview[i].profile_id)} <span class="inline-block color_666 size16 fr" title="{$clsISO->formatDateSecond($lstReview[i].review_date)}">{$clsISO->converTimeToTextShort($lstReview[i].review_date)}</span></div>
								<p class="inline-block full-width mb10">
									<span class="rate inline-block "><label class="rate-2019 text_left">{$clsReviews->getRatesStar($lstReview[i].reviews_id)}</label> &nbsp;<span class="btn_rate text_bold">{$clsReviews->getTextRateOne($lstReview[i].reviews_id)}</span></span>
									{*<time class="inline-block fr color_999 full-width_450" datetime="{$clsISO->formatDateSecond($lstReview[i].review_date)}" title="{$clsISO->formatDateSecond($lstReview[i].review_date)}">{$core->get_Lang('Written on')} {$clsISO->converTimeToTextShort($lstReview[i].review_date)}</time>*}
								</p>
							</div>
						</div>
						<div class="cus-desc">
							<div class="review-content">
								{$clsReviews->getContent($lstReview[i].reviews_id)|html_entity_decode}
							</div>
							<ul class="review_image">
								{$clsImage->getListImage($lstReview[i].reviews_id,'_REVIEW')}
							</ul>
						</div>
						</li>
					{else}
						<li id="Reviews{$lstReview[i].reviews_id}" class="box item boder_bottom d-flex" {if $smarty.section.i.iteration gt '3'} style="display:none"{/if}>
						<div class="member">
							<div class="image"><img class="mb05" alt="{$clsProfile->getFullname($lstReview[i].profile_id)}" src="{$clsProfile->getImageAvatar($lstReview[i].profile_id,58,58)}" width="58" height="58" />
							<div class="name text_center mb0">{$clsProfile->getFullname($lstReview[i].profile_id)}</div>
							</div>
							
						</div>
						<div class="body">
							<div class="name mb05"> </div>
							<p class="inline-block full-width mb10">
								<span class="rate inline-block "><label class="rate-2019 text_left">{$clsReviews->getRatesStar($lstReview[i].reviews_id)}</label> &nbsp;<span class="btn_rate text_bold">{$clsReviews->getTextRateOne($lstReview[i].reviews_id)}</span></span>
								<time class="mgl10 inline-block color_999 full-width_450" datetime="{$clsISO->formatDateSecond($lstReview[i].review_date)}" title="{$clsISO->formatDateSecond($lstReview[i].review_date)}">{$core->get_Lang('Written on')} {$clsISO->converTimeToTextShort($lstReview[i].review_date)}</time>
							</p>
							<div class="cus-desc">
								<div class="review-content">
									{$clsReviews->getContent($lstReview[i].reviews_id)|html_entity_decode}
								</div>
								<ul class="review_image">
									{$clsImage->getListImage($lstReview[i].reviews_id,'_REVIEW')}
								</ul>
							</div>
						</div>
						</li>
					{/if}

				{/section}  
				{literal}
				<script >
					$(function(){
						$('.venobox2').venobox({
							framewidth: '750px',    
							border: '5px',       
							bgcolor: '#fff', 
							numeratio: true,       
							infinigall: true    
						});
					});
				</script>
				{/literal}
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
	{/if}
	</div>
</div>



<script >
	var process = "{$core->get_Lang('Processing')}......";
	var Publish_Review = "{$core->get_Lang('Publish Review')}";
	var Completed = "{$core->get_Lang('Completed')}....";
	var msg_message_required = "{$core->get_Lang('Your message should not be empty')}!";
	var msg_login = "{$core->get_Lang('Sign in saved to review')}!";
	var msg_rating = "{$core->get_Lang('Your rating should not be empty')}!";
	var msg_insert_success = "{$core->get_Lang('Your Review is submit success')}!";
</script>
<script  src="{$URL_JS}/jquery.form.js?ver={$upd_version}"></script>
{literal}
<script >
$(function(){
	$(document).on('change', '#media-files', function(ev){
		var $_this = $(this);
		var fileList = $_this[0].files; 
		for(var i = 0; i < fileList.length; i++) {
			var t = window.URL || window.webkitURL;
			var objectUrl = t.createObjectURL(fileList[i]);
			$('#media-preview').show().append('<div class="img-preview">'
			+'<a href="javascript:void(0);" class="closeMv"><i class="fa fa-remove"></i></a>'
			+'<img width="60px" height="60px" src="' + objectUrl + '" />'
			+'<input type="hidden" name="imgs[]" value="1">'
			+'</div>');
		}
	});
	$(document).on('click', '.closeMv', function(ev){
		var $_this = $(this);
		$_this.closest('.img-preview').remove();
		if($('.img-preview').length == 0){
			$('#media-preview').hide();
		}
		return false;
	});
	$(document).on('click', '#btnClick', function(ev){
		var $_this = $(this);
		if($.trim($('textarea[name=message]').val())==''){
			$('textarea[name=message]').focus();
			return false;
		}
		if($.trim($('input[name=rates]').val())==''){
			$('input[name=rates]').focus();
			return false;
		}
		$_this.closest('form.simple_form').ajaxSubmit({
			type: "POST",
			url: path_ajax_script+'/index.php?mod=home&act=ajSaveReviews&lang='+LANG_ID,
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
				$('#show-more').hide();
		}, 500);
	});
	
});
</script>
{/literal}
{else}
<div class="stories bg_f7f7f7" id="stories">
	<div id="writeTourReview" style="display:none">
		<p class="write_your_story_btn">{$core->get_Lang('Write Your review')}</p>
		<form action="" class="simple_form new_review" enctype="multipart/form-data" id="frmCommentCrx" method="post">
			<div class="rating_block">
				<div class="rating-body">
					<div class="rate">
						<span class="title">{$core->get_Lang('Your Rating')}:</span><div class="rate_row"></div>
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
						<button type="button" id="btnClick" class="btn_green">{$core->get_Lang('Publish Review')}</button>
						<input type="hidden" value="Review" name="Review"> 
						<input type="hidden" value="{$profile_id}" id="member_id" name="member_id"> 
						<input type="hidden" value="{$table_id}" id="table_id" name="table_id"> 
						<input type="hidden" value="{$mod}" id="type" name="type">
						<input type="hidden" value="{$_LANG_ID}" id="_LANG_ID" name="_LANG_ID"> 
					</div>
				</div>
			</div>
		</form>
	</div>
	{if $lstReview}
	<div class="read_stories">
		{if $mod eq 'tour' || $mod eq 'tour_new' || $mod eq 'combo'}
		<h4>Đánh giá tổng thể</h4>
		<div class="bg_f7f7f7 mb40 totlalReview">
			<div class="starReview text_left">
				<p class="inline-block full-width">
					<span class="txt_rate text_left">{$core->get_Lang('Excellent')}</span>
					<span class="txt_rate text_right"><label class="rate-2019 text_left"><span style="width:100%"></span></label></span>
					{if $mod eq 'combo'}
					<span class="process_bar"><i style="width:{$clsReviews->getRateProcess(5,$table_id,'combo')}%"></i></span>
					<span class="w145">{$clsReviews->getToTalReviewByTable($table_id,'combo','Excellent')}</span>
					{else}
					<span class="process_bar"><i style="width:{$clsReviews->getRateProcess(5,$table_id,'tour')}%"></i></span>
					<span class="w145">{$clsReviews->getToTalReviewByTable($table_id,'tour','Excellent')}</span>
					{/if}
				</p>
				<p class="inline-block full-width">
					<span class="txt_rate text_left">{$core->get_Lang('Very good')}</span>
					<span class="txt_rate text_right"><label class="rate-2019 text_left"><span style="width:80%"></span></label></span>
					{if $mod eq 'combo'}
					<span class="process_bar"><i style="width:{$clsReviews->getRateProcess(4,$table_id,'combo')}%"></i></span>
					<span class="w145">{$clsReviews->getToTalReviewByTable($table_id,'combo','Very good')}</span>
					{else}
					<span class="process_bar"><i style="width:{$clsReviews->getRateProcess(4,$table_id,'tour')}%"></i></span>
					<span class="w145">{$clsReviews->getToTalReviewByTable($table_id,'tour','Very good')}</span>
					{/if}
				</p>
				<p class="inline-block full-width">
					<span class="txt_rate text_left">{$core->get_Lang('Good')}</span>
					<span class="txt_rate text_right"><label class="rate-2019 text_left"><span style="width:60%"></span></label></span>
					{if $mod eq 'combo'}
					<span class="process_bar"><i style="width:{$clsReviews->getRateProcess(3,$table_id,'combo')}%"></i></span>
					<span class="w145">{$clsReviews->getToTalReviewByTable($table_id,'combo','Good')}</span>
					{else}
					<span class="process_bar"><i style="width:{$clsReviews->getRateProcess(3,$table_id,'tour')}%"></i></span>
					<span class="w145">{$clsReviews->getToTalReviewByTable($table_id,'tour','Good')}</span>
					{/if}
				</p>
				<p class="inline-block full-width">
					<span class="txt_rate text_left">{$core->get_Lang('Average')}</span>
					<span class="txt_rate text_right"><label class="rate-2019 text_left"><span style="width:40%"></span></label></span>
					{if $mod eq 'combo'}
					<span class="process_bar"><i style="width:{$clsReviews->getRateProcess(2,$table_id,'combo')}%"></i></span>
					<span class="w145">{$clsReviews->getToTalReviewByTable($table_id,'combo','Average')}</span>
					{else}
					<span class="process_bar"><i style="width:{$clsReviews->getRateProcess(2,$table_id,'tour')}%"></i></span>
					<span class="w145">{$clsReviews->getToTalReviewByTable($table_id,'tour','Average')}</span>
					{/if}
				</p>
				<p class="inline-block full-width mb0">
					<span class="txt_rate text_left">{$core->get_Lang('Poor')}</span>
					<span class="txt_rate text_right"><label class="rate-2019 text_left"><span style="width:20%"></span></label></span>
					{if $mod eq 'combo'}
					<span class="process_bar"><i style="width:{$clsReviews->getRateProcess(1,$table_id,'combo')}%"></i></span>
					<span class="w145">{$clsReviews->getToTalReviewByTable($table_id,'combo','Poor')}</span>
					{else}
					<span class="process_bar"><i style="width:{$clsReviews->getRateProcess(1,$table_id,'tour')}%"></i></span>
					<span class="w145">{$clsReviews->getToTalReviewByTable($table_id,'tour','Poor')}</span>
					{/if}
				</p>
			</div>
		</div>
		{/if}
		<div class="tab-item" id="reviews">
			<div class="cruise-review-tab">
				<div class="review-list">
					<ul class="load_result-review" id="commentCrx">
						{section name=i loop=$lstReview}
						<li id="Reviews{$lstReview[i].reviews_id}" class="box item" {if $smarty.section.i.iteration gt '3'} style="display:none"{/if}>
							<div class="member">
								<div class="image"><label class="rate-number text-normal">
									{$clsReviews->getRates($lstReview[i].reviews_id)}</label>
								</div>
								<div class="name">{$clsReviews->getFullname($lstReview[i].reviews_id)}</div>
							</div>
							<div class="body">
								<p class="inline-block full-width">
								<span class="rate inline-block fl full-width_450"><label class="rate-2019 text_left">{$clsReviews->getRatesStar($lstReview[i].reviews_id)}</label> &nbsp;<span class="btn_rate color_999">{$clsReviews->getNewRates($lstReview[i].reviews_id)}</span></span>
								<time class="inline-block fr color_999 full-width_450" datetime="{$clsISO->formatDateSecond($lstReview[i].review_date)}" title="{$clsISO->formatDateSecond($lstReview[i].review_date)}">{$core->get_Lang('Written on')} {$clsISO->converTimeToTextShort($lstReview[i].review_date)}</time>
								</p>
								<div class="cus-desc">
									<div class="review-content">				
									 {$clsReviews->getContent($lstReview[i].reviews_id)|html_entity_decode}
									</div>	
									<ul class="review_image">
									{$clsImage->getListImage($lstReview[i].reviews_id,'_REVIEW')}
									</ul>	                     
								</div>
							</div>
						</li>
						{/section}  
					</ul>
				</div>
				{if $lstReview|@count > 3}
					<div class="cleafix"></div>
					<div id="exploreWorldLoadMore">
						<div id="load_more_collections">
							<div class="loader"></div>
							<a href="javascript:void(0);" rel="nofollow" page="1" class="color_5f93e7 show-loader" id="show-more">{$core->get_Lang('Load more reviews')}</a>
						</div>
					</div>  
				{/if}
			</div>
		</div>
	</div>
	{/if}
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
				$('#show-more').hide();
		}, 500);
	});
	
});
function checkValidEmail(e) {
    var a = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return a.test(e)
}
</script>
{/literal}
{/if}
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
    background: var(--main-color);
    color: var(--color-text-main-bg);
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