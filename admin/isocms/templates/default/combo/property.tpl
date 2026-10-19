<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$curl}">{$clsClassTable->getTextByType($type)}</a>
    <!--// -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">	
        <h2>{$clsClassTable->getTextByType($type)}</h2>
        <p>{$core->get_Lang('systemmanagementhotelproperty')}</p>
    </div>
    <div class="clearfix"><br /></div>
    <form id="forums" method="post" action="">
		<div class="filterbox" style="width:100%">
			<div class="wrap">
				<div class="searchbox">
					<input class="text" type="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}" />
					<a class="btn btn-success" href="javascript:void();" id="searchBtn" style="padding:6px">
						<i class="icon-search icon-white"></i>
					</a>
					<a class="btn btn-success btnCreateProperty" href="javascript:void(0);" style="padding:4px">
						<i class="icon-plus icon-white"></i> {$core->get_Lang('add')}
					</a>
				</div>
			</div>
		</div>
        <input type="hidden" name="filter" value="filter" />
    </form>
    <div class="clearfix"></div>
    <form id="listItem" method="post" action="">
        <input type="hidden" value="delete" name="delete" />
        <table cellspacing="0" class="tbl-grid" width="100%">
            <thead>
                <td class="gridheader"><strong>{$core->get_Lang('index')}</strong></td>
                <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></td>
                <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('type')}</strong></td>
                <td class="gridheader" style="width:6%"><strong>{$core->get_Lang('status')}</strong></td>
                <td class="gridheader" colspan="4" style="width:4%"><strong>{$core->get_Lang('move')}</strong></td>
                <td class="gridheader" style="text-align:center;"><strong>{$core->get_Lang('func')}</strong></td>
            </thead>
            <tr>
            {section name=i loop=$allItem}
			<tr class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}">
                <td class="index">{$smarty.section.i.index+1}</td>
                <td>
                    <a class="btnedit_hotelproperty" href="javascript:void(0);" data="{$allItem[i].hotel_property_id}">
                        <strong class="title">  {$clsClassTable->getTitle($allItem[i].hotel_property_id)}</strong>
                    </a>
                </td>
                <td><strong class="title">{$clsClassTable->getOneField('type',$allItem[i].hotel_property_id)}</strong></td>
                <td style="text-align:center">
                    <a href="javascript:void(0);" class="SiteClickPublic" clsTable="HotelProperty" pkey="hotel_property_id" sourse_id="{$allItem[i].hotel_property_id}" rel="{$clsClassTable->getOneField('is_online',$allItem[i].hotel_property_id)}" title="{$core->get_Lang('Click to change status')}">
                        {if $clsClassTable->getOneField('is_online',$allItem[i].hotel_property_id) eq '1'}
                        <i class="fa fa-check-circle green"></i>
                        {else}
                        <i class="fa fa-minus-circle red"></i>
                        {/if}
                    </a>
                </td>
                <td style="vertical-align: middle;text-align:center">
                    {if !$smarty.section.i.first}
                    <a title="{$core->get_Lang('movetop')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=move_property&direct=movetop&type={$type}&hotel_property_id={$allItem[i].hotel_property_id}">
                        <i class="icon-circle-arrow-up"></i>
                    </a>
                    {/if}
                </td>
                <td style="vertical-align: middle;text-align:center">
                    {if !$smarty.section.i.last}
                    <a title="{$core->get_Lang('movebottom')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=move_property&direct=movebottom&type={$type}&hotel_property_id={$allItem[i].hotel_property_id}"><i class="icon-circle-arrow-down"></i></a>
                    {/if}
                </td>
                <td style="vertical-align: middle;text-align:center">
                    {if !$smarty.section.i.first}
                    <a title="{$core->get_Lang('moveup')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=move_property&direct=moveup&type={$type}&hotel_property_id={$allItem[i].hotel_property_id}">
                        <i class="icon-arrow-up"></i>
                    </a>
                    {/if}
                </td>
                <td style="vertical-align: middle;text-align:center">
                    {if !$smarty.section.i.last}
                    <a title="{$core->get_Lang('movedown')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=move_property&direct=movedown&type={$type}&hotel_property_id={$allItem[i].hotel_property_id}">
                        <i class="icon-arrow-down"></i>
                    </a>
                    {/if}
                </td>
                <td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
                    <div class="btn-group">
                        <button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
                        <ul class="dropdown-menu" style="right:0px !important">
                            <li><a class="btnedit_hotelproperty" title="{$core->get_Lang('edit')}" href="javascript:void();" data="{$allItem[i].hotel_property_id}"><i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span></a></li>
                            <li><a class="btndelete_hotelproperty" title="{$core->get_Lang('delete')}" href="javascript:void();" data="{$allItem[i].hotel_property_id}"><i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span></a></li>
                        </ul>
                    </div>
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
    </form>
