<section class="section_box experience_video_box">
    <div class="container">
        <span class="video-section-heading__eyebrow">{$core->get_Lang('Experience Videos')}</span>
        <div class="home_title_box ">
            <h2 class="section_box-title">
                {$core->get_Lang('Your Journey Videos')}
            </h2>

            <a class="experience-video-view-all"
                href="{if $_LANG_ID eq 'vn'}{$DOMAIN_NAME}/vn/trai-nghiem-video{else}{$DOMAIN_NAME}/experience-video{/if}"
                title="{$core->get_Lang('View more')|escape:'html'}">
                {$core->get_Lang('View All Videos')}
            </a>
        </div>
    </div>

    <div class="section_content">
        <div class="container">
            <div id="video" data-lang="{if $_LANG_ID eq 'vn'}vn{else}en{/if}"></div>
        </div>
    </div>
</section>

{literal}
    <style>
        html.home-video-open,
        body.home-video-open {
            overflow: hidden !important;
        }

        .home-video-popup-header {
            position: absolute;
            z-index: 4;
            right: 65px;
            bottom: calc(100% + 14px);
            left: 0;
            display: flex;
            align-items: center;
            min-width: 0;
            color: #fff;
        }

        .home-video-popup-title {
            min-width: 0;
            overflow: hidden;
            font-size: var(--font-size-h4);
            font-weight: var(--font-weight-bold);
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .home-video-popup-counter {
            flex: 0 0 auto;
            margin-left: auto;
            padding-left: 15px;
            color: rgba(255, 255, 255, 0.75);
            font-size: var(--font-size-small);
        }

        .home-video-popup-nav {
            position: fixed !important;
            z-index: 2147483646 !important;
            top: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 58px !important;
            height: 78px !important;
            padding: 0 !important;
            border: 1px solid rgba(255, 255, 255, 0.65) !important;
            border-radius: 4px !important;
            background: rgba(0, 0, 0, 0.55) !important;
            color: #fff !important;
            font-family: Arial, sans-serif !important;
            font-size: 38px !important;
            line-height: 1 !important;
            cursor: pointer !important;
            opacity: 0.9;
            transform: translateY(-50%) !important;
            transition:
                background 0.2s ease,
                opacity 0.2s ease,
                transform 0.2s ease !important;
        }

        .home-video-popup-prev {
            left: 30px !important;
        }

        .home-video-popup-next {
            right: 30px !important;
        }



        .ic-play_video,
        .ic-play_video:hover,
        .ic-play_video:focus,
        .ic-play_video i,
        .ic-play_video i::before,
        .video_play_button,
        .video_play_button i,
        .video_play_button i::before {
            color: #fff !important;
        }

        .home-video-popup-nav:hover {
            border-color: #fff !important;
            background: var(--jacky-green) !important;
            color: #fff !important;
            opacity: 1;
        }

        .home-video-popup {
            position: fixed !important;
            z-index: 2147483640 !important;
            inset: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            height: 100% !important;
            padding: 60px 20px 30px !important;
            background: rgba(0, 0, 0, 0.92) !important;
            opacity: 0;
            visibility: hidden;
            transition:
                opacity 0.2s ease,
                visibility 0.2s ease;
        }

        /* Vòng tròn vàng, tam giác trắng */
        .ic-play_video,
        .video_play_button {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 0 !important;
            border: 0 !important;
            border-radius: 50% !important;
            background: var(--primary-18-babd, #18babd) !important;
            background-image: none !important;
            color: #fff !important;
            text-decoration: none !important;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.18);
        }

        .ic-play_video i,
        .ic-play_video i::before,
        .video_play_button i,
        .video_play_button i::before {
            margin: 0 !important;
            color: #fff !important;
            font-size: 20px !important;
            line-height: 1 !important;
        }

        /* Đẩy nhẹ tam giác sang phải để cân giữa */
        .ic-play_video i,
        .video_play_button i {
            transform: translateX(2px);
        }



        /* Nút nhỏ cột bên phải */
        .home-video-right .ic-play_video {
            width: 36px !important;
            height: 36px !important;
        }

        .home-video-right .ic-play_video i,
        .home-video-right .ic-play_video i::before {
            font-size: 13px !important;
        }

        /* Nút video lớn */
        .home-video-left .ic-play_video {
            width: 60px !important;
            height: 60px !important;
        }

        .home-video-left .ic-play_video i,
        .home-video-left .ic-play_video i::before {
            font-size: 21px !important;
        }

        .home-video-popup.is-visible {
            opacity: 1;
            visibility: visible;
        }

        .home-video-popup-dialog {
            position: relative !important;
            width: 100% !important;
            max-width: 1100px !important;
            margin: auto !important;
        }

        .home-video-popup-content {
            position: relative !important;
            width: 100% !important;
            padding-top: 56.25% !important;
            overflow: hidden !important;
            background: #000 !important;
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.6);
        }

        .home-video-popup-content iframe {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            display: block !important;
            width: 100% !important;
            height: 100% !important;
            border: 0 !important;
            background: #000 !important;
        }

        .home-video-popup-close {
            position: absolute !important;
            z-index: 2 !important;
            top: -48px !important;
            right: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 42px !important;
            height: 42px !important;
            padding: 0 !important;
            border: 1px solid rgba(255, 255, 255, 0.5) !important;
            border-radius: 50% !important;
            background: rgba(0, 0, 0, 0.7) !important;
            color: #fff !important;
            font-family: Arial, sans-serif !important;
            font-size: 32px !important;
            font-weight: 300 !important;
            line-height: 1 !important;
            cursor: pointer !important;
        }

        .home-video-popup-close:hover {
            border-color: #fff !important;
            background: #fff !important;
            color: #111 !important;
        }

        .home-video-popup-nav,
        .home-video-popup-nav:hover,
        .home-video-popup-nav:focus,
        .home-video-popup-nav span,
        .home-video-popup-nav:hover span {
            color: #fff !important;
        }

        .section_box.experience_video_box .home_title_box {
            margin-bottom: var(--title-space-bottom);
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 32px;
        }

        .home-video-right i {
            margin-right: 10px;
            color: var(--main-color) !important;
        }

        .experience_video_box .intro_box {
            margin-top: 20px;
        }

        .experience_video_box .intro_box p:last-child {
            margin-bottom: 0;
        }

        #video {
            width: 100%;
            margin: 0;
            padding: 0;
            border: 0;
        }

        .home-video-wrapper {
            display: grid;
            width: 100%;
            grid-template-columns: minmax(0, 2fr) minmax(320px, 1fr);
            gap: 20px;
        }

        .home-video-left,
        .home-video-right {
            min-width: 0;
        }

        .home-video-left .video-item {
            height: 100%;
        }

        .video-item {
            position: relative;
        }

        .video-item img {
            display: block;
            width: 100%;
            height: 100%;
            border-radius: var(--border-radius-button);
        }

        /* Nút play nằm giữa ảnh */
        .video-item .ic-play_video {
            position: absolute;
            z-index: 2;
            top: 50%;
            left: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            color: #fff;
            font-size: 50px;
            line-height: 1;
            text-decoration: none;
            transform: translate(-50%, -50%);
        }

        .home-video-right {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .home-video-right .video-item {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .video-item-mobile {
            display: none !important;
        }

        .home-video-right .video-item .photo {
            position: relative;
            display: block;
            flex: 0 0 200px;
            width: 200px;
            height: 123px;
            overflow: hidden;
            border-radius: var(--border-radius-button);
        }

        .home-video-right .video-item .photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .home-video-right .video-item .photo .ic-play_video {
            width: 32px;
            height: 32px;
            font-size: 30px;

        }

        .ic-play_video {
            cursor: pointer;
            color: var(--main-color) !important;
        }

        .home-video-right .video-item .body {
            flex: 1 1 auto;
            width: auto;
            min-width: 0;
        }

        #video .video-tabs-nav p.title {
            margin: 0 0 8px;
            font-size: var(--font-size-h4);
            font-weight: var(--font-weight-bold);
            letter-spacing: 0.02em;
            overflow-wrap: anywhere;
        }

        #video .video-tabs-nav .body .time {
            display: inline-block;
            margin-top: auto;
            vertical-align: middle;
        }

        #video .video-tabs-nav .body .time .ic-cald {
            vertical-align: middle;
        }

        .video-server-inline video {
            display: block;
            width: 100%;
            max-height: 85vh;
        }

        .experience-video-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }

        .experience-video-heading h2 {
            margin: 0;
        }

        .experience-video-view-all {
            min-height: 42px;
            padding: 0 14px;
            border: 1px solid var(--main-color) !important;
            border-radius: var(--border-radius-button);
            color: var(--main-color) !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            white-space: nowrap;
            text-decoration: none;
            transition:
                background-color 0.25s ease,
                color 0.25s ease,
                transform 0.25s ease;
        }

        .experience-video-view-all span {
            font-size: 22px;
            transition: transform 0.25s ease;
        }

        .experience-video-view-all:hover {
            background: var(--primary-18-babd, #18babd);
            border-color: var(--primary-18-babd, #18babd);
            color: #fff !important;
            text-decoration: none;
            transform: translateY(-1px);
        }

        .video-section-heading__eyebrow {
            color: #ec5a1f;
            font-size: 15px;
            font-weight: 450;
            letter-spacing: 0;
            text-transform: uppercase;
        }

        .experience-video-view-all:hover span {
            transform: translateX(4px);
        }


        @media (max-width: 991px) {
            .home-video-wrapper {
                grid-template-columns: 1fr;
            }

            .home-video-popup-prev {
                left: 10px !important;
            }

            .home-video-popup-next {
                right: 10px !important;
            }

            .home-video-left .video-item {
                min-height: 0;
                aspect-ratio: 3 / 2;
            }

            .home-video-right {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .experience_video_box .intro_box {
                font-size: 16px;
            }

            .home-video-right .video-item,
            .section_box.experience_video_box .home_title_box {
                display: block;
                margin-top: 10px;
            }

            .section_box .home_title_box {
                padding-top: 0;
            }

            .home-video-right .video-item .photo {
                width: 100%;
                height: auto;
                aspect-ratio: 200 / 123;
            }

            .section_box-title {
                font-size: 22px !important;
            }

            .home-video-right .video-item .body {
                width: 100%;
                padding-top: 10px;
            }
        }

        @media (max-width: 767px) {
            .home-video-popup {
                padding: 55px 10px 20px !important;
            }

            .experience-video-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 15px;
            }

            .experience-video-view-all {
                min-height: 40px;
                font-size: var(--font-size-small);
            }

            .home-video-popup-close {
                top: -45px !important;
                right: 0 !important;
            }

            .home-video-popup-header {
                right: 50px;
                bottom: calc(100% + 10px);
            }

            .home-video-popup-title {
                font-size: var(--font-size-small);
                line-height: 20px;
            }

            .home-video-popup-counter {
                font-size: 12px;
            }

            .home-video-popup-nav {
                top: auto !important;
                bottom: 16px !important;
                width: 48px !important;
                height: 48px !important;
                border-radius: 50% !important;
                font-size: 27px !important;
                transform: none !important;
            }

            .home-video-popup-prev {
                left: calc(50% - 60px) !important;
            }

            .home-video-popup-next {
                right: calc(50% - 60px) !important;
            }

            .home-video-wrapper {
                gap: 15px;
            }

            .home-video-right {
                display: block;
            }

            .home-video-right .video-item {
                display: flex;
                margin-bottom: 15px;
            }

            .home-video-right .video-item .photo {
                flex: 0 0 130px;
                width: 130px;
                height: 85px;
            }

            #video .video-tabs-nav p.title {
                font-size: 15px;
                line-height: 22px;
            }
        }
    </style>
    <script type="text/javascript">
        (function(window, document) {
            'use strict';

            var videoLoaded = false;
            var venoboxInstance = null;

            function waitForJQuery(callback) {
                var count = 0;
                var maxCount = 200;

                function check() {
                    if (
                        typeof window.jQuery === 'function' &&
                        window.jQuery.fn
                    ) {
                        callback(window.jQuery);
                        return;
                    }

                    count++;

                    if (count < maxCount) {
                        window.setTimeout(check, 50);
                    } else {
                        console.error('jQuery was not loaded');
                    }
                }

                check();
            }

            /*
         * Chuẩn hóa đường dẫn AJAX, tránh:
         * //index.php hoặc thiếu dấu /
         */
            function getAjaxUrl() {
                var ajaxPath = typeof window.path_ajax_script === 'string' ?
                    window.path_ajax_script :
                    '';

                var videoElement = document.getElementById('video');
                var langId = videoElement ?
                    videoElement.getAttribute('data-lang') :
                    'en';

                /*
             * isoCMS co the luu English bang lang_id rong.
             * Chi chap nhan vn; cac gia tri con lai deu gui en.
             */
                langId = langId === 'vn' ? 'vn' : 'en';

                ajaxPath = ajaxPath.replace(/\/+$/, '');

                return ajaxPath +
                    '/index.php?mod=homepackage' +
                    '&act=ajaxLoadVideoHome' +
                    '&lang=' +
                    encodeURIComponent(langId);
            }


            function initLazyLoad($) {
                var $images = $('#video img.iso_lazy_load');

                if (!$images.length) {
                    return;
                }

                if (typeof $.fn.lazy === 'function') {
                    $images.lazy({
                        bind: 'event',
                        delay: 0
                    });
                } else {
                    /*
                 * Fallback nếu plugin lazy chưa được tải.
                 */
                    $images.each(function() {
                        var image = this;
                        var dataSrc = image.getAttribute('data-src');

                        if (!image.getAttribute('src') && dataSrc) {
                            image.setAttribute('src', dataSrc);
                        }

                        image.style.opacity = '1';
                    });
                }
            }

            function initVideoContent($) {
                initLazyLoad($);

            }

            function loadVideoHome($) {
                if (videoLoaded) {
                    return;
                }

                videoLoaded = true;

                $.ajax({
                    type: 'GET',
                    url: getAjaxUrl(),
                    dataType: 'html',
                    cache: false,

                    success: function(html) {
                        html = typeof html === 'string' ?
                            $.trim(html) :
                            '';

                        if (!html) {
                            videoLoaded = false;
                            console.error('ajaxLoadVideoHome returned empty HTML');
                            return;
                        }

                        $('#video').html(html);

                        /*
                     * Chờ DOM của nội dung AJAX render xong.
                     */
                        window.setTimeout(function() {
                            initVideoContent($);
                        }, 50);
                    },

                    error: function(xhr, status, error) {
                        videoLoaded = false;

                        console.error(
                            'ajaxLoadVideoHome error:',
                            xhr.status,
                            status,
                            error,
                            xhr.responseText
                        );
                    }
                });
            }

            function getYouTubeId(url) {
                if (!url) {
                    return '';
                }

                url = String(url).trim();

                var patterns = [
                    /youtube\.com\/watch\?.*v=([a-zA-Z0-9_-]{6,})/i,
                    /youtube\.com\/embed\/([a-zA-Z0-9_-]{6,})/i,
                    /youtube\.com\/shorts\/([a-zA-Z0-9_-]{6,})/i,
                    /youtube\.com\/live\/([a-zA-Z0-9_-]{6,})/i,
                    /youtu\.be\/([a-zA-Z0-9_-]{6,})/i
                ];

                for (var i = 0; i < patterns.length; i++) {
                    var match = url.match(patterns[i]);

                    if (match && match[1]) {
                        return match[1];
                    }
                }

                return '';
            }

            /*
         * Lấy danh sách video trong #video và loại bỏ video trùng.
         * Video đầu tiên đang có ở cả khung lớn và danh sách nhỏ.
         */
            function getHomeVideoItems() {
                var links = document.querySelectorAll(
                    '#video .js-home-youtube'
                );

                var items = [];
                var videoIds = {};

                for (var i = 0; i < links.length; i++) {
                    var link = links[i];

                    var url =
                        link.getAttribute('data-video-url') ||
                        link.getAttribute('href') ||
                        '';

                    var videoId = getYouTubeId(url);

                    if (!videoId || videoIds[videoId]) {
                        continue;
                    }

                    videoIds[videoId] = true;

                    items.push({
                        id: videoId,
                        url: url,
                        title: link.getAttribute('title') || 'YouTube video'
                    });
                }

                return items;
            }

            function closeHomeVideoPopup() {
                var popup = document.getElementById('home-video-popup');

                if (popup && popup.parentNode) {
                    popup.parentNode.removeChild(popup);
                }

                document.documentElement.classList.remove('home-video-open');
                document.body.classList.remove('home-video-open');
            }

            /*
         * Cập nhật iframe và thông tin video
         * mà không cần đóng popup.
         */
            function showHomeVideoByIndex(index) {
                var popup = document.getElementById('home-video-popup');

                if (!popup) {
                    return;
                }

                var items = getHomeVideoItems();

                if (!items.length) {
                    closeHomeVideoPopup();
                    return;
                }

                /*
             * Cho phép quay vòng:
             * video đầu nhấn Prev -> video cuối
             * video cuối nhấn Next -> video đầu
             */
                if (index < 0) {
                    index = items.length - 1;
                }

                if (index >= items.length) {
                    index = 0;
                }

                var item = items[index];
                var iframe = popup.querySelector(
                    '.home-video-popup-content iframe'
                );
                var titleElement = popup.querySelector(
                    '.home-video-popup-title'
                );
                var counterElement = popup.querySelector(
                    '.home-video-popup-counter'
                );

                popup.setAttribute('data-current-index', String(index));

                if (iframe) {
                    /*
                 * Gán about:blank trước để dừng video cũ.
                 */
                    iframe.src = 'about:blank';

                    window.setTimeout(function() {
                        iframe.src =
                            'https://www.youtube.com/embed/' +
                            encodeURIComponent(item.id) +
                            '?autoplay=1' +
                            '&rel=0' +
                            '&playsinline=1' +
                            '&enablejsapi=1';
                    }, 30);

                    iframe.title = item.title;
                }

                if (titleElement) {
                    titleElement.textContent = item.title;
                }

                if (counterElement) {
                    counterElement.textContent =
                        (index + 1) + ' / ' + items.length;
                }

                /*
             * Chỉ có một video thì ẩn Prev/Next.
             */
                var navigationButtons = popup.querySelectorAll(
                    '.home-video-popup-nav'
                );

                for (var i = 0; i < navigationButtons.length; i++) {
                    navigationButtons[i].style.display =
                        items.length > 1 ? 'flex' : 'none';
                }
            }

            function changeHomeVideo(step) {
                var popup = document.getElementById('home-video-popup');

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

                showHomeVideoByIndex(currentIndex + step);
            }

            function openHomeVideoPopup(url, title) {
                closeHomeVideoPopup();

                var videoId = getYouTubeId(url);

                if (!videoId) {
                    console.error('Invalid YouTube URL:', url);
                    return;
                }

                var items = getHomeVideoItems();
                var currentIndex = 0;

                /*
             * Tìm vị trí video vừa click trong danh sách.
             */
                for (var i = 0; i < items.length; i++) {
                    if (items[i].id === videoId) {
                        currentIndex = i;
                        break;
                    }
                }

                var popup = document.createElement('div');
                popup.id = 'home-video-popup';
                popup.className = 'home-video-popup';
                popup.setAttribute('role', 'dialog');
                popup.setAttribute('aria-modal', 'true');
                popup.setAttribute('data-current-index', String(currentIndex));
                popup.setAttribute(
                    'aria-label',
                    title || 'YouTube video'
                );

                var dialog = document.createElement('div');
                dialog.className = 'home-video-popup-dialog';

                /*
             * Tiêu đề và số thứ tự.
             */
                var header = document.createElement('div');
                header.className = 'home-video-popup-header';

                var popupTitle = document.createElement('div');
                popupTitle.className = 'home-video-popup-title';

                var popupCounter = document.createElement('div');
                popupCounter.className = 'home-video-popup-counter';

                header.appendChild(popupTitle);
                header.appendChild(popupCounter);

                /*
             * Nút đóng.
             */
                var closeButton = document.createElement('button');
                closeButton.type = 'button';
                closeButton.className = 'home-video-popup-close';
                closeButton.setAttribute('aria-label', 'Close video');
                closeButton.innerHTML = '&times;';

                /*
             * Nút Previous.
             */
                var prevButton = document.createElement('button');
                prevButton.type = 'button';
                prevButton.className =
                    'home-video-popup-nav home-video-popup-prev';
                prevButton.setAttribute('aria-label', 'Previous video');
                prevButton.innerHTML =
                    '<span aria-hidden="true">&#10094;</span>';

                /*
             * Nút Next.
             */
                var nextButton = document.createElement('button');
                nextButton.type = 'button';
                nextButton.className =
                    'home-video-popup-nav home-video-popup-next';
                nextButton.setAttribute('aria-label', 'Next video');
                nextButton.innerHTML =
                    '<span aria-hidden="true">&#10095;</span>';

                /*
             * Khung iframe.
             */
                var videoBox = document.createElement('div');
                videoBox.className = 'home-video-popup-content';

                var iframe = document.createElement('iframe');
                iframe.src = 'about:blank';
                iframe.title = title || 'YouTube video';
                iframe.setAttribute('allowfullscreen', '');
                iframe.setAttribute(
                    'allow',
                    'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share'
                );
                iframe.setAttribute(
                    'referrerpolicy',
                    'strict-origin-when-cross-origin'
                );

                videoBox.appendChild(iframe);

                dialog.appendChild(header);
                dialog.appendChild(closeButton);
                dialog.appendChild(prevButton);
                dialog.appendChild(videoBox);
                dialog.appendChild(nextButton);
                popup.appendChild(dialog);
                document.body.appendChild(popup);

                document.documentElement.classList.add('home-video-open');
                document.body.classList.add('home-video-open');

                closeButton.addEventListener('click', function() {
                    closeHomeVideoPopup();
                });

                prevButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    changeHomeVideo(-1);
                });

                nextButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    changeHomeVideo(1);
                });

                popup.addEventListener('click', function(event) {
                    if (event.target === popup) {
                        closeHomeVideoPopup();
                    }
                });

                window.setTimeout(function() {
                    popup.classList.add('is-visible');
                    showHomeVideoByIndex(currentIndex);
                    closeButton.focus();
                }, 10);
            }

            /*
         * Chỉ đăng ký sự kiện một lần.
         */
            if (!window.homeVideoPopupInitialized) {
                window.homeVideoPopupInitialized = true;

                document.addEventListener(
                    'click',
                    function(event) {
                        var target = event.target;

                        if (!target) {
                            return;
                        }

                        var link = target.closest ?
                            target.closest('.js-home-youtube') :
                            null;

                        if (!link) {
                            return;
                        }

                        event.preventDefault();
                        event.stopPropagation();

                        if (
                            typeof event.stopImmediatePropagation === 'function'
                        ) {
                            event.stopImmediatePropagation();
                        }

                        var videoUrl =
                            link.getAttribute('data-video-url') ||
                            link.getAttribute('href') ||
                            '';

                        openHomeVideoPopup(
                            videoUrl,
                            link.getAttribute('title') || ''
                        );
                    },
                    true
                );

                /*
             * Điều khiển bằng bàn phím:
             * Escape: đóng
             * ArrowLeft: video trước
             * ArrowRight: video sau
             */
                document.addEventListener('keydown', function(event) {
                    var popup = document.getElementById(
                        'home-video-popup'
                    );

                    if (!popup) {
                        return;
                    }

                    if (
                        event.key === 'Escape' ||
                        event.keyCode === 27
                    ) {
                        closeHomeVideoPopup();
                        return;
                    }

                    if (
                        event.key === 'ArrowLeft' ||
                        event.keyCode === 37
                    ) {
                        event.preventDefault();
                        changeHomeVideo(-1);
                        return;
                    }

                    if (
                        event.key === 'ArrowRight' ||
                        event.keyCode === 39
                    ) {
                        event.preventDefault();
                        changeHomeVideo(1);
                    }
                });
            }
            waitForJQuery(function($) {
                var videoElement = document.getElementById('video');

                if (!videoElement) {
                    console.error('#video element was not found');
                    return;
                }

                /*
             * Load video khi section gần màn hình.
             */
                if ('IntersectionObserver' in window) {
                    var observer = new IntersectionObserver(
                        function(entries) {
                            for (var i = 0; i < entries.length; i++) {
                                if (entries[i].isIntersecting) {
                                    observer.disconnect();
                                    loadVideoHome($);
                                    break;
                                }
                            }
                        }, {
                            root: null,
                            rootMargin: '500px 0px',
                            threshold: 0
                        }
                    );

                    observer.observe(videoElement);
                } else {
                    loadVideoHome($);
                }
            });
        })(window, document);
    </script>
{/literal}