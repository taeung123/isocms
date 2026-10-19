{if $run_ajax eq 'overview'}
    {$core->getBlock('box_detail_tour_overview')}
{elseif $run_ajax eq 'setting_menu'}
    {$core->getBlock('box_detail_tour_setting_menu')}
{else}

    {section name=i loop=$list_menu_tour}
        {assign var=child_cat_menu value=$list_menu_tour[i].child}
        {assign var=child_cat_menu_prev value=$list_menu_tour[i.index_prev].child|default:[]}
        {assign var=list_cat_menu_prev value=$list_menu_tour[i.index_prev].cat_menu|default:[]}
        {math assign=count_child_cat_menu_prev equation='x-y' x=$list_menu_tour[i.index_prev].child|default:[]|@count y=1}

        {assign var=child_cat_menu_next value=$list_menu_tour[i.index_next].child|default:[]}
        {assign var=list_cat_menu_next value=$list_menu_tour[i.index_next].cat_menu|default:[]}
        {section name=j loop=$child_cat_menu}
            {assign var=blk value=box_detail_tour_|cat:$run_ajax}
            {assign var=child_prev value=$child_cat_menu[j.index_prev]|default:[]}
            {assign var=child_next value=$child_cat_menu[j.index_next]|default:[]}
        
            {if $run_ajax eq $child_cat_menu[j] && $run_ajax ne 'overview'}
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="type_post" value="{$child_cat_menu[j]}">
                    {$clsISO->getBlock($blk, [
                        "child_cat_menu"=>$child_cat_menu,
                        "count_child_cat_menu_prev"=>$count_child_cat_menu_prev,
                        "child_cat_menu_prev"=>$child_cat_menu_prev,
                        "child_cat_menu_next"=>$child_cat_menu_next,
                        "list_cat_menu_prev"=>$list_cat_menu_prev,
                        "list_cat_menu_next"=>$list_cat_menu_next,
                        "child_cat_menu_j"=> $child_cat_menu[j],
                        "child_cat_menu_j_index_prev"=>$child_prev,
                        "child_cat_menu_j_index_next"=>$child_next,
                        "list_menu_tour_i_index_next"=>$list_menu_tour[i.index_next]|default:[]
                    ])}
                </form>
            {/if}
        {/section}
    {/section}
{/if}

<script type="text/javascript">
	var pcsm_ovv = `{$PCMS|default:''}`;
	var list_check_target = {$list_check_target};
	var pvalTable_ovv = {$pvalTable};
</script>

{literal}
<script type="text/javascript">
$(function() {
    $(".chosen-select").chosen({ width: '100%' });

    $('.textarea_intro_editor_simple').each(function(){
        var $_this = $(this);
        tinyMCE.remove();
        var $editorID = $_this.attr('id');
        $('#'+$editorID).isoTextAreaSimple();
    });

    $.each(list_check_target, function(i, val){
        var $el = $('#' + val['target']).closest('li');
        $el.addClass(val['result']);
        $('#' + val['target']).html(val['name']);
    });
});
</script>
{/literal}
