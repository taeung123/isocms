<link href="{$URL_CSS}/pretty-checkbox.min.css?v={$upd_version}" rel="stylesheet" />
<div class="headPop">
	<h3>{$core->get_Lang('syncTourAPItoTMS')}</h3>
	<a href="javscript:void(0);" class="close_pop closeEv"></a>
</div>
<div class="modal-body mt-40">
	<span class="help-block">Chọn tour cần đồng bộ</span>
	<div class="form-group form-row">

		<div class="col-xs-12 col-md-8">
			<div class="custom-search-input">
				<input class="form-control input-lg mb-2 iso_search_field" toClass="trTourToTMS" name="keysearch" id="keysearch" maxlength="255" charset="UTF-8" lang="{$_LANG_ID}" placeholder="Nhập từ khóa để tìm kiếm" />
				<span class="loading hidden">{$clsISO->makeIcon('circle-o-notch fa-spin fa-2x fa-fw')}</span>
			</div>
			<span class="help-block">Gợi ý: Tên, mã Tour...</span>
		</div>
	</div>
	<div holder-results class="js_scroller holder_tour_to_tms" data-slimScroll-height="450px">
		{$clsISO->loadingMessage()}
	</div>
</div>
<div class="modal-footer">
	<a href="javascript:void(0)" class="btn btn-success syncTourToTMS">{$core->get_Lang('Sync')}<i class="fa fa-share ml-2" aria-hidden="true"></i></a>
</div>