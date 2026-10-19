{assign var="title" value=$core->get_Lang("Travel Styles")}
{if $act === "place_inbound2024"}
    {assign var="title" value=$clsCountry->getTitle($country_id)}
{elseif $act === "searchtour2024"}
    {assign var="title" value=$core->get_Lang("Tours")}
    {assign var="title_active" value=$core->get_Lang("Search results")}
{/if}

<section class="hnv_breadcrumb">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{$DOMAIN_NAME}{$extLang}" title="{$core->get_Lang('Home')}">{$core->get_Lang('Home')}</a>
                </li>
                {if $act == "place_inbound2024" || $act == "travel_style_by_country"}
                    <li class="breadcrumb-item">
                        <a href="#" title="{$core->get_Lang($title)}">{$core->get_Lang("Destination")}</a>
                    </li>
                {/if}
                {if $show == "CatCountry"}
                    <li class="breadcrumb-item">
                        <a href="#">{$clsCountry->getTitle($country_id)}</a>
                    </li>
                {/if}
                <li class="breadcrumb-item">
                    <a href="#" title="{$core->get_Lang($title)}">{$core->get_Lang($title)}</a>
                </li>
                {if isset($oneItem) && !empty($oneItem.title)}
                <li class="breadcrumb-item active" aria-current="page">
                    {$oneItem.title} {if $act === "place_inbound2024" || $act === "place_outbound2024"}{$core->get_Lang("tours")}{/if}
                    {$title_active|default:''}
                </li>
                {/if}
            </ol>
        </nav>
    </div>
</section>
<form action="" id="hnv_filter_form_tour" method="post">
{$clsISO->getBlock('2024_box_intro')}
{$core->getBlock('box_item_tour')}
</form>
{$core->getBlock('tour_recently_viewed')}
{$core->getBlock('2024_review_customer')}
{$core->getBlock('dev_helpcenter_topdest')}
{literal}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $('.typeSearch').change(function() {
                $(this).closest('form').submit();
            });
        })
    </script>
{/literal}
