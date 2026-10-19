$(function () {
    let reviews_table_id = 0; //Id cua tour/cruise/hotel/voucher

    let reviews_type = ""; //Phan biet tur/cruise/hotel/voucher

    if (mod == "tour_new") {
        reviews_table_id = $tour_id;

        reviews_type = "tour";
    } else if (mod == "hotel") {
    }

    let dataLoadReviews = {
        table_id: reviews_table_id,

        type: reviews_type,
    };

    //Load review khi vua truy cap vao trang

    isoLoadReviews(dataLoadReviews);
    const class_list_reviews = $(".hnv_tour_detail_main_review_content_list");
    class_list_reviews.attr("data-page", 1);
    //function lay 2 ky tu dau tien

    function renderShortname(name) {
        let cleanedText = name.replace(/\s+/g, "");
        // Lấy 2 ký tự đầu tiên
        let result = cleanedText.substring(0, 2);
        return result;
    }

    //Function load du lieu thong so reviews

    function isoStatisticalReviews() {
        let data = {
            table_id: reviews_table_id,
            type: reviews_type,
        };

        $.ajax({
            type: "POST",
            dataType: "JSON",
            data: data,
            url:
                path_ajax_script +
                "/index.php?mod=home&act=ajStatisticalReviews&lang=" +
                LANG_ID,
            success: function (json) {
                let rates = json.rates;

                $.each(rates, function (key, item) {
                    let text = `width: ${item}%`;

                    $(`.iso_filter_reviews_${key}`)
                        .find(".progress-bar")

                        .attr("style", text);
                });

                let count_rates = json.count;

                $.each(count_rates, function (key, item) {
                    $(`.iso_filter_reviews_${key}`)
                        .find(
                            ".hnv_tour_detail_main_review_content_filter_right_count"
                        )
                        .text(item);
                });
            },
        });
    }

    isoStatisticalReviews();

    //Function load reviews

    function isoLoadReviews(dataPost, loadMore = "") {
        $.ajax({
            type: "POST",
            dataType: "JSON",
            data: dataPost,
            url:
                path_ajax_script +
                "/index.php?mod=home&act=ajLoadReviews&lang=" +
                LANG_ID,
            success: function (json) {
                if (json.result) {
                    let lstReviews = json.lstReviews;

                    let html = "";
                    $.each(lstReviews, function (index, item) {
                        html += `
                            <div class="hnv_tour_detail_main_review_content_item">
                                <div class="hnv_tour_detail_main_review_content_item_info">
                                    <div class="hnv_tour_detail_main_review_content_item_info_avatar" style="background:#${
                                        item.review_avatar_background
                                    };">
                                        ${renderShortname(item.fullname)}
                                    </div>
                                    <div class="hnv_tour_detail_main_review_content_item_info_name">
                                        <span>${item.fullname}</span>
                                        <p>${item.title_country}</p>
                                    </div>
                                </div>
                                <div class="hnv_tour_detail_main_review_content_item_star">
                                    <div class="hnv_tour_detail_main_review_content_item_star_list">`;
                        html += `<span class="hnv_rating_star_list">`;
                        for (let i = 0; i < 5; i++) {
                            html += `<i class="fa-thin fa-star" aria-hidden="true"></i>`;
                        }
                        html += `</span>`;
                        html += `<span class="hnv_rating_star_list hnv_rating_star_list_absolute">`;
                        for (let i = 0; i < item.rates; i++) {
                            html += `<i class="fa-solid fa-star" aria-hidden="true"></i>`;
                        }
                        html += `</span>`;
                        let decodedContent = $("<textarea/>")
                            .html(item.content)
                            .text();
                        html += `</div>
                                    <div class="hnv_tour_detail_main_review_content_item_star_date">
                                        ${item.review_date}
                                    </div>
                                </div>
                                <div class="hnv_tour_detail_main_review_content_item_text">
                                    ${decodedContent}
                                </div>
                                <div class="hnv_tour_detail_main_review_content_item_image">`;

                        let lstImages = item.lstImages;

                        if (lstImages && lstImages.length > 0) {
                            $.each(lstImages, function (k, image) {
                                html += `
                                    <div class="hnv_tour_detail_main_review_content_item_image_item" data-fancybox="gallery_review_img_${item.reviews_id}" href="${image.image}">
                                        <img src="${image.image}" width="100" height="100" alt="Image">
                                    </div>
                                `;
                            });
                        }

                        html += `</div>
                            </div>
                        `;
                    });
                    if (loadMore == "") {
                        class_list_reviews.html(html);
                    } else {
                        class_list_reviews.append(html);
                    }
                    $(".btn_more_reviews").remove();
                    if (json.view_more) {
                        let page = class_list_reviews.attr("data-page");

                        page = parseInt(page) + 1;

                        class_list_reviews.attr("data-page", page);

                        class_list_reviews.append(
                            `<button class="btn_more_reviews">View more</button>`
                        );
                    }
                }
            },
        });
    }

    //Su kien view more reviews

    $(document)
        .on("click", ".btn_more_reviews", function () {
            let page = class_list_reviews.attr("data-page");

            let dataLoadReviews = {
                table_id: reviews_table_id,
                type: reviews_type,
                page: page,
            };

            isoLoadReviews(dataLoadReviews, "show");
        })

        .on("click", ".iso_filter_reviews", function () {
            class_list_reviews.attr("data-page", 1);

            let txt_rates = "";

            $(".iso_filter_reviews").each(function () {
                if ($(this).prop("checked")) {
                    txt_rates += "," + $(this).val();
                }
            });

            let dataLoadReviews = {
                table_id: reviews_table_id,
                type: reviews_type,
                txt_rates: txt_rates,
            };

            isoLoadReviews(dataLoadReviews);
        });
});
