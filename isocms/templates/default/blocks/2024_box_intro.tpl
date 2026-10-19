{assign var="item_id" value=""}
{if $cat_id|default:0 != 0 && $act != "place_inbound2024"}
    {assign var="item_id" value=$cat_id|default:0}
{elseif !empty($city_id)}
    {assign var="item_id" value=$city_id}
{/if}
{assign var="title_h1" value=""}
{if $act === "searchtour2024"}
    {assign var="title_h1" value="Top tours of $PAGE_NAME"}
{elseif $act === "travel_style_by_country"}
    {assign var="title_h1" value=$oneItem.title}
{/if}
{capture name="listTrvsTemplate"}
    <div class="hnv_trvs_intro_category swiper-container mb-3" id="trvsSwiper">
        <div class="hnv_trvs_intro_category_list swiper-wrapper">
            {section name=i loop=$lstTourCategory}
                {assign var="tourcat_id" value=$lstTourCategory[i].{$clsTourCategory->pkey}}
                <label for="cate_item_{$tourcat_id}" class="hnv_trvs_intro_category_item cursor_pointer typeSearch {if $clsISO->checkInArray($cat_id|default:0,$tourcat_id)}hnv_trvs_intro_category_item_active{/if} swiper-slide">
                    <input id="cate_item_{$tourcat_id}" type="checkbox" name="cat_id[]" class="d-none" value="{$tourcat_id}" {if $clsISO->checkInArray($cat_id|default:0,$tourcat_id)}checked{/if}>
                    <p class="hnv_trvs_intro_category_link">
                        {$lstTourCategory[i].title} {if $clsISO->checkInArray($cat_id|default:0,$tourcat_id)}
                            <i class="ms-1 fa-regular fa-xmark"></i>
                        {/if}
                    </p>
                </label>
            {/section}
        </div>
        <div class="swiper-button-next"><i class="fa-regular fa-angle-right"></i></div>
        <div class="swiper-button-prev"><i class="fa-regular fa-angle-left"></i></div>
    </div>
{/capture}
<section class="hnv_trvs_intro">
    <div class="container">
        <div class="row">
            {if $act === "searchtour2024" }
                <div class="hnv_trvs_intro_title">
                    <h1>{$core->get_Lang($title_h1)}</h1>
                </div>
                <div class="hnv_trvs_intro_description truncate_5">
                            {$oneItem.intro|html_entity_decode}
                        </div>
                {$smarty.capture.listTrvsTemplate}
            {elseif  $act === "travel_style_by_country"}
            <div class="col-sm-12 col-md-7">
                <div class="hnv_trvs_intro_title">
                    <h1>{$core->get_Lang($title_h1)}</h1>
                </div>
            {$smarty.capture.listTrvsTemplate}
                 <div class="hnv_trvs_intro_description truncate_5">
                            {$oneItem.content|html_entity_decode}
                        </div>
            </div>
                            <div class="col-sm-12 col-md-5">
                
                </div>
            {else}
                <div class="col-sm-12 col-md-7">
                    <div class="hnv_trvs_intro_title">
                        <h1>{$oneItem.title} {if $act == "place_inbound2024"}{$core->get_Lang("tours")}{/if}</h1>
                    </div>
                    {if $oneItem.intro}
                        <div class="hnv_trvs_intro_description truncate_5">
                            {$oneItem.intro|html_entity_decode}
                        </div>
                    {/if}
                    {$smarty.capture.listTrvsTemplate}
                </div>
                <div class="col-sm-12 col-md-5">
                    <div class="hnv_trvs_intro_gallery">
                        <img src="{$clsClassTable->getImage($item_id, 517, 260)}" onerror="this.src='{$URL_IMAGES}/none_image.png'" width="517" height="260"
                             class="hnv_trvs_intro_gallery_image scale_img_hover" title="{$oneItem.title}"
                             alt="Gallery">
                    </div>
                </div>
            {/if}
        </div>
    </div>
</section>
{literal}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $(document).ready(() => {
                const swiper = new Swiper('#trvsSwiper', {
                    slidesPerView: 'auto',
                    spaceBetween: 10,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                });
            })
        })
    </script>
{/literal}
