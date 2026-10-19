 {if $lstImage}
<section id="silde-photo">
    <div class="silde-photo-head">
        <h2><a href="">Photo</a></h2>
        <div id="relatedBox" class="hotelBox mt40">
            <div class="headBox">
                <div class="control_js fr">
                    <a href="javascript:void(0);" class="prev" id="prev_1"></a>
                    <a href="javascript:void(0);" class="next" id="next_1"></a>
                </div>
            </div>
        </div> 
    </div>                           
    <div class="jcarousel-box owl-carousel" id="jcarousel-tours-slides">
        {section name=i loop=$lstImage}
        <div class="content3-bottom ">
            <ul class="content3-img-top flipInY"> 
                <li class="images images-left">
                	<img src="{$clsTourImage->getImage($lstImage[i].tour_image_id,400,300)}" alt="{$clsTourImage->getTitle($lstImage[i].tour_image_id)}" width="100%" /></li>
            </ul>
        </div>
        {/section}  
    </div>                                     
</section>
{/if}