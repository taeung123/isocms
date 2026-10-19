$(document).ready(function(){
	var sync1 = $("#sync-lg");
	var sync2 = $("#sync-xs");
	sync1.owlCarousel({
		singleItem : true,
		slideSpeed : 1000,
		navigation: true,
		pagination:false,
		afterAction : syncPosition,
		responsiveRefreshRate : 200,
		navigationText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>']
	});
	sync2.owlCarousel({
		items : 9,
		itemsDesktop      : [1199,9],
		itemsDesktopSmall     : [979,7],
		itemsTablet       : [768,6],
		itemsMobile       : [479,4],
		navigation: true,
		pagination:false,
		responsiveRefreshRate : 100,
		navigationText: ['<i class="fa fa-caret-left"></i>','<i class="fa fa-caret-right"></i>'],
		afterInit : function(el){
			el.find(".owl-item").eq(0).addClass("synced");
		}
	});
	function syncPosition(el){
		var current = this.currentItem;
		$("#sync-xs")
				.find(".owl-item")
				.removeClass("synced")
				.eq(current)
				.addClass("synced")
		if($("#sync-xs").data("owlCarousel") !== undefined){
			center(current)
		}
	}
	$("#sync-xs").on("click", ".owl-item", function(e){
		e.preventDefault();
		var number = $(this).data("owlItem");
		sync1.trigger("owl.goTo",number);
	});
	function center(number){
		var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
		var num = number;
		var found = false;
		for(var i in sync2visible){
			if(num === sync2visible[i]){
				var found = true;
			}
		}
		if(found===false){
			if(num>sync2visible[sync2visible.length-1]){
				sync2.trigger("owl.goTo", num - sync2visible.length+2)
			}else{
				if(num - 1 === -1){
					num = 0;
				}
				sync2.trigger("owl.goTo", num);
			}
		} else if(num === sync2visible[sync2visible.length-1]){
			sync2.trigger("owl.goTo", sync2visible[1])
		} else if(num === sync2visible[0]){
			sync2.trigger("owl.goTo", num-1)
		}
	}
	
	var sync1m = $("#sync-modal-lg");
    var sync2m = $("#sync-modal-xs");
    sync1m.owlCarousel({
        singleItem : true,
        slideSpeed : 1000,
        navigation: true,
        pagination:false,
        afterAction : syncPosition,
        responsiveRefreshRate : 200,
        navigationText: ['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>']
    });
    sync2m.owlCarousel({
        items : 6,
        itemsDesktop      : [1199,6],
        itemsDesktopSmall     : [979,5],
        itemsTablet       : [768,4],
        itemsMobile       : [479,3],
        pagination:false,
        responsiveRefreshRate : 100,
        afterInit : function(el){
            el.find(".owl-item").eq(0).addClass("synced");
        }
    });
    function syncPosition(el){
        var current = this.currentItem;
        $("#sync-modal-xs")
                .find(".owl-item")
                .removeClass("synced")
                .eq(current)
                .addClass("synced")
        if($("#sync-modal-xs").data("owlCarousel") !== undefined){
            center(current)
        }
    }
    $("#sync-modal-xs").on("click", ".owl-item", function(e){
        e.preventDefault();
        var number = $(this).data("owlItem");
        sync1m.trigger("owl.goTo",number);
    });
    function center(number){
        var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
        var num = number;
        var found = false;
        for(var i in sync2visible){
            if(num === sync2visible[i]){
                var found = true;
            }
        }
        if(found===false){
            if(num>sync2visible[sync2visible.length-1]){
                sync2.trigger("owl.goTo", num - sync2visible.length+2)
            }else{
                if(num - 1 === -1){
                    num = 0;
                }
                sync2.trigger("owl.goTo", num);
            }
        } else if(num === sync2visible[sync2visible.length-1]){
            sync2.trigger("owl.goTo", sync2visible[1])
        } else if(num === sync2visible[0]){
            sync2.trigger("owl.goTo", num-1)
        }
    }

});