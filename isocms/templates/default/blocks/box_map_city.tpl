<section class="col-md-4"><a href="javascript:void()" class="h_map_pop fr ajViewMapCity" title="{$core->get_Lang('Interactive Map')}">	{$core->get_Lang('Interactive Map')}</a></section>
<script type="text/javascript">
	var map_la = "{$clsCity->getOneField('map_la',$city_id)}";
	var map_lo = "{$clsCity->getOneField('map_lo',$city_id)}";
	var content_map = '{$clsCity->getMapHTML($city_id)}';
	var city_name = '{$clsCity->getTitle($city_id)}';
</script>
{literal}
<script type="text/javascript">
	function initialize_2(){
		var mapOptions = {
			center: new google.maps.LatLng(map_la,map_lo),
			zoom: 10,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}; 
		map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions);
		var marker = new google.maps.Marker({
			map: map,
			position: new google.maps.LatLng(map_la,map_lo),
		});
		var infowindow = new google.maps.InfoWindow({
			map: map,
			position: new google.maps.LatLng(map_la,map_lo),
			content: content_map
		});
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map, marker);
		});
   } 
	$().ready(function(){
		$('.ajViewMapCity').click(function(){
			var html = '<div id="full-box-popup">';
			html += '<div class="headPop">';
			html += '<a href="javascript:void();" class="close_pop closeEv"></a>';
			html += '<h3>Map '+city_name+'</h3>';
			html += '</div>';
			html += '<div id="map_canvas"></div></div>';
			makepopup('86%','',html,'mapBox');
			initialize_2();
		});
	});
</script>
{/literal}