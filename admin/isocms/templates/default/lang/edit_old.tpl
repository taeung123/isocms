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
    <form method="post" action="">
        <input value="Updatelang" name="submit" type="hidden">
        <textarea name="content_config_file" class="form-control" cols="30" rows="10">{$conf_lang}</textarea>
        <table class="tbl-grid" style="width:100%;">
            <tbody>
            <tr>
                <td></td>
                <td>
                    <input type="text" name="key[]" placeholder="key" style="width:98%;" />
                </td>
                <td width="20px">-></td>
                <td></td>
                <td>
                    <input type="text" name="value[]" placeholder="value" style="width:98%;" />
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="text" name="key[]" placeholder="key" style="width:98%;" />
                </td>
                <td width="20px">-></td>
                <td></td>
                <td>
                    <input type="text" name="value[]" placeholder="value" style="width:98%;" />
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="text" name="key[]" placeholder="key" style="width:98%;" />
                </td>
                <td width="20px">-></td>
                <td></td>
                <td>
                    <input type="text" name="value[]" placeholder="value" style="width:98%;" />
                </td>
            </tr>
            {section name=i loop=$lstItem}
                <tr class="trItem" style="background:#F0F0F0;">
                    <td style="width:10px">{$smarty.section.i.index+1}</td>
                    <td width="30%">
                        <input type="text" name="key[]" value="{$lstItem[i].key}" placeholder="key" style="width:98%; color:red;" />
                    </td>
                    <td width="20px">-></td>
                    <td style="width:25px; text-align:center">{$smarty.section.i.index+1}</td>
                    <td>
                        <input type="text" name="value[]" value="{$lstItem[i].value}" placeholder="value" style="width:98%; color:black;" />
                    </td>
                </tr>
            {/section}
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td>
                </td>
                <td></td>
                <td></td>
                <td>
                    <a href="#" id="addmore">+Thêm nữa</a>
                </td>
            </tr>
            </tfoot>
        </table>
        <div class="clearfix"><br /></div>
        {if $lang_permission eq '0777'}
            <fieldset class="submit-buttons">
                {$saveBtn}

            </fieldset>
        {/if}
        {literal}
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#addmore").click(function(){
                        $('tbody').append('<tr><td></td><td><input type="text" name="key[]" placeholder="key" style="width:97%;" /></td><td>-></td><td></td><td><input type="text" name="value[]" placeholder="value" style="width:97%;" /></td></tr>');
                        return false;
                    });
                    function replaceHtml( string_to_replace ) {
                        return string_to_replace.replace(/&nbsp;/g, ' ').replace(/<br.*?>/g, '\n');
                    }
                    var str = $("#lang").val();
                    $("#lang").val(replaceHtml(str));
                });
            </script>
        {/literal}
    </form>
</div>
{literal}
    <style>
        .searchmap{ background:#E9EFF3; padding:10px;}
        .errorTxt{color:#c00000; display:block;margin:5px 0 0}
        .trItem:hover td{background:#FC9 !important;}
        .submit-buttons {
            position: fixed;
            right: calc(50% - 50px);
            left:calc(50% - 50px);
            bottom: 0;
        }
    </style>
{/literal}