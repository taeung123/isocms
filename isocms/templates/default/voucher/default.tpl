<div class="page_container page_voucher">
   <nav class="breadcrumb-main breadcrumb-{$mod} bg_fff">
      <div class="container">
         <ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
               <a itemprop="item" href="{$PCMS_URL}">
               <span itemprop="name" class="reb">{$core->get_Lang('Trang chủ')}</span></a>
               <meta itemprop="position" content="1" />
            </li>
             <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
               <a itemprop="item" href="{$curl}">
               <span itemprop="name" class="reb">{$core->get_Lang('Vouchers')}</span></a>
               <meta itemprop="position" content="2" />
            </li>
         </ol>
      </div>
   </nav>
   <main class="maincontent bg_fff">
      <section class="introPage">
         <div class="container">
            <div class="introbox mb40">
               <h1 class="title bold upcase">{$core->get_Lang('voucher')}</h1>
               {assign var=site_voucher_intro value=site_voucher_intro_|cat:$_LANG_ID}
               <div class="intro">{$clsConfiguration->getValue($site_voucher_intro)|html_entity_decode}</div>
            </div>
         </div>
      </section>
       <section class="tourTravelonPage">
           <div class="container">
               <div class="contentListTravel">
                   <div class="row">
                       <div class="col-lg-3">
                           <div class="sticky_fix">
                               <div class="block991" style="display:none">
                                   <div class="tag-search">
                                       <div class="btn_open_modal btn_quick_search" data-bs-toggle="modal"
                                            data-bs-target="#filter_search">
                                           <span>{$core->get_Lang('Filter Trip')}</span> <i class="fa fa-sliders" aria-hidden="true"></i>
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
                                                       <button type="button" class="close" data-bs-dismiss="modal">
                                                           <span aria-hidden="true">X</span>
                                                           <span class="sr-only">{$core->get_Lang('Close')}</span>
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
                           </div>
                       </div>
                       <div class="col-lg-9">
                           <div class="listTourItem">
                               <div class="row">
                                    {foreach from=$lstVoucher item=voucher}
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col_item">
                                            {$clsISO->getBlock('voucherbox', [
                                                "voucher_id" => $voucher.voucher_id,
                                                "arrVoucher" => $voucher
                                            ])}
                                        </div>
                                    {/foreach}
                               </div>
                           </div>
                           {if $totalPage|default:0 gt '1'}
                               <div class="clearfix"></div>
                               <div class="pagination pager">
                                   {$page_view}
                               </div>
                           {/if}
                       </div>
                   </div>
               </div>
           </div>
       </section>
   </main>
</div>
<script >
   var min_duration_value = '{$min_duration}';
   var max_duration_value = '{$max_duration}';
   var country_id ='{$country_id}';
   var city_id ='{$city_id}';
   var totalpage ='{$totalPage}';
</script>