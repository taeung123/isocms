(function ($) {

	$.sharer = {
		"networks": {
			"facebook": {
				"name": "Facebook",
				"url": "https://www.facebook.com//share.php?u=%url%&title=%title%"
			},
			"twitter": {
				"name": "Twitter",
				"url": "https://twitter.com/intent/tweet?url=%url%&text=%title%+%description%"
			},
			"linkedin": {
				"name": "LinkedIn",
				"url": "https://www.linkedin.com//shareArticle?mini=true&url=%url%&title=%title%&summary=%description%&source=in1.com"
			},
			"tumblr": {
				"name": "Tumblr",
				"url": "https://www.tumblr.com//share/link?url=%url%&name=%title%&description=%description%"
			},
			"reddit": {
				"name": "Reddit",
				"url": "https://www.reddit.com/submit?url=%url%"
			},
			"pinterest": {
				"name": "Pinterest",
				"url": "https://www.pinterest.com/pin/create/button/?url=%url%&media=&description=%title%+%description%"
			},
			"kakao": {
				"name": "Kakao Story",
				"url": "https://story.kakao.com/s/share?url=%url%&text=%title%+%description%"
			}
		},
		"options": {
			"networks": ["facebook", "twitter", "linkedin", "reddit", "pinterest", "tumblr", "kakao"], 
			"template": $('<a class="sharer-icon"></a>'),
			"class": "sharer-icon-%network.id%",
			"label": "Share on %network.name%",
			"title": null,
			"description": null,
			"url": null
		}
	};
	$.fn.sharer = function (options) {
		var options = options || {},
			options = $.extend({}, $.sharer.options, options);

		return this.each(function () {
			var container = $(this);
			for (var i = 0; i < options["networks"].length; i++) {
				var network = options["networks"][i],
					networkData = $.sharer.networks[network],
					button = options["template"].clone();

				button.data("network", networkData).addClass(options["class"].replace("%network.id%", network)).attr("title",options["label"].replace("%network.name%", networkData["name"])).html('<i class="fa-brands fa-'+network+'" aria-hidden="true"></i>').click(function () {
					var networkData = $(this).data("network");
					var popup = networkData["url"].replace("%title%", encodeURIComponent(options["title"] || document.title)).replace("%description%", encodeURIComponent(options["description"] || $("meta[name=description]").attr("content"))).replace("%url%", encodeURIComponent(options["url"] || location.href));

					window.open(popup, "sharer", "toolbar=0,resizable=1,status=0,width=640,height=528");
				}).appendTo(container);
			}
		});
	};
	}(jQuery));