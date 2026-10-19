{if $clsISO->getCheckActiveModulePackage($package_id,'page','about','default')}
    <div class="page_container bg_fff">
        <section class="banner_box_2019" style="background:url('{$clsConfiguration->getImage('site_about_page_banner',1600,330)}') no-repeat center center; background-size:cover">
            <div class="bg_opacity"></div>
            <div class="content_banner_box">
                <h1 class="title_banner_box">{$core->get_Lang('About Us')}</h1>
                {assign var = SiteIntroBannerAbout value = SiteIntroBannerAbout_|cat:$_LANG_ID}
                <div class="intro_banner_box">
                    {$clsConfiguration->getValue($SiteIntroBannerAbout)|html_entity_decode}
                </div>
            </div>
        </section>
        <div class="aboutPage_2019" id="content_page">
            <div class="box_about_page_2019 box_number_year">
                <div class="container">
                    <div class="row">
                        {assign var = Site_Title_Our_Mission value = Site_Title_Our_Mission_|cat:$_LANG_ID}
                        {assign var = Site_Intro_Our_Mission value = Site_Intro_Our_Mission_|cat:$_LANG_ID}
                        {assign var = Site_Title_Our_Vission value = Site_Title_Our_Vission_|cat:$_LANG_ID}
                        {assign var = Site_Intro_Our_Vission value = Site_Intro_Our_Vission_|cat:$_LANG_ID}
                        <div class="col-md-6">
                            <article class="content_box">
                                <div class="mission_content mb30">
                                    <h2 class="h2_title">{$core->get_Lang('Our Mission')}</h2>
                                    <p class="title size22">{$clsConfiguration->getValue($Site_Title_Our_Mission)}</p>
                                    <div class="intro">{$clsConfiguration->getValue($Site_Intro_Our_Mission)|html_entity_decode}</div>
                                </div>
                            </article>
                        </div>
                        <div class="col-md-6">
                            <article class="content_box">
                                <div class="vission_content">
                                    <h2 class="h2_title">{$core->get_Lang('Our Vission')}</h2>
                                    <p class="title size22">{$clsConfiguration->getValue($Site_Title_Our_Vission)}</p>
                                    <div class="intro">{$clsConfiguration->getValue($Site_Intro_Our_Vission)|html_entity_decode}
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
            <section class="box_about_page_2019 box_reason">
                <div class="container">
                    {*<h2 class="h2_title text_center mb40">{$core->get_Lang('Top 3 Reasons to Choose Us')}</h2>*}
                    <div class="row">
                        {section name=i loop=$listReasons max=3}
                            {assign var=title_reason value=$clsYearJourney->getTitle($listReasons[i].year_journey_id,$listReasons[i])}
                            <div class="col-md-4">
                                <article>
                                    <div class="reason_item">
                                        <div class="photo">
                                            <img class="img100 lazy height-auto" src="{$URL_IMAGES}/pixel.png" data-src="{$clsYearJourney->getImage($listReasons[i].year_journey_id,334,222,$listReasons[i])}" alt="{$title_reason}"/>
                                        </div>
                                        <div class="reason_body">
                                            <h3><i class="icon"><img class="img100 lazy" src="{$URL_IMAGES}/pixel.png" data-src="{$clsYearJourney->getIcon($listReasons[i].year_journey_id,$listReasons[i])}" alt="" /></i>{$title_reason}</h3>
                                            <div class="intro">
                                                {$clsYearJourney->getIntro($listReasons[i].year_journey_id,$listReasons[i])}
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        {/section}
                    </div>
                </div>
            </section>
            <section class="box_about_page_2019 box_year_journey">
                <div class="container">
                    <h2 class="h2_title text_center mb40">{$core->get_Lang('Journey and development')}</h2>
                    <div class="list_year_journey">
                        {section name=i loop=$listYearJourney}
                            {assign var=year_journey_id value=$listYearJourney[i].year_journey_id}
                            <div class="item item_{$smarty.section.i.iteration}">
                                {*<span class="icon"><img class="img100 lazy height-auto" src="{$URL_IMAGES}/pixel.png" data-src="{$clsYearJourney->getImageUrl($year_journey_id,$listYearJourney[i])}" alt="{$clsYearJourney->getTitle($year_journey_id,$listYearJourney[i])}" /></span>*}
                                <div class="body">
                                    <p class="number_year">{$clsYearJourney->getTitle($year_journey_id)}</p>
                                    {assign var=introYearJourney value= $clsYearJourney->getIntro($year_journey_id,$listYearJourney[i])}
                                    {if $introYearJourney ne ''}
                                        <div class="intro">{$introYearJourney|strip_tags}
                                            <span class="angle"><i class="fa fa-caret-right" aria-hidden="true"></i></span>
                                        </div>
                                    {/if}
                                </div>
                            </div>
                        {/section}
                    </div>
                    {if $totalRecord gt $recordPerPage}
                        <div class="view_more_year_journeyp" style="clear: both;margin-top: 10px">
                            <a href="javascript:void(0);" page="1" rel="nofollow" _type="TopTrip" class="show-loader btn_view_more" id="show-more-year-journeyp" title="{$core->get_Lang('View more')}">{$core->get_Lang('View more')}</a>
                        </div>
                    {/if}
                </div>
            </section>
            {*<section class="box_about_page_2019 box_download" style="background: url('{$clsConfiguration->getImage('site_about_page_bg_download',1600,325)}'); background-size:cover; background-position:center center; background-repeat:no-repeat;">
                <div class="container">
                    <div class="content_box">
                        <h2>{$core->get_Lang('WE BRING YOU THE BEST SERVICE')}!</h2>
                        {assign var = about_page_file_download value = about_page_file_download_|cat:$_LANG_ID}
                        {if $clsConfiguration->getValue($about_page_file_download)}
                        <div class="btn_download">
                            <a href="{$clsConfiguration->getValue($about_page_file_download)}" target="_blank" title="{$core->get_Lang('DOWNLOAD OUR PROFILE')}">{$core->get_Lang('DOWNLOAD OUR PROFILE')}</a>
                        </div>
                        {/if}
                    </div>
                </div>
            </section>*}
            <div class="box_subscribe_page" style="background: url('{$clsConfiguration->getImage('site_about_page_bg_download',1600,325)}'); background-size:cover; background-position:center center; background-repeat:no-repeat;height: 325px">
                {$core->getBlock('subscribeHomePage')}
            </div>

        </div>
    </div>
{literal}
    <style>
        .footer {

        }
    </style>
{/literal}
{else}
    <div class="page_container">
        {assign var=itemPage value=$clsPage->getOne($page_id,'title,intro')}
        {assign var=titlePage value=$itemPage.title}
        {assign var=introPage value=$clsPage->getIntro($page_id,$itemPage)}
        <nav class="breadcrumb-main bg_fff">
            <div class="container">
                <div class="row">
                    <div class="col"></div>
                    <div class="col-md-8">
                        <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="http://schema.org/BreadcrumbList">
                            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                                <a itemtype="http://schema.org/Thing" itemscope itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
                                    <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
                                <meta itemprop="position" content="1" />
                            </li>
                            <li  itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="current">
                                <a itemtype="http://schema.org/Thing" itemscope itemprop="item" href="{$curl}" title="{$titlePage}">
                                    <span itemprop="name" class="reb">{$titlePage}</span></a>
                                <meta itemprop="position" content="2" />
                            </li>
                        </ol>
                    </div>
                    <div class="col"></div>
                </div>
            </div>
        </nav>
        <section class="aboutPage whyPage">
            <div class="container ">
                <div class="row">
                    <div class="col"></div>
                    <div class="col-md-8">
                        <div class="Aboutcontent">
                            <h1 class="titlePage">{$titlePage}</h1>
                            <div class="tinymce_Content">{$introPage}</div>
                        </div>
                    </div>
                    <div class="col"></div>
                </div>
            </div>
        </section>
    </div>
{/if}
<script>
    var totalRecord='{$totalRecord}';
    var $pageLastest = 1;
    var $_LANG_ID = '{$_LANG_ID}';
</script>
{literal}
    <script >
        $(function(){
            $(document).on('click', "#show-more-year-journeyp", function(ev) {
                var $_this = $(this);
                $_this.find('.ajax-loader').show();
                $pageLastest++;
                $.ajax({
                    type:'POST',
                    url:path_ajax_script+'/index.php?mod=about&act=ajload_list_year_journey&lang='+LANG_ID,
                    data:{
                        "page":$pageLastest,
                    },
                    dataType:'html',
                    success:function(html){
                        $_this.find('.ajax-loader').hide();
                        $('.list_year_journey').append( html );
                    }
                });
                setInterval(function(){
                    loadPageShowMore2();
                },100);
            });
        });
        function loadPageShowMore2($number_per_page){
            var $number_show = $('.list_year_journey .item:visible').size();
            if($number_show >= totalRecord){
                $('.view_more_year_journeyp').remove();
            }
        }

    </script>
{/literal}