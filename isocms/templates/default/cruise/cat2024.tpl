<main>
    <section class="banner_cruise">
        {assign var="w" value=($deviceType=="computer")?1920:480}
        <img src="{$clsISO->tripslashImage($oneCat.image_banner, $w, 400)}" alt="{$title_cat}">
        <div class="intro_cruise">
            <h1 class="intro_cruise_title">{$title_cat}</h1>
            <div class="intro_cruise_txt">{$oneCat.intro|html_entity_decode}</div>
        </div>
        <div class="overlay"></div>
    </section>
    <div class="body_homecontainer">
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
                            <a href="#" title="{$title_cat}">{$title_cat} {$core->get_Lang("Packages")}</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </section>
        {$core->getBlock("block_list_cruise")}
        {$core->getBlock("cruise_recently_viewed")}
        {$core->getBlock('2024_review_customer')}
    </div>
</main>
