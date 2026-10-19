<div class="page_container video_page_container">

    {* =====================================================
     * BREADCRUMB
     * ===================================================== *}
    <div class="video_breadcrumb_box">
        <nav class="breadcrumb-main">
            <div class="container">
                <ol
                    class="breadcrumb mt0"
                    itemscope
                    itemtype="https://schema.org/BreadcrumbList"
                >
                    <li
                        itemprop="itemListElement"
                        itemscope
                        itemtype="https://schema.org/ListItem"
                    >
                        <a
                            itemprop="item"
                            href="{$PCMS_URL}"
                            title="{$core->get_Lang('Home')|escape:'html'}"
                        >
                            <span itemprop="name">
                                {$core->get_Lang('Home')}
                            </span>
                        </a>

                        <meta itemprop="position" content="1" />
                    </li>



                    <li
                        class="active"
                        itemprop="itemListElement"
                        itemscope
                        itemtype="https://schema.org/ListItem"
                    >
                        <span itemprop="name">
                            {$core->get_Lang('Experience Videos')}
                        </span>

                        <meta itemprop="position" content="3" />
                    </li>
                </ol>
            </div>
        </nav>
    </div>

    {* =====================================================
     * VIDEO LIST
     * ===================================================== *}
    <main class="video_page_content">
        <div class="container">

            <div class="video_page_heading">
                <h1 class="Title_news">
                    {$core->get_Lang('Experience Videos')}
                </h1>

                {if !empty($lstVideos)}
                    <span class="video_total">
                        {$lstVideos|@count}
                        {$core->get_Lang('Videos')}
                    </span>
                {/if}
            </div>

            {if !empty($lstVideos)}
                <div class="video_grid">
                    <div class="row">

                        {section name=i loop=$lstVideos}
                            {assign
                                var=video_id
                                value=$lstVideos[i].video_id
                            }

                            {assign
                                var=title_video
                                value=$clsVideo->getTitle(
                                    $video_id,
                                    $lstVideos[i]
                                )
                            }

                            {assign
                                var=video_link
                                value=$lstVideos[i].link|default:''
                            }

                            {if empty($video_link)}
                                {assign
                                    var=video_link
                                    value=$clsVideo->getLinkVideo(
                                        $video_id
                                    )
                                }
                            {/if}

                            <article class="video_grid_item col-12 col-sm-6 col-lg-3">
                                <div class="video_card">

                                    {* Ảnh đại diện *}
                                    <div class="video_card_photo">
                                        <img
                                            src="{$clsVideo->getImage(
                                                $video_id,
                                                420,
                                                260,
                                                $lstVideos[i]
                                            )}"
                                            alt="{$title_video|escape:'html'}"
                                            title="{$title_video|escape:'html'}"
                                            width="420"
                                            height="260"
                                            loading="lazy"
                                        />

                                        <a
                                            class="video_play_button js-page-video"
                                            href="{$video_link|escape:'html'}"
                                            data-video-url="{$video_link|escape:'html'}"
                                            data-video-type="{$lstVideos[i].type|default:2}"
                                            title="{$title_video|escape:'html'}"
                                            aria-label="{$core->get_Lang('Play video')|escape:'html'}: {$title_video|escape:'html'}"
                                        >
                                            <i
                                                class="fa fa-play"
                                                aria-hidden="true"
                                            ></i>
                                        </a>
                                    </div>

                                    {* Tiêu đề phía dưới *}
                                    <div class="video_card_body">
                                        <h2 class="video_card_title">
                                            <a
                                                class="js-page-video"
                                                href="{$video_link|escape:'html'}"
                                                data-video-url="{$video_link|escape:'html'}"
                                                data-video-type="{$lstVideos[i].type|default:2}"
                                                title="{$title_video|escape:'html'}"
                                            >
                                                {$title_video}
                                            </a>
                                        </h2>

                                        {if !empty($lstVideos[i].reg_date_text)}
                                            <time class="video_card_date">
                                                <i
                                                    class="fas fa-calendar-alt"
                                                    aria-hidden="true"
                                                ></i>

                                                {$lstVideos[i].reg_date_text}
                                            </time>
                                        {/if}
                                    </div>
                                </div>
                            </article>
                        {/section}

                    </div>
                </div>
            {else}
                <div class="video_empty">
                    {$core->get_Lang('No videos found')}
                </div>
            {/if}

        </div>
    </main>
