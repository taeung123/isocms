{assign var=title_combo value=$clsCombo->getTitle($combo_id)}
{assign var = _Inclusion value = $clsCombo->getInclusion($combo_id)}
{assign var = _ApplyConditions value = $clsCombo->getApplyConditions($combo_id)}
{assign var = _Note value = $clsCombo->getNote($combo_id)}
<div class="page_container DetailCombo ComboDefault">
	{$core->getBlock('box_slider_combo_detail')}
	<nav class="breadcrumb-main bg-default breadcrumb-more bg_fff">
		<div class="container">
			<ol class="breadcrumb hidden-xs bg_fff" itemscope itemtype="https://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$PCMS_URL}">
						<span itemprop="name">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="hidden-xs">
					<a itemprop="item" href="{$curl}" title="{$core->get_Lang('Combo')}">
						<span itemprop="name" >{$core->get_Lang('Combo')}</span>
					</a>
					<meta itemprop="position" content="2" />
				</li>
				
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="active">
					<a itemprop="item" href="javascript:void(0);" title="{$title_combo}">
						<span itemprop="name">{$title_combo}</span>
					</a>
					<meta itemprop="position" content="3" />
				</li>
			</ol>
		</div>
	</nav>
	<main class="pageDetail ComboDetail">
		<div class="container">
			<div class="tour__content">
				<div class="row">
					<div class="col-md-8 col-xs-12">
						<h1 class="title">{$title_combo}</h1>
						<div class="duration_tour">
							{assign var=getTripDuration value=$clsCombo->getTripDuration2019($combo_id,'')}
							{assign var=address value=$clsCombo->getLCityAround2($combo_id)}
							{if $getTripDuration}
							<div class="duration"><i class="ico ico-clock-2"></i> {$core->get_Lang('Thời lượng')}: <span class="text_bold">{$getTripDuration}</span></div>
							{/if}
							{if $address}
							<div class="destination"><i class="ico ico-des-2"></i> {$core->get_Lang('Destination')}: <span class="text_bold">{$address}</span></div>
							{/if}
						</div>
		
						<div class="box_highlight tinymce_Content">
						{$clsCombo->getHighlight($combo_id)}
						</div>
						
						<div class="mt10"><a href="javascript:void(0)" class="more_intro">{$core->get_Lang('Xem thêm')}</a></div>
						{literal}
						<script type="text/javascript">
							document.addEventListener("DOMContentLoaded", function () {
								$(function(){
									if($(".overview_tour").height()>145){
										$(".overview_tour").css("height","145px");
										$(".more_intro").show();	
									}else
										$(".more_intro").hide();	
									$(document).on("click",".more_intro",function(){
										var $_this = $(this);
										if(!$_this.hasClass("less")){
											$_this.addClass("less");
											$_this.closest(".tour__content").find(".overview_tour").css("height","auto");	
											$_this.html('{/literal}{$core->get_Lang("Thu gọn")}{literal}');
										}
										else{
											$_this.removeClass("less");
											$_this.closest(".tour__content").find(".overview_tour").css("height","145px");	
											$_this.html('{/literal}{$core->get_Lang("Xem thêm")}{literal}');	
										}
									});	
								});
							})
						</script>
						{/literal}
						{if $_Inclusion || $_Note ||$_ApplyConditions}
						<div class="box_content box_content_detail">
							{if $_Inclusion}
							<h2 class="title_detail_box mb20">{$core->get_Lang('Inclusions Combo')}</h2>
							<div class="inclusion_box tinymce_Content mb40">
							{$_Inclusion}
							</div>
							{/if}
							{if $_Note}
							<h2 class="title_detail_box mb20">{$core->get_Lang('Special notes')}</h2>
							<div class="special_note_box tinymce_Content mb40">
							{$_Note}
							</div>
							{/if}
							{if $_ApplyConditions}
							<h2 class="title_detail_box mb20">{$core->get_Lang('Conditions apply')}</h2>
							<div class="condition_apply_box tinymce_Content">
							{$_ApplyConditions}
							</div>
							{/if}
						</div>
						{/if}
						{if $list_hotel}
						<div class="combo_hotel_box box_content_detail">
							<h2 class="title_detail_box mb20">{$core->get_Lang('Khách sạn - chỗ nghỉ')}</h2>
							<div class="map_hotel_box">
								<div class="google_map_box">
									{$core->getBlock('Lbox_map_combo')}
								</div>
								<div class="hotel_box">
									{foreach from=$list_hotel key=k item=v}
									<div class="hotel_item" data-title="{$clsHotel->getTitle($k)}" data-map_la="{$clsHotel->getMapLa($k)}" data-map_lo="{$clsHotel->getMapLo($k)}">
										<h3>{$clsHotel->getTitle($k)}</h3>
										<p class="star_hotel"><img src="{$clsHotel->getHotelStar($k)}" alt="star"/></p>
										<p class="address_hotel">
											<i class="fa fa-map-marker" aria-hidden="true"></i> {$clsHotel->getAddress($k)}
										</p>
									</div>
									{/foreach}
								</div>
							</div>
						</div>
						{/if}
						{if $clsISO->getCheckActiveModulePackage($package_id,'reviews','default','default','voucher')}
						<div id="reviews" class="review box_content_detail">
							<h2 class="title_detail_box">{$core->get_Lang('Reviews')}</h2>
							{if $clsISO->getCheckActiveModulePackage($package_id,'member','default','default')}
							{$core->getBlock('review_combo')}
							{else}
							{$core->getBlock('review_Star_No_Login')}
							{/if}
						</div>
						{/if}
					</div>
					<div class="col-md-4 col-xs-12">
						<div class="info_combo_price_book">
							<p class="duration">{$getTripDuration} {$core->get_Lang('price from')}</p>
							<p class="price_per_person"><span id="price_per_person_html">407.745</span> <u>đ</u>/{$core->get_Lang('person')}</p>
							<div class="time_left">
								<p class="time_left_text">{$core->get_Lang('Time left')}</p>
								<p class="time_left_day">{$core->get_Lang('Còn')} 77 {$core->get_Lang('Days')}</p>
							</div>
							<div class="check_price_box">
								<div class="check_in_out_box">
									<input class="input_check_date" id="check_in" value="{$check_in}" />
									<input class="input_check_date" id="check_out" value="{$check_out}" />
								</div>
							</div>
							<div class="info_room">
								<div class="info_line info_line_room">
									<div class="info_text">
										<p class="text">{$core->get_Lang('Rooms')}</p>
										<p class="room_type">Standard Room</p>
									</div>
									<div class="info_control">
									<span class="minus control"><i class="ico ico-minus"></i></span>
									<span class="number">1</span>
									<input type="hidden" id="number_room" value="1">
									<span class="plus control"><i class="ico ico-plus"></i></span>
									</div>
								</div>
								<div class="info_line">
									<div class="info_text">
										<p class="text">{$core->get_Lang('Adults')}</p>
									</div>
									<div class="info_control">
									<span class="minus control"><i class="ico ico-minus"></i></span>
									<span class="number">2</span>
									<input type="hidden" id="number_adult" value="2">
									<span class="plus control"><i class="ico ico-plus"></i></span>
									</div>
								</div>
								<div class="info_line">
									<div class="info_text">
										<p class="text">{$core->get_Lang('Child')}</p>
									</div>
									<div class="info_control">
									<span class="minus control"><i class="ico ico-minus"></i></span>
									<span class="number">0</span>
									<input type="hidden" id="number_adult" value="0">
									<span class="plus control"><i class="ico ico-plus"></i></span>
									</div>
								</div>
								<div class="info_line_price">
									<span class="total_text">{$core->get_Lang('Total')}</span>
									<span class="price"><span id="total_price">815.585</span> <u>{$clsISO->getShortRate()}</u></span>
								</div>
								<div class="info_line_button">
									<a class="btn_main" id="book_now_combo" title="{$core->get_Lang('Book now')}">{$core->get_Lang('Book now')}</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="why_with_us_box">
			<div class="container">
				<h2 class="title">isoCMS luôn là lựa chọn lý tưởng</h2>
				<div class="why_with_us_list">
					<div class="row">
						<div class="col-md-4">
							<div class="why_with_us_item">
								<div class="icon">
									<img src="{$URL_IMAGES}/why_icon/icon1.png" />
								</div>
								<h3 class="intro">
								Lleva una mochila con snacks y agua para todo un día de excursión. Y si tienes binoculares no olvides
								</h3>
							</div>
						</div>
						<div class="col-md-4">
							<div class="why_with_us_item">
								<div class="icon">
									<img src="{$URL_IMAGES}/why_icon/icon2.png" />
								</div>
								<h3 class="intro">
								Lleva una mochila con snacks y agua para todo un día de excursión. Y si tienes binoculares no olvides
								</h3>
							</div>
						</div>
						<div class="col-md-4">
							<div class="why_with_us_item">
								<div class="icon">
									<img src="{$URL_IMAGES}/why_icon/icon3.png" />
								</div>
								<h3 class="intro">
								Lleva una mochila con snacks y agua para todo un día de excursión. Y si tienes binoculares no olvides
								</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div>
		{$core->getBlock('relatecombo')}
		</div>
	</main>
