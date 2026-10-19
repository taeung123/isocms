<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')}:</strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('edit profile')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>

<div class="container-fluid">
	<div class="agent_profile mt-5">
		<div class="agent_name">
			<h3 class="agent_name_title">{$oneTable.full_name}</h3>
			<div class="box_status_switch">
				<span class="txt_status_switch public">{$core->get_Lang('Active')}</span>
				<label class="switch_public switch" data-clstable="Agent" data-pkey="{$clsClassTable->pkey}"
					   data-sourse_id="{$pvalTable}">
					<input id="active_agent" type="checkbox" status="Active" {if $oneTable.is_active eq 1}checked{/if}>
					<span class="slider round"></span>
				</label>
			</div>
		</div>
		<div class="agent_info">
			<div class="agent_contact mt-4">
				<div class="agent_item">
					<label for="email">{$core->get_Lang("Email")}/{$core->get_Lang("Username")}</label>
					<input class="form-control" type="text" id="email" name="email" value="{$oneTable.email}" disabled>
				</div>
				<div class="agent_item">
					<label for="phone">{$core->get_Lang("Phone number")}</label>
					<input class="form-control" type="text" id="phone" name="phone" value="{$oneTable.phone}" disabled>
				</div>
				<div class="agent_item">
					<label for="nationality">{$core->get_Lang("Nationality")}</label>
					<input class="form-control" type="text" id="nationality" name="nationality" value="{$clsCountry->getTitle($oneTable.country_id)}" disabled>
				</div>
			</div>
			<div class="agent_company mt-4">
				<div class="agent_item">
					<label for="comapny_name">{$core->get_Lang("Company name")}</label>
					<input class="form-control" type="text" id="comapny_name" name="comapny_name" value="{$oneTable.company_name}" disabled>
				</div>
			</div>
			<div class="agent_contact mt-4">
				<div class="agent_item">
					<label for="market">{$core->get_Lang("Market")}</label>
					<input class="form-control" type="text" id="market" name="market" value="{$clsCountryEx->getTitle($oneTable.market_id)}" disabled>
				</div>
				<div class="agent_item">
					<label for="website">{$core->get_Lang("Website")}</label>
					<input class="form-control" type="text" id="website" name="website" value="{$oneTable.website}" disabled>
				</div>
			</div>
		</div>
		<div class="d-flex align-items-center justify-content-between mt-5">
			<button class="reset_password">
				<i class="fa fa-paper-plane"></i> {$core->get_Lang("Reset password")}
			</button>
{*			<span id="block_agent" class="lock_account" data-status="locked"><i class="fa-regular fa-ban"></i> {$core->get_Lang("Lock account")}</span>*}
		</div>
	</div>
	<hr>
	<div class="home_box actions_required_box">
		<div class="header_box">
			<h2 class="title_box">{$core->get_Lang('Requests')}/{$core->get_Lang('Bookings')}</h2>
			{*<div class="search_box d-flex">
				<div class="input_search">
					<input class="form-control" type="text" placeholder="{$core->get_Lang("Search")}">
				</div>
				<select class="form-select" name="" id="">
					<option value="">Status</option>
					<option value="1">Fail</option>
					<option value="1">Success</option>
				</select>
				<select class="form-select" name="" id="">
					<option value="">Status</option>
					<option value="1">Fail</option>
					<option value="1">Success</option>
				</select>
			</div>*}
		</div>
		<div class="lst_booking_sale_contact">
			{if !empty($lstRequest)}
			<div id="sale_feed" class="sale_feed_table">
				{foreach from=$lstRequest key=k item=v}
					{$clsISO->getBlock("box_request_item", ['item'=>$v,"index"=>$k,'feedback_id'=>$v.feedback_id])}
				{/foreach}
			</div>
			{else}
				{$core->get_Lang("No data")}!
			{/if}
		</div>
	</div>
</div>
<link rel="stylesheet" href="{$URL_CSS}/agent.css?v={$upd_version}" type="text/css">
<script type="text/javascript">
var agent_id ='{$oneTable.agent_id}';
</script>
{literal}
<script type="text/javascript">
$(document).on('change', '#active_agent', function(ev) {
	var $_this = $(this);
	var value = $_this.is(':checked') ? 1 : 0;
	var status = $_this.attr('status');
	updateAgent(value,status);
});
$(document).on('click', '#block_agent', function(ev) {
	var $_this = $(this);
	const currentStatus = $_this.attr('data-status');
	const value = currentStatus === 'locked' ? '0' : '1';
	updateAgent(value,status);
});
function updateAgent(val,status) {
	vietiso_loading(1)
    var adata = {};
    adata['agent_id'] = agent_id;
    adata['val'] = val;
	adata['status'] = status;
    $.ajax({
        type: 'POST',
        url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajUpdateAgent&lang='+LANG_ID,
        data: adata,
        dataType: 'html',
        success: function(html) {
			vietiso_loading(0);
			alertify.success("Changed successfully!");
			 // window.location.reload();
        }
    });
}

$(document).on("click", ".reset_password", function (ev) {
	let email = $("#email").val();
	vietiso_loading(1)
	$.ajax({
		type: "POST",
		url:
				DOMAIN_NAME +
				"/index.php?mod=agent&act=ajAjaxForgotPass",
		data: {email: email},
		dataType: "html",
		success: function (html) {
			vietiso_loading(0)
			if (html.indexOf('reset_success') >= 0) {
				alertify.success("Password reset email sent successfully")
			} else {
				alertify.error("Failed to send password reset email")
			}
		},
	});
	return false;
});
</script>
{/literal}