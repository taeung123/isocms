<table id="list_hotel">
	<thead>
		<tr>
			<th>{$core->get_Lang('No.')}</th>
			<th>{$core->get_Lang('Image')}</th>
			<th align="left">{$core->get_Lang('Name')}</th>
			<th align="left">{$core->get_Lang('Country')}</th>
			<th align="left">{$core->get_Lang('City')}</th>
			<th>{$core->get_Lang('Function')}</th>
		</tr>
	</thead>
	<tbody>
		{section name=i loop=$listAllHotel}
		{assign var=hotel_name value=$clsHotel->getTitle($listAllHotel[i].hotel_id)}
		<tr>
			<td style="width: 60px" align="center">{$smarty.section.i.iteration}</td>
			<td style="width: 70px" align="center"><img src="{$clsHotel->getImage($listAllHotel[i].hotel_id,60,40)}" alt="{$hotel_name}" width="60" height="40"/>
			</td>
			<td>{$hotel_name}</td>
			<td style="width: 120px">{$clsHotel->getCountryHotel($listAllHotel[i].hotel_id)}</td>
			<td style="width: 120px">{$clsHotel->getCityHotel($listAllHotel[i].hotel_id)}</td>
			<td style="width: 90px" align="center">
				{if in_array($listAllHotel[i].hotel_id, $list_hotel_id)}
				<input type="checkbox" checked name="hotel_select" value="{$listAllHotel[i].hotel_id}" title="{$core->get_Lang('Save')}" onclick="chooseHotel(this)" style="display: none">
				<a href="javascript:void(0);" class="change_room" data-hotel_id="{$listAllHotel[i].hotel_id}">{$core->get_Lang('Change Room')}</a>
				{else}
				<input type="checkbox" name="hotel_select" value="{$listAllHotel[i].hotel_id}" title="{$core->get_Lang('Save')}" class="hotel_check_box" onclick="chooseHotel(this)">
				{/if}
			</td>
		</tr>
		{/section}
	</tbody>
</table>
<script>
var  combo_id='{$combo_id}';
var  City='{$core->get_Lang("City")}';
var  Country='{$core->get_Lang("Country")}';
</script>
{literal}
<style>
	.DataTables_sort_icon{display: none !important}
	.hotel_check_box{cursor: pointer}
</style>
<script>
$(document).ready(function(){
    $('#list_hotel').DataTable({
        order: [[2, 'asc']],
		columnDefs: [
		  { orderable: false, targets: '_all' }
		],
		aLengthMenu:[[10, 50, 100, -1], [10, 50, 100, All]],
		iDisplayLength:10,
		initComplete: function () {
            this.api().columns([3]).every( function () {
                var column = this;
                var select = $('<select><option value="">'+Country+'</option></select>')
                    .appendTo( $(column.header()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column
                            .search( val ? '^'+val+'$' : '',true,false)
                            .draw();
                    } );
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
			this.api().columns([4]).every( function () {
                var column = this;
                var select = $('<select><option value="">'+City+'</option></select>')
                    .appendTo( $(column.header()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
    });
	$(document).on('click', '.change_room', function(ev){
		var $_this = $(this);
		var hotel_id = $_this.data('hotel_id');
		loadHotelRoom(hotel_id);
	});
});
function chooseHotel(checkbox) {
	var checkboxes = document.getElementsByName('hotel_select');
	if(checkbox.checked){
	   loadHotelRoom(checkbox.value);
	}else{
	   loadHotelRoom(0);
	}

}
function loadHotelRoom(hotel_id) {
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod='+mod+'&act=ajLoadListHotelRoom',
		data:{
			"combo_id":combo_id,
			"hotel_id":hotel_id
		},
		dataType:'html',
		success: function(html){
			$('#div_HotelRoom').html(html).addClass('open');
		} 
	});
}
</script>
{/literal}

