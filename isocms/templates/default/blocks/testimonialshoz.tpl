<div class="testimonial">
	<div class="container">							
		<div class="rslides" id="testimonial_Container">
			{section name=i loop=$listTestimonial}
			{assign var=titletestimonial value=$clsTestimonial->getTitle($listTestimonial[i].testimonial_id)}
			<div class="tesItem"  id="TEST-{$smarty.section.i.index}" {if !$smarty.section.i.first}style="display:none"{/if} >
			   <a class="photo" href="{$clsTestimonial->getLink($listTestimonial[i].testimonial_id)}" title="{$titletestimonial}">
				  <img src="{$clsTestimonial->getImage($listTestimonial[i].testimonial_id,600,400)}" alt="{$titletestimonial}" width="100" height="100" /></a>   
				 <div class="body" ><i class="before"></i>
					<p class="title">{$titletestimonial}</p>
					<p class="intro">{$clsTestimonial->getIntro($listTestimonial[i].testimonial_id)|strip_tags|truncate:150}
					<i class="after"></i></p>
					<p class="author">{$clsTestimonial->getName($listTestimonial[i].testimonial_id)}</p>
					<p class="city">{$clsTestimonial->getCountry($listTestimonial[i].testimonial_id)}</p>
				 </div>
			 </div>
		 {/section}
		</div>
		<div class="clearfix"></div>
		<div class="testimonial_pager">
			<ul>
				{section name=i loop=$lstTestimonial}
				<li class="slide-pager-slot{if $smarty.section.i.first} current{/if}">{$smarty.section.i.index+1}</li>
				{/section}
			</ul>
		</div>
	</div>	
	<!-- Script Testimonial -->
	{literal}
	<script type="text/javascript">
		$(function(){
			$('#testimonial_Container');				
			setInterval(function(){
				var $_cu = $('.tesItem:visible').attr('id');
				var $_s = $_cu.split('-');
				var $_c = parseInt($_s[1]);
				$_c = $_c +1;
				$('.slide-pager-slot.current').removeClass('current');
				if($_c==$('.tesItem').size()){
					$('.tesItem:visible').fadeOut();
					$('#TEST-0').fadeIn();
					$('.slide-pager-slot:eq(0)').addClass('current');
					$_c==0;
				}else{
					$('.tesItem:visible').fadeOut();
					$('#TEST-'+$_c).fadeIn();
					$('.slide-pager-slot:eq('+$_c+')').addClass('current');
				}
			},4000);
		});
	</script>
	{/literal}					
</div>