{* =========================================================
 * DEFAULT VALUES - CHỐNG WARNING PHP 8 / SMARTY
 * ========================================================= *}

{if !isset($key_blog)}
    {assign var=key_blog value=''}
{/if}

{if !isset($country_id)}
    {assign var=country_id value=0}
{/if}
{if !isset($country_id_array)}
    {assign var=country_id_array value=array()}
{/if}
{if !isset($country_id_search)}
    {assign var=country_id_search value=0}
{/if}

{if !isset($city_id)}
    {assign var=city_id value=0}
{/if}

{if !isset($region_id)}
    {assign var=region_id value=0}
{/if}

{if !isset($list_cats)}
    {assign var=list_cats value=''}
{/if}

{if !isset($lstCountry)}
    {assign var=lstCountry value=''}
{/if}

{if !isset($lstCategory)}
    {assign var=lstCategory value=''}
{/if}

{if !isset($oneItemCountry)}
    {assign var=oneItemCountry value=array()}
{/if}

{if !isset($oneItemCity)}
    {assign var=oneItemCity value=array()}
{/if}

{if !isset($oneItemRegion)}
    {assign var=oneItemRegion value=array()}
{/if}


<form action="" method="post" class="form_blog_search">

    {* =====================================================
     * SEARCH
     * ===================================================== *}

    <div class="input-group txtbox_search mb-3">

        <input
            type="text"
            class="form-control clear key_blog_search"
            placeholder="{$core->get_Lang('Search')}"
            name="key_blog"
            value="{$key_blog|default:''|escape:'html'}"
        />

        <button
            type="submit"
            class="input-group-text txtbox_searchtxt iso_btn_search"
            aria-label="{$core->get_Lang('Search')}"
        >
            <i class="fa fa-search" aria-hidden="true"></i>
        </button>

    </div>


    {* =====================================================
     * MOBILE FILTER BUTTON
     * ===================================================== *}

    <button
        type="button"
        class="mobile_blog_filter_btn"
        aria-controls="blog_mobile_filter"
        aria-expanded="false"
    >
        <i class="fa-solid fa-sliders" aria-hidden="true"></i>
        <span>{$core->get_Lang('Filter Article')}</span>
    </button>


    {* =====================================================
     * FILTER
     * ===================================================== *}

    <div
        class="box_filter mt-lg-0 mt-5"
        id="blog_mobile_filter"
    >

        <button
            type="button"
            class="mobile_filter_close"
            aria-label="{$core->get_Lang('Close')}"
        >
            ×
        </button>


        {* =================================================
         * FILTER TITLE
         * ================================================= *}

        <div class="box_articles">

            <h4 class="txt_filterart">

                <i
                    class="fa-solid fa-sliders"
                    aria-hidden="true"
                ></i>

                <span>
                    {$core->get_Lang('Filter Articles')}
                </span>

            </h4>

        </div>


        {* =================================================
         * CATEGORY
         * ================================================= *}

        {if $lstCategory}

            <div class="filter-checkbox">

                <h4 class="l-widget-title">
                    {$core->get_Lang('Blog Category')}
                </h4>

                <div class="grid-1fr1fr">

                    {foreach from=$lstCategory key=key item=item}

                        {assign
                            var=item_blogcat_id
                            value=$item.blogcat_id|default:0
                        }

                        {assign
                            var=item_category_title
                            value=$item.title|default:''
                        }


                        {if !isset($list_cats_map)}
                            {assign var=list_cats_map value=array()}
                        {/if}


                        {assign
                            var=is_category_checked
                            value=false
                        }


                        {if isset($list_cats_map[$item_blogcat_id])}

                            {if $list_cats_map[$item_blogcat_id] eq 1}

                                {assign
                                    var=is_category_checked
                                    value=true
                                }

                            {/if}

                        {/if}


                        <div class="blog_category_item">

                            <input
                                id="cat_id_{$item_blogcat_id}"
                                name="cat_id[]"
                                class="blog_category_checkbox"
                                type="checkbox"
                                value="{$item_blogcat_id}"
                                {if $is_category_checked}
                                    checked="checked"
                                {/if}
                            />

                            <label
                                for="cat_id_{$item_blogcat_id}"
                                class="form-check-label"
                            >
                                {$item_category_title}
                            </label>

                        </div>

                    {/foreach}

                </div>

            </div>

        {/if}


     {* =================================================
 * COUNTRY - MULTI SELECT
 * ================================================= *}