</div>
<script>
	var number_day ='{$number_day}';
</script>
{literal}
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$(function() {
			$("#check_in").datepicker({               
				dateFormat: 'dd/mm/yy',
				numberOfMonths: 1,
				autoclose: true,
				minDate: "+0D", maxDate: "+1Y",
				onClose: function(dateStr){
				var date = $(this).datepicker('getDate'); 
					if(date){ 
						date.setDate(date.getDate() + number_day); 
					}
					$("#check_out").datepicker('option',{minDate: date}).datepicker('setDate',date);
				}
			});
			$("#check_out").datepicker({               
				dateFormat: 'dd/mm/yy',
				numberOfMonths: 1,
				minDate: new Date(), maxDate: "+1Y",
			});
			$('.minus').click(function () {
				var $input = $(this).parent().find('input');
				var $number_html = $(this).parent().find('.number');
				var minus = parseInt($input.val()) - 1;
				minus = minus < 1 ? 0 : minus;
				$input.val(minus);
				$number_html.html(minus);
				$input.change();
				return false;
			});
			$('.plus').click(function () {
				var $input = $(this).parent().find('input');
				var $number_html = $(this).parent().find('.number');
				var plus = parseInt($input.val()) + 1;
				$input.val(plus);
				$number_html.html(plus);
				$input.change();
				return false;
			});
			
		});
	})
</script>
{/literal}