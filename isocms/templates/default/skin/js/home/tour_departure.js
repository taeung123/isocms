App.registerModule(function ({ container, actionRegistry }) {
    /* ================= SERVICE ================= */

    container.register(
        "calendarService",
        (function () {
            let instance = null;

            function parseAllowedDates() {
                if (!window.allowedDates) return [];
                try {
                    return JSON.parse(window.allowedDates);
                } catch (e) {
                    console.warn("allowedDates JSON invalid");
                    return [];
                }
            }

            function buildHtml(res) {
                let html = "";

                $.each(res, function (index, item) {
                    html += `
                    <a href="${item.tour_link}" class="iso_departure_item">
                        <div class="box_left d-flex flex-column align-items-center justify-content-center">
                            <span class="box_left-day">${item.dayDeparture}</span>
                            <span class="box_left-month">${item.monthDeparture}</span>
                        </div>
                        <div class="box_right iso_departure_body_right">
                            <div class="d-flex flex-column">
                                <div class="box_right_title">
                                    ${item.tour_title}
                                </div>
                                <div class="box_right_body d-flex">
                                    <div class="box_right_body_item">
                                        <span>${item.txt_address}</span>
                                    </div>
                                    <div class="box_right_body_item">
                                        <span>${item.txt_allotment}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                `;
                });

                $(".iso_departure_body").html(html);
            }

            function loadDeparture(dateStr) {
                return $.ajax({
                    type: "POST",
                    url:
                        window.path_ajax_script +
                        "/index.php?mod=" +
                        window.mod +
                        "&act=ajaxLoadDepartureSchedule",
                    data: { dateStr },
                    dataType: "JSON",
                });
            }

            function init() {
                if (!$("#calendar").length) return;
                if (instance) return; // tránh init 2 lần

                instance = flatpickr("#calendar", {
                    inline: true,
                    dateFormat: "d/m/Y",
                    enable: parseAllowedDates(),
                    locale: {
                        firstDayOfWeek: 1,
                        weekdays: window.iso_calendar_weekdays,
                        months: window.iso_calendar_months,
                    },
                    onDayCreate: function (dObj, dStr, fp, dayElem) {
                        const isoDay = document.createElement("span");
                        isoDay.textContent = dayElem.textContent;
                        isoDay.className = "iso_day";
                        dayElem.textContent = "";
                        dayElem.appendChild(isoDay);
                    },
                    onChange: function (selectedDates, dateStr) {
                        loadDeparture(dateStr).done(function (res) {
                            buildHtml(res);
                        });
                    },
                });
            }

            function destroy() {
                if (!instance) return;
                instance.destroy();
                instance = null;
            }

            function restart() {
                destroy();
                init();
            }

            return {
                init,
                destroy,
                restart,
            };
        })(),
    );

    /* ================= ACTIONS ================= */

    actionRegistry.register("calendar.init", function () {
        container.get("calendarService").init();
    });

    actionRegistry.register("calendar.restart", function () {
        container.get("calendarService").restart();
    });

    /* ================= LIFECYCLE ================= */

    actionRegistry.register("app.ready", function () {
        actionRegistry.execute("calendar.init");
    });
});
