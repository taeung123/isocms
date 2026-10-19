<div class="page_container page_review page_all_reviews">
    <div class="page-title" style="background: inherit">
        <h2>{$core->get_Lang('reviews')}</h2>
        <p>Chức năng quản lý danh sách các reviews trong hệ thống isoCMS</p>
        <p>{$core->get_Lang('This function is intended to manage reviews in isoCMS system')}</p>
    </div>
    <div class="container-fluid">
        <div class="row d-flex flex-wrap">
            <div class="col-lg-4 col-md-6 box-col">
                <div class="box_chart box_white">
                    <div class="head_box_chart">
                        <h3 class="title_box_chart">{$core->get_Lang("Review")}</h3>
                    </div>
                    <div class="box_body_chart d-flex flex-wrap align-items-center">
                        <div class="box_text_chart">
                            <div class="item_chart d-flex justify-content-between">
                                <label for="" class="lbl_item_chart tour">{$core->get_Lang('Tour')}</label>
                                <span class="number_item_review">{$totalReviewTour}</span>
                            </div>
                            <div class="item_chart d-flex justify-content-between">
                                <label for="" class="lbl_item_chart cruise">{$core->get_Lang('Cruise')}</label>
                                <span class="number_item_review">{$totalReviewCruise}</span>
                            </div>
                            <div class="item_chart d-flex justify-content-between">
                                <label for="" class="lbl_item_chart hotel">{$core->get_Lang('Hotel')}</label>
                                <span class="number_item_review">{$totalReviewHotel}</span>
                            </div>
                            <div class="item_chart d-flex justify-content-between">
                                <label for="" class="lbl_item_chart voucher">{$core->get_Lang('Voucher')}</label>
                                <span class="number_item_review">{$totalReviewVoucher}</span>
                            </div>
                        </div>
                        <div class="relative box_right_chart_all">
                            <div class="box_chart_all" id="box_chart_all"></div>
                            <div class="box_text_total">
                                <p class="number_total">{$totalReview}</p>
                                <span class="txt_total">{$core->get_Lang('Reviews')}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 box-col">
                <div class="box_chart box_white">
                    <div class="head_box_chart d-flex flex-wrap justify-content-between">
                        <h3 class="title_box_chart">{$core->get_Lang("Review tour")}</h3>
                        <a href="{$PCMS_URL}?mod=reviews&type=tour" class="view_all"
                           title="{$core->get_Lang('View all')}">{$core->get_Lang('View all')}</a>
                    </div>
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <div class="box_star">
                            <p class="score_star">{$totalReviewAvgTour}</p>
                            <p class="txt_review">{$totalReviewTour} {$core->get_Lang('reviews')}</p>
                            {math equation="x*100/5" x=$totalReviewAvgTour assign="star_rate_tour"}
                            <label class="rate_star block"><span style="width: {$star_rate_tour}%;"></span></label>
                        </div>
                        <div class="box_chart_tour" id="box_chart_tour"></div>
                    </div>

                </div>
            </div>
            <div class="col-lg-4 col-md-6 box-col">
                <div class="box_chart box_white">
                    <div class="head_box_chart d-flex flex-wrap justify-content-between">
                        <h3 class="title_box_chart">{$core->get_Lang("Review cruise")}</h3>
                        <a href="{$PCMS_URL}?mod=reviews&type=cruise" class="view_all"
                           title="{$core->get_Lang('View all')}">{$core->get_Lang('View all')}</a>
                    </div>
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <div class="box_star box_rate">
                            <p class="score_star">{$totalReviewAvgCruise}</p>
                            <p class="txt_review">{$totalReviewCruise} {$core->get_Lang('reviews')}</p>
                            {math equation="x*100/5" x=$totalReviewAvgCruise assign="star_rate_cruise"}
                            <label class="rate_star block"><span style="width: {$star_rate_cruise}%;"></span></label>
                        </div>
                        <div class="box_chart_cruise" id="box_chart_cruise"></div>
                    </div>

                </div>
            </div>
            <div class="col-lg-4 col-md-6 box-col">
                <div class="box_chart box_white">
                    <div class="head_box_chart d-flex flex-wrap justify-content-between">
                        <h3 class="title_box_chart">{$core->get_Lang("Review hotel")}</h3>
                        <a href="{$PCMS_URL}?mod=reviews&type=hotel" class="view_all"
                           title="{$core->get_Lang('View all')}">{$core->get_Lang('View all')}</a>
                    </div>
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <div class="box_star box_rate">
                            <p class="score_star">{$totalReviewAvgHotel}</p>
                            <p class="txt_review">{$totalReviewHotel} {$core->get_Lang('reviews')}</p>
                            {math equation="x*100/5" x=$totalReviewAvgHotel assign="star_rate_hotel"}
                            <label class="rate_star block"><span style="width: {$star_rate_hotel}%;"></span></label>
                        </div>
                        <div class="box_chart_hotel" id="box_chart_hotel"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 box-col">
                <div class="box_chart box_white">
                    <div class="head_box_chart d-flex flex-wrap justify-content-between">
                        <h3 class="title_box_chart">{$core->get_Lang("Review voucher")}</h3>
                        <a href="{$PCMS_URL}?mod=reviews&type=voucher" class="view_all"
                           title="{$core->get_Lang('View all')}">{$core->get_Lang('View all')}</a>
                    </div>
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <div class="box_star">
                            <p class="score_star">{$totalReviewAvgVoucher}</p>
                            <p class="txt_review">{$totalReviewVoucher} {$core->get_Lang('reviews')}</p>
                            {math equation="x*100/5" x=$totalReviewAvgVoucher assign="star_rate_voucher"}
                            <label class="rate_star block"><span style="width: {$star_rate_voucher}%;"></span></label>
                        </div>
                        <div class="box_chart_voucher" id="box_chart_voucher"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 12px">
            <div class="col-lg-12">
                <h3 class="title_box">{$core->get_Lang("Recent reviews")}</h3>
                <div class="box_table_review box_white">
                    <div class="box_head_tab_reviews d-flex justify-content-between align-items-center flex-wrap">
                        <div class="box_scroll">

                            <ul class="nav_tab_reviews nav nav-tabs" id="myTab" role="tablist">

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active"
                                    data-bs-toggle="tab"
                                    href="#all"
                                    role="tab"
                                    data-url="{$PCMS_URL}?mod=reviews&act=reviewAll">
                                        {$core->get_Lang('All')}
                                    </a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link"
                                    data-bs-toggle="tab"
                                    href="#tour"
                                    role="tab"
                                    data-url="{$PCMS_URL}?mod=reviews&type=tour">
                                        {$core->get_Lang('Tour')}
                                    </a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link"
                                    data-bs-toggle="tab"
                                    href="#cruise"
                                    role="tab"
                                    data-url="{$PCMS_URL}?mod=reviews&type=cruise">
                                        {$core->get_Lang('Cruise')}
                                    </a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link"
                                    data-bs-toggle="tab"
                                    href="#hotel"
                                    role="tab"
                                    data-url="{$PCMS_URL}?mod=reviews&type=hotel">
                                        {$core->get_Lang('Hotel')}
                                    </a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link"
                                    data-bs-toggle="tab"
                                    href="#voucher"
                                    role="tab"
                                    data-url="{$PCMS_URL}?mod=reviews&type=voucher">
                                        {$core->get_Lang('Voucher')}
                                    </a>
                                </li>

                            </ul>

                        </div>

                        <a href="{$PCMS_URL}?mod=reviews&act=reviewAll"
                        class="view_all"
                        id="view_all">
                            {$core->get_Lang('View all')}
                        </a>

                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div id="all" class="tab-pane fade in active show">
                            <div class="wrap">
                                <table cellspacing="0" class="table tbl-grid table-striped table_responsive"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th class="gridheader name_responsive" style="text-align:left">
                                            <strong>{$core->get_Lang('Name services')}</strong></th>
                                        <th class="gridheader hiden_responsive" style="text-align:center;width:100px">
                                            <strong>{$core->get_Lang('Type')}</strong></th>
                                        <th class="gridheader hiden_responsive" style="text-align:left">
                                            <strong>{$core->get_Lang('country')}</strong></th>
                                        <th class="gridheader hiden_responsive" style="text-align:center">
                                            <strong>{$core->get_Lang('Ranking')}</strong></th>
                                        <th class="gridheader hiden_responsive" style="width:6%">
                                            <strong>{$core->get_Lang('status')}</strong></th>
                                        <th class="gridheader hiden_responsive"></th>
                                    </tr>
                                    </thead>
                                    <tbody id="SortAble">
                                    {section name=i loop=$allItem}
                                        {assign var=type_review value=$clsClassTable->getTextByType($allItem[i].type)}
                                        {assign var=nameServices value=$clsClassTable->getNameService($allItem[i].reviews_id)}
                                        <tr id="order_{$allItem[i].reviews_id}" class="{cycle values="row1,row2"}">
                                            <td class="text-left name_service">
                                                <div class="box_name_services">
                                                    <p class="txt_name_services"><a
                                                                href="{$PCMS_URL}/?mod={$mod}&act=edit&reviews_id={$core->encryptID($allItem[i].reviews_id)}"
                                                                title="{$clsClassTable->getFullname($allItem[i].reviews_id)}">#{$allItem[i].reviews_id}</a> {if $nameServices}- {$nameServices}{/if}
                                                    </p>
                                                    <p class="txt_info">
                                                        <span>{$clsClassTable->getFullname($allItem[i].reviews_id)}</span>
                                                        |
                                                        <span>{$clsClassTable->getEmail($allItem[i].reviews_id)}</span>
                                                    </p>
                                                    <p class="txt_info">{$core->get_Lang('Update')}
                                                        : {$clsISO->formatDateTime($allItem[i].upd_date,"d/m/Y H:i",0)}</p>
                                                </div>
                                                <button type="button" class="toggle-row inline_block767"
                                                        style="display:none"><i class="fa fa-caret fa-caret-down"></i>
                                                </button>
                                            </td>
                                            <td data-title="{$core->get_Lang('Type')}"
                                                class="block_responsive border_top_responsive"
                                                style="text-align:center">
                                                {if $type_review}
                                                    <span class="type_review {$allItem[i].type}">{$type_review}</span>
                                                {/if}
                                            </td>
                                            <td data-title="{$core->get_Lang('country')}"
                                                class="block_responsive">{$clsClassTable->getCountry($allItem[i].reviews_id)}</td>
                                            <td data-title="{$core->get_Lang('Ranking')}" class="block_responsive"
                                                style="text-align:center"><p class="rate_table">{$allItem[i].rates}
                                                    <span>/5.0</span></p></td>
                                            <td data-title="{$core->get_Lang('status')}" class="block_responsive"
                                                style="text-align:center">
                                                {if $clsClassTable->getOneField('is_online',$allItem[i].reviews_id) eq '1'}
                                                    <span class="status_review public">{$core->get_Lang('Public')}</span>
                                                {else}
                                                    <span class="status_review private">{$core->get_Lang('Private')}</span>
                                                {/if}
                                            </td>
                                            <td data-title="{$core->get_Lang('func')}" class="block_responsive"
                                                align="center"
                                                style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
                                                <div>
                                                    <a href="{$PCMS_URL}/?mod={$mod}&act=edit&reviews_id={$core->encryptID($allItem[i].reviews_id)}"
                                                       title="{$core->get_Lang('edit')}"
                                                       class="icon_action edit_review">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                             viewBox="0 0 20 20" fill="none">
                                                            <path d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z"
                                                                  fill="#1756C8"/>
                                                            <path d="M19.3375 9.7875C18.6024 7.88603 17.3262 6.24164 15.6668 5.05755C14.0073 3.87347 12.0372 3.20161 10 3.125C7.96283 3.20161 5.99275 3.87347 4.33326 5.05755C2.67377 6.24164 1.39761 7.88603 0.662509 9.7875C0.612863 9.92482 0.612863 10.0752 0.662509 10.2125C1.39761 12.114 2.67377 13.7584 4.33326 14.9424C5.99275 16.1265 7.96283 16.7984 10 16.875C12.0372 16.7984 14.0073 16.1265 15.6668 14.9424C17.3262 13.7584 18.6024 12.114 19.3375 10.2125C19.3872 10.0752 19.3872 9.92482 19.3375 9.7875ZM10 14.0625C9.19652 14.0625 8.41108 13.8242 7.743 13.3778C7.07493 12.9315 6.55423 12.297 6.24675 11.5547C5.93927 10.8123 5.85882 9.99549 6.01557 9.20745C6.17232 8.4194 6.55924 7.69553 7.12739 7.12738C7.69554 6.55923 8.41941 6.17231 9.20745 6.01556C9.9955 5.85881 10.8123 5.93926 11.5547 6.24674C12.297 6.55422 12.9315 7.07492 13.3779 7.743C13.8242 8.41107 14.0625 9.19651 14.0625 10C14.0609 11.0769 13.6323 12.1093 12.8708 12.8708C12.1093 13.6323 11.0769 14.0608 10 14.0625Z"
                                                                  fill="#1756C8"/>
                                                        </svg>
                                                    </a>
                                                    <a href="{$PCMS_URL}/?mod={$mod}&act=delete&action=reviewAll&reviews_id={$core->encryptID($allItem[i].reviews_id)}{$pUrl}"
                                                       title="{$core->get_Lang('delete')}"
                                                       class="icon_action delete_review confirm_delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                             viewBox="0 0 20 20" fill="none">
                                                            <path d="M16.975 7.425L16.1417 8.86667L6.03333 3.03333L6.86667 1.59167L9.4 3.05L10.5333 2.74167L14.1417 4.825L14.45 5.96667L16.975 7.425ZM5 15.8333V5.83333H9.225L15 9.16667V15.8333C15 16.2754 14.8244 16.6993 14.5118 17.0118C14.1993 17.3244 13.7754 17.5 13.3333 17.5H6.66667C6.22464 17.5 5.80072 17.3244 5.48816 17.0118C5.17559 16.6993 5 16.2754 5 15.8333Z"
                                                                  fill="#FF0000"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    {/section}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="tour" class="tab-pane fade">
                            <div class="wrap">
                                <table cellspacing="0" class="table tbl-grid table-striped table_responsive"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th class="gridheader name_responsive" style="text-align:left">
                                            <strong>{$core->get_Lang('Name services')}</strong></th>
                                        <th class="gridheader hiden_responsive" style="text-align:left">
                                            <strong>{$core->get_Lang('country')}</strong></th>
                                        <th class="gridheader hiden_responsive" style="text-align:center">
                                            <strong>{$core->get_Lang('Ranking')}</strong></th>
                                        <th class="gridheader hiden_responsive" style="width:6%">
                                            <strong>{$core->get_Lang('status')}</strong></th>
                                        <th class="gridheader hiden_responsive"></th>
                                    </tr>
                                    </thead>
                                    <tbody id="SortAble">
                                    {section name=i loop=$allItemTour}
                                        {assign var=type_review value=$clsClassTable->getTextByType($allItemTour[i].type)}
                                        {assign var=nameServices value=$clsClassTable->getNameService($allItemTour[i].reviews_id)}
                                        <tr id="order_{$allItemTour[i].reviews_id}" class="{cycle values="row1,row2"}">
                                            <td class="text-left name_service">
                                                <div class="box_name_services">
                                                    <p class="txt_name_services"><a
                                                                href="{$PCMS_URL}/?mod={$mod}&act=edit&reviews_id={$core->encryptID($allItemTour[i].reviews_id)}"
                                                                title="{$clsClassTable->getFullname($allItemTour[i].reviews_id)}">#{$allItemTour[i].reviews_id}</a> {if $nameServices}- {$nameServices}{/if}
                                                    </p>
                                                    <p class="txt_info">
                                                        <span>{$clsClassTable->getFullname($allItemTour[i].reviews_id)}</span>
                                                        |
                                                        <span>{$clsClassTable->getEmail($allItemTour[i].reviews_id)}</span>
                                                    </p>
                                                    <p class="txt_info">{$core->get_Lang('Update')}
                                                        : {$clsISO->formatDateTime($allItemTour[i].upd_date,"d/m/Y H:i",0)}</p>
                                                </div>
                                                <button type="button" class="toggle-row inline_block767"
                                                        style="display:none"><i class="fa fa-caret fa-caret-down"></i>
                                                </button>
                                            </td>
                                            <td data-title="{$core->get_Lang('country')}"
                                                class="block_responsive border_top_responsive">{$clsClassTable->getCountry($allItemTour[i].reviews_id)}</td>
                                            <td data-title="{$core->get_Lang('Ranking')}" class="block_responsive"
                                                style="text-align:center"><p class="rate_table">{$allItemTour[i].rates}
                                                    <span>/5.0</span></p></td>
                                            <td data-title="{$core->get_Lang('status')}" class="block_responsive"
                                                style="text-align:center">
                                                {*													<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Reviews" pkey="reviews_id" sourse_id="{$allItemTour[i].reviews_id}" rel="{$clsClassTable->getOneField('is_online',$allItemTour[i].reviews_id)}" title="{$core->get_Lang('Click to change status')}">*}
                                                {if $clsClassTable->getOneField('is_online',$allItemTour[i].reviews_id) eq '1'}
                                                    <span class="status_review public">{$core->get_Lang('Public')}</span>
                                                {else}
                                                    <span class="status_review private">{$core->get_Lang('Private')}</span>
                                                {/if}
                                                {*													</a>*}
                                            </td>
                                            <td data-title="{$core->get_Lang('func')}" class="block_responsive"
                                                align="center"
                                                style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
                                                <div>
                                                    <a href="{$PCMS_URL}/?mod={$mod}&act=edit&reviews_id={$core->encryptID($allItemTour[i].reviews_id)}"
                                                       title="{$core->get_Lang('edit')}"
                                                       class="icon_action edit_review">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                             viewBox="0 0 20 20" fill="none">
                                                            <path d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z"
                                                                  fill="#1756C8"/>
                                                            <path d="M19.3375 9.7875C18.6024 7.88603 17.3262 6.24164 15.6668 5.05755C14.0073 3.87347 12.0372 3.20161 10 3.125C7.96283 3.20161 5.99275 3.87347 4.33326 5.05755C2.67377 6.24164 1.39761 7.88603 0.662509 9.7875C0.612863 9.92482 0.612863 10.0752 0.662509 10.2125C1.39761 12.114 2.67377 13.7584 4.33326 14.9424C5.99275 16.1265 7.96283 16.7984 10 16.875C12.0372 16.7984 14.0073 16.1265 15.6668 14.9424C17.3262 13.7584 18.6024 12.114 19.3375 10.2125C19.3872 10.0752 19.3872 9.92482 19.3375 9.7875ZM10 14.0625C9.19652 14.0625 8.41108 13.8242 7.743 13.3778C7.07493 12.9315 6.55423 12.297 6.24675 11.5547C5.93927 10.8123 5.85882 9.99549 6.01557 9.20745C6.17232 8.4194 6.55924 7.69553 7.12739 7.12738C7.69554 6.55923 8.41941 6.17231 9.20745 6.01556C9.9955 5.85881 10.8123 5.93926 11.5547 6.24674C12.297 6.55422 12.9315 7.07492 13.3779 7.743C13.8242 8.41107 14.0625 9.19651 14.0625 10C14.0609 11.0769 13.6323 12.1093 12.8708 12.8708C12.1093 13.6323 11.0769 14.0608 10 14.0625Z"
                                                                  fill="#1756C8"/>
                                                        </svg>
                                                    </a>
                                                    <a href="{$PCMS_URL}/?mod={$mod}&act=delete&action=reviewAll&reviews_id={$core->encryptID($allItemTour[i].reviews_id)}{$pUrl}"
                                                       title="{$core->get_Lang('delete')}"
                                                       class="icon_action delete_review confirm_delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                             viewBox="0 0 20 20" fill="none">
                                                            <path d="M16.975 7.425L16.1417 8.86667L6.03333 3.03333L6.86667 1.59167L9.4 3.05L10.5333 2.74167L14.1417 4.825L14.45 5.96667L16.975 7.425ZM5 15.8333V5.83333H9.225L15 9.16667V15.8333C15 16.2754 14.8244 16.6993 14.5118 17.0118C14.1993 17.3244 13.7754 17.5 13.3333 17.5H6.66667C6.22464 17.5 5.80072 17.3244 5.48816 17.0118C5.17559 16.6993 5 16.2754 5 15.8333Z"
                                                                  fill="#FF0000"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    {/section}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="cruise" class="tab-pane fade">
                            <div class="wrap">
                                <table cellspacing="0" class="table tbl-grid table-striped table_responsive"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th class="gridheader name_responsive" style="text-align:left">
                                            <strong>{$core->get_Lang('Name services')}</strong></th>
                                        <th class="gridheader hiden_responsive" style="text-align:left">
                                            <strong>{$core->get_Lang('country')}</strong></th>
                                        <th class="gridheader hiden_responsive" style="text-align:center">
                                            <strong>{$core->get_Lang('Ranking')}</strong></th>
                                        <th class="gridheader hiden_responsive" style="width:6%">
                                            <strong>{$core->get_Lang('status')}</strong></th>
                                        <th class="gridheader hiden_responsive"></th>
                                    </tr>
                                    </thead>
                                    <tbody id="SortAble">
                                    {section name=i loop=$allItemCruise}
                                        {assign var=type_review value=$clsClassTable->getTextByType($allItemCruise[i].type)}
                                        {assign var=nameServices value=$clsClassTable->getNameService($allItemCruise[i].reviews_id)}
                                        <tr id="order_{$allItemCruise[i].reviews_id}"
                                            class="{cycle values="row1,row2"}">
                                            <td class="text-left name_service">
                                                <div class="box_name_services">
                                                    <p class="txt_name_services"><a
                                                                href="{$PCMS_URL}/?mod={$mod}&act=edit&reviews_id={$core->encryptID($allItemCruise[i].reviews_id)}"
                                                                title="{$clsClassTable->getFullname($allItemCruise[i].reviews_id)}">#{$allItemCruise[i].reviews_id}</a> {if $nameServices}- {$nameServices}{/if}
                                                    </p>
                                                    <p class="txt_info">
                                                        <span>{$clsClassTable->getFullname($allItemCruise[i].reviews_id)}</span>
                                                        |
                                                        <span>{$clsClassTable->getEmail($allItemCruise[i].reviews_id)}</span>
                                                    </p>
                                                    <p class="txt_info">{$core->get_Lang('Update')}
                                                        : {$clsISO->formatDateTime($allItemCruise[i].upd_date,"d/m/Y H:i",0)}</p>
                                                </div>
                                                <button type="button" class="toggle-row inline_block767"
                                                        style="display:none"><i class="fa fa-caret fa-caret-down"></i>
                                                </button>
                                            </td>
                                            <td data-title="{$core->get_Lang('country')}"
                                                class="block_responsive border_top_responsive">{$clsClassTable->getCountry($allItemCruise[i].reviews_id)}</td>
                                            <td data-title="{$core->get_Lang('Ranking')}" class="block_responsive"
                                                style="text-align:center"><p
                                                        class="rate_table">{$allItemCruise[i].rates}<span>/5.0</span>
                                                </p></td>
                                            <td data-title="{$core->get_Lang('status')}" class="block_responsive"
                                                style="text-align:center">
                                                {*													<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Reviews" pkey="reviews_id" sourse_id="{$allItemCruise[i].reviews_id}" rel="{$clsClassTable->getOneField('is_online',$allItemCruise[i].reviews_id)}" title="{$core->get_Lang('Click to change status')}">*}
                                                {if $clsClassTable->getOneField('is_online',$allItemCruise[i].reviews_id) eq '1'}
                                                    <span class="status_review public">{$core->get_Lang('Public')}</span>
                                                {else}
                                                    <span class="status_review private">{$core->get_Lang('Private')}</span>
                                                {/if}
                                                {*													</a>*}
                                            </td>
                                            <td data-title="{$core->get_Lang('func')}" class="block_responsive"
                                                align="center"
                                                style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
                                                <div>
                                                    <a href="{$PCMS_URL}/?mod={$mod}&act=edit&reviews_id={$core->encryptID($allItemCruise[i].reviews_id)}"
                                                       title="{$core->get_Lang('edit')}"
                                                       class="icon_action edit_review">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                             viewBox="0 0 20 20" fill="none">
                                                            <path d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z"
                                                                  fill="#1756C8"/>
                                                            <path d="M19.3375 9.7875C18.6024 7.88603 17.3262 6.24164 15.6668 5.05755C14.0073 3.87347 12.0372 3.20161 10 3.125C7.96283 3.20161 5.99275 3.87347 4.33326 5.05755C2.67377 6.24164 1.39761 7.88603 0.662509 9.7875C0.612863 9.92482 0.612863 10.0752 0.662509 10.2125C1.39761 12.114 2.67377 13.7584 4.33326 14.9424C5.99275 16.1265 7.96283 16.7984 10 16.875C12.0372 16.7984 14.0073 16.1265 15.6668 14.9424C17.3262 13.7584 18.6024 12.114 19.3375 10.2125C19.3872 10.0752 19.3872 9.92482 19.3375 9.7875ZM10 14.0625C9.19652 14.0625 8.41108 13.8242 7.743 13.3778C7.07493 12.9315 6.55423 12.297 6.24675 11.5547C5.93927 10.8123 5.85882 9.99549 6.01557 9.20745C6.17232 8.4194 6.55924 7.69553 7.12739 7.12738C7.69554 6.55923 8.41941 6.17231 9.20745 6.01556C9.9955 5.85881 10.8123 5.93926 11.5547 6.24674C12.297 6.55422 12.9315 7.07492 13.3779 7.743C13.8242 8.41107 14.0625 9.19651 14.0625 10C14.0609 11.0769 13.6323 12.1093 12.8708 12.8708C12.1093 13.6323 11.0769 14.0608 10 14.0625Z"
                                                                  fill="#1756C8"/>
                                                        </svg>
                                                    </a>
                                                    <a href="{$PCMS_URL}/?mod={$mod}&act=delete&action=reviewAll&reviews_id={$core->encryptID($allItemCruise[i].reviews_id)}{$pUrl}"
                                                       title="{$core->get_Lang('delete')}"
                                                       class="icon_action delete_review confirm_delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                             viewBox="0 0 20 20" fill="none">
                                                            <path d="M16.975 7.425L16.1417 8.86667L6.03333 3.03333L6.86667 1.59167L9.4 3.05L10.5333 2.74167L14.1417 4.825L14.45 5.96667L16.975 7.425ZM5 15.8333V5.83333H9.225L15 9.16667V15.8333C15 16.2754 14.8244 16.6993 14.5118 17.0118C14.1993 17.3244 13.7754 17.5 13.3333 17.5H6.66667C6.22464 17.5 5.80072 17.3244 5.48816 17.0118C5.17559 16.6993 5 16.2754 5 15.8333Z"
                                                                  fill="#FF0000"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    {/section}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="hotel" class="tab-pane fade">
                            <div class="wrap">
                                <table cellspacing="0" class="table tbl-grid table-striped table_responsive"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th class="gridheader name_responsive" style="text-align:left">
                                            <strong>{$core->get_Lang('Name services')}</strong></th>
                                        <th class="gridheader hiden_responsive" style="text-align:left">
                                            <strong>{$core->get_Lang('country')}</strong></th>
                                        <th class="gridheader hiden_responsive" style="text-align:center">
                                            <strong>{$core->get_Lang('Ranking')}</strong></th>
                                        <th class="gridheader hiden_responsive" style="width:6%">
                                            <strong>{$core->get_Lang('status')}</strong></th>
                                        <th class="gridheader hiden_responsive"></th>
                                    </tr>
                                    </thead>
                                    <tbody id="SortAble">
                                    {section name=i loop=$allItemHotel}
                                        {assign var=type_review value=$clsClassTable->getTextByType($allItemHotel[i].type)}
                                        {assign var=nameServices value=$clsClassTable->getNameService($allItemHotel[i].reviews_id)}
                                        <tr id="order_{$allItemHotel[i].reviews_id}" class="{cycle values="row1,row2"}">
                                            <td class="text-left name_service">
                                                <div class="box_name_services">
                                                    <p class="txt_name_services"><a
                                                                href="{$PCMS_URL}/?mod={$mod}&act=edit&reviews_id={$core->encryptID($allItemHotel[i].reviews_id)}"
                                                                title="{$clsClassTable->getFullname($allItemHotel[i].reviews_id)}">#{$allItemHotel[i].reviews_id}</a> {if $nameServices}- {$nameServices}{/if}
                                                    </p>
                                                    <p class="txt_info">
                                                        <span>{$clsClassTable->getFullname($allItemHotel[i].reviews_id)}</span>
                                                        |
                                                        <span>{$clsClassTable->getEmail($allItemHotel[i].reviews_id)}</span>
                                                    </p>
                                                    <p class="txt_info">{$core->get_Lang('Update')}
                                                        : {$clsISO->formatDateTime($allItemHotel[i].upd_date,"d/m/Y H:i",0)}</p>
                                                </div>
                                                <button type="button" class="toggle-row inline_block767"
                                                        style="display:none"><i class="fa fa-caret fa-caret-down"></i>
                                                </button>
                                            </td>
                                            <td data-title="{$core->get_Lang('country')}"
                                                class="block_responsive border_top_responsive">{$clsClassTable->getCountry($allItemHotel[i].reviews_id)}</td>
                                            <td data-title="{$core->get_Lang('Ranking')}" class="block_responsive"
                                                style="text-align:center"><p class="rate_table">{$allItemHotel[i].rates}
                                                    <span>/5.0</span></p></td>
                                            <td data-title="{$core->get_Lang('status')}" class="block_responsive"
                                                style="text-align:center">
                                                {*													<a href="javascript:void(0);" class="SiteClickPublic" clsTable="Reviews" pkey="reviews_id" sourse_id="{$allItemHotel[i].reviews_id}" rel="{$clsClassTable->getOneField('is_online',$allItemHotel[i].reviews_id)}" title="{$core->get_Lang('Click to change status')}">*}
                                                {if $clsClassTable->getOneField('is_online',$allItemHotel[i].reviews_id) eq '1'}
                                                    <span class="status_review public">{$core->get_Lang('Public')}</span>
                                                {else}
                                                    <span class="status_review private">{$core->get_Lang('Private')}</span>
                                                {/if}
                                                {*													</a>*}
                                            </td>
                                            <td data-title="{$core->get_Lang('func')}" class="block_responsive"
                                                align="center"
                                                style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
                                                <div>
                                                    <a href="{$PCMS_URL}/?mod={$mod}&act=edit&reviews_id={$core->encryptID($allItemHotel[i].reviews_id)}"
                                                       title="{$core->get_Lang('edit')}"
                                                       class="icon_action edit_review">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                             viewBox="0 0 20 20" fill="none">
                                                            <path d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z"
                                                                  fill="#1756C8"/>
                                                            <path d="M19.3375 9.7875C18.6024 7.88603 17.3262 6.24164 15.6668 5.05755C14.0073 3.87347 12.0372 3.20161 10 3.125C7.96283 3.20161 5.99275 3.87347 4.33326 5.05755C2.67377 6.24164 1.39761 7.88603 0.662509 9.7875C0.612863 9.92482 0.612863 10.0752 0.662509 10.2125C1.39761 12.114 2.67377 13.7584 4.33326 14.9424C5.99275 16.1265 7.96283 16.7984 10 16.875C12.0372 16.7984 14.0073 16.1265 15.6668 14.9424C17.3262 13.7584 18.6024 12.114 19.3375 10.2125C19.3872 10.0752 19.3872 9.92482 19.3375 9.7875ZM10 14.0625C9.19652 14.0625 8.41108 13.8242 7.743 13.3778C7.07493 12.9315 6.55423 12.297 6.24675 11.5547C5.93927 10.8123 5.85882 9.99549 6.01557 9.20745C6.17232 8.4194 6.55924 7.69553 7.12739 7.12738C7.69554 6.55923 8.41941 6.17231 9.20745 6.01556C9.9955 5.85881 10.8123 5.93926 11.5547 6.24674C12.297 6.55422 12.9315 7.07492 13.3779 7.743C13.8242 8.41107 14.0625 9.19651 14.0625 10C14.0609 11.0769 13.6323 12.1093 12.8708 12.8708C12.1093 13.6323 11.0769 14.0608 10 14.0625Z"
                                                                  fill="#1756C8"/>
                                                        </svg>
                                                    </a>
                                                    <a href="{$PCMS_URL}/?mod={$mod}&act=delete&action=reviewAll&reviews_id={$core->encryptID($allItemHotel[i].reviews_id)}{$pUrl}"
                                                       title="{$core->get_Lang('delete')}"
                                                       class="icon_action delete_review confirm_delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                             viewBox="0 0 20 20" fill="none">
                                                            <path d="M16.975 7.425L16.1417 8.86667L6.03333 3.03333L6.86667 1.59167L9.4 3.05L10.5333 2.74167L14.1417 4.825L14.45 5.96667L16.975 7.425ZM5 15.8333V5.83333H9.225L15 9.16667V15.8333C15 16.2754 14.8244 16.6993 14.5118 17.0118C14.1993 17.3244 13.7754 17.5 13.3333 17.5H6.66667C6.22464 17.5 5.80072 17.3244 5.48816 17.0118C5.17559 16.6993 5 16.2754 5 15.8333Z"
                                                                  fill="#FF0000"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    {/section}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="voucher" class="tab-pane fade">
                            <div class="wrap">
                                <table cellspacing="0" class="table tbl-grid table-striped table_responsive"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th class="gridheader name_responsive" style="text-align:left">
                                            <strong>{$core->get_Lang('Name services')}</strong></th>
                                        <th class="gridheader hiden_responsive" style="text-align:left">
                                            <strong>{$core->get_Lang('country')}</strong></th>
                                        <th class="gridheader hiden_responsive" style="text-align:center">
                                            <strong>{$core->get_Lang('Ranking')}</strong></th>
                                        <th class="gridheader hiden_responsive" style="width:6%">
                                            <strong>{$core->get_Lang('status')}</strong></th>
                                        <th class="gridheader hiden_responsive"></th>
                                    </tr>
                                    </thead>
                                    <tbody id="SortAble">
                                    {section name=i loop=$allItemVoucher}
                                        {assign var=type_review value=$clsClassTable->getTextByType($allItemVoucher[i].type)}
                                        {assign var=nameServices value=$clsClassTable->getNameService($allItemVoucher[i].reviews_id)}
                                        <tr id="order_{$allItemVoucher[i].reviews_id}"
                                            class="{cycle values="row1,row2"}">
                                            <td class="text-left name_service">
                                                <div class="box_name_services">
                                                    <p class="txt_name_services"><a
                                                                href="{$PCMS_URL}/?mod={$mod}&act=edit&reviews_id={$core->encryptID($allItemVoucher[i].reviews_id)}"
                                                                title="{$clsClassTable->getFullname($allItemVoucher[i].reviews_id)}">#{$allItemVoucher[i].reviews_id}</a> {if $nameServices}- {$nameServices}{/if}
                                                    </p>
                                                    <p class="txt_info">
                                                        <span>{$clsClassTable->getFullname($allItemVoucher[i].reviews_id)}</span>
                                                        |
                                                        <span>{$clsClassTable->getEmail($allItemVoucher[i].reviews_id)}</span>
                                                    </p>
                                                    <p class="txt_info">{$core->get_Lang('Update')}
                                                        : {$clsISO->formatDateTime($allItemVoucher[i].upd_date,"d/m/Y H:i",0)}</p>
                                                </div>
                                                <button type="button" class="toggle-row inline_block767"
                                                        style="display:none"><i class="fa fa-caret fa-caret-down"></i>
                                                </button>
                                            </td>
                                            <td data-title="{$core->get_Lang('country')}"
                                                class="block_responsive border_top_responsive">{$clsClassTable->getCountry($allItemVoucher[i].reviews_id)}</td>
                                            <td data-title="{$core->get_Lang('Ranking')}" class="block_responsive"
                                                style="text-align:center"><p
                                                        class="rate_table">{$allItemVoucher[i].rates}<span>/5.0</span>
                                                </p></td>
                                            <td data-title="{$core->get_Lang('status')}" class="block_responsive"
                                                style="text-align:center">
                                            </td>
                                            <td data-title="{$core->get_Lang('func')}" class="block_responsive"
                                                align="center"
                                                style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
                                                <div>
                                                    <a href="{$PCMS_URL}/?mod={$mod}&act=edit&reviews_id={$core->encryptID($allItemVoucher[i].reviews_id)}"
                                                       title="{$core->get_Lang('edit')}"
                                                       class="icon_action edit_review">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                             viewBox="0 0 20 20" fill="none">
                                                            <path d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z"
                                                                  fill="#1756C8"/>
                                                            <path d="M19.3375 9.7875C18.6024 7.88603 17.3262 6.24164 15.6668 5.05755C14.0073 3.87347 12.0372 3.20161 10 3.125C7.96283 3.20161 5.99275 3.87347 4.33326 5.05755C2.67377 6.24164 1.39761 7.88603 0.662509 9.7875C0.612863 9.92482 0.612863 10.0752 0.662509 10.2125C1.39761 12.114 2.67377 13.7584 4.33326 14.9424C5.99275 16.1265 7.96283 16.7984 10 16.875C12.0372 16.7984 14.0073 16.1265 15.6668 14.9424C17.3262 13.7584 18.6024 12.114 19.3375 10.2125C19.3872 10.0752 19.3872 9.92482 19.3375 9.7875ZM10 14.0625C9.19652 14.0625 8.41108 13.8242 7.743 13.3778C7.07493 12.9315 6.55423 12.297 6.24675 11.5547C5.93927 10.8123 5.85882 9.99549 6.01557 9.20745C6.17232 8.4194 6.55924 7.69553 7.12739 7.12738C7.69554 6.55923 8.41941 6.17231 9.20745 6.01556C9.9955 5.85881 10.8123 5.93926 11.5547 6.24674C12.297 6.55422 12.9315 7.07492 13.3779 7.743C13.8242 8.41107 14.0625 9.19651 14.0625 10C14.0609 11.0769 13.6323 12.1093 12.8708 12.8708C12.1093 13.6323 11.0769 14.0608 10 14.0625Z"
                                                                  fill="#1756C8"/>
                                                        </svg>
                                                    </a>
                                                    <a href="{$PCMS_URL}/?mod={$mod}&act=delete&action=reviewAll&reviews_id={$core->encryptID($allItemVoucher[i].reviews_id)}{$pUrl}"
                                                       title="{$core->get_Lang('delete')}"
                                                       class="icon_action delete_review confirm_delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                             viewBox="0 0 20 20" fill="none">
                                                            <path d="M16.975 7.425L16.1417 8.86667L6.03333 3.03333L6.86667 1.59167L9.4 3.05L10.5333 2.74167L14.1417 4.825L14.45 5.96667L16.975 7.425ZM5 15.8333V5.83333H9.225L15 9.16667V15.8333C15 16.2754 14.8244 16.6993 14.5118 17.0118C14.1993 17.3244 13.7754 17.5 13.3333 17.5H6.66667C6.22464 17.5 5.80072 17.3244 5.48816 17.0118C5.17559 16.6993 5 16.2754 5 15.8333Z"
                                                                  fill="#FF0000"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    {/section}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="{$URL_CSS}/reviews.css?v={$upd_version}">
<script type="text/javascript">
    var $recordPerPage = '{$recordPerPage}';
    var $currentPage = '{$currentPage}';
    var $title_chart_column = '{$core->get_Lang("innings")}';
    var dataAll = {$dataAll};
    var dataTour = {$dataTour};
    var dataVoucher = {$dataVoucher};
    var dataCruise = {$dataCruise};
    var dataHotel = {$dataHotel};
    /*var dataCruise = [{
            name: 'Du thuyền',
            y: 7.5,
        },
        {
            name: 'Ăn uống',
            y: 8,
        },
        {
            name: 'Cabin',
            y: 7.6,
        },
        {
            name: 'Phục vụ',
            y: 8,
        },
        {
            name: 'Giải trí',
            y: 9,
        },
        {
            name: 'Đáng giá',
            y: 9.8,
        }
     ];
    var dataHotel = [{
            name: 'Staff',
            y: 7.5,
        },
        {
            name: 'Amenities',
            y: 8,
        },
        {
            name: 'Clean',
            y: 7.6,
        },
        {
            name: 'Place',
            y: 8,
        },
        {
            name: 'Food&Drink',
            y: 9,
        },
        {
            name: 'Worthy',
            y: 9.8,
        }
    ];*/
</script>
<script src="{$URL_JS}/highchart/highcharts.js?v={$upd_version}"></script>
<script src="{$URL_JS}/reviews.js?v={$upd_version}"></script>
{literal}
    <script>
        $(document).ready(function () {
            loadChartReviewAll(dataAll);
            loadChartByColumn({data: dataTour, color: "#FFC43D", title: $title_chart_column}, 'tour');
            loadChartByColumn({data: dataVoucher, color: "#FFC43D", title: $title_chart_column}, 'voucher');
            loadChartByColumn({data: dataCruise, color: "#FFC43D", title: $title_chart_column}, 'cruise');
            loadChartByColumn({data: dataHotel, color: "#FFC43D", title: $title_chart_column}, 'hotel');
            /*loadChartByLine(dataCruise,'cruise');
            loadChartByLine(dataHotel,'hotel');*/

        });
    </script>
{/literal}