{if $lstHotelRoomAll}
<div class="room_info">
	<div class="row">
		<div class="col-md-8">
			<div class="list_room">
				{foreach from=$lstHotelRoomAll item=item name=item}
				{assign var=hotel_room_id value=$item.hotel_room_id}
				{assign var=title_room value=$clsHotelRoom->getTitle($hotel_room_id,$item)}
				{assign var=roomBed value=$clsHotelRoom->getRoomBed($hotel_room_id,$item)}
				{assign var=roomSize value=$clsHotelRoom->getRoomSize($hotel_room_id,$item)}
				{assign var=numberAdult value=$clsHotelRoom->getNumberAdult($hotel_room_id,$item)}
				<div class="room_item">
					<div class="room_photo">
						<img class="img100" alt="{$title_room}" src="{$clsHotelRoom->getImage($hotel_room_id,407,344,$item)}"/>
					</div>
					<div class="room_body">
						<h3 hotel_room_id={$hotel_room_id}>{$title_room}</h3>
						<div class="info">
							<p class="mb10" lang_id="{$_LANG_ID}"><i class="icon_info_room icon_bed"></i>	{$core->get_Lang('Bed')}: {$roomBed}</p>
							<p class="mb10"><i class="icon_info_room icon_size"></i> {$core->get_Lang('Room size')}: {$roomSize} m<sup>2</sup></p>
							<p class="mb10"><i class="icon_info_room icon_user"></i>{$core->get_Lang('Max')} ({$core->get_Lang('adult')}): {$numberAdult} </p>
							<a class="entry_it_more pull-left fs-15 color_333" href="javascript:void(0);" title="{$core->get_Lang('Show more')}" rel="nofollow" data-bs-toggle="modal" data-bs-target="#roomModalB{$hotel_room_id}">
								{$core->get_Lang('Show more')}
							</a>
						</div>
                        {if 1==2}
                        <form action="" method="post">
							<input type="hidden" name="hotel_id" value="{$hotel_id}" />
							<input type="hidden" name="hotel_room_id" value="{$hotel_room_id}" />
							<input type="hidden" name="check_in" value="{$check_in}" />
							<input type="hidden" name="check_in" value="{$check_in}" />
							<input type="hidden" name="check_out"  value="{$check_out}" />
							<input type="hidden" name="number_room" value="{$number_room}" />
							<input type="hidden" name="number_adult" value="{$number_adult}" />
							<input type="hidden" name="number_child" value="{$number_child}" />
							<input type="hidden" name="ContactHotel" id="ContactHotel" value="ContactHotel" />
							
						</form>
                        {/if}
						{$clsHotelRoom->getPriceCheckRate($hotel_id,$hotel_room_id,$check_in,$check_out,$number_adult,$number_child)}
						
						<div class="modal fade roomModal" id="roomModalB{$hotel_room_id}" tabindex="-1" role="dialog" aria-labelledby="roomModalLabel" aria-hidden="false">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content" id="container-room-detail">
									<div class="modal-header">
										<button type="button" class="btn-close c6" data-bs-dismiss="modal" aria-label="Close">
										</button>
										<h4 class="modal-title" id="roomModalLabel">{$title_room}</h4>
									</div>
									<div class="modal-body">
										<div class="room_info mb40 phone_mb20">
											<div class="row">
												{if $roomBed}
												<div class="col-md-4 col-sm-4 col-sm-6">
													<p class="mb0" ><i class="icon_info_room icon_bed"></i>	{$core->get_Lang('Bed')}: {$roomBed}</p>
												</div>
												{/if}
												<div class="col-md-4 col-sm-4 col-sm-6">
												<p class="mb0"><i class="icon_info_room icon_size"></i> {$core->get_Lang('Room size')}: {$roomSize} m<sup>2</sup></p>
												</div>
												<div class="col-md-4 col-sm-4 col-sm-6">
												<p class="mb0"><i class="icon_info_room icon_user"></i>{$core->get_Lang('Max')} ({$core->get_Lang('adult')}): {$numberAdult} </p>
												</div>
												{*<div class="col-md-4 col-sm-4 col-sm-6">
												<p class="mb0" ><i class="icon_info_room icon_bed"></i>	{$core->get_Lang('Extra Bed')}: {if $clsHotelRoom->getOneField('extra_bed',$hotel_room_id)==1}{$core->get_Lang('Yes')}{else}{$core->get_Lang('No')}{/if}</p>
												</div>*}
											</div>
										</div>
										{*<div class="room_facility">
											<h5><span>{$core->get_Lang('Room Facilities')}</span></h5>
											<div class="list_facility">
												{$clsHotelRoom->getRoomFa($hotel_room_id)}
											</div>
										</div>*}
									</div><!--end modal-body-->
								</div><!--end modal-content -->
							</div><!--end modal-dialog-->
						</div><!--end modal-->
					</div>
				</div>
				{/foreach}
			</div>
		</div>
		<div class="col-md-4">
			<div class="sticky_fix">
				<div class="info_room_book">

				</div>
			</div>
		</div>
	</div>
