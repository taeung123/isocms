App.registerModule(function ({ container, actionRegistry }) {
    /* ================= SERVICE ================= */

    container.register(
        "countdownService",
        (function () {
            let interval = null;

            function update() {
                let $items = $(".border_timeleft");

                if (!$items.length) {
                    stop();
                    return;
                }

                let now = Date.now();
                let hasActive = false;

                $items.each(function () {
                    let openSaleDate =
                        parseInt($(this).attr("open_sale_date")) * 1000;
                    let closeSaleDate =
                        parseInt($(this).attr("close_sale_date")) * 1000;

                    let timeLeft = closeSaleDate - now;

                    if (timeLeft <= 0) {
                        $(this)
                            .find(".time_lefttxt")
                            .text("00 days left 00:00:00");

                        $(this).hide();
                        return;
                    }

                    hasActive = true;

                    let days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                    let hours = Math.floor(
                        (timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60),
                    );
                    let minutes = Math.floor(
                        (timeLeft % (1000 * 60 * 60)) / (1000 * 60),
                    );
                    let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                    $(this)
                        .find(".time_lefttxt")
                        .text(
                            `${days} days left ${String(hours).padStart(2, "0")}:${String(minutes).padStart(2, "0")}:${String(seconds).padStart(2, "0")}`,
                        );
                });

                // Nếu không còn item active → stop interval
                if (!hasActive) {
                    stop();
                }
            }

            function start() {
                if (interval) return; // tránh start 2 lần
                update(); // chạy ngay lần đầu
                interval = setInterval(update, 1000);
            }

            function stop() {
                if (!interval) return;
                clearInterval(interval);
                interval = null;
            }

            function restart() {
                stop();
                start();
            }

            return {
                start,
                stop,
                restart,
            };
        })(),
    );

    /* ================= ACTIONS ================= */

    actionRegistry.register("countdown.start", function () {
        container.get("countdownService").start();
    });

    actionRegistry.register("countdown.stop", function () {
        container.get("countdownService").stop();
    });

    actionRegistry.register("countdown.restart", function () {
        container.get("countdownService").restart();
    });

    /* ================= LIFECYCLE ================= */

    actionRegistry.register("app.ready", function () {
        actionRegistry.execute("countdown.start");
    });
});
