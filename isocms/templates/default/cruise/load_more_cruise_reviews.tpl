{section name=i loop=$lstReview}
{assign var=reviews_content value=$clsReviews->getContent($lstReview[i].reviews_id)}
<div class="it_lst_review clearfix mt30">
	<div class="it_rate_num_left">
		<span class="rate-number">{$clsReviews->getRates($lstReview[i].reviews_id)}</span>
		<p class="name">{$clsReviews->getFullName($lstReview[i].reviews_id)}</p>
		<p class="country">{$clsReviews->getCountry($lstReview[i].reviews_id)}</p>
		<p class="day">{$clsISO->converTimeToText($lstReview[i].review_date)}</p>
	</div>
	<div class="it_entry_info_right parent_cruise_box ">
		<h3>{$clsReviews->getTitle($lstReview[i].reviews_id)}</h3>
		<div class="intro_box intro_cruise_short reviews">
			{$clsISO->limit_textIso($reviews_content,80)}
			{if $reviews_content|count_words gt 80}
				<a class="more_intro_c" href="javascript:void(0);" title="{$core->get_Lang('Read More')}">{$core->get_Lang('Read More')}</a>
			{/if}
		</div>
		<div class="intro_box intro_cruise_full reviews" style="display:none;">
			{$reviews_content} 
			<a class="less_intro_c" href="javascript:void(0);" title="{$core->get_Lang('Less')}">{$core->get_Lang('Less')}</a>
		</div>
	</div>
</div><!--end it_lst_review-->
{/section}