</div>
<script type="text/javascript">
	var parent_id = '{$parent_id}';
	var type = '{$type}';
</script>
{literal}
<script type="text/javascript">
	$().ready(function(){
		$('#slb_Type').change(function(){
			var $_this = $(this);
			window.location.href = '/admin/index.php?mod='+mod+'&act='+act+'&type='+$_this.val();
		});
		$(document).on('click', '.btnCreateProperty', function(ev){
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script+'/?mod='+mod+'&act=ajSiteHotelProperty',
				data: {
					'parent_id' : parent_id,
					'type' : type,
					'tp' : 'F'
				},
				dataType: "html",
				success: function(html){
					vietiso_loading(0);
					makepopupnotresize(520,'auto',html,'pop_Property');
					$('#pop_Property').css('top','100px');
				}
			});
			return false;
		});
		$(document).on('click', '.btnedit_hotelproperty', function(ev){
			var $_this = $(this);
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script+'/?mod='+mod+'&act=ajSiteHotelProperty',
				data: {
					'hotel_property_id' : $_this.attr('data'),
					'type' : type,
					'tp' : 'F'
				},
				dataType: "html",
				success: function(html){
					vietiso_loading(0);
					makepopupnotresize(520,'auto',html,'pop_Property');
					$('#pop_Property').css('top','100px');
				}
			});
			return false;
		});
		$(document).on('click', '.btndelete_hotelproperty', function(ev){
			var $_this = $(this);
			if(confirm(confirm_delete)){
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script+'/?mod='+mod+'&act=ajSiteHotelProperty',
					data: {'hotel_property_id' : $_this.attr('data'),'tp' : 'D'},
					dataType: "html",
					success: function(html){
						vietiso_loading(0);
						window.location.reload();
					}
				});
			}
			return false;
		});
		$(document).on('click', '.clickSubmitProperty', function(ev){
			var $_this = $(this);
			var $hotel_property_id = $_this.attr('hotel_property_id');
			var $_form = $_this.closest('.frmPop');
			var $title = $_form.find('input[name=title_HotelProperty]');
			var $type = $_form.find('select[name=type_HotelProperty]');
			var $intro = $_form.find('textarea[name=intro_HotelProperty]');		
						
			if($title.val()==''){
				$title.focus();
				alertify.error(field_is_required);
				return false;
			}
			if($type.val()==''){
				$type.focus();
				alertify.error(field_is_required);
				return false;
			}
			var adata = {
				'title'				: $title.val(),
				'type'				: $type.val(),
				'intro'				: $intro.val(),
				'hotel_property_id'	: $hotel_property_id,
				'tp'				: 'S'
			};
			vietiso_loading(1);
			$.ajax({
				type : "POST",
				url: path_ajax_script+'/?mod='+mod+'&act=ajSiteHotelProperty',
				data: adata,
				dataType: 'html',
				success : function(html){
					vietiso_loading(0);
					window.location.reload();
				}
			});
		});
	});
</script>
{/literal}