<a href="javascript:history.back();" style="float: right;">« Back</a>
<form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
	<fieldset>
		<legend>{$core->get_Lang('confirm')}:</legend>
        {$core->get_Lang('Are you sure delete this')} {$mod|ucfirst} ?
	</fieldset>
	<fieldset class="submit-buttons">
		<input class="button1" id="submit" name="update" value="Đồng ý" type="submit">&nbsp;
		<input class="button2" id="reset" name="reset" value="Không/Quay lại" type="button" onclick="javascript:history.back();">
		<input value="agree" name="agree" type="hidden">
	</fieldset>
</form>
