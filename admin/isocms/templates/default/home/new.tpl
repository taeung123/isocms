<link rel="stylesheet" href="{$URL_CSS}/homeadmin.css?v={$upd_version}"/>
<link rel="stylesheet" href="{$URL_CSS}/fontawesome/css/all.min.css?v={$upd_version}"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

<section class="dashboard">
    <div class="container-fluid">
        <div class="dashboard_header_box">
            <div class="title_box">
                <h2 class="txt_welcome">{$core->get_Lang('Welcome')}
                    <span class="txt_namewel">{$clsUser->getOneField('first_name',$_loged_id)} {$clsUser->getOneField('last_name',$_loged_id)}</span>
                </h2>
                <p class="txt_isocmswel">{$core->get_Lang('Welcome to isoCMS website data management system.')}</p>
            </div>
            <div class="button_product_booking">
                <a href="product" alt="product" title="product">
                <button class="btn_product">{$core->get_Lang('Add Product')}</button>
                </a>
                <a href="booking" alt="booking" title="booking">
                <button class="btn_product">{$core->get_Lang('Create Booking')}</button>
                </a>
            </div>
        </div>

    <div class="dashboard_cards">
        <div class="row">
            {if $core->checkAccess(feedback) && $core->checkAccess(tour)}
            <div class="col-md-3 mb-4">
                <a href="{$PCMS_URL}/index.php?mod=feedback&type=TourInquiry">
                <div class="card_dashboard d-flex align-items-center p-3 position-relative">
                    <div class="card-bar" style="background-color: #ff6666;"></div>
                    <div class="card-content flex-grow-1 mx-3">
                        <p class="mb-1 text-muted">{$core->get_Lang('Tour Inquiry')}</p>
                        <h2 class="mb-0">{$clsISO->countTotal('Feedback',"type='TourInquiry'")}</h2>
                    </div>
                    <div class="card-icon bg_red rounded-circle p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                            <g clip-path="url(#clip0_766_177)">
                                <g filter="url(#filter0_d_766_177)">
                                    <path d="M24 9.71429V7.57143C24 7.00311 23.7742 6.45806 23.3724 6.0562C22.9705 5.65434 22.4255 5.42857 21.8571 5.42857H19V4.71429C19 4.52485 18.9247 4.34316 18.7908 4.20921C18.6568 4.07525 18.4752 4 18.2857 4C18.0963 4 17.9146 4.07525 17.7806 4.20921C17.6467 4.34316 17.5714 4.52485 17.5714 4.71429V5.42857H10.4286V4.71429C10.4286 4.52485 10.3533 4.34316 10.2194 4.20921C10.0854 4.07525 9.90373 4 9.71429 4C9.52485 4 9.34316 4.07525 9.20921 4.20921C9.07525 4.34316 9 4.52485 9 4.71429V5.42857H6.14286C5.57454 5.42857 5.02949 5.65434 4.62763 6.0562C4.22576 6.45806 4 7.00311 4 7.57143V9.71429H24Z" fill="#FA5A7D"/>
                                    <path d="M4 11.1431V21.8574C4 22.4257 4.22576 22.9707 4.62763 23.3726C5.02949 23.7744 5.57454 24.0002 6.14286 24.0002H21.8571C22.4255 24.0002 22.9705 23.7744 23.3724 23.3726C23.7742 22.9707 24 22.4257 24 21.8574V11.1431H4ZM18.0357 15.2566L13.0357 19.5424C12.899 19.6592 12.7233 19.7202 12.5437 19.7132C12.364 19.7062 12.1936 19.6316 12.0664 19.5045L9.92357 17.3616C9.79346 17.2269 9.72146 17.0465 9.72309 16.8592C9.72472 16.6719 9.79984 16.4928 9.93227 16.3603C10.0647 16.2279 10.2439 16.1528 10.4311 16.1512C10.6184 16.1495 10.7989 16.2215 10.9336 16.3516L12.6093 18.0274L17.1093 14.1702C17.1801 14.1064 17.263 14.0574 17.3531 14.0261C17.4431 13.9948 17.5385 13.9818 17.6337 13.988C17.7288 13.9942 17.8218 14.0193 17.9071 14.062C17.9923 14.1046 18.0682 14.1639 18.1302 14.2363C18.1922 14.3088 18.239 14.3929 18.268 14.4837C18.297 14.5746 18.3075 14.6703 18.2989 14.7652C18.2903 14.8602 18.2627 14.9525 18.2179 15.0366C18.1731 15.1208 18.1119 15.1951 18.0379 15.2552L18.0357 15.2566Z" fill="#FA5A7D"/>
                                </g>
                            </g>
                            <defs>
                                <filter id="filter0_d_766_177" x="0" y="1" width="28" height="28" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                    <feOffset dy="1"/>
                                    <feGaussianBlur stdDeviation="2"/>
                                    <feComposite in2="hardAlpha" operator="out"/>
                                    <feColorMatrix type="matrix" values="0 0 0 0 0.980392 0 0 0 0 0.352941 0 0 0 0 0.490196 0 0 0 0.4 0"/>
                                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_766_177"/>
                                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_766_177" result="shape"/>
                                </filter>
                                <clipPath id="clip0_766_177">
                                    <rect width="28" height="28" fill="white"/>
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                </div>
                </a>
            </div>
            {/if}

            {if $core->checkAccess(feedback) && $core->checkAccess(cruise)}
            <div class="col-md-3 mb-4">
                <div class="card_dashboard d-flex align-items-center p-3 position-relative">
                    <div class="card-bar" style="background-color: #66a3ff;"></div>
                    <div class="card-content flex-grow-1 mx-3">
                        <p class="mb-1 text-muted">{$core->get_Lang('Cruise Inquiry')}</p>
                        <h2 class="mb-0">{$clsISO->countTotal('Feedback',"type='CruiseInquiry'")}</h2>
                    </div>
                    <div class="card-icon bg-blue rounded-circle p-2">
                        <img src="customer-icon.png" alt="Customer Icon" width="24">
                    </div>
                </div>
            </div>
            {/if}
            <div class="col-md-3 mb-4">
                <div class="card_dashboard d-flex align-items-center p-3 position-relative">
                    <div class="card-bar" style="background-color: #9999ff;"></div>
                    <div class="card-content flex-grow-1 mx-3">
                        <p class="mb-1 text-muted">{$core->get_Lang('Tailor made tour')}</p>
                        <h2 class="mb-0">{$clsISO->countTotal('Booking',"clsTable='Tailor'")}</h2>
                    </div>
                    <div class="card-icon bg-blue rounded-circle p-2">
                        <img src="tour-request-icon.png" alt="Tour Request Icon" width="24">
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card_dashboard d-flex align-items-center p-3 position-relative">
                    <div class="card-bar" style="background-color: #66ff66;"></div>
                    <div class="card-content flex-grow-1 mx-3">
                        <p class="mb-1 text-muted">{$core->get_Lang('Contact')}</p>
                        <h2 class="mb-0">{$clsISO->countTotal('Feedback', "type NOT IN ('TourInquiry', 'CruiseInquiry')")}</h2>
                    </div>
                    <div class="card-icon bg-green rounded-circle p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                            <g filter="url(#filter0_d_768_213)">
                                <path d="M25.9887 14.9095C26.0269 15.8322 25.7009 16.7325 25.0819 17.413C24.463 18.0934 23.6018 18.4984 22.6872 18.5391C22.6337 18.5416 22.5803 18.5429 22.527 18.5429C22.284 18.5427 22.0418 18.5162 21.8044 18.4638C21.1 19.5608 20.1765 20.4974 19.0928 21.2138C18.009 21.9302 16.789 22.4105 15.5108 22.624C15.3596 23.072 15.058 23.4527 14.6581 23.7003C14.2581 23.9478 13.7851 24.0466 13.3206 23.9795C12.8561 23.9125 12.4295 23.6839 12.1144 23.3332C11.7993 22.9825 11.6156 22.5318 11.5949 22.0589C11.5743 21.5861 11.7182 21.1208 12.0015 20.7436C12.2849 20.3664 12.69 20.1009 13.1469 19.993C13.6037 19.8851 14.0836 19.9416 14.5035 20.1528C14.9234 20.364 15.257 20.7165 15.4465 21.1494C17.2461 20.8137 18.8719 19.8516 20.0404 18.4307C21.209 17.0099 21.8463 15.2204 21.8412 13.3743C21.8412 9.01271 18.3236 5.46435 14 5.46435C9.67636 5.46435 6.15885 9.01271 6.15885 13.3743C6.15861 14.7229 6.50029 16.0493 7.15141 17.2272C7.17348 17.266 7.19005 17.3078 7.20062 17.3514C7.26352 17.5277 7.25679 17.7217 7.18185 17.8931C7.1069 18.0646 6.96947 18.2005 6.79799 18.2726C6.37812 18.4508 5.92715 18.5426 5.4716 18.5426C5.41799 18.5426 5.36426 18.5413 5.31042 18.5388C4.39624 18.4976 3.53556 18.0923 2.91712 17.4119C2.29867 16.7315 1.97294 15.8315 2.01133 14.9092C2.02677 14.5414 2.01816 14.2132 2.00974 13.8959C2.0019 13.5971 1.99372 13.2881 2.00717 12.9657C2.04732 12.0652 2.43133 11.2152 3.07878 10.5939C3.72623 9.97257 4.5869 9.62806 5.48051 9.63252C6.91548 6.32055 10.1939 4 14 4C17.8061 4 21.0846 6.32055 22.5195 9.63257C23.4132 9.62743 24.2742 9.97164 24.9217 10.593C25.5693 11.2143 25.9532 12.0645 25.9928 12.9652C26.0063 13.2881 25.9982 13.597 25.9902 13.8958C25.9819 14.2132 25.9732 14.5415 25.9887 14.9095ZM20.0874 13.3743C20.087 14.315 19.8725 15.2432 19.4603 16.0871C19.0481 16.931 18.4493 17.6681 17.71 18.2416C16.9708 18.8151 16.1108 19.2097 15.1965 19.3949C14.2821 19.5801 13.3378 19.551 12.4364 19.3098L9.97249 20.7452C9.84817 20.8176 9.70535 20.8512 9.56209 20.8417C9.41883 20.8323 9.28158 20.7802 9.16768 20.692C9.05378 20.6039 8.96836 20.4836 8.92222 20.3465C8.87607 20.2093 8.87128 20.0615 8.90845 19.9216L9.53816 17.5519C8.49533 16.4148 7.91508 14.9233 7.91288 13.3743C7.91288 9.98733 10.6434 7.23211 14 7.23211C17.3566 7.23211 20.0874 9.98733 20.0874 13.3743ZM12.3077 13.3743C12.3077 13.1801 12.2312 12.9939 12.0951 12.8566C11.959 12.7192 11.7743 12.6421 11.5818 12.6421H11.5806C11.4371 12.6424 11.297 12.6855 11.1778 12.7662C11.0586 12.8468 10.9658 12.9612 10.911 13.095C10.8563 13.2288 10.8421 13.376 10.8703 13.518C10.8985 13.6599 10.9677 13.7902 11.0692 13.8925C11.1708 13.9947 11.3001 14.0643 11.4409 14.0925C11.5816 14.1206 11.7275 14.106 11.8601 14.0506C11.9926 13.9951 12.1059 13.9013 12.1856 13.7809C12.2653 13.6605 12.3078 13.519 12.3078 13.3743H12.3077ZM14.726 13.3743C14.7259 13.3503 14.7246 13.3264 14.7221 13.3025C14.7198 13.2786 14.7163 13.2548 14.7115 13.2313C14.7071 13.2078 14.7013 13.1846 14.694 13.1619C14.6873 13.139 14.6791 13.1166 14.6704 13.0941C14.6616 13.0716 14.651 13.0507 14.6399 13.0297C14.6288 13.0086 14.6167 12.988 14.6036 12.9682C14.5904 12.9481 14.5761 12.9287 14.561 12.9101C14.546 12.8914 14.5301 12.8737 14.5131 12.8569C14.4966 12.8398 14.4787 12.8237 14.4604 12.8081C14.4419 12.7934 14.4226 12.7788 14.4027 12.7656C14.383 12.7524 14.3627 12.7401 14.3418 12.729C14.321 12.7178 14.2992 12.7075 14.2774 12.6982C14.2556 12.689 14.2333 12.681 14.2107 12.6743C14.1654 12.6597 14.1187 12.6502 14.0713 12.646C14.0002 12.6391 13.9285 12.6426 13.8584 12.6563C13.8351 12.6611 13.812 12.6671 13.7893 12.6743C13.7666 12.681 13.7443 12.689 13.7225 12.6982C13.7007 12.7075 13.679 12.7178 13.6581 12.729C13.6373 12.7402 13.617 12.7524 13.5971 12.7656C13.5772 12.7788 13.5579 12.7934 13.5401 12.8081C13.5212 12.8237 13.5038 12.8398 13.4869 12.8569C13.4699 12.8737 13.4539 12.8914 13.4389 12.9101C13.4239 12.9287 13.4099 12.9481 13.3969 12.9682C13.3836 12.988 13.3713 13.0085 13.3601 13.0297C13.3489 13.0506 13.3389 13.0721 13.33 13.0941C13.3208 13.1163 13.3128 13.1389 13.3058 13.1619C13.2991 13.1844 13.2933 13.2078 13.2885 13.2313C13.2837 13.2548 13.2801 13.2786 13.2778 13.3025C13.2754 13.3264 13.2744 13.3504 13.2744 13.3743C13.2744 13.3982 13.2754 13.4226 13.2778 13.4465C13.2802 13.4703 13.2837 13.4939 13.2885 13.5173C13.2933 13.5407 13.2991 13.5642 13.3058 13.5871C13.3128 13.6099 13.3208 13.6324 13.33 13.6545C13.3389 13.6766 13.3489 13.6983 13.3601 13.7194C13.3712 13.7404 13.3838 13.7609 13.3969 13.7809C13.4099 13.8008 13.4239 13.82 13.4389 13.8385C13.454 13.8572 13.47 13.8751 13.4869 13.8922C13.5038 13.9088 13.5212 13.9254 13.5401 13.9405C13.5583 13.9557 13.5773 13.9699 13.5971 13.983C13.617 13.9961 13.6373 14.0088 13.6581 14.0201C13.7002 14.0422 13.744 14.0604 13.7893 14.0747C13.812 14.0816 13.8352 14.0874 13.8584 14.0923C13.9051 14.1019 13.9526 14.1067 14.0002 14.1065C14.1925 14.1059 14.3768 14.0289 14.5131 13.8922C14.5465 13.8579 14.5768 13.8207 14.6036 13.7809C14.6166 13.7609 14.6287 13.7404 14.6399 13.7194C14.651 13.6984 14.6612 13.6764 14.6704 13.6545C14.6796 13.6325 14.6873 13.6095 14.694 13.5871C14.7013 13.5642 14.7071 13.5409 14.7115 13.5173C14.7162 13.4939 14.7198 13.4703 14.7221 13.4465C14.7246 13.4225 14.7258 13.3983 14.7258 13.3742L14.726 13.3743ZM17.1453 13.3743C17.1453 13.1801 17.0688 12.9939 16.9327 12.8566C16.7966 12.7192 16.612 12.6421 16.4195 12.6421H16.4181C16.2746 12.6424 16.1344 12.6856 16.0153 12.7662C15.8961 12.8468 15.8033 12.9613 15.7485 13.0951C15.6938 13.2289 15.6797 13.376 15.7078 13.518C15.736 13.6599 15.8052 13.7902 15.9068 13.8925C16.0083 13.9948 16.1377 14.0643 16.2784 14.0925C16.4192 14.1206 16.565 14.106 16.6976 14.0506C16.8301 13.9951 16.9434 13.9013 17.0231 13.7809C17.1028 13.6605 17.1453 13.519 17.1453 13.3743Z" fill="#3CD856"/>
                            </g>
                            <defs>
                                <filter id="filter0_d_768_213" x="0" y="3" width="28" height="24" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                    <feOffset dy="1"/>
                                    <feGaussianBlur stdDeviation="1"/>
                                    <feComposite in2="hardAlpha" operator="out"/>
                                    <feColorMatrix type="matrix" values="0 0 0 0 0.235294 0 0 0 0 0.847059 0 0 0 0 0.337255 0 0 0 0.4 0"/>
                                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_768_213"/>
                                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_768_213" result="shape"/>
                                </filter>
                            </defs>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="home_box quick_access_box mb-4">
        <h2 class="title_box slideToggle">{$core->get_Lang('Quick Access')}</h2>
        <div class="quick_access_list">
            {section name=i loop=$listQuickAccessShow}
                {assign var=_adminbutton_id value=$listQuickAccessShow[i].adminbutton_id}
                {if $clsAdminButton->checkPackage($_adminbutton_id,$package_id)}
                    {if $core->checkAccess($listQuickAccessShow[i].mod_page)}
                        <div class="quick_access_item">
                            <a title="{$core->get_Lang($listQuickAccessShow[i].title)}"
                               href="{$clsAdminButton->getURL($listQuickAccessShow[i].adminbutton_id)}">
                                <span class="icon"><img class="imgIcon" src="{$listQuickAccessShow[i].image}" width="28"
                                                        height="28"/></span>
                                <span class="text">{$core->get_Lang($listQuickAccessShow[i].title_page)}</span>
                            </a>
                        </div>
                    {/if}
                {/if}
            {/section}
            <div class="quick_access_item item_add">
                <a href="javascript:void(0);" title="{$core->get_Lang('Add Task')}"
                   onClick="manager_tasks(this); return false;">
                    {$clsISO->makeIcon('plus')}
                    <span class="text">{$core->get_Lang('Add Task')}</span>
                </a>
            </div>
        </div>
    </div>
    {if $clsISO->getCheckActiveModulePackage($package_id,'booking','booking_tour','default')}
        <div class="home_box performance_box">
            <div class="header_box">
                <h2 class="title_box">{$core->get_Lang('Performance')}</h2>
                <p class="text">{$core->get_Lang('Last 7 Days')}</p>
            </div>
            <div class="performance_list">
                <div class="performance_item {if $nearest2.total_booking[0] != ''}item_{$nearest2.total_booking[0]}{/if}">
                    <p class="text">{$core->get_Lang('Number of Orders')}</p>
                    <p class="number">{$nearest1.total_booking}</p>
                    <p class="number2"><i
                                class="fa {if $nearest2.total_booking[0] != ''}fa-caret-{$nearest2.total_booking[0]}{/if}"
                                aria-hidden="true"></i> {$nearest2.total_booking[1]}</p>
                </div>
                <div class="performance_item {if $nearest2.value_of_order[0] != ''}item_{$nearest2.value_of_order[0]}{/if}">
                    <p class="text">{$core->get_Lang('Value of Orders')}</p>
                    <p class="number">{$nearest1.value_of_order} {$clsISO->getRate()}</p>
                    <p class="number2"><i
                                class="fa {if $nearest2.value_of_order[0] != ''}fa-caret-{$nearest2.value_of_order[0]}{/if}"
                                aria-hidden="true"></i> {$nearest2.value_of_order[1]} {$clsISO->getRate()}</p>
                </div>
                <div class="performance_item {if $nearest2.total_paid[0] != ''}item_{$nearest2.total_paid[0]}{/if}">
                    <p class="text">{$core->get_Lang('Total Paid')}</p>
                    <p class="number">{$nearest1.total_paid} {$clsISO->getRate()}</p>
                    <p class="number2"><i
                                class="fa {if $nearest2.total_paid[0] != ''}fa-caret-{$nearest2.total_paid[0]}{/if}"
                                aria-hidden="true"></i> {$nearest2.total_paid[1]} {$clsISO->getRate()}</p>
                </div>
                <div class="performance_item">
                    <p class="text">{$core->get_Lang('Total Refund')}</p>
                    <p class="number">0</p>
                    <p class="number2">$0.00</p>
                </div>
                <div class="performance_item {if $nearest2.total_discount[0] != ''}item_{$nearest2.total_discount[0]}{/if}">
                    <p class="text">{$core->get_Lang('Total Discount')}</p>
                    <p class="number">{$nearest1.total_discount} {$clsISO->getRate()}</p>
                    <p class="number2"><i
                                class="fa {if $nearest2.total_discount[0] != ''}fa-caret-{$nearest2.total_discount[0]}{/if}"
                                aria-hidden="true"></i> {$nearest2.total_discount[1]} {$clsISO->getRate()}</p>
                </div>
                <div class="performance_item {if $nearest2.balance_owed[0] != ''}item_{$nearest2.balance_owed[0]}{/if}">
                    <p class="text">{$core->get_Lang('Balance Owed')}</p>
                    <p class="number">{$nearest1.balance_owed} {$clsISO->getRate()}</p>
                    <p class="number2"><i
                                class="fa {if $nearest2.balance_owed[0] != ''}fa-caret-{$nearest2.balance_owed[0]}{/if}"
                                aria-hidden="true"></i> {$nearest2.balance_owed[1]} {$clsISO->getRate()}</p>
                </div>
                <div class="performance_item item_up">
                    <p class="text">{$core->get_Lang('Direct Sales')}</p>
                    <p class="number">4.268.580đ</p>
                    <p class="number2"><i class="fa fa-caret-up" aria-hidden="true"></i> 2.125.004đ</p>
                </div>
                <div class="performance_item item_up">
                    <p class="text">{$core->get_Lang('Marketplace Sales')}</p>
                    <p class="number">3.478.500đ</p>
                    <p class="number2"><i class="fa fa-caret-up" aria-hidden="true"></i> 2.125.004đ</p>
                </div>
            </div>
        </div>
        <div class="chart_booking">
            <div class="home_box chart_booking_box">
                <div class="top_chart_booking">
                    <div class="letf_top_chart_booking">
                        <h2 class="title_box">{$core->get_Lang("Chart Booking")}</h2>
                        <div class="input_year">
                            <select class="form-control year_chart_booking" name="" id="">
                                {foreach from=$rangeDate item=year}
                                    <option value="{$year}"
                                            {if $year == $smarty.now|date_format:"%Y"}selected{/if}>{$year}</option>
                                {/foreach}
                            </select>
                            <!--<input class="form-control year_chart_booking" type="text" min="2000" max="{$smarty.now|date_format:"%Y"}" step="1" value="{$smarty.now|date_format:"%Y"}" />
						<i class="fa fa-angle-down" aria-hidden="true"></i>-->
                        </div>
                    </div>
                    <div class="right_chart_booking">
                        <label class="lbl_checkbox">
                            <input type="radio" class="check_all" name="booking_cat" value="all" checked="checked">
                            <span class="checkmark">{$core->get_Lang('All')}</span>
                        </label>
                        <label class="lbl_checkbox">
                            <input type="radio" class="check_one" name="booking_cat" value="Tour">
                            <span class="checkmark">{$core->get_Lang('Tour')}, {$core->get_Lang('voucher')}</span>
                        </label>
                        <label class="lbl_checkbox">
                            <input type="radio" class="check_one" name="booking_cat" value="Hotel">
                            <span class="checkmark">{$core->get_Lang('Hotel')}</span>
                        </label>
                        <label class="lbl_checkbox">
                            <input type="radio" class="check_one" name="booking_cat" value="Cruise">
                            <span class="checkmark">{$core->get_Lang('Cruise')}</span>
                        </label>
                        <label class="lbl_checkbox">
                            <input type="radio" class="check_one" name="booking_cat" value="Tailor">
                            <span class="checkmark">{$core->get_Lang('Tailor made tour')}</span>
                        </label>
                    </div>
                </div>
                {$core->getBlock('chart_booking')}
            </div>
            <div class="ads_travelmaster">
                <a href="" title=""><img src="{$URL_IMAGES}/img_travelmaster.jpg"/></a>
            </div>
        </div>
    {/if}
    </div>
</section>

<div class="home_box actions_required_box">
    <div class="header_box">
        <h2 class="title_box">{$core->get_Lang('Actions Required')}</h2>
        <a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clstable="Booking"
           style="color:rgb(255,255,255); display:none;">
            <span>{$core->get_Lang('Delete Options')}</span>
        </a>
    </div>
    <table class="booking_list_table table-hover">
        <thead>
        <tr>
            <td class="gridheader" style="width:40px">
                <input id="check_all" type="checkbox"/>
            </td>
            <td class="gridheader" style="width:40px">
                <strong>{$core->get_Lang('STT')}</strong>
            </td>
            <td class="gridheader text-center name_responsive">
                <strong>{$core->get_Lang('Booking date')}</strong>
            </td>
            <td class="gridheader text-left hiden_responsive">
                <strong>{$core->get_Lang('Booking customer')}</strong>
            </td>
            <td class="gridheader text-center hiden_responsive">
                <strong>{$core->get_Lang('Booking pay')}</strong>
            </td>
            <td class="gridheader text-center hiden_responsive" width="100px"></td>
        </tr>
        </thead>
        <tbody>
        {section name=i loop=$lstBooking}
            {assign var=booking_id value=$lstBooking[i].booking_id}
            <tr id="order_{$booking_id}">
                <td class="index text-center">
                    <input name="p_key[]" class="chkitem" type="checkbox" value="{$booking_id}"/>
                </td>
                <td class="date_index">
                    <span>{$booking_id}</span>
                </td>
                <td class="date_booking">
                    <p class="text1">{$clsISO->getDayOfWeek($lstBooking[i].reg_date)}</p>
                    <p class="text2">{$clsISO->formatDate($lstBooking[i].reg_date,'dot')}</p>
                </td>
                <td class="customer_booking">
                    <p class="text1">{$clsBooking->getContactName($booking_id)}</p>
                    <p class="text2">{$clsBooking->getHTMLService($booking_id)}</p>
                    <span class="booking_code">{$lstBooking[i].booking_code}</span>
                </td>
                <td class="pay_booking">
                    <p class="text1">{$clsISO->priceFormat($lstBooking[i].totalgrand)}{$clsISO->getShortRateText()}</p>
                    <p class="text2">{$clsBooking->getBookingStatus($lstBooking[i].status)}</p>
                </td>

                <td style="vertical-align: middle; width:40px; text-align: center; white-space: nowrap;">
                    <div class="btn-group">
                        <button class="btn iso-button-standard dropdown-toggle" type="button"
                                data-toggle="dropdown">
                            <i class="icon-cog"></i> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" style="right:0px !important">
                            {if _ISOCMS_CLIENT_LOGIN eq '111'}
                                <li>
                                    <a href="{$PCMS_URL}/?mod=member&act=viewbooking&booking_id={$core->encryptID($booking_id)}"
                                       title="{$core->get_Lang('view')}">
                                        <i class="icon-edit"></i> {$core->get_Lang('view')}
                                    </a>
                                </li>
                            {else}
                                <li>
                                    <a href="{$PCMS_URL}/?mod=booking&act=edit&action=booking_tour&booking_id={$core->encryptID($booking_id)}"
                                       title="{$core->get_Lang('view')}">
                                        <i class="icon-edit"></i> {$core->get_Lang('view')}
                                    </a>
                                </li>
                            {/if}
                            <li>
                                <a class="confirm_delete"
                                   href="{$PCMS_URL}/?mod={$mod}&act=delete&pkeyTable={$core->encryptID($booking_id)}"
                                   title="{$core->get_Lang('delete')}">
                                    <i class="icon-remove"></i> {$core->get_Lang('delete')}
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>


            </tr>
        {/section}
        </tbody>
    </table>
</div>

{literal}
    <style>
        .dashboard {
            background-color: #F0F5FB;
        }
    </style>
    <script type="text/javascript">
        function manager_tasks() {
            $.post(path_ajax_script + '/index.php?mod=home&act=load_quick_access', {
                'holderG': '_modal'
            }, function (html) {
                $Core.popup.open('auto', 'auto', html, 'add_task');
                loadHtmlQuickAccess();
            });
        }

        function loadHtmlQuickAccess() {
            $.post(path_ajax_script + '/index.php?mod=home&act=load_quick_access', {
                'holderG': '_list'
            }, function (html) {
                $('.quick_access_html').html(html);
            });
        }

        $(function () {
            $_document.on('click', ".remove_item_quick_access,.add_item_quick_access", function (ev) {
                ev.preventDefault();
                var $_this = $(this),
                    holderG = $_this.data('tp'),
                    adminbutton_id = $_this.data('adminbutton_id');
                $.ajax({
                    type: 'POST',
                    url: path_ajax_script + '/index.php?mod=home&act=load_quick_access',
                    data: {"holderG": holderG, "adminbutton_id": adminbutton_id},
                    dataType: 'html',
                    success: function (html) {
                        loadHtmlQuickAccess();
                    }
                });
                return false;
            });
        });

    </script>
{/literal}