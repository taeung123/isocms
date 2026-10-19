<section class="tourTravelonPage page_container">
<div class="container pd50_0">
	<h1 class="titlebox h3 text_normal upcase">{$core->get_Lang("tour du lịch")} {$title}</h1>
	<div class="contentListTravel">
	   <div class="row">
		  <div class="col-lg-3">
			<div class="block991" style="display:none">
				<div class="tag-search">
					<div class="btn_open_modal btn_quick_search bg_main" data-bs-toggle="modal" data-bs-target="#filter_search" >
						<span>{$core->get_Lang('Filter Trip')}</span> <i class="fa fa-sliders" aria-hidden="true"></i>
					</div>
				</div>
			</div> 
			<div class="modal fade" id="filter_search" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="filter_left">
							<div class="modal-header">
								<button type="button" class="close" data-bs-dismiss="modal"><span aria-hidden="true">X</span><span class="sr-only">{$core->get_Lang('Close')}</span></button> {$core->get_Lang('Search')}
							</div>
							<div class="modal-body">
								<div class="totalTour mb20">
								   <h2 class="totalTourpage bg_main h3">{$core->get_Lang('Find')} {$totalTour} {if $totalTour gt 1}{$core->get_Lang('Tours')}{else}{$core->get_Lang('Tour')}{/if}</h2>
								</div>
								{$core->getBlock('filter_left_trip')}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-9">
			<div class="listTourItem">
				<div class="row">
				   {section name=i loop=$lstTourResult}
				   <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
					  {assign var=tour_id value=$lstTourResult[i].tour_id}
					  {assign var=oneTour value=$lstTourResult[i]}
						{$clsISO->getBlock('box_item_tour_mobile',["tour_id"=>$tour_id,"oneTour"=>$oneTour])}
				   </div>
				   {/section}
				</div>
			 </div>
			 {if $totalPage gt '1'}
				<div class="clearfix"></div>
				<div class="pagination">
					{$page_view}
				</div>
			{/if}
		  </div>
	   </div>
	</div>
</div>
</section>