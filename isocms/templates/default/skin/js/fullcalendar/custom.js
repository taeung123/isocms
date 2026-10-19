jQuery(function($){
	$('#calendar').fullCalendar('refetchEvents');
	var HotelCalendar = function(container){
		var self = this;
		this.container = container;
		this.calendar= true;
		this.form_container = true;
		
		this.init = function(){
			self.container = container;
			self.calendar = $('.calendar-content', self.container);
			self.form_container = $('.calendar-form', self.container);
			self.initCalendar();
		}
		this.initCalendar = function(){
			self.calendar.fullCalendar({
				firstDay: 1,
                lang:st_params.locale,
                timezone: st_timezone.timezone_string,
				customButtons: {
			        reloadButton: {
                        text: st_params.text_refresh,
			            click: function() {
			                self.calendar.fullCalendar('refetchEvents');
			            }
			        }
			    },
				header : {
				    left:   'today,reloadButton',
                    center: 'title',
                    right:  'prev, next'
				},
				selectable: true,
				select : function(start, end, jsEvent, view){
					var start_date = new Date(start._d).toString("MM");
					var end_date = new Date(end._d).toString("MM");
					var start_year = new Date(start._d).toString("yyyy");
					var end_year = new Date(end._d).toString("yyyy");
					var today = new Date().toString("MM");
					var today_year = new Date().toString("yyyy");
					if((start_date < today && start_year <= today_year) || (end_date < today && end_year <= today_year)){
						self.calendar.fullCalendar('unselect');
						setCheckInOut('', '', self.form_container);
					}else{
						var zone = moment(start._d).format('Z');
							zone = zone.split(':');
							zone = "" + parseInt(zone[0]) + ":00";
						var check_in = moment(start._d).utcOffset(zone).format("MM/DD/YYYY");
						var	check_out = moment(end._d).utcOffset(zone).subtract(1, 'day').format("MM/DD/YYYY");
						setCheckInOut(check_in, check_out, self.form_container);
					}
				},
				events:function(start, end, timezone, callback) {
                    $.ajax({
                        url: path_ajax_script+'/index.php?mod=tour&act=OpenAvailbility',
                        type:'POST',
						dataType: 'html',
                        data: {
                            tp:'L',
							type:'_ROOM',
                            tour_id:self.container.data('tour_id'),
                            start: start.unix(),
                            end: end.unix()
                        },
						success: function(html){
							var doc = jQuery.parseJSON(html);
                        	if(typeof doc == 'object'){
                            	callback(doc);
                        	}
                        }
                    });
                },
				eventClick: function(event, element, view){
                    setCheckInOut(event.start.format('MM/DD/YYYY'),event.start.format('MM/DD/YYYY'),self.form_container);
                    $('#calendar_price', self.form_container).val(event.price);
                    $('#calendar_number', self.form_container).val(event.number);
                    $('#calendar_status', self.form_container).val(event.status);
				},
				eventRender: function(event, element, view){
					var html = '';
					html += '<div class="price '+event.class+'"><p>Prices from: <span class="priceOption">'+event.price+'</span></p><a href="'+event.linkBooking+'&date='+event.dateBooking+'">Select this date</a></div>';
					var html2 = '';
					html2 += '<span class="number">'+event.class+'</span>';
					$('.fc-widget-content', element).html(html);
					$('.fc-content', element).html(html);
				},
                loading: function(isLoading, view){
                    if(isLoading){

                    }else{
                   
                    }
                }
			});
		}
	};
	
	function setCheckInOut(check_in, check_out, form_container){
		$('#calendar_check_in', form_container).val(check_in);
		$('#calendar_check_out', form_container).val(check_out);
	}
	function resetForm(form_container){
		$('#calendar_check_in', form_container).val('');
		$('#calendar_check_out', form_container).val('');
		$('#calendar_price', form_container).val('');
		$('#calendar_priority', form_container).val('');
		$('#calendar_number', form_container).val('');
		$('#calendar_allotement', form_container).val(0);
		$('#calendar_request_price', form_container).prop('checked',false);
	}
	$(function() {
		$('.calendar-wrapper').each(function(index, el) {
			var t = $(this);
			var hotel = new HotelCalendar(t);
			hotel.init();
			/**/
			var flag_submit = false;
			$('#calendar_submit', t).click(function(event) {
				var $_adata = $('input, select', '.calendar-form').serializeArray();
		
				 $.ajax({
					url: path_ajax_script+'/index.php?mod=tour&act=OpenAvailbility',
					type:'POST',
					dataType: 'html',
					data: $_adata,
					success: function(html){
				
						if(html.indexOf('_invalid_date_empty') >= 0){
							alertify.error('Check in or check out field is not empty.');
							return false;
						}
						else if(html.indexOf('_invalid_date_less') >= 0){
							alertify.error('The check out is later than the check in field.');
							return false;
						}
						else if(html.indexOf('_invalid_price') >= 0){
							alertify.error('The price field is not a number.');
							return false;
						}
						else{
							resetForm(t);
							$('.calendar-content', t).fullCalendar('refetchEvents');
						}
					}
				});
				return false;
			});
		});
	});
});
