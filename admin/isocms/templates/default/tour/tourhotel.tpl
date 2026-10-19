<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod=tour">{$core->get_Lang('tours')}</a>
    <a>&raquo;</a>
    <a href="{$curl}">{$core->get_Lang('listhotels')}</a>
    <!-- Back -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
	<div class="wrap">
        <div class="page-title">
            <h2>{$core->get_Lang('listhotelstour')} {$clsTour->getTitle($tour_id)}</h2>
            <p>{$core->get_Lang('System management tour hotels')}</p>
        </div>
    </div>
    <div class="clearfix"><br /></div>
    <form id="forums" method="post" class="filterForm" action="">
        <div class="ui-action">
            <div class="wrap">
                <div class="fiterbox" style="width:100%">
                    <div class="wrap">
                        <div class="searchbox" style="float:left !important; width:100%">
                            <input type="text" class="m-wrap short" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}..." />
                            <a class="btn btn-success iso-corner-all fileinput-button" id="searchbtn" style="padding:5px">
                                <i class="icon-search icon-white"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="filter" value="filter" />
    </form>
    <div class="clearfix"></div>
    <div class="hastable">
        <table cellspacing="0" class="tbl-grid" width="100%">
            <tr>
                <td class="gridheader"><strong>{$core->get_Lang('index')}</strong></td>
                <td style="text-align:left;" class="gridheader"><strong>{$core->get_Lang('nameofhotels')}</strong></td>
                <td class="gridheader" style="width:8%;text-align:center;"><strong>{$core->get_Lang('Price')}</strong></td>
                <td class="gridheader" style="width:8%"><strong>{$core->get_Lang('Ranking')}</strong></td>
                <td class="gridheader" style="text-align:center; width:40px;"><strong>{$core->get_Lang('func')}</strong></td>
            </tr>
            {if $allItem}
            {foreach from=$allItem key=k item=v}
            <tr class="{cycle values = "row1,row2"}">
            	<td class="index">{$k+1}</td>
                <td>
                    <a title="Edit" href="{$PCMS_URL}/index.php?mod=hotel&act=edit&hotel_id={$v}">
                       <strong style="font-size:15px;">{$clsHotel->getTitle($v)}</strong>
                    </a>
                    <div class="clear" style="height:5px;"></div>
                    <font color="#c00000">{$core->get_Lang('address')}</font> : {$clsHotel->getAddress($v)}
                </td>
                <td style="text-align:right; white-space:nowrap">
                    <strong class="format_price" style="font-size:13px">{$clsHotel->getPrice($v)}</strong>
                </td>
                <td style="text-align:center"><img src="{$clsHotel->getImageStar($clsHotel->getStar($v))}" /></td>
                <td><a class="iso-cancel-action confirm_delete" title="{$core->get_Lang('delete')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Delete&hotel_id={$v}&tour_id={$core->encryptID($tour_id)}"><i class="icon-upload icon-white"></i> {$core->get_Lang('delete')}</a></td>
            </tr>
            {/foreach}
            {else}<tr><td colspan="6">{$core->get_Lang('No Data')}!</td></tr>{/if}
        </table>
        <div style="border:1px solid #ccc; padding:5px; margin-top:10px;">
        <strong>{$core->get_Lang('Warning')}</strong>:  
        <img src="{$URL_IMAGES}/warning-20.png" align="absmiddle" /> {$core->get_Lang('Warning due to data not entered or entered incorrectly formatted')}.
        </div>
    </div>
    <div class="clearfix"><br /></div>
</div>