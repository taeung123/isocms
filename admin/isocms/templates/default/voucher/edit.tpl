{*<link rel="stylesheet" href="{$URL_CSS}/jquery.autocomplete.css?v={$upd_version}" type="text/css" />
<script type="text/javascript" src="{$URL_JS}/jquery.autocomplete.min.js?v={$upd_version}"></script>*}
<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('Voucher')}</a>
	<a>&raquo;</a>
	<a href="{$curl}" title="{$act}">{if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{if $pvalTable}{$core->get_Lang('Edit')}: {$clsClassTable->getTitle($pvalTable)}{else}{$core->get_Lang('Add New')}{/if}</h2>
        {if $pvalTable}
        <div class="permalinkbox">
            <div class="wrap permalink_show">
                <strong><a href="{$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}" target="_blank"><img align="absmiddle" src="{$URL_IMAGES}/v2/link.png" /> {$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}</a></strong>
			</div>
		</div>
        {/if}
	</div>
    <div class="clearfix"><br /></div>
   
        <div id="clienttabs">
            <ul>
                <li class="tabchild"><a href="#"><i class="iso-bassic"></i> {$core->get_Lang('generalinformation')}</a></li>
				{if $pvalTable} 
				<li><a href="javascript:void();"><i class="fa fa-map-marker"></i> {$core->get_Lang('destinations')}</a></li>
				<li><a href="javascript:void();"><i class="fa fa-map-marker"></i> {$core->get_Lang('Photo Gallery')}</a></li>
				<li><a href="javascript:void();"><i class="fa fa-map-marker"></i> {$core->get_Lang('Config Price')}</a></li>
				<li class="tabchild"><a href="#">{$core->get_Lang('seosdvanced')}</a></li> 
				{/if}   
			</ul>
		</div>
        <div class="clearfix"></div>
        <div id="tab_content">
            <div class="tabbox" style="display:block">
                <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
                	<div class="wrap">
                    <div class="fl col_Left">
                        <div class="photobox image">
                            {if $_isoman_use eq '1'}
							<img src="{$oneItem.image}" alt="{$core->get_Lang('images')}" id="isoman_show_image" />
							<input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneItem.image}" />
							<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneItem.image}" isoman_name="image"><i class="iso-edit"></i></a>
							{if $oneItem.image}
							<a pvalTable="{$pvalTable}" clsTable="Country" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>
							{/if}
                            {else}
							<img src="{$oneItem.image}" alt="{$core->get_Lang('noimages')}" id="imgTour_image" />
							<input type="hidden" name="image_src" value="{$oneItem.image}" class="hidden_src" id="imgTour_hidden" />
							<a href="javascript:void()" title="{$core->get_Lang('Change')}" class="photobox_edit editInlineImage" g="imgTour">
								<i class="iso-edit"></i>
							</a> 
							<input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="image" />
                            {/if}
						</div>
					</div>
                    <div class="fl col_Right">
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('title')}</strong> <span class="color_r">*</span></div>
                            <div class="fieldarea">
                                <input class="text_32 full-width border_aaa bold title_capitalize required" name="title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text">
							</div>
						</div>
						{if $clsConfiguration->getValue('SiteHasCat_Voucher')}
                        <div class="row-span">
							<div class="fieldlabel"><strong>{$core->get_Lang('category')}</strong> <span class="color_r">*</span></div>
                            <div class="fieldarea">
                                <select class="span12 required slb" name="iso-cat_id" style="width: 200px;">
                                    {$clsVoucherCat->makeSelectboxOption($voucher_cat_id)}
								</select>
							</div>
						</div>
                        {/if}
						<div class="row-span">
							<div class="fieldlabel"><strong>{$core->get_Lang('status')}</strong> <span class="color_r">*</span></div>
							<div class="fieldarea">
								<div class="checkbox-switch">
									{if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}
									<input type="checkbox" checked value="1" name="is_online" class="input-checkbox" id="toolbar-active">
									{else}
									<input type="checkbox" value="1" name="is_online" class="input-checkbox" id="toolbar-active">
									{/if}
									<div class="checkbox-animate">
										<span class="checkbox-off">PRIVATE</span>
										<span class="checkbox-on">PUBLIC</span>
									</div>
								</div>	
								<span class="notice" id="prv_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}style="display:none;"{/if}>PRIVATE: {$core->get_Lang('This article can only be seen via the link in the admin page')}.</span>
								<span class="notice" id="pub_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 0}style="display:none;"{/if}>PUBLIC: {$core->get_Lang('This article is available online show normal status')}.</span>
							</div>
						</div>
					</div>
					<div class="clearfix mb20"></div>
					<div class="wrap">
						<div id="v-nav">
							<ul>
								<li class="tabchildcol first current"><a href="javascript:void(0);"><strong>{$core->get_Lang('HighLight')}</strong></a> <span class="color_r">*</span></li>
								<li class="tabchildcol"><a href="javascript:void(0);"><strong>{$core->get_Lang('Detail Information')}</strong></a> <span class="color_r">*</span></li>
								<li class="tabchildcol"><a href="javascript:void(0);"><strong>{$core->get_Lang('Conditions apply')}</strong></a> <span class="color_r">*</span></li>
							</ul>
							<div class="tab-content" style="display: block;">
								<div class="format-setting-wrap">
									{$clsForm->showInput('intro')}
								</div>
							</div>
							<div class="tab-content" style="display: none;">
								<div class="format-setting-wrap">
									{$clsForm->showInput('content')}
								</div>
							</div>
							<div class="tab-content" style="display: none;">
								<div class="format-setting-wrap">
									{$clsForm->showInput('location')}
								</div>
							</div>
							
						</div>
					</div>
				</div>
					<div class="row-bottom">
						<div class="row-buttons">
							<div class="clear"></div>
							<button type="submit" class="btn-update" id="SaveVoucherStep1" name="submit" value="Update">
							<i class="iso-update"></i> {$core->get_Lang('Save')}
						  </button>
							<input type="hidden" name="UpdateStep1" value="UpdateStep1" />
							<input type="hidden" name="is_set" value="{$smarty.get.is_set}" />
						</div>
					</div>
				</form>
			</div>
			{if $pvalTable}
            <div class="tabbox" style="display:none;">
				<div class="row-span">{$core->get_Lang('infodestinationadmin')}</div>
				<div class="clear"><br /></div>
				<div class="row-span">
					{if $clsConfiguration->getValue('SiteModActive_continent') and $core->checkAccess('continent')}
					<select class="slb span20 mr5 fl" name="chauluc_id" id="slb_Chauluc" style="width:120px !important;">
						{$clsContinent->makeSelectboxOption()}
					</select>
					{/if}
                    <select class="slb mr5 fl" name="country_id" id="slb_Country" style="width:120px !important;">
                        <option value="0">-- {$core->get_Lang('selectcountry')} --</option>
					</select>
                    {if $clsConfiguration->getValue('SiteActive_region')}
                    <select class="slb mr5 fl" id="slb_RegionID" name="region_id" style="width:120px !important;">
                        <option value="0">-- {$core->get_Lang('selectregion')} --</option>
					</select>
                    {/if}
                    {if $clsConfiguration->getValue('SiteActive_city')}
                    <select class="slb mr10 fl" id="slb_CityID" name="city_id" style="width:120px !important;">
                        <option value="0">-- {$core->get_Lang('selectcity')} --</option>
					</select>
                    {/if}
                    <button class="fl btn-add ajQuickAddDestination" type="button">{$core->get_Lang('adddestination')}</button>
				</div>
				<div class="clear"><br /></div>
				<div class="row-span">
					<div style="padding-left:10px">
						<ul class="list-group" id="lstDestination" style="width:500px;"></ul>
						<div class="clearfix mt10"></div>
						<span class="notice" style="padding:0;color:#0565c9">(<span class="requiredMask">*</span> ) {$core->get_Lang('infoless1destination')}</span>
					</div>
				</div>
				<div class="clearfix"><br /><br /></div>
				<div class="row-bottom">
					<div class="row-buttons">
						<input type="hidden" name="submit" value="Update" />
					</div>
				</div>
			</div>
			<div class="tabbox" style="display:none">
				 <div id="VoucherGalleryHolder"></div>
				{literal}
				<script type="text/javascript">
					$().ready(function() {
						initSysGalleryVoucher();
					});
				</script>
				{/literal}
			</div>
			<div class="tabbox" style="display:none">
				<form method="post" action="">
				<div class="row">
					<div class="col-md-8">
						<div class="ui-card mt-half">
							<header class="ui-card__header">
								<h2 class="ui-heading">{$core->get_Lang('Price')}</h2>
							</header>
							<div class="ui-card__section">
								<div class="ui-type-container">
									<div class="form-group">
										<div class="row">
											<div class="col-md-6 col-md-12">
												<label class="col-form-label">{$core->get_Lang('Price')}</label>
												<div class="input-group">
													<span class="input-group-addon">₫</span>
													<input type="text" class="form-control require numberonly price-In" required="true" name="price" value="{$oneItem.price}" />
												</div>
											</div>
											<div class="col-md-6 col-md-12">
												<label class="col-form-label">{$core->get_Lang('PriceInput')}</label>
												<div class="input-group">
													<span class="input-group-addon">₫</span>
													<input type="text" class="form-control price-In numberonly" name="price_input" value="{$oneItem.price_input}" />
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="custom-checkbox-wrapper core-checkbox-custom">
											<label class="">
												<input{if $oneItem.taxable eq '1'} checked{/if} name="taxable" value="1" type="checkbox">
												<span class="custom-checkbox custom-icon"></span>
											</label> {$core->get_Lang('Price_Included_VAT')}
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="ui-card mt-half">
							<header class="ui-card__header">
								<h2 class="ui-heading">Kho hàng</h2>
							</header>
							<div class="ui-card__section">
								<div class="ui-type-container">
									<div class="form-group">
										<div class="row">
											<div class="col-md-6 col-md-12">
												<label class="col-form-label">Mã Voucher / SKU</label>
												<input type="text" class="form-control require" required name="iso-code" value="{$oneItem.code}" />
											</div>
											<div class="col-md-6 col-md-12">
												<label class="col-form-label">Mã vạch / Barcode (ISBN, UPC, v.v...)</label>
												<input type="text" class="form-control" name="iso-barcode" value="{$oneItem.barcode}" />
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-md-6 col-md-12">
												<label class="col-form-label">Quản lý kho</label>
												<select class="form-control" onChange="setInventory(this)" name="is_inventory">
													<option{if $oneItem.is_inventory eq '0'} selected{/if} value="0">{$core->get_Lang('NoStockManagement')}</option>
													<option{if $oneItem.is_inventory eq '1'} selected{/if} value="1">{$core->get_Lang('AllowStockManagement')}</option>
												</select>
											</div>
											<div class="col-md-6 col-md-12 stock-quantity-section{if $oneItem.is_inventory ne '1'} hidden{/if}">
												<label class="col-form-label">Số lượng</label>
												<input type="number" min="0" class="form-control numberonly" value="{$clsClassTable->getQuantityInStock($pvalTable)}" name="quantity" />
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="custom-checkbox-wrapper core-checkbox-custom">
											<label class="">
												<input{if $oneItem.continue_order eq '1'} checked{/if} name="continue_order" value="1" type="checkbox"> 
												<span class="custom-checkbox custom-icon"></span>
											</label> Cho phép tiếp tục đặt hàng khi hết hàng
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="ui-card mt-half">
							<header class="ui-card__header">
								<h2 class="ui-heading">{$core->get_Lang('Transfer')}</h2>
							</header>
							<div class="ui-card__section">
								<div class="ui-type-container">
									<div class="form-group">
										<div class="custom-checkbox-wrapper core-checkbox-custom">
											<label class="">
												<input onChange="setTransfer(this)" name="is_shipping"{if $oneItem.is_shipping eq '1'} checked{/if} value="1" type="checkbox"> 
												<span class="custom-checkbox custom-icon"></span>
											</label> Sản phẩm yêu cầu vận chuyển
										</div>
									</div>
								</div>
							</div>
							<div class="ui-card__section transfer-section{if $oneItem.is_shipping ne '1'} hidden{/if}">
								<div class="ui-type-container">
									<div class="ui-stack ui-stack--wrap ui-stack--vertical ui-stack--spacing-tight">
										<h3 class="ui-subheading">Khối lượng</h3>
										<p class="type--subdued">Được dùng để tính phí vận chuyển ở trang thanh toán</p>
									</div>
									<div class="form-group">
										<div class="input-group double-input mb10">
											<input type="text" class="form-control numberonly" name="iso-weight" value="{$oneItem.weight}" />
											<select class="form-control" name="unit">
												{$clsProperty->getSelectByProperty('Unit', $oneItem.unit)}
											</select>
										</div>
										<a href="{$PCMS_URL}/index.php?mod=property&type=Unit" title="{$core->get_Lang('Manage Unit')}">{$core->get_Lang('Manage Unit')}</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row-bottom">
						<div class="row-buttons">
							<div class="clear"></div>
							<button type="submit" class="btn-update" id="SaveVoucherStep2" name="submit" value="Update">
							<i class="iso-update"></i> {$core->get_Lang('Save')}
						  </button>
							<input type="hidden" name="UpdateStep2" value="UpdateStep2" />
							<input type="hidden" name="is_set" value="{$smarty.get.is_set}" />
						</div>
					</div>
				</form>
			</div>
			<div class="tabbox" style="display:none">
			 <form method="post" action="" enctype="multipart/form-data">
			    <input type="hidden" id="hid_voucher_id" name="hid_voucher_id" value="{$pvalTable}" />
				<input type="hidden" name="UpdateStep3" value="UpdateStep3" />
				 {$core->getBlock('meta_box_detail')}
				 <fieldset class="submit-buttons">
					{$saveBtn}
				 </fieldset>
			 </form>
			</div>
			{/if}
		</div>
        <div class="clearfix"><br /></div>
        {*<fieldset class="submit-buttons">
            {$saveBtn}{$saveList}
            <input value="Update" name="submit" type="hidden" />
		</fieldset>*}
