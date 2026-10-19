jQuery(document).ready(function($){
        var $bsstoc = $(".bsstoc");
        var $content = $bsstoc.parent();
        var stopAt = $bsstoc.data("stopat");
        var sub_headers = [];
        switch(stopAt){
            case "h6":
                sub_headers.push("h6");
            case "h5":
                sub_headers.push("h5");
            case "h4":
                sub_headers.push("h4");
            case "h3":
                sub_headers.push("h3");
            case "h2":
                sub_headers.push("h2");
        }
        sub_headers = sub_headers.join();
        var $heads = $content.find(sub_headers);
        if($heads.length === 0){
            return;
        }
        var toc = "";
        toc += "<h2>Mục lục</h2><ul>";
        $heads.each(function(){
            var $this = $(this);
            var tag = $this[0].tagName;
            var txt = $this.text();
            var slug = convertToSlug(txt);
            $this.attr("data-linked",slug);
            toc += '<li class="bsstoc-level-'+tag+'">';
            toc += '<a href="#" data-linkto="'+slug+'">'+txt+"</a></li>";
        });
        toc += "</ul>";
        $bsstoc.append(toc);
        $(".bsstoc ul").on("click", "a", function(e){
            e.preventDefault();
            $([document.documentElement, document.body]).animate({
                scrollTop: $content.find('[data-linked="'+$(this)
                    .attr("data-linkto")+'"]').offset()
                    .top - parseInt($bsstoc.attr("data-offset"), 10)
            }, 2000);
        });
    function convertToSlug(text){
        return text.toString().toLowerCase()
			.replace(/\s+/g, "-")
			.replace(/[^\w\-àáãạảăắằẳẵặâấầẩẫậèéẹẻẽêềếểễệđìíĩỉịòóõọỏôốồổỗộơớờởỡợùúũụủưứừửữựỳỵỷỹýÀÁÃẠẢĂẮẰẲẴẶÂẤẦẨẪẬÈÉẸẺẼÊỀẾỂỄỆĐÌÍĨỈỊÒÓÕỌỎÔỐỒỔỖỘƠỚỜỞỠỢÙÚŨỤỦƯỨỪỬỮỰỲỴỶỸÝ]+/g, "")
			.replace(/\-\-+/g, "-")
			.replace(/^\d+/, "")
			.replace(/^-+/, "")
			.replace(/-+$/, "")
			.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a")
			.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e")
			.replace(/ì|í|ị|ỉ|ĩ/g, "i")
			.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o")
			.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u")
			.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y")
			.replace(/đ/g, "d")
			.replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, "")
			.replace(/\u02C6|\u0306|\u031B/g, "");
    }
});