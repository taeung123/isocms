<div class="breadcrumb">
	<strong>{$core->get_Lang('youareahere')}: </strong>
	<a href="{$PCMS_URL}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('tours')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act=setting">{$core->get_Lang('settingtour')}</a>
    <a>&raquo;</a>
    <a href="javascript:void();" title="{$mod}">{$core->get_Lang('tailorproperty')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">	
        <h2>{$core->get_Lang('tailorproperty')} <select id="slb_Type" class="slbHighlight"> {$clsClassTable->getSelectByType($type)}</select></h2>
        <p>{$core->get_Lang('systemmanagementtailorproperty')}</p>
    </div>
    <form id="forums" method="post" action="">
		<div class="fiterbox">
			<div class="wrap">
				<div class="searchbox">
					<input class="text" type="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}" />
					<a class="btn btn-success" href="javascript:void();" id="searchBtn" style=" padding:6px">
						<i class="icon-search icon-white"></i>
					</a>
                    <a href="javascript:void();" class="btn btn-success btnCreateTailorProperty">
						<i class="icon-plus icon-white"></i>
					</a>
				</div>
				<div class="fr group_buttons">
					<a href="{$PCMS_URL}/?mod=setting&act=tailor" class="btn btn-danger" title="{$core->get_Lang('Tailor Setting')}"><i class="icon-cog icon-white"></i> <span>{$core->get_Lang('Tailor Setting')}</span> </a>
				</div>
			</div>
		</div>
        <input type="hidden" name="filter" value="filter" />
    </form>
    <div class="clearfix"></div>
    <form id="listItem" method="post" action="">
        <input type="hidden" value="delete" name="delete" />
        <table cellspacing="0" class="tbl-grid tblAction" id="tblLanguage" width="100%">
            <thead>
            	<td class="gridheader" style="width: 80px;"><strong>{$core->get_Lang('index')}</strong></td>
            	<td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></td>
                <td class="gridheader" style="text-align:left; width: 200px;"><strong>{$core->get_Lang('type')}</strong></td>
                <td class="gridheader" style="width: 100px"><strong>{$core->get_Lang('func')}</strong></td>
            </thead>
           <tr>
		   <tbody id="SortAble">
			   {section name=i loop=$allItem}
			   <tr style="cursor:move" id="order_{$allItem[i].tailor_property_id}" class="{cycle values="row1,row2"}">
					<td class="index">{$smarty.section.i.index+1}</td>
					<td>
						<a class="clickToEditProperty" href="javascript:void();" data="{$allItem[i].tailor_property_id}">
							<strong class="title">
								{$clsClassTable->getTitle($allItem[i].tailor_property_id)}
							</strong>
						</a>
					</td>
					<td><strong class="title">{$clsClassTable->getTextByType($allItem[i].type)}</strong></td>
					<td style="vertical-align: middle; width: 20px; text-align: right; white-space: nowrap;"> 
						<div class="btn-group">
							<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown">
								<i class="icon-cog"></i> <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" style="right:0px !important">
								<li><a title="{$core->get_Lang('edit')}" class="btnedit_tailorproperty" data="{$allItem[i].tailor_property_id}" href="javascript:void();"><i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span></a></li>
								<li><a title="{$core->get_Lang('delete')}" class="btndelete_tailorproperty" data="{$allItem[i].tailor_property_id}" href="javascript:void();"><i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span></a></li>
							</ul>
						</div>
					</td>
				</tr>
				{/section}
			</tbody>	
        </table>
    </form>
</div>
<script type="text/javascript">
	var type = '{$type}';
	var $recordPerPage = '{$recordPerPage}';
	var $currentPage = '{$currentPage}'; 
</script>
{literal}
<script type="text/javascript">
	$().ready(function(){
		$('#slb_Type').change(function(){
			var $_this = $(this);
			window.location.href = '/admin/index.php?mod='+mod+'&act='+act+'&type='+$_this.val();
		});
		$('.btnCreateTailorProperty').click(function(){
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script+'/?mod='+mod+'&act=ajOpenTailorProperty',
				data: {'tp':'F','type' : type},
				dataType: "html",
				success: function(html){
					vietiso_loading(0);
					makepopupnotresize('25%','auto',html,'frmAddProperty');
				}
			});
			return false;
		});
		$(document).on('click', '.btnedit_tailorproperty', function(ev){
			var $_this = $(this);
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script+'/?mod='+mod+'&act=ajOpenTailorProperty',
				data: {'tp':'F','tailor_property_id' : $_this.attr('data'),'type' : type},
				dataType: "html",
				success: function(html){
					vietiso_loading(0);
					makepopupnotresize('25%','auto',html,'frmEditProperty');
				}
			});
			return false;
		});
		$(document).on('click', '.btndelete_tailorproperty', function(ev){
			if(confirm(confirm_delete)){
				var $_this = $(this);
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script+'/?mod='+mod+'&act=ajOpenTailorProperty',
					data: {'tp':'D','tailor_property_id' : $_this.attr('data'),'type' : type},
					dataType: "html",
					success: function(html){
						vietiso_loading(0);
						window.location.reload();
					}
				});
			}
			return false;
		});
		$(document).on('click', '#clickSubmitProperty', function(ev){
			var $_this = $(this);
			var $_form = $_this.closest('.frmPop');
			var $title = $_form.find('input[name=title]');
			var $intro = $_form.find('textarea[name=intro]');
			var $type  = $_form.find('#type');
			
			if($title.val()==''){
				$title.addClass('error').focus();
				alertify.error(field_is_required);
				return false;
			}
			if($type.val()==''){
				$type.addClass('error').focus();
				alertify.error(field_is_required);
				return false;
			}
			var adata = {
				'title'						: $title.val(),
				'type'						: $type.val(),
				'tailor_property_id'		: $_this.attr('tailor_property_id'),
				'tp' : 'S'
			};
			$.ajax({
				type : "POST",
				url : path_ajax_script+'/index.php?mod='+mod+'&act=ajOpenTailorProperty',
				data: adata,
				dataType: 'html',
				success : function(html){
					if(html.indexOf('_EXIST') >= 0){
						alertify.error(exist_error);
					}
					if(html.indexOf('_SUCCESS') >= 0){
						window.location.reload();
					}
					if(html.indexOf('_ERROR') >= 0){
						alertify.error(update_error);
					}
				}
			});
			return false;
		});
		$("#SortAble").sortable({
			opacity: 0.8,
			cursor: 'move',
			start: function(){
				vietiso_loading(1);
			},
			stop: function(){
				vietiso_loading(0);
			},
			update: function(){
				var recordPerPage = $recordPerPage;
				var currentPage = $currentPage;
				var type = type;
				var order = $(this).sortable("serialize")+'&update=update'+'&recordPerPage='+recordPerPage+'&currentPage='+currentPage+'&type='+type;
				$.post(path_ajax_script+"/index.php?mod=tour&act=ajUpdPosSortTailorProperty", order,  
				function(html){
					vietiso_loading(0);
					location.href = REQUEST_URI;
				});
			}
		});
	});
</script>
{/literal}