<h3 class="title_box mb05">{$core->get_Lang('Combo related')}</h3>
<p class="intro_box mb40">{$core->get_Lang('introcomborelated')}</p>
<div class="form_option_tour">
	<div class="inpt_tour">
		<div class="filterbox border_0">
			<div class="wrap">
				<div class="searchbox searchbox_new">
					<input id="searchkey" placeholder="{$core->get_Lang('searchcombo')}" type="text" class="text" style="width:300px" />
					<input type="hidden" id="combo_related_id" value="0" />
					<a class="btn btn-add_new" id="add_combo_related"><span>Thêm vào</span></a>
					<div class="autosugget" id="autosugget">
						<ul class="HTML_sugget"></ul>
						<div class="clearfix"></div>
						<a class="close_Div">{$core->get_Lang('close')}</a>
					</div>
				</div>
			</div>
		</div>
		<div class="hastable" style="margin-bottom:10px">
			<table class="tbl-grid full-width table_responsive" cellspacing="0">
				<thead>
					<tr>
						<th class="gridheader boder_top_none text-left" style="width: 60px"><strong>{$core->get_Lang('ID')}</strong></th>
						<th class="gridheader name_responsive text-left boder_top_none"><strong>{$core->get_Lang('Combo name')}</strong></th>
						<th class="gridheader text-left hiden_responsive boder_top_none" style="width:80px"><strong>{$core->get_Lang('duration')}</strong></th>
						<th class="gridheader hiden_responsive boder_top_none" style="width: 50px"></th>
					</tr>
				</thead>
				<tbody id="tblComboExtension"></tbody>
			</table>
		</div>
	</div>
</div>
{literal}
<script type="text/javascript">
	$(function(){
		loadComboExtension(table_id);
		$("#searchkey").bind('keyup change', function() {
			var $_this = $(this);
			if ($_this.val() != '') {
				clearTimeout(aj_search);
				search_combo();
			} else {
				$("#autosugget").stop(false, true).slideUp();
			}
		});
		$(document).on('click', '.clickChooseCombo', function(ev) {
			var $_this = $(this);
			var title=$_this.data('title');
			var combo_id=$_this.data('combo_id');
			$('#searchkey').val(title);
			$('#combo_related_id').val(combo_id);
			search_combo('Hidden');
			return false;
		});
		$(document).on('click', '#add_combo_related', function(ev) {
			var _this = $(this);
			vietiso_loading(1);
			var adata = {
				'combo_related_id':$('#combo_related_id').val(),
				'combo_id': table_id
			};
			$.ajax({
				type: 'POST',
				url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajAddComboExtension',
				data: adata,
				dataType: 'html',
				success: function(html) {
					vietiso_loading(0);
					loadComboExtension(table_id);
				}
			});
		});
		$(document).on('click', '.clickDeleteComboRelated', function(ev) {
			if (confirm(confirm_delete)) {
				var _this = $(this);
				vietiso_loading(1);
				$.ajax({
					type: 'POST',
					url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajAddComboExtension',
					data: {
						"combo_id": _this.data('combo_id'),
						"combo_related_id": _this.data('combo_related_id'),
						"tp": 'DEL',
					},
					dataType: 'html',
					success: function(html) {
						vietiso_loading(0);
						loadComboExtension(table_id);
					}
				});
				return false;
			}
		});
	});
</script>
{/literal}