<div class="page_container">
	<div class="page-title  d-flex">
        <div class="title">
			<h2>
				{$core->get_Lang('Departure schedule')}
				<div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách các tours mở bán trong hệ thống isoCMS">i</div>
			</h2>
			<p><span>11 tour khởi hành</span> <span>1 tour bán hết</span></p>
		</div>
		{if 1 eq 2}
        <p>Chức năng quản lý danh sách các tours trong hệ thống isoCMS</p>
		<p>{$core->get_Lang('This function is intended to manage tours in isoCMS system')}</p>
		{/if}
    </div>
	<div class="container-fluid">
		<div class="wrap p_relative">
			<div class="select_type">
				<form id="forums" method="post" class="filterForm" action="">
					<select name="type" onchange="this.form.submit()" class="slb">
						<option {if $type=='MONTH'} selected{/if} value="MONTH">Theo Tuần</option>
						<option {if $type=='DAY'} selected{/if} value="DAY">Theo Ngày</option>
					</select>
					<input type="hidden" name="filter" value="filter" />
				</form>
			</div>
			<div id="list_start_date">
			
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var begin_date = '{$begin_date}';
	var type = '{$type}';
</script>
{literal}
<script>
loadListStartDate(begin_date,type);
function loadListStartDate(begin_date,type){
$.ajax({
	'type': 'POST',
	'url' : path_ajax_script+'/index.php?mod=tour&act=load_list_start_date&lang='+LANG_ID,
	'data' : {"begin_date":begin_date,"type":type},
	'dataType': 'html',
	'success':function(html){
		$('#list_start_date').html(html);
	}
});
}
</script>
{/literal}