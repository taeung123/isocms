<form action="" method="post">
    <div class="input-group txtbox_search mb-3">
        <input type="text" class="form-control clear key_blog_search" placeholder="{$core->get_Lang("Search")}" name="keyword_search" value="{$keyword_search}" />
        <button type="submit" class="input-group-text txtbox_searchtxt iso_btn_search">
            <i class="fa fa-search" aria-hidden="true"></i>
        </button>
    </div>
    <div class="box_filter mt-lg-0 mt-5">
        <div class="box_articles">
            <h2 class="txt_filterart">
                <i class="fa fa-sort-amount-desc" aria-hidden="true"></i>
                <span>{$core->get_Lang('Filter Articles')}</span>
            </h2>
        </div>
        <div class="box-region">
            {if $lstCountry}
                {foreach from=$lstCountry key=key item=item}
                    <div title="{$item.title}" alt="{$item.title}" data-country="{$item.country_id}" class="typeSearch iso_btn_search region_item {if $item.country_id eq $country_id} active {/if}">
                        <input class="d-none" id="country_id_{$item.country_id}" type="radio" name="country_id" value="{$item.country_id}" {if $item.country_id === $country_id}checked{/if}>
                        <label for="country_id_{$item.country_id}" class="mb-3 txt_region">{$item.title}</label>
                    </div>
                {/foreach}
            {/if}
        </div>
        <div class="filter-checkbox">
            {foreach from=$listGuideCat key=key item=item name=guidecat}
                <div class="iso_btn_search guidecat-item typeSearch">
                    <input id="guidecat_id_{$item.guidecat_id}" class="form-check-input" type="checkbox" name="guide_cat[]" value="{$item.guidecat_id}" {if $clsISO->checkInArray($list_guidecat_id,$item.guidecat_id)}checked{/if} />
                    <label for="guidecat_id_{$item.guidecat_id}" class="form-check-label">
                        {$item.title}
                    </label>
                </div>
            {/foreach}
        </div>
    </div>
</form>
{literal}
    <style>
        .view_more {
            color: var(--primary-18-babd, #18BABD);
            border: unset;
            padding: 0;
            background: unset;
            cursor: pointer;
        }
        .form-check-input:focus,
        .form-control:focus {
            box-shadow: unset !important;
        }

        .box_articles {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #FFF;
            letter-spacing: 0.64px;
            border-radius: 4px 4px 0px 0px;
            background: var(--primary-18-babd, #18BABD);
            padding: 20px 0;
        }

        .box_articles h2 {
            font-size: 16px;
            font-style: normal;
            font-weight: 600;
            line-height: 24px;
        }

        .box-region {
            padding: 20px;
            border-bottom: 1px solid #e5e5e5;
            background: #F9F9F9;
        }

        .filter-checkbox {
            padding: 20px;
            background: #F9F9F9;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .box_filter {
            margin-bottom: 40px;
        }

        .filter-checkbox label {
            color: #333;
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 22px;
            cursor: pointer !important;
        }

        input[type="checkbox"] {
            appearance: none;
            width: 23px;
            height: 23px;
            border: 2px solid #D9D9D9;
            border-radius: 4px;
            background-color: #fff;
            transition: background-color 0.3s ease;
            margin: 0;
            margin-right: 10px !important;
        }

        input[type="checkbox"]:checked {
            background-color: var(--primary-18-babd, #18BABD);
            /* Màu khi checkbox được chọn */
            border-color: var(--primary-18-babd, #18BABD);
        }
        /* Hide all items after the first 5 */
        .filter-checkbox .guidecat-item:nth-child(n+6) {
            display: none;
        }

        .view-more-container {
            margin-top: 10px;
        }
        .view-more-btn, .view-less-btn {
            color: var(--primary-18-babd, #18BABD);
            border: none;
            background: transparent;
            padding: 8px 16px;
            cursor: pointer;
        }
        .txt_region {
            cursor: pointer;
        }
        .region_item.active .txt_region {
            color: var(--primary-18-babd, #18BABD);
        }

    </style>
    <script>
        toggleContent(".box-region", ".region_item");
        toggleContent(".filter-checkbox", ".guidecat-item");
        $(document).ready(function() {
            $('.typeSearch').click(function () {
                $(this).closest('form').submit();
            });
        });
    </script>
{/literal}