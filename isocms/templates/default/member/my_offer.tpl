<div class="page_container">
	<nav class="breadcrumb-main  breadcrumb-cruise bg-default breadcrumb-more bg_fff">
		<div class="container">
			<ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="http://schema.org/BreadcrumbList">
			   <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				   <a itemtype="http://schema.org/Thing" itemprop="item" href="{$PCMS_URL}">
					   <span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
			   <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				   <a itemtype="http://schema.org/Thing" itemprop="item" href="{$curl}" title="{$core->get_Lang('My Offer')}" >
					   <span itemprop="name" class="reb">{$core->get_Lang('My Offer')}</span></a>
					<meta itemprop="position" content="2" />
				</li>
			</ol>
		</div>
	</nav>
	<div id="contentPage" class="pageMyOffer pd40_0">
		<div class="container">
			<div class="content-info">
				<div class="row">
					{$core->getBlock('box_member_link')}
					<div class="col-lg-9 col-xs-12 tabs_content pl0" id="lstTabs" style="border:0 !important">
					<div class="contentTab" style="display:block">
						<div class="wishlist-media">
							<h1 class="title24">{$core->get_Lang('My Offers &amp; Discounts')} <span></span></h1>
							<div>{$core->get_Lang('Sorry, but there are no offers available at this time')}.</div>
						</div>
					</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
{literal}
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$(document).ready(function(){	
			$('.fileinput-exists').click(function(){
				$('.btn-update').show();
			});
			$('.it-head-iti').click(function(){
				$(this).find('.fa-dropdown').toggleClass('fa-angle-up');
				$(this).next().slideToggle();
			});
		}); 
	})
</script>
{/literal}
