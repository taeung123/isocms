{assign var=link_combo value=$clsCombo->getLink($combo_id)}
{assign var=title_combo value=$clsCombo->getTitle($combo_id)}
{if $title_combo}
<div class="combo_item {$deviceType}" combo_id="{$combo_id}">
	<a href="{$link_combo}" title="{$title_combo}">
		<div class="image relative">
			<img src="{$clsConfiguration->getImage('default_image_pixel',297,199)}" data-src="{$clsCombo->getImage($combo_id,296,196)}" alt="{$title_combo}" class="{if $act eq 'detail'}owl-lazy{else}lazy{/if} img100">
			<span class="combo_hotel">Quy Nhơn <i class="fa fa-bed" aria-hidden="true"></i></span>
		</div>
		<div class="body">
			<h3 class="body_title limit_2line color_1c1c1c">{$title_combo}</h3>
			<p class="body_duration"><i class="ico ico-clock"></i>{$clsCombo->getTripDuration2019($combo_id)}</p>
			<p class="destination"><i class="ico ico-des"></i>Hà nội</p>
			<div class="price">
			<p class="price_text">Chỉ từ</p>
			<p class="price_number"><span>2,000,000đ</span>/người</p>
			</div>
		</div>
	</a>
</div>
{/if}