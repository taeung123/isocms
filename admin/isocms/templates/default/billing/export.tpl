<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act=export">{$core->get_Lang('bookingmanagement')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
		<h2>{$core->get_Lang('Export Data')}</h2>
        <p>{$core->get_Lang('Here you are able to export all ticket-, attendee- and payment data of your event.')}</p>
    </div>
	<div class="clearfix"></div>
    <div class="hastable">
    	<table cellspacing="0" class="tbl-grid" width="100%">
        	<thead>
                <tr>
                    <td class="gridheader" width="150px" style="text-align:left"><strong>{$core->get_Lang('Type')}</strong></td>
                    <td class="gridheader" width="200px" style="text-align:left"><strong>{$core->get_Lang('Reports')}</strong></td>
                    <td class="gridheader" width="200px" style="text-align:left"><strong>{$core->get_Lang('Download')}</strong></td>
                </tr>
            </thead>
            <tbody>
            	<tr>
                	<td class="row1" rowspan="3" valign="top"><strong>{$core->get_Lang('Hotel request')}</strong></td>
                    <td class="row1">{$core->get_Lang('Request Remaining')}</td>
                    <td class="row1"><a href="{$DOMAIN_NAME}/inc/export.php?type=excel_hotel&status=0"><img src="{$URL_IMAGES}/v2/excel.png" /> {$core->get_Lang('Export Data')}</a></td>
                </tr>
                <tr>
                    <td class="row2">{$core->get_Lang('Request Offered')}</td>
                    <td class="row2"><a href="{$DOMAIN_NAME}/inc/export.php?type=excel_hotel&status=1"><img src="{$URL_IMAGES}/v2/excel.png" /> {$core->get_Lang('Export Data')}</a></td>
                </tr>
                <tr>
                    <td class="row1">{$core->get_Lang('Reviewed')}</td>
                    <td class="row1"><a href="{$DOMAIN_NAME}/inc/export.php?type=excel_hotel&status=2"><img src="{$URL_IMAGES}/v2/excel.png" /> {$core->get_Lang('Export Data')}</a></td>
                </tr>

                <tr>
                	<td class="row2" rowspan="3" valign="top"><strong>{$core->get_Lang('Tour booking')}</strong></td>
                    <td class="row2">{$core->get_Lang('Request Remaining')}</td>
                    <td class="row2"><a href="{$DOMAIN_NAME}/inc/export.php?type=excel_tour&status=0"><img src="{$URL_IMAGES}/v2/excel.png" /> {$core->get_Lang('Export Data')}</a></td>
                </tr>
                <tr>
                    <td class="row1">{$core->get_Lang('Request Offered')}</td>
                    <td class="row1"><a href="{$DOMAIN_NAME}/inc/export.php?type=excel_tour&status=1"><img src="{$URL_IMAGES}/v2/excel.png" /> {$core->get_Lang('Export Data')}</a></td>
                </tr>
                <tr>
                    <td class="row2">{$core->get_Lang('Reviewed')}</td>
                    <td class="row2"><a href="{$DOMAIN_NAME}/inc/export.php?type=excel_tour&status=2"><img src="{$URL_IMAGES}/v2/excel.png" /> {$core->get_Lang('Export Data')}</a></td>
                </tr>
                {if 1 eq 2}
                <tr>
                	<td class="row1" rowspan="3" valign="top"><strong>{$core->get_Lang('Tour request')}</strong></td>
                    <td class="row1">{$core->get_Lang('Request Remaining')}</td>
                    <td class="row1"><a href="{$DOMAIN_NAME}/inc/export.php?type=excel_tailortour&status=0"><img src="{$URL_IMAGES}/v2/excel.png" /> {$core->get_Lang('Export Data')}</a></td>
                </tr>
                <tr>
                    <td class="row2">{$core->get_Lang('Request Offered')}</td>
                    <td class="row2"><a href="{$DOMAIN_NAME}/inc/export.php?type=excel_tailortour&status=1"><img src="{$URL_IMAGES}/v2/excel.png" /> {$core->get_Lang('Export Data')}</a></td>
                </tr>
                <tr>
                    <td class="row1">{$core->get_Lang('Reviewed')}</td>
                    <td class="row1"><a href="{$DOMAIN_NAME}/inc/export.php?type=excel_tailortour&status=2"><img src="{$URL_IMAGES}/v2/excel.png" /> {$core->get_Lang('Export Data')}</a></td>
                </tr>
                {/if}
                <tr>
                	<td class="row2" rowspan="3" valign="top"><strong>{$core->get_Lang('Feedback')}</strong></td>
                    <td class="row2">{$core->get_Lang('Contact Remaining')}</td>
                    <td class="row2"><a href="{$DOMAIN_NAME}/inc/export.php?type=excel_feedback&is_process=0"><img src="{$URL_IMAGES}/v2/excel.png" />{$core->get_Lang('Export Data')}</a></td>
                </tr>
                <tr>
                    <td class="row1">{$core->get_Lang('Contact Offered')}</td>
                   	<td class="row1"><a href="{$DOMAIN_NAME}/inc/export.php?type=excel_feedback&is_process=1"><img src="{$URL_IMAGES}/v2/excel.png" />{$core->get_Lang('Export Data')}</a></td>
                </tr>
                <tr>
                    <td class="row2">{$core->get_Lang('Contact Reviewed')}</td>
                    <td class="row2"><a href="{$DOMAIN_NAME}/inc/export.php?type=excel_feedback&is_process=1"><img src="{$URL_IMAGES}/v2/excel.png" /> {$core->get_Lang('Export Data')}</a></td>
                </tr>
            </tbody>
    	</table>
    </div>
</div>