<div id="map_detail"></div>
{literal}
    <style type="text/css">
        .map_location_des{display: inline-block; width: 100%; height: 250px;position: relative}
        #map_detail{width: 100%; height: 100%; position: absolute; left: 0; top: 0;}
        #map_detail .leaflet-map-pane{width: 100%; height: 100%;}
        #map_detail .leaflet-control-container{width: 100%; height: 100%;}
        .map_box{
            position: relative;
        }
        .map_box .show_map_box{
            position:absolute;
            top: 10px;
            right: 10px;
            width: 180px;
            height: 44px;
            line-height: 44px;
            text-align: center;
            background: #fff;
            color: #238ba4;
            z-index: 999;
            border-radius: 22px;
            cursor: pointer
        }
        .map_box .show_map_box i{
            font-size: 20px;
            margin-right: 5px;
            vertical-align: middle
        }
    </style>

{/literal}
{literal}
<script type="text/javascript">
    let h ={/literal}{$h}{literal};
    let u = [];
    var mymap = L.map("map_detail").setView([0, 0], 2); // Khởi tạo bản đồ với view mặc định

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18, // Tăng maxZoom để hiển thị chi tiết hơn
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    }).addTo(mymap);

    function loadMapbox(){
        if (h.length === 0) {
            console.error("Không có dữ liệu địa điểm để hiển thị trên bản đồ.");
            return;
        }

        // Xóa các marker và polyline cũ trước khi vẽ lại
        mymap.eachLayer(function (layer) {
            if (layer instanceof L.Marker || layer instanceof L.Polyline) {
                mymap.removeLayer(layer);
            }
        });
        u = []; // Reset mảng u mỗi khi load lại dữ liệu

        var destinationIcon = L.icon({
            iconUrl: URL_IMAGES + "/map_icon/destination-map-new.svg",
            iconSize: [11, 11],
            iconAnchor: [5, 5],
            popupAnchor: [0, -10]
        });
        var startIcon = L.icon({
            iconUrl: URL_IMAGES + "/map_icon/start-map-new.svg",
            iconSize: [16, 16],
            iconAnchor: [8, 8],
            popupAnchor: [0, -15]
        });
        var endIcon = L.icon({
            iconUrl: URL_IMAGES + "/map_icon/end-map-new.svg",
            iconSize: [16, 16],
            iconAnchor: [8, 8],
            popupAnchor: [0, -15]
        });

        h.forEach(function (location, index) {
            if (!isNaN(parseFloat(location.place_x)) && !isNaN(parseFloat(location.place_y))) {
                var latLng = [parseFloat(location.place_x), parseFloat(location.place_y)];
                var icon = (index === 0) ? startIcon : (index === h.length - 1) ? endIcon : destinationIcon;
                var marker = L.marker(latLng, { icon: icon }).addTo(mymap);
                marker.bindPopup(location.place_name);
                u.push(latLng);
            }
        });
        if (h.length === 1) {
            mymap.setView(u[0], h[0].place_zoom || 13); // Sử dụng zoom mặc định nếu place_zoom không tồn tại
        } else if (u.length > 0) {
            mymap.fitBounds(u, { padding: [50, 50] }); // Thêm padding để marker không bị cắt
        }

        if (u.length > 1) {
            L.polyline(u, { color: "#409CD1", weight: 2, opacity: 1 }).addTo(mymap);
        }

    }

    // Gọi loadMapbox khi trang web đã sẵn sàng
    $(document).ready(function() {
        loadMapbox();
    });

    $(document).ready(function() {
        loadMapbox();
        console.log(h); // Thử in h ở đây
    });

    function getDataMap(tour_id){
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/?mod=' + mod + '&act=ajaxGetDataMap',
            data: { "tour_id": tour_id },
            dataType: "json",
            success: function (res) {
                if(res.result){
                    let data = res.data;
                    h = data.h; // Gán lại giá trị cho h
                    loadMapbox(); // Gọi lại loadMapbox để cập nhật bản đồ
                }
            }
        });
    }
</script>
{/literal}