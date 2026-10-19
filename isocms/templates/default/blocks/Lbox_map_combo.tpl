<div id="map"></div>
<script>
	var map_la = '{$map_la}';
	var map_lo = '{$map_lo}';
	var combo_id = '{$combo_id}';
</script>
{$script_location}
{literal}
  <script type="text/javascript">
	initialize(map_la, map_lo,'');
	function initialize(map_la, map_lo,content_map){
		var map = new google.maps.Map(document.getElementById('map'), {
		  zoom: 10,
		  center: new google.maps.LatLng(map_la, map_lo),
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		if(content_map!=''){
		  var infowindow = new google.maps.InfoWindow({
				map: map,
				position: new google.maps.LatLng(map_la,map_lo),
				content: content_map,
			  	pixelOffset: new google.maps.Size(0, -40)
			});
		}else{
		   var infowindow = new google.maps.InfoWindow();
		}
		var marker, i;

		for (i = 0; i < locations.length; i++) {  
		  marker = new google.maps.Marker({
			position: new google.maps.LatLng(locations[i][1], locations[i][2]),
			map: map
		  });
		  google.maps.event.addListener(marker, 'click', (function(marker, i) {
			return function() {
			  infowindow.setContent(locations[i][0]);
			  infowindow.open(map, marker);
			}
		  })(marker, i));

		}
    }
	$(document).on('click', '.hotel_item', function(ev){
		var $_this = $(this)
		map_la=$_this.data('map_la'),map_lo=$_this.data('map_lo'),content_map=$_this.data('title');
		initialize(map_la,map_lo,content_map);
		return false;
	});
  </script>
{/literal}