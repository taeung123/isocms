<div class="page_container">
	<div class="listtourPage">
		<div class="container">
			<div class="placeto">
				<div class="tourplace">
				  <h3>Ninh Bình - Hà Nội </h3>
					<img src="{$URL_IMAGES}/Shape 12.png" width="26" height="18" alt=""/>
					<h3>Hà Nội - Ninh Bình . 1 Người lớn</h3>
				  <p>Tìm kiếm khác &emsp; >></p>
				</div>
				<div class="timetour">
					<div class="row">
						<div class="gotour col-md-6 col-xs-12">
							<p>Khởi hành</p>
							<div class="go">
								<p>Thứ ba, 13/8</p>
								<h3>Ninh Bình</h3>
							</div>
							<img src="{$URL_IMAGES}/Shape 15 copy 3.png" width="23" height="18" alt=""/>
							<div class="to">
			    				<p>Thứ ba, 13/8</p>
								<h3>Hà Nội</h3>
							</div>
						</div>
						<div class="cometour col-md-6 col-xs-12">
							<p>Quay về</p>
							<div class="go">
								<p>Thứ ba, 13/8</p>
								<h3>Hà Nội</h3>
							</div>
							<img src="{$URL_IMAGES}/Shape 15 copy 3.png" width="23" height="18" alt=""/>
							<div class="to">
								<p>Thứ ba, 13/8</p>
								<h3>Ninh Bình</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="contenttour">
				<h3 class="title">1. Ninh Bình đến Hà Nội</h3>
				
					{section name=i loop=6}
					<div class="listhour">
						<div class="row">
							<div class="menuleft col-md-8">
								<p>2 điểm dừng . 18h25 phút</p>
								<div class="go">
									<h3>Ninh Bình 19:40</h3>
									<p>Thứ ba, 13/8</p>
								</div>
								<img src="{$URL_IMAGES}/Shape 15 copy 3.png" width="23" height="18" alt=""/>
								<div class="to">
									<h3>Hà Nội 09:05</h3>
									<p>Thứ ba, 20/8</p>
								</div>
								<div class="car">
									<p><font style="font-weight: bold">Bình Minh limo</font>.SG185 </p>
									<p><font style="font-weight: bold">Bình Minh limo</font>.SG185 </p>
								</div>
								<p class="note">* Thuộc chuyến 05:00 Ninh Bình đến Hà Nội(Bình Minh limo)</p>
							</div>
							<div class="menuright col-md-4">
								<div class="row">
									<div class="chair col-md-6">
										<h3>Số ghế trống</h3>
										<p>9 ghế trống</p>
									</div>
									<div class="price col-md-6">
										<h3>Giá</h3>
										<p>135000đ</p>
										<button id="mychose">Chọn</button>
									</div>
								</div>
							</div>
						</div>
						
					</div>
					{/section}
				<div class="formchose" id="chose">
					<div class="condition">
						<p>Điều kiện giá vé cho hành lý miễn cước, lựa chọn chỗ ngồi, thu nhập dặm và nâng cấp với dặm chỉ ra dưới đây chỉ danh cho Bình Minh Limousine Khai thác các chuyến xe.<u><a href="#" style="color: #1377d4">Xem điều kiện cho các chuyến xe </a></u></p>
					</div>
					<h3 class="titleform">Điều khoản Giao dịch</h3>
					<div class="rule">
						
						<div class="row">
						<div class="chosechair col-md-4">
							<h3>Chọn ghế chuyến đi</h3>
							<div class="chair">
								<div class="row">
							  	  <div class="col-md-6">
										<div>
									  <img src="{$URL_IMAGES}/volang.png" width="33" height="33" alt=""/> 
									  </div>
									  <div id="ghe1" class="func1" onClick="toggle();"><img src="{$URL_IMAGES}/chair.png" width="33" height="33" alt=""/></div>
									  <div id="ghe2" class="func1" onClick="toggle1();"><img src="{$URL_IMAGES}/chair.png" width="33" height="33" alt=""/></div>
									  <div id="ghe3" class="func1" onClick="toggle(2);"><img src="{$URL_IMAGES}/chair.png" width="33" height="33" alt=""/></div>
									  <div id="ghe4" class="func1" onClick="toggle(3);"><img src="{$URL_IMAGES}/chair.png" width="33" height="33" alt=""/></div>
									  <div id="ghe5" class="func1" onClick="toggle(4);"><img src="{$URL_IMAGES}/chair.png" width="33" height="33" alt=""/></div>
									  <div id="ghe6" class="func1" onClick="toggle(5);"><img src="{$URL_IMAGES}/chair.png" width="33" height="33" alt=""/></div>
									  <div id="ghe7" class="func1" onClick="toggle(6);"><img src="{$URL_IMAGES}/chair.png" width="33" height="33" alt=""/></div>
									  <div id="ghe8" class="func1" onClick="toggle(7);"><img src="{$URL_IMAGES}/chair.png" width="33" height="33" alt=""/></div>
									  <div id="ghe9" class="func1" onClick="toggle(8);"><img src="{$URL_IMAGES}/chair.png" width="33" height="33" alt=""/></div>
								  </div>
									<div class="col-md-6" style="border-left: 1px solid #cccccc">
										<div class="listchair">
											 <img src="{$URL_IMAGES}/chair.png" width="33" height="33" style="float: left" alt=""/>
											<p>Ghế trống</p>
										</div>
								   		<div class="listchair">
											<img src="{$URL_IMAGES}/chairchose.png" width="33" height="33" style="float: left" alt=""/>
											<p>Ghế đã chọn</p>
										</div>
									  	<div class="listchair">
											<img src="{$URL_IMAGES}/chairpay.png" width="33" height="33" style="float: left" alt=""/>
											<p>Ghế đã bán</p>
										</div>
										<div class="listchair">
											<img src="{$URL_IMAGES}/chairchild.png" width="33" height="33" style="float: left" alt=""/>
											<p>Ghế trẻ em</p>
										</div>  
									</div>
								</div>
							</div>
						</div>
						<div class="infocustomer col-md-4">
							<h3>Thông tin khách hàng</h3>
							<p>Quý khác vui lòng nhập thông tin chính xác</p>
							<form>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Họ và tên">
								</div>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Số điện thoại">
								</div>
								<div class="form-group">
									<input type="email" class="form-control" placeholder="Email">
								</div>
								<div class="form-group">
									<textarea class="form-control" rows="5" placeholder="Các yêu cầu đặc biệt không thể đảm bảo nhưng nhà xe sẽ cố gắng hết sức để đáp ứng yêu cầu của bạn"></textarea>
								</div>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Mã khuyến mãi" style="float: left;">	
									<button style="position: absolute;left: 72%;width: 95px;height: 45px;background-color: #3c2517;font-size: 16px;color: white;border: 1px;border-radius: 5px;">Kiểm tra</button>
								</div>
							</form>
						</div>
						<div class="detailticket col-md-4">
							<div class="row">
								<div class="ticketdetail col-xs-12">
									<h3 style="font-size: 16px; text-transform: uppercase;padding-top: 20px">Chi tiết giá vé</h3>	
									<div class="total-inside" style="background-color: white;padding-top: 10px;">
									<div class="total-price" style="padding-left: 20px">
										<h4>Lượt đi</h4>
										<p>Vị trí chọn:</p>
										<p>Giá người lớn:</p>
										<p>Giá trẻ em:</p>
									</div>
									<div class="subtotal" style="padding-left: 20px">
										<p>Tổng tiền lượt đi:</p>
										<p>Phí trung chuyển:</p>
										<p>Tổng tiền:</p>
									</div>
									</div>
								</div>
								<div class="chosepay col-xs-12">
									<h3>Thanh toán</h3>
									<form class="formpay">
										<input type="radio">Thanh toán qua MegaV<br>
										<input type="radio">Thanh toán tại quầy<br>
										<p>Hệ thống sẽ tự hủy nếu sau 60 phút bạn không thanh toán</p>
										<button>Xác nhận đặt vé</button>
									</form>
									
								</div>
							</div>
							
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{literal}
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function () {
		function func1() {
			document.getElementById("ghe1").style.backgroundColor ="#a5e958";
			document.getElementById("ghe1").style.borderRadius="40px";
			document.getElementById("ghe1").style.width="22%";
			
		}
		function func2() {
			document.getElementById("ghe1").style.backgroundColor ="#ff551c";
			document.getElementById("ghe1").style.borderRadius="40px";
		}
		function func3(){
			document.getElementById("ghe1").style.backgroundColor ="transparent";
		}
		function toggle() {
		var button = document.getElementById('ghe1');
		switch(ghe1.className) {
			case "func1": {
			func1();
			button.classList.remove('func1');
			button.classList.add('func2');
			break;
			}
			case "func2": {
			func2();
			button.classList.remove('func2');
			button.classList.add('func3');
			break;
			}
			case "func3":{
				func3();
				button.classList.remove('func3');
				button.classList.add('func1');
			}
		}
			
		}
	})
</script>
{/literal}