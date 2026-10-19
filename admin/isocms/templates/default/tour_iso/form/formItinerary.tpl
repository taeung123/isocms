<div class="tm-modal">
    <div class="tm-modal__header headPop">

        <span class="tm-modal__icon" aria-hidden="true"><i class="fa-solid fa-calendar-plus"></i></span>
        <div class="tm-modal__titles">
            <h2 id="addItineraryModalTitle">
                {if $tour_itinerary_id == 0}
                    {$core->get_Lang('Add Tour Itinerary')}
                {else}
                    {$core->get_Lang('Edit Tour Itinerary')} - [ID #{$tour_id}]
                {/if}
            </h2>
            <p>{$core->get_Lang('Create the next day of your tour itinerary') }</p>
        </div>
        <a class="tm-modal__close close_pop" href="javascript:void();" id="btnCloseAddItineraryModal"
            aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
        </a>
    </div>

    <div class="tm-modal__body">
        <form method="post" id="frmItinerary" class="frmform formborder" enctype="multipart/form-data">
            <div class="tm-modal__grid">
                <div class="tm-modal__grid-left">

                    <div class="tm-form-row">
                        <span class="tm-form-row__icon" aria-hidden="true"><i class="fa-regular fa-calendar"></i></span>
                        <div class="tm-form-row__main">
                            <label class="tm-form-row__label">{$core->get_Lang('Day') } <span
                                    class="required">*</span></label>
                            <div class="tm-day-range">
                                <div class="tm-stepper">
                                   <input
                                        type="number"
                                        id="dayFrom"
                                        value="{$itinerary_day}"
                                        min="{$itinerary_day}"
                                        max="{$max_day}"
                                        aria-label="Start day"
                                        name="day"
                                        required>
                                    <span class="tm-stepper__arrows">
                                        <button type="button" data-step-target="dayFrom" data-step-dir="1"
                                            aria-label="Increase start day"><i
                                                class="fa-solid fa-chevron-up"></i></button>
                                        <button type="button" data-step-target="dayFrom" data-step-dir="-1"
                                            aria-label="Decrease start day"><i
                                                class="fa-solid fa-chevron-down"></i></button>
                                    </span>
                                </div>
                                <span class="tm-day-range__sep"><i class="fa-solid fa-arrow-right"></i></span>
                                <div class="tm-stepper">
                                    <input
                                        type="number"
                                        id="dayTo"
                                        value="{$itinerary_day2}"
                                        min="{$itinerary_day2}"
                                        max="{$max_day}"
                                        aria-label="End day"
                                        name="day2"
                                        required>
                                    <span class="tm-stepper__arrows">
                                        <button type="button" data-step-target="dayTo" data-step-dir="1"
                                            aria-label="Increase end day"><i
                                                class="fa-solid fa-chevron-up"></i></button>
                                        <button type="button" data-step-target="dayTo" data-step-dir="-1"
                                            aria-label="Decrease end day"><i
                                                class="fa-solid fa-chevron-down"></i></button>
                                    </span>
                                </div>
                            </div>
                            <p class="tm-form-row__hint">
                                {$core->get_Lang('Select the day or range of days for this itinerary item') }</p>
                        </div>
                    </div>

                    <div class="tm-form-row">
                        <span class="tm-form-row__icon" aria-hidden="true"><i class="fa-solid fa-t"></i></span>
                        <div class="tm-form-row__main">
                            <label class="tm-form-row__label" for="title">{$core->get_Lang('Title') } <span
                                    class="required">*</span></label>
                            <input type="text" id="title" class="tm-input" name="title"
                                value="{$oneItem.title|default:''}"
                                required>
                        </div>
                    </div>
                    {if !empty($lstMeal)}
                        <div class="tm-form-row">
                            <span class="tm-form-row__icon" aria-hidden="true"><i class="fa-solid fa-utensils"></i></span>
                            <div class="tm-form-row__main">
                                <label class="tm-form-row__label">
                                    {$core->get_Lang('Meal') }<span class="required">*</span>
                                </label>
                                <div class="tm-pill-options">
                                    {foreach from=$lstMeal key=key item=item}
                                        <label
                                            class="tm-pill-check {if $clsTourItinerary->checkMealExist($item[$clsTourProperty->pkey], $tour_itinerary_id)}is-checked{/if}">
                                            <input type="checkbox" name="meal[]" value="{$item.tour_property_id}" group="meal"
                                                class="chk_Meal checkitem_checkbox"
                                                {if $clsTourItinerary->checkMealExist($item[$clsTourProperty->pkey], $tour_itinerary_id)}checked{/if}>
                                            <span class="tm-pill-check__box">
                                                <i class="fa-solid fa-check"></i>
                                            </span>
                                            {$item.title}
                                        </label>
                                    {/foreach}
                                </div>
                            </div>
                        </div>
                    {/if}
                    {if $clsISO->getCheckActiveModulePackage($package_id, 'property', 'transport', 'default')}
                        {if !empty($lstTransport)}
                            <div class="tm-form-row">
                                <span class="tm-form-row__icon" aria-hidden="true">
                                    <i class="fa-solid fa-bus"></i>
                                </span>
                                <div class="tm-form-row__main">
                                    <label class="tm-form-row__label">Transport <span class="required">*</span></label>
                                    <div class="tm-pill-options">
                                        {foreach from=$lstTransport key=key item=item}
                                            <label
                                                class="tm-pill-check {if $tour_itinerary_id > 0 && $clsTourItinerary->checkTransportExist($item.transport_id, $tour_itinerary_id)}is-checked{/if}">
                                                <input type="checkbox" name="transport[]" group="transport"
                                                    value="{$item.transport_id}" class="checkitem_checkbox chk_Transport"
                                                    {if $tour_itinerary_id > 0 && $clsTourItinerary->checkTransportExist($item.transport_id, $tour_itinerary_id)}checked{/if}>
                                                <span class="tm-pill-check__box">
                                                    <i class="fa-solid fa-check"></i>
                                                </span>
                                                {$item.title}
                                            </label>
                                        {/foreach}
                                    </div>
                                </div>
                            </div>
                        {/if}
                    {/if}

                    <div class="tm-form-row">
                        <span class="tm-form-row__icon" aria-hidden="true"><i
                                class="fa-regular fa-file-lines"></i></span>
                        <div class="tm-form-row__main">
                            <label class="tm-form-row__label">{$core->get_Lang('Short text') }</label>
                            <textarea rows="5" cols="255" id="textarea_itinerary_content_editor_{$now}"
                                class="textarea_itinerary_content_editor" style="width:100%">
                                {$oneItem.content}
                            </textarea>
                        </div>
                    </div>

                </div>

                <!-- RIGHT: image upload -->
                <div class="tm-modal__grid-right">
                    <div class="tm-image-panel">
                        <div class="tm-image-panel__header">
                            <span class="tm-image-panel__icon" aria-hidden="true"><i
                                    class="fa-regular fa-image"></i></span>
                            <div>
                                <h3>{$core->get_Lang('Image')}</h3>
                                <p>{$core->get_Lang('Upload a representative image for this day (optional)')}</p>
                            </div>
                        </div>

                        <div class="tm-dropzone" id="imageDropzone">
                            <span class="tm-dropzone__icon" aria-hidden="true"><i
                                    class="fa-solid fa-cloud-arrow-up"></i></span>
                            {* <span class="tm-dropzone__title">{$core->get_Lang('Drag &amp; drop an image here')}</span> *}
                            {* <span class="tm-dropzone__or">{$core->get_Lang('or')}</span>
                            <label class="tm-btn tm-btn--upload">
                                <i class="fa-solid fa-upload"></i> {$core->get_Lang('Upload image')}
                                <input type="file" id="dayImageInput" accept="image/png,image/jpeg,image/webp"
                                    class="visually-hidden">
                            </label> *}
                            <a href="javascript:void(0);" title="{$core->get_Lang('Change')}"
                                class="tm-btn tm-btn--upload ajOpenDialog" isoman_for_id="image_itinerary"
                                isoman_val="{$oneItem.image|default:''}" isoman_name="image" id="btnFromLibrary">
                                <i class="fa-solid fa-upload"></i></i>
                                {$core->get_Lang('Upload Image')}
                            </a>
                            <span
                                class="tm-dropzone__caption">{$core->get_Lang('JPG, PNG, WEBP (Max 5MB)')}<br>{$core->get_Lang('Recommended size: 204 x 134 pixels')}</span>
                        </div>
                        <div class="tm-image-preview-container">
                            <div class="tm-image-preview photobox image" id="dayImagePreview">
                                <img src="{$oneItem.image|default:''}" alt="Day image preview"
                                    id="isoman_show_image_itinerary">

                                <input type="hidden" id="isoman_hidden_image_itinerary" name="isoman_url_image"
                                    value="{$oneItem.image|default:''}" />

                                <a pvalTable="{$tour_itinerary_id}" clsTable="TourItinerary" href="javascript:void(0)"
                                    title="{$core->get_Lang('delete')}" class="tm-image-preview__remove deleteItemImage"
                                    data-name_input="isoman_url_image" g="imgItem" id="btnRemoveDayImage"
                                    aria-label="Remove uploaded image">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            </div>
                            <div class="tm-image-toggle-row">
                                <span>{$core->get_Lang('Display image on the itinerary')}</span>
                                <label class="tm-toggle">
                                    <span class="visually-hidden">
                                        {$core->get_Lang('Toggle display image on itinerary')}
                                    </span>
                                    <input type="hidden" name="is_show_image" value="0">
                                    <input type="checkbox" id="toggleDisplayImage" name="is_show_image" value="1"
                                        {if isset($oneItem['is_show_image']) && $oneItem['is_show_image'] == 1}checked{/if}>
                                    <span class="tm-toggle-slider"></span>
                                </label>
                            </div>
                            <div class="tm-image-note">
                                <i class="fa-solid fa-circle-info"></i>
                                <span>{$core->get_Lang('This image will be shown in the itinerary list to make your tour more attractive.')}</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- ACCOMMODATION (full width) -->
            {if $clsISO->getCheckActiveModulePackage($package_id, 'tour', 'hotel', 'customize') && $clsISO->getCheckActiveModulePackage($package_id, 'hotel', 'default', 'default')}
                <div class="tm-accommodation">
                    <div class="tm-form-row" style="margin-bottom:0;">
                        <span class="tm-form-row__icon" aria-hidden="true"><i class="fa-solid fa-bed"></i></span>
                        <div class="tm-form-row__main">
                            <label class="tm-form-row__label">
                                
                                <a href="javascript:void(0);" tour_id="{$tour_id}" tour_itinerary_id="{$tour_itinerary_id}"
                                    tour_hotel_id="0" class="ajaxOpenChoiceHotel">
                                    {$core->get_Lang('Accommodation')}
                                    <i class="fa-solid fa-circle-plus"></i>
                                    </a>
                            </label>
                            <div class="tm-accommodation__fields">
                                {assign var=listHotelItinerary value=$clsTourItinerary->getListItineraryHotel($tour_id, $tour_itinerary_id)}
                                <div class="tm-tag-select" id="lstHotel">
                                    {* {if !empty($listHotelItinerary)}


                                        {foreach from=$listHotelItinerary item=hotel}
                                                                    <span class="tm-tag-chip" data-hotel="{$hotel.title}">{$hotel.title}
                                                                        <button type="button" aria-label="Remove" tour_itinerary_id="{$tour_itinerary_id}"
                                                                            hotel-id="{$hotel.hotel_id}">
                                                                            <i class="fa-solid fa-xmark"></i>
                                                                        </button>
                                                                    </span>


                                        {/foreach}
                                                        <i class="fa-solid fa-chevron-down"></i>


                                    {/if} *}
                                </div>
                            </div>
                            <p class="tm-form-row__hint">
                                {$core->get_Lang('Select one or more accommodations for this day.')}</p>
                        </div>
                    </div>
                </div>

            {/if}

        </form>
    </div>

    <div class="tm-modal__footer">
        <button type="button" class="tm-btn tm-btn--modal-close close_pop" id="btnCloseAddItinerary">
            {$core->get_Lang('Close')}
        </button>
        <button type="submit" tour_itinerary_id="{$tour_itinerary_id}"
            class="tm-btn tm-btn--modal-save btnSaveTourItinerary">
            <i class="fa-solid fa-check"></i>
            {$core->get_Lang('Save')}
        </button>
    </div>
</div>
{literal}
    <script>
        $(function() {

            var $dropzone = $('#imageDropzone');
            var $input = $('#dayImageInput');
            var $preview = $('#dayImagePreview');
            var $img = $('#isoman_show_image_itinerary');
            var $hidden = $('#isoman_hidden_image_itinerary');

            // Click chọn file
            $input.on('change', function() {
                if (this.files && this.files.length) {
                    handleImage(this.files[0]);
                }
            });

            // Drag over
            $dropzone.on('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();

                $(this).addClass('is-dragover');
            });

            // Drag leave
            $dropzone.on('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();

                $(this).removeClass('is-dragover');
            });

            // Drop
            $dropzone.on('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();

                $(this).removeClass('is-dragover');

                var files = e.originalEvent.dataTransfer.files;

                if (files && files.length) {
                    handleImage(files[0]);
                }
            });

            // Xử lý ảnh
            function handleImage(file) {
                var allowedTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/webp'
                ];
                if ($.inArray(file.type, allowedTypes) === -1) {
                    alert('Please select a JPG, PNG or WEBP image.');
                    return;
                }
                var maxSize = 5 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert('Image size must not exceed 5MB.');
                    return;
                }
                var imageUrl = URL.createObjectURL(file);
                // Preview ảnh
                $img.attr('src', imageUrl);
                // Hidden input
                $hidden.val(imageUrl);
                // Hiện khung preview
                $('.tm-image-preview-container').show();
                // Ẩn khung dropzone
                $('.tm-dropzone').hide();
                // Bật display image
                $('#toggleDisplayImage').prop('checked', true);
            }
            // // Remove image
            // $('#btnRemoveDayImage').on('click', function(e) {
            //     e.preventDefault();
            //     $img.attr('src', '');
            //     $hidden.val('');
            //     $input.val('');
            //     // Ẩn khung preview
            //     $('.tm-image-preview-container').hide();

            //     $('#toggleDisplayImage').prop('checked', false);
            // });

            $(document).on('click', '#btnFromLibrary', function() {
                $('.tm-image-preview-container').show();
            });

            $(document).on(
                'click',
                '#isoman-insert-image_itinerary, .close_pop',
                function() {

                    setTimeout(function() {

                        var imageUrl = $('#isoman_hidden_image_itinerary').val();

                        if (!imageUrl) {
                            $('.tm-image-preview-container').hide();
                            $('#isoman_show_image_itinerary').attr('src', '');
                        } else {
                            $('.tm-dropzone').hide();
                        }

                    }, 100);
                }
            );

        });
    </script>
    <script>
        $(function() {
            document.querySelectorAll('.tm-pill-check').forEach(function(pill) {
                var input = pill.querySelector('input');
                input.addEventListener('change', function() {
                    pill.classList.toggle('is-checked', input
                        .checked);
                });
            });
            // day range stepper
            // Day range stepper
            document.querySelectorAll('.tm-stepper__arrows button').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var input = document.getElementById(btn.getAttribute('data-step-target'));
                    var dir = parseInt(btn.getAttribute('data-step-dir'), 10);

                    if (!input) return;

                    var min = parseInt(input.getAttribute('min'), 10);
                    var max = parseInt(input.getAttribute('max'), 10);
                    var val = parseInt(input.value, 10);

                    if (isNaN(val)) {
                        val = min;
                    }

                    val += dir;

                    // Không cho vượt min / max
                    val = Math.max(min, Math.min(max, val));

                    input.value = val;

                    // Trigger change nếu có code khác đang lắng nghe
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                });
            });


            // Không cho nhập số ngoài min / max
            document.querySelectorAll('.tm-day-range input[type="number"]').forEach(function(input) {

                function validateDay() {
                    var min = parseInt(input.getAttribute('min'), 10);
                    var max = parseInt(input.getAttribute('max'), 10);
                    var val = parseInt(input.value, 10);

                    if (isNaN(val)) {
                        input.value = min;
                        return;
                    }

                    // Ép giá trị nằm trong khoảng min -> max
                    if (val < min) {
                        input.value = min;
                    } else if (val > max) {
                        input.value = max;
                    }
                }

                // Khi nhập trực tiếp
                input.addEventListener('input', function() {
                    var min = parseInt(input.getAttribute('min'), 10);
                    var max = parseInt(input.getAttribute('max'), 10);
                    var val = parseInt(input.value, 10);

                    if (!isNaN(val)) {
                        if (val < min) {
                            input.value = min;
                        } else if (val > max) {
                            input.value = max;
                        }
                    }
                });

                // Khi blur / rời khỏi input
                input.addEventListener('blur', validateDay);

                // Khi nhấn Enter
                input.addEventListener('change', validateDay);
            });


            $(function() {

                var $search = $('#accommodationSearch');
                var $input = $('#accommodationSearchInput');
                var $dropdown = $('#accommodationDropdown');
                var $tagSelect = $('#accommodationTagSelect');

                var isOpen = false;


                /* =========================================================
             * OPEN / CLOSE DROPDOWN
             * ========================================================= */

                function openAccommodationDropdown() {

                    if (isOpen) {
                        return;
                    }

                    isOpen = true;

                    $search.addClass('is-open');

                    filterAccommodation(
                        $.trim($input.val()).toLowerCase()
                    );

                    updateSelectedOptions();

                    setTimeout(function() {
                        updateDropdownPosition();
                    }, 0);
                }



                /* =========================================================
             * CLOSE
             * ========================================================= */

                function closeAccommodationDropdown() {

                    if (!isOpen) {
                        return;
                    }

                    isOpen = false;

                    $search.removeClass('is-open');
                }


                function toggleAccommodationDropdown() {

                    if (isOpen) {
                        closeAccommodationDropdown();
                    } else {
                        openAccommodationDropdown();
                        $input.focus();
                    }
                }


                /* =========================================================
             * CLICK INPUT
             * ========================================================= */

                $input.on('click', function(e) {

                    e.stopPropagation();

                    if (isOpen) {
                        closeAccommodationDropdown();
                    } else {
                        openAccommodationDropdown();
                    }
                });


                /* =========================================================
             * SEARCH
             * ========================================================= */

                $input.on('input', function() {

                    var keyword = $.trim($(this).val()).toLowerCase();

                    if (!isOpen) {
                        openAccommodationDropdown();
                    }

                    filterAccommodation(keyword);

                    updateSelectedOptions();
                });


                /* =========================================================
             * CLICK CHEVRON
             * ========================================================= */

                $search.find('.fa-chevron-down').on('click', function(e) {

                    e.preventDefault();
                    e.stopPropagation();

                    toggleAccommodationDropdown();
                });


                /* =========================================================
             * CLICK TAG SELECT AREA
             * ========================================================= */

                $tagSelect.on('click', function(e) {

                    /*
                 * Nếu click nút X thì không toggle dropdown.
                 */
                    if ($(e.target).closest('button').length) {
                        return;
                    }

                    e.preventDefault();
                    e.stopPropagation();

                    toggleAccommodationDropdown();
                });


                /* =========================================================
             * SELECT ACCOMMODATION
             * ========================================================= */

                $(document).on(
                    'click',
                    '.tm-accommodation-option',
                    function(e) {

                        e.preventDefault();
                        e.stopPropagation();

                        var $option = $(this);


                        /*
                     * Hotel đã được chọn rồi
                     */
                        if ($option.hasClass('is-selected')) {
                            return;
                        }


                        var hotelId = $option.attr('data-id');
                        var hotelName = $option.attr('data-name');


                        /*
                     * Tạo tag
                     */
                        var $tag = $('<span>', {
                            'class': 'tm-tag-chip',
                            'data-hotel': hotelName
                        });


                        $tag.append(
                            document.createTextNode(hotelName + ' ')
                        );


                        /*
                     * Button remove
                     */
                        var $remove = $('<button>', {
                            'type': 'button',
                            'aria-label': 'Remove',
                            'tour_itinerary_id': '6264',
                            'hotel-id': hotelId
                        });


                        $remove.append(
                            $('<i>', {
                                'class': 'fa-solid fa-xmark'
                            })
                        );


                        $tag.append($remove);


                        /*
                     * Thêm tag trước chevron
                     */
                        $tagSelect
                            .find('.fa-chevron-down')
                            .first()
                            .before($tag);


                        /*
                     * Clear search
                     */
                        $input.val('');


                        /*
                     * Update trạng thái selected
                     */
                        updateSelectedOptions();


                        /*
                     * Sau khi chọn vẫn giữ dropdown mở
                     */
                        openAccommodationDropdown();

                        $input.focus();

                        filterAccommodation('');
                    }
                );


                /* =========================================================
             * REMOVE ACCOMMODATION
             * ========================================================= */

                $(document).on(
                    'click',
                    '#accommodationTagSelect button[aria-label="Remove"]',
                    function(e) {

                        e.preventDefault();
                        e.stopPropagation();

                        /*
                     * Xóa tag
                     */
                        $(this)
                            .closest('.tm-tag-chip')
                            .remove();


                        /*
                     * Update selected
                     */
                        updateSelectedOptions();


                        /*
                     * Nếu dropdown đang mở thì refresh danh sách
                     */
                        if (isOpen) {

                            filterAccommodation(
                                $.trim($input.val()).toLowerCase()
                            );
                        }
                    }
                );


                /* =========================================================
             * CLICK OUTSIDE
             * ========================================================= */

                $(document).on('click', function(e) {

                    /*
                 * Click bên trong search hoặc tag select
                 * thì không đóng.
                 */
                    if (
                        $(e.target).closest('#accommodationSearch').length ||
                        $(e.target).closest('#accommodationTagSelect').length
                    ) {
                        return;
                    }


                    closeAccommodationDropdown();
                });


                /* =========================================================
             * FILTER ACCOMMODATION
             * ========================================================= */

                function filterAccommodation(keyword) {

                    keyword = $.trim(keyword).toLowerCase();


                    $('.tm-accommodation-option').each(function() {
                        var $option = $(this);
                        var name = String(
                            $option.attr('data-name') || ''
                        ).toLowerCase();
                        if (
                            keyword === '' ||
                            name.indexOf(keyword) !== -1
                        ) {

                            $option.removeClass('is-hidden');
                        } else {
                            $option.addClass('is-hidden');
                        }
                    });
                }
                /* =========================================================
             * UPDATE SELECTED OPTIONS
             * ========================================================= */
                function updateSelectedOptions() {
                    var selected = {};

                    /*
                 * Lấy tất cả hotel đang có trong tag
                 */
                    $tagSelect.find('.tm-tag-chip').each(function() {
                        var hotelId = $(this)
                            .find('button[hotel-id]')
                            .attr('hotel-id');
                        if (hotelId) {
                            selected[String(hotelId)] = true;
                        }
                    });

                    /*
                 * Update danh sách option
                 */
                    $('.tm-accommodation-option').each(function() {
                        var $option = $(this);
                        var hotelId = String(
                            $option.attr('data-id')
                        );
                        if (selected[hotelId]) {
                            $option.addClass('is-selected');
                        } else {
                            $option.removeClass('is-selected');
                        }
                    });
                }

                /* =========================================================
             * INIT
             * ========================================================= */
                updateSelectedOptions();

                function updateDropdownPosition() {

                    var $dropdown = $('#accommodationDropdown');
                    var $search = $('#accommodationSearch');

                    if (!$search.length || !$dropdown.length) {
                        return;
                    }

                    /*
                 * Reset trước để lấy đúng kích thước
                 */
                    $search.removeClass('is-up');

                    var searchRect = $search[0].getBoundingClientRect();

                    var viewportHeight = window.innerHeight;

                    var spaceTop = searchRect.top;
                    var spaceBottom = viewportHeight - searchRect.bottom;

                    var dropdownHeight = Math.min(
                        $dropdown[0].scrollHeight,
                        250
                    );

                    /*
                 * Nếu phía dưới không đủ chỗ
                 * và phía trên có nhiều chỗ hơn
                 * => mở lên trên
                 */
                    if (
                        spaceBottom < dropdownHeight &&
                        spaceTop > spaceBottom
                    ) {
                        $search.addClass('is-up');
                    }
                }

                $(window).on('resize scroll', function() {
                    if (isOpen) {
                        updateDropdownPosition();
                    }
                });
                $(document).on('click', '#btnRemoveDayImage', function(e) {
                    e.preventDefault();
                    console.log('Remove day image button clicked');
                    // Xóa ảnh preview
                    $('#isoman_show_image_itinerary').attr('src', '');

                    // Xóa hidden input
                    $('#isoman_hidden_image_itinerary').val('');

                    // Reset file input
                    $('#dayImageInput').val('');

                    // Ẩn khung preview
                    $('.tm-image-preview-container').hide();

                    // Hiện lại khung upload
                    $('#imageDropzone').show();

                    // Tắt display image
                    $('#toggleDisplayImage').prop('checked', false);
                });

            });

        });
        $(function() {
            var imageUrl = $.trim($('#isoman_hidden_image_itinerary').val());
            if (imageUrl !== '') {
                // Có ảnh
                $('#isoman_show_image_itinerary').attr('src', imageUrl);
                $('.tm-image-preview-container').show();
                $('#imageDropzone').hide();
            } else {
                // Chưa có ảnh
                $('#isoman_show_image_itinerary').attr('src', '');
                $('.tm-image-preview-container').hide();
                $('#imageDropzone').show();
            }
        });
    </script>
{/literal}
{literal}
    <style>
        .tm-accommodation-search {
            position: relative;
        }

        .tm-accommodation-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 9999;

            max-height: 250px;
            overflow-y: auto;

            background: #fff;
            border: 1px solid #ddd;
            border-radius: 0 0 6px 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .12);
        }

        .tm-accommodation-search.is-open .tm-accommodation-dropdown {
            display: block;
        }

        .tm-accommodation-option {
            padding: 10px 14px;
            cursor: pointer;
            font-size: 14px;
        }

        .tm-accommodation-option:hover {
            background: #f5f5f5;
        }

        .tm-accommodation-option.is-selected {
            background: #f0f0f0;
            color: #999;
            cursor: default;
        }

        .tm-accommodation-option.is-hidden {
            display: none;
        }

        .tm-accommodation-search {
            position: relative;
        }

        .tm-accommodation-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 9999;

            background: #fff;
            border: 1px solid #ddd;
            border-radius: 0 0 6px 6px;

            max-height: 250px;
            overflow-y: auto;
        }

        .tm-accommodation-search.is-open .tm-accommodation-dropdown {
            display: block;
        }


        /* Dropdown mở lên trên */
        .tm-accommodation-search.is-up .tm-accommodation-dropdown {
            top: auto;
            bottom: 100%;

            border-radius: 6px 6px 0 0;
            border-bottom: 0;
        }


        /* Option */

        .tm-accommodation-option {
            padding: 10px 14px;
            cursor: pointer;
        }

        .tm-accommodation-option:hover {
            background: #f5f5f5;
        }

        .tm-accommodation-option.is-selected {
            color: #999;
            background: #f5f5f5;
            cursor: default;
        }

        .tm-accommodation-option.is-hidden {
            display: none;
        }

        #SiteFrmTourItinerary {
            background-color: transparent;
            border: none;
        }

        .tm-modal {
            width: 100%;
            max-height: min(92vh, 900px);
            background: var(--color-surface);
            border-radius: 20px;
            box-shadow: 0 24px 64px rgba(15, 23, 42, 0.28);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .tm-modal__header {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 22px 24px 18px;
            border-bottom: 1px solid var(--color-border-light);
            flex-shrink: 0;
            background: transparent;
            position: relative;
            top: auto;
            left: auto;
            line-height: inherit;
            width: auto;
            height: auto;
        }

        .tm-modal__icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--color-primary-soft);
            color: var(--color-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .tm-modal__titles {
            flex: 1;
            min-width: 0;
        }

        .tm-modal__titles h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: var(--color-text);
        }

        .tm-modal__titles p {
            margin: 4px 0 0;
            font-size: 12.5px;
            color: var(--color-text-secondary);
        }

        .tm-modal__close {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            border: none;
            background: var(--color-page);
            color: var(--color-text-secondary);
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .tm-modal__close:hover {
            background: var(--color-border-light);
            color: var(--color-text);
        }

        .tm-modal__body {
            flex: 1;
            overflow-y: auto;
            padding: 20px 24px;
        }

        .tm-modal__grid {
            display: grid;
            grid-template-columns: 1.6fr 1fr;
            gap: 22px;
            align-items: start;
        }

        .tm-form-row {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }

        .tm-form-row:last-child {
            margin-bottom: 0;
        }

        .tm-form-row__icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: var(--color-primary-soft);
            color: var(--color-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .tm-form-row__main {
            flex: 1;
            min-width: 0;
        }

        .tm-form-row__label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--color-text);
            margin-bottom: 8px;
        }

        .tm-form-row__label .required {
            color: var(--color-danger);
        }

        .tm-form-row__hint {
            margin: 6px 0 0;
            font-size: 12px;
            color: var(--color-text-secondary);
        }

        /* day range stepper */
        .tm-day-range {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .tm-stepper {
            display: flex;
            align-items: center;
            height: 42px;
            border: 1px solid var(--color-border);
            border-radius: var(--border-radius-md);
            overflow: hidden;
            width: 92px;
        }

        .tm-stepper input {
            width: 100%;
            height: 100%;
            border: none;
            text-align: center;
            font-size: 14px;
            font-weight: 700;
            color: var(--color-text);
            background: transparent;
            -moz-appearance: textfield;
        }

        .tm-stepper input::-webkit-outer-spin-button,
        .tm-stepper input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .tm-stepper__arrows {
            display: flex;
            flex-direction: column;
            border-left: 1px solid var(--color-border-light);
        }

        .tm-stepper__arrows button {
            width: 24px;
            height: 20px;
            border: none;
            background: var(--color-surface);
            color: var(--color-text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
        }

        .tm-stepper__arrows button:hover {
            background: var(--color-page);
            color: var(--color-text);
        }

        .tm-day-range__sep {
            color: var(--color-text-muted);
            font-size: 13px;
        }

        .tm-input {
            width: 100%;
            height: 44px;
            border-radius: var(--border-radius-md);
            border: 1px solid var(--color-border);
            background: var(--color-surface);
            padding: 0 14px;
            font-size: 14px;
            color: var(--color-text);
        }

        .tm-input:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        /* checkbox pill options (Meal / Transport) */
        .tm-pill-options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .tm-pill-check {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            height: 40px;
            padding: 0 14px;
            border-radius: var(--border-radius-md);
            border: 1.5px solid var(--color-border);
            background: var(--color-surface);
            font-size: 13px;
            font-weight: 600;
            color: var(--color-text-secondary);
            cursor: pointer;
            transition: border-color 150ms ease, background 150ms ease, color 150ms ease;
        }

        .tm-pill-check:hover {
            border-color: #C7D9FB;
        }

        .tm-pill-check.is-checked {
            border-color: var(--color-primary);
            background: var(--color-primary-soft);
            color: var(--color-primary);
        }

        .tm-pill-check__box {
            width: 17px;
            height: 17px;
            border-radius: 5px;
            border: 1.5px solid var(--color-border);
            background: var(--color-surface);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: transparent;
            flex-shrink: 0;
            transition: all 150ms ease;
        }

        .tm-pill-check.is-checked .tm-pill-check__box {
            background: var(--color-primary);
            border-color: var(--color-primary);
            color: #fff;
        }

        .tm-pill-check input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* rich text editor (static shell — TinyMCE mounts here in production) */
        .tm-richtext {
            border: 1px solid var(--color-border);
            border-radius: var(--border-radius-md);
            overflow: hidden;
        }

        .tm-richtext__menubar {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 7px 12px;
            border-bottom: 1px solid var(--color-border-light);
            background: var(--color-page);
            font-size: 12px;
            color: var(--color-text-secondary);
            overflow-x: auto;
            white-space: nowrap;
        }

        .tm-richtext__menubar button {
            border: none;
            background: none;
            font-size: 12px;
            color: var(--color-text-secondary);
            font-weight: 600;
            padding: 2px 2px;
        }

        .tm-richtext__menubar button:hover {
            color: var(--color-text);
        }

        .tm-richtext__toolbar {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 6px 8px;
            border-bottom: 1px solid var(--color-border-light);
            background: var(--color-surface);
            flex-wrap: wrap;
        }

        .tm-richtext__toolbar button {
            width: 28px;
            height: 28px;
            border: none;
            background: none;
            border-radius: 6px;
            color: var(--color-text-secondary);
            font-size: 12.5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .tm-richtext__toolbar button:hover {
            background: var(--color-page);
            color: var(--color-text);
        }

        .tm-richtext__toolbar select {
            height: 28px;
            border: 1px solid var(--color-border-light);
            border-radius: 6px;
            font-size: 11.5px;
            color: var(--color-text);
            background: var(--color-surface);
            padding: 0 6px;
        }

        .tm-richtext__sep {
            width: 1px;
            height: 20px;
            background: var(--color-border-light);
            margin: 0 4px;
            flex-shrink: 0;
        }

        .tm-richtext__area {
            min-height: 150px;
            padding: 12px 14px;
            font-size: 13.5px;
            color: var(--color-text);
            line-height: 1.6;
        }

        .tm-richtext__area:empty::before {
            content: attr(data-placeholder);
            color: var(--color-text-muted);
        }

        .tm-richtext__area:focus {
            outline: none;
        }

        .tm-richtext__footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 6px 12px;
            border-top: 1px solid var(--color-border-light);
            background: var(--color-page);
            font-size: 11px;
            color: var(--color-text-muted);
        }

        /* image upload panel */
        .tm-image-panel {
            border: 1px solid var(--color-border-light);
            border-radius: var(--border-radius-lg);
            padding: 16px;
            background: var(--color-surface);
        }

        .tm-image-panel__header {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 14px;
        }

        .tm-image-panel__icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: var(--color-primary-soft);
            color: var(--color-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .tm-image-panel__header h3 {
            margin: 0;
            font-size: 13.5px;
            font-weight: 700;
            color: var(--color-text);
        }

        .tm-image-panel__header p {
            margin: 2px 0 0;
            font-size: 11.5px;
            color: var(--color-text-secondary);
        }

        .tm-dropzone {
            border: 1.5px dashed var(--color-border);
            border-radius: var(--border-radius-md);
            padding: 26px 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            text-align: center;
            background: var(--color-page);
        }

        .tm-dropzone__icon {
            width: 44px;
            height: 44px;
            border-radius: 999px;
            background: var(--color-primary-soft);
            color: var(--color-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-bottom: 4px;
        }

        .tm-dropzone__title {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--color-text);
        }

        .tm-dropzone__or {
            font-size: 11.5px;
            color: var(--color-text-muted);
        }

        .tm-btn--upload {
            background: var(--color-surface);
            border: 1px solid var(--color-primary);
            color: var(--color-primary);
            font-size: 12.5px;
        }

        .tm-btn--upload:hover {
            background: var(--color-primary-soft);
        }

        .tm-dropzone__caption {
            font-size: 11px;
            color: var(--color-text-muted);
            margin-top: 4px;
            line-height: 1.5;
        }

        .tm-image-preview {
            position: relative;
            margin-top: 14px;
            border-radius: var(--border-radius-md);
            overflow: hidden;
            width: 100%;
            height: auto;
            aspect-ratio: 204/134;
            background: var(--color-border-light);
        }

        .tm-image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .tm-image-preview__remove {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 26px;
            height: 26px;
            border-radius: 999px;
            border: none;
            background: rgba(15, 23, 42, 0.65);
            color: #fff;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .tm-image-preview__remove:hover {
            background: rgba(15, 23, 42, 0.85);
        }

        .tm-image-toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-top: 14px;
        }

        .tm-image-toggle-row span {
            font-size: 13px;
            font-weight: 600;
            color: var(--color-text);
        }

        .tm-image-note {
            display: flex;
            gap: 8px;
            margin-top: 10px;
            font-size: 11.5px;
            color: var(--color-text-secondary);
            line-height: 1.5;
        }

        .tm-image-note i {
            color: var(--color-primary);
            font-size: 12px;
            margin-top: 1px;
            flex-shrink: 0;
        }

        /* Accommodation (full width, below the 2-col grid) */
        .tm-accommodation {
            margin-top: 22px;
            padding-top: 20px;
            border-top: 1px solid var(--color-border-light);
        }

        .tm-accommodation__row {
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }

        .tm-accommodation__fields {
            flex: 1;
            min-width: 0;
            display: grid;
            grid-template-columns: 1.6fr 1fr;
            gap: 10px;
        }

        .tm-tag-select {
            min-height: 44px;
            border: 1px solid var(--color-border);
            border-radius: var(--border-radius-md);
            padding: 6px 34px 6px 10px;
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            align-items: center;
            position: relative;
            background: var(--color-surface);
        }

        .tm-tag-select i.fa-chevron-down {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 11px;
            color: var(--color-text-muted);
            pointer-events: none;
        }

        .tm-tag-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            height: 28px;
            padding: 0 6px 0 10px;
            border-radius: 999px;
            background: var(--color-primary-soft);
            color: var(--color-primary-dark);
            font-size: 12px;
            font-weight: 600;
        }

        .tm-tag-chip button {
            border: none;
            background: none;
            color: var(--color-primary);
            width: 18px;
            height: 18px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
        }

        .tm-tag-chip button:hover {
            background: rgba(37, 99, 235, 0.15);
        }

        .tm-accommodation-search {
            position: relative;
        }

        .tm-accommodation-search input {
            width: 100%;
            height: 44px;
            border-radius: var(--border-radius-md);
            border: 1px solid var(--color-border);
            padding: 0 32px 0 34px;
            font-size: 13px;
            color: var(--color-text);
        }

        .tm-accommodation-search input:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .tm-accommodation-search i.fa-magnifying-glass {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
            color: var(--color-text-muted);
        }

        .tm-accommodation-search i.fa-chevron-down {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 11px;
            color: var(--color-text-muted);
        }

        .tm-modal__footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            padding: 16px 24px;
            border-top: 1px solid var(--color-border-light);
            flex-shrink: 0;
        }

        .tm-btn--modal-close {
            background: var(--color-page);
            border-color: var(--color-border);
            color: var(--color-text);
            height: 42px;
            padding: 0 18px;
        }

        .tm-btn--modal-save {
            background: var(--color-primary);
            border-color: var(--color-primary);
            color: #fff;
            height: 42px;
            padding: 0 20px;
            font-weight: 700;
        }

        .tm-btn--modal-save:hover {
            background: var(--color-primary-dark);
        }

        @media (max-width: 900px) {
            .tm-modal__grid {
                grid-template-columns: 1fr;
            }

            .tm-accommodation__fields {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .tm-modal-overlay {
                padding: 0;
                align-items: flex-end;
            }

            .tm-modal {
                max-width: none;
                max-height: 94vh;
                border-radius: 18px 18px 0 0;
            }

            .tm-pill-options {
                gap: 8px;
            }

            .tm-day-range {
                flex-wrap: wrap;
            }

            .tm-modal__footer {
                flex-direction: column-reverse;
            }

            .tm-modal__footer .tm-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
{/literal}