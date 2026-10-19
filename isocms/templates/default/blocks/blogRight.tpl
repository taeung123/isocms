<script type="text/javascript" src="{$URL_JS}/owl/owl.carousel.js?v={$upd_version}"></script>
		<link rel="stylesheet" type="text/css" href="{$URL_JS}/owl/owl.carousel.css?v={$upd_version}"/>

{if $mod eq 'blog'}
{if $lstRelated[0].blog_id}
<div class="clearfix"></div>
<h2 class="title reading">Đọc tiếp</h2>                 
<div class="jcarousel-box owl-carousel" id="jcarousel-tours-Relateds"> 
    {section name=i loop=$lstRelated}
		{assign var=link value=$clsBlog->getLink($lstRelated[i].blog_id)} 
		{assign var=title value=$clsBlog->getTitle($lstRelated[i].blog_id)}
		<div class="h_traveltip_item_fisrt item">
			<a class="h_image" href="{$link}" title="{$title}">
				<img src="{$clsBlog->getImage($lstBlog[i].blog_id,370,220)}" width="370" height="220" alt="" />
			</a>
			<div class="cap1"><a href="{$link}" title="{$title}">{$title}</a></div>
			<div class="cap2">{$clsISO->converTimeToText($lstRelated[i].reg_date)}</div>			
			<div class="cap4">{$clsBlog->getIntro($lstRelated[i].blog_id)|strip_tags|truncate:100}</div>
		</div>
   {/section}   
</div>                
{/if}
{else}
<div class="MR_box" style="margin-top:0">
	<h2 class="hd">{$core->get_Lang('Recent Blogs')}</h2>
    <ul class="MR_box_UL">
        {section name=i loop=$lstBlog}
        {assign var = title value = $clsBlog->getTitle($lstBlog[i].blog_id)}
        <li><a href="{$clsBlog->getLink($lstBlog[i].blog_id)}" title="{$title}"><i class="fa fa-angle-right"></i> {$title}</a></li>
        {/section}
    </ul>
</div>
{/if}
{literal}
	<script type="text/javascript">
	$(function(){
				if($('#jcarousel-tours-Relateds').length > 0){
						var $owl = $('#jcarousel-tours-Relateds');
						$owl.owlCarousel({
								loop:true,
								margin:30,
								responsiveClass:true,
								autoplay:true,
								responsive:{
										0:{
												items:1,
												nav:false
										},
										600:{
												items:2,
												nav:false
										},
										1200:{
												items:3,
												nav:false
										}
								}
						});
						$('#next_1').click(function(){
								$('#jcarousel-tours-slides .owl-next').trigger('click');
						});
						$('#prev_1').click(function(){
								$('#jcarousel-tours-slides .owl-prev').trigger('click');
						});
				}
		});
</script>
{/literal}
