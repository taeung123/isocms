<div class="page_container page_agent_profile">
	<div class="breadcrumb-main ">
		<div class="container">
			<ol class="breadcrumb bg_f5f5f5 hidden-xs mt0" itemscope itemtype="http://schema.org/BreadcrumbList">
				<li itemprop="name"><a itemprop="url" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}"><span class="reb">{$core->get_Lang('Home')}</span></a></li>
				<li itemprop="name"><a itemprop="url" href="{$curl}" title="{$core->get_Lang('Agent')}">{$core->get_Lang('Agent')}</a></li>
				<li itemprop="name"><a itemprop="url" href="{$curl}" title="{$core->get_Lang('Personal infomation')}">{$core->get_Lang('Personal infomation')}</a></li>
			</ol>
		</div>
	</div>
	<div id="contentPage" class="pageAgent">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<div class="col_Left">
						<div class="box_info">
							<div class="box_avatar">
								<img src="{$clsAgent->getImageAvatar($oneAgent.agent_id,120,120,$oneAgent)}" alt="{$oneAgent.full_name}" width="120" height="120" class="avatar">
							</div>
							<p class="p_name">{$oneAgent.full_name}</p>
							<p class="p_email">{$oneAgent.email}</p>
						</div>
						<ul class="box_tab_info nav nav-tabs">
							<li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#personal_infomation">{$core->get_Lang('Personal infomation')}</a></li>
							<li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#request_sent">{$core->get_Lang('Request sent')}</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-9">
					<div class="col_Right tab-content">
						<div class="tab_info tab-pane active show" id="personal_infomation">
							<h2 class="title_tab">{$core->get_Lang('Personal infomation')}</h2>
							<p class="text_tab">{$core->get_Lang('Manage your personal information, including phone numbe and email address where you can be contacted. Click on each edit box')}</p>
							<div class="personal_infomation_box">
								<div class="row">
									<div class="col-lg-6">
										<div class="info_item item_name">
											<div class="text">
												<label>{$core->get_Lang('First and last name')}</label>
												<p>{$oneAgent.full_name}</p>
											</div>
											<div class="icon_item_name"><i class="fa-regular fa-user"></i></div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="info_item item_email">
											<div class="text">
												<label>{$core->get_Lang('Email')}</label>
												<p>{$oneAgent.email}</p>
											</div>
											<div class="icon_item_name"><i class="fa-regular fa-envelope"></i></div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="info_item item_phone">
											<div class="text">
												<label>{$core->get_Lang('Phone number')}</label>
												<p>{$oneAgent.phone}</p>
											</div>
											<div class="icon_item_name"><i class="fa-regular fa-phone"></i></div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="info_item item_company">
											<div class="text">
												<label>{$core->get_Lang('Company name')}</label>
												<p>{$oneAgent.company_name}</p>
											</div>
											<div class="icon_item_name"><i class="fa-regular fa-buildings"></i></div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="info_item item_nationality">
											<div class="text">
												<label>{$core->get_Lang('Nationality')}</label>
												<p>{$clsCountry->getTitle($oneAgent.country_id)}</p>
											</div>
											<div class="icon_item_name"><i class="fa-regular fa-buildings"></i></div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="info_item item_market">
											<div class="text">
												<label>{$core->get_Lang('Market')}</label>
												<p>{$clsCountryx->getTitle($oneAgent.market_id)}</p>
											</div>
											<div class="icon_item_name"><i class="fa-regular fa-shop"></i></div>
										</div>
									</div>
									<div class="col-lg-12">
										<div class="info_item item_website">
											<div class="text">
												<label>{$core->get_Lang('Website')}</label>
												<p>{$oneAgent.website}</p>
											</div>
											<div class="icon_item_name"><i class="fa-regular fa-link"></i></div>
										</div>
									</div>
									<div class="col-lg-12">
										<div class="info_item item_password">
											<div class="text">
												<label>{$core->get_Lang('Password')}</label>
												<p>***********</p>
											</div>
											<div class="icon_item_name"><i class="fa-regular fa-lock-keyhole"></i></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab_info tab-pane" id="request_sent">
							<h2 class="title_tab">{$core->get_Lang('Request sent')}</h2>
							<p class="text_tab">{$core->get_Lang('Requests you have sent to the business')}</p>
							<ul class="box_tab_request nav nav-pills mb-3" id="pills-tab" role="tablist">
								<li class="nav-item" role="presentation">
									<button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab_all" type="button" role="tab" data-process="" aria-selected="true" onclick="loadRequest(this)">{$core->get_Lang('All')}</button>
								</li>
								<li class="nav-item" role="presentation">
									<button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#tab_waiting" type="button" role="tab" data-process="0" aria-selected="false" onclick="loadRequest(this)">{$core->get_Lang('Waiting')}</button>
								</li>
								<li class="nav-item" role="presentation">
									<button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#tab_refuse" type="button" role="tab" data-process="2" aria-selected="false" onclick="loadRequest(this)">{$core->get_Lang('Refuse')}</button>
								</li>
								<li class="nav-item" role="presentation">
									<button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#tab_accept" type="button" role="tab" data-process="1" aria-selected="false" onclick="loadRequest(this)">{$core->get_Lang('Accept')}</button>
								</li>
							</ul>
							<div class="tab-content">
								<div class="request_sent_box tab-pane active show" id="tab_all"></div>
								<div class="request_sent_box tab-pane" id="tab_waiting"></div>
								<div class="request_sent_box tab-pane" id="tab_refuse"></div>
								<div class="request_sent_box tab-pane" id="tab_accept"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var msg_fullname_required = "{$core->get_Lang('Your full name should not be empty')}!";
	var msg_email_required = "{$core->get_Lang('Your email should not be empty')}!";
	var msg_email_not_valid = "{$core->get_Lang('Please enter a valid email address')}!";
	var msg_phone_required = "{$core->get_Lang('Your telephone should not be empty')}!";
	var msg_company_name_required = "{$core->get_Lang('Your company name should not be empty')}!";
	var msg_position_required = "{$core->get_Lang('Your position should not be empty')}!";
	var msg_tax_code_required = "{$core->get_Lang('Your tax code should not be empty')}!";
	var msg_password_required = "{$core->get_Lang('Your password should not be empty')}!";
	var msg_re_password_required = "{$core->get_Lang('Your confirm password should not be empty')}!";
	var msg_confirmpassword_not_valid = "{$core->get_Lang('Please enter the same value again password')}!";
	var msg_success = "{$core->get_Lang('Update profile for agent success')}!";
	var msg_error = "{$core->get_Lang('Update profile for agent not success')}!";
