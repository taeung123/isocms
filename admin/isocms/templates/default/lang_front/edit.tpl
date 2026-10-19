<div class="breadcrumb">
	<strong>{$core->get_Lang('You are here')}:</strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$core->get_Lang('Languages')}">{$core->get_Lang('Languages')}</a>
    <a href="javascript:history.back();" class="back fr" style="width:50px;">{$core->get_Lang('Back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>/lang/{$langid}.php</h2>
    </div>
    <p>{$core->get_Lang('Edit Language Details')}</p>
    {if $lang_permission ne '0777'}
    <h2 style="color:red; text-align:center; border:1px dashed red; margin-bottom:20px; padding:10px;">File này chưa CMOD 777!</h2>
    {/if}
    <form method="post" action=""  enctype="multipart/form-data">
    	<input type="hidden" name="lang_json" id="lang_json">
    	{if 0}{*không cần lưu file conf 11/07/2026*}
    	example in tpl: {'{#key#}'}
    	<textarea name="content_config_file" class="form-control" cols="30" rows="10">{$conf_lang}</textarea>
    	{/if}
    	<table class="tbl-grid" style="width:100%;">
            <tbody>
            <tr>
            	<td></td>
            	<td>
                </td>
                <td></td>
            	<td></td>  
            	<td>
                	<a href="#" id="addmore">+Thêm nữa</a>
                </td>
                <td width="80"></td>
            </tr>
            {section name=i loop=3}
            <tr class="lang-row new-row" data-state="saved">
            	<td></td>
            	<td>
               		<input type="hidden" class="old_key" value="" />
                	<input type="text" class="lang_key form-control" placeholder="key" style="width:100%;" />
                </td>
                <td width="30px">-></td>
            	<td></td>
            	<td>
					<textarea class="lang_value" placeholder="value" style="width:100%;min-height:40px;resize:vertical;"></textarea>
                </td>
                <td class="text-center">
					<span class="save-status status-idle">
						<i class="icon-ok"></i>
					</span>
				</td>
            </tr>
            {/section}
            {section name=i loop=$lstItem} 
            <tr class="lang-row" data-state="saved" style="background:#F0F0F0;">
                <td style="width:10px">{$smarty.section.i.index+1}</td>
            	<td width="30%">
                	<input type="text" class="lang_key form-control" value="{$lstItem[i].key|escape:'html':'UTF-8'}" placeholder="key" style="width:100%; color:red;" />
                	<input type="hidden" class="old_key" value="{$lstItem[i].key|escape:'html':'UTF-8'}">
                </td>
                <td width="30px">-></td>
                <td style="width:10px">{$smarty.section.i.index+1}</td>
            	<td>
                	<textarea class="lang_value" placeholder="value" style="width:100%; color:blue;min-height:40px;resize:vertical;">{$lstItem[i].value|escape:'html':'UTF-8'}</textarea>
                </td>
                <td class="text-center">
					<span class="save-status status-idle">
						<i class="icon-ok"></i>
					</span>
				</td>
            </tr>
            {/section}
            </tbody>
            {*<tfoot></tfoot>*}
        </table>
        <div class="clearfix"><br /></div>
        {if $lang_permission eq '0777' && 0}
        <fieldset class="submit-buttons">
            {$saveBtn}
            <input value="Updatelang" name="submit" type="hidden">
        </fieldset>
        {/if}
        <script>
			//window.LanguageConfig = {$LanguageConfig|@json_encode nofilter}; smarty 3
		window.LanguageConfig = {
			csrfToken: '{$csrfToken|escape:"javascript"}',
			group: '{$group|escape:"javascript"}',
			language: '{$language|escape:"javascript"}'
		};
		</script>
        {literal}
        <script type="text/javascript">
			/*data-state lang-row
				saved
				saving
				error
				modified
			*/
			var saveTimers = {};
			$(document).ready(function(){
				$("#addmore").click(function(){
					$('tbody').prepend('<tr class="lang-row new-row" data-state="saved"><td></td><td><input type="hidden" class="old_key" value=""><input type="text" class="lang_key form-control" placeholder="key" style="width:100%;" /></td><td>-></td><td></td><td><textarea class="lang_value" placeholder="value" style="width:100%;min-height:40px;resize:vertical;"></textarea></td><td class="text-center"><span class="save-status status-idle"><i class="icon-ok"></i></span></td></tr>');//append
					return false;
				});
				function replaceHtml( string_to_replace ) 
					{
						return string_to_replace.replace(/&nbsp;/g, ' ').replace(/<br.*?>/g, '\n');
					 }
				if($("#lang").length){
					var str = $("#lang").val();
					$("#lang").val(replaceHtml(str));
				}
				function validateLanguage(rows) {
					var keys = {};
					for (var i = 0; i < rows.length; i++) {
						// Cho phép dòng trống (để xóa hoặc thêm mới)
						if (rows[i].key === "") {
							//alert("Dòng " + (i + 1) + " chưa nhập Key.");
							//return false;
							continue;
						}
						if (rows[i].key !== "" && keys[rows[i].key]) {
							alert('Key "' + rows[i].key + '" bị trùng.');
							return false;
						}
						keys[rows[i].key] = true;
					}
					return true;
				}
				function getLanguageData(){
					var rows=[];
					$(".lang-row").each(function(){
						var item = {
							old_key : $(this).find(".old_key").val() || "",
							key     : $.trim($(this).find(".lang_key").val() || ""),
							value   : $(this).find(".lang_value").val() || ""
						};
						// Bỏ qua dòng hoàn toàn rỗng
						if (
							item.old_key === "" &&
							item.key === "" &&
							item.value === ""
						){
							return;
						}
						rows.push(item);
					});
					return rows;
				}
				$("form").on("submit", function () {
					var rows = getLanguageData();
					
					if (!validateLanguage(rows)) {
						return false;
					}
					$("#lang_json").val(JSON.stringify(rows));
					var json = JSON.stringify(getLanguageData());
					//console.log(json.substring(0,1000));
					//console.log(json.substring(json.length-1000));
					//console.log("submit...");
					return true;
				});
				$(document).on("input", ".lang_key, .lang_value", function () {
					var row = $(this).closest(".lang-row");
					setRowStatus(row,"edit");
					scheduleSave(row);
				});
				function scheduleSave(row){
					var id = row.index();
					clearTimeout(saveTimers[id]);
					row.attr("data-state","modified");
					saveTimers[id] = setTimeout(function(){
						saveRow(row);
					},500);
				}
				function saveRow(row){
					row.attr("data-state","saving");
					var item = {
						old_key : row.find(".old_key").val(),
						key : $.trim(row.find(".lang_key").val()),
						value : row.find(".lang_value").val()
					};
					$.ajax({
						url : path_ajax_script + "/?mod=" + mod + "&act=ajax",
						type : "POST",
						dataType : "json",
						data : {
							cmd : "saveRow",
							group : LanguageConfig.group,
							language : LanguageConfig.language,
							csrf_token : LanguageConfig.csrfToken,
							item : JSON.stringify(item)
						},
						beforeSend:function(){
							setRowStatus(row,"saving");
						},
						success:function(res){
							if(res.success){
								row.attr("data-state","saved").removeClass("new-row");
								row.find(".old_key").val(item.key);
								setRowStatus(row,"success");
								setTimeout(function(){
									setRowStatus(row,"idle");
								},2000);
							}else{
								row.attr("data-state","error");
								alert(res.message);
								setRowStatus(row,"error");
							}
						},
						error:function(){
							row.attr("data-state","error");
							setRowStatus(row,"error");
						}
					});
				}
				function setRowStatus(row,status){
					var icon=row.find(".save-status");
					icon.removeClass(
						"status-idle status-edit status-saving status-success status-error"
					);
					switch(status){
						case "idle":
							icon
								.addClass("status-idle")
								.html('<i class="icon-ok"></i>');
							break;
						case "edit":
							icon
								.addClass("status-edit")
								.html('<i class="icon-pencil"></i> Editing');
							break;
						case "saving":
							icon
								.addClass("status-saving")
								.html('<i class="icon-refresh icon-spin"></i> Saving...');
							break;
						case "success":
							icon
								.addClass("status-success")
								.html('<i class="icon-ok"></i> Success');
							break;
						case "error":
							icon
								.addClass("status-error")
								.html('<i class="icon-remove"></i> Error');
							break;
					}
				}
			});
		</script>
        {/literal}
    </form>
</div>
{literal}
<style>
	.searchmap{ background:#E9EFF3; padding:10px;}
	.errorTxt{color:#c00000; display:block;margin:5px 0 0}
	.lang-row:hover td{background:#369 !important;}
	.submit-buttons {
		position: fixed;
		right: calc(50% - 50px);
		left:calc(50% - 50px);
		bottom: 0;
		/*display: none;*//*ẩn đi vì file đã vượt quá giới hạn*/
	}
	.save-status{
		display:inline-block;
		width:20px;
		text-align:center;
		transition:.2s;
	}
	.status-idle{
		color:#999;
	}
	.status-edit{
		color:#f0ad4e;
	}
	.status-saving{
		color:#5bc0de;
	}
	.status-success{
		color:#5cb85c;
	}
	.status-error{
		color:#d9534f;
	}
</style>
{/literal}