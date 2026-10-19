<div class="page_container">

    <nav class="breadcrumb-main bg_fff">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">

                    <ol
                        class="breadcrumb hidden-xs mt0 bg_fff"
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
                                <span itemprop="name" class="reb">
                                    {$core->get_Lang('Home')}
                                </span>
                            </a>

                            <meta
                                itemprop="position"
                                content="1"
                            />
                        </li>

                        {if $page_id|default:0 gt 0 && $titlePage|default:'' ne ''}
                            <li
                                itemprop="itemListElement"
                                itemscope
                                itemtype="https://schema.org/ListItem"
                                class="current"
                            >
                                <a
                                    itemprop="item"
                                    href="{$curl|default:''|escape:'html'}"
                                    title="{$titlePage|escape:'html'}"
                                >
                                    <span itemprop="name" class="reb">
                                        {$titlePage}
                                    </span>
                                </a>

                                <meta
                                    itemprop="position"
                                    content="2"
                                />
                            </li>
                        {/if}
                    </ol>

                </div>
            </div>
        </div>
    </nav>

    <section class="aboutPage whyPage">
        <div class="container">
            <div class="row">


                    <div class="Aboutcontent">

               {if $page_id|default:0 gt 0}
    <h1 class="titlePage">
        {$titlePage|default:''}
    </h1>

    <div class="tinymce_Content">
        {$introPage|default:''|html_entity_decode}
    </div>
{/if}

                    </div>


            </div>
        </div>
    </section>

</div>

{literal}
<style>
.aboutPage {
    padding: 40px 0;
}

.aboutPage .titlePage {
    margin: 0 0 25px;
}

.aboutPage .tinymce_Content {
    color: #333;
    font-size: 16px;
    line-height: 1.7;
}

.aboutPage .tinymce_Content ul,
.aboutPage .tinymce_Content ol {
    padding-left: 25px;
}

.aboutPage .tinymce_Content li {
    list-style-position: outside;
}

.aboutPage .tinymce_Content ul li {
    list-style-type: disc;
}

.aboutPage .tinymce_Content ol li {
    list-style-type: decimal;
}

.aboutPage .tinymce_Content img {
    max-width: 100%;
    height: auto;
}

.page-not-found {
    padding: 60px 20px;
    text-align: center;
}
</style>
{/literal}