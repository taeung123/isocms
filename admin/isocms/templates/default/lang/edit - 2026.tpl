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
    	example in tpl: {'{#key#}'}
    	<textarea name="content_config_file" class="form-control" cols="30" rows="10">{$conf_lang}</textarea>
    	<table class="tbl-grid" style="width:100%;">
            <tbody>
            {section name=i loop=3}
            <tr class="lang-row">
            	<td></td>
            	<td>
               		<input type="hidden" class="old_key" value="" />
                	<input type="text" class="lang_key form-control" placeholder="key" style="width:98%;" />
                </td>
                <td width="20px">-></td>
            	<td></td>
            	<td>
					<textarea class="lang_value" placeholder="value" style="width:98%;min-height:40px;resize:vertical;"></textarea>
                </td>
            </tr>
            {/section}
            {section name=i loop=$lstItem} 
            <tr class="lang-row" style="background:#F0F0F0;">
                <td style="width:10px">{$smarty.section.i.index+1}</td>
            	<td width="30%">
                	<input type="text" class="lang_key form-control" value="{$lstItem[i].key|escape:'html':'UTF-8'}" placeholder="key" style="width:98%; color:red;" />
                	<input type="hidden" class="old_key" value="{$lstItem[i].key|escape:'html':'UTF-8'}">
                </td>
                <td width="20px">-></td>
                <td style="width:10px">{$smarty.section.i.index+1}</td>
            	<td>
                	<textarea class="lang_value" placeholder="value" style="width:98%; color:blue;min-height:40px;resize:vertical;">{$lstItem[i].value|escape:'html':'UTF-8'}</textarea>
                </td>
            </tr>
            {/section}
            </tbody>
            <tfoot>
            {*
            <tr>
            	<td></td>
            	<td>
                </td>
                <td></td>
            	<td></td>  
            	<td>
                	<a href="#" id="addmore">+Thêm nữa</a>
                </td>
            </tr>*}
            </tfoot>
        </table>
        <div class="clearfix"><br /></div>
        {if $lang_permission eq '0777'}
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
			$(document).ready(function(){
				$("#addmore").click(function(){
					$('tbody').append('<tr class="lang-row"><td></td><td><input type="hidden" class="old_key" value=""><input type="text" class="lang_key form-control" placeholder="key" style="width:97%;" /></td><td>-></td><td></td><td><textarea class="lang_value" placeholder="value" style="width:98%;min-height:40px;resize:vertical;"></textarea></td></tr>');
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
				/*function validateLanguage(rows) {

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
				}*/
				function validateLanguage(rows) {
					return true;
					var keys = {};

					for (var i = 0; i < rows.length; i++) {

						/*console.log(
							"row:", i,
							"key:", JSON.stringify(rows[i].key),
							"exist:", keys[rows[i].key]
						);*/
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

					//console.log(keys);

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
					//$(".lang_key, .old_key, .lang_value").prop("disabled", true);
					//var json = JSON.stringify(getLanguageData());
					//console.log(json.length);
					//console.log(new Blob([json]).size);
					//console.log(json.substring(0,1000));
					//console.log(json.substring(json.length-1000));
					//console.log("submit...");
					return true;
					
				});
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
</style>
{/literal}