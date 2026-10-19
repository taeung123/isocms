<div id="searchSortFilters" class="hidden992">

	{if $mod eq tour and $act eq city}
    <ul class="sorting">
        <li class="title">Sort By</li>
        <li>
            <a href="{$clsCity->getLink($city_id)}&sortby=rating-asc" sortby="rating-asc" class="show-loader sortRule" city_id={$city_id} data-remote="true">Rating<span class='icon'>e</span></a>
        </li>
        <li>
            <a href="{$clsCity->getLink($city_id)}&sortby=rating-desc" sortby="rating-desc" class="show-loader sortRule" city_id={$city_id} data-remote="true">Rating<span class='icon icon2'>e</span></a>
        </li>
        <li>
            <a href="{$clsCity->getLink($city_id)}&sortby=offer-asc" sortby="offer-asc" class="show-loader sortRule" city_id={$city_id} data-remote="true">Offers<span class='icon'>e</span></a>
        </li>
        <li>
            <a href="{$clsCity->getLink($city_id)}&sortby=offer-desc" sortby="offer-desc" class="show-loader sortRule" city_id={$city_id} data-remote="true">Offers<span class='icon icon2'>e</span></a>
        </li>
        <li>
            <a href="{$clsCity->getLink($city_id)}&sortby=new-asc" sortby="new-asc" class="show-loader sortRule" city_id={$city_id} data-remote="true">New<span class='icon'>e</span></a>
        </li>
        <li>
            <a href="{$clsCity->getLink($city_id)}&sortby=new-desc" sortby="new-desc" class="show-loader sortRule" city_id={$city_id} data-remote="true">New<span class='icon icon2'>e</span></a>
        </li>
    </ul>
    {elseif $mod eq 'destination'}
    <ul class="sorting">
        <li class="title">Sort By</li>
        <li>
            <a href="{$clsCountryEx->getLink($country_id)}&sortby=rating-asc" sortby="rating-asc" class="show-loader sortRule" country_id={$country_id} data-remote="true">Rating<span class='icon'>e</span></a>
        </li>
        <li>
            <a href="{$clsCountryEx->getLink($country_id)}&sortby=rating-desc" sortby="rating-desc" class="show-loader sortRule" country_id={$country_id} data-remote="true">Rating<span class='icon icon2'>e</span></a>
        </li>
        <li>
            <a href="{$clsCountryEx->getLink($country_id)}&sortby=offer-asc" sortby="offer-asc" class="show-loader sortRule" country_id={$country_id} data-remote="true">Offers<span class='icon'>e</span></a>
        </li>
        <li>
            <a href="{$clsCountryEx->getLink($country_id)}&sortby=offer-desc" sortby="offer-desc" class="show-loader sortRule" country_id={$country_id} data-remote="true">Offers<span class='icon icon2'>e</span></a>
        </li>
        <li>
            <a href="{$clsCountryEx->getLink($country_id)}&sortby=new-asc" sortby="new-asc" class="show-loader sortRule" country_id={$country_id} data-remote="true">New<span class='icon'>e</span></a>
        </li>
        <li>
            <a href="{$clsCountryEx->getLink($country_id)}&sortby=new-desc" sortby="new-desc" class="show-loader sortRule" country_id={$country_id}  data-remote="true">New<span class='icon icon2'>e</span></a>
        </li>
    </ul>
    {else}
    <ul class="sorting">
        <li class="title">Sort By</li>
        <li>
            <a href="{$clsTourCategory->getLink($cat_id)}&sortby=rating-asc" sortby="rating-asc" class="show-loader sortRule" cat_id={$cat_id} data-remote="true">Rating<span class='icon'>e</span></a>
        </li>
        <li>
            <a href="{$clsTourCategory->getLink($cat_id)}&sortby=rating-desc" sortby="rating-desc" class="show-loader sortRule" cat_id={$cat_id} data-remote="true">Rating<span class='icon icon2'>e</span></a>
        </li>
        <li>
            <a href="{$clsTourCategory->getLink($cat_id)}&sortby=offer-asc" sortby="offer-asc" class="show-loader sortRule" cat_id={$cat_id} data-remote="true">Offers<span class='icon'>e</span></a>
        </li>
        <li>
            <a href="{$clsTourCategory->getLink($cat_id)}&sortby=offer-desc" sortby="offer-desc" class="show-loader sortRule" cat_id={$cat_id} data-remote="true">Offers<span class='icon icon2'>e</span></a>
        </li>
        <li>
            <a href="{$clsTourCategory->getLink($cat_id)}&sortby=new-asc" sortby="new-asc" class="show-loader sortRule" cat_id={$cat_id} data-remote="true">New<span class='icon'>e</span></a>
        </li>
        <li>
            <a href="{$clsTourCategory->getLink($cat_id)}&sortby=new-desc" sortby="new-desc" class="show-loader sortRule" cat_id={$cat_id} data-remote="true">New<span class='icon icon2'>e</span></a>
        </li>
    </ul>
    {/if}
</div>
<script type="text/javascript">
	var cat_id='{$cat_id}';
</script>
{literal}
    <script type="text/javascript">
        $(document).ready(function(){
			$('.sortRule').live('click',function(e){	
				e.preventDefault();
            	$('#filters_form input:checkbox:checked').prop('checked', false);
				var $_this = $(this);	
					var adata = {'cat_id': $_this.attr('cat_id'),'city_id': $_this.attr('city_id'),'country_id': $_this.attr('country_id'),'sortby': $_this.attr('sortby')};	
						$('.loader').show();
						$.ajax({	
							type:'POST',	
							url: path_ajax_script + '/index.php?mod=ajax&act=sortTour',
							dataType:'html',	data:adata,	cache: true,	
							success:function(html){	
							$htm=html.split('$$$');
							if(html.indexOf('NOT_RESULT')>=0){	
							window.location.href='/';	

						}else{	
							$('#home-masonry-container').html($htm[0]);	
							$('.ajaxClk').removeClass('current');	
							$_this.addClass('current');	
							history.pushState(null, null, $_this.attr('href'));	
							$('.loader').hide();
								}	
							}	
						});	
					return false;	
			});	
			

        });
    </script>
{/literal}
