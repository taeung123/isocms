<div id="map_canvas" class="map_canvas mt40">
    <!-- HTML here -->
</div>
{if $show eq 'City'}
<script type="text/javascript">
	var map_la = '{$clsCity->getOneField("map_la",$city_id)}';
	var map_lo = '{$clsCity->getOneField("map_lo",$city_id)}';
	var city_id = '{$city_id}';
	var $_show = '{$show}';
</script>
{else}
<script type="text/javascript">
	var map_la = '{$clsCountryEx->getOneField("map_la",$country_id)}';
	var map_lo = '{$clsCountryEx->getOneField("map_lo",$country_id)}';
	var country_id = '{$country_id}';
	var $_show = '{$show}';
</script>
{/if}
{literal}
<style>
	.map_canvas{ width:100%; height:460px;}
</style>
<script type="text/javascript">
	$(function(){
		initialize();
	});
	function initialize(){
		var mapOptions = {
			center: new google.maps.LatLng(map_la,map_lo),
			zoom: 6,
			scrollwheel: false,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}; 
		map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions);
		var marker = new google.maps.Marker({
			map: map,
			position: new google.maps.LatLng(map_la,map_lo),
		});
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map, marker);
		});
	}
</script>
{/literal}