</div>

{literal}
<style>
/* =========================================================
 * GENERAL
 * ========================================================= */
.video_page_container {
    width: 100%;
    background: #fff;
}

.video_page_container *,
.video_page_container *::before,
.video_page_container *::after {
    box-sizing: border-box;
}

/* =========================================================
 * BREADCRUMB
 * ========================================================= */
.video_breadcrumb_box {
    border-bottom: 1px solid rgba(0, 0, 0, 0.07);
    background: #fff;
}

.video_breadcrumb_box .breadcrumb-main {
    margin: 0;
    padding: 14px 0;
}

.video_breadcrumb_box .breadcrumb {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    margin: 0;
    padding: 0;
    background: transparent;
    list-style: none;
}

.video_breadcrumb_box .breadcrumb li {
    color: #777;
    font-size: 14px;
    line-height: 22px;
}

.video_breadcrumb_box .breadcrumb li + li::before {
    display: inline-block;
    margin: 0 9px;
    color: #aaa;
    content: "/";
}

.video_breadcrumb_box .breadcrumb a {
    color: #777;
    text text-decoration: none;
}

.video_breadcrumb_box .breadcrumb a:hover {
    color: var(--main-color, #f5a900);
}

.video_breadcrumb_box .breadcrumb .active {
    color: #333;
}

/* =========================================================
 * CONTENT
 * ========================================================= */
.video_page_content {
    width: 100%;
    padding: 30px 0 65px;
    background: #fff;
}

.video_page_heading {
    display: flex;
    align-items: center;
    margin-bottom: 28px;
    padding-bottom: 15px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
}

.video_page_heading .Title_news {
    margin: 0;
    color: #333;
    font-size: 34px;
    font-weight: 700;
    line-height: 44px;
}

.video_total {
    flex: 0 0 auto;
    margin-left: auto;
    padding: 6px 13px;
    border-radius: 20px;
    background: rgba(245, 169, 0, 0.12);
    color: #9f6a00;
    font-size: 14px;
    line-height: 20px;
}

/* =========================================================
 * GRID 4 CỘT
 * ========================================================= */
.video_grid > .row {
    display: flex;
    flex-wrap: wrap;
}

.video_grid_item {
    display: flex;
    margin-bottom: 30px;
}

.video_card {
    display: flex;
    width: 100%;
    min-width: 0;
    flex-direction: column;
    overflow: hidden;
    border: 1px solid rgba(36, 107, 72, 0.12);
    border-radius: 4px;
    background: #fff;
    transition:
        transform 0.25s ease,
        box-shadow 0.25s ease;
}

.video_card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.11);
}

/* Ảnh */
.video_card_photo {
    position: relative;
    width: 100%;
    overflow: hidden;
    aspect-ratio: 420 / 260;
    background: #eee;
}

.video_card_photo::after {
    position: absolute;
    inset: 0;
    z-index: 1;
    content: "";
    background: rgba(0, 0, 0, 0);
    pointer-events: none;
    transition: background 0.25s ease;
}

.video_card:hover .video_card_photo::after {
    background: rgba(0, 0, 0, 0.12);
}