</script>
{literal}
	<script type="text/javascript">
		var inputs = document.querySelectorAll('.inputfile');
		Array.prototype.forEach.call( inputs, function(input)
		{
			var label	 = input.nextElementSibling,
					labelVal = label.innerHTML;

			input.addEventListener( 'change', function( e )
			{
				var fileName = '';
				fileName = e.target.value.split( '\\' ).pop();
				if(fileName){
					label.innerHTML = fileName;
					$('.text_hidden').hide();
					$('#avatar_post').val('');
				}else{
					label.innerHTML = labelVal;
					$('.text_hidden').show();

				}
			});
		});
		$("#delete_avatar").click(function(){
			$('.avatar_photo').attr('src','');
			$('#avatar_post').val('');
			$(this).remove();
		});

	</script>
{/literal}
{literal}
	<script type="text/javascript">
		$(document).ready(function(){
			loadRequest();
		});
		function loadRequest(elm){
			var process = $(elm).data('process');
			var html_container = $(elm).data('bs-target');
			if(html_container == undefined){
				html_container = "#tab_all";
			}
			$.ajax({
				type: "POST",
				dataType: "html",
				data:{process:process},
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajLoadRequest',
				success:function(html){
					$("#tab_all,#tab_waiting,#tab_refuse,#tab_accept").html('');
					$(html_container).html(html);
				}
			});
		}
	</script>
{/literal}