<div class="page_container page-tour_setting">
	{$core->getBlock('header_title_module_setting')}
	<div class="container-fluid container-fluid-2 d-flex">
		{$core->getBlock('menu_hotel_setting')}
		<div class="content_setting_box">
			<div class="page_detail-title d-flex">
				<div class="title">
					<h2>{$core->get_Lang('Price range')}</h2>
				</div>
				<div class="button_right">
					<a class="btn btn-main btn-addnew btnCreatePriceRange" href="javascript:void(0);" title="{$core->get_Lang('Add')} {$core->get_Lang('Price range')}">{$core->get_Lang('Add')} {$core->get_Lang('Price range')}</a>
				</div>
			</div>
			<div class="fl fiterbox" style=" width:100%">
				<div class="wrap">
					<div class="filter_box">
						<form id="forums" method="post" class="filterForm" action="" onsubmit="return false">
							<div class="form-group form-keyword">
								<input class="form-control" type="text" name="keyword" value="{$keyword|default:''}" placeholder="{$core->get_Lang('search')}" />
							</div>
							<div class="form-group form-button">
								<button type="submit" class="btn btn-main findPriceRange" id="findtBtn">{$core->get_Lang("Search")}</button>
								<input type="hidden" name="filter" value="filter" />
							</div>
						</form>	
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="hastable">
				<table class="tbl-grid table-striped" cellpadding="0" width="100%">
					<thead>
						<tr>
							<th class="gridheader hiden767" style=" width:4%">{$core->get_Lang('index')}</th>
							<th class="gridheader" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></th>
							<th class="gridheader" style="text-align:right"><strong>{$core->get_Lang('minrate')}</strong></th>
							<th class="gridheader" style="text-align:right"><strong>{$core->get_Lang('maxrate')}</strong></th>
							<th class="gridheader" style="width:3%" colspan="4"><strong>{$core->get_Lang('move')}</strong></th>
							<th class="gridheader" style="text-align:center;"><strong>{$core->get_Lang('func')}</strong></th>
						</tr>
					</thead>
					<tbody id="tblHolderPriceRange">
					</tbody>
				</table>
			</div>
		</div>		
	</div>
</div>
<script type="text/javascript" src="{$URL_THEMES}/hotel/jquery.hotel.js?v={$upd_version}"></script>