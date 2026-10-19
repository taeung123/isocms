<script defer type="text/javascript" src="{$URL_JS}/jquery.validate.js?v={$upd_version}"></script>
<link rel="stylesheet" type="text/css" href="{$URL_CSS}/bookingcruise.css?v={$upd_version}">
{assign var=address value=$clsCruiseItinerary->getAllCityAround($ContactCruise.cruise_itinerary_id)}
{assign var=oneCruiseCat value=$clsCruiseCat->getOne($oneCruise.cruise_cat_id,"title,slug")}
<div class="page_container page_book_services">
	<div class="breadcrumb-main">
		<div class="container">
			<ol class="breadcrumb mt0" itemscope itemtype="https://schema.org/BreadcrumbList"> 
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$PCMS_URL}{$extLang}">
						<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
					<meta itemprop="position" content="1" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$clsCruiseCat->getLink($oneCruise.cruise_cat_id,$oneCruiseCat)}" title="{$oneCruiseCat.title}">
						<span itemprop="name" class="reb">{$oneCruiseCat.title}</span> </a>
					<meta itemprop="position" content="2" />
				</li>
				<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
					<a itemprop="item" href="{$curl}" title="{$oneCruise.title}">
						<span itemprop="name" class="reb">{$oneCruise.title}</span> </a>
					<meta itemprop="position" content="3" />
				</li>
			</ol>
		</div>
	</div>
	<div class="container">
		<form class="bk-form-info" id="frmCruiseServices" method="post" action="" novalidate>
			<div class="row">
				<div class="col-lg-8 mx-auto">
					<h1 class="title_page">{$oneCruise.title}</h1>
					<div class="box_cabin_book box_info_cabin_book">
						<h2 class="title_book">{$core->get_Lang('Summary')}</h2>
						<div class="item_book">
							<label for="" class="lbl_item_book">{$core->get_Lang('Itinerary')}:</label>
							<p class="txt_item_book">{$clsCruiseItinerary->getDuration($ContactCruise.cruise_itinerary_id)}</p>
						</div>
						{if $address}
						<div class="item_book">
							<label for="" class="lbl_item_book">{$core->get_Lang('Destination')}:</label>
							<p class="txt_item_book">{$address}</p>
						</div>
						{/if}						
						<div class="item_book">
							<label for="" class="lbl_item_book">{$core->get_Lang('Departing')}:</label>
							<p class="txt_item_book">{$clsISO->converTimeToText5($ContactCruise.departure_date)}</p>
						</div>		
						{if $txt_number_people}
						<div class="item_book">
							<label for="" class="lbl_item_book">{$core->get_Lang('Number people')}:</label>
							<p class="txt_item_book">{$txt_number_people}</p>
						</div>
						{/if}
						<div class="item_book">
							<label for="" class="lbl_item_book">{$core->get_Lang('Cabins')}:</label>
							<div class="txt_item_book">
                                <p>{$clsCruiseCabin->getTitle($ContactCruise.cruise_cabin_id)}</p>
                                {foreach from=$array_bed item=item name=item key=key}
                                <p>- {$core->get_Lang('Cabin')} {$smarty.foreach.item.iteration}: {$item.bed_type} {if $item.is_extra_bed==1} + {$core->get_Lang('Extra Bed')} {/if}</p>
                                {/foreach}
                            </div>
						</div>
					</div>
                    {if $lstService}
					<div class="box_cabin_book box_services_cabin_book">
						<h2 class="title_book">{$core->get_Lang('Addon services')}</h2>
						<div class="list_services_cruise">
							{section name=i loop=$lstService}
                            <div class="item_services d-flex justify-content-between align-items-center">
                                <div class="box_left_services">
                                    <p class="title_services">{$lstService[i].title}</p>
                                </div>
                                <div class="box_right_services">
                                    {if $_LANG_ID eq 'vn'}
                                        <div class="box_price_services">{$clsISO->formatPrice($lstService[i].price)} <span class="price_unit"> {$clsISO->getRate()}</span></div>
                                    {else}
                                        <div class="box_price_services"><span class="price_unit"> {$clsISO->getRate()}</span> {$clsISO->formatPrice($lstService[i].price)}</div>
                                    {/if}
                                    <div class="right__inputTraveller">
                                        <a class="unNum text_main disabled" _type="number_adults" href="javascript:void(0);"></a> 
                                        <input min-number="0" type="number" class="ui-spinner-input input_number find_select"  name="number_service[{$lstService[i].cruise_service_id}]" data-cruise_service_id="{$lstService[i].cruise_service_id}" data-price_service="{$lstService[i].price}" value="0" readonly> 
                                        <a class="upNum text_main" _type="number_adults" href="javascript:void(0);"></a> 
                                    </div>
                                </div>
                            </div>
							{/section}
						</div>
					</div>
                    {/if}
					<div class="box_cabin_book box_servicer_total_price">
						<div class="item_total_price d-flex justify-content-between align-items-center">
							<label for="" class="lbl_total">{$core->get_Lang("Price Cabin")}</label>
                            {if $ContactCruise.total_price_promotion}
							<div class="box_price_services">
								{if $_LANG_ID eq 'vn'}
									{$clsISO->formatPriceText($ContactCruise.total_price_promotion)} <span class="price_unit"> {$clsISO->getRate()}</span>
                                    <input type="hidden" name="total_price_cabin" value="{$ContactCruise.total_price_promotion}">
								{else}
									<span class="price_unit"> {$clsISO->getRate()}</span> {$clsISO->formatPrice2($ContactCruise.total_price_promotion,2)}
                                    <input type="hidden" name="total_price_cabin" value="{$ContactCruise.total_price_promotion|number_format:2:".":""}">
								{/if}								
								
							</div>
                            {else}
                            <div class="box_price_services">
								{$core->get_Lang('Contact')}
                                <input type="hidden" name="total_price_cabin" value="0">
							</div>
                            {/if}
                            
                            <input name="total_number_service" value="0" id="total_number_service" type="hidden" />
                            
                            
						</div>
                        {if $lstService}
						<div class="item_total_price d-flex justify-content-between align-items-center">
							<label for="" class="lbl_total">{$core->get_Lang("Price Service")}</label>
							<div class="box_price_services">
								{if $_LANG_ID eq 'vn'}
									<span id="total_price_service">0</span> <span class="price_unit"> {$clsISO->getRate()}</span>
								{else}
									<span class="price_unit"> {$clsISO->getRate()}</span> <span id="total_price_service">0</span> 
								{/if}
								<input type="hidden" name="total_price_service" value="0">
							</div>
                            
						</div>
						<div class="box_list_service_choose" id="box_list_service_choose">
							
						</div>
                        {/if}
						<div class="box_total_bill">
							<div class="item_total_price d-flex justify-content-between align-items-center">
								<label for="" class="lbl_total">{$core->get_Lang("Price Total")}</label>
                                {if $ContactCruise.total_price_promotion}
								<div class="box_price_services">
									{if $_LANG_ID eq 'vn'}
										<span id="total_price_bill">{$clsISO->formatPriceText($ContactCruise.total_price_promotion)}</span> <span class="price_unit"> {$clsISO->getRate()}</span>
									{else}
										<span class="price_unit"> {$clsISO->getRate()}</span> <span id="total_price_bill">{$clsISO->formatPrice2($ContactCruise.total_price_promotion,2)}</span> 
									{/if}
									<input type="hidden" name="total_price_bill" value="{$ContactCruise.total_price_promotion}">
								</div>
                                {else}
                                <div class="box_price_services">
                                    <span>{$core->get_Lang('Contact')}</span>
									<span id="total_price_bill" class="hidden"></span>
									<input type="hidden" name="total_price_bill" value="{$ContactCruise.total_price_promotion}">
								</div>
                                {/if}
							</div>
						</div>						
					</div>
					<div class="box_submit">
						<button class="btn_submit" type="button">{$core->get_Lang('Continue')}</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	var price_rate = '{$clsISO->getRate()}';
