<header class="ui-title-bar-container ">
	<div class="ui-title-bar">
		<div class="ui-title-bar__navigation">
			<div class="ui-breadcrumbs">
				<a class="btn btn-default ui-breadcrumb" href="{$PCMS_URL}/index.php?mod=setting" title="{$core->get_Lang('Setting')}">
					{$core->makeIcon('angle-left mr-5')}
					<span class="ui-breadcrumb__item">{$core->get_Lang('Products')}</span>
				</a>
			</div>
		</div>
	</div>
	<div class="ui-title-bar">
		<div class="ui-title-bar__main-group">
			<div class="ui-title-bar__heading-group">
				<h1 class="ui-title-bar__title">{$core->get_Lang('Blocks_Product')}</h1>
			</div>
		</div>
		<div class="action-bar">
			<div class="ui-title-bar__mobile-primary-actions">
				<div class="ui-title-bar__actions">
					<a href="javascript:void(0);" class="ui-button ui-button--primary btnCreateNewBlock ui-title-bar__action" title="{$core->get_Lang('Addnew')}">{$core->get_Lang('Addnew')}</a>
				</div>
			</div>
		</div>
	</div>
</header>
<div class="clearfix"></div>
<div class="ui-layout">
	<div class="ui-layout__sections">
		<div class="ui-layout__section">
			<div class="ui-layout__item">
				<div class="ui-card">
					<div class="next-tab__container">
						<ul class="next-tab__list filter-tab-list">
							{section name=i loop=$lstproperty}
							<li class="filter-tab-item" data-tab-index="1">
								<a href="{$PCMS_URL}/index.php?mod={$mod}&act=block&block_id={$lstproperty[i].property_id}" class="filter-tab filter-tab-active show-all-items next-tab{if $block_id eq $lstproperty[i].property_id} next-tab--is-active{/if}">{$clsProperty->getTitle($lstproperty[i].property_id)}</a>
							</li>
							{/section}
						</ul>
					</div>
					<div class="ui-card__section has-bulk-actions pages">
						<form method="post">
							<div class="form-search form-inline">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="{$core->get_Lang('EnterSearchKeyword')}">
								</div>
								<input type="hidden" name="filter" value="filter" />
								<button type="submit" class="btn btn-success">{$core->makeIcon('search', 'Search')}</button>
								<div class="form-group pull-right">
									<a href="javascript:void(0)" clsTable="ProductStore" class="btn btn-danger text-white btn-delete-all" style="display:none"> 
										{$core->makeIcon('times', $core->get_Lang('Delete'))}
									</a>
								</div>
							</div>
						</form>
						<div class="form-group">
							<div class="holder_product_store">Loading...</div>	
						</div>
						<div class="form-group row">
							<div class="col-md-6">
								<div id="dropdown" class="dropdown dropup mega-dropdown">
									<button class="btn btn-default dropdown-toggle fixed-width btn-filter btn-choose-product" data-toggle="dropdown">
										{$core->makeIcon('plus-circle', $core->get_Lang('AddProduct'))} {$core->makeIcon('caret-up')}
									</button>
									<div class="dropdown-menu mega-dropdown-menu">
										<div class="dropdown-panel-body">
											<div class="form-group">
												<div class="col-md-12">
													<div class="input-group">
														<span class="input-group-addon">{$core->makeIcon('search')}</span>
														<input type="text" data-uid="{$uid}" data-url="{$_url}" placeholder="Tìm kiếm" class="form-control input-search" />
													</div>
												</div>
											</div>
											<div class="holder_product_results">Loading...</div>
										</div>
										<div class="dropdown-panel-footer">
											<div class="button-group pull-right">
												<input type="hidden" class="holder_current_page" value="1" />
												<button type="button" disabled class="btn btn-default">{$core->makeIcon('arrow-left')}</button>
												<button type="button" class="btn btn-default">{$core->makeIcon('arrow-right')}</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var block_id = '{$block_id}',
		product_type = '_BLOCK';
</script>
{literal}
<style type="text/css">
	.single-suggest-result li.single-suggest-select{ padding: 5px !important}
	.dropup .mega-dropdown-menu:after, .dropup .dropdown-menu:before{ left: 20px !important}
	.ui-stack--spacing-tight>*{ margin-top:.9rem !important; margin-left:.9rem !important}
