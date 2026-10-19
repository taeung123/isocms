<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css"/>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<link rel="stylesheet" href="{$URL_CSS}/cruise_cat2024.css?v={$upd_version}"/>

<main>
    <section class="hnv_breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{$HOMEPAGE_URL}" title="{$core->get_Lang('Home')}">{$core->get_Lang('Home')}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{$clsISO->getLink("cruise")}" title="{$core->get_Lang('Cruise')}">{$core->get_Lang('Cruises')}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="#" title="{$core->get_Lang("Search results")}">{$core->get_Lang("Search results")}</a>
                    </li>
                </ol>
            </nav>
        </div>
    </section>

    {$core->getBlock("block_list_cruise")}
    {$core->getBlock('2024_review_customer')}
</main>
{literal}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $("main").css("margin-top", $("header").outerHeight());
        })
    </script>
{/literal}