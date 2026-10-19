<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')}:</strong>
	<a href="{$PCMS_URL}" title="{$_ADMINLANG.home}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('reviewstour')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('reviewstour')} <a class="btn btn-success" href="{$PCMS_URL}/?mod={$mod}&act=edittourreview&tour_id={$tour_id}" title="{$core->get_Lang('add')}"> <i class="icon-plus icon-white"></i></a></h2>
        <p>{$core->get_Lang('This option is not mandatory, are shown in the assessment and review of user's, to help users easily share travel experiences, quality of program services that you offer Tour')}.</p>
    </div>
	<div class="clearfix"></div>
    <form id="forums" method="post" action="" name="filter" class="filterForm">
        <div class="ui-action">
           <div class="fl fiterbox" style="width:100%">
                <div class="wrap">
                    <div class="searchbox">
                        <input type="text" class="m-wrap short" name="keyword" value="{$keyword}" placeholder="{$_ADMINLANG.search}..." />
                        <a class="btn btn-success fileinput-button" href="javascript:void();" id="searchbtn" style=" padding:5px">
                            <i class="icon-search icon-white"></i>
                        </a>
                    </div>
                    <div style="float:right;">
                        <a href="{$PCMS_URL}/?mod={$mod}" class="btn btn-warning" style="color:#fff"> <i class="icon-folder-open icon-white"></i> <span>{$core->get_Lang('all')}({$number_all})</span> </a>
                        <a href="{$PCMS_URL}/?mod={$mod}&type_list=Trash" class="btn btn-danger" style="color:#fff"> <i class="icon-warning-sign icon-white"></i> <span>{$core->get_Lang('trash')} ({$number_trash})</span> </a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="Testimonial" style="color:#fff; display:none"> <i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span> </a>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="filter" value="filter" />
    </form>
    <input id="list_selected_chkitem" style="display:none" value="0" />
    <table cellspacing="0" class="tbl-grid" width="100%">
        <tr>
            <td class="gridheader"><input id="check_all" type="checkbox" /></td>
            <td class="gridheader"><strong>{$core->get_Lang('index')}</strong></td>
            <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('titleofarticle')}</strong></td>
            <td class="gridheader" style="width:18%;text-align:left"><strong>{$core->get_Lang('fullname')}</strong></td>
            <td class="gridheader" style="width:12%;" align="center"><i class="icon-calendar"></i> {$core->get_Lang('update')}</td>
            <td class="gridheader" colspan="4" style="width:4%"><strong>{$core->get_Lang('move')}</strong></td>
            <td class="gridheader"><strong>{$core->get_Lang('func')}</strong></td>
        </tr>
        {section name=i loop=$allItem}
        <tr class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
            <td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$allItem[i].tour_review_id}" /></td>
            <td class="index">{$smarty.section.i.index+1}</td>
            <td><strong style="font-size:15px">{if $clsClassTable->getOneField('is_online',$allItem[i].tour_review_id) eq 0}<span style="color:#F90">[PRIVATE]</span>{/if} {$clsClassTable->getTitle($allItem[i].tour_review_id)}</strong></td>
            <td><strong>{$clsClassTable->getFullName($allItem[i].tour_review_id)}</strong></td>
            <td style="text-align:center">{$allItem[i].reg_date|date_format:"%d/%m/%Y %H:%M"}</td>
            <td style="vertical-align: middle;text-align:center">
                {if !$smarty.section.i.first}
                <a title="{$core->get_Lang('movetop')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=move&direct=movetop&tour_review_id={$core->encryptID($allItem[i].tour_review_id)}"><i class="icon-circle-arrow-up"></i></a>
                {/if}
            </td>
            <td style="vertical-align: middle;text-align:center">
                {if !$smarty.section.i.last}
                <a title="{$core->get_Lang('movebottom')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=move&direct=movebottom&tour_review_id={$core->encryptID($allItem[i].tour_review_id)}"><i class="icon-circle-arrow-down"></i></a>
                {/if}
            </td>
            <td style="vertical-align: middle;text-align:center">
                {if !$smarty.section.i.first}
                <a title="{$core->get_Lang('moveup')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=move&direct=moveup&tour_review_id={$core->encryptID($allItem[i].tour_review_id)}"><i class="icon-arrow-up"></i></a>
                {/if}
            </td>
            <td style="vertical-align: middle;text-align:center">
                {if !$smarty.section.i.last}
                <a title="{$core->get_Lang('movedown')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=move&direct=movedown&tour_review_id={$core->encryptID($allItem[i].tour_review_id)}"><i class="icon-arrow-down"></i></a>
                {/if}
            </td>
            <td style="vertical-align: middle; width: 40px; text-align: right; white-space: nowrap;">
                {if $allItem[i].is_trash eq '1'}
                <a title="{$core->get_Lang('restore')}" class="btn btn-success fileinput-button" href="{$PCMS_URL}/?mod={$mod}&act=restore&tour_review_id={$core->encryptID($allItem[i].tour_review_id)}">
                    <i class="icon-refresh icon-white"></i>
                </a>
                <a title="{$core->get_Lang('delete')}" class="btn btn-danger fileinput-button" href="{$PCMS_URL}/?mod={$mod}&act=delete&tour_review_id={$core->encryptID($allItem[i].tour_review_id)}">
                    <i class="icon-remove icon-white"></i>
                </a>
                {else}
                <a title="{$core->get_Lang('edit')}" class="btn btn-primary fileinput-button" href="{$PCMS_URL}/?mod={$mod}&act=edittourreview&tour_review_id={$core->encryptID($allItem[i].tour_review_id)}&tour_id={$tour_id}">
                    <i class="icon-edit icon-white"></i>
                </a>
                <a title="{$core->get_Lang('trash')}" class="btn btn-warning fileinput-button" href="{$PCMS_URL}/?mod={$mod}&act=trash&tour_review_id={$core->encryptID($allItem[i].tour_review_id)}">
                    <i class="icon-trash icon-white"></i>
                </a>
                {/if}
            </td>
        </tr>
        {/section}
    </table>
    <div class="adminPaging">
        <ul class="lstAdminPaging">
        {section name=i loop=$listPageNumber}
            <li>
                <a href="{$PCMS_URL}/{$link_page_current}&page={$listPageNumber[i]}" {if $listPageNumber[i] eq $currentPage}class="active"{/if}>{$listPageNumber[i]}</a>
            </li>
        {/section}
        </ul>
        <div class="report">
            <strong>{$core->get_Lang('statistical')}</strong>: <strong>{$totalRecord}</strong> {$core->get_Lang('records')}/<strong>{$totalPage}</strong> {$core->get_Lang('page')}. {$core->get_Lang('youareonpagenumber')} <strong>{$currentPage}</strong>.
        </div>
    </div>
</div>