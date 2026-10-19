<div class="breadcrumb">
	<strong>{$_lang->get_Lang('You are here')} : </strong>
	<a href="{$PCMS_URL}">{$_lang->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod=cruise">{$_lang->get_Lang('Cruise Management')}</a>
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">{$_lang->get_Lang('Back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">	
        <h2>{$_lang->get_Lang('Cruise Management')}</h2>
    	Module quản lý cruise trong Hệ Thống.<br />
    </div>
	<br class="clear" />
	<form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
		<fieldset>
			<legend>Xác nhận:</legend>
			Bạn có chắc chắn muốn Xóa {$mod|ucfirst} này?
		</fieldset>
		<fieldset class="submit-buttons">
			<button type="submit" name="update" class="btn btn-primary start">
				<i class="icon-ok icon-white"></i>
				<span>Đồng ý</span>
			</button>
			<button type="button" class="btn btn-warning delete" onclick="javascript:history.back();">
				<i class="icon-retweet icon-white"></i>
				<span>Không/Quay lại</span>
			</button>
			<input value="agree" name="agree" type="hidden">
		</fieldset>
	</form>
</div>