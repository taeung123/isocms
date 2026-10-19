<div class="modal fade in" id="viewphotoModal" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        	{if $mod eq 'tour' and $act eq 'detaildeparture'}
            <div class="modal-body">
                <div id="carousel-view-photo" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                    <div class="m-caption box-hidden">
                        <p class="pull-left">Glory Legend Cruise</p>
                        <div class="numslide pull-right hidden-xs">image 18 of 32</div>
                    </div>
                     {section name=i loop=$lstImage}
                    <div class="bigimage{$smarty.section.i.index} wc-item item {if $smarty.section.i.first}active{/if}" alt="">
                        <img src="{$clsTourImage->getImage($lstImage[i].tour_image_id,822,450)}" alt="">                           
                    </div>
                    {/section}		
                     </div>
                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-view-photo" role="button" data-slide="prev">
                        <span class="fa fa-chevron-left" aria-hidden="true"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-view-photo" role="button" data-slide="next">
                        <span class="fa fa-chevron-right" aria-hidden="true"></span>
                    </a>
                </div>
            </div>
            {else}
            <div class="modal-body">
                <div id="carousel-view-photo" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                    <div class="m-caption box-hidden">
                        <p class="pull-left">Glory Legend Cruise</p>
                        <div class="numslide pull-right hidden-xs">image 18 of 32</div>
                    </div>
                     {section name=i loop=$lstImage}
                    <div class="bigimage{$smarty.section.i.index} wc-item item {if $smarty.section.i.first}active{/if}" alt="">
                        <img src="{$clsCruiseImage->getImage($lstImage[i].cruise_image_id,822,450)}" alt="">                           
                    </div>
                    {/section}		
                     </div>
                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-view-photo" role="button" data-slide="prev">
                        <span class="fa fa-chevron-left" aria-hidden="true"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-view-photo" role="button" data-slide="next">
                        <span class="fa fa-chevron-right" aria-hidden="true"></span>
                    </a>
                </div>
            </div>
            {/if}
        </div>
    </div>
</div>