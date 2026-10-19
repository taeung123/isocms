<div class="breadcrumb">
	<strong>{$core->get_Lang('You are here')}:</strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$core->get_Lang('Languages')}">{$core->get_Lang('Languages')}</a>
    <a href="javascript:history.back();" class="back fr" style="width:50px;">{$core->get_Lang('Back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('Languages FrontPage')}</h2>
    </div>
    <div class="clearfix"><br class="clear" /></div>
    <div class="hastable">
        <table cellspacing="0" class="tbl-grid">
        	<tr>
                <td class="gridheader" style="text-align:left;"><strong>{$core->get_Lang('Name')}</strong></td>
                <td class="gridheader"><strong>{$core->get_Lang('Action')}</strong></td>
            </tr>
            {section name=i loop=$listLang}
			{if $listLang[i] eq $_LANG_ID}
            <tr class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
                <td class="posts column-posts num">
                    <a title="{$core->get_Lang('Edit')}" href="{$PCMS_URL}/?admin&mod={$mod}&act=edit&lang_id={$core->encryptID($listLang[i])}"><strong>{$listLang[i]}</strong></a>
                </td>
                <td style="vertical-align: top; width: 30px; text-align: right; white-space: nowrap;"> 
                    <a title="{$core->get_Lang('Edit')}" class="btn btn-primary" href="{$PCMS_URL}/?admin&mod={$mod}&act=edit&lang_id={$core->encryptID($listLang[i])}">
                    	<i class="icon-white icon-edit"></i>	
                    </a>
                </td>
            </tr>
			{/if}
            {/section}
        </table>
    </div>
</div>