{if $lstCountry}

    <div class="box-region">

        <h4 class="l-widget-title">
            {$core->get_Lang('Destination')}
        </h4>


        <div class="grid-1fr1fr">

            {foreach from=$lstCountry key=key item=item}

                {* =========================================
                 * COUNTRY ID
                 *
                 * Lấy country_id thật từ PHP.
                 * KHÔNG dùng key của foreach.
                 * ========================================= *}

                {assign
                    var=item_country_id
                    value=$item.country_id|default:0
                }


                {assign
                    var=item_country_title
                    value=$item.title|default:''
                }


                {* =========================================
                 * CHECKED STATE
                 *
                 * country_id_array có thể là:
                 *
                 * array(1,7,78)
                 *
                 * Nếu country hiện tại nằm trong array
                 * thì checked.
                 * ========================================= *}

                {assign
                    var=is_country_checked
                    value=false
                }


                {if !empty($country_id_array)}

                    {foreach
                        from=$country_id_array
                        item=selected_country_id
                    }

                        {if $item_country_id eq $selected_country_id}

                            {assign
                                var=is_country_checked
                                value=true
                            }

                        {/if}

                    {/foreach}

                {/if}


                <div
                    title="{$item_country_title|escape:'html'}"
                    data-country="{$item_country_id}"
                    class="region_item{if $is_country_checked} active{/if}"
                >

                    <input
                        class="country-check-input"
                        id="country_id_{$item_country_id}"
                        type="checkbox"
                        name="country_id[]"
                        value="{$item_country_id}"
                        {if $is_country_checked}
                            checked="checked"
                        {/if}
                    />


                    <label
                        for="country_id_{$item_country_id}"
                        class="country-check-label"
                    >
                        {$item_country_title}
                    </label>

                </div>

            {/foreach}

        </div>

    </div>

{/if}


    </div>


    <input
        type="hidden"
        name="form_search"
        value="form_search"
    />

</form>


{literal}

<style>

/* =========================================================
 * FILTER
 * ========================================================= */

