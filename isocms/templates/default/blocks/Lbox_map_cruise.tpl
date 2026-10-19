<div id="map">
	<a href="javascript:void(0);" title="Zoom" class="google-map__zoom" table_map_id="{$table_map_id}"><i class="fa fa-expand"></i></a>
	<div id="map_canvas" style="height:180px; float:right"></div>
</div>
<script type="text/javascript">
	var map_la = '{$map_la}';
	var map_lo = '{$map_lo}';
	var cruise_id = '{$cruise_id}';
	var cruise_itinerary_id = '{$cruise_itinerary_id}';
</script>
{$script_location}
{literal}
<style type="text/css">
	#map{ position:relative;}
	.google-map__zoom{ display:block; position:absolute; right:5px; top:5px; padding:10px; background:rgba(0,0,0,0.5); z-index:9;}
	.google-map__zoom > .fa{ color:#FFF;}
</style>
<script type="text/javascript">
	$().ready(function(){
		initialize('map_canvas', 8);
		$('.google-map__zoom').click(function(){
			var $_this = $(this);
			if(!$_this.hasClass('clicked')){
				$_this.addClass('clicked');
				var table_map_id = $_this.attr('table_map_id');
				var type_show_map = $_this.attr('type_show_map');
				$.post('/index.php?mod=cruise&act=map',{'table_map_id':table_map_id,'type_show_map':type_show_map}, function(html){
					$_this.removeClass('clicked');
					makepopup('90%','90%',html,'OpenMap_'+table_map_id);
					initialize('map_canvas_'+table_map_id,9);
				});
			}
			return false;
		});
	});
	function initialize($_container, $zoom){
		var map = new google.maps.Map(document.getElementById($_container), {
			zoom:$zoom,
			scrollwheel: false,
			center: new google.maps.LatLng(map_la,map_lo),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		var infowindow = new google.maps.InfoWindow();
		var marker, i, _array = new Array();
		var maker_icon = new google.maps.MarkerImage('/isocms/templates/default/skin/images/google_map/gIcon'+(i+1)+'.png', new google.maps.Size(32,32));
		for(i = 0; i < locations.length; i++) {
			_array[i] = new google.maps.LatLng(locations[i][1],locations[i][2]);
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(locations[i][1],locations[i][2]),
				map: map,
				icon: '/isocms/templates/default/skin/images/google_map/gIcon'+(i+1)+'.png'
			});
			google.maps.event.addListener(marker,"click",(function(marker, i){
				return function() {
				  infowindow.setContent(locations[i][0]);
				  infowindow.open(map, marker);
				}
			})(marker, i));
		}
		var flightPath = new google.maps.Polyline({
			path: _array,
			geodesic: true,
			strokeColor: '#fF6000',
			strokeOpacity: 0.8,
			strokeWeight: 4
		});
		flightPath.setMap(map);
	}
</script>
{/literal}


