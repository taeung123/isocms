<link rel="stylesheet" href="{$URL_CSS}/homestore.css?v={$upd_version}"/>
<header id="header" class="header2020">
	<div class="header__desktop hidden1024">
			<div class="hr-top">
				<div class="container">
					<div class="hr-top-content">
					<div class="top-hr-support">
							<span class="hr-info"><i class="fa fa-envelope-o" aria-hidden="true"></i> contact@insolitevoyage.com</span>
							<span class="hr-contact"><i class="fa fa-phone" aria-hidden="true"></i> {$core->get_Lang('Hotline')}: +0386782014 </span>
						</div>
						<div class="top-hr-list">
							<span class="item tutorial">{$core->get_Lang('Hướng dẫn mua hàng')}</span>
							<span class="item contact">{$core->get_Lang('Hướng dẫn mua hàng')}</span>
							<div class="item top-hr-dropdown">
							  <div class="dropdown show">
								  <a class="btn btn-secondary dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									{$core->get_Lang('Xem thêm')} <i class="fa fa-caret-down" aria-hidden="true"></i>
								  </a>
								  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item" href="#">Action</a>
									<a class="dropdown-item" href="#">Another action</a>
									<a class="dropdown-item" href="#">Something else here</a>
								  </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
			<div class="hr-main">
				<div class="header__desktop--left">
					{if $mod eq 'home'}
					<h1 id="logo">{$PAGE_NAME}
						<a  title ="{$PAGE_NAME}" class="navbar-brand" href="{$DOMAIN_NAME}{$extLang}">
							<img alt="{$PAGE_NAME}" src="{$URL_IMAGES}/image_store/logo_shop365.jpg" class="img100"/>
						</a>
					</h1>
					{else}
					<p id="logo">
						<a title ="{$PAGE_NAME}" class="navbar-brand" href="{$DOMAIN_NAME}{$extLang}">
							<img alt="{$PAGE_NAME}" src="{$URL_IMAGES}/image_store/logo_shop365.jpg" class="img100"/>
						</a>
					</p>
					{/if}
					<div class="search">
						<form class="form_search form_box_search_header" method="post" action="">
							<input type="text" name="keyword" value="" class="input_search form-control input_search_header" placeholder="Search">
							<button type="submit" class="search_btn"><i class="fa fa-search" aria-hidden="true"></i></button>
							<input type="hidden" name="header_Search" value="header_Search">
						</form>
					</div>
				</div>
				<div class="header__desktop--right">
					<ul class="hr-ul-right">
						<li>
							<a class="favourite" rel="nofollow" href="" target="_blank" title="{$core->get_Lang('Đăng nhập Đăng ký')}">
								<img class="img100" src="{$URL_IMAGES}/image_store/icon_like.jpg" alt>
								<div class="body">
									<span class="number">0</span>
									<span>{$core->get_Lang('Yêu thích')}</span>
								</div>
							</a>
						</li>
						<li>
							<a class="cart" rel="nofollow" href="" target="_blank" title="{$core->get_Lang('Đăng nhập Đăng ký')}">
								<img class="img100" src="{$URL_IMAGES}/image_store/cart.jpg" alt>
								<div class="body">
									<span class="number">0</span>
									<span>{$core->get_Lang('Giỏ hàng')}</span>
								</div>
							</a>
						</li>
						<li>
							<a class="login" rel="nofollow" href="" target="_blank" title="{$core->get_Lang('Đăng nhập Đăng ký')}">
									<img class="img100" src="{$URL_IMAGES}/image_store/icon_login.jpg" alt>
								<div class="body">
									<span>{$core->get_Lang('Đăng nhập Đăng ký')} <i class="fa fa-caret-down" aria-hidden="true"></i></span>
								</div>
							</a>
						</li>
						
            		</ul>
				</div>
			
			</div>
			</div>
	</div>
