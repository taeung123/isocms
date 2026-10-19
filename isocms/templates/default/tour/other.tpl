<div id="breadcrumb">
    <div class="container">
        <a class="pa0" href="{$PCMS_URL}{$extLang}" title="{$core->get_Lang('home')}">
            <img src="{$URL_IMAGES}/background/home.png" alt="{$core->get_Lang('home')}" align="absmiddle" />
        </a>
        <a href="{$PCMS_URL}{$extLang}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
        <span class="s"></span>
        <div itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
            <a itemprop="url" href="javascript:void(0)" title="{$core->get_Lang('tours')}">{$core->get_Lang('tours')}</a>
        </div>
        <span class="s"></span>
        <div itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
            <a itemprop="url" href="{$curl}" title="{$core->get_Lang('schedules')} {$clsTour->getTitle($tour_id)}">{$core->get_Lang('schedules')} {$clsTour->getTitle($tour_id)}</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div id="page" class="container">
	<div class="boxMainDetail otherDate" style="background:#fff">
    	<h1 class="headPageMod">{$core->get_Lang('schedules')} {$clsTour->getTitle($tour_id)}</h1>
        <div class="month_top_box mt20" style="width:1090px">
            <div class="cleafix"></div>
            <div class="mt10">
                <a href="javascript:void(0);" class="prev"></a>
                <div class="jcarousel">
                    <ul id="monthtabs">
                        {section name=i loop=$listMonth}
                        <li><a class="mClick" href="javascript:void();" month="{$listMonth[i].month}" year="{$listMonth[i].year}">{$listMonth[i].month}/{$listMonth[i].year}</a></li>
                        {/section}
                    </ul>
                </div>
                <a href="javascript:void(0);" class="next"></a>
           </div>
            <div class="clearfix"></div>
            <div class="contentTable mt15">
                <table cellspacing="0" cellpadding="3" border="0" style="width:1090px;border-collapse:collapse;table-layout:auto">
                    <tr align="center" style="background-color:#E0DFDF;font-weight:bold;height:50px; font-size:13px">
                        <td>{$core->get_Lang('codetour')}</td>
                        <td>{$core->get_Lang('destination')}</td>
                        <td style="text-transform:capitalize">{$core->get_Lang('day')}</td>
                        <td>{$core->get_Lang('departuredate')}</td>
                        <td>{$core->get_Lang('enddate')}</td>
                        <td style="width:50px;">{$core->get_Lang('price')} ({$clsISO->getRateSign()})</td>
                        <td>{$core->get_Lang('hourin')}</td>
                        <td>{$core->get_Lang('hourout')}</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tbody id="ucIndex_TourOpenning"></tbody>
                </table>
                <div class="clearfix"></div>
                <div class="pagination" id="pagination"></div>
            </div>
        </div>
	</div>
</div>
<script type="text/javascript">
	var path_ajax_script = '{$PCMS_URL}';
	var $tour_type_id = '{$tour_type_id}';
	var $tour_id = '{$tour_id}';