.view_more {
    color: var(--primary-18-babd, #18BABD);
    border: 0;
    padding: 0;
    background: transparent;
    cursor: pointer;
}


/* =========================================================
 * COUNTRY
 * ========================================================= */

.box-region {
    display: flex;
    flex-direction: column;
    gap: 15px;
}


.box-region .region_item {
    display: flex;
    align-items: center;
    margin: 0;
    cursor: pointer;
}


/* =========================================================
 * COUNTRY RADIO -> CHECKBOX STYLE
 * ========================================================= */

.box-region .country-check-input {
    appearance: none;
    -webkit-appearance: none;

    position: relative;
    display: inline-block;

    flex: 0 0 23px;

    width: 23px;
    height: 23px;

    margin: 0 10px 0 0 !important;
    padding: 0;

    border: 2px solid #d9d9d9;
    border-radius: 4px;

    background-color: #fff;

    cursor: pointer;

    transition:
        background-color .2s ease,
        border-color .2s ease;
}


.box-region .country-check-input:checked {
    border-color: var(--primary-18-babd, #18BABD);
    background-color: var(--primary-18-babd, #18BABD);
}


.box-region .country-check-input:checked::after {
    content: "";

    position: absolute;

    top: 3px;
    left: 7px;

    display: block;

    width: 6px;
    height: 11px;

    border: solid #fff;
    border-width: 0 2px 2px 0;

    transform: rotate(45deg);
}


.box-region .country-check-input:focus {
    outline: none;
    box-shadow: none;
}


/* =========================================================
 * COUNTRY LABEL
 * ========================================================= */

.box-region .country-check-label {
    margin: 0 !important;
    cursor: pointer;
}


.box-region .region_item.active .country-check-label,
.box-region .country-check-input:checked + .country-check-label {
    color: var(--primary-18-babd, #18BABD);
}


.region_item label {
    cursor: pointer;
}


.region_item.active label {
    color: #F9A108;
}


/* =========================================================
 * COMMON
 * ========================================================= */

.form-check-input:focus,
.form-control:focus {
    box-shadow: none !important;
}


/* =========================================================
 * FILTER TITLE
 * ========================================================= */

.box_articles {
    color: var(--primary-1-d-2-d-53, #1D2D53);

    border-radius: 10px;

    background: var(--main-light-color);

    border: 1px solid var(--border-color);

    padding: 11px 16px;

    margin-bottom: 24px;

    display: flex;
    align-items: center;

    gap: 12px;
}

.box_articles h4 {
    display: flex;
    align-items: center;
    gap: 8px;
}

.box_articles h4 i {
    font-size: var(--font-size-article-icon);
    color: var(--primary-color);
}





/* =========================================================
 * BOX
 * ========================================================= */

.box-region,
.filter-checkbox {
    padding: 20px;
    border-bottom: 1px solid var(--border-color);
    box-shadow: rgb(0, 80, 0) 0px 6px 20px -15px;
    margin-bottom: 30px;
}

.filter-checkbox {
    display: flex;
    flex-direction: column;
    gap: 15px;
}


.box_filter {
    margin-bottom: 40px;
}


/* =========================================================
 * CATEGORY
 * ========================================================= */

.filter-checkbox label {
    cursor: pointer !important;
}


.filter-checkbox input[type="checkbox"] {
    appearance: none;
    -webkit-appearance: none;
    flex: 0 0 23px;
    width: 23px;
    height: 23px;
    border: 2px solid var(--border-color);
    border-radius: 4px;
    background-color: var(--light-color);

    transition:
        background-color .3s ease,
        border-color .3s ease;

    margin: 0 10px 0 0 !important;
}


.filter-checkbox input[type="checkbox"]:checked {
    background-color: var(--primary-18-babd, #18BABD);
    border-color: var(--primary-18-babd, #18BABD);
}


.filter-checkbox input[type="checkbox"]:checked::after {
    content: "";
    display: block;
    width: 6px;
    height: 11px;
    margin: 2px auto 0;
    border: solid var(--light-color);
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}


.form-check-input:disabled,
.form-check-input:disabled ~ .form-check-label,
.form-check-input[disabled] ~ .form-check-label {
    opacity: 1 !important;
}


/* =========================================================
 * GRID
 * ========================================================= */

.country_hidden {
    display: none;
}


.more_region {
    color: #F9A108;

    border: 0;
    padding: 0;

    background: transparent;
}





.region_item,
.blog_category_item {
    display: flex;
    align-items: center;

    margin: 0;

    cursor: pointer;
}


.region_item {
    align-items: center;
}


.grid-1fr1fr .region_item,
.grid-1fr1fr .blog_category_item {
    margin-bottom: 5%;
}


.region_item label {
    margin-bottom: 0 !important;
}


/* =========================================================
 * SEARCH
 * ========================================================= */

.txtbox_search {
    position: relative;
}


.txtbox_search input {
    border-color: var(--main-color);
    border-radius: 6px !important;
    height: 52px;
    padding-right: 50px;
}


.txtbox_search .input-group-text {
    background: transparent;
    border: 0;
    position: absolute;
    right: 0;
    height: 100%;
    z-index: 99;
}


.txtbox_search .input-group-text i {
    color: var(--main-color);
}


/* =========================================================
 * MOBILE
 * ========================================================= */

@media (max-width: 991px) {

    .pdt50 {
        padding-top: 20px !important;
    }


    /* ---------------------------------------------
     * MOBILE FILTER BUTTON
     * --------------------------------------------- */

    .mobile_blog_filter_btn {
        display: flex;

        gap: 8px;

        width: 100%;
        min-height: 48px;

        margin: 0 0 15px;

        padding: 10px 16px;

        border: 1px solid #0b8b40;
        border-radius: 6px;

        background: #f3fff7;

        color: #087f38;

        font-size: 16px;
        font-weight: 600;

        cursor: pointer;
    }


    .mobile_blog_filter_btn i {
        font-size: 18px;
        margin-top: 4px;
    }


    /* ---------------------------------------------
     * FILTER DEFAULT HIDDEN
     * --------------------------------------------- */

    .form_blog_search .box_filter,
    .box_articles {
        display: none;
    }


    /* ---------------------------------------------
     * FILTER OPEN
     * --------------------------------------------- */

    .form_blog_search .box_filter.mobile_filter_open {
        display: block;

        position: fixed;

        z-index: 99999;

        top: 60px;

        left: 0;
        right: 0;

        width: 100%;

        height: calc(100vh - 60px);

        margin: 0 !important;

        padding: 0;

        overflow-y: auto;
        overflow-x: hidden;

        background: #fff;

        -webkit-overflow-scrolling: touch;
    }


    /* ---------------------------------------------
     * CLOSE
     * --------------------------------------------- */

    .mobile_filter_close {
        position: sticky;

        top: 0;

        z-index: 10;

        display: block;

        width: 100%;
        height: 54px;

        margin: 0;

        padding: 0 18px;

        border: 0;

        background: #fff;

        color: #111;

        font-size: 34px;
        font-weight: 300;

        line-height: 54px;

        text-align: right;

        cursor: pointer;
    }


    /* ---------------------------------------------
     * FILTER BOX MOBILE
     * --------------------------------------------- */

    .form_blog_search .box_filter.mobile_filter_open .filter-checkbox,
    .form_blog_search .box_filter.mobile_filter_open .box-region {
        margin: 0;

        padding: 20px 16px;

        border-bottom: 1px solid #e5e5e5;

        box-shadow: none;

        border-radius: 0;

        gap: 15px;
    }


    .form_blog_search .box_filter.mobile_filter_open .l-widget-title {
        margin: 0 0 15px;
        text-align: center;
        font-size: 18px;
        line-height: 26px;
    }


    /* ---------------------------------------------
     * TWO COLUMNS
     * --------------------------------------------- */

    .form_blog_search .box_filter.mobile_filter_open .grid-1fr1fr {
        display: grid;

        grid-template-columns: 1fr 1fr;

        column-gap: 18px;
        row-gap: 14px;
    }


    .form_blog_search .box_filter.mobile_filter_open .grid-1fr1fr .region_item,
    .form_blog_search .box_filter.mobile_filter_open .grid-1fr1fr .blog_category_item {
        margin-bottom: 0;

        min-height: 24px;
    }


    .form_blog_search .box_filter.mobile_filter_open .region_item,
    .form_blog_search .box_filter.mobile_filter_open .blog_category_item {
        display: flex;

        align-items: center;
    }


    .form_blog_search .box_filter.mobile_filter_open .country-check-label,
    .form_blog_search .box_filter.mobile_filter_open .filter-checkbox label {
        font-size: 15px;

        line-height: 22px;
    }


    .grid-1fr1fr {
        display: grid;

        grid-template-columns: 1fr 1fr;
    }


    .mt-5 {
        margin-top: 0 !important;
    }


    .txtbox_search .key_blog_search {
        height: 50px;
    }


    /* ---------------------------------------------
     * LOCK BODY
     * --------------------------------------------- */

    body.blog_filter_mobile_locked {
        overflow: hidden;

        touch-action: none;
    }

}


/* =========================================================
 * DESKTOP
 * ========================================================= */

@media (min-width: 992px) {

    .mobile_blog_filter_btn,
    .mobile_filter_close {
        display: none;
    }

}

</style>


<script>

(function () {

    'use strict';


    var isNavigating = false;


    /* =====================================================
     * FORM
     * ===================================================== */

    function getFilterForm() {

        return document.querySelector(
            '.form_blog_search'
        );

    }


    /* =====================================================
     * MOBILE FILTER
     * ===================================================== */

    function isMobileBlogFilter() {

        return window.matchMedia &&
            window.matchMedia(
                '(max-width: 991px)'
            ).matches;

    }


    function setMobileFilter(open) {

        var form = getFilterForm();

        if (
            !form ||
            !isMobileBlogFilter()
        ) {
            return;
        }


        var filter =
            form.querySelector(
                '.box_filter'
            );


        var button =
            form.querySelector(
                '.mobile_blog_filter_btn'
            );


        if (!filter) {
            return;
        }


        if (open) {

            filter.classList.add(
                'mobile_filter_open'
            );

            document.body.classList.add(
                'blog_filter_mobile_locked'
            );


            if (button) {

                button.setAttribute(
                    'aria-expanded',
                    'true'
                );

            }

        } else {

            filter.classList.remove(
                'mobile_filter_open'
            );

            document.body.classList.remove(
                'blog_filter_mobile_locked'
            );


            if (button) {

                button.setAttribute(
                    'aria-expanded',
                    'false'
                );

            }
        }
    }


    /* =====================================================
     * GET CHECKED CATEGORY
     * ===================================================== */

    function getCheckedCategoryIds() {

        var checkedInputs =
            document.querySelectorAll(
                '.form_blog_search .blog_category_checkbox:checked'
            );


        var categoryIds = [];


        checkedInputs.forEach(
            function (input) {

                var categoryId =
                    parseInt(
                        input.value,
                        10
                    );


                if (
                    categoryId > 0 &&
                    categoryIds.indexOf(
                        categoryId
                    ) === -1
                ) {

                    categoryIds.push(
                        categoryId
                    );

                }

            }
        );


        categoryIds.sort(
            function (a, b) {
                return a - b;
            }
        );


        return categoryIds;
    }


    /* =====================================================
     * CATEGORY FILTER
     * ===================================================== */

    function applyCategoryFilter() {

        if (isNavigating) {
            return;
        }


        isNavigating = true;


        var categoryIds =
            getCheckedCategoryIds();


        var currentUrl =
            new URL(
                window.location.href
            );


        if (categoryIds.length > 0) {

            currentUrl.searchParams.set(
                'cat',
                categoryIds.join(',')
            );

        } else {

            currentUrl.searchParams.delete(
                'cat'
            );
        }


        currentUrl.searchParams.delete(
            'page'
        );


        window.location.href =
            currentUrl.pathname +
            currentUrl.search;
    }


    /* =====================================================
     * COUNTRY FILTER
     *
     * country_id = ID thật.
     *
     * Không dùng key.
     * ===================================================== */

    function applyCountryFilter(input) {

        if (
            isNavigating ||
            !input
        ) {
            return;
        }


        isNavigating = true;


        var countryId =
            parseInt(
                input.value,
                10
            );


        if (
            !countryId ||
            countryId <= 0
        ) {

            isNavigating = false;

            return;
        }


        /*
         * Không POST key.
         *
         * Chuyển trực tiếp:
         *
         * ?country_id=1
         *
         */

        var currentUrl =
            new URL(
                window.location.href
            );


        currentUrl.searchParams.set(
            'country_id',
            countryId
        );


        currentUrl.searchParams.delete(
            'page'
        );


        /*
         * Nếu đang ở URL SEO:
         *
         * /blog/vietnam/
         *
         * thì chuyển về:
         *
         * /blog/?country_id=1
         *
         * để controller Default xử lý
         * country_id trực tiếp.
         */

        currentUrl.searchParams.delete(
            'key'
        );


        window.location.href =
            currentUrl.pathname +
            currentUrl.search;

    }


    /* =====================================================
     * RESTORE CATEGORY FROM URL
     * ===================================================== */

    function restoreCategoryChecksFromUrl() {

        var currentUrl =
            new URL(
                window.location.href
            );


        var catValue =
            currentUrl.searchParams.get(
                'cat'
            ) || '';


        var selectedIds =
            catValue
                .split(',')
                .map(
                    function (value) {

                        return String(
                            parseInt(
                                value,
                                10
                            )
                        );

                    }
                )
                .filter(
                    function (value) {

                        return (
                            value !== 'NaN' &&
                            value !== '0'
                        );

                    }
                );


        document
            .querySelectorAll(
                '.form_blog_search .blog_category_checkbox'
            )
            .forEach(
                function (checkbox) {

                    checkbox.checked =
                        selectedIds.indexOf(
                            String(
                                checkbox.value
                            )
                        ) !== -1;

                }
            );
    }


    /* =====================================================
     * DOM READY
     * ===================================================== */

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            restoreCategoryChecksFromUrl();


            var form =
                getFilterForm();


            if (!form) {
                return;
            }


            /* =================================================
             * MOBILE BUTTON
             * ================================================= */

            var mobileFilterButton =
                form.querySelector(
                    '.mobile_blog_filter_btn'
                );


            var mobileFilterClose =
                form.querySelector(
                    '.mobile_filter_close'
                );


            if (mobileFilterButton) {

                mobileFilterButton.addEventListener(
                    'click',
                    function () {

                        setMobileFilter(true);

                    }
                );

            }


            if (mobileFilterClose) {

                mobileFilterClose.addEventListener(
                    'click',
                    function () {

                        setMobileFilter(false);

                    }
                );

            }


            window.addEventListener(
                'resize',
                function () {

                    if (!isMobileBlogFilter()) {

                        setMobileFilter(false);

                    }

                }
            );


           /* =====================================================
 * COUNTRY - MULTI SELECT
 * ===================================================== */

var countryBox =
    form.querySelector(
        '.box-region'
    );


if (countryBox) {


    /* =================================================
     * GET ALL CHECKED COUNTRY
     *
     * Ví dụ:
     *
     * Vietnam
     * Thailand
     * Laos
     *
     * =>
     *
     * [1, 7, 78]
     * ================================================= */

    function getCheckedCountryIds() {

        var checkedInputs =
            countryBox.querySelectorAll(
                '.country-check-input:checked'
            );


        var countryIds = [];


        checkedInputs.forEach(
            function (input) {

                var countryId =
                    parseInt(
                        input.value,
                        10
                    );


                if (
                    countryId > 0 &&
                    countryIds.indexOf(countryId) === -1
                ) {

                    countryIds.push(
                        countryId
                    );

                }

            }
        );


        /*
         * Sắp xếp ID để URL ổn định.
         *
         * 78,1,7
         *
         * =>
         *
         * 1,7,78
         */

        countryIds.sort(
            function (a, b) {

                return a - b;

            }
        );


        return countryIds;
    }


    /* =================================================
     * UPDATE ACTIVE CLASS
     * ================================================= */

    function updateCountryActiveState() {

        countryBox
            .querySelectorAll(
                '.region_item'
            )
            .forEach(
                function (item) {

                    var checkbox =
                        item.querySelector(
                            '.country-check-input'
                        );


                    if (!checkbox) {
                        return;
                    }


                    if (checkbox.checked) {

                        item.classList.add(
                            'active'
                        );

                    } else {

                        item.classList.remove(
                            'active'
                        );

                    }

                }
            );
    }


    /* =================================================
     * APPLY COUNTRY FILTER
     *
     * KHÔNG nhận input nữa.
     *
     * Lấy TOÀN BỘ checkbox đang checked.
     * ================================================= */

    function applyCountryFilter() {

        if (isNavigating) {
            return;
        }


        var countryIds =
            getCheckedCountryIds();


        var currentUrl =
            new URL(
                window.location.href
            );


        /* =============================================
         * COUNTRY
         *
         * Ví dụ:
         *
         * [1,7,78]
         *
         * =>
         *
         * country_id=1,7,78
         * ============================================= */

        if (countryIds.length > 0) {

            currentUrl.searchParams.set(
                'country_id',
                countryIds.join(',')
            );

        } else {

            currentUrl.searchParams.delete(
                'country_id'
            );

        }


        /*
         * Khi đổi country:
         * reset pagination.
         */

        currentUrl.searchParams.delete(
            'page'
        );


        /*
         * Country filter không dùng key.
         */

        /*
         * KHÔNG xóa cat.
         *
         * Ví dụ:
         *
         * /blog/?country_id=1,7&cat=4,6
         *
         * vẫn giữ:
         *
         * country_id=1,7
         * cat=4,6
         */


        /*
         * Nếu URL hiện tại là:
         *
         * /blog/vietnam/
         *
         * thì vẫn giữ pathname.
         *
         * Controller PHP sẽ xử lý country_id.
         */

        isNavigating = true;


        window.location.href =
            currentUrl.pathname +
            currentUrl.search;
    }


    /* =================================================
     * CHANGE CHECKBOX
     *
     * Đây là event chính.
     *
     * Browser tự checked / unchecked trước khi
     * event change chạy.
     * ================================================= */

    countryBox.addEventListener(
        'change',
        function (event) {

            var input =
                event.target;


            if (
                !input.classList.contains(
                    'country-check-input'
                )
            ) {

                return;
            }


            event.stopPropagation();


            /*
             * Cập nhật màu active.
             */

            updateCountryActiveState();


            /*
             * Lấy TẤT CẢ country đang checked.
             */

            applyCountryFilter();

        }
    );


    /* =================================================
     * CLICK VÀO KHOẢNG TRỐNG TRÊN DÒNG COUNTRY
     *
     * Nếu click input hoặc label:
     *
     * => để browser xử lý.
     *
     * Nếu click phần còn lại của dòng:
     *
     * => tự toggle checkbox.
     * ================================================= */

    countryBox.addEventListener(
        'click',
        function (event) {

            var item =
                event.target.closest(
                    '.region_item'
                );


            if (!item) {
                return;
            }


            /*
             * Nếu click trực tiếp checkbox hoặc label
             * thì browser sẽ xử lý checkbox.
             *
             * Event change bên trên sẽ gọi filter.
             */

            if (
                event.target.matches(
                    'input, label'
                )
            ) {

                return;
            }


            event.preventDefault();
            event.stopPropagation();


            var checkbox =
                item.querySelector(
                    '.country-check-input'
                );


            if (!checkbox) {
                return;
            }


            /*
             * Toggle:
             *
             * unchecked -> checked
             * checked   -> unchecked
             */

            checkbox.checked =
                !checkbox.checked;


            updateCountryActiveState();


            applyCountryFilter();

        }
    );


    /* =================================================
     * RESTORE CHECKED STATE FROM URL
     *
     * Trường hợp reload:
     *
     * /blog/?country_id=1,7,78
     *
     * phải hiện:
     *
     * ☑ Vietnam
     * ☑ Thailand
     * ☑ Laos
     * ================================================= */

    function restoreCountryChecksFromUrl() {

        var currentUrl =
            new URL(
                window.location.href
            );


        var countryValue =
            currentUrl.searchParams.get(
                'country_id'
            ) || '';


        var selectedIds = [];


        if (countryValue !== '') {

            selectedIds =
                countryValue
                    .split(',')
                    .map(
                        function (value) {

                            return parseInt(
                                value,
                                10
                            );

                        }
                    )
                    .filter(
                        function (value) {

                            return (
                                !isNaN(value) &&
                                value > 0
                            );

                        }
                    );

        }


        /*
         * Remove duplicate.
         */

        selectedIds =
            selectedIds.filter(
                function (value, index) {

                    return (
                        selectedIds.indexOf(value)
                        === index
                    );

                }
            );


        /*
         * Restore checkbox.
         */

        countryBox
            .querySelectorAll(
                '.country-check-input'
            )
            .forEach(
                function (checkbox) {

                    var id =
                        parseInt(
                            checkbox.value,
                            10
                        );


                    checkbox.checked =
                        selectedIds.indexOf(id)
                        !== -1;

                }
            );


        /*
         * Restore active class.
         */

        updateCountryActiveState();
    }


    /*
     * Chạy ngay khi DOM ready.
     */

    restoreCountryChecksFromUrl();

}
            /* =================================================
             * CATEGORY
             * ================================================= */

            var categoryBox =
                form.querySelector(
                    '.filter-checkbox'
                );


            if (categoryBox) {

                /*
                 * Click checkbox / label
                 */

                categoryBox.addEventListener(
                    'change',
                    function (event) {

                        if (
                            !event.target.classList.contains(
                                'blog_category_checkbox'
                            )
                        ) {

                            return;
                        }


                        event.stopPropagation();


                        applyCategoryFilter();

                    }
                );


                /*
                 * Click dòng category
                 */

                categoryBox.addEventListener(
                    'click',
                    function (event) {

                        var item =
                            event.target.closest(
                                '.blog_category_item'
                            );


                        if (!item) {
                            return;
                        }


                        if (
                            event.target.matches(
                                'input, label'
                            )
                        ) {

                            return;
                        }


                        event.preventDefault();
                        event.stopPropagation();


                        var checkbox =
                            item.querySelector(
                                '.blog_category_checkbox'
                            );


                        if (!checkbox) {
                            return;
                        }


                        checkbox.checked =
                            !checkbox.checked;


                        applyCategoryFilter();

                    }
                );

            }

        }
    );

})();

</script>

{/literal}