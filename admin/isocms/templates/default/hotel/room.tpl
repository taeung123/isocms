<link rel="stylesheet" href="{$URL_CSS}/chosen.css" type="text/css" media="all">
<script type="text/javascript" src="{$URL_JS}/chosen.jquery.js?v={$upd_version}"></script>
<script type="text/javascript">
    var hotel_room_id = '{$pvalTable}';
    var hotel_id = '{$hotel_id}';
</script>
<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('hotels')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act=edit&hotel_id={$core->encryptID($hotel_id)}">{$clsHotel->getTitle($hotel_id)}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act=edit&hotel_id={$core->encryptID($hotel_id)}">{$clsClassTable->getTitle($pvalTable)}</a>
    <!-- Back -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$clsHotel->getTitle($hotel_id)} <img src="{$clsHotel->getImageStar($clsHotel->getStar($hotel_id))}"/></h2>
        <div class="permalinkbox">
            <div class="wrap permalink_show">
                <a href="{$DOMAIN_NAME}{$clsHotel->getLink($hotel_id)}" target="_blank"><img align="absmiddle"
                                                                                             style="vertical-align:-2px"
                                                                                             src="{$URL_IMAGES}/v2/link.png"/>
                    <strong>{$DOMAIN_NAME}{$clsHotel->getLink($hotel_id)}</strong></a>
            </div>
        </div>
    </div>
    <div class="hr"></div>
    <div class="clearfix"><br/></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
        <div class="wrap">
            <div class="image">
                <div class="photobox fl">
                    {if $_isoman_use eq '1'}
                        <img src="{$oneItem.image}" alt="{$core->get_Lang('images')}" id="isoman_show_image"/>
                        <input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneItem.image}">
                        <a href="javascript:void()" class="photobox_edit ajOpenDialog" isoman_for_id="image"
                           isoman_val="{$oneItem.image}" isoman_name="image" title="{$core->get_Lang('change')}"><i
                                    class="iso-edit"></i></a>
                        {if $oneItem.image}
                            <a pvalTable="{$pvalTable}" clsTable="HotelRoom" href="javascript:void()"
                               title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage"
                               data-name_input="isoman_url_image" g="imgItem"
                               style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>
                        {/if}
                    {else}
                        <img src="{$clsClassTable->getImage($pvalTable,180,156)}" alt="{$core->get_Lang('noimages')}"
                             id="imgTour_image"/>
                        <input type="hidden" name="image_src" value="{$oneItem.image}" class="hidden_src"
                               id="imgTour_hidden"/>
                        <a href="javascript:void()" title="{$core->get_Lang('change')}"
                           class="photobox_edit editInlineImage" g="imgTour">
                            <i class="iso-edit"></i>
                        </a>
                        <input type="file" style="display:none" id="imgTour_file" g="imgTour"
                               class="editInlineImageFile" name="image"/>
                    {/if}
                </div>
            </div>
            <div style="vertical-align:top; margin-left:220px">
                <div class="row-span">
                    <div class="fieldlabel"><strong>{$core->get_Lang('Name')}* </strong></div>
                    <div class="fieldarea">
                        <input class="text full" id="title" name="iso-title"
                               value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text"/>
                    </div>
                </div>
                {if $clsISO->getCheckActiveModulePackage($package_id,'property','default','default','TypeRoom')}
                    <div class="row-span">
                        <div class="fieldlabel"><strong>{$core->get_Lang('TypeOfRoom')}* </strong></div>
                        <div class="fieldarea">
                            <select name="iso-room_stype_id">
                                {$clsISO->getSelectPropertyType('TypeRoom',$oneItem.room_stype_id)}
                            </select>
                        </div>
                    </div>
                {/if}
                <div class="row-span">
                    <div class="fieldlabel"><strong>{$core->get_Lang('Description')}* </strong></div>
                    <div class="fieldarea">
                        <textarea id="textarea_content_editor{$now}" rows="2" class="textarea_content_editor"
                                  name="iso-intro" style="width:99%">{$clsClassTable->getIntro($pvalTable)}</textarea>
                    </div>
                </div>
            </div>
            <div class="clearfix mb10"></div>
            <div id="v-nav">
                <ul style="width:382px !important">
                    <li class="tabchildcol current" style="width:382px !important"><a
                                href="javascript:void(0);">{$core->get_Lang('RoomFacility')}</a></li>
                </ul>
                <div class="tab-content" style="display: block;margin-left:382px !important">
                    <div class="format-setting-wrap">
                        <div class="format-setting-label">
                            <label>{$core->get_Lang('Number Room')}</label>
                        </div>
                        <div class="format-setting-content">
                            <input type="text" class="text full" value="{$oneItem.number_val}" name="iso-number_val"
                                   style="width:50%"/>
                        </div>
                    </div>
                    <div class="format-setting-wrap">
                        <div class="format-setting-label">
                            <label>{$core->get_Lang('Price')} ({$clsISO->getRate()})</label>
                        </div>
                        <div class="format-setting-content">
                            <input type="text" class="text full autosavefield" name="rate"
                                   value="{$clsISO->formatPrice($oneItem.price)}" field_id="price" tbl="HotelRoom"
                                   pval="{$pvalTable}" ipn="number" style="width:50%"/>
                            <span>{$core->get_Lang('Per night')}</span>
                        </div>
                    </div>
                    <div class="format-setting-wrap">
                        <div class="format-setting-label">
                            <label>{$core->get_Lang('Adult')}</label>
                        </div>
                        <div class="format-setting-content">
                            <input type="text" class="text full" name="iso-number_adult" value="{$oneItem.number_adult}"
                                   style="width:50%"/>
                            <span>{$core->get_Lang('Number of Adults in room')}</span>
                        </div>
                    </div>
                    <div class="format-setting-wrap">
                        <div class="format-setting-label">
                            <label>{$core->get_Lang('Children')}</label>
                        </div>
                        <div class="format-setting-content">
                            <input type="text" class="text full" name="iso-number_children"
                                   value="{$oneItem.number_children}" style="width:50%"/>
                            <span>{$core->get_Lang('Number of children in room')}</span>
                        </div>
                    </div>
                    <div class="format-setting-wrap">
                        <div class="format-setting-label">
                            <label>{$core->get_Lang('No. beds')}</label>
                        </div>
                        <div class="format-setting-content">
                            <input type="text" class="text full" name="iso-number_bed"
                                   {if $oneItem.number_bed ne '0' and $oneItem.number_bed ne ''}value="{$oneItem.number_bed}"
                                   {else}placeholder="1 double beds (2mx2m) or 2 twin beds (1m2x2m)"{/if}
                                   style="width:50%"/>
                            <span>{$core->get_Lang('Number of Beds in room')}</span>
                        </div>
                    </div>
                    <div class="format-setting-wrap">
                        <div class="format-setting-label">
                            <label>{$core->get_Lang('Room size')}</label>
                        </div>
                        <div class="format-setting-content">
                            <input type="text" class="text full" name="iso-footage" value="{$oneItem.footage}"
                                   style="width:50%"/>
                            <span>{$core->get_Lang('Room size m2')}</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Room Service -->
            <div class="h4 mv10">
                {$core->get_Lang('RoomFacilities')}</strong>
                <p class="checkall">{$core->get_Lang('Check/Uncheck All')} <input type="checkbox" rel="room_facility"
                                                                                  id="all_check"></p>
            </div>
            <div class="wrap">
                {section name=i loop=$lstRoomFacilities}
                    <label class="lblcheck">
                        <input type="checkbox"
                               value="{$lstRoomFacilities[i].property_id}" {if $clsISO->checkContainer2($oneItem.list_RoomFacilities,$lstRoomFacilities[i].property_id)} checked="checked"{/if}
                               class="room_facility" name="list_RoomFacilities[]"/>
                        {$clsProperty->getTitle($lstRoomFacilities[i].property_id)}
                    </label>
                {/section}
                <label class="lblcheck"><a href="{$PCMS_URL}/index.php?mod=property&type=RoomFacilities"><img
                                src="{$URL_IMAGES}/v2/add.png" align="absmiddle"
                                style="vertical-align-3px"/> {$core->get_Lang('AddMoreRoomFacilities')}</a></label>
            </div>
        </div>
        <div class="clearfix mt10"></div>
        <fieldset class="submit-buttons">
            {$saveBtn}{$saveList}
            <input value="Update" name="submit" type="hidden">
        </fieldset>
    </form>
