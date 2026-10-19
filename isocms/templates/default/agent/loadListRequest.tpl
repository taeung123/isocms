{section name=i loop=$lstRequest}
    {assign var=oneDownload value=$clsDownload->getOne($lstRequest[i].target_id,'download_id,title,trip_code,trip_price_old,trip_price,attachment_file,image')}
    <div class="item_request">
        <div class="box_item_top">
            <p class="agent_code">{$lstRequest[i].feedback_code}</p>
            {if $lstRequest[i].is_process eq '1'}
                <span class="status status_accept">{$core->get_Lang('Accept')}</span>
            {elseif $lstRequest[i].is_process eq '2'}
                <span class="status status_refuse">{$core->get_Lang('Refuse')}</span>
            {else}
                <span class="status status_waiting">{$core->get_Lang('Waiting')}</span>
            {/if}
        </div>
        <div class="item_salestool">
            <div class="img_salestool"><img class="img100" src="{$clsDownload->getImage($oneDownload.download_id,150,105,$oneDownload)}" width="150" height="105" alt="{$title_item}"></div>
            <div class="content_item">
                <div class="box_content_text">
                    <h3 class="title_salestool"><a href="{$oneDownload.attachment_file}" class="download" title="{$oneDownload.title}">{$oneDownload.title}</a></h3>
                    {if $oneDownload.trip_code}<p class="trip_code"><i class="fa-regular fa-barcode"></i> {$core->get_Lang('Trip code')}: <span class="code">{$oneDownload.trip_code}</span></p>{/if}
                </div>
                <div class="box_price_button">
                    <div class="box_price">
                        {if $oneDownload.trip_price_old}<p class="price_from">{$core->get_Lang('From')} <span class="price_old">{$clsISO->getRate()}{$oneDownload.trip_price_old}</span></p>{/if}
                        {if $oneDownload.trip_price}<p class="price">{$clsISO->getRate()}{$oneDownload.trip_price}</p>{/if}
                    </div>
                    <div class="box_button_request mt-3">
                        <a href="{$oneDownload.attachment_file}" class="btn_detail" title="{$core->get_Lang('View detail')}& {$core->get_Lang('price')}"><i class="fa-regular fa-file-arrow-down me-1"></i> {$core->get_Lang('View detail')}& {$core->get_Lang('price')}</a>
                        <a href="javascript:void(0)" type="button" class="btn_request" data-bs-toggle="modal" data-bs-target="#modalRequest_{$lstRequest[i].feedback_id}"><i class="fa-light fa-pen-to-square me-1"></i> {$core->get_Lang('Request detail')}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal modal_require" id="modalRequest_{$lstRequest[i].feedback_id}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="box_header_modal">
                            <h2 class="title_modal">{$oneDownload.title}</h2>
                            <p class="title_tour">{$title_item}</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        {$lstRequest[i].feedback_html}
                    </div>
                </div>
            </div>
        </div>
    </div>
{/section}
