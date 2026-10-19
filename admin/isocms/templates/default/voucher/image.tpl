{if $template eq '_list'}
	{if $total_record gt '0'}
	<style>
		.grid:after {
		  content: '';
		  display: block;
		  clear: both;
		}
		.grid-item {
		  width: 120px;
		  height: 120px;
		  float: left;
		  background: #D26;
		  border-color: hsla(0, 0%, 0%, 0.5);
		  border-radius: 0px;
		  margin: 5px;
		}
		.grid-item--width2 { width: 250px; }
		.grid-item--height2 { height: 250px; }
		.grid-item:hover .product-photo-hover-overlay{
			opacity: 1;
			filter: alpha(opacity=100)
		}
	</style>
	<div class="grid">
		{section name=i loop=$list_images}
		<div class="grid-item{if $smarty.section.i.first} grid-item--width2 grid-item--height2{/if}">
			<div class="aspect-ratio aspect-ratio--square aspect-ratio--interactive">
				<img class="aspect-ratio__content" src="{$list_images[i].image}" />
			</div>
			<div class="product-photo-hover-overlay">
				<ul class="photo-overlay-actions">
					{if !$smarty.section.i.first}
					<li><a href="javascript:void(0)" image_id="{$list_images[i].image_id}" onClick="setup_product_image(this)" class="photo-overlay-actions__link" data-toggle="tooltip" data-placement="top" title="Chọn làm ảnh sản phẩm">{$core->makeIcon('check-square-o')}</a></li>
					{/if}
					<li><a href="javascript:void(0)" image_id="{$list_images[i].image_id}" onClick="open_view_image(this)" class="photo-overlay-actions__link" data-toggle="tooltip" data-placement="top" title="Xem">{$core->makeIcon('eye')}</a></li>
					<li><a href="javascript:void(0)" image_id="{$list_images[i].image_id}" onClick="open_edit_image(this)" class="photo-overlay-actions__link" data-toggle="tooltip" data-placement="top" title="Sửa thẻ alt">{$core->makeIcon('eyedropper')}</a></li>
					<li><a href="javascript:void(0)" image_id="{$list_images[i].image_id}" onClick="delete_image(this)" class="photo-overlay-actions__link" data-toggle="tooltip" data-placement="top" title="Xóa">{$core->makeIcon('trash')}</a></li>
				</ul>
			</div>
		</div>
		{/section}
	</div>
	{else}
	<div class="upload-dropzone__hit-area next-upload-dropzone__hit-area--padded">
		<img src="data:image/png;base64,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" />
		<h3 class="heading heading--no-margin upload-dropzone__heading">
			<div data-bind-show="dragging" aria-hidden="true">
				Thả file ảnh vào đây để thêm mới
			</div>
		</h3>
	</div>
	{/if}
{elseif $template eq '_view'}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body form-horizontal">
				<div class="aspect-ratio aspect-ratio--square aspect-ratio--interactive">
					<img class="aspect-ratio__content" src="{$clsImage->getOneField('image', $image_id)}" />
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default mr-half pull-right" data-dismiss="modal">{$core->get_Lang('Close')}</button>
			</div>
		</div>
	</div>
{elseif $template eq '_edit'}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"> 
				<a href="javascript:void();" class="closeEv close_pop close"><span>×</span></a> 
				<h3 class="modal-title"><strong>{$core->get_Lang('Edit_Alt_Image')}</strong></h3>
			</div>
			<form method="post">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-4">
							<div class="aspect-ratio aspect-ratio--square aspect-ratio--interactive">
								<img class="aspect-ratio__content" src="{$clsImage->getOneField('image', $image_id)}" />
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group mt-half">
								<label for="" class="col-form-label">{$core->get_Lang('Image')} ALT</label>
								<input type="text" class="form-control required" name="title" value="{$clsImage->getOneField('title',$image_id)}"/>
								<span class="help-block">{$core->get_Lang('Image_Alt_Notice')}</span>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success pull-right" onClick="save_edit_image(this)" image_id="{$image_id}">{$core->get_Lang('Save')}</button>
					<button type="button" class="btn btn-default mr-half pull-right" data-dismiss="modal">{$core->get_Lang('Close')}</button>
				</div>
			</form>
		</div>
	</div>
{/if}