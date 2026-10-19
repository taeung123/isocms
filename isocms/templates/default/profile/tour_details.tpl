<div class="container" style="margin-top:10px;">
	<h1>{$oneTour.title}</h1>
	{assign var=trip_price value=$clsTour->getOneField('trip_price',$oneTour.tour_id)}
	{assign var=type_promo value=$oneTour.type_promo}
	{assign var=val_discount value=$oneTour.val}
	{if $type_promo eq $PROMO_VALUE}
		{assign var=trip_price value=math equation='x - y' x=$trip_price y=$val_discount}
	{/if}
	{if $type_promo eq $PROMO_PERCENT}
		{math assign="trip_price" equation='x-y*x/100' x=$trip_price y=$val_discount} 
	{/if}	
	<h1>{$clsISO->getRateSign()}  {$clsISO->formatNumberToEasyRead($trip_price)}</h1>
	<form action="" method="post" name="form">
		<div class="form-group">
			<label for="email">Start Date</label>
		 	<input type="text" class="form-control datepicker" name="data[start_date]" readonly="readonly" style="width:200px">
		</div>
		<div class="form-group">
		  	<label for="email">Dult</label>
		  	<input type="number" class="form-control adult" name="data[adult]" value="1" style="width:200px">
		</div>
		<div class="form-group">
		 	<label for="pwd">Children</label>
		  	<input type="number" class="form-control children" name="data[children]" value="1" style="width:200px">
		</div>
		<div class="form-group">
		  	<label for="pwd">Orphan</label>
			<input type="number" class="form-control infant" name="data[infant]" value="1" style="width:200px">
		</div>		
		<div class="form-group">
		  	<label for="pwd">Purchaser name</label>
			<input type="text" class="form-control purchaser" name="data[purchaser]" value="" placeholder="Name your provided" style="width:200px">
		</div>
		<button class="clkBookTourStore btn-danger" style="padding:5px 10px; cursor:pointer" href="{$PCMS_URL}booking/bookTourItem/{$core->encryptID($oneTour.tour_id)}" >
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Book now
		</button>
	</form>
</div>


<script>
var $arrDate = '{$arrDate}';
var availableDates = $arrDate;
var availableDates = $.parseJSON(availableDates);
</script>
{literal}
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			function available(date) {
				dmy = date.getDate() + "-" + (date.getMonth()+1) + "-" + date.getFullYear();
				if ($.inArray(dmy, availableDates) != -1) {
					return [true, "","Available"];
				} else {
					return [false,"","unAvailable"];
				}
			}

			$('.datepicker').datepicker({
				dateFormat: 'dd/mm/yy',changeMonth: true,
				changeYear: true,
				beforeShowDay: available
				},
				$.datepicker.regional['vn']
			);
			$(".clkBookTourStore").live('click',function(event){
				event.preventDefault();
				var $_this = $(this);
				if( $('.datepicker').val() =='' ){
					alert('you must choice date start');
					return false;
				}
				if( $.trim($('.adult').val()) =='' && $.trim($('.children').val()) =='' && $.trim($('.infant').val()) =='' 
				|| ($('.adult').val()==0&&$('.children').val()==0&&$('.infant').val()==0) 
				|| ($('.adult').val()< 0 || $('.children').val()<0 || $('.infant').val()<0 ) )
				{
					alert('you must enter quality of travel');
					return false;
				}
				$.ajax({
					type: "POST",
					url: $_this.attr('href'),
					dataType: "html",
					data:$_this.closest('form').serialize(),
					success: function(data){
						data = $.parseJSON(data);
						if( data.ok ){	
							window.location.assign( path_ajax_script+'booking/bookOrder' );				
						}else{
							alert(data.error);
							window.location.assign( path_ajax_script+'booking/bookOrder' );
						}
					}
				}); 
			});
		})
	</script>
{/literal}