</div>
{literal}
    <script type="text/javascript">
        if ($('.textarea_content_editor').length > 0) {
            $('.textarea_content_editor').each(function () {
                var $_this = $(this);
                var $editorID = $_this.attr('id');
                $('#' + $editorID).isoTextArea();
            });
        }
    </script>
    <script type="text/javascript">
        var st_timezone = {"timezone_string": ""};
        var st_params = {"locale": "vi", "text_refresh": "Refresh"};
    </script>
{/literal}
<link rel="stylesheet" type="text/css" href="{$URL_JS}/fullcalendar/fullcalendar.min.css"/>

<script type="text/javascript" src="{$URL_JS}/fullcalendar/moment.js"></script>
<script type="text/javascript" src="{$URL_JS}/fullcalendar/moment-timezone-with-data-2010-2020.js"></script>
<script type="text/javascript" src="{$URL_JS}/fullcalendar/fullcalendar.min.js"></script>
<script type="text/javascript" src="{$URL_JS}/fullcalendar/date.js"></script>
<script type="text/javascript" src="{$URL_JS}/fullcalendar/custom.js"></script>
<script type="text/javascript" src="{$URL_THEMES}/hotelpro/jquery.hotelpro.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/jquery.global.js?v={$upd_version}"></script>
<script type="text/javascript">
    loadCustomField(hotel_id, hotel_room_id, 'ADDFACILITY', 'SiteCustomFieldContaciner');
</script>