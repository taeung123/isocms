<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')}:</strong>
    <a href="{$PCMS_URL}">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('System Settings')}</a>
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">Quay lại</a>
</div>
<div class="container-fluid bg-grey">	
	{$clsISO->showExchangeRates()}
</div>
{literal}
<style type="text/css">
table {
	font-size:14px;
    border-spacing: 0;
    border-collapse: collapse;
}
.table{width:100%}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
}
.table>thead>tr>th {
    vertical-align: bottom;
    border-bottom: 2px solid #ddd;
	text-align:left;
}
.table>caption+thead>tr:first-child>td, .table>caption+thead>tr:first-child>th, .table>colgroup+thead>tr:first-child>td, .table>colgroup+thead>tr:first-child>th, .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
    border-top: 0;
}
.table>tbody>tr.tr_old>td, .table>tbody>tr.tr_old>th, .table>tbody>tr>td.tr_old, .table>tbody>tr>th.tr_old, .table>tfoot>tr.tr_old>td, .table>tfoot>tr.tr_old>th, .table>tfoot>tr>td.tr_old, .table>tfoot>tr>th.tr_old, .table>thead>tr.tr_old>td, .table>thead>tr.tr_old>th, .table>thead>tr>td.tr_old, .table>thead>tr>th.tr_old {
    background-color: #dff0d8;
}
.table>tbody>tr.info>td, .table>tbody>tr.info>th, .table>tbody>tr>td.info, .table>tbody>tr>th.info, .table>tfoot>tr.info>td, .table>tfoot>tr.info>th, .table>tfoot>tr>td.info, .table>tfoot>tr>th.info, .table>thead>tr.info>td, .table>thead>tr.info>th, .table>thead>tr>td.info, .table>thead>tr>th.info {
    background-color: #d9edf7;
}
</style>
{/literal}