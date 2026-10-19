<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('hotels')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}&country_id={$country_id}{if $city_id}&city_city={$city_id}{/if}" title="{$act}">
    	{$core->get_Lang('add')}
    </a>
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('addhotels')}</h2>
        <p>{$core->get_Lang('systemaddhotels')}</p>
    </div>
	<div class="clearfix"></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
    	<div id="clienttabs">
        	<ul>
                <li class="tabchild"><a href="javascript:void(0);">{$core->get_Lang('hotelinformation')}</a></li>
            </ul>
        </div>
        <div id="tab_content">
        	<div class="tabbox" style="display:block">
                <div class="row-field">
                    <div class="row-heading notToogle">1. {$core->get_Lang('nameofhotels')}*</div>
                    <div class="coltrols">
                        <input class="text isotitle full required" autocomplete="off" name="iso-{$title}" value="" maxlength="255" type="text">
                    </div>
                </div>
                <div class="leftPage">
                    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
                    <div class="row-field">
                        <div class="row-heading notToogle">2. {$core->get_Lang('address')}*</div>
                        <div class="coltrols">
                            <input class="text full required" id="search_location" name="iso-{$address}" value="{$clsClassTable->getAddress($pvalTable)}" maxlength="255" type="text">
                        </div>
                    </div>
                    <div class="wrap">
                        <div class="row-field" style="width:32%;margin-right:1%;float:left">
                            <div class="row-heading notToogle">3. {$core->get_Lang('ranking')} *</div>
                            <div class="coltrols">
                                <select name="iso-star" style="width:100%;font-size:12px;padding:3px;" class="slb required">
                                    {$clsProperty->getSelectByProperty('star_number',$star)}
                                </select>
                            </div>
                        </div>
                        <div class="row-field" style="width:33%;margin-right:1%;float:left">
                            <div class="row-heading notToogle">4. {$core->get_Lang('pricefrom')} </div>
                            <div class="coltrols">
                                <span style="vertical-align:-2px">$US&nbsp;&nbsp;</span>
                                <input class="text price medium" name="price" value="{$clsClassTable->getOneField('price',$pvalTable)}" maxlength="255" type="text" />
                            </div>
                        </div>
                        <div class="row-field" style="width:32%;float:right">
                            <div class="row-heading notToogle">5. {$core->get_Lang('phone')}*</div>
                            <div class="coltrols">
                                <input class="text full required" name="iso-phone" value="{$clsClassTable->getOneField('phone',$pvalTable)}" maxlength="255" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row-field">
                        <div class="row-heading">6. {$core->get_Lang('intro')}</div>
                        <div class="coltrols">{$clsForm->showInput($intro)}</div>
                    </div>
                    <div class="row-field">
                        <div class="row-heading">7. {$core->get_Lang('content')}</div>
                        <div class="coltrols">{$clsForm->showInput($content)}</div>
                    </div>
                </div>
                <div class="rightPage">
                    <div class="row-field">
                        <div class="row-heading">8. {$core->get_Lang('country')}*</div>
                        <div class="coltrols">
                            <select class="slb required full" name="iso-country_id" style="width:100%">
                                {$clsCountry->getSelectByCountry($country_id)}
                            </select>
                        </div>
                    </div>
                    <div class="row-field">
                        <div class="row-heading">9. {$core->get_Lang('cities')}</div>
                        <div class="coltrols">
                            <select name="iso-city_id" class="slb" style="width:100%;">
                                {$clsCity->getSelectByCity($city_id)}
                            </select>
                        </div>
                    </div>
                    <div class="row-field">
                        <div class="row-heading">10. {$core->get_Lang('images')} {$clsISO->getConfigImage('_HOTEL','size')}</div>
                        <div class="coltrols">
                            <div class="upload-box">
                                <a href="javascript:void()" class="image {$clsISO->getConfigImage('_HOTEL','dimension')}">
                                    <img src="{$URL_IMAGES}/noPhoto.jpg" width="100%" alt="{$clsClassTable->getTitle($pvalTable)}" />
                                </a>
                                <div class="upload-file">
                                    <a href="javascript:void();" class="btn fl btn-primary vietISO_upload" style=" margin:0 0 10px">
                                        <i class="icon-picture icon-white"></i>
                                        <span>{$core->get_Lang('uploadandcrop')}</span>
                                    </a>
                                    <br class="clearfix" />
                                     <input type="hidden" name="image" class="hidden_src" />
                                    <label>{$core->get_Lang('Or use images online')}</label>
                                    <input type="text" name="image_url" class="full text">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"><br/></div>
        <fieldset class="submit-buttons">
            {$saveBtn}{$saveNew}{$saveList}
            <input value="Insert" name="submit" type="hidden">
        </fieldset>
    </form>
</div>
<script type="text/javascript">
	var path_ajax_script="{$PCMS_URL}";
	var city_id="{$city_id}";
</script>
<script type="text/javascript" src="{$URL_JS}/mod/hotel.js"></script>