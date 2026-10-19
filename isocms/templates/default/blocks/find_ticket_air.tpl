<div class="container">
	{literal}
	<script type="text/javascript">        
		var IBEBasePath = ("https:" == document.location.protocol ? "https://" : "http://") + "ibev3.maybay.net";
		var IBEConfigs = {
			languageCode: "vi-VN",
			colorScheme: "default",
			productKey: "y62e9p4h0qvnaoi",
			searchForm: {
				showHeader: true
			}
		};
		(function () {
			var ibe = document.createElement("script");
			ibe.type = "text/javascript"; ibe.async = true;
			ibe.src = IBEBasePath + "/embed.js";
			var s = document.getElementsByTagName("script")[0];
			s.parentNode.insertBefore(ibe, s);
		})();
	</script>
	{/literal}
	{if $act eq 'default'}
	<div class="IBESearchForm"></div>
	{elseif $act eq 'result'}
	<div class="IBESearchResult"></div>
	{else}
	<div class="IBELowestFareResult"></div>
	{/if}
</div>