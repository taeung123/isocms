{assign var=title_item value=$value.title}
{assign var=attachment_file value=$value.attachment_file}
<div class="item_salestool {$value.tour_id}">
    <div class="img_salestool"><a href="{$attachment_file}" class="download" title="{$title_item}"><img class="img100" src="{$clsISO->tripslashImage($value.image,335,237)}" width="335" height="237" alt="{$title_item}" loading="lazy"></a></div>
    <div class="content_item">
        <div class="box_content_text">
            <h3 class="title_salestool"><a href="{$attachment_file}" class="download" title="{$title_item}">{$title_item}</a></h3>
            {if $value.trip_code}<p class="trip_code line-height-24"><i class="fa-solid fa-barcode"></i> {$core->get_Lang('Trip code')}: <span class="code">{$value.trip_code}</span></p>{/if}
            <div class="intro_salestool line-height-24 limit_3line">{$value.intro|html_entity_decode}</div>
        </div>
        <div class="box_price">
            {if $value.trip_price_old}<p class="price_from">{$core->get_Lang('From')} <span class="price_old">{$clsISO->getRate()}{$value.trip_price_old}</span></p>{/if}
            {if $value.trip_price}<p class="price">{$clsISO->getRate()}{$value.trip_price}</p>{/if}
        </div>
        <div class="box_button_request mt-3">
            {if $attachment_file}<a href="{$attachment_file}" class="btn_detail" download title="{$core->get_Lang('Download')}"><i class="fa-regular fa-file-arrow-down me-1"></i> {$core->get_Lang('Download')}</a>{/if}
            <a href="{$attachment_file}" class="btn_detail" title="{$core->get_Lang('View detail')}& {$core->get_Lang('price')}"><i class="fa-regular fa-file-arrow-down me-1"></i> {$core->get_Lang('View detail')}& {$core->get_Lang('price')}</a>
            <a href="javascript:void(0)" type="button" class="btn_request" data-target_id="{$value.tour_id}" data-title="{$title_item}" data-bs-toggle="modal" data-bs-target="#modalRequest"><i class="fa-light fa-pen-to-square me-1"></i> {$core->get_Lang('Request')}</a>
        </div>
    </div>
</div>