.video_card_photo img {
    display: block;
    width: 100%;
    height: 100%;
    border-radius: 0;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.video_card:hover .video_card_photo img {
    transform: scale(1.05);
}

/* Nút play */
.video_play_button {
    position: absolute;
    z-index: 2;
    top: 50%;
    left: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    padding: 0 0 0 3px;
    border-radius: 50%;
    background: var(--main-color, #ffb300);
    color: #fff !important;
    font-size: 21px;
    line-height: 1;
    text-decoration: none !important;
    transform: translate(-50%, -50%);
    transition:
        background 0.2s ease,
        transform 0.2s ease;
}


.video_play_button i {
    margin: 0 !important;
    color: inherit !important;
}
.company_truspilot{
    margin-top: 0;
}
.video_card_body {
    display: flex;
    min-height: 100px;
    flex: 1;
    flex-direction: column;
    padding: 15px 16px 6px;
}

.video_card_title {
    display: -webkit-box;
    margin: 0 0 12px;
    overflow: hidden;
    color: #333;
    font-size: 18px;
    font-weight: 600;
    line-height: 27px;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
}

.video_card_title a {
    color: #333;
    text-decoration: none;
}

.video_card_title a:hover {
    color: var(--main-color, #f5a900);
}

.video_card_date {
    display: block;
    margin-top: 1px;
    color: #777;
    font-size: 13px;
    line-height: 21px;
}

.video_card_date i {
    margin-right: 7px;
    color: var(--main-color, #f5a900);
}

.video_empty {
    padding: 50px 20px;
    border: 1px solid #eee;
    background: #fafafa;
    color: #777;
    text-align: center;
}

/* =========================================================
 * POPUP
 * ========================================================= */
html.video-popup-open,
body.video-popup-open {
    overflow: hidden !important;
}

.video-popup {
    position: fixed;
    z-index: 2147483640;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 65px 85px 35px;
    background: rgba(0, 0, 0, 0.94);
    opacity: 0;
    visibility: hidden;
    transition:
        opacity 0.2s ease,
        visibility 0.2s ease;
}

.video-popup.is-visible {
    opacity: 1;
    visibility: visible;
}

.video-popup-dialog {
    position: relative;
    width: 100%;
    max-width: 1100px;
}

.video-popup-header {
    position: absolute;
    right: 60px;
    bottom: calc(100% + 14px);
    left: 0;
    display: flex;
    align-items: center;
    color: #fff;
}

.video-popup-title {
    min-width: 0;
    overflow: hidden;
    font-size: 17px;
    font-weight: 600;
    line-height: 24px;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.video-popup-counter {
    flex: 0 0 auto;
    margin-left: auto;
    padding-left: 15px;
    color: rgba(255, 255, 255, 0.75);
    font-size: 14px;
}

.video-popup-content {
    position: relative;
    width: 100%;
    overflow: hidden;
    padding-top: 56.25%;
    background: #000;
    box-shadow: 0 12px 55px rgba(0, 0, 0, 0.65);
}

.video-popup-content iframe,
.video-popup-content video {
    position: absolute;
    inset: 0;
    display: block;
    width: 100%;
    height: 100%;
    border: 0;
    background: #000;
    object-fit: contain;
}

.video-popup-close,
.video-popup-nav {
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(255, 255, 255, 0.65);
    background: rgba(0, 0, 0, 0.55);
    color: #fff;
    cursor: pointer;
}

.video-popup-close {
    position: absolute;
    z-index: 3;
    top: -50px;
    right: 0;
    width: 42px;
    height: 42px;
    padding: 0;
    border-radius: 50%;
    font-size: 30px;
    line-height: 1;
}

.video-popup-nav {
    position: fixed;
    z-index: 2147483645;
    top: 50%;
    width: 56px;
    height: 76px;
    padding: 0;
    border-radius: 4px;
    font-size: 34px;
    transform: translateY(-50%);
}

.video-popup-prev {
    left: 20px;
}

.video-popup-next {
    right: 20px;
}

.video-popup-close:hover,
.video-popup-nav:hover {
    border-color: #fff;
    background: var(--main-color, #ffb300);
    color: #111;
}

/* =========================================================
 * RESPONSIVE
 * ========================================================= */
@media (max-width: 991px) {
    .video_page_content {
        padding: 38px 0 55px;
    }

    .video_page_heading .Title_news {
        font-size: 30px;
        line-height: 40px;
    }
}

@media (max-width: 767px) {
    .video_breadcrumb_box {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .video_breadcrumb_box .breadcrumb {
        flex-wrap: nowrap;
        width: max-content;
        min-width: 100%;
        white-space: nowrap;
    }

    .video_page_content {
        padding: 28px 0 45px;
    }

    .video_page_heading {
        margin-bottom: 20px;
    }

    .video_page_heading .Title_news {
        font-size: 25px;
        line-height: 34px;
    }

    .video_total {
        padding: 4px 9px;
        font-size: 12px;
    }

    .video_grid_item {
        margin-bottom: 18px;
    }

    .video_card_body {
        min-height: 0;
        padding: 14px;
    }

    .video_card_title {
        font-size: 17px;
        line-height: 25px;
    }

    .video-popup {
        padding: 70px 8px 85px;
    }

    .video-popup-header {
        right: 50px;
        bottom: calc(100% + 10px);
    }

    .video-popup-title {
        font-size: 13px;
        line-height: 19px;
    }

    .video-popup-counter {
        padding-left: 8px;
        font-size: 12px;
    }

    .video-popup-nav {
        top: auto;
        bottom: 18px;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        font-size: 26px;
        transform: none;
    }

    .video-popup-prev {
        left: calc(50% - 60px);
    }

    .video-popup-next {
        right: calc(50% - 60px);
    }
}
</style>

<script type="text/javascript">
(function (window, document) {
    'use strict';

    function getYouTubeId(url) {
        if (!url) {
            return '';
        }

        var patterns = [
            /youtube\.com\/watch\?.*v=([a-zA-Z0-9_-]{6,})/i,
            /youtube\.com\/embed\/([a-zA-Z0-9_-]{6,})/i,
            /youtube\.com\/shorts\/([a-zA-Z0-9_-]{6,})/i,
            /youtube\.com\/live\/([a-zA-Z0-9_-]{6,})/i,
            /youtu\.be\/([a-zA-Z0-9_-]{6,})/i
        ];

        for (var i = 0; i < patterns.length; i++) {
            var match = String(url).match(patterns[i]);

            if (match && match[1]) {
                return match[1];
            }
        }

        return '';
    }

    function getVideoItems() {
        var cards = document.querySelectorAll('.video_card');
        var items = [];

        for (var i = 0; i < cards.length; i++) {
            var link = cards[i].querySelector('.js-page-video');

            if (!link) {
                continue;
            }

            items.push({
                card: cards[i],
                link: link,
                url:
                    link.getAttribute('data-video-url') ||
                    link.getAttribute('href') ||
                    '',
                type:
                    link.getAttribute('data-video-type') ||
                    '2',
                title:
                    link.getAttribute('title') ||
                    'Video'
            });
        }

        return items;
    }

    function closeVideoPopup() {
        var popup = document.getElementById(
            'video-page-popup'
        );

        if (popup && popup.parentNode) {
            popup.parentNode.removeChild(popup);
        }

        document.documentElement.classList.remove(
            'video-popup-open'
        );

        document.body.classList.remove(
            'video-popup-open'
        );
    }

    function showVideo(index) {
        var popup = document.getElementById(
            'video-page-popup'
        );

        var items = getVideoItems();

        if (!popup || !items.length) {
            closeVideoPopup();
            return;
        }

        if (index < 0) {
            index = items.length - 1;
        }

        if (index >= items.length) {
            index = 0;
        }

        var item = items[index];
        var youtubeId = getYouTubeId(item.url);

        var content = popup.querySelector(
            '.video-popup-content'
        );

        var title = popup.querySelector(
            '.video-popup-title'
        );

        var counter = popup.querySelector(
            '.video-popup-counter'
        );

        popup.setAttribute(
            'data-current-index',
            String(index)
        );

        while (content.firstChild) {
            content.removeChild(content.firstChild);
        }

        if (youtubeId) {
            var iframe = document.createElement('iframe');

            iframe.src =
                'https://www.youtube.com/embed/'
                + encodeURIComponent(youtubeId)
                + '?autoplay=1'
                + '&rel=0'
                + '&playsinline=1';

            iframe.title = item.title;

            iframe.setAttribute(
                'allowfullscreen',
                ''
            );

            iframe.setAttribute(
                'allow',
                'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share'
            );

            iframe.setAttribute(
                'referrerpolicy',
                'strict-origin-when-cross-origin'
            );

            content.appendChild(iframe);
        } else {
            var video = document.createElement('video');

            video.src = item.url;
            video.controls = true;
            video.autoplay = true;
            video.playsInline = true;

            content.appendChild(video);
        }

        title.textContent = item.title;

        counter.textContent =
            (index + 1) + ' / ' + items.length;
    }

    function changeVideo(step) {
        var popup = document.getElementById(
            'video-page-popup'
        );

        if (!popup) {
            return;
        }

        var currentIndex = parseInt(
            popup.getAttribute('data-current-index'),
            10
        );

        if (isNaN(currentIndex)) {
            currentIndex = 0;
        }

        showVideo(currentIndex + step);
    }

    function openVideoPopup(clickedLink) {
        var items = getVideoItems();
        var clickedCard = clickedLink.closest(
            '.video_card'
        );

        var currentIndex = 0;

        for (var i = 0; i < items.length; i++) {
            if (items[i].card === clickedCard) {
                currentIndex = i;
                break;
            }
        }

        closeVideoPopup();

        var popup = document.createElement('div');
        popup.id = 'video-page-popup';
        popup.className = 'video-popup';
        popup.setAttribute(
            'data-current-index',
            String(currentIndex)
        );

        var dialog = document.createElement('div');
        dialog.className = 'video-popup-dialog';

        var header = document.createElement('div');
        header.className = 'video-popup-header';

        var title = document.createElement('div');
        title.className = 'video-popup-title';

        var counter = document.createElement('div');
        counter.className = 'video-popup-counter';

        var close = document.createElement('button');
        close.type = 'button';
        close.className = 'video-popup-close';
        close.setAttribute('aria-label', 'Close');
        close.innerHTML = '&times;';

        var prev = document.createElement('button');
        prev.type = 'button';
        prev.className =
            'video-popup-nav video-popup-prev';
        prev.setAttribute(
            'aria-label',
            'Previous video'
        );
        prev.innerHTML = '&#10094;';

        var next = document.createElement('button');
        next.type = 'button';
        next.className =
            'video-popup-nav video-popup-next';
        next.setAttribute(
            'aria-label',
            'Next video'
        );
        next.innerHTML = '&#10095;';

        var content = document.createElement('div');
        content.className = 'video-popup-content';

        header.appendChild(title);
        header.appendChild(counter);

        dialog.appendChild(header);
        dialog.appendChild(close);
        dialog.appendChild(prev);
        dialog.appendChild(content);
        dialog.appendChild(next);
        popup.appendChild(dialog);

        document.body.appendChild(popup);

        document.documentElement.classList.add(
            'video-popup-open'
        );

        document.body.classList.add(
            'video-popup-open'
        );

        close.addEventListener(
            'click',
            closeVideoPopup
        );

        prev.addEventListener(
            'click',
            function (event) {
                event.preventDefault();
                event.stopPropagation();
                changeVideo(-1);
            }
        );

        next.addEventListener(
            'click',
            function (event) {
                event.preventDefault();
                event.stopPropagation();
                changeVideo(1);
            }
        );

        popup.addEventListener(
            'click',
            function (event) {
                if (event.target === popup) {
                    closeVideoPopup();
                }
            }
        );

        window.setTimeout(function () {
            popup.classList.add('is-visible');
            showVideo(currentIndex);
            close.focus();
        }, 10);
    }

    if (!window.videoPagePopupInitialized) {
        window.videoPagePopupInitialized = true;

        document.addEventListener(
            'click',
            function (event) {
                var target = event.target;

                var link =
                    target && target.closest
                        ? target.closest('.js-page-video')
                        : null;

                if (!link) {
                    return;
                }

                event.preventDefault();
                event.stopPropagation();

                if (
                    typeof event.stopImmediatePropagation ===
                    'function'
                ) {
                    event.stopImmediatePropagation();
                }

                openVideoPopup(link);
            },
            true
        );

        document.addEventListener(
            'keydown',
            function (event) {
                if (
                    !document.getElementById(
                        'video-page-popup'
                    )
                ) {
                    return;
                }

                if (
                    event.key === 'Escape' ||
                    event.keyCode === 27
                ) {
                    closeVideoPopup();
                } else if (
                    event.key === 'ArrowLeft' ||
                    event.keyCode === 37
                ) {
                    event.preventDefault();
                    changeVideo(-1);
                } else if (
                    event.key === 'ArrowRight' ||
                    event.keyCode === 39
                ) {
                    event.preventDefault();
                    changeVideo(1);
                }
            }
        );
    }

})(window, document);
</script>
{/literal}