</header>
<main id="main" class="page_container">
	<div class="container">
		<div class="main-content">
			<div class="BoxContentTop">
				<div class="main-menu">
					<h2 class="menu-title">
						<i class="fa fa-list-ul" aria-hidden="true"></i> {$core->get_Lang('Danh mục sản phẩm')}
					</h2>
					<ul class="menu-ul">
						<li><a href="#" title="">
							<img class="img100" src="{$URL_IMAGES}/image_store/icon_start.jpg" alt="">
							{$core->get_Lang('Khuyến mãi')}
						
						</a></li>
						<li><a href="#" title="">
						<img class="img100" src="{$URL_IMAGES}/image_store/icon_start.jpg" alt="">
						{$core->get_Lang('Giày bé trai')}
						</a></li>
						<li><a href="#" title="">
						<img class="img100" src="{$URL_IMAGES}/image_store/icon_start.jpg" alt="">
						{$core->get_Lang('Giày bé gái')}</a></li>
						<li><a href="#" title="">
						<img class="img100" src="{$URL_IMAGES}/image_store/icon_start.jpg" alt="">
						{$core->get_Lang('Đồ chơi cho bé')}</a></li>
						<li><a href="#" title="">
						<img class="img100" src="{$URL_IMAGES}/image_store/icon_start.jpg" alt="">
						{$core->get_Lang('Balo - Túi - Cặp')}</a></li>
						<li><a href="#" title="">
						<img class="img100" src="{$URL_IMAGES}/image_store/icon_start.jpg" alt="">
						{$core->get_Lang('Cho bé mặc')}</a></li>
						<li><a href="#" title="">
						<img class="img100" src="{$URL_IMAGES}/image_store/icon_start.jpg" alt="">
						{$core->get_Lang('Cho bé ngủ')}</a></li>
						<li><a href="#" title="">
						<img class="img100" src="{$URL_IMAGES}/image_store/icon_start.jpg" alt="">
						{$core->get_Lang('Cho bé đi chơi')}</a></li>
					</ul>
				</div>
				<div class="main-hot-news">
					<ul class="horizontal-menu">
						<li><a href="" title="">Giày dép</a></li>
						<li><a href="" title="">Đồ chơi</a></li>
						<li><a href="" title="">Trợ giúp</a></li>
						<li><a href="" title="">Sản phẩm mới</a></li>
						<li><a href="" title="">Giờ vàng giá shock</a></li>
						<li><a href="" title="">Cách chọn đồ chơi</a></li>
					</ul>
					<div class="hot-news">
						<div class="slider-hot-news">
							<div class="owl-carousel" id="owl-hot-news">
								<div class="item">
									<img class="img100" src="{$URL_IMAGES}/image_store/image_slide.jpg" alt="">
								</div>
							</div>
						</div>
						<div class="list-image">
							<div class="item-image">
								<img class="img100" src="{$URL_IMAGES}/image_store/image_slide.jpg" alt="">
							</div>
							<div class="item-image">
								<img class="img100" src="{$URL_IMAGES}/image_store/image_slide.jpg" alt="">
							</div>
							<div class="item-image">
								<img class="img100" src="{$URL_IMAGES}/image_store/image_slide.jpg" alt="">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="BoxAdvertisement">
				<div class="owl-carousel" id="owl-advertisement">
					<div class="item">
						<img class="img100" src="{$URL_IMAGES}/image_store/image_slide.jpg" alt="" style="height: 200px">
					</div>
					<div class="item">
						<img class="img100" src="{$URL_IMAGES}/image_store/image_slide.jpg" alt="" style="height: 200px">
					</div>
					<div class="item">
						<img class="img100" src="{$URL_IMAGES}/image_store/image_slide.jpg" alt="" style="height: 200px">
					</div>
				</div>
			</div>
			<div class="BoxNewProduct">
				<h2 class="text-upp">{$core->get_Lang('Sản phẩm mới')}</h2>
				<div class="list-product">
					<div class="owl-carousel" id="owl-product">
					{section name=i loop=6}
						<div class="item">
							<a class="photo" href="#" title="">
								<img class="img100" src="{$URL_IMAGES}/image_store/image_slide.jpg" alt="" style="height: 220px">
							</a>
							<div class="body">
								<h3 class="title-item">Thú nhồi bông voi con</h3>
								<p class="price-item">115.000đ</p>
							</div>
						</div>
					{/section}
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
{literal}
<script >
	document.addEventListener("DOMContentLoaded", function () {
		if($('#owl-hot-news').length > 0){
		var $owl = $('#owl-hot-news');
		$owl.owlCarousel({
			loop:false,
			nav: true,
			lazyLoad:true,
			dots:false,
			navText:'',
			autoplay:false,
			responsiveClass:true,
			responsive:{
				0:{
					items:1,
				},
				1200:{
					items:1,
				}
			}
		});
	};
		
	if($('#owl-advertisement').length > 0){
			var $owl = $('#owl-advertisement');
			$owl.owlCarousel({
				loop:false,
				nav: true,
				lazyLoad:true,
				dots:false,
				navText:'',
				margin:12,
				autoplay:false,
				responsiveClass:true,
				responsive:{
					0:{
						items:3,
					},
					1200:{
						items:3,
					}
				}
			});
		};
	if($('#owl-product').length > 0){
	var $owl = $('#owl-product');
	$owl.owlCarousel({
		loop:false,
		nav: true,
		lazyLoad:true,
		dots:false,
		navText:'',
		margin:17,
		autoplay:false,
		responsiveClass:true,
		responsive:{
			0:{
				items:5,
			},
			1200:{
				items:5,
			}
		}
	});
	};
	var $ww = $(window).width();	
	$(window).scroll(function(){
	var sticky = $('#header');
	scroll = $(window).scrollTop();
	if (scroll >= 200){
		sticky.addClass('fixed');
	}
	else{
		sticky.removeClass('fixed');
	}
	});
	})
</script> 
{/literal}