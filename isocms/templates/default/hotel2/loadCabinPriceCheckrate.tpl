<div class="cabin_info">
	<div class="row">
		<div class="col-md-8">
			<div class="list_cabin">
				{if $lstCruiseCabinID}
				{foreach from=$lstCruiseCabinID item=item name=item}
				{assign var=cruise_cabin_id value=$item.cruise_cabin_id}
				{assign var=title_cabin value=$clsCruiseCabin->getTitle($cruise_cabin_id)}
				<div class="cabin_item">
					<div class="cabin_photo">
						<img class="img100" alt="{$title_cabin}" src="{$clsCruiseCabin->getImage($cruise_cabin_id,407,344)}"/>
					</div>
					<div class="cabin_body">
						<h3 cruise_cabin_id={$cruise_cabin_id}>{$title_cabin}</h3>
						<div class="info">
							<p class="mb10" lang_id="{$_LANG_ID}"><i class="icon_info_cabin icon_bed"></i>	{$core->get_Lang('Bed')}: {$clsCruiseCabin->getBedOption($cruise_cabin_id)}</p>
							<p class="mb10"><i class="icon_info_cabin icon_size"></i> {$core->get_Lang('Cabin size')}: {$clsCruiseCabin->getCabinSize($cruise_cabin_id)} m<sup>2</sup></p>
							<p class="mb10"><i class="icon_info_cabin icon_user"></i>{$core->get_Lang('Max')} ({$core->get_Lang('adult')}): {$clsCruiseCabin->getMaxAdult($cruise_cabin_id)} </p>
							<a class="entry_it_more pull-left fs-15 color_333" href="javascript:void(0);" title="{$core->get_Lang('Show more')}" rel="nofollow" data-toggle="modal" data-target="#roomModalB{$cruise_cabin_id}">
								{$core->get_Lang('Show more')}
							</a>
						</div>
						
						{$clsCruiseCabin->getLCheckRatePriceCabinCruise($cruise_cabin_id,$arraycheckrateCabin,$promotion_date,$cruise_id)}
						<div class="modal fade roomModal" id="roomModalB{$cruise_cabin_id}" tabindex="-1" role="dialog" aria-labelledby="roomModalLabel" aria-hidden="false">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content" id="container-room-detail">
									<div class="modal-header">
										<button type="button" class="close c6" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true" class="fa fa-times"></span>
										</button>
										<h4 class="modal-title text-uppercase" id="roomModalLabel">{$title_cabin}</h4>
									</div>
									<div class="modal-body">
										<div class="row">
											<div class="col-md-6">
												<img alt="{$title_cabin}" class="img100" src="{$clsCruiseCabin->getImage($cruise_cabin_id,409,218)}"/>
												<div class="m-item" style="margin-top:30px">
													<h5><span>{$core->get_Lang('DESCRIPTION')}</span></h5>
													<div class="m-content">
														<p><strong>{$core->get_Lang('Cabin size')}:</strong> {$clsCruiseCabin->getCabinSize($cruise_cabin_id)} m<sup>2</sup></p>
														<p><strong>{$core->get_Lang('Bed options')}:</strong> {$clsCruiseCabin->getBedOption($cruise_cabin_id)}</p>
														<p><strong>{$core->get_Lang('Max Adults')}:</strong>  {$clsCruiseCabin->getMaxAdult($cruise_cabin_id)}</p>
														<p><strong>{$core->get_Lang('Extra Bed')}:</strong>  {if $clsCruiseCabin->getOneField('extra_bed',$cruise_cabin_id)==0}{$core->get_Lang('Yes')}{else}{$core->get_Lang('No')}{/if}</p>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="m-item">
													<h5><span>{$core->get_Lang('Cabin Facilities')}</span></h5>
													<div class="m-content">
														{$clsCruiseCabin->getCabinFa($cruise_cabin_id)}
													</div>
												</div>
											</div>
										</div>
									</div><!--end modal-body-->
								</div><!--end modal-content -->
							</div><!--end modal-dialog-->
						</div><!--end modal-->
					</div>
				</div>
				{/foreach}
				{/if}
				{if $lstCruiseCabin}
				{section name=i loop=$lstCruiseCabin}
				{assign var=cruise_cabin_id value=$lstCruiseCabin[i].cruise_cabin_id}
				{assign var=title_cabin value=$clsCruiseCabin->getTitle($lstCruiseCabin[i].cruise_cabin_id)}
				<div class="cabin_item">
					<div class="cabin_photo">
						<img class="img100" alt="{$title_cabin}" src="{$clsCruiseCabin->getImage($cruise_cabin_id,407,344)}"/>
					</div>
					<div class="cabin_body">
						<h3 cruise_cabin_id={$cruise_cabin_id}>{$title_cabin}</h3>
						<div class="info">
							<p class="mb10" lang_id="{$_LANG_ID}"><i class="icon_info_cabin icon_bed"></i>	{$core->get_Lang('Bed')}: {$clsCruiseCabin->getBedOption($cruise_cabin_id)}</p>
							<p class="mb10"><i class="icon_info_cabin icon_size"></i> {$core->get_Lang('Cabin size')}: {$clsCruiseCabin->getCabinSize($cruise_cabin_id)} m<sup>2</sup></p>
							<p class="mb10"><i class="icon_info_cabin icon_user"></i>{$core->get_Lang('Max')} ({$core->get_Lang('adult')}): {$clsCruiseCabin->getMaxAdult($cruise_cabin_id)} </p>
							<a class="entry_it_more pull-left fs-15 color_333" href="javascript:void(0);" title="{$core->get_Lang('Show more')}" rel="nofollow" data-toggle="modal" data-target="#roomModalB{$cruise_cabin_id}">
								{$core->get_Lang('Show more')}
							</a>
						</div>
						
						<div class="priceCheckrate">
							<a href="{$clsISO->getLink('contacts')}" title="{$core->get_Lang('Contact us')}" class="cabin_selected btn_main">{$core->get_Lang('Contact us')}</a>
						</div>
						<div class="modal fade roomModal" id="roomModalB{$cruise_cabin_id}" tabindex="-1" role="dialog" aria-labelledby="roomModalLabel" aria-hidden="false">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content" id="container-room-detail">
									<div class="modal-header">
										<button type="button" class="close c6" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true" class="fa fa-times"></span>
										</button>
										<h4 class="modal-title text-uppercase" id="roomModalLabel">{$title_cabin}</h4>
									</div>
									<div class="modal-body">
										<div class="row">
											<div class="col-md-6">
												<img alt="{$title_cabin}" class="img100" src="{$clsCruiseCabin->getImage($cruise_cabin_id,409,218)}"/>
												<div class="m-item" style="margin-top:30px">
													<h5><span>{$core->get_Lang('DESCRIPTION')}</span></h5>
													<div class="m-content">
														<p><strong>{$core->get_Lang('Cabin size')}:</strong> {$clsCruiseCabin->getCabinSize($cruise_cabin_id)} m<sup>2</sup></p>
														<p><strong>{$core->get_Lang('Bed options')}:</strong> {$clsCruiseCabin->getBedOption($cruise_cabin_id)}</p>
														<p><strong>{$core->get_Lang('Max Adults')}:</strong>  {$clsCruiseCabin->getMaxAdult($cruise_cabin_id)}</p>
														<p><strong>{$core->get_Lang('Extra Bed')}:</strong>  {if $clsCruiseCabin->getOneField('extra_bed',$cruise_cabin_id)==0}{$core->get_Lang('Yes')}{else}{$core->get_Lang('No')}{/if}</p>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="m-item">
													<h5><span>{$core->get_Lang('Cabin Facilities')}</span></h5>
													<div class="m-content">
														{$clsCruiseCabin->getCabinFa($cruise_cabin_id)}
													</div>
												</div>
											</div>
										</div>
									</div><!--end modal-body-->
								</div><!--end modal-content -->
							</div><!--end modal-dialog-->
						</div><!--end modal-->
					</div>
				</div>
				{/section}
				{/if}
			</div>
			
		</div>
		<div class="col-md-4">
			<div class="info_cabin_book">
			
			</div>
		</div>
	</div>
</div>
<script>
var itinerary_cruise_id='{$cruise_itinerary_id}';
var departure_date='{$departure_date}';
</script>
{literal}
<script type="text/javascript">
loadChooseCabinCruise(itinerary_cruise_id,departure_date); 
function loadChooseCabinCruise($cruise_itinerary_id,$departure_date){
	var adata = {
		'cruise_itinerary_id': $cruise_itinerary_id,
		'departure_date' : $departure_date,
	};
	$.ajax({
		type:'POST',
		url:path_ajax_script+'/index.php?mod='+mod+'&act=ajChooseCabinCruise',
		data: adata,	
		dataType:'html',	
		success:function(html){
			$('.info_cabin_book').html(html);
		}
	});
}
</script>
{/literal}