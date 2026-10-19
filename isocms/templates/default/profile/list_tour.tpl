<div class="masthead" style="margin:20px 0;padding:8px 0px;background-color: #ec2427;box-shadow: 0 2px 4px 0 rgba(0,0,0,.25);"> 
	<div class="container" style="margin-top:0px;">	
		 <form class="form-horizontal" action="" method="get">
          <fieldset>
            <div id="legend">
              <legend class="" style="margin-bottom: 0px;">Search</legend>
            </div>
			 <div class="control-group col-md-2">
              <label class="control-label">{$core->get_Lang('tourcategory')}</label>
              <div class="controls">
                <select onchange="_reload()" name="cat_id" class="slb form-control" id="slb_Category" style="width:170px;">
					{$clsTourCat->makeSelectboxOption($tour_group_id, $get.cat_id, $is_set)}
				</select>
              </div>
            </div>
            <div class="control-group col-md-2">
              <label class="control-label">{$core->get_Lang('numberday')}</label>
              <div class="controls">
				   <select onchange="_reload()" name="number_day" class="slb form-control" style="width:170px;">
						 <option value="0">-- {$core->get_Lang('Number days')} --</option>
						 {$clsISO->makeSelectNumber2(30,$get.number_day)}
					</select>
              </div>
            </div>
         
            <div class="control-group col-md-2">
              <label class="control-label">{$core->get_Lang('Keyword')}</label>
              <div class="controls">
              		<input type="text" value="{$get.keyword}" name="keyword" class="form-control" placeholder="{$core->get_Lang('Keyword')}" autocomplete="off" width="170px" />
              </div>
            </div>
         
            <div class="control-group col-md-2">
              <label class="control-label">{$core->get_Lang('depart_start')}</label>
              <div class="controls">
               <input type="text" value="{$get.depart_start}" name="depart_start" class="form-control datepicker" placeholder="{$core->get_Lang('depart_start')}" autocomplete="off" width="120px" />
              </div>
            </div>
         
            <div class="control-group col-md-2">
              <label class="control-label">{$core->get_Lang('depart_end')}</label>
              <div class="controls">
               <input type="text" value="{$get.depart_end}" name="depart_end" class="form-control datepicker" placeholder="{$core->get_Lang('depart_end')}" autocomplete="off" width="120px" />
              </div>
            </div>
         
            <div class="control-group col-md-2">
              <!-- Button -->
			  <label class="control-label">{$core->get_Lang('Search')}</label>
              <div class="controls">
			  		
                	<button type="submit" class="btn btn-info">
					     <span class="glyphicon glyphicon-search"></span> Search
					</button>
					<a href="{$PCMS_URL}profile/my-profile.html">Profile</a>
              </div>
            </div>
          </fieldset>
        </form>					
	</div>	
</div>
<div class="container">		
	<form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
        <table cellspacing="0" class="tbl-grid table" width="100%">
				<tr>
					<td class="gridheader" style="text-align:center"><strong>ID</strong></td>
					<td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('nameoftrips')}</strong></td>
					<td class="gridheader" style="text-align:center"><strong>{$core->get_Lang('duration')}</strong></td>
          			{if $clsConfiguration->getValue('SiteHasCat_Tours')}
					<td class="gridheader" style="text-align:center;"><strong>{$core->get_Lang('travelstyles')}</strong></td>
					{/if}
					<td class="gridheader" style="text-align:center; width:8%"><strong>{$core->get_Lang('pricefrom')}</strong></td>					
					<td class="gridheader" style="text-align:center;"><strong>{$core->get_Lang('func')}</strong></td>
				</tr>
				{if !empty($listAgenOfTour)}
				{section name=i loop=$listAgenOfTour}
				<tr class="{cycle values="row1,row2"}">
					<td class="index" style="text-align:center">{$listAgenOfTour[i].tour_id}</td>
					<td>
                    	<strong>{if $clsTour->getOneField('is_online',$listAgenOfTour[i].tour_id) eq 0}<span style="color:#F90">[PRIVATE]</span>{/if}
						 <a href="{$DOMAIN_NAME}{$clsTour->getLink($listAgenOfTour[i].tour_id)}" rel="nofollow" target="_blank">
						 {$clsTour->getTitle($listAgenOfTour[i].tour_id)}
						 </a>
						 </strong>
						{if $listAgenOfTour[i].is_trash eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
					</td>
					<td class="text-left" style="white-space:nowrap">
						{$clsTour->getTripDuration($listAgenOfTour[i].tour_id)}
					</td>
                    {if $clsConfiguration->getValue('SiteHasCat_Tours')}
						<td>{$clsTour->getCatName($listAgenOfTour[i].tour_id)}</td>
					{/if}					
					<td style="text-align:right; white-space:nowrap">
						{$clsISO->getRateSign()}  
						<strong class="format_price">
							{assign var=trip_price value=$clsTour->getOneField('trip_price',$listAgenOfTour[i].tour_id)}
							{assign var=type_promo value=$listAgenOfTour[i].type_promo}
							{assign var=val_discount value=$listAgenOfTour[i].val}
							{if $type_promo eq $PROMO_VALUE}
								{assign var=trip_price value=math equation='x - y' x=$trip_price y=$val_discount}
							{/if}
							{if $type_promo eq $PROMO_PERCENT}
								{math assign="trip_price" equation='x-y*x/100' x=$trip_price y=$val_discount} 
							{/if}
							{$clsISO->formatNumberToEasyRead($trip_price)}
						</strong>
					</td>
					                 
					<td align="center" style="vertical-align: middle; text-align:center; width: 120px; white-space: nowrap;">
						<a class="btn btn-danger" tour_store_id="{$core->encryptID($listAgenOfTour[i].tour_store_id)}" 
						 href="{$DOMAIN_NAME}{$clsTour->getLink($listAgenOfTour[i].tour_id)}" rel="nofollow" target="_blank" title="{$core->get_Lang('View')}">
						<i class="icon-upload icon-white"></i> 
						{$core->get_Lang('View')}
						</a>
						<a class="btn btn-danger" tour_store_id="{$core->encryptID($listAgenOfTour[i].tour_store_id)}" 
						href="{$PCMS_URL}booking/tour_details/{$core->encryptID($listAgenOfTour[i].tour_id)}" rel="nofollow" 
						 title="{$core->get_Lang('Book')}">
						<i class="icon-upload icon-white"></i> 
						{$core->get_Lang('Book')}
						</a>						
					</td>
				</tr>
				{/section}
				{else}<tr><td colspan="15">{$core->get_Lang('nodata')}!</td></tr>{/if}
			</table>		
    </form>
</div>
{literal}
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			$('.datepicker').datepicker({dateFormat: 'dd/mm/yy'});
			$(".slb_Country").live('change',function(){
				$.ajax({
					type: "POST",
					url: path_ajax_script+'admin/?mod=tour&act=ajmakeSelectCityGlobal',	
					data:{'country_id':$(this).val()},
					dataType: "html",
					success: function(html){
						$('.city_tour').html('<select name="city_id" class="formcontrol" style="width:200px;float:right;">'+html+'</select>');
					}
				}); 
			});
			$(".clkBookTourStore").live('click',function(){
				var $_this = $(this);
				$.ajax({
					type: "POST",
					url: $_this.attr('href'),	
					dataType: "html",
					success: function(html){
						alert('sssssss');
					}
				}); 
			});
		})
	</script>
{/literal}