</div>
{literal}
<script>
$(".showdate").datepicker({dateFormat: "dd/mm/yy"});
</script>
{/literal}
<script type="text/javascript">
	var voucher_id = '{$pvalTable}';
	var $voucher_id = '{$pvalTable}';
	var $type = 'BLOG';
	var $SiteHasDestinationVoucher=1;
	var $SiteHasTags_Voucher = "{$clsConfiguration->getValue('SiteHasTags_Voucher')}";
	var $SiteModActive_country = "{$clsConfiguration->getValue('SiteModActive_country')}";
	var $SiteModActive_continent = "{$clsConfiguration->getValue('SiteModActive_continent')}";
	var $SiteActive_region = "{$clsConfiguration->getValue('SiteActive_region')}";
	var $SiteActive_city = "{$clsConfiguration->getValue('SiteActive_city')}";
	var $Selectavalue= "{$core->get_Lang('Selectavalue')}";
	var $Selectafewvalues= "{$core->get_Lang('Selectafewvalues')}";
	var $Nomatchingresults= "{$core->get_Lang('Nomatchingresults')}";
	var $SiteHasTourExtension = "{$clsConfiguration->getValue('SiteHasTourExtension')}";
	var $SiteHasCruiseExtension = "{$clsConfiguration->getValue('SiteHasCruiseExtension')}";
	var $SiteHasHotelExtension = "{$clsConfiguration->getValue('SiteHasHotelExtension')}";
</script>
<link rel="stylesheet" href="{$URL_CSS}/bootstrap.css?v={$upd_version}" type="text/css" media="all">
<link rel="stylesheet" href="{$URL_CSS}/chosen.css?v={$upd_version}" type="text/css" media="all">
<script type="text/javascript" src="{$URL_JS}/chosen.jquery.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_THEMES}/voucher/js/jquery.voucher.js?v={$upd_version}"></script>