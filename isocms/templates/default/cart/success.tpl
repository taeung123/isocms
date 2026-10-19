<div class="container container_success">
    <div class="success-container">
        <p>
            {assign var=SiteMsg_ResetPassSuccess value=SiteMsg_ResetPassSuccess_|cat:$_LANG_ID}
            {if $show eq 'bookTour'}
                {$SiteMsgTourSuccess|html_entity_decode}
            {/if}
            {if $show eq 'Feedback'}
                {$messageFeedbackSuccess|html_entity_decode}
            {/if}
            {if $show eq 'bookCruise'}
                {$SiteMsgCruiseSuccess|html_entity_decode}
            {/if}
            {if $show eq 'bookHotel'}
                {$SiteMsgHotelSuccess|html_entity_decode}
            {/if}
            {if $show eq 'bookTailor'}
                {$SiteMsgTailorSuccess|html_entity_decode}
            {/if}
            {if $show eq 'Bookingservices'}
                {$SiteMsgServiceSuccess|html_entity_decode}
            {/if}
            {if $show eq 'ResetPassSuccess'}{$clsConfiguration->getValueAutoInfo($SiteMsg_ResetPassSuccess)|html_entity_decode}{/if}
        </p>
        <p>{$core->get_Lang('Thank you for choosing isoCMS, wish you a happy shopping')}!</p>
        <button class="btn btn-back"
                onclick="window.location.href='{PCMS_URL}'">{$core->get_Lang('Back to home page')}</button>
    </div>
</div>

{literal}
    <style>

        .success-container {
            text-align: center;
            padding: 50px 20px;
            max-width: 845px;
            width: 100%;
            margin: 0 auto;
        }

        .success-container img {
            margin-bottom: 60px;
        }

        .success-container h2 {
            margin-bottom: 24px;
            color: var(--primary-1-d-2-d-53, #1D2D53);
            font-size: 28px;
            font-style: normal;
            font-weight: 700;
            line-height: 40px;
        }

        .success-container p {
            color: var(--primary-1-d-2-d-53, #1D2D53);
            text-align: center;
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 24px;
        }

        .btn-back {
            color: #fff;
            border: none;
            padding: 10px 70px;
            border-radius: 4px;
            background: var(--primary-18-babd, #18BABD);
            margin-top: 16px;
        }

        .btn-back:hover {
            background-color: #138496;
            color: #fff;
        }
    </style>
{/literal}