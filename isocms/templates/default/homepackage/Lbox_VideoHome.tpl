{if !empty($listVideoHome)}
<div class="home-video-wrapper video-tabs-nav">

    {* ================= VIDEO LỚN ================= *}
    <div class="home-video-left">
        {foreach from=$listVideoHome key=key item=item}
            {if $key eq 0}
                {assign var=video_id value=$item.video_id}
                {assign var=title_video value=$item.title|default:''}

                <div class="video-item">
                    <img
                        src="{$item.image}"
                        alt="{$title_video|escape:'html'}"
                        width="900"
                        height="600"
                        loading="lazy"
                    />

                    <a
                        class="ic-home ic-play_video play_video js-home-youtube"
                        href="{$item.link|escape:'html'}"
                        data-video-url="{$item.link|escape:'html'}"
                        title="{$title_video|escape:'html'}"
                        >
                            <i class="fa fa-play" aria-hidden="true"></i>
                        </a>
                </div>
            {/if}
        {/foreach}
    </div>

    {* ================= VIDEO NHỎ ================= *}
    <div class="home-video-right">
        {foreach from=$listVideoHome key=key item=item}
            {assign var=video_id value=$item.video_id}
            {assign var=title_video value=$item.title|default:''}

            <div class="video-item {if $key eq 0}video-item-mobile{/if}">
                <div class="photo video-item-img">
                    <img
    src="{$item.image}"
    alt="{$title_video|escape:'html'}"
    width="200"
    height="123"
    loading="lazy"
/>

                  <a
    class="ic-home ic-play_video play_video js-home-youtube"
    href="{$item.link|escape:'html'}"
    data-video-url="{$item.link|escape:'html'}"
    title="{$title_video|escape:'html'}"
>
    <i class="fa fa-play" aria-hidden="true"></i>
</a>
                </div>

                <div class="body">
                    <p class="title">
                        {$title_video}
                    </p>

                    {if !empty($item.reg_date_text)}
                        <div class="time">
                            <i class="fas fa-calendar-alt"></i>
                            {$item.reg_date_text}
                        </div>
                    {/if}
                </div>
            </div>
        {/foreach}
    </div>
</div>

{/if}