</script>
{literal}
<script>
	document.addEventListener("DOMContentLoaded", function () {
		$(document).on('click','.upNum:not(.disabled)',function() {
			var inputTraveller = $(this).closest(".right__inputTraveller").find("input.input_number");
			var number_person = parseInt(inputTraveller.val());
			var _type=$(this).attr('_type');
			number_person = number_person + 1;
			$(this).closest(".right__inputTraveller").find(".unNum").removeClass("disabled");
			inputTraveller.val(number_person);	
			loadService();
			return false;
		});
		$(document).on('click','.unNum:not(.disabled)',function() {
			var inputTraveller = $(this).closest(".right__inputTraveller").find("input.input_number");
			var number_person = parseInt(inputTraveller.val());
			var min_number = parseInt(inputTraveller.attr('min-number'));
			var _type=$(this).attr('_type');
			number_person = number_person - 1;
			if (number_person <= min_number) {
				$(this).addClass('disabled');
				number_person = min_number;
			}
			$(this).closest(".right__inputTraveller").find(".upNum").removeClass("disabled");
			inputTraveller.val(number_person);	
			loadService();
			return false;
		});
		$(document).on('click','.btn_submit',function(e) {
			e.preventDefault();
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajChooseCabinCruise&lang='+LANG_ID,
				data: $("#frmCruiseServices").serialize(),	
				dataType:'html',	
				success: function(link){
					if(link != ''){
						location.href = link;	
					}				
				}
			});
			return false;
		});
		function loadService(){
			$("#box_list_service_choose").html('');
			var data = new Array();
			var total_price_cabin = parseInt($("input[name='total_price_cabin']").val());
			var total_price_service = 0;
			var total_number_service = 0;
			$(".list_services_cruise").find("input.input_number").each(function(index,elm){
				
				if(parseInt($(elm).val()) > 0){
					var number = $(elm).val();
					var price_service = $(elm).data("price_service");
					var cruise_service_id = $(elm).data("cruise_service_id");
					var title = $(elm).closest(".item_services").find(".title_services").text();
					var price = parseInt(price_service)* parseInt(number);
					total_price_service += price;
					total_number_service += parseInt(number);
					if(LANG_ID == 'vn'){
						var html = `<div class="item_service_choose">
								<label for="" class="lbl_price_service">`+title+` `+number+` x `+format_price(price_service)+price_rate+`</label>
								<div class="box_price_services">`;
							html +=  format_price(price)+` <span class="price_unit"> `+price_rate+`</span>`;
							html +=`</div>
							</div>`;
					}else{
						var html = `<div class="item_service_choose">
								<label for="" class="lbl_price_service">`+title+` `+number+` x `+price_rate+format_price(price_service)+`</label>
								<div class="box_price_services">`;
							html +=  ` <span class="price_unit"> `+price_rate+`</span>`+format_price(price);
							html +=`</div>
							</div>`;
					}
					$("#box_list_service_choose").append(html);
				}
			});		
			$("#total_price_service").text(format_price(total_price_service));
			$("#total_number_service").val(parseInt(total_number_service));
			$("input[name='total_price_service']").val(total_price_service);
			console.log(total_price_cabin, total_price_service);
			$("#total_price_bill").text(format_price(total_price_cabin + total_price_service));
			$("input[name='total_price_bill']").val(total_price_cabin + total_price_service);
		}
		function formatNumber(number){
			console.log(LANG_ID);
			if(LANG_ID == 'vn'){
				if(number > 1000){
					var number_format = (number/1000).toString().split(".");
					number_format[0] = number_format[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
					return number_format.join(".")+"k";
				}else{
					var number_format = number.toString().split(".");
					number_format[0] = number_format[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
					return number_format.join(".");
				}
				
			}else{
				var number_format = number.toString().split(".");
				number_format[0] = number_format[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
				return number_format.join(".");		
			}
			return number_format;		
		}
		
		if(LANG_ID=='vn'){
			function format_price(n) {
				return n.toFixed(0).replace(/./g, function(c, i, a) {
					return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
				});
			}
		}else{
			function format_price(n) {
				return n.toFixed(2).replace(/./g, function(c, i, a) {
					return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
				});
			}
		}
	})	
</script>
{/literal}