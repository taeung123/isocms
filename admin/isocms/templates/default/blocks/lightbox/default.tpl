<div
    class="iso-lightbox"
    id="{$lightbox_id}"
    style="display:none;"
>
    <div class="iso-lightbox-overlay"></div>
    <div class="iso-lightbox-dialog" data-size="{$lightbox_size}">
        <a class="iso-lightbox-cancel">
            &times;
        </a>
        <div class="iso-lightbox-body">
            {$lightbox_content}
        </div>
    </div>
</div>
{literal}
    <script>
        var Lightbox = {
            open: function(id) {

                var $lightbox = $('#' + id);

                if (!$lightbox.length) {
                    console.error('Lightbox #' + id + ' does not exist.');
                    return;
                }

                $lightbox.stop(true, true).fadeIn(200);

                $('body').addClass('lightbox-open');

            },
            close: function(lightbox) {

                var $lightbox;

                if (typeof lightbox === 'string') {

                    $lightbox = $('#' + lightbox);

                } else {

                    $lightbox = $(lightbox).closest('.iso-lightbox');

                }

                if (!$lightbox.length) {
                    return;
                }

                $lightbox.stop(true, true).fadeOut(200);

                $('body').removeClass('lightbox-open');

            }
        };

        $(document).on(
            'click',
            '.iso-lightbox-cancel, .iso-lightbox-overlay',
            function() {
                Lightbox.close(this);
            }
        );

        $(document).on('keydown', function(event) {
            if (event.key === 'Escape') {
                $('.iso-lightbox:visible').each(function() {
                    Lightbox.close(this);
                });
            }
        });
    </script>
    <style>
        .iso-lightbox {
            position: fixed;
            inset: 0;
            z-index: 99999;
        }

        .iso-lightbox-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
        }

        .iso-lightbox-dialog {
            position: relative;
            width: calc(100% - 30px);
            max-width: 700px;
            max-height: calc(100vh - 60px);

            margin: 30px auto;

            background: #fff;
            border-radius: 8px;

            overflow: hidden;

            z-index: 2;

            display: flex;
            flex-direction: column;
        }

        .iso-lightbox-body {
            padding: 20px;
            overflow-y: auto;
        }

        .iso-lightbox-cancel {
            position: absolute;
            top: 10px;
            right: 15px;
            width: 32px;
            height: 32px;
            border: 0;
            background: transparent;
            font-size: 28px;
            line-height: 32px;
            cursor: pointer;
            z-index: 10;
        }

        body.lightbox-open {
            overflow: hidden;
        }

        .iso-lightbox-dialog[data-size="sm"] {
            max-width: 400px;
        }

        .iso-lightbox-dialog[data-size="md"] {
            max-width: 600px;
        }

        .iso-lightbox-dialog[data-size="lg"] {
            max-width: 900px;
        }

        .iso-lightbox-dialog[data-size="xl"] {
            max-width: 1200px;
        }

        .iso-lightbox-dialog[data-size="full"] {
            width: calc(100% - 30px);
            max-width: none;
            height: calc(100vh - 30px);
            max-height: none;
        }
    </style>
{/literal}