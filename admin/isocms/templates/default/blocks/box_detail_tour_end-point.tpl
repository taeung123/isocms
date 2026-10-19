<div class="box_title_end_point">
    <div class="row d-flex full-height">
        <div class="col-md-9">
            <div class="fill_data_box">
                <h3 class="title_box mb05 mb-5">{$core->get_Lang('End Point')}</h3>
                <div class="form_option_point">
                    <div class="form-group inpt_tour">
                        <label class="col-form-label" for="title">
                            {$core->get_Lang('Address')}
                        </label>
                        <div>
                            <input type="text" class="form-control mb-3" id="location" placeholder="{$core->get_Lang('Enter the address')}" oninput="debounceLoadLocations(this.value)" name="end_point" value="{$clsTour->getEndPoint($tour_id)}">
                            <div id="location-suggestions" class="suggestions"></div>
                        </div>
                        <div class="text_help" hidden=""></div>
                    </div>
                    <div class="btn_save_titile_trip_code">
                        <a tour_id="{$pvalTable}" cat_run="{$cat_run}" prev_step="{if $child_cat_menu_j_index_prev eq ''}{if $list_cat_menu_prev eq ''}{$child_cat_menu_j}{/if}{if $list_cat_menu_prev ne ''}{$list_cat_menu_prev}/{$child_cat_menu_prev[$count_child_cat_menu_j_index_prev]}{/if}{else}{$child_cat_menu_j_index_prev}{/if}" class="back_step">{$core->get_Lang('Back')}</a>
                        <a id="btn-save-img-file" tour_id="{$pvalTable}" cat_run="{$cat_run}" status="" present_step="{$child_cat_menu_j}" next_step="{if empty($child_cat_menu_j_index_next)}{if empty($list_menu_tour_i_index_next.cat_menu)}SaveAll{/if}{if !empty($list_menu_tour_i_index_next.cat_menu)}{$list_cat_menu_next}/{$child_cat_menu_next[0]}{/if}{else}{$child_cat_menu_j_index_next}{/if}" class="save_and_continue_tour">{$core->get_Lang('Save &amp; Continue')}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{literal}
    <style>
        .suggestions {
            border: 1px solid #ccc;
            max-height: 150px;
            overflow-y: auto;
            position: absolute;
            background: white;
            z-index: 1000;
        }

        .suggestions div {
            padding: 10px;
            cursor: pointer;
            width: 100%;
        }

        .suggestions div:hover {
            background-color: #f0f0f0;
        }
    </style>

    <script>
        var locationInput = document.getElementById("location");
        var locationSuggestions = document.getElementById("location-suggestions");
        const apiKey = "676e5e9d073d9495157046jus806c27"; // Thay thế bằng access token của bạn
        let debounceTimer;

        function debounceLoadLocations(query) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => loadLocations(query), 300); // 300ms delay
        }

        function loadLocations(query) {
            locationSuggestions.innerHTML = "";
            if (query.length < 1) return;

            // Gọi API geocode.maps.co
            fetch(`https://geocode.maps.co/search?q=${encodeURIComponent(query)}&api_key=${apiKey}`)
                .then((response) => {
                    if (!response.ok) {
                        console.error("Error fetching data:", response.statusText);
                        return;
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data && Array.isArray(data) && data.length > 0) {
                        data.forEach(location => {
                            const suggestionItem = document.createElement("div");
                            suggestionItem.textContent = location.display_name; // Hoặc location.address nếu cần
                            suggestionItem.onclick = () => selectLocation(location);
                            locationSuggestions.appendChild(suggestionItem);
                        });
                    } else {
                        console.error("Không tìm thấy địa điểm:", data);
                    }
                })
                .catch((error) => console.error("Error fetching data from geocode.maps.co:", error));
        }

        function selectLocation(location) {
            locationInput.value = location.display_name; // Hiển thị địa chỉ đã chọn
            locationSuggestions.innerHTML = ""; // Xóa gợi ý
        }
    </script>
{/literal}
