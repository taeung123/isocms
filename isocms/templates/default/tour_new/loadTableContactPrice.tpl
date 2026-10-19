<form class="form_booking_now" action="" method="post">
    {if empty($exceeded_seat)}
		<div class="box__price_table">
			<div class="box__price--header d-flex">
				<div class="box_left">
					<h4 class="text_bold mt0">{$clsTour->getTitle($tour_id)}</h4>
					{if $is_last_hour}
						<p class="mb0 title_seat">{$title_seat}</p>
					{else}
						<p class="color_1fb69a mb0">{$core->get_Lang('Contact us for more information')}</p>
					{/if}

				</div>
				<div class="box_right">
					<input type="hidden" name="tour_id_z" value="{$tour_id}" />
					<input type="hidden" name="promotion_z" id="promotion_z" value="{$promotion}" />
					<input type="hidden" name="price_promotion" value="{$price_promotion}" />
					<input type="hidden" name="number_adults_z" id="number_adults_z" value="{$number_adults}" />
					<input type="hidden" name="number_child_z" id="number_child_z" value="{$number_child}" />
					<input type="hidden" name="number_infants_z" id="number_infants_z" value="{$number_infants}" />
					<input type="hidden" name="price_adults_z" id="price_adults_z" value="{$price_adults}" />
					<input type="hidden" name="price_child_z" id="price_child_z" value="{$price_child}" />
					<input type="hidden" name="price_infants_z" id="price_infants_z" value="{$price_infants}" />
					<input type="hidden" name="total_price_adults" id="total_price_adults" value="{$total_price_adults}" />
					<input type="hidden" name="total_price_child" id="total_price_child" value="{$total_price_child}" />
					<input type="hidden" name="total_price_infants" id="total_price_infants" value="{$total_price_infants}" />
					<input type="hidden" name="check_in_book_z" id="check_in_book_z" value="{$check_in_book}" />
					<input type="hidden" name="deposit" id="deposit" value="{$deposit}" />
					<input type="hidden" name="price_deposit" id="price_deposit" value="{$price_deposit}" />
					<input type="hidden" name="total_price_z" id="total_price_z" value="{$total_price_promotion}" />
					<input type="hidden" name="ContactTour" id="ContactTour" value="ContactTour" />
					<button class="contact_now btn_yellow btn_main">
						{$core->get_Lang("Contact")}
					</button>
				</div>
			</div>
			<div class="box_avaiable_detail d-flex">
				<div class="box_left">
					<p class="text_bold">{$core->get_Lang('Select Travel Style')}:</p>
					<select class="select--tour__class" name="tour__class" id="tour__class">
						{section name=i loop=$lstOption}
						<option value="{$lstOption[i]}" {if $tour_class_id eq $lstOption[i]} selected="selected" {/if}>{$clsTourOption->getTitle($lstOption[i])}</option>
						{/section}
					</select>
				</div>
				<div class="box_right">
					<p class="text_bold">{$core->get_Lang('Price detail')}</p>
					<ul class="list_style_none list_detail_price">
						<li><span class="w_120">{$number_adults} {$core->get_Lang('Adults')}</span></li>
						{if $number_child}
							<li class="flex-wrap">
								<div class="d-flex flex-wrap justify-content-between w-100 collapseHead collapsed" {if $arr_price_child|count gt 0}data-bs-toggle="collapse" data-bs-target="#collapseChild" aria-expanded="false" aria-controls="collapseChild"{/if}>
									<span class="w_240 text_left">{$number_child} {$core->get_Lang('Children')}</span>
									<span class="w_120 text_right">{if $arr_price_child|count gt 0}<i class="fa fa-angle-down" aria-hidden="true"></i>{/if}</span>
								</div>
								<div class="w-100 mt10 collapse" id="collapseChild">
									<div class="d-flex flex-wrap w-100">
										{section name=i loop=$arr_price_child}
											<span class="w_240 text_left">{$arr_price_child[i].number} ({$arr_price_child[i].text})</span>
										{/section}
									</div>
								</div>								
							</li>
						{/if}
						{if $number_infants}
							<li class="flex-wrap">
								<div class="d-flex flex-wrap justify-content-between w-100 collapseHead collapsed" {if $arr_price_infant|count gt 0}data-bs-toggle="collapse" data-bs-target="#collapseInfant" aria-expanded="false" aria-controls="collapseInfant"{/if}>
									<span class="w_240 text_left">{$number_infants} {$core->get_Lang('Infants')}</span>
									<span class="w_120 text_right">{if $arr_price_infant|count gt 0}<i class="fa fa-angle-down" aria-hidden="true"></i>{/if}</span>
								</div>
								<div class="w-100 mt10 collapse" id="collapseInfant">
									<div class="d-flex flex-wrap w-100">
										{section name=i loop=$arr_price_infant}
											<span class="w_240 text_left">{$arr_price_infant[i].number} ({$arr_price_infant[i].text})</span>
										{/section}
									</div>
								</div>								
							</li>
						{/if}
						{if $promotion}
							<li class="promotion color_1fb69a hidden"> <span class="w_120">{$core->get_Lang('Promotion')}</span> <span class="w_120">-{$promotion}%</span> {*<span class="price text-right">-{$price_promotion|number_format:0:".":","} {$clsISO->getShortRate()}</span>*}</li>
						{/if}
					</ul>
				</div>
			</div>
			<div class="box_avaiable_detail d-flex hidden">
				<div class="notice">
					<p>{$core->get_Lang('The system is updating. please contact')} <a href="{$clsISO->getLink('contact')}" target="_blank">{$core->get_Lang('here')}</a>
						<br>{$core->get_Lang('Hotline')} <a href="tel:{$clsConfiguration->getValue('CompanyHotline')}" title="{$clsConfiguration->getValue('CompanyHotline')}" class="">{$clsConfiguration->getValue('CompanyHotline')}</a>
					</p>
				</div>
			</div>
		</div>
    {else}
		<div class="box__price_table">
			<div class="box__price--header d-flex">
				<div class="box_left">
					<h4 class="text_bold mt0">{$clsTour->getTitle($tour_id)}</h4>
					<p class="mb0 title_seat">{$title_seat}</p>
				</div>
				<div class="box_right">
					<p class="color_666 text_bold mb0">{$core->get_Lang('Total Price')}</p>
					<div class="price">
						<span class="size24 color_fb1111 text_bold">{$core->get_Lang('Updating')}</span>
					</div>
				</div>
			</div>
			<div class="box_avaiable_detail d-flex">
				<div class="notice">
					<p>{$core->get_Lang('The number of people exceeded the number of seats left. Please')} <a class="repick_travellers">{$core->get_Lang('choose again')}</a> {$core->get_Lang('person number or contact')} <a class="trigger_contact" href="javascript:void(0);">{$core->get_Lang('here')}</a>
						<br>{$core->get_Lang('Hotline')} <a href="tel:{$clsConfiguration->getValue('CompanyHotline')}" title="{$clsConfiguration->getValue('CompanyHotline')}" class="">{$clsConfiguration->getValue('CompanyHotline')}</a>
					</p>
				</div>
			</div>
		</div>
		<div class="box__booking hidden">
			<input type="hidden" name="tour_id_z" value="{$tour_id}" />
			<input type="hidden" name="promotion_z" id="promotion_z" value="{$promotion}" />
			<input type="hidden" name="price_promotion" value="{$price_promotion}" />
			<input type="hidden" name="number_adults_z" id="number_adults_z" value="{$number_adults}" />
			<input type="hidden" name="number_child_z" id="number_child_z" value="{$number_child}" />
			<input type="hidden" name="number_infants_z" id="number_infants_z" value="{$number_infants}" />
			<input type="hidden" name="price_adults_z" id="price_adults_z" value="{$price_adults}" />
			<input type="hidden" name="price_child_z" id="price_child_z" value="{$price_child}" />
			<input type="hidden" name="price_infants_z" id="price_infants_z" value="{$price_infants}" />
			<input type="hidden" name="total_price_adults" id="total_price_adults" value="{$total_price_adults}" />
			<input type="hidden" name="total_price_child" id="total_price_child" value="{$total_price_child}" />
			<input type="hidden" name="total_price_infants" id="total_price_infants" value="{$total_price_infants}" />
			<input type="hidden" name="check_in_book_z" id="check_in_book_z" value="{$check_in_book}" />
			<input type="hidden" name="deposit" id="deposit" value="{$deposit}" />
			<input type="hidden" name="price_deposit" id="price_deposit" value="{$price_deposit}" />
			<input type="hidden" name="total_price_z" id="total_price_z" value="{$total_price_promotion}" />
			<input type="hidden" name="ContactTour" id="ContactTour" value="ContactTour" />
			<button class="contact_now btn_yellow btn_main">
				{$core->get_Lang("Contact")}
			</button>
		</div>
    {/if}
</form>
