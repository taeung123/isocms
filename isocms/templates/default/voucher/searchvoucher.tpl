<section class="tourTravelonPage PageSearch">
   <div class="container">
      <p class="titlebox h3 bold upcase">{$core->get_Lang("Voucher")} {$title}</p>
      <div class="contentListTravel">
         <div class="row">
            <div class="col-lg-3">
               <div class="block991" style="display:none">
                  <div class="tag-search">
                     <div class="btn_open_modal btn_quick_search" data-bs-toggle="modal"
                        data-bs-target="#filter_search">
                        <span>{$core->get_Lang('Filter Trip')}</span> <i class="fa fa-sliders"
                           aria-hidden="true"></i>
                     </div>
                  </div>
               </div>

               <div class="modal fade" id="filter_search" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                     <div class="modal-content">
                        <div class="filter_left">
                           <div class="modal-header">
                              <h2>
                                 <button type="button" class="close" data-bs-dismiss="modal"><span
                                            aria-hidden="true">X</span><span
                                            class="sr-only">{$core->get_Lang('Close')}</span>
                                 </button> {$core->get_Lang('Search')}
                              </h2>
                           </div>
                           <div class="modal-body">
                              <div class="totalTour mb20">
                                 <p class="totalTourpage h3">{$core->get_Lang('Find')} {$totalVoucher} {if $totalTour gt 1}{$core->get_Lang('Voucher')}{else}{$core->get_Lang('Vouchers')}{/if}</p>
                              </div>
                              {$core->getBlock('filter_left_trip_voucher')}
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               
{*               <div class="modal fade" id="filter_search" tabindex="-1" role="dialog"*}
{*                  aria-labelledby="myModalLabel" aria-hidden="true">*}
{*                  <div class="filter_left">*}
{*                     <div class="modal-header">*}
{*                        <p>*}
{*                           <button type="button" class="close" data-dismiss="modal"><span*}
{*                              aria-hidden="true">X</span><span*}
{*                              class="sr-only">{$core->get_Lang('Close')}</span>*}
{*                           </button> {$core->get_Lang('Search')}*}
{*                        </p>*}
{*                     </div>*}
{*                     <div class="modal-body">*}
{*                        <div class="totalTour mb20">*}
{*                           <p class="totalTourpage h3">{$core->get_Lang('Find')} {$totalVoucher} {if $totalTour gt 1}{$core->get_Lang('Voucher')}{else}{$core->get_Lang('Voucher')}{/if}</p>*}
{*                        </div>*}
{*                        {$core->getBlock('filter_left_trip_voucher')}*}
{*                     </div>*}
{*                  </div>*}
{*               </div>*}

            </div>
            <div class="col-lg-9">
               <div class="listTourItem">
                  <div class="row">
                    {section name=i loop=$lstVoucherResult}
					{assign var=voucher_id value=$lstVoucherResult[i].voucher_id}
					{assign var=arrVoucher value=$lstVoucherResult[i]}
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col_item">
					   {$clsISO->getBlock('voucherbox',[
							"voucher_id"	=>$voucher_id,
							"arrVoucher"	=>$arrVoucher
					   ])}
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