</div>
<script>
var hotel_id='{$hotel_id}';
var number_adult='{$number_adult}';
var number_child='{$number_child}';
var check_in='{$check_in}';
var check_out='{$check_out}';
</script>
{literal}
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function () {
		loadChooseHotelRoom(hotel_id,number_adult,number_child,check_in,check_out); 
		function loadChooseHotelRoom($hotel_id,$number_adult,$number_child,$check_in,$check_out){
			
			var adata = {
				'hotel_id': $hotel_id,
				'check_in' : $check_in,
				'check_out' : $check_out,
				'number_adult' : $number_adult,
				'number_child' : $number_child,
			};
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod=hotel2&act=ajChooseHotelRoom&lang='+LANG_ID,
				data: adata,	
				dataType:'html',	
				success:function(html){
					$('.info_room_book').html(html);
				}
			});
		}
			
		$(document).on('change', '.number_room', function(ev){
			ev.preventDefault();
			var _this = $(this);
			var adata = {
				'hotel_id'   				:_this.data('hotel_id'),
				'hotel_room_id'   			:_this.data('hotel_room_id'),
				'check_in'   				:_this.data('check_in'),
				'check_out'   				:_this.data('check_out'),
				'number_adult'   			:_this.data('number_adult'),
				'number_child'   			:_this.data('number_child'),
				'number_room'   			:_this.val(),
				'totalprice'   				:_this.data('totalprice'),
			};
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajChooseHotelRoom&lang='+LANG_ID,
				data: adata,	
				dataType:'html',	
				success:function(html){
					$('.info_room_book').html(html);
				}
			});
		});
		$(document).on('click', '.delete_room', function(ev){
			ev.preventDefault();
			var _this = $(this),hotel_room_id=_this.data('hotel_room_id');
			
			var adata = {
				'hotel_id'   				:_this.data('hotel_id'),
				'hotel_room_id'   			:_this.data('hotel_room_id'),
				'check_in'   				:_this.data('check_in'),
				'check_out'   				:_this.data('check_out'),
				'number_adult'   			:_this.data('number_adult'),
				'number_child'   			:_this.data('number_child'),
				'type'   	:'D',

			};
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajChooseHotelRoom&lang='+LANG_ID,
				data: adata,	
				dataType:'html',	
				success:function(html){
					$('.info_room_book').html(html);
					$('#hotel_room_'+hotel_room_id).val(0);
				}
			});
		});
		$(document).on('click', '#book_now_room', function(ev){
			ev.preventDefault();
			var _this = $(this);
			var adata = {
				'hotel_id'   				:_this.data('hotel_id'),
				'hotel_room_id'   	:_this.data('hotel_room_id'),
				'type'   	:'BOOKNOW',

			};
			$.ajax({
				type:'POST',
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajChooseHotelRoom&lang='+LANG_ID,
				data: adata,	
				dataType:'html',	
				success: function(html){
					location.href = html;
			}
			});
		});
	})
</script>
{/literal}
{/if}