</script>
{literal}
<style type="text/css">
.month_top_box .line label{ display:inline-block; float:left; white-space:nowrap; margin-right:10px; line-height:30px}
</style>
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function () {
		$().ready(function(){
			var $month = $('#monthtabs a.current').attr('month');
			var $year = $('#monthtabs a.current').attr('year');	
			loadTourOpenning($month,$year,$tour_id,1);
			hoz_slider();
			makeSelectboxDeparture();
			makeSelectboxDestination();
			makeSelectboxDuration();
			
			$('.mClick').click(function(){
				var $_this = $(this);
				var $month = $_this.attr('month');
				var $year = $_this.attr('year');
				var $tour_type_id = $('input[name=txtTypeTour]:checked').val();
				$('#monthtabs a.current').removeClass('current');
				$_this.addClass('current');
				loadTourOpenning($month,$year,$tour_id,$tour_type_id,1);
				return false;
			});
			$('.paginate_button').live('click',function(){
				var $_this = $(this);
				var $month = $('#monthtabs a.current').attr('month');
				var $year = $('#monthtabs a.current').attr('year');
				loadTourOpenning($month,$year,$tour_id,$tour_type_id,$_this.attr('page'));
				return false;
			});
			$('input[name=txtTypeTour]').change(function(){
				var $_this = $(this);
				var $month = $('#monthtabs a.current').attr('month');
				var $year = $('#monthtabs a.current').attr('year');	
				makeSelectboxDeparture();
				makeSelectboxDestination();
				makeSelectboxDuration();
				loadTourOpenning($month,$year,$tour_id,$_this.val(),1);
			});
			
			$('select[name=departure_id]').change(function(){
				var $_this = $(this);
				$('select[name=city_id]').html('<option value="">Loading...</option>');
				var $tour_type_id = $("input[name='txtTypeTour']:checked").val();
				var $month = $('#monthtabs a.current').attr('month');
				var $year = $('#monthtabs a.current').attr('year');	
				/**/
				var adata = {
					'departure_id': $_this.val(),
					'tour_type_id': $tour_type_id
				};
				$.ajax({
					type: 'POST',
					url: path_ajax_script+'/index.php?mod=ajax&act=ajaxMakeSelectboxCity',
					data :adata,
					dataType:'html',
					success: function(html){
						$('select[name=city_id]').html(html);
						makeSelectboxDestination();
						makeSelectboxDuration();
						loadTourOpenning($month,$year,$tour_id,$tour_type_id,1);
					} 
				});
			});
			
			$('select[name=destination_id]').change(function(){
				var $_this = $(this);
				$('select[name=duration]').html('<option value="">Loading...</option>');
				var $departure_id 	= $('select[name=departure_id]').val();
				var $tour_type_id 	= $("input[name='txtTypeTour']:checked").val();
				var $month 			= $('#monthtabs a.current').attr('month');
				var $year 			= $('#monthtabs a.current').attr('year');
				/**/
				makeSelectboxDuration();
				loadTourOpenning($month,$year,$tour_id,$tour_type_id,1);
			});
			
			$('select[name=duration]').live('change',function(){
				var $tour_type_id = $("input[name='txtTypeTour']:checked").val();
				var $month = $('#monthtabs a.current').attr('month');
				var $year = $('#monthtabs a.current').attr('year');	
				loadTourOpenning($month,$year,$tour_id,$tour_type_id,1);
			});
			
			$('.btnBookTourCalendar').live('click',function(){
				var $_this = $(this);
				var $tour_id = $_this.attr('tour_id');
				var $tour_start_date_id = $_this.attr('tour_start_date_id');
				/**/
				var adata = {
					'tour_id': $tour_id,
					'tour_start_date_id': $tour_start_date_id
				};
				$.ajax({
					type: 'POST',
					url: path_ajax_script+'/index.php?mod=ajax&act=ajaxSetTourBook',
					data :adata,
					dataType:'html',
					success: function(html){
						location.href = html;
					} 
				});
			});
		});
		function loadTourOpenning($month,$year,$tour_id,$tour_type_id,$page) {
			var $departure_id = $('select[name=departure_id]').val();
			var $destination_id = $('select[name=destination_id]').val();
			var $tour_type_id = $("input[name='txtTypeTour']:checked").val();
			var $duration = $('select[name=duration]').val();
			
			var adata = {
				'month' 			: $month,
				'year' 				: $year,
				'page' 				: $page,
				'departure_id' 		: $departure_id,
				'destination_id' 	: $destination_id,
				'duration' 			: $duration,
				'tour_type_id' 		: $tour_type_id,
				'tour_id' 			: $tour_id
			};
			$.ajax({
				type: 'POST',
				url: path_ajax_script+'/index.php?mod='+mod+'&act=ajaxGetTourOpenning',
				data :adata,
				dataType:'html',
				success: function(html){
					var $htm = html.split('$$');
					$('#ucIndex_TourOpenning').html($htm[0]);
					$('#pagination').html($htm[1]);
				} 
			});
		}
		function makeSelectboxDeparture(){
			var $tour_type_id = $("input[name='txtTypeTour']:checked").val();
			$.ajax({
				type: 'POST',
				url: path_ajax_script+'/index.php?mod=ajax&act=ajaxMakeSelectboxDeparture',
				data :{'tour_type_id' : $tour_type_id},
				dataType:'html',
				success: function(html){
					$('select[name=departure_id]').html(html);
				} 
			});
		}
		function makeSelectboxDestination(){
			$('select[name=destination_id]').html('<option value="">Loading...</option>');
			var $departure_id = $('select[name=departure_id]').val();
			var $destination_id = $('select[name=destination_id]').val();
			var $tour_type_id = $("input[name='txtTypeTour']:checked").val();
			if($tour_type_id == '1') {
				var adata = {
					'depart_point_id'	:	$departure_id,
					'city_id'			: 	$destination_id,
					'tour_type_id'		: 	$tour_type_id
				};
				$.ajax({
					type: 'POST',
					url: path_ajax_script+'/index.php?mod=ajax&act=ajaxMakeSelectboxCity',
					data :adata,
					dataType:'html',
					success: function(html){
						$('select[name=destination_id]').html(html);
					} 
				});
			} else {
				var adata = {
					'depart_point_id'	:	$departure_id,
					'country_id'		: 	$destination_id,
					'tour_type_id'		: 	$tour_type_id
				};
				$.ajax({
					type: 'POST',
					url: path_ajax_script+'/index.php?mod=ajax&act=ajaxMakeSelectboxCountry',
					data :adata,
					dataType:'html',
					success: function(html){
						$('select[name=destination_id]').html(html);
					} 
				});
			}
		}
		function makeSelectboxDuration(){
			$('select[name=duration]').html('<option value="">Loading...</option>');
			var $departure_id = $('select[name=departure_id]').val();
			var $destination_id = $('select[name=destination_id]').val();
			var $duration = $('select[name=duration]').val();
			var $tour_type_id = $("input[name='txtTypeTour']:checked").val();
			
			if($tour_type_id == '1') {
				var adata = {
					'depart_point_id'	: $departure_id,
					'city_id'			: $destination_id,
					'duration'    		: $duration,
					'tour_type_id'		: $tour_type_id
				};
			} else {
				var adata = {
					'depart_point_id'	: $departure_id,
					'country_id'		: $destination_id,
					'duration'    		: $duration,
					'tour_type_id'		: $tour_type_id
				};
			}
			$.ajax({
				type: 'POST',
				url: path_ajax_script+'/index.php?mod=ajax&act=ajMakeSelectboxDuration',
				data :adata,
				dataType:'html',
				success: function(html){
					$('select[name=duration]').html(html);
				} 
			});
		}
		function hoz_slider(){
			var $num = 12;
			var $w = $('#monthtabs li').width()+4;
			/**/
			$('.prev,.next').addClass('disabled');
			if($num > 10){
				$('.next').removeClass('disabled');
				var $iActive = 0;
				var $iScroll= 0;
				
				$('.next').live('click',function(){
					if($iActive < ($num - 10)){
						$('.prev').removeClass('disabled');
						$iActive ++;
						$iScroll = $iScroll + $w;
						$('#monthtabs').stop(false,true).animate({'left':-$iScroll},500);
					}else{
						if($iActive==($num-10)){
							$(this).addClass('disabled');
						}
					}
					return false;
				});
				$('.prev').live('click',function(){
					if($iActive > 0){
						$('.next').removeClass('disabled');
						$iActive --;
						$iScroll = $iScroll - $w;
						$('#monthtabs').stop(false,true).animate({'left':-$iScroll},500);
					}else{
						$(this).addClass('disabled');
					}
					return false;
				});
			}
		}
	})
</script>
{/literal}