</style>
<script type="text/javascript">
	$(function(){
		load_list_search({'for_id':block_id,'product_type':product_type});
		load_list_product_store(product_type,block_id,{});
		/** End */
		$('div.dropdown.mega-dropdown a').on('click', function (event) {
			$(this).parent().toggleClass('open');
		});
		$('body').on('click',function(e){
			if(!$('.dropdown.mega-dropdown').is(e.target) 
			   && $('.dropdown.mega-dropdown').has(e.target).length===0 
			   && $('.open.mega-dropdown').has(e.target).length===0){
				$('.dropdown.mega-dropdown').removeClass('open');
			}else{
				e.stopPropagation();
			}
		});
		$_document.on('keyup', '.input-search', $Core.util.delay(function(ev){
			var $_adata = {'block_id':block_id,'product_type':product_type,'keysearch':$(this).val()};
			load_list_search($.extend({'page':1}, $_adata));
		},500));
		$_document.on('click', '.btnCreateNewBlock', function(){
			$.post(path_ajax_script+"/index.php?mod="+mod+"&act=ajOpenBlock", {'tp':'F'}, function(html){
				makepopup('auto','auto',html,'OpenBlock');
				$('#OpenBlock').css('top',100);
			});
			return false;
		});
		$_document.on('click', '.ajSaveNewBlock', function(){
			var $_this = $(this),
				$_form = $_this.closest('form');
			
			var _validated = 0;
			if($('input.required',$_form).length){
				$('input.required',$_form).each(function(){
					if($Core.util.isEmpty($(this).val())){
						_validated++;
						$(this).focus();
						return false;
					}
				});
			}
			if(_validated==0){
				$_form.ajaxSubmit({
					type: "POST",
					url: path_ajax_script+"/index.php?mod="+mod+"&act=ajOpenBlock",
					dataType: 'html',
					data:{'tp':'S'},
					success: function(html){
						if(html.indexOf('_success') >=0){
							$Core.popup.close($_form.closest('.modal'));
							window.location.reload(true);
						}
					}
				});
			}
		});
	});
	function add_product_store(_this, product_id, for_id, product_type){
		var $_adata = {'product_id':product_id,'for_id':for_id,'product_type':product_type};
		$.post(path_ajax_script+"/index.php?mod="+mod+"&act=add_product_store", $_adata, function(html){
			if(html.indexOf('_success') >= 0){
				$(_this).fade
				load_list_product_store(product_type, for_id, {});
			}
		});
	}
	function move_product_store(_this){
		var for_id = $(_this).attr('for_id'),
			direct = $(_this).attr('direct'),
			product_store_id = $(_this).attr('id'),
			product_type = $(_this).attr('product_type');
		
		var $_adata = {'for_id':for_id,'direct':direct,'product_store_id':product_store_id,'product_type':product_type};
		$.post(path_ajax_script+"/index.php?mod="+mod+"&act=move_product_store", $_adata, function(){
			load_list_product_store(product_type, for_id, {});
		});
		return false;
	}
	function load_list_search(options){
		var $_adata = options || {};
		$.post(path_ajax_script+"/index.php?mod="+mod+"&act=load_product_search", $_adata, function(respJson){
			$('.holder_product_results').html(respJson.html)
			$('.holder_current_page').val(respJson.current_page);
		},'json');
	}
	function delete_product_store(_this){
		var for_id = $(_this).attr('for_id'),
			direct = $(_this).attr('direct'),
			product_store_id = $(_this).attr('id'),
			product_type = $(_this).attr('product_type');
		$Core.alert.confirm("Xác nhận xóa?", "Bạn chắc chắn muốn xóa bỏ nội dung này?", function(){
			var $_adata = {'for_id':for_id,'product_store_id':product_store_id,'product_type':product_type};
			$.post(path_ajax_script+"/index.php?mod="+mod+"&act=delete_product_store", $_adata, function(html){
				load_list_product_store(product_type, for_id, {});
			},'json');
		});
		return false;
	}
	function load_list_product_store(product_type, for_id, options){
		var $_adata = options || {};
		$_adata['for_id'] = for_id;
		$_adata['product_type'] = product_type;
		vietiso_loading(1);
		$.post(path_ajax_script+"/index.php?mod="+mod+"&act=load_list_product_store", $_adata, function(respJson){
			vietiso_loading(0);
			$('.holder_product_store').html(respJson.html);
			if(parseInt(respJson.total_record)>0){
				$('#pager_product_store').pagination({
					total: parseInt(respJson.total_record),
					pageSize : respJson.number_per_page,
					onSelectPage: function(pageNumber,pageSize){
						load_list_product_store(product_type,for_id,{'page':pageNumber, 'number_per_page':pageSize});
					},
					onRefresh: function(pageNumber,pageSize){
						load_list_product_store(product_type,for_id,{'page':pageNumber, 'number_per_page':pageSize});
					},
					onChangePageSize: function(pageSize){
						load_list_product_store(product_type,for_id,{'page':1,'number_per_page':pageSize});
					}
				})
			}
		},'json');
	}
</script>
{/literal}