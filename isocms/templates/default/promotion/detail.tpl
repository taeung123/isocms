<div id="breadcrumb">
    <div class="container">
        <div class="breadcrumb row"> 
            <ul> 
                <li><a href="#" title="{$core->get_Lang('Home')}">{$core->get_Lang('Home')}</a></li> 
                <li> <i class="fa fa-chevron-right"></i> </li>
                <li class="current"><a href="#" title="{$core->get_Lang('Promotions')}">{$core->get_Lang('Promotions')}</a></li> 
            </ul> 
        </div>
    </div>
</div>
<div class="page_container mt110 mb50">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="blogDetail">
                    <h1 class="title">{$clsPromotion->getTitle($promotion_id)}</h1>
                    <div class="format-text">
                    Posted on {$clsISO->converTimeToText($clsPromotion->getOneField('reg_date',$promotion_id))}
                    </div>
                    <div class="formatTextStandard">
                        <h2 class="bio">{$clsPromotion->getIntro($promotion_id)}</h2>
                        {$clsPromotion->getContent($promotion_id)}
                    </div>
                    <div class="share_box">
                        <span class="hr"></span>
                        <div class="addthis">{$core->getBlock('addthis')}</div>
                    </div>
                    {if $lstPromotion[0].promotion_id ne ''}
                    <div class="cat-tours-free" style="overflow:hidden;width:100%">
                        <h2 class="title mt20">{$core->get_Lang('Other promotions')}</h2>
                        {section name=i loop=$lstPromotion}
                        {assign var = link value = $clsPromotion->getLink($lstPromotion[i].promotion_id)}
                        {assign var = title value = $clsPromotion->getTitle($lstPromotion[i].promotion_id)}
                        <div class="hotels-product mt20">
                            <div class="photo-cat col-md-3">  
                                <a class="photo" href="{$link}" title="{$title}">
                                <img class="img-responsive" src="{$clsPromotion->getImage($lstPromotion[i].promotion_id,174,134)}" alt="{$title}" width="174px" />
                                </a>
                            </div>
                            <div class="formattext-cat col-md-9">
                            	<h2 class="title"><a href="{$link}" title="{$title}">{$title}</a></h2>
                                <div class="destination">
                                <i class="fa fa-clock-o"></i> 
                                {$core->get_Lang('Posted on')} {$clsISO->converTimeToText($lstPromotion[i].reg_date)} 
                                </div>
                            </div>
                            <div class="text-cat">
                                {$clsPromotion->getIntro($lstPromotion[i].promotion_id)|strip_tags|truncate:150}
                                <a href="{$link}" title="{$title}" class="details">{$core->get_Lang('Chi tiết')}</a> 
                            </div>
                        </div>
                        {/section}
                        </div>
                    {/if}
                </div>
            </div>
            <div class="col-md-3">
                {$core->getBlock('toptours')}
                {$core->getBlock('testimonials')}
            </div>
        </div>
    </div>
</div>