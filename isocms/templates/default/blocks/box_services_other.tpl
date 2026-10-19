<section class="section_box orther_services">
	<div class="attractive_tour--header header__content">
		<div class="container">
			<h2 class="section_box-title">{$core->get_Lang('Discover other services')}</h2>
		</div>
	</div>				
	<div class="attractive_tour--content">
		<div class="container">
			<div class="list_services owl-carousel">
				<div class="box_services" data-dot="<button>1</button>">
					<div class="box_img">
						<a href="{$clsISO->getLink('hotel')}" title="{$core->get_Lang('Stay')}" class="link_services"><img src="{$URL_IMAGES}/img_isocms/img_stay.png" width="405" height="300" alt="{$core->get_Lang('Stay')}" class="img_services"></a>
					</div>
					<div class="content_services">
						<div class="content_top">
							<a href="{$clsISO->getLink('hotel')}" title="{$core->get_Lang('Stay')}" class="link_services">
								<h3 class="title_serv">{$core->get_Lang('Stay')}</h3>
								<p class="desp_serv">Thoải mái bằng sau ngày dài bận rộn, vất vả</p>
							</a>
						</div>
						<div class="desp_bot"><a href="{$clsISO->getLink('hotel')}" class="view_detail">Khám phá thêm</a></div>
					</div>
				</div>
				<div class="box_services" data-dot="<button>2</button>">
					<div class="box_img">
						<a href="{$clsISO->getLink('cruise')}" title="{$core->get_Lang('Cruise')}" class="link_services"><img src="{$URL_IMAGES}/img_isocms/img_cruise.png" width="405" height="300" alt="{$core->get_Lang('Cruise')}" class="img_services"></a>
					</div>
					<div class="content_services">
						<div class="content_top">
							<a href="{$clsISO->getLink('cruise')}" title="{$core->get_Lang('Cruise')}" class="link_services">
								<h3 class="title_serv">{$core->get_Lang('Cruise')}</h3>
								<p class="desp_serv">Thoải mái bằng sau ngày dài bận rộn, vất vả</p>
							</a>
						</div>
						<div class="desp_bot"><a href="{$clsISO->getLink('cruise')}" class="view_detail">Khám phá thêm</a></div>
					</div>
				</div>
				<div class="box_services" data-dot="<button>3</button>">
					<div class="box_img">
						<a href="{$clsIso->getLink('voucher')}" title="{$core->get_Lang('Voucher')}" class="link_services"><img src="{$URL_IMAGES}/img_isocms/img_voucher.png" width="405" height="300" alt="{$core->get_Lang('Voucher')}" class="img_services"></a>
					</div>
					<div class="content_services">
						<div class="content_top">
							<a href="{$clsIso->getLink('voucher')}" title="{$core->get_Lang('Voucher')}" class="link_services">
								<h3 class="title_serv">{$core->get_Lang('Voucher')}</h3>
								<p class="desp_serv">Thoải mái bằng sau ngày dài bận rộn, vất vả</p>
							</a>
						</div>
						<div class="desp_bot"><a href="{$clsIso->getLink('voucher')}" class="view_detail">Khám phá thêm</a></div>
					</div>
				</div>
			</div>
		</div>

	   </div>
</section>
{literal}
	<script>
		$(function(){
			$('.list_services').owlCarousel({
				loop:true,
				responsiveClass:true,
				responsive:{
					0:{
						items:1,
						margin:0,
						dot:true,
						dotsData: true,
					},
					600:{
						items:2,
						margin:20,
						dot:true,
						dotsData: true,
					},
					1000:{
						items:3,
						nav:true,
						loop:false,
						margin:32,
					},
				}
			})
		});
	</script>
{/literal}