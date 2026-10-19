{if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
    {assign var="getToTalReview" value=$clsReviews->getToTalReview($tour_id,'tour')}
    {assign var="getStarNewIcon" value=$clsReviews->getStarNewIcon($tour_id,'tour')}
    {assign var="getRateAvg" value=$clsReviews->getRateAvg($tour_id,'tour')}
{else}
    {assign var="getToTalReview" value=$clsReviews->getToTalReviewNoLogin($tour_id,'tour')}
    {assign var="getStarNewIcon" value=$clsReviews->getStarNewIconNoLogin($tour_id,'tour')}
    {assign var="getRateAvg" value=$clsReviews->getRateAvgNologin($tour_id,'tour')}
{/if}
{assign var=textRateAvg value=$clsReviews->getTextRateAvg($tour_id,'tour')}
<div id="hnv_tour_detail_main_review" class="hnv_scrollspy_item hnv_tour_detail_main_review">
    <div class="hnv_tour_detail_main_review_title">
        <h2>{$core->get_Lang('Customer Reviews')}</h2>
    </div>
    <div class="hnv_tour_detail_main_review_content">
        <div class="hnv_tour_detail_main_review_content_filter">
            <div class="row">
                <div class="col-md-5">
                    <div class="hnv_tour_detail_main_review_content_filter_left">
                        <div class="hnv_tour_detail_main_review_content_filter_left_star">
                            <span>{$getRateAvg}</span>
                            <div class="hnv_tour_detail_main_review_content_filter_left_star_list">
                                {$getStarNewIcon}
                            </div>
                        </div>
                        <div class="hnv_tour_detail_main_review_content_filter_left_text">
                            <span>{$textRateAvg}</span> - {$getToTalReview}
                            {$core->get_Lang('reviews')}
                        </div>
                        {$core->getBlock('2024_box_review')}
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="hnv_tour_detail_main_review_content_filter_right">
                        {section name=i loop=5} 
                            {assign var="iteration" value=$smarty.section.i.loop - $smarty.section.i.index}
                            <div class="hnv_tour_detail_main_review_content_filter_right_item iso_filter_reviews_rates_{$iteration} iso_filter_reviews_count_{$iteration}">
                                <div class="hnv_tour_detail_main_review_content_filter_right_checkbox_list">
                                    <input type="checkbox" class="hnv_tour_detail_main_review_content_filter_right_checkbox_item iso_filter_reviews" value="{$iteration}"/>
                                    {$iteration} {$core->get_Lang('stars')}
                                </div>
                                <div class="progress hnv_tour_detail_main_review_content_filter_right_progress_item">
                                    <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="hnv_tour_detail_main_review_content_filter_right_count"></div>
                            </div>
                        {/section}
                    </div>
                </div>
            </div>
        </div>
        <div class="hnv_tour_detail_main_review_content_list"></div>
    </div>
</div>
{literal}
<style>
    .hnv_tour_detail_main_review {
        margin-bottom: 50px;
    }
    .hnv_tour_detail_main_review_content_filter {
        margin-bottom: 40px;
    }
    .hnv_tour_detail_main_review_title {
        color: #1c1c1c;
        font-size: 28px;
        font-style: normal;
        font-weight: 700;
        line-height: 40px; /* 142.857% */
        margin-bottom: 16px;
    }
    .hnv_tour_detail_main_review_content_filter_left_star {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .hnv_tour_detail_main_review_content_filter_left_star span {
        color: var(--primary-1-d-2-d-53, #1d2d53);
        font-size: 36px;
        font-style: normal;
        font-weight: 500;
        line-height: 56px; /* 155.556% */
    }
    .hnv_tour_detail_main_review_content_filter_left_star_list {
        font-size: 32px;
    }
    .hnv_tour_detail_main_review_content_filter_left_text {
        color: var(--chroma-717171, #717171);
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: 21px; /* 150% */
        margin-bottom: 26px;
    }
    .hnv_tour_detail_main_review_content_filter_left_text span {
        color: var(--primary-1-d-2-d-53, #1d2d53);
        font-weight: 500;
    }
    .hnv_tour_detail_main_review_content_filter_left_button {
        display: inline-flex;
        padding: 9px 20px;
        justify-content: center;
        align-items: center;
        gap: 10px;
        border-radius: 4px;
        background: var(--primary-18-babd, #18babd);
        color: var(--chroma-ffffff, #fff);
        font-size: 16px;
        font-style: normal;
        font-weight: 500;
        line-height: 24px; /* 150% */
    }
    .hnv_tour_detail_main_review_content_item {
        padding: 28px 0;
        border-top: 1px solid #c8cbd0;
        border-bottom: 1px solid #c8cbd0;
    }
    .hnv_tour_detail_main_review_content_item_info {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 14px;
    }
    .hnv_tour_detail_main_review_content_item_info_avatar {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        border-radius: 50%;
    }
    .hnv_tour_detail_main_review_content_item_info_avatar img {
        border-radius: 50%;
    }
    .hnv_tour_detail_main_review_content_item_info_name {
        color: var(--chroma-717171, #717171);
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: 21px; /* 150% */
    }
    .hnv_tour_detail_main_review_content_item_info_name span {
        color: var(--primary-1-d-2-d-53, #1d2d53);
        font-size: 16px;
        font-style: normal;
        font-weight: 700;
        line-height: 24px; /* 150% */
    }
    .hnv_tour_detail_main_review_content_item_star_date {
        color: var(--chroma-717171, #717171);
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: 21px; /* 150% */
    }
    .hnv_tour_detail_main_review_content_item_star_list {
        font-size: 16px;
        position: relative;
    }
    .hnv_rating_star_list {
        color: #ffd012 !important;
    }
    .hnv_rating_star_list_absolute {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 0;
        display: flex;
        background: #ffd012;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .hnv_tour_detail_main_review_content_item_star {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
    }
    .hnv_tour_detail_main_review_content_item_text {
        color: var(--primary-1-d-2-d-53, #1d2d53);
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: 21px; /* 150% */
        margin-bottom: 16px;
    }
    .hnv_tour_detail_main_review_content_item_image {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .hnv_tour_detail_main_review_content_item_image_item {
        flex-shrink: 0;
        overflow: hidden;
        border-radius: 4px;
        width: 100px;
        height: 100px;
        cursor: pointer;
    }
    .btn_more_reviews {
        display: flex;
        padding: 9px 20px;
        justify-content: center;
        align-items: center;
        gap: 10px;
        border-radius: 4px;
        background: var(--primary-18-babd, #18babd);
        color: var(--chroma-ffffff, #fff);
        font-size: 16px;
        font-style: normal;
        font-weight: 500;
        line-height: 24px;
        border: unset;
        margin: 30px auto;
    }
    .hnv_tour_detail_main_review_content_filter_right {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 16px;
    }
    .hnv_tour_detail_main_review_content_filter_right_checkbox_item {
        width: 20px;
        height: 20px;
    }
    .hnv_tour_detail_main_review_content_filter_right_checkbox_list
        input[type="checkbox"]:checked {
        background-color: var(--secondary-00818-a, #00818a);
        border-color: var(--secondary-00818-a, #00818a);
        accent-color: var(--secondary-00818-a, #00818a);
    }
    .hnv_tour_detail_main_review_content_filter_right_item {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .hnv_tour_detail_main_review_content_filter_right_progress_item {
        flex-shrink: 0;
        width: 70%;
        height: 8px;
    }
    .hnv_tour_detail_main_review_content_filter_right_progress_item
        .progress-bar {
        background: var(--secondary-007850, #007850);
    }
    .hnv_tour_detail_main_review_content_filter_right_checkbox_list {
        display: flex;
        align-items: center;
        gap: 8px;
    }
</style>
{/literal}
