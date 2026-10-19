<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$core->get_Lang('hotels')}">{$core->get_Lang('hotels pro')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('pricerange')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('pricerange')}</h2>
    </div>
    <div class="fl fiterbox" style=" width:80%">
        <div class="wrap">
            <div class="searchbox" style="float:left !important; width:100%">
                <input type="text" class="m-wrap short" name="keyword" id="keyword" placeholder="{$core->get_Lang('search')}" />
                <a class="btn btn-success fileinput-button" href="javascript:void();" id="findPriceRange" style=" padding:5px">
                    <i class="icon-search icon-white"></i>
                </a>
                <a href="javascript:void();" class="btn btn-success btnCreatePriceRange">
                    <i class="icon-plus icon-white"></i> <span>{$core->get_Lang('add')}</span> 
                </a>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="hastable">
        <table class="tbl-grid" cellpadding="0" width="100%">
            <tr>
                <td class="gridheader" style=" width:4%">{$core->get_Lang('index')}</td>
                <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></td>
                <td class="gridheader" style="text-align:right"><strong>{$core->get_Lang('minrate')}</strong></td>
                <td class="gridheader" style="text-align:right"><strong>{$core->get_Lang('maxrate')}</strong></td>
                <td class="gridheader" style="width:3%" colspan="4"><strong>{$core->get_Lang('move')}</strong></td>
                <td class="gridheader" style="text-align:center;"><strong>{$core->get_Lang('func')}</strong></td>
            </tr>
            <tbody id="tblHolderPriceRange">
            </tbody>
        </table>
        <div class="clearfix" style="height:5px"></div>
            <div class="pagination_box">
            <div class="wrap holderEvent_tbl" id="dataTable_paginate">
            <!-- Ajax Loading pagination -->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{$URL_THEMES}/hotelpro/jquery.hotelpro.js?v={$upd_version}"></script>