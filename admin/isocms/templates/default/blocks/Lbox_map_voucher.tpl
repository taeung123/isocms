<div id="map">
	<div id="map_canvas" style="width:100%; height:300px; float:right"></div>
</div>
<script type="text/javascript">
	var map_la = '{$map_la}';
	var map_lo = '{$map_lo}';
	var voucher_id = '{$voucher_id}';
	var mapzoom = '{$map_zoom}';
</script>
{$script_location}
{literal}
<style type="text/css">
	#map{ position:relative;}
	.google-map__zoom{ display:block; position:absolute; right:5px; top:5px; padding:10px; background:rgba(0,0,0,0.5); z-index:9;}
	.google-map__zoom > .fa{ color:#FFF;}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		google.maps.event.addDomListener(window, 'load', initialize);
	});
	function loadMaps(voucher_id) {
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/?mod=' + mod + '&act=map',
            data: {
                'voucher_id': voucher_id,
            },
            dataType: "html",
            success: function(html) {
                var $htm = html.split('$$$');
                $('#map_canvas').html($htm[0]);
                initialize('map_canvas');
            }
        });
    }
	function initialize(){
		if(mapzoom > 0){
			$zoom = parseInt(mapzoom);
		}else{
			$zoom = 11;
		}
		var map = new google.maps.Map(document.getElementById('map_canvas'), {
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
			map.addListener('zoom_changed', function(){
				map_zoom = map.getZoom();
				$('input[name=iso-map_zoom]').val(map_zoom);
			});
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


