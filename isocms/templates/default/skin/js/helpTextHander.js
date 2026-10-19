function animateHeadline($headlines) {
    $headlines.each(function() {
        var headline = $(this);
        setTimeout(function() {
            hideWord(headline.find(".is-visible"))
        }, animationDelay)
    })
}

function hideWord($word) {
    var nextWord = takeNext($word);
    switchWord($word, nextWord), setTimeout(function() {
        hideWord(nextWord)
    }, animationDelay)
}

function takeNext($word) {
    return $word.is(":last-child") ? $word.parent().children().eq(0) : $word.next()
}

function switchWord($oldWord, $newWord) {
    $oldWord.removeClass("is-visible").addClass("is-hidden"), $newWord.removeClass("is-hidden").addClass("is-visible")
}

function handleOTAPriceOptIn(datum) {
    var apiName = datum.apiName || "",
        priceSupportingOTAs = $("#rezdy-price-ota").data("price-supporting-otas").split(","),
        otaSupportsPrice = -1 !== priceSupportingOTAs.indexOf(apiName);
    if ($("#rezdy-price-ota").toggle(otaSupportsPrice), otaSupportsPrice) {
        $("#rezdy-price-ota").data(apiName.toLowerCase() + "-price") && $("#rezdy-price-ota-checkbox").attr("checked", !0), $("#rezdy-price-ota-label").text("Allow " + datum.companyName + " to use your prices in Rezdy")
    }
}

function isFullPaymentNonOTA(datum) {
    return -1 !== $("#AgentSupplier_agentPayment").data("full-payment-agent-aliases").split(",").indexOf(datum.alias)
}

function initAvailabilityJs() {
    loading = 0, startTime = 0, window.lastSessionFromPreviousWeek = [], window.loadingEndSessions = !1, window.shifted = !1, window.endAvailability = {}, window.endingSessions = [], window.allSessions = [], window.durationSettings.language = $.parseJSON(window.durationSettings.language), window.durationSettings && window.durationSettings.isDuration ? (window.durationSettings.selecting = "start", $(".prompt-session-start").removeClass("hidden"), $("#OrderItem_quantity").trigger("change")) : window.durationSettings.selecting = "end"
}

function setLoading() {
    loading++, $(".loading-container .loading-splash").removeClass("hidden"), $(".loading-overlay-div").removeClass("hidden")
}

function clearLoading() {
    --loading <= 0 && (loading = 0, $(".loading-container .loading-splash").addClass("hidden"), $(".loading-overlay-div").addClass("hidden"))
}

function isLoading() {
    return loading > 0
}

function getCellIndex(cellElement) {
    return {
        "column": cellElement.parent().children().index(cellElement),
        "row": cellElement.parent().parent().children().index(cellElement.parent())
    }
}

function parseToDate(string) {
    return void 0 != $.datepicker ? $.datepicker.parseDate(window.dateFormat, string) : void 0 != $.fn.datetimepicker ? (dpg = $.fn.datetimepicker.DPGlobal, dpg.parseDate(string, dpg.parseFormat(window.dateFormat, "standard"), "en", "standard")) : void 0
}

function parseToTime(string) {
    return void 0 != $.datepicker ? $.datepicker.parseTime(window.timeFormat, string, {
        "amNames": window.amNames,
        "pmNames": window.pmNames,
        "ampm": window.ampm
    }) : void 0 != $.fn.datetimepicker ? (dpg = $.fn.datetimepicker.DPGlobal, parsedTime = dpg.parseDate(string, dpg.parseFormat(window.timeFormat, "standard"), "en", "standard"), {
        "hour": parsedTime.getHours(),
        "minute": parsedTime.getMinutes()
    }) : ""
}

function combineDateTimeObject(dateObject, timeObject) {
    return timeObject || (timeObject = !1), new Date(dateObject.getFullYear(), dateObject.getMonth(), dateObject.getDate(), timeObject ? timeObject.hour : 0, timeObject ? timeObject.minute : 0, 0)
}

function collapseRows() {
    "DAYS" != durationSettings.durationUnit && (startSessionTime = startTime, startSessionTime = parseToTime($.trim(startSessionTime)), startSessionDateTime = combineDateTimeObject(new Date, startSessionTime), hideRow = function(row) {
        $(row).addClass("hidden")
    }, $(".session-picker .session-row").each(function() {
        switch (thisRowTime = $(this).find("th .session-start-time").text(), thisRowTime = parseToTime($.trim(thisRowTime)), thisRowDateTime = combineDateTimeObject(new Date, thisRowTime), durationSettings.durationUnit) {
            case "HOURS":
                startSessionDateTime.getMinutes() != thisRowDateTime.getMinutes() && hideRow(this);
                break;
            case "MINUTES":
                sessionDifference = startSessionDateTime.getTime() - thisRowDateTime.getTime(), sessionDifference < 0 && (sessionDifference *= -1), sessionDifference = sessionDifference / 1e3 / 60, sessionDifference % 15 != 0 && hideRow(this)
        }
    }))
}

function addMissingAvailabilityRows() {
    return
}

function loadCalculateEndingSessionsAjax(sessionId) {
    var quantity = parseInt($("#OrderItem_quantity").val(), 10);
    isNaN(quantity) && (quantity = 1), !1 !== window.loadingEndSessions && window.loadingEndSessions.abort(), window.loadingEndSessions = $.ajax({
        "url": durationSettings.availabilityEndSessionsQuoteUrl + "/" + durationSettings.productId,
        "type": "POST",
        "data": {
            "sessionId": sessionId,
            "quantity": quantity
        },
        "beforeSend": function() {
            setLoading()
        },
        "complete": function() {
            clearLoading(), window.loadingEndSessions = !1
        }
    }).done(function(response) {
        if (response.success) {
            window.endAvailability = response.endAvailability, window.endingSessions = response.endingSessions, window.allSessions = response.allSessions, updateViewEndingSessions();
            var mpQuantity = $(".mp-quantity");
            if (mpQuantity && mpQuantity.length) {
                var form = $("form"),
                    firstAmount = $(".first-amount").val(),
                    data = Object.assign({
                        "duration": !0,
                        "amount": firstAmount ? Number(firstAmount) : 0
                    }, buildPriceOptionsObjectFromForm(form.serializeArray()));
                window.postMessage({
                    "type": "MP_UPDATE_QUANTITIES",
                    "data": data
                }, "*")
            }
        } else try {
            console.error("Failed response from Server")
        } catch (e) {}
    })
}

function buildSessionPickerFromAjax(html, direction) {
    if ("DAYS" == durationSettings.durationUnit && "ONE" == durationSettings.nextDayType && "next" == direction && (lastDaySelector = ".session-day:visible:last", lastDateSelector = ".session-date:visible:last", lastCell = $(lastDaySelector).find(".session-select-link"), lastCellId = !!lastCell.attr("data-original-sessionid") && lastCell.attr("data-original-sessionid"), lastCellDate = $(lastDateSelector).attr("data-date"), lastCellId && lastCellDate && (void 0 != $.datepicker ? parsedDate = $.datepicker.parseDate("yy-mm-dd", lastCellDate) : void 0 != $.fn.datetimepicker && (dpg = $.fn.datetimepicker.DPGlobal, parsedDate = dpg.parseDate(lastCellDate, dpg.parseFormat("yy-mm-dd", "standard"), "en", "standard")), window.lastSessionFromPreviousWeek[parsedDate] = lastCellId)), newSessionTable = $(html).find("table.session-picker"), newSessionTable) return $("table.session-picker").replaceWith(newSessionTable), void(window.durationSettings.isDuration && updateViewEndingSessions())
}

function resetWarnings() {
    $("#alert-container").empty()
}

function updateViewEndingSessions() {
    if ("start" == durationSettings.selecting) return void $(".prompt-session-start").removeClass("hidden");
    var endAvailability = window.endAvailability,
        endingSessions = window.endingSessions,
        allSessions = window.allSessions,
        sessionDetails = window.sessionDetails = {};
    if (0 === endingSessions.length) {
        $(".reset-selection a").click();
        var alertContainer = $("#alert-container"),
            alertBox = $("#alert-template .alert").clone();
        return alertBox.find("ul.errors").append($("<li>").text(durationSettings.language.NoAvailability)), durationSettings.durationMinimum && alertBox.find("ul").append($("<li>").text(durationSettings.language.MinDuration)), alertBox.appendTo(alertContainer), void $("html, body").animate({
            "scrollTop": $(".form-availability").offset().top
        }, 300)
    }
    $(".session-picker .prompt-session-start").addClass("hidden"), $(".session-picker .session-seats-available").addClass("hidden"), $(".session-picker .session-detail").addClass("hidden"), $(".session-picker .session-fade").removeClass("session-fade"), $(".session-picker .availableSession").removeClass("availableSession"), $(".session-picker .session-to-book").removeClass("session-to-book"), $(".session-picker .session-row").removeClass("hidden"), $(".session-picker tr.no-availability").remove(), $(".session-picker .session-detail .durationLabel").each(function(key, element) {
        $(element).attr("data-duration-value", !1).text("")
    });
    var shifted = window.shifted;
    "DAYS" !== durationSettings.durationUnit || "ONE" != durationSettings.nextDayType || shifted ? "end" === durationSettings.selecting && shifted && shiftSessionIds() : (shiftSessionIds(), window.shifted = !0);
    var index = 0;
    $.each(endAvailability, function(date, times) {
        $.each(times, function(time, sessionDetail) {
            var dataSessionAttr = "data-sessionid",
                sessionId = sessionDetail.id,
                cell = $(".session-picker td a.session-select-link[" + dataSessionAttr + "=" + sessionId + "]").closest("td"),
                durationText = sessionDetail.quote.durationValue,
                durationAmount = sessionDetail.quote.amount,
                onlyAmount = sessionDetail.quote.onlyAmount;
            parseInt(durationText, 10) > 1 ? durationText += " " + durationSettings.durationUnitPlural : durationText += " " + durationSettings.durationUnitSingle, sessionDetails[sessionId] = sessionDetail, cell.addClass("availableSession"), cell.find(".session-detail").removeClass("hidden").attr("data-session-date", date).attr("data-session-time", time), cell.find(".book-now").removeClass("hidden"), cell.find(".duration").text(durationText), cell.find(".amount").text(durationAmount).attr("data-original-amount", durationAmount).attr("data-amount", onlyAmount), 0 === index && $(".first-amount").val(onlyAmount), "LIST" == durationSettings.durationType && cell.find(".durationLabel").attr("data-duration-value", sessionDetail.durationValue).text(sessionDetail.durationLabel), index++
        }), document.dispatchEvent(new CustomEvent("rezdy-update-prices", {}))
    }), $(".session-picker .session-cell a[data-sessionid]").each(function() {
        var sessionId = $(this).attr("data-sessionid"); - 1 === $.inArray(sessionId, endingSessions) && -1 !== $.inArray(sessionId, allSessions) ? $(this).closest("td").addClass("availableSession").addClass("session-fade") : -1 === $.inArray($(this).attr("data-sessionid"), allSessions) && ($(this).closest("td").addClass("session-fade"), $(this).find(".prompt-session-start, .prompt-session-end").addClass("hidden"))
    }), 0 === $(".session-picker td.session-cell.starting-session a :visible").length && $(".session-picker td.session-cell.starting-session .prompt-session-starting").removeClass("hidden"), collapseRows()
}

function getSessionData(selectedElement) {
    return {
        "id": selectedElement.attr("data-sessionid"),
        "startTime": selectedElement.attr("data-session-start-time"),
        "endTime": selectedElement.attr("data-session-end-time"),
        "allDay": !!selectedElement.attr("data-session-all-day")
    }
}

function mpUpdateSession(productId, startingSessionData, endSessionData, amount, priceOptions) {
    var data = {
        "productId": Number(productId),
        "session": startingSessionData,
        "endSession": endSessionData,
        "amount": amount,
        "priceOptions": priceOptions
    };
    window.postMessage({
        "type": "MP_UPDATE_SESSION",
        "data": data
    }, "*")
}

function fadeOutOfQty() {
    var quantity = parseInt($("#OrderItem_quantity").val(), 10);
    $(".session-picker .session-day").each(function(index, cell) {
        cellQty = $(cell).find(".session-seats-available .seatsValue").text(), parseInt(cellQty, 10) < quantity ? ($(cell).addClass("session-fade"), $(cell).find(".session-seats-available .prompt-session-start").addClass("hidden"), $(cell).find(".session-seats-available").addClass("hidden"), $(cell).find(".session-not-enough").removeClass("hidden")) : ($(cell).removeClass("session-fade"), $(cell).find(".session-seats-available .prompt-session-start").removeClass("hidden"), $(cell).find(".session-seats-available").removeClass("hidden"), $(cell).find(".session-not-enough").addClass("hidden"))
    })
}

function qtyChange() {
    var quantity = parseInt($("#OrderItem_quantity").val(), 10),
        mpQuantity = $(".mp-quantity"),
        isNonInventory = $("#OrderItem_quantity").hasClass("non-inventory");
    if (mpQuantity && mpQuantity.length && isNonInventory) {
        var form = $("form"),
            data = buildPriceOptionsObjectFromForm(form.serializeArray());
        return void window.postMessage({
            "type": "MP_UPDATE_QUANTITIES",
            "data": data
        }, "*")
    }
    switch ((isNaN(quantity) || 0 === quantity) && $("#OrderItem_quantity").val(durationSettings.minimum), durationSettings.selecting) {
        case "start":
            if (fadeOutOfQty(), mpQuantity && mpQuantity.length) {
                var form = $("form"),
                    firstAmount = $(".first-amount").val(),
                    data = Object.assign({
                        "start": !0,
                        "duration": !0,
                        "amount": firstAmount ? Number(firstAmount) : 0
                    }, buildPriceOptionsObjectFromForm(form.serializeArray()));
                window.postMessage({
                    "type": "MP_UPDATE_QUANTITIES",
                    "data": data
                }, "*")
            }
            break;
        case "end":
            loadCalculateEndingSessionsAjax($("#OrderItem_sessionId").val())
    }
}

function shiftSessionIds() {
    $("a[data-sessionid]").each(function() {
        $(this).attr("data-original-sessionid", $(this).attr("data-sessionid"))
    }), $("a[data-sessionid]").each(function() {
        previousCellIndex = getCellIndex($(this).closest("td")), previousCell = $(".session-picker tr:nth-child(" + (previousCellIndex.row + 1) + ") td:nth-child(" + previousCellIndex.column + ")"), previousCell.length ? $(this).attr("data-sessionid", previousCell.find("a[data-sessionid]").attr("data-original-sessionid")) : $(this).closest("td").hasClass("session-day-0") && "DAYS" == durationSettings.durationUnit && "ONE" == durationSettings.nextDayType && (firstOfWeekDate = $(".session-date.session-day-0").attr("data-date"), firstOfWeekDate && (void 0 != $.datepicker ? parsedDate = $.datepicker.parseDate("yy-mm-dd", firstOfWeekDate) : void 0 != $.fn.datetimepicker && (dpg = $.fn.datetimepicker.DPGlobal, parsedDate = dpg.parseDate(firstOfWeekDate, dpg.parseFormat("yy-mm-dd", "standard"), "en", "standard")), parsedDate.setDate(parsedDate.getDate() - 1), void 0 !== window.lastSessionFromPreviousWeek[parsedDate] && $(this).attr("data-sessionid", window.lastSessionFromPreviousWeek[parsedDate])))
    })
}

function resetSessionIds() {
    $("a[data-sessionid]").each(function() {
        $(this).attr("data-sessionid", $(this).attr("data-original-sessionid")).attr("data-original-sessionid", null)
    })
}

function buildPriceOptionsObjectFromForm(data) {
    if ("1" === $(".check-quantity").attr("data-multi-quantities")) {
        var productId, formDataArray = (data || []).filter(function(item) {
                return item.name.includes("ItemQuantity")
            }) || [],
            priceOptions = [];
        return formDataArray.forEach(function(formData) {
            var normalisedFormData = formData.name.replace("ItemQuantity", "").replace(/]/g, "").split("[").filter(function(test) {
                return Boolean(test)

            });
            productId || (productId = Number(normalisedFormData[0]));
            var currentIndex = Number(normalisedFormData[1]),
                priceOptionToUpdate = priceOptions[currentIndex] || {};
            normalisedFormData.includes("quantity") && (priceOptionToUpdate.quantity = Number(formData.value)), normalisedFormData.includes("priceOption") && (normalisedFormData.includes("id") && (priceOptionToUpdate.id = Number(formData.value)), normalisedFormData.includes("priceOptionType") && (priceOptionToUpdate.type = formData.value), normalisedFormData.includes("price") && (priceOptionToUpdate.price = Number(formData.value)), normalisedFormData.includes("label") && (priceOptionToUpdate.label = formData.value), normalisedFormData.includes("priceGroupType") && (priceOptionToUpdate.priceGroupType = formData.value), normalisedFormData.includes("seatsUsed") && (priceOptionToUpdate.seatsUsed = formData.value)), priceOptions[currentIndex] = priceOptionToUpdate
        }), {
            "productId": productId,
            "priceOptions": priceOptions
        }
    }
    var productId, formDataArray = (data || []).filter(function(item) {
            return item.name.includes("OrderItem") || item.name.includes("PriceOption") || "Product[id]" === item.name
        }) || [],
        priceOption = {};
    return formDataArray.forEach(function(formData) {
        productId || "Product[id]" !== formData.name || (productId = Number(formData.value)), "OrderItem[quantity]" === formData.name && (priceOption.quantity = Number(formData.value)), "PriceOption[id]" === formData.name && (priceOption.id = Number(formData.value)), "PriceOption[priceOptionType]" === formData.name && (priceOption.type = formData.value), "PriceOption[price]" === formData.name && (priceOption.price = Number(formData.value)), "PriceOption[label]" === formData.name && (priceOption.label = formData.value), "PriceOption[priceGroupType]" === formData.name && (priceOption.priceGroupType = formData.value), "PriceOption[seatsUsed]" === formData.name && (priceOption.seatsUsed = formData.value)
    }), {
        "productId": productId,
        "priceOptions": [priceOption]
    }
}

function initCalendarSelectedDate() {
    void 0 != $.datepicker || void 0 != $.fn.datetimepicker && $.initDatePickers($(".modal-content")), $("#selectedDate").on("change", function(e) {
        $("#selectedDateLink").attr("href", $("#selectedDateLink").attr("href") + "&date=" + $("#selectedDate").val()), $("#selectedDateLink").click()
    })
}! function($) {
    function deleteApiKey() {
        $.ajax({
            "url": "/apps/appsettings/public_api_key",
            "type": "POST",
            "data": {
                "method": "delete"
            },
            "dataType": "json",
            "beforeSend": function() {
                $("#modal-delete-confirm button").each(function() {
                    $(this).attr("disabled", !0)
                }), $("#modal-delete-confirm .confirm").append(' <i class="icon-spinner icon-spin icon-large"></i>')
            },
            "complete": function() {
                $("#modal-delete-confirm button").each(function() {
                    $(this).attr("disabled", !1)
                }), $("#modal-delete-confirm .confirm i").remove()
            }
        }).done(function(response) {
            void 0 !== response.success && 1 == response.success ? ($("#modal-delete-confirm").modal("hide"), $(".api-key-public").load("/marketplace/appSettings/public_api_key", function(response, status, xhr) {}), $('.nav-tabs a[data-target="#sell-api"]').tab("show")) : 0 == response.success && alert("Unable to delete your API Key. Please contact Support")
        })
    }

    function noticeClear(noticeContainer) {
        $.ajax({
            "url": "/site/dismissNotice",
            "type": "POST",
            "beforeSend": function() {
                noticeContainer.remove()
            },
            "data": {
                "noticeId": noticeContainer.attr("data-noticeId")
            }
        })
    }

    function initTypeaheadOrderForm() {
        $(".new-customer input:visible:not(.tt-input):not(.tt-hint)").typeahead({
            "minLength": 3
        }, {
            "name": "customers",
            "source": bhSearchCustomersNewCustomer.ttAdapter(),
            "templates": {
                "header": '<p class="text-right"><a href="#" class="tt-dismiss" title="Dismiss"><i class="fa fa-times"></i></a></p>',
                "empty": "<p>No customer found. A new one will be created.</p>",
                "suggestion": function(data) {
                    var mobile = "",
                        email = "",
                        firstName = "Unknown",
                        lastName = "Unknown";
                    return data.hasOwnProperty("mobile") && data.mobile && (mobile = data.mobile), data.hasOwnProperty("email") && data.email && (email = data.email), data.hasOwnProperty("firstName") && data.firstName && (firstName = data.firstName, lastName = ""), data.hasOwnProperty("lastName") && data.lastName && (lastName = data.lastName), '<p><span class="name block">' + firstName + " " + lastName + '</span><span class="block"><small>M:</small> ' + mobile + '</span><span class="block"><small>E:</small> ' + email + "</span></p>"
                }
            }
        }).bind("typeahead:selected", function(obj, datum, name) {
            $(".new-customer").hide();
            var firstName = "Unknown",
                lastName = "";
            datum.hasOwnProperty("firstName") && (firstName = datum.firstName), datum.hasOwnProperty("lastName") && (lastName = datum.lastName);
            var template = '<div class="col-md-11"><a href="/contacts/edit/' + datum.id + '" title="View and edit customer"><strong><u>' + firstName + " " + lastName + "</u></strong></a>";
            datum.hasOwnProperty("mobile") && datum.mobile && (template += '<span class="ml mr text-muted">|</span>' + datum.mobile), datum.hasOwnProperty("email") && datum.email && (template += '<span class="ml mr text-muted">|</span>' + datum.email), template += "</div>", $(".selected-customer-details").html(template), $(".selected-customer").show(), $("#Order_customer_id").val(datum.id)
        }).bind("typeahead:closed", function(obj, datum, name) {
            window.getCustomerParticipantFields()
        })
    }

    function listenWidth(e) {
        $(window).width() < 990 ? $(".swap-div").remove().insertAfter($(".side-panel")) : $(".swap-div").remove().insertBefore($(".side-panel"))
    }

    function setToggleCatalogsLabel() {
        $(".catalog-products-list").find("input:checkbox:checked").size() > 0 ? $(".catalog-products-list .toggle-catalogs").html('<i class="fa fa-check"></i>') : $(".catalog-products-list .toggle-catalogs").html("&nbsp;")
    }

    function scrollingHelp() {
        var helper = $($("#list-details-fixed").length > 0 ? "#list-details-fixed" : ".contextual-help-wrap");
        if (helper && helper.offset()) {
            var stickyTop = helper.offset().top;
            helper.css({
                "position": "relative",
                "top": 0
            }), $(window).scroll(function() {
                var windowTop = $(window).scrollTop();
                windowTop > stickyTop ? helper.css({
                    "position": "absolute",
                    "top": windowTop - 150
                }) : helper.css({
                    "position": "relative",
                    "top": 0
                })
            })
        }
    }

    function setToggleTopicLabel() {
        $(".messages-list").find("input:checkbox:checked").size() > 0 ? ($(".messages-list .toggle-messages").text("Deselect All"), $(".archive-message").removeClass("hide")) : ($(".messages-list .toggle-messages").text("Select All"), $(".archive-message").addClass("hide"))
    }

    function setToggleNotificationLabel() {
        $(".messages-list").find("input:checkbox:checked").size() > 0 ? ($(".messages-list .toggle-messages").text("Deselect All"), $(".archive-notification").removeClass("hide")) : ($(".messages-list .toggle-messages").text("Select All"), $(".archive-notification").addClass("hide"))
    }
    /Android/.test(navigator.appVersion) && ($(document).ajaxSuccess(function() {
        Array.prototype.forEach.call(document.forms, function(form) {
            Array.prototype.forEach.call(form.elements, function(element) {
                element.setAttribute("autocomplete", "nothankyou")
            })
        })
    }), $(document.body).on("shown.bs.modal", "#modalId", function(event) {
        document.body.classList.remove("modal-open")
    })), void 0 == window.history.pushState && (window.history.pushState = function() {});
    $(window).width(), $(window).height();
    $(document).on("click", ".catalog-products-list li.row.selected select, .catalog-products-list li.row.selected input:text", function(e) {
        return e.preventDefault(), !1
    }), $(function() {
        $(".plus").click(function() {
            var text = $(this).next(":text");
            text.val(parseInt(text.val(), 10) + 1)
        }), $(".minus").click(function() {
            var text = $(this).prev(":text");
            text.val(parseInt(text.val(), 10) - 1)
        })
    }), $.fn.initScrollbar = function() {
        enquire.register("screen and (min-width: 1025px)", {
            "match": function() {
                $(".scroll-dash:not(.empty)").slimScroll({
                    "height": 385,
                    "touchScrollStep": 100,
                    "start": "bottom"
                }), $(".more").click(function() {
                    $(".scroll-dash").slimScroll({
                        "scrollTo": "385px"
                    })
                })
            },
            "unmatch": function() {
                $(".scroll-dash:not(.empty)").slimScroll({
                    "height": 385,
                    "touchScrollStep": 100,
                    "start": "bottom"
                })
            }
        })
    }, $.fn.initScrollbar(), $(".reports-carousel").slick({
        "dots": !1,
        "infinite": !1,
        "speed": 300,
        "slidesToShow": $(".reports-carousel").attr("data-number-of-tiles"),
        "slidesToScroll": 1,
        "initOnload": !0,
        "arrows": !0,
        "prevArrow": '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
        "nextArrow": '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
        "responsive": [{
            "breakpoint": 1025,
            "settings": {
                "slidesToShow": 4,
                "slidesToScroll": 1,
                "infinite": !0,
                "dots": !1
            }
        }, {
            "breakpoint": 769,
            "settings": {
                "slidesToShow": 2,
                "slidesToScroll": 1
            }
        }, {
            "breakpoint": 480,
            "settings": {
                "slidesToShow": 1,
                "slidesToScroll": 1
            }
        }]
    }), $.fn.sixColCarousel = function() {
        $(".six-col").slick({
            "dots": !1,
            "infinite": !0,
            "speed": 300,
            "slidesToShow": 6,
            "slidesToScroll": 5,
            "initOnload": !0,
            "arrows": !0,
            "prevArrow": '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
            "nextArrow": '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
            "responsive": [{
                "breakpoint": 1025,
                "settings": {
                    "slidesToShow": 4,
                    "slidesToScroll": 3,
                    "infinite": !0,
                    "dots": !1
                }
            }, {
                "breakpoint": 769,
                "settings": {
                    "slidesToShow": 2,
                    "slidesToScroll": 3
                }
            }, {
                "breakpoint": 480,
                "settings": {
                    "slidesToShow": 1,
                    "slidesToScroll": 1
                }
            }]
        })
    }, $.fn.sixColCarousel(), $(".three-col").slick({
        "dots": !1,
        "infinite": !0,
        "speed": 300,
        "slidesToShow": 3,
        "slidesToScroll": 3,
        "initOnload": !0,
        "arrows": !0,
        "prevArrow": '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
        "nextArrow": '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
        "responsive": [{
            "breakpoint": 1024,
            "settings": {
                "slidesToShow": 3,
                "slidesToScroll": 3,
                "infinite": !0,
                "dots": !1
            }
        }, {
            "breakpoint": 600,
            "settings": {
                "slidesToShow": 2,
                "slidesToScroll": 2
            }
        }, {
            "breakpoint": 480,
            "settings": {
                "slidesToShow": 1,
                "slidesToScroll": 1
            }
        }]
    }), $(".two-col").slick({
        "dots": !1,
        "infinite": !0,
        "speed": 300,
        "slidesToShow": 2,
        "slidesToScroll": 2,
        "initOnload": !0,
        "arrows": !0,
        "prevArrow": '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
        "nextArrow": '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
        "responsive": [{
            "breakpoint": 480,
            "settings": {
                "slidesToShow": 1,
                "slidesToScroll": 1
            }
        }]
    }), $(document).on("click", "#delete-api-key", function(event) {
        event.preventDefault(), $("#modal-delete-confirm").modal("show")
    }), $(document).on("click", "#regenerate-api-key", function(event) {
        event.preventDefault(), $("#modal-regenerate-confirm").modal("show")
    }), $(document).on("click", "#modal-delete-confirm button.confirm", deleteApiKey), $(document).on("click", ".api-key-public #generate-api-key", function(event) {
        event.preventDefault(), $.ajax({
            "url": "/apps/appsettings/public_api_key",
            "type": "POST",
            "data": {
                "method": "generate"
            },
            "dataType": "json",
            "beforeSend": function() {
                $(".api-key-public #generate-api-key").attr("disabled", !0)
            },
            "complete": function() {
                $(".api-key-public #generate-api-key").attr("disabled", !1), $(".api-key-public #generate-api-key i").remove()
            }
        }).done(function(response) {
            void 0 !== response.success && 1 == response.success ? ($(".api-key-public #generate-api-key").attr("disabled", !0).fadeOut(), $(".api-key-public #ApiKey_apiKeyValue").val(response.apikey), $("#sell-api").load("/marketplace/appSettings/public_api_key", function(response, status, xhr) {}), $('.nav-tabs a[data-target="#sell-api"]').tab("show")) : 0 == response.success && alert("Unable to generate your API Key. Please contact Support")
        })
    }), $(document).on("click", "article .icon", function() {
        var article = $(this).closest("article");
        article.hasClass("selected") ? (article.removeClass("selected"), article.find("input[type='checkbox']:not(.tnc-check)").removeAttr("checked"), article.find("li").removeClass("selected")) : (article.addClass("selected"), article.find(".selectable").attr("checked", "checked"), article.find("li").addClass("selected"))
    }), $.fn.rateActions = function() {
        $(".button-rate-requested").hover(function() {
            $(this).removeClass("btn-white").addClass("btn-primary no-hover").text("Send a Reminder?")
        }, function() {
            $(".button-rate-requested").removeClass("btn-primary no-hover").addClass("btn-white").text("Negotiated Rate Requested")
        }), $(document).on("click", ".send-request", function(e) {
            if ("#" == $(this).attr("href")) {
                e.preventDefault(), e.stopPropagation(), e.stopImmediatePropagation();
                var btn = $(this),
                    supplierId = btn.data("supplier-id");
                $.ajax({
                    "url": "/marketplace/sendRateRequestAjax",
                    "data": {
                        "id": supplierId
                    },
                    "dataType": "json",
                    "beforeSend": function() {},
                    "success": function(data) {
                        data.message && (data.success ? (btn.hasClass("disabled") && btn.removeClass("disabled"), $('.send-request[data-supplier-id="' + supplierId + '"]').siblings(".success-message").html('<small class="block text-center"><i class="fa fa-check"></i> Sent Just Now</small>').removeClass("hide"), $('.send-request[data-supplier-id="' + supplierId + '"]').text("Negotiated Rate Requested").removeClass("btn-danger send-request").addClass("btn-white send-reminder button-rate-requested")) : (btn.siblings(".error-message").text(data.message).removeClass("hide"), btn.siblings(".success-message").addClass("hide")), $.fn.rateActions())
                    }
                })
            }
        }), $(document).on("click", ".send-reminder", function(e) {
            if ("#" == $(this).attr("href")) {
                e.preventDefault(), e.stopPropagation(), e.stopImmediatePropagation();
                var btn = $(this),
                    supplierId = btn.data("supplier-id");
                $.ajax({
                    "url": "/marketplace/sendRateRequestAjax",
                    "data": {
                        "id": supplierId
                    },
                    "dataType": "json",
                    "beforeSend": function() {},
                    "success": function(data) {
                        data.message && (data.success ? (btn.hasClass("disabled") && btn.removeClass("disabled"), $('.send-reminder[data-supplier-id="' + supplierId + '"]').siblings(".success-message").text("Rate requested again just now").removeClass("hide"), $('.send-reminder[data-supplier-id="' + supplierId + '"]').text("Reminder Sent")) : (btn.siblings(".error-message").text(data.message).removeClass("hide"), btn.siblings(".success-message").addClass("hide")), $.fn.rateActions())
                    }
                })
            }
        })
    }, $.fn.rateActions(), $("form#create-user-form").submit(function(e) {
        return $(this).find(".rezdy-btn-loader").each(function() {
            $(this).button("loading")
        }), !0
    }), $.fn.calculateNetCommissionRate = function(element) {
        var val = $(element).val(),
            currencySymbol = $(element).data("currency");
        if ("undefined" != val && "" != val) {
            var rrp = $(element).data("rrp"),
                rezdyFee = $(element).parents(".commission-type").data("rezdy-fee"),
                rezdyCommission = rezdyFee * rrp / 100,
                net = rrp - rezdyCommission,
                commissionRate = (net - parseFloat(val, 2)).toFixed(2),
                commissionLabel = $(element).closest(".commission-net-rate").find(".agent-gets-commission");
            commissionLabel.removeClass("text-error"), commissionLabel.html(currencySymbol + " " + commissionRate), commissionRate <= 0 && (commissionLabel.addClass("text-error"), commissionLabel.html("-" + currencySymbol + " " + Math.abs(commissionRate)))
        } else {
            var commissionLabel = $(element).closest(".commission-net-rate").find(".agent-gets-commission");
            commissionLabel.removeClass("text-error"), commissionLabel.html(currencySymbol + " 0")
        }
    }, $(".commission-net").each(function() {
        $.fn.calculateNetCommissionRate(this)
    }), $(".commission-net").on("keyup", function() {
        $.fn.calculateNetCommissionRate(this)
    }), $.fn.calculatePercentCommissionRate = function(element) {
        var rezdyFee = $(element).parents(".commission-type").data("rezdy-fee"),
            commissionRate = parseInt($(element).val() - rezdyFee, 10) + "%";
        $(element).closest(".commission-rate").find(".agent-gets-commission").html(commissionRate)
    }, $(".commission-percent").each(function() {
        $.fn.calculatePercentCommissionRate(this)
    }), $(".commission-percent").on("change", function() {
        $.fn.calculatePercentCommissionRate(this)
    }), $(document).on("click", ".marketplace-agreement", function(e) {
        var isTicked = $(this).is(":checked");
        $(".marketplace-agreement-accepted").prop("disabled", !isTicked), $(".marketplace-warning").toggle(!isTicked)
    }), $(document).on("click", ".vendor-agreement", function(e) {
        var isTicked = $(this).is(":checked"),
            disableButton = !(isTicked || $(".marketplace-agreement").is(":checked"));
        $(".vendor-agreement-accepted").prop("disabled", disableButton), $(".vendor-warning").toggle(!isTicked)
    }), $("a.tab-target").click(function() {
        var url = $(this).attr("href");
        if (url.match("#")) {
            var tid = url.split("#")[1];
            $(".nav a[href=#" + tid + "]").tab("show")
        }
    }), $(document).on("click", ".tab-switch", function(e) {
        var urlstate = $(this).data("state");
        window.history.pushState({
            "pageType": "modal"
        }, null, urlstate)
    }), $(document).on("click", ".tab-switcher", function(e) {
        var urlstate = $(".modal .nav li.active").next().find("a.tab-switch").data("state");
        window.history.pushState({
            "pageType": "modal"
        }, null, urlstate)
    }), window.onpopstate = function(event) {
        var hash = location.hash,
            State = window.history.state,
            ua = window.navigator.userAgent,
            msie = ua.indexOf("MSIE "),
            safari = $.browser.webkit && !window.chrome;
        if (msie > 0 || navigator.userAgent.match(/Trident.*rv\:11\./) || safari) return !1;
        if (State && "modal" == State.pageType && "" != hash && "#" != hash && "undefined" != hash && -1 !== hash.indexOf("#")) {
            $.cookie("previousHash", hash);
            var activeTab = $("[data-state=" + hash + "]"),
                url = activeTab.attr("href");
            0 == activeTab.length ? ($(".modal").modal("hide"), "#modalId" != hash && window.location.reload()) : "#" != url && "" != url ? ($.ajax({
                "type": "POST",
                "url": url,
                "success": function(data) {
                    $(".modal-content").html(data)
                }
            }), activeTab.parent().addClass("active")) : $(".modal").modal("hide")
        } else "#modalId" == $.cookie("previousHash") && $(".modal").modal("hide")
    }, $(".noticebar").on("click", '[data-toggle="dismiss"]', function() {
        noticeContainer = $(this).closest(".notice-container"), 1 == $(".noticebar .notice-container").length ? $(".noticebar").slideUp(400, function() {
            noticeClear(noticeContainer)
        }) : noticeClear(noticeContainer)
    }), $.fn.replaceSvgImages = function() {}, $(document).ajaxStop(function() {
        $(".link-popover").popover()
    }), $(".link-popover").popover(), $(document).on("click", ".link-popover", function() {
        $(".link-popover").not(this).popover("hide")
    }), $(".navbar-toggle-sidebar").click(function() {
        $(".navbar-nav").toggleClass("slide-in"), $(".side-body").toggleClass("body-slide-in"), $(".menu-overlay").toggleClass("on")
    }), $(".menu-overlay").click(function() {
        $(".navbar-nav").toggleClass("slide-in"), $(".side-body").toggleClass("body-slide-in"), $(this).toggleClass("on")
    }), $(".side-menu li.dropdown li.active").closest(".collapse").addClass("in"), $(".side-menu").on("show.bs.collapse", function() {
        $(".side-menu .collapse.in").collapse("hide")
    }), $(".main-navbar-messages").slimScroll({
        "height": 280
    });
    var bhSearchOrders = new Bloodhound({
        "remote": "/site/searchOrders?term=%QUERY",
        "rateLimitWait": 800,
        "datumTokenizer": Bloodhound.tokenizers.obj.whitespace("orderNumberFormatted"),
        "queryTokenizer": Bloodhound.tokenizers.whitespace
    });
    bhSearchOrders.initialize();
    var bhSearchCustomers = new Bloodhound({
        "remote": "/site/searchCustomers?term=%QUERY",
        "rateLimitWait": 800,
        "datumTokenizer": Bloodhound.tokenizers.obj.whitespace("firstName"),
        "queryTokenizer": Bloodhound.tokenizers.whitespace
    });
    bhSearchCustomers.initialize();
    var bhSearchCustomersNewCustomer = new Bloodhound({
        "remote": "/site/searchCustomers?term=%QUERY&limit=20",
        "rateLimitWait": 800,
        "datumTokenizer": Bloodhound.tokenizers.obj.whitespace("firstName"),
        "queryTokenizer": Bloodhound.tokenizers.whitespace,
        "limit": 20
    });
    bhSearchCustomersNewCustomer.initialize();
    var bhSearchAgents = new Bloodhound({
        "remote": "/site/searchAgents?term=%QUERY",
        "rateLimitWait": 800,
        "datumTokenizer": Bloodhound.tokenizers.obj.whitespace("resellerCode"),
        "queryTokenizer": Bloodhound.tokenizers.whitespace
    });
    bhSearchAgents.initialize();
    var bhSearchVouchers = new Bloodhound({
        "remote": "/site/searchVouchers?term=%QUERY",
        "rateLimitWait": 800,
        "datumTokenizer": Bloodhound.tokenizers.obj.whitespace("code"),
        "queryTokenizer": Bloodhound.tokenizers.whitespace
    });
    bhSearchVouchers.initialize();
    var bhSearchPromoCodes = new Bloodhound({
        "remote": "/site/searchPromoCodes?term=%QUERY",
        "rateLimitWait": 800,
        "datumTokenizer": Bloodhound.tokenizers.obj.whitespace("code"),
        "queryTokenizer": Bloodhound.tokenizers.whitespace
    });
    bhSearchPromoCodes.initialize(), $(".rezdy-super-search").typeahead({
        "minLength": 3,
        "highlight": !0
    }, {
        "name": "customers",
        "source": bhSearchCustomers.ttAdapter(),
        "displayKey": "firstName",
        "templates": {
            "header": "<h3>Customers</h3>",
            "empty": "<p>No result</p>",
            "suggestion": function(data) {
                return '<p><a href="/contacts/edit/' + data.id + '">' + data.firstName + " " + data.lastName + " &lt;" + data.email + "&gt;</a></p>"
            }
        }
    }, {
        "name": "orders",
        "source": bhSearchOrders.ttAdapter(),
        "displayKey": "orderNumberFormatted",
        "templates": {
            "header": "<h3>Orders</h3>",
            "empty": "<p>No result</p>",
            "suggestion": function(data) {
                return '<p><a href="/orders/edit/' + data.orderNumber + '">' + data.orderNumberFormatted + "</a></p>"
            }
        }
    }, {
        "name": "agents",
        "source": bhSearchAgents.ttAdapter(),
        "displayKey": "fullName",
        "templates": {
            "header": "<h3>Agents</h3>",
            "empty": "<p>No result</p>",
            "suggestion": function(data) {
                return '<p><a href="/agents/edit/' + data.id + '?showModal=false">' + data.resellerCode + "</a></p>"
            }
        }
    }, {
        "name": "vouchers",
        "source": bhSearchVouchers.ttAdapter(),
        "displayKey": "code",
        "templates": {
            "header": "<h3>Vouchers</h3>",
            "empty": "<p>No result</p>",
            "suggestion": function(data) {
                return '<p><a href="/vouchers/edit/' + data.id + '">' + data.code + "</a></p>"
            }
        }
    }, {
        "name": "promocodes",
        "source": bhSearchPromoCodes.ttAdapter(),
        "displayKey": "code",
        "templates": {
            "header": "<h3>Promo Codes</h3>",
            "empty": "<p>No result</p>",
            "suggestion": function(data) {
                return '<p><a href="/promocodes/edit/' + data.id + '">' + data.code + "</a></p>"
            }
        }
    }).bind("typeahead:selected", function(obj, datum, name) {
        $(this).val("")
    }), $.fn.initTypeaheadCustomerDetails = function() {
        $(".autocomplete-details input[type=text]:visible:not(.tt-input):not(.tt-hint)").typeahead({
            "minLength": 3
        }, {
            "name": "customers",
            "source": bhSearchCustomersNewCustomer.ttAdapter(),
            "templates": {
                "header": '<p class="text-right"><a href="#" class="tt-dismiss" title="Dismiss"><i class="fa fa-times"></i></a></p>',
                "suggestion": function(data) {
                    var mobile = "",
                        email = "",
                        firstName = "Unknown",
                        lastName = "Unknown";
                    return data.hasOwnProperty("mobile") && data.mobile && (mobile = data.mobile), data.hasOwnProperty("email") && data.email && (email = data.email), data.hasOwnProperty("firstName") && data.firstName && (firstName = data.firstName, lastName = ""), data.hasOwnProperty("lastName") && data.lastName && (lastName = data.lastName), '<p><span class="name block">' + firstName + " " + lastName + '</span><span class="block"><small>M:</small> ' + mobile + '</span><span class="block"><small>E:</small> ' + email + "</span></p>"
                }
            }
        }).bind("typeahead:selected  typeahead:autocompleted", function(obj, datum, name) {
            $("#Order_customer_firstName").val(""), $("#Order_customer_lastName").val(""), $("#Order_customer_mobile").val(""), $("#Order_customer_email").val(""), datum.hasOwnProperty("firstName") && ($("#Order_customer_firstName").typeahead("val", datum.firstName), $.fn.copyValue("#Order_customer_firstName")), datum.hasOwnProperty("lastName") && ($("#Order_customer_lastName").typeahead("val", datum.lastName), $.fn.copyValue("#Order_customer_lastName")), datum.hasOwnProperty("mobile") && ($("#Order_customer_mobile").typeahead("val", datum.mobile), $.fn.copyValue("#Order_customer_mobile")), datum.hasOwnProperty("email") && ($("#Order_customer_email").typeahead("val", datum.email), $.fn.copyValue("#Order_customer_email")), $("#Order_customer_id").val(datum.id)
        })
    }, $.fn.copyValue = function(element) {
        var $targetField, $sourceField = $(element),
            $firstParticipant = $("#participants .participants-fields-0"),
            type = $sourceField.data("fieldtype");
        if ("CUSTOM" === type) {
            var fieldName = $sourceField.data("custom-name");
            $targetField = $firstParticipant.find("[data-fieldtype=" + type + "][data-custom-name=" + fieldName + "]")
        } else $targetField = $firstParticipant.find("input[data-fieldtype=" + type + "]");
        $targetField.length && !$targetField.val() && $targetField.val($(element).val())
    }, $(".remove-selected-customer").on("click", function(e) {
        e.preventDefault(), $("#Order_customer_id").val(""), $(".selected-customer").hide(), $(".new-customer").show(), $(".new-customer input").val(""), $(".new-customer input").attr("value", ""), initTypeaheadOrderForm()
    }), initTypeaheadOrderForm(), $.fn.closeTypeaheadAutocomplete = function() {
        $(".new-customer :input").typeahead("close"), $(".autocomplete-details :input[type=text]").typeahead("close"), $(".agent-container :input[type=text]").typeahead("close")
    }, $(document).on("click", ".tt-dismiss", function(e) {
        e.preventDefault(), $.fn.closeTypeaheadAutocomplete()
    }), $(".new-customer :input").live("keydown", function(e) {
        9 == e.keyCode && $.fn.closeTypeaheadAutocomplete()
    }), $(function() {
        $(document.body).find(".no-autocomplete").each(function() {
            $(this).attr("autocomplete", "chrome-y-u-no-observe-autocomplete-off")
        })
    }), $(".show-tooltip").tooltip(), $('[data-toggle="tooltip"]').tooltip(), Selectize.define("clear_selection", function(options) {
        var self = this;
        self.plugins.settings.dropdown_header = {
            "title": "Clear Selection"
        }, this.require("dropdown_header"), self.setup = function() {
            var original = self.setup;
            return function() {
                original.apply(this, arguments), this.$dropdown.on("mousedown", ".selectize-dropdown-header", function(e) {
                    return self.setValue(""), self.close(), self.blur(), !1
                })
            }
        }()
    }), $("select:not(.noselectize)").each(function() {
        if ($(this).find("option").length > 15) {
            $(this).hasClass("form-control") && $(this).removeClass("form-control");
            var selectValue = $(this).val(),
                select = $(this).selectize({
                    "create": !1,
                    "dropdownParent": "body",
                    "plugins": {
                        "clear_selection": {}
                    },
                    "lockOptgroupOrder": !0
                }),
                control = select[0].selectize;
            selectValue && !control.getValue() && control.setValue(selectValue)
        }
    }), $("#Order_status").selectize(), $(".order-status-select .selectize-input").css({
        "padding": "0",
        "margin": "0",
        "height": "40px"
    }), $(".order-status-select input").css({
        "display": "none"
    }), $(".order-status-select input").prop("readonly", !0), $(".selectize-dropdown").css("z-index", "10000"), $(".selectize-control ").closest(".input-group:not(.no-selectize-block)").addClass("block"), $(document).load($(window).bind("resize", listenWidth)), window.rgb2hex = function(rgb) {
        function hex(x) {
            return ("0" + parseInt(x).toString(16)).slice(-2)
        }
        return /^#[0-9A-F]{6}$/i.test(rgb) ? rgb : (rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/), "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]))
    }, window.selectizeTags = function(selectizeInput) {
        return $selectize = $(selectizeInput).selectize({
            "plugins": ["remove_button"],
            "valueField": "val",
            "labelField": "label",
            "searchField": ["label"],
            "create": !1,
            "openOnFocus": !1,
            "highlight": !1,
            "closeAfterSelect": !0,
            "disableDelete": !0,
            "disableCaret": !0,
            "render": {
                "option": function(item, escape) {
                    return "<div>" + escape(item.label) + "</div>"
                }
            },
            "load": function(query, callback) {
                return query.length, callback()
            },
            "onInitialize": function() {
                if ("undefined" != typeof onInitializeSelectize && $.isFunction(onInitializeSelectize)) {
                    var self = this;
                    onInitializeSelectize(self)
                }
            },
            "onDelete": function(val) {
                "undefined" != typeof onDeleteSelectizeItem && $.isFunction(onDeleteSelectizeItem) && onDeleteSelectizeItem(val)
            },
            "onItemRemove": function(val) {
                "undefined" != typeof onDeleteSelectizeItem && $.isFunction(onDeleteSelectizeItem) && onDeleteSelectizeItem(val)
            },
            "onItemAdd": function(val) {
                "undefined" != typeof onAddingSelectizeItem && $.isFunction(onAddingSelectizeItem) && onAddingSelectizeItem(val)
            }
        }), $selectize[0].selectize
    }, $(document).ready(function() {
        $(".textarea-autoresize").each(function(pos, obj) {
            autoresize(this)
        })
    }), $(".textarea-autoresize").on("keyup", function() {
        autoresize(this)
    }), window.autoresize = function(textarea) {
        $(textarea).height(30), "" !== $(textarea).val() && $(textarea)[0].scrollHeight > 1 && $(textarea).height($(textarea)[0].scrollHeight + 5)
    }, $(".more-criteria").on("click", function() {
        $(".search-filter").toggleClass("on"), $(this).toggleClass("on")
    }), $(document).on("click", ".toggler", function() {
        $(".toggled").toggleClass("on"), $(this).parent().find(".fa-angle-down").toggleClass("rotate-90"), $(".toggled-next").parent().find(".fa-angle-down").toggleClass("rotate-90")
    }), $(document).on("click", ".errorMessage", function() {
        $(this).css("display", "none"), $(this).parent(".controls").toggleClass("error")
    }), $(document).on("click", ".toggler-next", function() {
        $(this).next(".toggled-next").toggleClass("on"), $(this).parent().find(".fa-angle-down").toggleClass("rotate-90")
    }), $(document).on("click", ".hdr-toggler", function() {
        $(this).toggleClass("on"), $(this).next(".div-toggled").toggleClass("on"), $(this).hasClass("on") && $(this).closest("section").find(".textarea-autoresize").each(function(pos, obj) {
            autoresize(this)
        })
    }), $(window).width() < 481 && $(".hdr-toggler, .div-toggled").removeClass("on"), $(document).on("click", "a.edit-catalog-product", function(e) {
        var btn = $(this);
        e.preventDefault();
        var productid = $(this).data("productid"),
            categoryid = $(this).data("categoryid"),
            action = $(this).data("action");
        $.ajax({
            "type": "POST",
            "url": "/catalogs/editCatalogProductAjax",
            "data": "productid=" + productid + "&categoryid=" + categoryid + "&action=" + action,
            "dataType": "json",
            "beforeSend": function() {
                btn.button("loading"), $(".edit-catalog-product").addClass("disabled")
            },
            "success": function(data, status) {
                data.success && $("#add-category").html(data.view), $(".edit-catalog-product").removeClass("disabled")
            }
        })
    }), $(document).on("click", "a.catalog-submit", function(e) {
        var btn = $(this),
            catalogName = $("#Catalog_name").val(),
            catalogType = $("input[name=catalogType]").val();
        e.preventDefault();
        var dataForm = $("#catalog-form").serialize();
        catalogType && "AGENT_CATEGORY" === catalogType && catalogName && catalogName.length > 0 ? ($("a.deSelect-agentCategory").trigger("click"), $.fn.createAgentCategory(dataForm, btn)) : $.fn.createCategory(dataForm, btn)
    }), $.fn.createCategory = function(dataForm, btn) {
        $.ajax({
            "type": "POST",
            "url": "/catalogs/createNewCategoryAjax",
            "data": dataForm,
            "dataType": "json",
            "beforeSend": function() {
                btn.button("saving")
            },
            "success": function(data, status) {
                data.success ? ($("#add-category").html(data.view), $('#category-tabs a[href="#add-category"]').tab("show")) : $("#new-category").html(data.view)
            }
        })
    }, $.fn.createAgentCategory = function(dataForm, btn) {
        $.ajax({
            "type": "POST",
            "url": "/catalogs/createAgentCategoryAjax",
            "data": dataForm,
            "dataType": "json",
            "beforeSend": function() {
                btn.button("saving")
            },
            "success": function(data, status) {
                data.success ? ($("#AgentSupplier_agentCategory_name").val(data.agentCategoryName), $("input[name=selectedAgentCategoryId]").val(data.agentCategoryId), $("#add-category").html(data.view), $('#category-tabs a[href="#add-category"]').tab("show")) : $("#new-category").html(data.view)
            }
        })
    }, $(document).on("click", ".products .categorise", function() {
        $(this).next(".categories").toggleClass("on"), $(this).toggleClass("on")
    }), $(document).on("click", ".categories li", function() {
        $(this).toggleClass("on");
        var productId = $(this).closest(".categories").data("productid"),
            catalogId = $(this).data("categoryid"),
            inCategory = $(this).hasClass("on") ? 1 : 0,
            masterObject = {
                "Catalog": {
                    "name": $(this).text(),
                    "visible": "1"
                },
                "Product": {}
            },
            ajaxUrl = 0 == inCategory ? "/catalogs/removeProductAjax" : "/catalogs/addProductAjax";
        $.ajax({
            "type": "POST",
            "url": ajaxUrl + "?catalogId=" + catalogId + "&productId=" + productId,
            "data": masterObject,
            "success": function() {},
            "dataType": "json"
        })
    }), $(document).on("click", ".categories a.add-category", function() {
        $(".categories ul.categories-list").append('<li class="new">' + $(this).prev().val() + "</li>"), $.ajax({
            "type": "POST",
            "url": "/catalogs/new",
            "data": {
                "Catalog": {
                    "name": $(this).prev().val(),
                    "visible": "1"
                }
            },
            "success": function(result) {
                result && $(".categories ul.categories-list li.new").attr("data-categoryid", result.trim())
            }
        }), $(this).prev().val("")
    }), $(document).on("change", ".catalog-products-list .select-commission-type", function(e) {
        $(this).closest("li").find(".commission-type").toggle()
    }), $(document).on("click", ".catalog-products-list .select-catalog", function(e) {
        $(this).closest("li").toggleClass("selected"), $(this).closest("li").hasClass("selected") && $(this).closest("li").find(".check-extra").attr("checked", !0), setToggleCatalogsLabel()
    }), $(document).on("click", ".catalog-products-list .toggle-catalogs", function(e) {
        $(".catalog-products-list").find("input:checkbox:checked").size() > 0 ? ($(".catalog-products-list").find("input:checkbox").closest("li.row").removeClass("selected"), $(".catalog-products-list").find("input:checkbox").prop("checked", !1)) : ($(".catalog-products-list").find("input:checkbox").closest("li.row").addClass("selected"), $(".catalog-products-list").find("input:checkbox").prop("checked", !0)), setToggleCatalogsLabel(), e.preventDefault()
    }), $.fn.trimSerialize = function(selector) {
        var clonedObject = $(this).clone(!0).off();
        return $(this).find("select").each(function(i) {
            clonedObject.find("select").eq(i).val($(this).val())
        }), selector = void 0 === selector ? "input[type=text]" : selector, clonedObject.find(selector).each(function() {
            $(this).val($.trim($(this).val()))
        }), clonedObject.serialize()
    };
    var currentYiiListRequest = !1;
    $("form.search-items-form").submit(function(e) {
        e.preventDefault();
        var form = $(this);
        try {
            currentYiiListRequest.abort()
        } catch (error) {}
        var filters = form.trimSerialize();
        currentYiiListRequest = $.fn.yiiListView.update("list-items", {
            "url": form.attr("action"),
            "data": filters,
            "beforeSend": function() {
                form.find(".rezdy-btn-loader").each(function() {
                    $(this).button("loading")
                }), $("#list-items-loading .img-loader-error").hide(), $("#list-items-loading .img-loader").show()
            },
            "error": function(XMLHttpRequest, textStatus, errorThrown) {
                $("#list-items-loading .img-loader").hide(), $("#list-items-loading .img-loader-error").show()
            },
            "complete": function() {
                document.dispatchEvent(new CustomEvent(COMPLETE_SUBMIT_SEARCH, {
                    "detail": {
                        "filters": filters
                    }
                })), form.find(".rezdy-btn-loader").each(function() {
                    $(this).button("reset")
                })
            }
        })
    });
    var ajaxUpdateTimeout;
    $("form.search-items-form input.searchField").on("keyup", function() {
        clearTimeout(ajaxUpdateTimeout), ajaxUpdateTimeout = setTimeout(function() {
            $("form.search-items-form").submit()
        }, 300)
    }), $("form.search-items-form select.searchField").on("change", function() {
        clearTimeout(ajaxUpdateTimeout), ajaxUpdateTimeout = setTimeout(function() {
            $("form.search-items-form").submit()
        }, 300)
    }), $.fn.extend({
        "startLoading": function() {
            $("#list-items").hide(), $("#list-items-loading").show(), $("#item-details").html(""), $.fn.destroyInfiniteScroll()
        },
        "endLoading": function(id, data) {
            if ($.fn.resetInfiniteScroll(), $("#list-items").show(), $("#list-items-loading").hide(), data) {
                var filters = document.forms["main-search-form"] ? $(document.forms["main-search-form"]).trimSerialize() : "";
                document.dispatchEvent(new CustomEvent(SUCCESS_SUBMIT_SEARCH, {
                    "detail": {
                        "result": data,
                        "filters": filters
                    }
                })), data = "<div>" + data + "</div>", $(".items-total-count").text($(data).find(".items-total-count").text()), $(".what-we-found").html($(data).find(".what-we-found").html()), $(".marketplace-destination-breadcrumbs").html($(data).find(".marketplace-destination-breadcrumbs").html()), $(".destination-search").html($(data).find(".destination-search").html()), $(".commission-details").html($(data).find(".commission-details").html())
            }
        }
    }), $(document).on("click", ".filter-supplier", function() {
        $(".supplier-filter-name").html($(this).data("supplier-name")), $(".supplier-filter-id").val($(this).data("supplier-id")), $(".supplier-filter-link").attr("href", "/marketplace/share/" + $(this).data("supplier-id")), $("form.search-items-form").trigger("submit"), $(".supplier-filter-holder").show()
    }), $(document).on("click", ".supplier-filter-holder .glyphicon-remove", function() {
        $(".supplier-filter-id").val(""), $("form.search-items-form").trigger("submit"), $(".supplier-filter-holder").hide()
    }), $(document).on("click", ".with-confirm", function() {
        return confirm($(this).data("confirm"))
    }), $(document).on("click", ".edit-total a", function(e) {
        e.preventDefault(), $(".total-amount").hide(), $(".edit-total").hide(), $(".edit-total-fields").show()
    }), $(document).on("change", ".return-check", function() {
        $(".return").toggle(1 == $(this).val())
    }), $(document).on("click", ".number-spinner a", function() {
        var btn = $(this),
            preVal = btn.closest(".number-spinner").find("input").val().trim(),
            newVal = 0;
        newVal = "up" == btn.attr("data-dir") ? parseInt(preVal) + 1 : preVal > 0 ? parseInt(preVal) - 1 : 0, btn.closest(".number-spinner").find("input").val(newVal)
    }), $(document).on("show.bs.modal", ".modal", function() {
        var modal = this,
            hash = location.hash;
        if (-1 === hash.indexOf("#")) var hash = "#" + modal.id;
        window.history.pushState({
            "pageType": "modal"
        }, null, hash), window.location.hash = hash, $.cookie("previousHash", hash)
    }), $(document).on("hidden.bs.modal", ".modal", function() {
        window.history.pushState("", document.title, window.location.pathname + window.location.search), $(".target-modal").bind("click"), $.cookie("previousHash", null)
    });
    var iframeParameterPattern = new RegExp("/iframe=(?:true|1)/", "i");
    $(document).on("click", ".target-modal", function(e) {
        var modal = $(".modal.modal-blur:not(#dialog-restore-confirmation)"),
            modalContent = modal.find(".modal-content"),
            isSmallModal = event.target.classList.contains("small-modal");
        if (event.target.classList.contains("no-tab-index") && modal.removeAttr("tabindex"), (event.target.classList.contains("refresh-page-on-close") || isSmallModal) && modal.on("hide.bs.modal", function() {
                window.location.reload()
            }), event.target.classList.contains("resizable-content")) {
            var script = document.querySelector("script#iframeHostResizer"),
                selector = '[src="' + targetUrl + '"]';
            if (script) iFrameResize(opts, selector);
            else {
                script = document.createElement("script"), script.id = "iframeHostResizer", script.src = "https://cdnjs.cloudflare.com/ajax/libs/iframe-resizer/4.3.2/iframeResizer.min.js";
                var opts = {
                    "scrolling": !0
                };
                script.onload = function() {
                    iFrameResize(opts, selector)
                }, document.head.append(script)
            }
        }
        if (isSmallModal && (modal.css({
                "top": "10vh",
                "left": "10vw",
                "padding": "10px",
                "width": "80vw",
                "height": "90vw",
                "minWidth": "80vw"
            }), modal.on("shown.bs.modal", function() {
                var backdrop = $(".modal-backdrop");
                if (backdrop) {
                    backdrop.css({
                        "display": "block",
                        "z-index": 1030,
                        "background-color": "rgba(0,0,0,0.5)"
                    });
                    var modalHeaders = modal.find(".modal-header");
                    if (0 !== modalHeaders.length) {
                        modalHeaders.css({
                            "background-color": "transparent",
                            "border": "none"
                        });
                        var closeButtons = modal.find("button.close");
                        0 !== closeButtons.length && closeButtons.addClass("small-modal-close")
                    }
                }
            })), modal.attr("id", "modalId"), modal.removeClass("transparent"), $(this).data("background") && "transparent" == $(this).data("background") && modal.addClass("transparent"), "#" != $(this).attr("href")) {
            e.preventDefault();
            var actualLabel = "";
            if (!$(this).hasClass("no-loading-text")) {
                actualLabel = $(this).text();
                var modalLink = $(this);
                modalLink.text("Loading...")
            }
            if ($(".target-modal").unbind("click"), $(this).hasClass("target-iframe")) {
                var targetUrl = $(this).attr("href");
                iframeParameterPattern.test($(this).attr("href")) || (targetUrl += (-1 !== targetUrl.indexOf("?") ? "&" : "?") + "iframe=1");
                var modalTitle = $(this).attr("data-modalTitle"),
                    modalURL = $(this).attr("data-modalURL"),
                    modalContentHtml = '<div class="modal-header"><button type="button" class="close" data-dismiss="modal" data-target="#modalId" aria-hidden="true">\xd7</button>';
                modalContentHtml += void 0 !== modalTitle ? '<h4 class="modal-title">' + modalTitle + "</h4>" : "", modalContentHtml += void 0 !== modalURL ? '<a href="' + modalURL + '">' + modalURL + "</a>" : "", modalContentHtml += "</div>";
                if (modalContentHtml += '<div class="modal-body" >' + ('<iframe  marginwidth="0" marginheight="0" frameborder="0" seamless src="' + targetUrl + '"  data-source-url="' + targetUrl + '" width="100%" height="' + ($(window).height() - 97) + 'px"></iframe>') + "</div>", modal.addClass("iframe-model"), modalContent.html(modalContentHtml), event.target.classList.contains("resizable-content")) {
                    var iframe$ = modalContent.find("iframe");
                    iframe$[0].style.minWidth = "100%", iframe$[0].removeAttribute("width"), isSmallModal && (iframe$[0].removeAttribute("height"), iframe$[0].style.minHeight = $(window).height() - 196 + "px")
                }
                modal.modal("show"), "" !== actualLabel && modalLink.text(actualLabel)
            } else $(this).hasClass("external") ? window.location = $(this).attr("href") : modalContent.load($(this).attr("href"), function(result) {
                $.initDatePickers($(this)), modal.modal({
                    "show": !0,
                    "backdrop": "static"
                }), "" != actualLabel && modalLink.text(actualLabel), modal.removeClass("iframe-model")
            });
            $(".target-modal").bind("click"), modalContent.removeClass("col-md-8 pull-center app-store")
        }
    }), $(document).on("click", ".products button.close", function() {
        document.cookie = "hideCongratulations = true"
    });
    var currentAjaxRequest;
    $(document).on("click", ".target-remote-tab", function(e) {
        var tab = $(this);
        "#" != tab.attr("href") && (e.preventDefault(), $(tab.data("target") + " .tab-content").empty().html('<div id="list-loading-div" style="text-align: center;"><div id="infscr-loading"><img alt="Loading..." src="data:image/gif;base64,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"><div>Loading...</div></div></div>'), currentAjaxRequest && 4 != currentAjaxRequest.readyState && currentAjaxRequest.abort(), currentAjaxRequest = $.ajax({
            "url": tab.attr("href"),
            "async": !0,
            "success": function(data, result) {
                $(tab.data("target") + " .tab-content").html(data), $.initDatePickers($(this)), tab.tab("show")
            }
        }))
    }), $(document).on("click", ".share-url, button#clipboard", function() {
        var linkText = $("input#clipboard_text");
        linkText.select(), $(this).hasClass("link") && window.open(linkText.val(), "_blank")
    }), $("table.app-cat-table,table#extras-table,table.row-sorter").sortable({
        "containerSelector": ".app-cat-table,.extras-table,.row-sorter",
        "itemSelector": "tr",
        "itemPath": "tbody",
        "delay": 3,
        "placeholder": '<p class="placeholder"><span class="label label-primary">Drop here</span></p>',
        "onDragStart": function(item, container, _super) {
            container.options.drop || item.clone().insertAfter(item), _super(item)
        }
    });
    //vietISO
    var helpTextHandler = function(event) {
        $(event.target).nextAll(".contextual-help:first").length && $(".contextual-help-wrap div").html($(event.target).nextAll(".contextual-help:first").clone())
    };
    $(document).on("mouseover", ".wysihtml5-sandbox", function(event) {
        $(event.target).contents().find("body").one("click.iframe", function() {
            helpTextHandler(event)
        })
    }), $(document).on("focusin", "form input, form select, form textarea", helpTextHandler), $(document).on("click", "form input[type='checkbox'], form input[type='file'], form input[type='radio'], form .selectize-control", helpTextHandler), $(document).on("focusin", "form input.tt-input", function(e) {
        $(this).closest(".twitter-typeahead").nextAll(".contextual-help:first").length && $(".contextual-help-wrap div").html($(this).closest(".twitter-typeahead").nextAll(".contextual-help:first").clone())
    }), $(document).on("click", "form .helper-block", function(event) {
        $(".helper-block").find(".contextual-help:first").length > 0 && $(".contextual-help-wrap div").html($(".helper-block").find(".contextual-help:first").clone())
    }), $(document).on("submit", ".modal-content form", function(e) {
        var form = $(this);
        form.hasClass("no-ajax") || (e.preventDefault(), $.ajax({
            "type": form.attr("method"),
            "url": form.attr("action"),
            "data": form.serialize(),
            "beforeSend": function() {
                $(".loading-container .loading-splash").removeClass("hidden"), form.find(".rezdy-btn-loader").each(function() {
                    $(this).button("loading")
                })
            },
            "success": function(data, status) {
                $("#invite").length > 0 ? ($(".modal-content").html(data), $("button.inviteAnotherSupplier").removeClass("hide-old")) : form.data("element-target") ? $(form.data("element-target")).html(data) : $(".modal-content").html(data), $.initDatePickers($(".modal-content"));
                const $errorSummary = $(".errorSummary");
                if ($errorSummary.length && $errorSummary.is(":visible")) {
                    const $modal = $("#modalId"),
                        scrollOffset = $errorSummary.offset().top - $modal.offset().top + $modal.scrollTop() - 16;
                    $modal.scrollTop(scrollOffset)
                }
            },
            "complete": function() {
                form.find(".rezdy-btn-loader").each(function() {
                    $(this).button("reset")
                })
            }
        }))
    }), $(".modal-blur").insertAfter("#main-wrapper"), $(document).on("click", "button.out-of-form", function(e) {
        $(this).parents().find("form").submit()
    }), $(document).on("click", "a#show-custom-css", function(e) {
        e.preventDefault()
    }), $(document).on("click", ".dashboard-actions ul li", function() {
        var link = $(this).find("a").attr("href");
        window.location = link
    });
    var lastStr = "[First Name]";
    $(document).on("blur", "#invite input#AgentSupplier_firstName", function() {
        var inviteMessage = $("textarea#AgentSupplier_inviteMessage").val(),
            nameValue = "" != $(this).val() ? $(this).val() : "[First Name]";
        $("textarea#AgentSupplier_inviteMessage").val(inviteMessage.replace(lastStr, nameValue)), lastStr = nameValue
    }), $(document).on("click", "button.inviteAnotherSupplier", function() {
        return $("#invite .required input").val(""), $(this).addClass("hide-old"), $("#invite input#AgentSupplier_firstName").focus(), $("#invite .alert-success").remove(), !1
    });
    var selectListOptions = $("select.multiselect option"),
        selectList = $("select.multiselect"),
        availableList = $(".multi-select ul.available-list"),
        selectedList = $(".multi-select ul.selected-list"),
        amountOfItems = 1,
        countElement = $("div.selected p.amount span");
    $(".selected,.available").sortable({
        "group": "grouped",
        "itemSelector": "li",
        "itemPath": "ul",
        "placeholder": '<p class="placeholder"><span class="label label-primary">Drop here</span></p>',
        "onDragStart": function(item, container, _super) {
            container.options.drop || item.clone().insertAfter(item), _super(item)
        },
        "delay": 2,
        "onDrop": function() {
            amountOfItems = selectedList.find("li").length, countElement.text(amountOfItems + " Resource/s Selected"), $("body").removeClass("dragging"), selectListOptions.each(function(i, value) {
                selectedList.find("li[value=" + $(this).val() + "]").length > 0 ? $(this).attr("selected", "selected") : $(this).removeAttr("selected")
            }), selectedList.find("li").each(function() {
                selectedValue = $(this).attr("value"), selectList.find("[value=" + selectedValue + "]").remove().appendTo(selectList)
            })
        }
    }), $.each(selectListOptions, function() {
        void 0 !== $(this).attr("selected") ? selectedList.append('<li class="sortable" value="' + $(this).val() + '">' + $(this).text() + "</li>") : availableList.append('<li class="sortable" value="' + $(this).val() + '">' + $(this).text() + "</li>")
    }), amountOfItems = selectedList.find("li").length, $(document).on("click", ".multi-select ul.available-list li,.multi-select ul.selected-list li,.multi-select .available p.add-all,.multi-select .selected p.remove-all", function() {
        var selectedValue = $(this).val();
        $(this).hasClass("add-all") ? (amountOfItems = selectListOptions.size(), selectedList.empty(), selectListOptions.each(function() {
            selectedList.append('<li value="' + $(this).val() + '">' + $(this).text() + "</li>")
        }), selectListOptions.attr("selected", "selected"), availableList.empty()) : $(this).hasClass("remove-all") && (availableList.empty(), selectListOptions.each(function() {
            availableList.append('<li value="' + $(this).val() + '">' + $(this).text() + "</li>")
        }), selectedList.empty(), $(selectListOptions).removeAttr("selected"), amountOfItems = 0), $(this).parent().hasClass("selected-list") ? (availableList.append($(this)), selectListOptions.each(function(i, value) {
            $(this).val() == selectedValue && $(this).removeAttr("selected")
        }), amountOfItems = selectedList.find("li").length) : $(this).parent().hasClass("available-list") && (selectedList.append($(this)), selectListOptions.each(function(i, value) {
            $(this).val() == selectedValue && $(this).attr("selected", "selected")
        }), amountOfItems = selectedList.find("li").length), selectedList.find("li").each(function() {
            selectedValue = $(this).attr("value"), selectList.find("[value=" + selectedValue + "]").remove().appendTo(selectList)
        }), countElement.text(amountOfItems + " Selected")
    }), countElement.text(amountOfItems + " Selected"), window.resetSaveWarning = function() {
        window.onbeforeunload = function() {}
    }, $(document).on("click", ".manifest-item .header-controls button.hideTable", function() {
        $(this).closest(".collapse-container").find(".normal-session").slideToggle(), $(this).children("i.icon-chevron-down,i.icon-chevron-up").toggleClass("hidden")
    }), window.changeProfilePicture = function(imageUrl) {};
    $("#user-display-picture").length && ($("#user-display-picture-hidden").on("error", function() {
        $("#user-display-picture").css("background-image", "url(" + placeHolderImage + ")")
    }).attr("src", $("#user-display-picture-hidden").attr("src")), window.changeProfilePicture = function(imageUrl) {
        $("#user-display-picture-hidden").attr("src", imageUrl), $("#user-display-picture").css("background-image", "url(" + imageUrl + ")")
    }), $("body").on("click", ".closeable .item-close", function() {
        return callbackUrl = $(this).parent().attr("data-callback"), void 0 != callbackUrl && $.ajax({
            "url": callbackUrl
        }), removeId = $(this).parent().attr("data-remove"), hideId = $(this).parent().attr("data-hide"), triggerId = $(this).parent().attr("data-trigger"), void 0 != removeId && ("this" == removeId ? $(this).parent().fadeOut(function() {
            $(this).remove(), void 0 != triggerId && $("#" + triggerId).trigger("removeEvent")
        }) : $("#" + removeId).fadeOut(function() {
            $(this).remove(), void 0 != triggerId && $("#" + triggerId).trigger("removeEvent")
        })), void 0 != hideId && ("this" == hideId ? $(this).parent().fadeOut(function() {
            $(this).hide(), void 0 != triggerId && $("#" + triggerId).trigger("removeEvent")
        }) : $("#" + removeId).fadeOut(function() {
            $(this).hide(), void 0 != triggerId && $("#" + triggerId).trigger("removeEvent")
        })), !1
    }), $(document).on("focusout", "#AgentSupplier_companyName", function(e) {
        if ("" != $(this).val() && "" == $("#AgentSupplier_resellerCode").val()) {
            var companyName = $(this).val().replace(/\"/g, "").replace(/ /g, "").replace(/\'/g, "").replace(/&/g, "").toUpperCase();
            $("#AgentSupplier_resellerCode").val(companyName)
        }
    }), scrollingHelp(), $(document).load($(window).bind("resize", scrollingHelp)), $(document).on("input change", "#Topic_lastMessage_message", function() {
        $(".send-message").attr("disabled", !0), this.value.length && $(".send-message").attr("disabled", !1)
    }), $(document).on("click", ".topic-container .messages-list .select-message", function(e) {
        $(this).closest("li").toggleClass("selected"), setToggleTopicLabel()
    }), $(document).on("click", ".notification-container .messages-list .select-message", function(e) {
        $(this).closest("li").toggleClass("selected"), setToggleNotificationLabel()
    }), $(document).on("click", ".topic-container .messages-list .toggle-messages", function(e) {
        $(".messages-list").find("input:checkbox:checked").size() > 0 ? ($(".messages-list").find("input:checkbox").closest("li.row").removeClass("selected"), $(".messages-list").find("input:checkbox").prop("checked", !1)) : ($(".messages-list").find("input:checkbox").closest("li.row").addClass("selected"), $(".messages-list").find("input:checkbox").prop("checked", !0)), setToggleTopicLabel(), e.preventDefault()
    }), $(document).on("click", ".notification-container .messages-list .toggle-messages", function(e) {
        $(".messages-list").find("input:checkbox:checked").size() > 0 ? ($(".messages-list").find("input:checkbox").closest("li.row").removeClass("selected"), $(".messages-list").find("input:checkbox").prop("checked", !1)) : ($(".messages-list").find("input:checkbox").closest("li.row").addClass("selected"), $(".messages-list").find("input:checkbox").prop("checked", !0)), setToggleNotificationLabel(), e.preventDefault()
    }), $(".navbar-nav .nav-notification").click(function() {
        $.ajax({
            "url": "/notifications/markAllRead",
            "type": "POST",
            "success": function(data) {
                $(".notification-badge").remove()
            }
        })
    }), $.fn.loadSelectizeForMessage = function(inputField) {
        var REGEX_EMAIL = "([a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)";
        $(inputField).selectize({
            "persist": !1,
            "maxItems": null,
            "valueField": "id",
            "labelField": "name",
            "searchField": ["name", "email"],
            "dropdownParent": null,
            "options": [{
                "id": 10,
                "email": "followers@rezdy.com",
                "name": "Followers"
            }, {
                "id": 11,
                "email": "bookmarked@rezdy.com",
                "name": "Bookmarked"
            }, {
                "id": 12,
                "email": "preferred@rezdy.com",
                "name": "Preferred Agents"
            }, {
                "id": 13,
                "email": "hugo@rezdy.com",
                "name": "Hugo Tours"
            }, {
                "id": 14,
                "email": "simon@rezdy.com",
                "name": "Simon Activities"
            }, {
                "id": 15,
                "email": "jerome@rezdy.com",
                "name": "Jerome Lessons"
            }],
            "render": {
                "item": function(item, escape) {
                    return "<div>" + (item.name ? "<span class='name strong'>" + escape(item.name) + "</span> " : "") + "</div>"
                },
                "option": function(item, escape) {
                    var label = item.name || item.email,
                        caption = item.name ? item.email : null;
                    return "<div><small class='fr'>" + escape(caption) + "</small>" + (caption ? "<span class='strong'>" + escape(label) + "</span>" : "") + "</div>"
                }
            },
            "createFilter": function(input) {
                var match, regex;
                return regex = new RegExp("^" + REGEX_EMAIL + "$", "i"), (match = input.match(regex)) ? !this.options.hasOwnProperty(match[0]) : (regex = new RegExp("^([^<]*)<" + REGEX_EMAIL + ">$", "i"), !!(match = input.match(regex)) && !this.options.hasOwnProperty(match[2]))
            },
            "create": function(input) {
                if (new RegExp("^" + REGEX_EMAIL + "$", "i").test(input)) return {
                    "email": input
                };
                var match = input.match(new RegExp("^([^<]*)<" + REGEX_EMAIL + ">$", "i"));
                return match ? {
                    "email": match[2],
                    "name": $.trim(match[1])
                } : (alert("Invalid email address."), !1)
            }
        })
    }, $.fn.initSelectize = function() {
        $("select:not(.noselectize)").each(function() {
            $(this).find("option").length > 15 && $(this).selectize({
                "create": !1,
                "dropdownParent": "body",
                "plugins": {
                    "clear_selection": {}
                }
            })
        })
    }, $.fn.createDestinationTypeahead = function(shouldShowGeolocation, shouldShowGeolocationPrompt) {
        var remoteUrl = "/site/searchDestinations?term=%QUERY";
        const geolocationIcon = '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#0345D1"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm8.94 3c-.46-4.17-3.77-7.48-7.94-7.94V1h-2v2.06C6.83 3.52 3.52 6.83 3.06 11H1v2h2.06c.46 4.17 3.77 7.48 7.94 7.94V23h2v-2.06c4.17-.46 7.48-3.77 7.94-7.94H23v-2h-2.06zM12 19c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7z"/></svg>';
        var typeaheadHeader = "";
        shouldShowGeolocation ? remoteUrl += "&geolocation=1" : shouldShowGeolocationPrompt && (typeaheadHeader = '<a onclick="$.fn.showGeoLocation();"> <span>' + geolocationIcon + "<strong> Let Rezdy use my current location? </strong></span></a>");
        var bhSearchDestinations = new Bloodhound({
            "remote": remoteUrl,
            "rateLimitWait": 800,
            "datumTokenizer": Bloodhound.tokenizers.obj.whitespace("name"),
            "queryTokenizer": Bloodhound.tokenizers.whitespace,
            "limit": 10
        });
        bhSearchDestinations.initialize();
        var destinationTypeahead = $(".destination-typeahead").typeahead({
            "minLength": 1,
            "highlight": !0,
            "hint": !0,
            "autoselect": "first"
        }, {
            "name": "destinations",
            "source": bhSearchDestinations.ttAdapter(),
            "displayKey": "longName",
            "templates": {
                "header": typeaheadHeader,
                "empty": "<p>No result</p>",
                "suggestion": function(data) {
                    return data.isUserGeolocation ? '<span class="geolocation-typeahead">' + geolocationIcon + "<strong>" + data.longName + "</strong></span>" : (response = '<strong class="block">' + data.name + "</strong>", data.parent1Name && (response += data.parent1Name, data.parent2Name && (response += ", " + data.parent2Name)), response)
                }
            }
        }).bind("typeahead:selected", function(obj, datum, name) {
            datum.isUserGeolocation ? $.fn.showGeoLocation() : ($("#Destination_id").length ? $("#Destination_id").val(datum.id) : $(this).attr("data-typeahead-valueholder").length && $("#" + $(this).attr("data-typeahead-valueholder")).val(datum.id), $("#destination_lat").val(datum.latitude), $("#destination_lon").val(datum.longitude), $("#main-search-form").length && ($.fn.setDestinationSearchAsGeolocation(!1), $.fn.toggleClearButton($(".clear-marketplace-product-filters")), $.fn.resetSearchWhenProductId(), $("#main-search-form").submit()))
        });
        if (shouldShowGeolocation && destinationTypeahead.data("ttTypeahead")) {
            var TTDropdown = destinationTypeahead.data("ttTypeahead").dropdown;
            TTDropdown.getDatumForTopSuggestion = function() {
                return TTDropdown.getDatumForSuggestion(TTDropdown._getSuggestions().eq(1))
            }
        }
        $(".destination-typeahead").change(function() {
            "" == $(this).val() && ($("#Destination_id").length ? $("#Destination_id").val("") : $(this).attr("data-typeahead-valueholder").length && $("#" + $(this).attr("data-typeahead-valueholder")).val(""))
        })
    }, $.fn.DestinatioTypeahead = function() {
        var url = new URL(window.location.href),
            isNewSearch = url.searchParams.get("newSearch") || url.searchParams.get("allowNewSearch");
        navigator.permissions ? navigator.permissions.query({
            "name": "geolocation"
        }).then(function(result) {
            var shouldShowGeolocation = "granted" === result.state && isNewSearch,
                shouldShowGeolocationPrompt = "prompt" === result.state && isNewSearch;
            $.fn.createDestinationTypeahead(shouldShowGeolocation, shouldShowGeolocationPrompt)
        }) : $.fn.createDestinationTypeahead(window.canUserLocationBeUsed && isNewSearch, !1)
    }, $.fn.DestinatioTypeahead(), $.fn.displayCCIcon = function(cardNumber, supplierId, acceptedCreditCardTypes) {
        var cardNumberStr = cardNumber.toString(),
            cardType = "";
        /^5[1-5]|^2(?:2(?:2[1-9]|[3-9]\d)|[3-6]\d\d|7(?:[01]\d|20))/.test(cardNumberStr) ? ($(".creditcard-container").find(".creditcard-icon").attr("src", "data:image/png;base64,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"), cardType = "MASTERCARD") : /^4/.test(cardNumberStr) ? ($(".creditcard-container").find(".creditcard-icon").attr("src", "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAADgklEQVR4Ae3VA5zfShiF4e/atm3btm1btW3ba5vdtmvbtm1bxXsz2Zo/1O3zN3PmTDIR5aSTTrrpMYcZK+xye81dC9rW2OU2HMqbmUtBq4FTfv9dz7msEOX0O61+La7o4HBrbu3j0kfsR8sr3/nacoR8MSh0vbzxk78HR8iPoyJ8VQA3jpDvhod7yRu/hA0EKHeAsK8h7Q/ImgvdNWwTFlfL35NiWGWdQ2VtF7NWpTF1eQqt7X0o+SVtjJmXyCf/BPPT6Ei8QivZpr6ph9lr0hkyPY7krKa9BPg5aCBAbzF9cWOpmCswXyBxAts897o7IoP4d3gQCRlNiEzmvAtWogQk1CNnr0FkOiKzERnMZ1+4ss3vIyMQmYrIBIaMCt8jwB5T8PngJKa+LpD2JEpqRitygQEiS6gsb2d9QDkiM3nrOz+Um+62RmQW01anoSwwzsTJqwSlvqGHc2+2QM5YicgyXvjM68ABDK2aETHAf9nLQA/j5+UjMo0HX3NHGTUzDpEpDNcelfMuUeEWMmhmPLtbrFUvMoeXP/XkggftOPMOKzo7+/cfoLyqBTnNg7vvnQ99KTzwToherZN7IcorX/nodc/bOuJRC5IQmTdQ/9XGWHgUsc2dzzojspT4lHpe/cEPkcXEJ9XtP4Dy0FvuyBkmDBoZjlxmxOX327LNtU85IbIAN63mbdz8yrj6ObWxJfpGSuu7yc1t1oPdsrW570ZE6MGNbXIOHGDYlBh9zs68wVKvd/T0WJSKyk7kalPknNXavtGIsnnzlu1HgtxujcgMXByzmLY0FZFFnHGVCWfeaskpV5voAf8aF3XgAB4+pQOjOXMlcv4aMrXRKIGhlfqozrvNEuXDn/y56ilHxi1K4jXtuWrmxrus8Y2q5uKbzJALDbjzFTdufNmV655w1Nt55DW3AwdoaO7l7Dus9I29pf3xNqstsvQan/poPcqT72/QX4tMQ2Q+lz3hRH1HPwYmmfqh+sTHG9imvLoTudgAucKYtta+/QdQisraSdRqbmrpZZsabW5jU+qpqOlC6e7dRHxaA57BFcSnN7JlyxaUdK2xuNQGahu62VmBNk3JmY30aL/bFuDIL8VH/GT08re+Nhwhnw8KWSen3Gb5kzqEDreGph4uetBuhCjXPWQ3aYFZVpuBXW79UvOsykN5W2ObW7fUOqfjticdF8hJJ52k+R9VpTa6bu/xNgAAAABJRU5ErkJggg=="), cardType = "VISA") : /^3[47]/.test(cardNumberStr) ? ($(".creditcard-container").find(".creditcard-icon").attr("src", "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAACNElEQVR4Ae1VA6wdURB9sdPYSRXUtoPa9q9t27Ztt9+2bds2Y5/uyctUD9Giusnk3tGZczG7pv/j//g/uq93HNd1rSP0li5rP401cVBZ8ChNd2HdoQfdRwoB9DwRpZuMuhQvBLYbSmDIQbcdRhMwn8AJj0K8jqmGU3I9TnoUIaKgFZxpu+JXiuTyDnC9zzEfvllNEL/4OK96mQnGnFbsm99lg1jUaT/gZM6T2G8E5Aq8Mhqw4HEapt1JBsGHnI8lEG0EIWtZY/zVBPoJyCL0ccbDsArGsBh1YlGnnVjMYyxJWBJIqeggqARwxqSbSWYinkXUMeFaAtfocyoavRV5F1+DO8Hl9HHGni/5jMfMeymCQR3rXmdh8ZN0DDgbY0FgsFyBnMCPBHh0P+6au5A1d2fvBASDOvMoxLNJQN6A3BFnAv5w7wSWNQvynm2+AbFTZx6FeBJrQUD/LrBNgDvTvBuYw7oD9rtaEGCC5t0QnNtCAui/z5IAd6J5NySWtpEA+u21QUDrbngZXSVfQgsCvEfNu2G1EsO6A/cb2gV8AyTwT/+OhcDUW4mYcTsBy5+mYstbpV8dc3HavQBXfYtxN6gUT8Mr8DamCl8Sa+GWUgefjAYEZDciNI/fgmaE5DbBP6sRXukNcEmuwyelM15FV+FxWDluBZTiglcRjjjnYdv7LKx8moa595PkBHaQAIIzKtFpyUPd5Oxn+RK6bzUN2f/lERW9pd/uzyFDD3kMMv3z4//4CuzuNW5iCJowAAAAAElFTkSuQmCC"), cardType = "AMEX") : /^3(?:0[0-5]|[68])/.test(cardNumberStr) ? ($(".creditcard-container").find(".creditcard-icon").attr("src", "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAE1ElEQVR4Ae2VA7AkSxqFv8yqrr5j21iNnv3e2EZgPXZgbXtHa3ts27Zt23hzVcjN+0dFRa06tN490X8685w6+Uc2/8f/8T8PRQqHDh1qA4wDXuYfh93Ap4BNIsCSEoMoim40adK0ZjbrYQCMAakMkQ07L2EiE49FYMBQMmfQSuG4Dq7rolCyNggDwjCU9WEQUVCQz6NHD28CtQBcuygtoGY2L0tRYRFyrJDLuBxS7PsEgU8URjIr+mzEBUpp8ux+z/NsG4KSPcV2va1NiXBAu67wECMtQEhIfxkQifLQEgdcuv6IpWsvsnnnDQ4fv08aKAedKY3Oq86wDzbgQ12qUrWihzgHGKVQsavCE8NNd2w7ZbV8oYix5Fyx5D/83WFebF6NH3z5LSqUU5y7XMiMhSeZv/ISSmtwPXTW4/cLH7Hn8H2+OaYedauXQok7Kg7+tgBLJJO+H4gQbARhif0Bi1Zd4KUW1Xi+RQ2mzDvB2IHN+N2sY4z+cCu80hlmL7+Om5eH9lwwRRw9dZ/fLczniyOfE2IAjUI5SngSAemOJbeTIYVFxWAiIrn/UO5w07YbjP/SGyxceZFfTzstApZtuEapsllGf6AF89bdt+T2a1Vgtz6ROHi8QMhj820btNK5HQh8n6KiIsnaWIS0T5x8QoWy8ORJACiUVmituXSjgJrV8tDZMignxPiW3DxFqUKu3jaxADAiQNvI4YAICAOKrYB4S/xTvKtxBfzAoWqVLMhBGjJZnm1ZlbfzLZGOyaMCbMP2I7unUiJAIQrEgZwCbMZbIl9ItVbJpjdfqc6uA7f40ID34HrgOg4jP/wuBnRsyNd+eQgTPkSZImwD7RoA3ni+tuxNoEDncsC39vsiIhDlxmix2VZ061iTX0y9QJkyWTq3bkSEon/7BqzYcoG1W84h9mMS8tefrUXX1xvJVSUwoLUSnkRAqiPKjJFHJslcW8umOrXL8tFRzdh96AHTfnaMXQdv2bkicAK0ilBaiG0N7+v+Lnq91YR3NqgI8RUAiEAn9xXIMxtTx+SaTCZDxstSt5Zrozx9O9fDmESc5IOtkiSzVXxGukTEOI5DmlPbDumIMAn5N7/xDSaMH8++ffvIehkUijCM5FkFcSmJVatWMXHCeI4fP8aUyVPicSQmT54McTtOwiT+4h0QB5TGdVxKly3L1772NcaMGUvrNm354hc/z5e+9GUkMUmslfrY0aN88lOfkvYvfv5zBg4ciIon9+zZw8BBAyF2Ldc7kLLd5fr167iuI3e3ZvUaCgsL+eQnP8Fzz7/Agf37ePHFF9m4cSPt27fnypUric0Ak//wB0u8m3r16gMw7rvj+JQVmOsdSP4287IeO3fuxHNdRo8azSD7NUuXLJV/wYmTJvGJj30MSy5X07xZM/bu3ctLL71Iv759LWG99KVTs1ZNEVejZg1AXtbEgWHDhikVdyhfvrz+7ne/e+3ll1+uWblKVTwrIutlJcnCyBDF67R2bIiVcfLZOhVg0k4I0vMP7j9g0aKFN998660Gzd7TLLRXEEGMy5cvf9w68mPXdSvxD4I9/4F15NPNmjXToX1wXFsQw4wbN24hsAkoC5QCHOI5SKD+Rj9HWxACRUC+52Uedu/WzTcWKj8/n38lNP9i/F/A/wX8Ec/+waZMYuorAAAAAElFTkSuQmCC"), cardType = "DINERS") : /^6(?:011|5)/.test(cardNumberStr) ? ($(".creditcard-container").find(".creditcard-icon").attr("src", "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAEI0lEQVR4Ae2UU5gsSRCF/8yuxrVt43Vt2+br2n7a17W9j2vbtnltzNXYM63qzNzq+Kbyq6/v2jr9RZ2ILJwTieY/j//xPxQJLFiwYA/gOmB7/jh8DlwOvAegIlFiWGvrZ8+ZMzabzYJzgFAUDuss1lbDCTucjOMQlhxw8UU5cArw4zhnyefztLW0NADjAAJrbdLA2Fw2G2sLW+cwxlIxFcrlkEollNoh4oLYgFIKAGElmZCHgkwmIzoIagwYY3Ag3dInHoWMh2FFTBjrkuJJQWEvqWrkVXyR7xEjkCJpwErHfV2BsSbqOhKOxGXqnaUWXrjKfUJaKRyCGlP8sAERstKtdE4UFWOqL8i4ny0HIGK1on48ZkUC8qwSnRhBsjAiZimFZc46+2yZhYkTJrD77rvz0MMPM2P6dDZu2sSOO+xIfUM9mzZu5NZth6A3LsNNms/pHzVy0YUXccstt6C0YsiQIYweNZqVq1YCcO3V1zBs6FCSTWsRlZCpFg7LoYhfeP4FsmnW19UB0NLSgrOWpcuWsiEau+H6G0TcHHQGauNS5syezcsvv8TsObPl/VkzZ3H4YYcBRPlMMRWF6MShE4WEtUY2G8DNt95CsViUDwPss+++oKQzpkyZyqWXXyadp165FybP59BDD4u6XRWJHo4CVq9ZzQsvvih5EATU1zegtabc0+VDvfzs08SwQcbtvMuudPf01Kzl1qG1FqaaKx3VQMQKZDz5rgcOKmWeu/Isfy6C1rceJ8bAvU+QXW6tS3yAGCL28COPMHToULq6Ohk6ZCidXV1Sd3Z2MqzK1fGIjzryKH/yPEolwm/fofPDF4gRJIvc7sfgHFt3rH3Oqaec4rtXEeutZiXxPkAfu9bNlJ6/E6cDsIljmCj88VBKosaI9kwfay8sy5A07JfCFbqxC94hfOch7KqvSB9+PkkECGoN/MC6y8c9J7r2RnxOVyt26YeYr17GrP4awhIqCEgNHv6DBvxfMSig1kDN5kIgtU6I07KJyoK3sQvexNWvRimHDlIQ9EelAnRuwM+cAa0gFpefhjiv7d5Z3OY1mG/fwi56OxJeEwnlIsEUKE0M1S+NyuZ+Ygas+95Nhggm6rCIjbq165fglr6P2rAY19FIKtdPxEmlEdG0sMCFIaZUIsZZX/eqILoAMHjwYH1tGDY0NjWOHTVqlD/fqZRGptc6yHdgO1qw7Q3QsgW6mqGcRw8bjx49GR2JyswpaQB0xACZHCrbH9JZVq9fD9Cw6/2fZYyxJoguxNiwYcMlb73x+h1BEAwjRrkAW9bAphVQFe5qhWIvOAtKxIR/NhztTgdXtLW2amMqFVUoFAAYOXKk6u3t7QcMAwYC1TzlX8ND/VD9w7nAACUgn8mkO155+ZXenXbe2ap8Ps9fCc1fjP8N/G/gO/ZqUh52Tg3WAAAAAElFTkSuQmCC"), cardType = "DISCOVER") : /^(?:2131:1800|35)/.test(cardNumberStr) ? ($(".creditcard-container").find(".creditcard-icon").attr("src", "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAEjUlEQVR4Ae2VA7AtxxqFv+6eOcY1Yts2X2zbhejZ78W2bdv2tW37Hl17c6bT+6+ZnI4Lcc6qWe2p9aNBG3y0oQ3Pvv7u3o6DHO2PyEGJDiWqUpHC2rhp39127ta+vpbYWrAQx5ZCFFEoFCkUCxRLdaFAFMdYa/EJYLEkH1IowFppxnHM0uUraGhuaQa6AwROFASyoFuHdvVYQGOJrKUYR+SdaCabY+WqVWQyWXK5PKX/LKnw16GV5ptQUVYuOiQI4tgzIIrFyqJ4B+/3HM91j/Vm3NwV2JpaqKpxrKbX3zdh/rDhND33CuHkOXTMGzoWDO2KihV9HqX/vLE8O+MdFkaNdKjStK9xrNT8c41bsVjRSaFLnVYm3mbyrFqV5boHPmHslBZQCKxSpA5Pf/FlVk6fiUBZwNEqUIpHJ7/D1OVzsV4qrEXmAhOITkrtdyLHXL7AChfqlS7U46Y0oxRYFKKDBTHCsnxGIi4CrQ2jNZOXzUGgQCGUIgzLCMJQdFJqvxOLAc77TEbyDam4bfXCz7lK6y8aGBN4cx4slDnxMPi+CORyIr7KMYmu4JG/7sLUew8GQBvNthdfwKGfvsPufd9m3Wdup+r0I2VxGAaMPuVpxp7xKv2Of5lrd76cA9c4BLCUl5fJvO90UCpSRMUiRcd8Lg9YPAsk7AqFEm8Va+69N9nmeUz42+V07tCZ9R+5iZWPv0NZWZmsOe/jK5i0dBwDT3qVilAzaNGHkh5jlOikCPyOpEFOQOyHDoUX6qRf0aGeWa/0IjO3gZUzWmjY/HDaYTDGoJXi6UOvleWjF4xl1MJhiFggc/hO+3tALIs98YeuOhKLwlrFht3rkpNg0dpgcwW6bL8NVWuuQe2OW7PelI8AS2CMhPnM9y9hx2ePZruuW7Nz913AQhAEjkZ0En4lAsUIf5NNnrmQF248ik3W7cSkucv49wuDAMTLMY8/yc5/+SN7vPkUhYYmFl33IIBsMm00Lx19EwoYOX8MwxcMAZXMadHxUxB5KSh6+opbHuuH2znYimqorsU6UlWN1pqJL7/K3Odfp76o6ZjXyEWkjHi4xv1HUF2mqK/SdKh2c471lZqy0KATHS8FRVoZtV6tCrzUe0NWIpCmw19rLeJlCmURWgSSHuP4bfeAhMZ6iimsVYmIpbYikAik8FeaumqCQAOJqGd4dVgt4u5f0Unpp0DuAvvVx8S2HsWaypBrjlkvjUCrkFVOvIaOd/4fo/05BNVBDRdv/U+M0dg4Fp0U6vIrbyBFFEf2mOOOZsXKDKjECKUSjxVhGFJWYlkoZ9rl2zEgFBqhE5H1SinvolTJu2DJ5/PccutdAOrKy/6jVHom6+rq9J/+8q+GPfbas1vHTh1RSglNEMgDYoxyYqHkMSiJJOEMHE1JWJeElRitVCIKKNKMSp+GxiaeePyZ5pNOPGrtzTbdLAoi72lsamr8e8/PetxjTNCeHwVyAhY3Nzf9e9HChdq1i4F3JOwTjz34BtALqAEqAeOlM4X69v63tkUbyAGrXAqXnH3GyQXrII/Oz0nNz4w2A9oM+BzOyVFHgijeGAAAAABJRU5ErkJggg=="), cardType = "JCB") : ($(".creditcard-container").find(".creditcard-icon").attr("src", "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAAAPFBMVEUAAAAsPU8sPU8sPU85SVrKz9P///97hpFhbntueoawtr2Wnqfl5+ny8/RUYXCjqrK9wsjX295GVWWIkpyb928zAAAAA3RSTlMAcN/DJXJtAAAAtklEQVR4Ad2SVYKEMBAFgdcWt/vfdTPu8jtbWEuFAGH5DdYNL9nW2SeWlzCty8byBt4WyFvwvcBqznOIM/TOlH24FRQ7CCwpH8MbIQAlSQFYDFQlKW4Fgu49aw3wu9DZtcBAlQMBSMfwVuCLII9CBMru2kLyQNuF3t88Q0bf3digCXAzSgR/LTSARuigKAXoYRDy7XfgjInt7l76LtR0I0wiczqGjfnjWnwvfPwfPv5RH//J/8Efl00PY6zdEHUAAAAASUVORK5CYII="), cardType = "");
        var generalTitle = $(".ccv-icon").attr("data-general-title") ? $(".ccv-icon").attr("data-general-title") : "",
            amexTitle = $(".ccv-icon").attr("data-amex-title") ? $(".ccv-icon").attr("data-amex-title") : "";
        if ($(".ccv-icon").attr("src", "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAAAflBMVEUAAAAsPU8sPU8sPU8sPU8sPU9GVWVueoaWnqcsPU8sPU9UYXC9wsj///8sPU97hpH63drseGz3x8Lug3jzpZ3vj4X99PPmSzv86ef0sKnoVkf2vLYsPU/pYlSjqrLKz9M5SVrrbWD50s7xmpHl5+nX297y8/RhbnuIkpywtr0azTnnAAAAD3RSTlMAMHCAYN////8Qz////+/+IdsTAAABF0lEQVR4AcWSAwLkQAAEV4OgNzY3vv9/8GLnjIrTNZ7bj3J/PJ+P+2X8IpRxzih5ncaCKMkAAMiSKJzkbwUzyvtoiG2+MsRD+xI2SPt+EFnVNEDXDBWmZtky2Y2PwrYcuI5n+KoTOB5oOEMet9uDAWYrmDAiwHN0sBgTSfq4PXkvwDY+KvCJVHCOxSCzoFnIsgAfbSMgbJuAqzmB6uSmk/mmn4OFa9pOwjXNoL1ME5kZAHQr3EIZG4p0L0hjUo6Pqt4LyliUJQBQK1Wy0AlVOhplmtYNT0OpxEwnoJLG5a6UoX2GrQB8of2GYSWKRAobHASgjDmP+6qZjIOwocJ3BPwHgSS4JiHtlkoPxmZHtQYJryBt/vf5CulCMitJF1YrAAAAAElFTkSuQmCC"), $(".ccv-icon").attr("title", generalTitle), $("#CreditCard_cardType").length && $("#CreditCard_cardType").val(cardType), $(".cardTypeNotAccepted").html("").addClass("hidden"), "" != cardType && ("AMEX" == cardType && ($(".ccv-icon").attr("src", "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAAAflBMVEUAAAAsPU8sPU8sPU8sPU8sPU9GVWVueoaWnqcsPU8sPU9UYXC9wsj///8sPU97hpH63drseGz3x8Lug3jzpZ3vj4X99PPmSzv86ef0sKnoVkf2vLYsPU/pYlSjqrLKz9M5SVrrbWD50s7xmpHX297l5+lhbnvy8/SIkpywtr108B1RAAAAD3RSTlMAMHCAYN////8Qz////+/+IdsTAAABE0lEQVR4AcXSA8KmYAAE4PQiTLZde/8DflZa77+Tmycn/GxESZYl8bBWCGWcM0qU3VrVdAO3GLqm7vSmhVcscyu0d38V2ub6OhbR1/dBDNtxANfxbPhOEBpk9XwUYRAhjhIvtaMsSkDzV4gkCBID/Avw4RVAErlgJZ6pakmQ+Q0g9BobaAobnOMtyAs4Ado2Q+MsAPLrJWInyuyo86M29dMOrFwAkSL2/ewy+T5aPwNovwBCbmCRQccKPHf078UKWI9DWQUAozWtwFQ/RF/X48zrXO+XAJP++NyTVefXsBUAvtHbD8N6DJWez1iD6+lLzsvbqZmBNVhmwg8A/gMg1Xf6igiCVB+L6x91ESQ/Crn2/zxn2xMug/80ImwAAAAASUVORK5CYII="), $(".ccv-icon").attr("title", amexTitle)), void 0 !== supplierId && acceptedCreditCardTypes)) {
            acceptedCreditCardTypes.split(", ").indexOf(cardType) < 0 && $(".cardTypeNotAccepted").html("Sorry, we don't accept " + cardType + " cards. Only " + acceptedCreditCardTypes + " are accepted.").removeClass("hidden")
        }
    }, $(document).on("blur input paste change", "#CreditCard_cardNumber", function() {
        var ccnumber = $(this).val(),
            supplierId = $("#CreditCard_supplier_id").val(),
            rezdyCreditCardTypes = $("#CreditCard_acceptedCreditCardTypes").length > 0 ? $("#CreditCard_acceptedCreditCardTypes").val() : "";
        "" != ccnumber && ccnumber.indexOf("X") < 0 && $.fn.displayCCIcon(ccnumber, supplierId, rezdyCreditCardTypes)
    }), $(document).on("click", ".sortable-list .fancy", function(e) {
        $(this).closest("li").toggleClass("selected")
    }), $(document).on("click", ".sortable-list .single-select .fancy", function(e) {
        $(this).closest("li").addClass("selected"), $(this).parent("li").siblings().removeClass("selected")
    }), $(document).on("click", ".hideAgentDashboardUpdateNotice .close", function(e) {
        e.preventDefault(), $.ajax({
            "type": "GET",
            "url": "/site/hideAgentDashboardUpdateAjax"
        })
    }), $.fn.validateSocialMedia = function(inputElement, site) {
        var inputVal = inputElement.val();
        inputVal = inputVal.replace(/.*?:\/\//g, "");
        var domainName = inputVal.substring(0, inputVal.indexOf("/") + 1);
        domainName.indexOf(site) >= 0 && (inputVal = inputVal.replace(domainName, ""), inputElement.val(inputVal))
    }, $.fn.youtube_parser = function(url) {
        var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/,
            match = url.trim().match(regExp),
            videoId = !(!match || 11 != match[7].length) && match[7];
        if (videoId) {
            return !!new RegExp("^[a-zA-Z0-9_-]{11}$").test(videoId) && videoId
        }
        return !1
    }, $(document.body).on("initialisePhoneWidgets", function(e) {
        var phoneFields = $('input[data-fieldtype="MOBILE"]:not(.tt-hint):visible, input[data-fieldtype="PHONE"]:not(.tt-hint):visible');
        if (0 != phoneFields.length) {
            var needsInitialising = phoneFields.filter(function(phoneField) {
                    return void 0 === $(phoneField).data("plugin_intlTelInput")
                }),
                intlTelPluginOptions = {
                    "utilsScript": "/themes/rezdyv2/js/libs/utils.js"
                };
            $(needsInitialising).each(function() {
                $(this).val() || (intlTelPluginOptions.initialCountry = $("body").attr("data-rezdy-country-code")), $(this).intlTelInput(intlTelPluginOptions), $(this).on("countrychange change", function(e, countryData) {
                    if (window.intlTelInputUtils) {
                        var isValid = $(this).intlTelInput("isValidNumber"),
                            isEmpty = !$(this).val().length;
                        $("#" + $(this).attr("id")).parent().next("span.phone-widget-validator").remove(), isEmpty || $(isValid ? '<span class="glyphicon glyphicon-ok phone-widget-validator" style="color:LawnGreen">' : '<span class="glyphicon glyphicon-remove phone-widget-validator" style="color:OrangeRed">').insertAfter($("#" + $(this).attr("id")).parent())
                    }
                })
            })
        }
    }), $(document.body).trigger("initialisePhoneWidgets");
    var formUsingIntlTelPlugin = ["order-form", "agents", "contact-form", "form-company", "create-user-form"],
        activeForm = formUsingIntlTelPlugin.filter(function(formId) {
            return void 0 !== document.forms[formId]
        });
    activeForm.length && $(document.body).on("submit", "form#" + activeForm[0], function() {
        var intlTelInputs = $(".intl-tel-input input");
        intlTelInputs.length && intlTelInputs.filter(function() {
            return (this.value || "").trim().length > 0
        }).each(function() {
            var intlInputTelInstance = $(this),
                countryData = intlInputTelInstance.intlTelInput("getSelectedCountryData"),
                value = intlInputTelInstance.intlTelInput("getNumber");
            if (countryData && countryData.dialCode) {
                new RegExp("\\+" + countryData.dialCode).test(value) || (value = "+" + countryData.dialCode + value, intlInputTelInstance.intlTelInput("setNumber", value))
            }
            $(this).val(intlInputTelInstance.intlTelInput("getNumber"))
        })
    })
}(jQuery),
function() {
    "use strict";
    $("body").on("click", ".disableonclick", function() {
        function getYiiFormSettings($form) {
            return void 0 !== $.fn.yiiactiveform && $.fn.yiiactiveform.getSettings($form)
        }
        var $form = $(this).closest("form"),
            hasValidationErrors = function($form) {
                if (getYiiFormSettings($form)) {
                    var successCallback = function($form) {
                            $form.data("valid", !0)
                        },
                        errorCallback = function($form) {
                            $form.data("valid", !1)
                        };
                    $.fn.yiiactiveform.validate($form, successCallback.bind(this, $form), errorCallback.bind(this, $form))
                } else $form.data("valid", !0);
                return $form[0] && $form[0].checkValidity && !$form[0].checkValidity() || !$form.data("valid")
            };
        if ($(this).data("clicked")) return !1;
        if (hasValidationErrors($form)) $(this).addClass("disabled");
        else {
            $(this).data("clicked", !0), $(this).addClass("disabled");
            var settings = getYiiFormSettings($form);
            settings && settings.validateOnSubmit && $form[0].submit()
        }
    })
}(jQuery),
function(window) {
    function CustomEvent(event, params) {
        params = params || {
            "bubbles": !1,
            "cancelable": !1,
            "detail": void 0
        };
        var evt = document.createEvent("CustomEvent");
        return evt.initCustomEvent(event, params.bubbles, params.cancelable, params.detail), evt
    }
    if ("function" == typeof window.CustomEvent) return !1;
    CustomEvent.prototype = window.Event.prototype, window.CustomEvent = CustomEvent, Array.from || (Array.from = function() {
        var toStr = Object.prototype.toString,
            isCallable = function(fn) {
                return "function" == typeof fn || "[object Function]" === toStr.call(fn)
            },
            toInteger = function(value) {
                var number = Number(value);
                return isNaN(number) ? 0 : 0 !== number && isFinite(number) ? (number > 0 ? 1 : -1) * Math.floor(Math.abs(number)) : number
            },
            maxSafeInteger = Math.pow(2, 53) - 1,
            toLength = function(value) {
                var len = toInteger(value);
                return Math.min(Math.max(len, 0), maxSafeInteger)
            };
        return function(arrayLike) {
            var C = this,
                items = Object(arrayLike);
            if (null == arrayLike) throw new TypeError("Array.from requires an array-like object - not null or undefined");
            var T, mapFn = arguments.length > 1 ? arguments[1] : void 0;
            if (void 0 !== mapFn) {
                if (!isCallable(mapFn)) throw new TypeError("Array.from: when provided, the second argument must be a function");
                arguments.length > 2 && (T = arguments[2])
            }
            for (var kValue, len = toLength(items.length), A = isCallable(C) ? Object(new C(len)) : new Array(len), k = 0; k < len;) kValue = items[k], A[k] = mapFn ? void 0 === T ? mapFn(kValue, k) : mapFn.call(T, kValue, k) : kValue, k += 1;
            return A.length = len, A
        }
    }())
}(window);
var MARKETPLACE_SEARCH_FORM_ID = "main-search-form",
    NAMESPACE_EVENT = "rzd_marketplace",
    SUCCESS_SUBMIT_SEARCH = NAMESPACE_EVENT + ".search:success",
    COMPLETE_SUBMIT_SEARCH = NAMESPACE_EVENT + ".search:complete",
    CLICK_SUPPLIER_PROFILE = NAMESPACE_EVENT + ".click",
    AVAILABILITY_LOADED = NAMESPACE_EVENT + ".search:availability",
    PRODUCT_LIKED = NAMESPACE_EVENT + ".productLiked";
! function(window, document, $, undefined) {
    "use strict";
    if (document.forms.length && document.forms[MARKETPLACE_SEARCH_FORM_ID]) {
        var delegateEvent = function(selector, event, childSelector, handler) {
                var is = function(el, selector) {
                        return (el.matches || el.matchesSelector || el.msMatchesSelector || el.mozMatchesSelector || el.webkitMatchesSelector || el.oMatchesSelector).call(el, selector)
                    },
                    elements = document.querySelectorAll(selector);
                Array.from(elements).forEach(function(el, i) {
                    el.addEventListener(event, function(e) {
                        is(e.target, childSelector) && handler(e)
                    })
                })
            },
            handleLikedProducts = function(event) {
                if (event.detail) {
                    var eventName = event.detail.dislike ? "marketplace_product_disliked" : "marketplace_product_liked";
                    window.dataLayer.push({
                        "event": eventName,
                        "productId": parseInt(event.detail.productId, 10)
                    })
                }
            },
            generateDocumentFromString = function(htmlText) {
                return (new DOMParser).parseFromString(htmlText, "text/html")
            },
            formatFilters = function(formData) {
                var fieldsToRename = {
                        "Product[searchString]": "query",
                        "Destination[longName]": "destination",
                        "Product[startDate]": "availabilityDate",
                        "Product[likedFilter]": "onlyLiked",
                        "Product[quantity]": "pax",
                        "Product[orderBy]": "orderBy",
                        "Product[rateFilter]": "rateFilter"
                    },
                    blacklistFields = ["Destination[id]", "options"],
                    fieldsNeedingAggregation = {
                        "Product[productTag][]": undefined,
                        "Product[languages][]": "languages",
                        "Product[catalogId][]": "savedCategories"
                    },
                    simpleMapperReducer = function(accumulator, param) {
                        var paramFragments = param.split("=");
                        if (!paramFragments[1].trim().length) return accumulator;
                        var rawKey = paramFragments[0],
                            key = fieldsToRename[rawKey] || rawKey;
                        return void 0 === accumulator[key] && (-1 !== Object.keys(fieldsNeedingAggregation).indexOf(rawKey) ? accumulator[key] = [] : accumulator[key] = decodeURIComponent(paramFragments[1]).split("+").join(" ")), -1 !== Object.keys(fieldsNeedingAggregation).indexOf(rawKey) && accumulator[key].push(decodeURIComponent(paramFragments[1])), accumulator
                    },
                    blacklistReducer = function(accumulator, current) {
                        return -1 === blacklistFields.indexOf(current) && -1 === Object.keys(fieldsNeedingAggregation).indexOf(current) || delete accumulator[current], accumulator
                    },
                    aggregatorReducer = function(accumulator, current) {
                        if (-1 === Object.keys(fieldsNeedingAggregation).indexOf(current)) return accumulator;
                        var rawValues = accumulator[current],
                            key = fieldsNeedingAggregation[current];
                        if (key) return void 0 === accumulator[key] && (accumulator[key] = rawValues), accumulator;
                        var values = rawValues.reduce(function(acc, curr) {
                            var key = curr.split(":")[0].toLowerCase(),
                                value = curr.split(":")[1].replace(/\+/g, " ").trim();
                            return void 0 === acc[key] && (acc[key] = []), acc[key].push(decodeURIComponent(value)), acc
                        }, {});
                        return Object.assign({}, accumulator, values)
                    },
                    filters = decodeURI(formData).split("&").reduce(simpleMapperReducer, {});
                return filters = Object.keys(filters).reduce(aggregatorReducer, filters), filters = Object.keys(filters).reduce(blacklistReducer, filters)
            },
            searchSuccessHandler = function(event) {
                var futureDom = generateDocumentFromString(event.detail.result),
                    productsNodes = futureDom.querySelectorAll("article[data-product-id]");
                if (futureDom.querySelector(".what-we-found h4")) {
                    var productCount = parseInt(/(\d+)/.exec(futureDom.querySelector(".what-we-found h4").innerText).pop(), 10),
                        data = {
                            "event": "marketplace_search_result",
                            "productCount": productCount
                        };
                    if (data.filters = formatFilters(event.detail.filters), data._clear = !0, !productCount) {
                        window.dataLayer.push({
                            "event": "marketplace_availability_check",
                            "availabilities": [],
                            "_clear": !0
                        });
                        for (var i = 1; i <= 5; i++) data["returned_product_" + i] = {};
                        return void window.dataLayer.push(data)
                    }
                    Array.from(productsNodes).splice(0, 5).forEach(function(product, index) {
                        var payload = {
                            "product_id": product.getAttribute("data-product-id"),
                            "product_code": product.querySelector(".mkt-product-list-view .product-meta p:last-child span").innerText.replace(/\s+/, ""),
                            "supplier_id": product.getAttribute("data-supplier-id"),
                            "supplier_name": product.querySelector(".product-supplier h4 a").innerText.replace(/\s+/, "")
                        };
                        data["returned_product_" + (index + 1)] = payload
                    }), window.dataLayer.push(data)
                }
            },
            handleClickSupplierProfile = function(event) {
                event.detail && window.dataLayer.push({
                    "event": "marketplace_view_supplier_profile",
                    "supplierId": event.detail.supplier_id,
                    "fromProductId": event.detail.product_id
                })
            },
            listenToGlobalAjaxHandlers = function() {
                $(document).ajaxSuccess(function(event, xhr, settings) {
                    if (settings && settings.url) {
                        if (-1 !== settings.url.indexOf("Product_page")) {
                            var pageNumber = parseInt(/Product_page=(\d+)/.exec(settings.url).pop(), 10);
                            window.dataLayer.push({
                                "event": "marketplace_load_more_results",
                                "pageNumber": pageNumber
                            }), document.removeEventListener(SUCCESS_SUBMIT_SEARCH, searchSuccessHandler)
                        } else - 1 !== settings.url.indexOf("marketplace/index") && (document.removeEventListener(SUCCESS_SUBMIT_SEARCH, searchSuccessHandler), document.addEventListener(SUCCESS_SUBMIT_SEARCH, searchSuccessHandler));
                        if (-1 !== settings.url.indexOf("marketplace/orderWizard") && xhr.responseText.trim().length) {
                            var futureDom = generateDocumentFromString(xhr.responseText);
                            if (!futureDom) return;
                            var currentStepElement = futureDom.querySelector(".icon-tabs li.active > a"),
                                currentStep = currentStepElement ? currentStepElement.innerText.trim().toLowerCase() : "";
                            if (!currentStep.length) return;
                            var payload = {
                                "event": "marketplace_booking"
                            };
                            payload.step = currentStep, payload.productId = futureDom.querySelector(".tab-content[data-product-id]").getAttribute("data-product-id"), payload.productCode = futureDom.querySelector(".tab-content[data-product-code]").getAttribute("data-product-code");
                            var orderNumberElement = futureDom.querySelector(".panel-body h3.strong span");
                            payload.orderNumber = "finish" == currentStep && orderNumberElement ? orderNumberElement.innerText : null, window.dataLayer.push(payload)
                        }
                    }
                })
            },
            handleAvailability = function(event) {
                if (event.detail && event.detail.availability && Object.keys(event.detail.availability).length) {
                    var availability = Object.assign({}, event.detail.availability),
                        availabilities = [];
                    Object.keys(availability).forEach(function(productId) {
                        var firstDateAvailable = "N/A";
                        Object.keys(availability[productId]).length && (firstDateAvailable = Object.keys(availability[productId])[0], "timeFormats" === firstDateAvailable && (firstDateAvailable = Object.keys(availability[productId])[1]), "phone" === firstDateAvailable && (firstDateAvailable = Object.keys(availability[productId]).length >= 3 ? Object.keys(availability[productId])[2] : null), availabilities.push({
                            "productId": productId,
                            "nextDateAvailable": firstDateAvailable
                        }))
                    });
                    var resultEvents = window.dataLayer.filter(function(data) {
                            return data.event && "marketplace_search_result" === data.event
                        }).pop(),
                        currentDate = /(\d{4}\-\d{2}\-\d{2})/.exec((new Date).toISOString()).pop();
                    Object.keys(resultEvents).forEach(function(key) {
                        if (/returned_product/.test(key)) {
                            availabilities.filter(function(availability) {
                                return availability.productId === resultEvents[key].product_id
                            }).length || availabilities.push({
                                "productId": resultEvents[key].product_id,
                                "nextDateAvailable": currentDate
                            })
                        }
                    }), window.dataLayer.push({
                        "event": "marketplace_availability_check",
                        "availabilities": availabilities,
                        "_clear": !0
                    })
                }
            },
            initAnalyticsTracking = function() {
                window.dataLayer || (window.dataLayer = []), listenToGlobalAjaxHandlers(), document.addEventListener(CLICK_SUPPLIER_PROFILE, handleClickSupplierProfile), document.addEventListener(PRODUCT_LIKED, handleLikedProducts), document.addEventListener(AVAILABILITY_LOADED, handleAvailability), delegateEvent("body", "click", 'a[href*="/profile/"]', function(event) {
                    var parentContainer = event.target;
                    do {
                        parentContainer = parentContainer.parentNode
                    } while ("div" !== parentContainer.nodeName && !parentContainer.classList.contains("product-pod") && null !== parentContainer.parentNode);
                    document.dispatchEvent(new CustomEvent(CLICK_SUPPLIER_PROFILE, {
                        "detail": {
                            "supplier_id": parentContainer.getAttribute("data-supplier-id"),
                            "product_id": parentContainer.getAttribute("data-product-id")
                        }
                    }))
                }), document.addEventListener(SUCCESS_SUBMIT_SEARCH, searchSuccessHandler)
            };
        window.addEventListener("DOMContentLoaded", initAnalyticsTracking)
    }
}(window, document, jQuery),
function($) {
    function buildTokenHtml(key, value, label) {
        return '<div class="token">' + label + '<a href="#" class="remove-token" tabindex="-1" title="Remove" data-key="' + key + '" data-value="' + value + '">\xd7</a></div>'
    }
    $(document.body).on("click", ".marketplace-cart-counter", function(e) {
        $(".marketplace-cart-flyout").addClass("active"), e.stopPropagation()
    }), $(document.body).on("click", function(e) {
        var cartFlyout = $(".marketplace-cart-flyout");
        cartFlyout.is(e.target) || 0 !== cartFlyout.has(e.target).length || $(".marketplace-cart-flyout").removeClass("active")
    }), $.datetoymd = function(mydate) {
        if (!mydate) return null;
        var yyyy = mydate.getFullYear().toString(),
            mm = (mydate.getMonth() + 1).toString(),
            dd = mydate.getDate().toString();
        return yyyy + "-" + (mm[1] ? mm : "0" + mm[0]) + "-" + (dd[1] ? dd : "0" + dd[0])
    }, $(".flyout-trigger").on("click", function(e) {
        $(".flyout-panel").toggleClass("fadeInUp"), $(".flyout-panel").toggleClass("hide"), $(".flyout-trigger > .fa").toggleClass("rotate180"), e.preventDefault()
    }), $(".list-toggler").on("click", function(e) {
        $("body#operations").removeClass("kiosk"), $("body#operations").removeClass("mp-admin"), $("body#operations").addClass("mp-list"), $(".container.target").removeClass("hide"), $(".container.target").removeClass("container-fluid"), $(".marketplace-toolbar .liked-products").show(), $(".map-view").remove(), $(".product-filters .date-filter").show(), $(".product-filters .categories-filter").show(), e.preventDefault()
    }), $(".kiosk-toggler").on("click", function(e) {
        $("body#operations").removeClass("mp-admin"), $("body#operations").removeClass("mp-list"), $("body#operations").addClass("kiosk", !0), $(".container.target").removeClass("hide"), $(".container.target").addClass("container-fluid"), $(".marketplace-toolbar .liked-products").show(), $(".map-view").remove(), $(".product-filters .date-filter").show(), $(".product-filters .categories-filter").show(), e.preventDefault()
    }), $(".admin-toggler").on("click", function(e) {
        $("body#operations").removeClass("kiosk"), $("body#operations").removeClass("mp-list"), $("body#operations").addClass("mp-admin", !0), $(".container.target").removeClass("hide"), $(".container.target").removeClass("container-fluid"), $(".marketplace-toolbar .liked-products").show(), $(".map-view").remove(), $(".product-filters .date-filter").show(), $(".product-filters .categories-filter").show(), e.preventDefault()
    }), $(document.body).on("click", ".marketplace-cart-action-checkout", function(e) {
        $.fn.closeCartFlyout()
    }), $(document.body).on("click", ".marketplace-cart-item-remove", function(e) {
        var productId = $(this).attr("data-product-id");
        $.fn.removeProductFromCart(productId)
    }), $(document.body).on("click", ".add-cart-button", function(e) {
        e.preventDefault();
        var productId = $(this).attr("data-product-id");
        $.fn.addProductToCart(productId)
    }), $.fn.closeCartFlyout = function() {
        $(".marketplace-cart-flyout").removeClass("active")
    }, $.fn.populateCart = function(response) {
        var count = response.totalNumberOfItems,
            prodString = count > 1 ? "Products" : "Product";
        $(".badge-counter").text(count), $(".cart-flyout-count").text(count + " " + prodString);
        var cartItemContentHtml = "",
            cartActionContentHtml = "",
            items = response.items;
        if (items && items.length > 0) {
            items[0].product.id;
            $.each(items, function(index, item) {
                var product = item.product || {},
                    imageUrl = product.imageUrl ? product.imageUrl : "/themes/rezdyv2/images/no-image.jpg";
                cartItemContentHtml += '<div class="marketplace-cart-item" data-product-id="' + product.id + '">', cartItemContentHtml += '<figure class="marketplace-cart-item-product-img">', cartItemContentHtml += '<img src="' + imageUrl + '"/>', cartItemContentHtml += "</figure>", cartItemContentHtml += '<div class="marketplace-cart-item-product-details">', cartItemContentHtml += '<div class="marketplace-cart-item-title-header">', cartItemContentHtml += '<div class="marketplace-cart-item-title-product-name">' + product.name + "</div>", cartItemContentHtml += '<img src="/themes/rezdyv2/images/bin.svg" alt="remove item icon" class="marketplace-cart-item-remove" data-product-id="' + product.id + '">', cartItemContentHtml += "</div></div>", cartItemContentHtml += $.fn.addProductAdvertisedPrice(product.formattedPrice), cartItemContentHtml += '<i class="fa fa-circle-o-notch fa-spin" aria-hidden="true" style="display: none;"></i>', cartItemContentHtml += "</div>", cartItemContentHtml += '<div style="border-bottom: 1px solid #f2f6fd;"></div>'
            }), cartActionContentHtml += "<br/>", cartActionContentHtml += '<a href="/marketplace/loadMpCheckoutAjax" class="target-modal no-loading-text no-tab-index no-icon marketplace-cart-action-btn marketplace-cart-action-checkout">', cartActionContentHtml += '<span class="marketplace-cart-action-label no-tab-index">Checkout</span>', cartActionContentHtml += "</a>"
        } else cartItemContentHtml = "<div>No products in cart</div>";
        $(".marketplace-cart-item-list").html(cartItemContentHtml), $(".marketplace-cart-more-action").html(cartActionContentHtml)
    }, $.fn.addProductAdvertisedPrice = function(formattedPrice) {
        return formattedPrice ? '<div class="marketplace-cart-item-footer"> <div class="marketplace-cart-item-total">From ' + formattedPrice + '</div> <div class="marketplace-cart-item-total-label">per person</div> </div>' : ""
    }, $.fn.updateAddToCartBtnState = function(response) {
        var addCartButtons = $(".add-cart-button");
        addCartButtons && addCartButtons.each(function() {
            var addCartButton = $("#" + this.id),
                resp = response || {},
                items = resp.items || [],
                productId = addCartButton.attr("data-product-id"),
                notValidProductType = addCartButton.attr("data-product-not-valid-product-type"),
                notValidCurrency = items.length > 0 && items[0].product.currency !== addCartButton.attr("data-currency"),
                productNotNegotiated = addCartButton.attr("data-product-not-negotiated"),
                productAlreadyExist = items.find(function(item) {
                    return item.product.id === Number(productId)
                }),
                prodAvailabilityElement = $(".product-availability[data-product-id='" + productId + "']"),
                isDateAvailable = 0 === prodAvailabilityElement.length || "1" === prodAvailabilityElement.attr("date-is-available");
            notValidProductType || notValidCurrency || productNotNegotiated || productAlreadyExist || !isDateAvailable ? $(addCartButton).addClass("disabled") : $(addCartButton).removeClass("disabled")
        })
    }, $.fn.fetchCartItems = function() {
        $(".marketplace-cart-item-list").html('<div style="text-align: center;"><i class="fa fa-circle-o-notch fa-spin fa-3x"></i></div>'), $.ajax({
            "url": "/marketplace/fetchCartItemsAjax",
            "dataType": "json",
            "beforeSend": function() {},
            "success": function(response, status) {
                status && "success" === status && response && ($.fn.populateCart(response), $.fn.updateAddToCartBtnState(response))
            },
            "error": function() {
                $(".marketplace-cart-item-list").html("<div>Error loading cart.</div>")
            }
        })
    }, $.fn.getCurrency = function(elementId) {
        return $(elementId).attr("data-currency")
    }, $.fn.removeProductFromCart = function(id) {
        $(".marketplace-cart-item[data-product-id='" + id + "'] > .marketplace-cart-item-remove").hide(), $(".marketplace-cart-item[data-product-id='" + id + "'] > .fa-circle-o-notch").show(), $.ajax({
            "url": "/marketplace/removeProductFromCartAjax",
            "data": {
                "productId": id
            },
            "dataType": "json",
            "beforeSend": function() {},
            "success": function(response, status) {
                status && "success" === status && ($.fn.populateCart(response), $.fn.updateAddToCartBtnState(response))
            },
            "error": function() {
                $(".marketplace-cart-item[data-product-id='" + id + "'] > .fa-circle-o-notch").hide(), $(".marketplace-cart-item[data-product-id='" + id + "'] > .marketplace-cart-item-remove").show()
            }
        })
    }, $.fn.addProductToCart = function(productId) {
        var elementId = "add-cart-" + productId;
        $("#" + elementId).addClass("disabled"), $.ajax({
            "type": "POST",
            "url": "/marketplace/addProductToCartAjax",
            "data": {
                "productId": productId
            },
            "dataType": "json",
            "beforeSend": function() {},
            "success": function(response, status) {
                if (status && "success" === status) {
                    var basedCurrency = $.fn.getCurrency(elementId);
                    $(".add-cart-button").each(function() {
                        var currentCurrency = $.fn.getCurrency(this.id);
                        basedCurrency !== currentCurrency && $(this).addClass("disabled")
                    }), $.fn.populateCart(response), $.fn.updateAddToCartBtnState(response)
                }
            },
            "error": function() {
                $("#" + elementId).removeClass("disabled")
            }
        })
    }, $(".list-toggler").trigger("click"), $(".marketplace-filter").keyup(function() {
        var t = $(this);
        t.next("span").toggle(Boolean(t.val()))
    }), $(".close-icon").hide($(this).prev("input").val()), $(".close-icon").click(function() {
        $(this).prev("input").val("").focus(), $(this).prev(".destination-typeahead").val("setQuery", "").focus(), $(this).hide()
    }), $(document).on("click", ".btn-search", function(e) {
        $(".flyout-panel").addClass("hide")
    }), enquire.register("screen and (max-width: 736px)", {
        "match": function() {
            $("body#operations").addClass("kiosk").removeClass("mp-admin"), $(".kiosk-toggler").addClass("hide"), $(".flyout-panel").addClass("hide")
        },
        "unmatch": function() {
            $("body#operations").removeClass("kiosk"), $("body#operations").addClass("mp-list"), $(".admin-toggler ").removeClass("hide").removeClass("active"), $(".kiosk-toggler ").removeClass("hide").removeClass("active"), $(".list-toggler ").addClass("active")
        }
    }), enquire.register("screen and (max-width: 1240px)", {
        "match": function() {
            $(".agent-filter").addClass("hide"), $(".collapse-agent-filter").addClass("hide"), $(".modal-search").removeClass("hide")
        },
        "unmatch": function() {
            $(".agent-filter").removeClass("hide"), $(".collapse-agent-filter").removeClass("hide"), $(".modal-search").addClass("hide")
        }
    }), $(".collapse-agent-filter").click(function() {
        $(".agent-filter").toggleClass("off"), $(".agent-filter-fancy").toggleClass("off"), $(".top-notice").toggleClass("off"), $(this).toggleClass("on")
    }), $(".collapse-agent-filter").click(function() {
        $(".agent-filter").toggleClass("off"), $(".agent-filter-fancy").toggleClass("off"), $(".top-notice").toggleClass("off"), $(this).toggleClass("on")
    }), $(".mp-filter-catcher").click(function(evt) {
        evt.stopPropagation(), $(".showsearch").addClass("on")
    }), $(".token-box").click(function(evt) {
        $(".search-keyword").focus()
    }), $(document).click(function() {
        $(".showsearch").removeClass("on")
    }), $(".boot-slider").slider({}), $.buildFancyFilterToken = function(elmt) {
        var thisName = elmt.attr("name"),
            thisValue = elmt.val(),
            thisLabel = elmt.val();
        "text" != elmt.attr("type") && "div" != elmt.attr("type") || (thisValue = "any"), elmt.hasClass("form_date") ? thisLabel = elmt.datetimepicker("getFormattedDate") : "checkbox" != elmt.attr("type") && "radio" != elmt.attr("type") || (thisLabel = elmt.closest("label").text()), "checkbox" != elmt.attr("type") ? $(".token-box").find('.remove-token[data-key="' + thisName + '"]').closest(".token").remove() : $(".token-box").find('.remove-token[data-key="' + thisName + '"][data-value="' + thisValue + '"]').closest(".token").remove(), "checkbox" != elmt.attr("type") && "radio" != elmt.attr("type") && elmt.val() || elmt.hasClass("form_date") || ("checkbox" == elmt.attr("type") || "radio" == elmt.attr("type")) && elmt.is(":checked") ? ($(".token-box").append(buildTokenHtml(thisName, thisValue, thisLabel)), $.cookie("mkt_" + thisName.replace("[", "_").replace("]", ""), thisValue, {
            "expires": 30,
            "path": "/"
        })) : $.cookie("mkt_" + thisName.replace("[", "_").replace("]", ""), null, {
            "expires": 30,
            "path": "/"
        })
    }, $(".fancy-filter").on("change", function() {
        $(this).hasClass("fancy-filter-override") && $(this).is(":checked") && $(".token-box .remove-token").each(function() {
            $.removeFancyFilterToken($(this))
        }), $.buildFancyFilterToken($(this)), $(this).closest("form").submit()
    }), $(".fancy-filter.form_date").on("changeDate", function(ev) {
        $(this).trigger("change")
    }), $.removeFancyFilterToken = function(elmt) {
        elmt.closest(".token").remove(), $('input.fancy-filter[type=checkbox][name="' + elmt.data("key") + '"][value="' + elmt.data("value") + '"]').attr("checked", !1).closest("label").removeClass("active"), $('input.fancy-filter[type=radio][name="' + elmt.data("key") + '"][value="' + elmt.data("value") + '"]').attr("checked", !1).closest("label").removeClass("active"), $('input.fancy-filter[type=text][name="' + elmt.data("key") + '"],input.fancy-filter[type=hidden][name="' + elmt.data("key") + '"]').val(""), $('.fancy-filter.form_date[name="' + elmt.data("key") + '"]').datetimepicker("update", ""), "Product[location]" != elmt.data("key") && "Company[location]" != elmt.data("key") || ($("input#filter-lat").val(""), $("input#filter-lng").val("")), $.cookie("mkt_" + elmt.data("key").replace("[", "_").replace("]", ""), null, {
            "expires": 30,
            "path": "/"
        })
    }, $(".token-box").on("click", ".remove-token", function() {
        if ("Company[location]" == $(this).attr("data-key") || "Product[location]" == $(this).attr("data-key")) {
            var userId = $(this).closest("div.token-box").attr("data-user-id");
            $.cookie("marketplaceLocation" + userId, null, {
                "path": "/"
            }), $("#filter-location").val(""), $("#filter-lat").val(""), $("#filter-lng").val("")
        }
        $.removeFancyFilterToken($(this)), $("#main-search-form").submit()
    }), $("input.quick-filter").on("change", function() {
        $(this).closest("form").submit()
    }), $.fn.toggleClearButton = function(clearFilterClass) {
        var clearFilterClass = clearFilterClass || $(".clear-marketplace-product-filters"),
            showClearButton = !1;
        clearFilterClass.closest("#main-search-form").find(".marketplace-filter-field").each(function() {
            var defaultValue = $(this).attr("data-default-value") || "";
            if ($(this).is("input") && $.trim($(this).val()) != defaultValue || $(this).is("button") && $.trim($(this).text()) != defaultValue) return showClearButton = !0, !1
        }), clearFilterClass.toggleClass("hide", !showClearButton)
    }, $.fn.clearBasicFilters = function(removeCookieNames) {
        $("#main-search-form").trigger("reset"), $(".marketplace-filter").each(function() {
            ($(this).is(":text") || $(this).is(":hidden")) && $(this).val("")
        });
        for (var i = 0; i < removeCookieNames.length; i++) {
            var cookieName = removeCookieNames[i];
            $.fn.removeMarketplaceCookie(cookieName)
        }
    }, $.fn.removeMarketplaceCookie = function(cookieName) {
        var hostnameParts = window.location.hostname.split(".");
        hostnameParts[0] = "";
        var tld = hostnameParts.join(".");
        $.cookie(cookieName, null, {
            "path": "/",
            "domain": tld
        })
    }, $.fn.validateEmail = function(email) {
        return /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(email)
    }, $.fn.submitForm = function(form) {
        $.ajax({
            "type": form.attr("method"),
            "url": form.attr("action"),
            "data": form.serialize(),
            "dataType": "json",
            "beforeSend": function() {},
            "success": function(response, status) {},
            "complete": function() {}
        })
    }, $("#agentsetup").bootstrapWizard({
        "onTabShow": function(tab, navigation, index) {
            var $total = navigation.find("li").length,
                $current = index + 1,
                $percent = $current / $total * 100;
            $("#agentsetup").find("#bar").show(), $("#agentsetup").find(".bar").css({
                "width": $percent + "%"
            })
        },
        "onNext": function(tab, navigation, index) {
            switch ($(".errorMessage").remove(), index) {
                case 1:
                    if (!$("#Company_companyName").val()) return $("#Company_companyName").closest(".controls").append("<div class= 'errorMessage'>Please enter a valid company name</div>"), !1;
                    break;
                case 2:
                    if (!$("#Company_supplierType").val()) return $("#Company_supplierType").closest(".controls").append("<div class= 'errorMessage'>Please select your business type</div>"), !1;
                    break;
                case 3:
                    if (!$("#Company_mailingAddress_addressLine").val()) return $("#Company_mailingAddress_addressLine").closest(".controls").append("<div class= 'errorMessage'>Please enter your address</div>"), !1;
                    if (!$("#Company_mailingAddress_city").val()) return $("#Company_mailingAddress_city").closest(".controls").append("<div class= 'errorMessage'>Please enter your city</div>"), !1;
                    if (!$("#Company_mailingAddress_state").val()) return $("#Company_mailingAddress_state").closest(".controls").append("<div class= 'errorMessage'>Please enter your state</div>"), !1;
                    if (!$("#Company_mailingAddress_postCode").val()) return $("#Company_mailingAddress_postCode").closest(".controls").append("<div class= 'errorMessage'>Please enter your postcode</div>"), !1;
                    if (!$("#Company_mailingAddress_countryCode").val()) return $("#Company_mailingAddress_countryCode").closest(".controls").append("<div class= 'errorMessage'>Please select a country</div>"), !1;
                    var geocoder = new google.maps.Geocoder;
                    addr = $("#Company_mailingAddress_addressLine").val() + " " + $("#Company_mailingAddress_city").val() + " " + $("#Company_mailingAddress_state").val() + " " + $("#Company_mailingAddress_postCode").val() + " " + $("#Company_mailingAddress_countryCode option:selected").text(), geocoder.geocode({
                        "address": addr
                    }, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            var pos = results[0].geometry.location;
                            $("#lat").val(pos.lat()), $("#lng").val(pos.lng())
                        }
                    });
                    break;
                case 4:
                    if (!$("#Company_phone").val()) return $("#Company_phone").closest(".controls").append("<div class= 'errorMessage'>Please provide your contact number</div>"), !1;
                    break;
                case 5:
                    if (!$("#Company_email").val() || !$.fn.validateEmail($("#Company_email").val())) return $("#Company_email").closest(".controls").append("<div class= 'errorMessage'>Please enter a valid email address</div>"), !1;
                    break;
                case 6:
                    $.fn.submitForm($("#form-onboarding"))
            }
            return !0
        }
    }), $.fn.resetSearchWhenProductId = function() {
        var queryParams = new URLSearchParams(window.location.search);
        if (queryParams.get("productIds")) {
            queryParams.delete("productIds");
            var path = 0 === Array.from(queryParams.keys()).length ? window.location.pathname : "?" + queryParams.toString();
            history.replaceState(null, null, path), $("#productIds").val(null)
        }
        if (queryParams.get("supplierId")) {
            queryParams.delete("supplierId");
            var path = 0 === Array.from(queryParams.keys()).length ? window.location.pathname : "?" + queryParams.toString();
            history.replaceState(null, null, path), $("#supplierId").val(null)
        }
    }, $.fn.showGeoLocation = function() {
        function _addInputHiddenField(inputName, inputValue) {
            $("#main-search-form").find('input[name="' + inputName + '"]').length > 0 ? $("#main-search-form").find('input[name="' + inputName + '"]').attr("value", inputValue) : $("<input />").attr("type", "hidden").attr("name", inputName).attr("value", inputValue).appendTo("#main-search-form")
        }
        navigator.geolocation && navigator.geolocation.getCurrentPosition(function(position) {
            position && position.coords && position.coords.latitude && position.coords.longitude && (_addInputHiddenField("lat", position.coords.latitude), _addInputHiddenField("lng", position.coords.longitude)), $("#destination_lat").val(position.coords.latitude), $("#destination_lon").val(position.coords.longitude), $.fn.resetSearchWhenProductId(), $("#main-search-form").submit(), $.fn.setDestinationSearchAsGeolocation(!0), window.canUserLocationBeUsed = !0
        }, function(error) {
            $.fn.resetSearchWhenProductId(), $("#main-search-form").submit()
        }, {
            "enableHighAccuracy": !0,
            "timeout": 5e3,
            "maximumAge": 0
        })
    }, $.fn.displayDestinationSearchInput = function(shouldShowGeolocation) {
        if (void 0 === shouldShowGeolocation) {
            var shouldShowGeolocationElement = $('meta[name="shouldShowGeolocation"]');
            shouldShowGeolocation = !!shouldShowGeolocationElement && JSON.parse(shouldShowGeolocationElement.attr("content"))

        }
        shouldShowGeolocation ? ($("#my-location").removeClass("hide"), $("#destination-search-input").addClass("hide")) : ($("#my-location").addClass("hide"), $("#destination-search-input").removeClass("hide"))
    }, $.fn.setDestinationSearchAsGeolocation = function(shouldShowGeolocation) {
        shouldShowGeolocation ? $('meta[name="shouldShowGeolocation"]').attr("content", "true") : ($('meta[name="shouldShowGeolocation"]').attr("content", "false"), $("#main-search-form").find('input[name="lng"]').remove(), $("#main-search-form").find('input[name="lat"]').remove()), $.fn.displayDestinationSearchInput(shouldShowGeolocation)
    }
}(jQuery),
function($) {
    $(".shareprofile").sharrre({
        "share": {
            "twitter": 0,
            "facebook": !0,
            "linkedin": !0
        },
        "template": '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\n<span class="label label-primary compact mr-sm">{total}</span> Share Profile <span class="caret"></span>\n</button>\n<ul class="dropdown-menu right">\n<li><a href="#" class="share-linkedin">Linkedin <i class="fa fa-linkedin pull-right"></i></a></li>\n                  <li><a href="#" class="share-facebook">Facebook <i class="fa fa-facebook pull-right"></i></a></li>\n                </ul>',
        "enableHover": !1,
        "enableTracking": !0,
        "render": function(api) {
            $(api.element).on("click", ".share-twitter", function() {
                api.openPopup("twitter")
            }), $(api.element).on("click", ".share-facebook", function() {
                api.openPopup("facebook")
            }), $(api.element).on("click", ".share-linkedin", function() {
                api.openPopup("linkedin")
            })
        }
    }), $(".shareprofile.btn-group").on("click", function() {
        $(this).addClass("open")
    }), $(".sharerezdy").sharrre({
        "share": {
            "twitter": !0,
            "facebook": !0,
            "linkedin": !0
        },
        "template": '<a class="dropdown-toggle notification" data-toggle="dropdown" href="#"><i class="fa fa-heart text-error"></i></a><ul class="dropdown-menu right"><li class="header headline text-error text-center">Love Rezdy?<br>&mdash;<br><small>share with your colleagues</small></li><li><a href="#" class="share-linkedin">Linkedin <i class="fa fa-linkedin pull-right"></i></a></li><li><a href="#" class="share-twitter">Twitter <i class="fa fa-twitter pull-right"></i></a></li>                  <li><a href="#" class="share-facebook">Facebook <i class="fa fa-facebook pull-right"></i></a></li></ul>',
        "enableHover": !1,
        "enableTracking": !0,
        "render": function(api) {
            $(api.element).on("click", ".share-twitter", function() {
                api.openPopup("twitter")
            }), $(api.element).on("click", ".share-facebook", function() {
                api.openPopup("facebook")
            }), $(api.element).on("click", ".share-linkedin", function() {
                api.openPopup("linkedin")
            })
        }
    }), $("li.sharerezdy").on("click", function() {
        $(this).addClass("open")
    })
}(jQuery),
function($) {
    var orderTour = new Trip([{
        "sel": $(".order-tour0"),
        "content": "<h4>Order Form Improvements</h4> Order Status, Balance, Internal Notes and Agents have moved and improved. Continue to see how.",
        "animation": "fadeIn",
        "position": "s",
        "showSteps": !0,
        "expose": !0
    }, {
        "sel": $(".order-tour1"),
        "content": "<h4>Log Order Notes</h4> Add note with time and date stamp to the Recent Actions below.",
        "animation": "fadeIn",
        "position": "s",
        "showSteps": !0,
        "expose": !0
    }, {
        "sel": $(".order-tour2"),
        "content": "<h4>Fixed Header</h4> Order Status and Balance are always in view.",
        "animation": "fadeIn",
        "position": "s",
        "showSteps": !0,
        "expose": !0
    }, {
        "sel": $(".order-tour3"),
        "content": "<h4>Improved Agents</h4>Type to search for your agent companies and contacts. Add new contacts on the fly.",
        "animation": "fadeIn",
        "position": "s",
        "expose": !0
    }, {
        "sel": $(".order-tour4"),
        "content": "<h4>Link to Session</h4>Selected sessions are provided with a link to view session details. ",
        "animation": "fadeIn",
        "position": "s",
        "expose": !0
    }, {
        "sel": $(".order-tour5"),
        "content": "<h4>Internal Notes</h4>Internal Notes are now here. ",
        "animation": "fadeIn",
        "position": "s",
        "expose": !0
    }].filter(function(tour) {
        return tour.sel.length
    }), {
        "tripTheme": "dark",
        "showNavigation": !0,
        "showCloseBox": !0,
        "delay": -1,
        "finishLabel": "Finish"
    });
    $(".start-order-tour").on("click", function() {
        orderTour.start()
    });
    var chartTour = new Trip([{
        "sel": $(".chart-tour0"),
        "content": "<h4>New Report Options</h4> There are two reporting views; by order number and by order value with ability to drilldown the chart values.",
        "animation": "fadeIn",
        "position": "s",
        "expose": !0
    }, {
        "sel": $(".chart-tour1"),
        "content": "<h4>Switch Reports</h4>Click this button to toggle between Number of Orders and Value of Orders.",
        "animation": "fadeIn",
        "position": "s",
        "expose": !0
    }, {
        "sel": $(".chart-tour2"),
        "content": "<h4>Drilldown Report Values</h4>Breakdown each value by clicking on a bar. There are 3 levels of breakdown including the current view. Navigate back using the '<i class='fa fa-arrow-left'></i> Previous Level' button positioned top right once a drilldown is performed.",
        "animation": "fadeIn",
        "position": "s",
        "expose": !0
    }], {
        "tripTheme": "dark",
        "showNavigation": !0,
        "showCloseBox": !0,
        "delay": -1,
        "finishLabel": "Finish"
    });
    $(".start-chart-tour").on("click", function() {
        chartTour.start()
    })
}(jQuery);
var animationDelay = 2500;
animateHeadline($(".cd-headline"));
var options = {
    "types": []
};
$.fn.pacSelectFirst = function(input) {
    var inputElement = $("#" + input.id);
    $.fn.initGooglePlacesAutocomplete(input, function(autocomplete) {
        var place = autocomplete.getPlace();
        place && place.geometry && place.geometry.location ? (inputElement.parent().find("#filter-lat").val(place.geometry.location.lat()), inputElement.parent().find("#filter-lng").val(place.geometry.location.lng())) : (inputElement.parent().find("#filter-lat").val(""), inputElement.parent().find("#filter-lng").val(""))
    }), inputElement.on("change", function() {
        $(this).val().length || ($(this).parent().find("#filter-lat").val(null), $(this).parent().find("#filter-lng").val(null))
    })
}, $.fn.googleMapInitialize = function() {
    for (var acInputs = document.getElementsByClassName("search-destination"), i = 0; i < acInputs.length; i++) $.fn.pacSelectFirst(acInputs[i])
}, $("form").on("submit", function() {
    $(".search-destination").each(function() {
        "" == $(this).val && ($(this).parent().find("#filter-lat"), $(this).parent().find("#filter-lng"))
    })
});
var newPickupId = window.newPickupId;
window.initNewInputs = function(root, idNumber) {
        null != idNumber && $(root).find("div[id]").each(function() {
            $(this).attr("id", $(this).attr("id").replace(/\d+/, idNumber))
        }), $(root).find("input, select").each(function(idx, elm) {
            $(this).hasClass("keepValue") || $(this).val(""), null != idNumber && null != $(this).attr("id") && $(this).attr("id", $(this).attr("id").replace(/\d+/, idNumber)), null != idNumber && null != $(this).attr("name") && $(this).attr("name", $(this).attr("name").replace(/\d+/, idNumber)), null != idNumber && null != $(this).attr("data-link-field") && $(this).attr("data-link-field", $(this).attr("data-link-field").replace(/\d+/, idNumber))
        }), $(root).find("input[type=radio][value='0']").each(function(idx, elm) {
            $(this).attr("checked", "checked")
        }), $(root).find("input[type=radio][value='1']").each(function(idx, elm) {
            $(this).removeAttr("checked")
        }), $(root).find(".pickup-time").html($("#time-select").val()), $(root).find(".location-name").focus()
    }, $.fn.calculateMinutesForPickups = function() {
        var tourtime = $("#time-select").val();
        $(".pickups div").each(function() {
            if ($(this).find(".pickup-minutes").length > 0) {
                var minutes = "" != $(this).children(".pickup-minutes").val() ? $(this).children(".pickup-minutes").val() : "0";
                $.fn.calculateMinutes($(this), tourtime, minutes)
            }
        })
    }, $.fn.calculateMinutes = function(inputElement, tourtime, minutes) {
        "" != minutes && "" != tourtime && inputElement.length > 0 && (ctime = moment(tourtime, "h:mm A").subtract(minutes, "minutes").format("h:mm A"), inputElement.find(".pickup-time").html(ctime))
    }, $.fn.googleMapInitialize(), $.fn.calculateMinutesForPickups(), $(".add-location").click(function(e) {
        e.preventDefault(), window.newPickupId = parseInt([].reduce.call(document.querySelectorAll('[name^="PickupLocation["]'), function(acc, current) {
            return /\[(\d+)\]/.exec(current.name)[1]
        }), 10) + 1;
        var parentTr = $(this).parents(".pickup-locations-container").find("ul.pickup-list li:last-child"),
            trCloned = parentTr.clone();
        parentTr.after(trCloned), initNewInputs(trCloned, newPickupId), newPickupId++, $.fn.googleMapInitialize()
    }), $(".pickup-list").on("click", ".remove-location", function(e) {
        e.preventDefault();
        var pickupRows = $(this).parents(".pickup-list").find("li");
        pickupRows.length > 1 ? $(this).parent("li").remove() : initNewInputs(pickupRows, null)
    }), $(document).on("change", "#time-select", function(e) {
        $.fn.calculateMinutesForPickups()
    }), $("body").on("keyup", ".pickup-minutes", function() {
        var tourtime = $("#time-select").val(),
            minutes = $(this).val();
        $.fn.calculateMinutes($(this).parent(), tourtime, minutes)
    }), $(".checkbox-toggler-div").hide(), $(".checkbox-toggler").is(":checked") && $(".checkbox-toggler-div").show(), $(".checkbox-toggler").change(function() {
        $(".checkbox-toggler-div").toggle()
    }), $(".checkbox-toggler-note-div").hide(), $(".checkbox-toggler-note").is(":checked") && $(".checkbox-toggler-note-div").show(), $(".checkbox-toggler-note").change(function() {
        $(".checkbox-toggler-note-div").toggle()
    }), $("[data-toggle='btns'] .btn").on("click", function() {
        var thisBtn = $(this);
        thisBtn.parent().find(".active").removeClass("active"), thisBtn.addClass("active")
    }), $(document).on("click", ".edit-pickup-name", function(e) {
        e.preventDefault(), $(".route-name").focus()
    }),
    function($) {
        var availability = window.availability,
            body = $(document.body);
        $.setAvailability = function(newAvailability) {
            availability = newAvailability
        }, $.getAvailability = function(newAvailability) {
            return window.availability
        }, window.productHasAvailibilityLimitedPerPriceOption = window.productHasAvailibilityLimitedPerPriceOption || function(productContainer) {
            var inventoryMode = productContainer.find("[type=hidden].inventoryMode");
            return inventoryMode.length && ("SESSION_SEATS_PER_PRICE_OPTIONS" == inventoryMode.val() || "SESSION_RESOURCES_PER_PRICE_OPTIONS" == inventoryMode.val())
        }, window.getSelectizeSessionSettings = function() {
            return {
                "create": !1,
                "maxItems": 1,
                "valueField": "id",
                "labelField": "label",
                "searchField": "label",
                "allowEmptyOption": !0,
                "render": {
                    "item": function(item, escape) {
                        return '<div><span class="option-label">' + item.label + " \u2014 <strong>" + item.availability + "</strong></span></div>"
                    },
                    "option": function(item, escape) {
                        var availability = "",
                            priceOpts = [],
                            availability = "";
                        if (item.price) {
                            for (var keys = Object.keys(item.price), i = 0; i < keys.length; i++) {
                                var po = item.price[keys[i]],
                                    priceOpt = '<dt>{{price_label}}</dt><dd class="{{price_availability_state}}">{{price_availability}}</dd>'.replace("{{price_label}}", po.label).replace("{{price_availability_state}}", po.state);
                                priceOpt = priceOpt.replace("{{price_availability}}", 0 !== Math.abs(po.availability) ? Math.abs(po.availability) + " " + po.state : po.state), priceOpts.push(priceOpt)
                            }
                            availability = '<dl class="availability-per-price-options">{{items}}</dl>'.replace("{{items}}", priceOpts.join(""))
                        }
                        return ('<div class="sessiontime-item"><span class="option-label">' + item.label + " \u2014 <strong>" + item.availability + "</strong></span>{{availability}}</div>").replace("{{availability}}", availability)
                    }
                }
            }
        }, $.checkAvailability = function(productId, mydate) {
            var available = !1,
                returnclass = "unavailable",
                productSettings = $("#product-settings-" + productId),
                returndetails = "",
                checkdate = $.datetoymdUtc(mydate);
            if (availability || (availability = window.availability), void 0 != availability[checkdate]) {
                available = !0, returnclass = "available", dayAvailability = 0;
                var productFound = !1;
                $.each(availability[checkdate], function(key, val) {
                    if (void 0 != productId && void 0 != val[productId]) {
                        var onHold = "";
                        val[productId].onHold > 0 && (onHold = ", " + val[productId].onHold + " on hold"), productSettings.find(".isDuration").val() && "DAYS" == productSettings.find(".durationUnit").val() ? returndetails += "All Day : " + val[productId].availability + "\r\n" : returndetails += key + " : " + val[productId].availability + onHold + "\r\n", "Free sale" != val[productId].availability ? dayAvailability += parseInt(val[productId].seatsAvailable) : dayAvailability += 999999, productFound = !0
                    }
                }), dayAvailability <= 0 && (available = productFound, returnclass = productFound ? "full" : "unavailable")
            }
            return [available, returnclass, returndetails]
        }, $.loadAvailability = function(showdate, productId, callback, viewtype) {
            var params = {
                "showdate": showdate,
                "viewtype": "month",
                "productId": productId,
                "availabilityPerPriceOption": window.productHasAvailibilityLimitedPerPriceOption($("#product-settings-" + productId))
            };
            void 0 !== viewtype && (params.viewtype = viewtype), $.ajax({
                "url": "/calendar/availabilityAjax",
                "type": "POST",
                "data": params,
                "dataType": "json",
                "beforeSend": function(xhr) {
                    if (void 0 === showdate) return xhr.abort(), !1;
                    window.availability_loading = !0, $(".rezdy-overlay-loader").addClass("active").show()
                },
                "complete": function() {
                    window.availability_loading = !1, $(".rezdy-overlay-loader").removeClass("active").hide()
                },
                "success": function(jsonResponse) {
                    window.availability = $.extend(!0, window.availability, jsonResponse), $(".rezdy-overlay-loader").removeClass("active").hide(), "function" == typeof callback && callback(jsonResponse)
                }
            })
        }, $.loadDaySessions = function(productId, selectObj, showdate, callback) {
            if (window.productHasAvailibilityLimitedPerPriceOption($("#product-settings-" + productId))) {
                var selectedValue, selectedOption;
                void 0 === selectObj[0].selectize ? (selectedValue = selectObj.val(), !selectedValue && document.getElementsByName(selectObj[0].dataset.initField).length && (selectedValue = document.getElementsByName(selectObj[0].dataset.initField)[0].value), selectObj.val(""), selectObj.find("option").remove(), selectObj.html("")) : (selectedValue = selectObj[0].selectize.getValue(), !selectedValue && document.getElementsByName(selectObj[0].dataset.initField).length && (selectedValue = document.getElementsByName(selectObj[0].dataset.initField)[0].value), selectObj[0].selectize.options.length && $(selectObj[0].selectize.options).each(function(idx, option) {
                    selectObj[0].selectize.removeOption(option.id, !0)
                }), selectObj[0].selectize.removeItem(selectedValue, !0), selectObj[0].selectize.setValue("", !0), selectObj.val(""), selectObj.find("option[selected]").remove(), selectObj.html(""), selectObj[0].selectize.clear(!0), selectObj[0].selectize.clearCache("item"), selectObj[0].selectize.clearCache("template"), selectObj[0].selectize.destroy()), void 0 === selectObj[0].selectize && selectObj.selectize(window.getSelectizeSessionSettings()), $.each(availability[showdate], function(key, val) {
                    if (void 0 !== val[productId]) {
                        var availabilityPerPriceOptionArray = [];
                        for (var poId in val[productId].availabilityPerPriceOption) availabilityPerPriceOptionArray.push(val[productId].availabilityPerPriceOption[poId]);
                        void 0 !== val[productId].availabilityPerPriceOption && availabilityPerPriceOptionArray.sort(function(poA, poB) {
                            return poA.label == poB.label ? 0 : poA.label < poB.label ? -1 : 1
                        });
                        var option = {
                            "id": val[productId].id,
                            "label": availability.timeFormats[key],
                            "price": availabilityPerPriceOptionArray || [],
                            "time": key,
                            "availability": val[productId].availability
                        };
                        option.id == selectedValue && (selectedOption = option), selectObj[0].selectize.registerOption(option), body.data("seats_" + val[productId].id, val[productId].seatsAvailable), body.data("availability_" + val[productId].id, val[productId].availability), body.data("availability_per_price_options_" + val[productId].id, val[productId].availabilityPerPriceOption), body.data("prices_" + val[productId].id, val[productId].price), body.data("hasResources_" + val[productId].id, val[productId].hasResources)
                    }
                });
                var initialValue = selectObj.closest(".form-field").find("input.initialValue").val();
                if (initialValue && selectedOption && (selectObj.val(initialValue), selectObj[0].selectize.setValue(initialValue, !0), selectObj[0].selectize.addItem(initialValue, !0)), !selectObj[0].selectize.getValue() && (!selectedValue || selectedValue && !selectedOption)) {
                    var firstOption = selectObj[0].selectize.options[Object.keys(selectObj[0].selectize.options)[0]];
                    selectObj.val(firstOption.id), selectObj[0].selectize.addItem(firstOption.id, !0), selectObj[0].selectize.setValue(firstOption.id, !0)
                }
                selectedValue && selectedOption && (selectObj.val(selectedValue), selectObj[0].selectize.addItem(selectedValue, !0), selectObj[0].selectize.setValue(selectedValue, !0)), void 0 !== selectedOption && selectObj[0].selectize.updateOption(selectedOption.id, selectedOption), selectObj[0].selectize.refreshOptions(!1)
            } else {
                if (selectObj.html(""), void 0 !== availability[showdate]) {
                    var fragment = document.createDocumentFragment();
                    $.each(availability[showdate], function(key, val) {
                        if (void 0 !== val[productId]) {
                            var onHold = "";
                            val[productId].onHold > 0 && (onHold = ", " + val[productId].onHold + " on hold");
                            var opt = document.createElement("option");
                            opt.value = val[productId].id, opt.textContent = availability.timeFormats[key] + " - " + val[productId].availability + onHold, opt.setAttribute("data-time", key), opt.setAttribute("data-seats-available", val[productId].seatsAvailable), fragment.appendChild(opt), body.data("seats_" + val[productId].id, val[productId].seatsAvailable), body.data("availability_" + val[productId].id, val[productId].availability), body.data("prices_" + val[productId].id, val[productId].price), body.data("hasResources_" + val[productId].id, val[productId].hasResources)
                        }
                    }), selectObj[0].appendChild(fragment)
                } else selectObj.html("<option value>Select a session<option>");
                var initialValue = selectObj.closest(".form-field").find("input.initialValue").val();
                initialValue && selectObj.val(initialValue), selectObj.val() || selectObj.val(selectObj.find("option:first").val()), selectObj.off("change.alert_overbooking"), selectObj.on("change.alert_overbooking", function() {
                    alertOverbooking(selectObj), selectObj.off("change.alert_overbooking")
                }), $(".rezdy-overlay-loader").removeClass("active").hide(), "function" == typeof callback && callback()
            }
        }, body.on("focus.alert_overbooking", '[name^="ItemQuantity"].quantity', function(event) {
            void 0 === $(event.target).attr("data-previous-value") && $(event.target).attr("data-previous-value", parseInt(event.target.value, 10))
        }), body.on("change.alert_overbooking", '[name^="ItemQuantity"].quantity', function(event) {
            var select = $(this).closest(".product-holder").find(".sessiontime.recalculate");
            select && alertOverbooking(select)
        });
        var resetQtyValue = function(selectObj) {
                for (var array = jQuery.makeArray(selectObj.closest(".block-inner").find('[name^="ItemQuantity"].quantity')), index = 0; index < array.length; index++) {
                    const element = array[index];
                    element.value = element.defaultValue
                }
            },
            alertOverbooking = function(selectObj) {
                if (selectObj && selectObj[0]) {
                    var value = void 0 === selectObj[0].selectize ? selectObj.val() : selectObj[0].selectize.getValue();
                    if ("Free sale" !== body.data("availability_" + value)) {
                        var seatsAvailable = parseInt(body.data("seats_" + value), 10),
                            quantity = jQuery.makeArray(selectObj.closest(".block-inner").find('[name^="ItemQuantity"].quantity')).reduce(function(acc, current) {
                                return acc + parseInt($(current).val(), 10)
                            }, 0);
                        if (window.orderNumber) {
                            var initQuantity = jQuery.makeArray(selectObj.closest(".block-inner").find('[name^="ItemQuantity"].quantity')).reduce(function(acc, current) {
                                    return acc + parseInt(void 0 !== $(current).attr("data-previous-value") ? $(current).attr("data-previous-value") : $(current)[0].defaultValue, 10)
                                }, 0),
                                currentQuantity = jQuery.makeArray(selectObj.closest(".block-inner").find('[name^="ItemQuantity"].quantity')).reduce(function(acc, current) {
                                    return acc + parseInt($(current).val(), 10)
                                }, 0);
                            quantity = parseInt(currentQuantity, 10) - parseInt(initQuantity, 10)
                        }
                        if (seatsAvailable < quantity) {
                            var preventOverBooking = $(".form-order").data("prevent-over-booking");
                            $("#overbookingModal").modal("show"), preventOverBooking && resetQtyValue(selectObj)
                        }
                    }
                }
            },
            alertExtraOverBooking = function(event) {
                var isCheckboxAndChecked = "checkbox" === event.target.getAttribute("type") && $(event.target).is(":checked"),
                    isNotCheckbox = "checkbox" !== event.target.getAttribute("type");
                (isCheckboxAndChecked || isNotCheckbox) && isOverbookingExtra(event) && alert("Warning: the selected quantity is more than the number of extra available for this session. You can continue to confirm the overbooking")
            };
        body.on("click", '[type="checkbox"][data-seats-available]', alertExtraOverBooking).on("input", '[type="text"][data-seats-available]', alertExtraOverBooking);
        var extraAvailabilityHandler = function(event) {
            var container = $(event.target).closest(".product-holder"),
                productId = container.attr("data-product-id"),
                sessionId = $(event.target).val();
            if (sessionId && productId) {
                var extrasToUpdate = container.find('[name^="ItemExtra"]').filter("[data-seats-available]"),
                    extraAvailabilityForCurrentProduct = body.data("extras_availability_" + productId) || {};
                extraAvailabilityForCurrentProduct.length && void 0 !== extraAvailabilityForCurrentProduct[sessionId] ? (updateExtrasSeatsAvailable(extrasToUpdate, extraAvailabilityForCurrentProduct[sessionId]), updateSeatsAvailableForExtraPerQuantity.call(event.target)) : getExtrasWithAvailability(productId, sessionId).done(function(response) {
                    $(".rezdy-overlay-loader").removeClass("active").hide();
                    var data = JSON.parse(response);
                    extraAvailabilityForCurrentProduct[sessionId] = data, body.data("extras_availability_" + productId, extraAvailabilityForCurrentProduct), updateExtrasSeatsAvailable(extrasToUpdate, data), updateSeatsAvailableForExtraPerQuantity.call(event.target)
                }).fail(function(err) {
                    console.error(err)
                })
            }
        };
        body.on("change", '.product-holder[data-has-extras-with-limited-availability="1"]:not([data-is-duration="1"]) .sessiontime', extraAvailabilityHandler), body.on("input", "input[data-seats-available]", function(event) {
            var sessionHasChanged;
            if ($(this).closest(".product-holder").attr("data-is-duration")) {
                var startDate = $("#" + $(this).closest(".product-holder").find(".form_availability").attr("data-link-field")),
                    endDate = $(this).closest(".product-holder").find(".duration-end-details .item-endSession-date > select");
                sessionHasChanged = startDate[0].value !== startDate[0].defaultValue || endDate[0].value !== endDate[0].defaultValue
            } else {
                var sessionSelector = $(event.target).closest(".product-holder").find(".sessiontime");
                sessionSelector[0].defaultValue || (sessionSelector[0].defaultValue = sessionSelector[0].value);
                var defaultValue = sessionSelector[0].defaultValue || $(this).closest(".product-holder").find('[id$="initialValue"]').val();
                sessionHasChanged = sessionSelector[0].value !== defaultValue
            }
            var value = event.target.value || 0,
                defaultValue = event.target.defaultValue || 0,
                qty = 0;
            qty += sessionHasChanged ? parseInt(value, 10) : value != defaultValue ? parseInt(value, 10) - parseInt(defaultValue, 10) : 0;
            var seatsAvailable = parseInt($(event.target).attr("data-seats-available"), 10) - qty,
                label = 0 == seatsAvailable ? "Full" : Math.abs(seatsAvailable);
            0 != seatsAvailable && (label += seatsAvailable > 0 ? " remaining" : " overbooked");
            var container = $(event.target).closest(".inputs-row"),
                target = container.find(".extra.right");
            target.text(label), target.removeClass("hide")
        });
        var updateSeatsAvailableForExtraPerQuantity = function(forceCheck) {
            var extrasToUpdate = $(this).closest('.product-holder[data-has-extras-with-limited-availability="1"]').find('[data-extra-price-type="QUANTITY"]');
            if (extrasToUpdate.length) {
                var sessionHasChanged;
                if ($(this).closest(".product-holder").attr("data-is-duration")) {
                    var startDate = $("#" + $(this).closest(".product-holder").find(".form_availability").attr("data-link-field")),
                        endDate = $(this).closest(".product-holder").find(".duration-end-details .item-endSession-date > select");
                    sessionHasChanged = startDate[0].value !== startDate[0].defaultValue || endDate[0].value !== endDate[0].defaultValue
                } else {
                    var sessionSelector = $(this).closest(".product-holder").find(".sessiontime"),
                        defaultValue = sessionSelector[0].defaultValue || $(this).closest(".product-holder").find('[id$="initialValue"]').val();
                    sessionHasChanged = sessionSelector[0].value !== defaultValue
                }
                $(extrasToUpdate).each(function(index, extra) {
                    var seatsAvailable = parseInt($(extra).attr("data-seats-available"), 10),
                        qty = 0;
                    if ($(this).closest(".product-holder").find('[id^="ItemQuantity"].quantity').each(function(index, input) {
                            var qtyHasChanged = $(input)[0].value !== $(input)[0].defaultValue;
                            !sessionHasChanged && qtyHasChanged && (forceCheck || $(extra).is(":checked")) ? qty += parseInt($(input).val() || 0, 10) - parseInt($(input)[0].defaultValue, 10) : sessionHasChanged && (forceCheck || $(extra).is(":checked")) && (qty += parseInt($(input).val() || 0, 10))
                        }), forceCheck || $(extra).is(":checked")) var updatedQty = seatsAvailable - qty;
                    else var updatedQty = seatsAvailable;
                    var label = 0 === updatedQty ? "Full" : Math.abs(updatedQty);
                    0 !== updatedQty && (label += updatedQty > 0 ? " remaining" : " overbooked");
                    var container = $(extra).closest(".inputs-row"),
                        target = container.find(".extra.right");
                    target.text(label), target.removeClass("hide")
                })
            }
        };
        body.on("input", '[id^="ItemQuantity"].quantity:not([data-seats-available])', updateSeatsAvailableForExtraPerQuantity), body.on("click", '[data-extra-price-type="QUANTITY"][data-seats-available]', function(event) {
            if (event.target.checked) updateSeatsAvailableForExtraPerQuantity.call(event.target, !0);
            else {
                var updatedQty = parseInt($(event.target).attr("data-seats-available"), 10),
                    label = 0 === updatedQty ? "Full" : Math.abs(updatedQty);
                0 !== updatedQty && (label += updatedQty > 0 ? " remaining" : " overbooked");
                var container = $(event.target).closest(".inputs-row"),
                    target = container.find(".extra.right");
                target.text(label), target.removeClass("hide")
            }
        }), body.on("change", '.product-holder[data-has-extras-with-limited-availability="1"][data-is-duration="1"] .form_availability [type=hidden], .product-holder[data-has-extras-with-limited-availability="1"][data-is-duration="1"] .sessiontime, .product-holder[data-has-extras-with-limited-availability="1"][data-is-duration="1"] .duration-end-details select:visible:last', function(event) {
            var container = $(event.target).closest(".product-holder"),
                productId = container.attr("data-product-id"),
                startDate = $("#" + container.find(".form_availability").attr("data-link-field")).val(),
                endDate = container.find(".duration-end-details .item-endSession-date > select").val(),
                startSessionId = null,
                endSessionId = null;
            if (container.find('[id^="endSession"]').length) {
                if (startSessionId = container.find('[id^="Session"][id$="id"]')[0].value, endSessionId = container.find('[id^="endSession"][id$="id"]')[0].value, !startSessionId || !endSessionId) return
            } else if (!startDate || !endDate) return;
            var extrasToUpdate = container.find('[name^="ItemExtra"]').filter("[data-seats-available]"),
                keyToUse = startSessionId || startDate,
                extraAvailabilityForCurrentProduct = body.data("extras_availability_" + productId) || {};
            extraAvailabilityForCurrentProduct.length && void 0 !== extraAvailabilityForCurrentProduct[keyToUse] ? (updateExtrasSeatsAvailable(extrasToUpdate, extraAvailabilityForCurrentProduct[keyToUse]), updateSeatsAvailableForExtraPerQuantity.call(event.target)) : getExtrasWithAvailabilityForRental(productId, startDate, endDate, startSessionId, endSessionId).done(function(response) {
                $(".rezdy-overlay-loader").removeClass("active").hide();
                var data = JSON.parse(response);
                extraAvailabilityForCurrentProduct[keyToUse] = data, body.data("extras_availability_" + productId, extraAvailabilityForCurrentProduct), updateExtrasSeatsAvailable(extrasToUpdate, data), updateSeatsAvailableForExtraPerQuantity.call(event.target)
            }).fail(function(err) {
                console.error(err)
            })
        });
        var updateExtrasSeatsAvailable = function(extrasToUpdate, extrasAvailability) {
                extrasToUpdate.length && $(extrasToUpdate).each(function(index, extra) {
                    if ("QUANTITY" == $(extra).attr("data-extra-price-type")) return !0;
                    var extraId = $(extra).closest("li").find('[id$="extra_id"]').val(),
                        container = $(extra).closest(".product-holder"),
                        extraDatum = $(extrasAvailability).filter(function(index, extraData) {
                            return extraData.id == extraId
                        });
                    if (extraDatum.length) {
                        var sessionSelector = container.find(".sessiontime"),
                            defaultValue = sessionSelector[0].defaultValue || $(this).closest(".product-holder").find('[id$="initialValue"]').val(),
                            sessionHasChanged = sessionSelector[0].value !== defaultValue,
                            seatsAvailable = parseInt(extraDatum[0].seatsAvailable, 10);
                        $(extra).attr("data-seats-available", seatsAvailable);
                        var qtyHasChanged = $(extra)[0].value != $(extra)[0].defaultValue;
                        if (sessionHasChanged || qtyHasChanged) {
                            if (!sessionHasChanged && qtyHasChanged) var bookedQty = seatsAvailable - (parseInt($(extra).val(), 10) - parseInt($(extra)[0].defaultValue, 10));
                            else if (sessionHasChanged) var bookedQty = seatsAvailable - parseInt($(extra).val() || 0, 10)
                        } else var bookedQty = seatsAvailable;
                        var label = 0 == bookedQty ? "Full" : Math.abs(bookedQty);
                        0 != bookedQty && (label += bookedQty > 0 ? " remaining" : " overbooked");
                        var container = $(extra).closest(".inputs-row"),
                            target = container.find(".extra.right");
                        target.text(label), target.removeClass("hide")
                    }
                })
            },
            getExtrasWithAvailability = function(productId, sessionId) {
                return $.ajax({
                    "url": "/orders/extrasAvailabilityAjax",
                    "data": {
                        "productId": productId,
                        "sessionId": sessionId
                    },
                    "type": "POST"
                })
            },
            getExtrasWithAvailabilityForRental = function(productId, startTime, endTime, startSessionId, endSessionId) {
                return $.ajax({
                    "url": "/orders/extrasAvailabilityForRentalAjax",
                    "data": {
                        "productId": productId,
                        "startTime": startTime,
                        "endTime": endTime,
                        "startSessionId": startSessionId,
                        "endSessionId": endSessionId
                    },
                    "type": "POST"
                })
            },
            isOverbookingExtra = function(event) {
                var quantity = parseInt(event.target.value, 10),
                    extraConditions = quantity > parseInt(event.target.defaultValue, 10);
                return extraConditions && (quantity -= parseInt(event.target.defaultValue, 10)), event.target.hasAttribute("data-extra-price-type") && (extraConditions = !0, "FIXED" === event.target.getAttribute("data-extra-price-type") ? quantity = 1 : "QUANTITY" === event.target.getAttribute("data-extra-price-type") && (quantity = 0, $(event.target).closest(".product-details-container").find('.quantities input[type="text"].quantity').each(function() {
                    quantity += parseInt($(this).val(), 10), window.orderNumber && (quantity -= parseInt($(this)[0].defaultValue, 10))
                }))), quantity && extraConditions && quantity > parseInt(event.target.getAttribute("data-seats-available"), 10)
            }
    }(jQuery), $(function() {
        $(document).on("keyup focusin", "#Extra_description", function() {
            var len = $(this).val().length;
            $("#descriptionNumChars").text(len)
        }), $("#description").trigger("keyup")
    }), $(document).on("click", ".merge-public-profile", function() {
        var profileId = $(this).data("profile-id"),
            agentSupplierId = $(this).data("id");
        $.ajax({
            "url": "/agents/mergeProfileAjax",
            "type": "POST",
            "data": {
                "profileId": profileId,
                "id": agentSupplierId
            },
            "dataType": "json",
            "success": function(data) {
                data.success ? (window.location.href = "/agents/edit/" + agentSupplierId, $(".matching-profile-div").find(".success-message-container").html(data.message).removeClass("hide"), $(".matching-profile-div").find(".error-message-container").html(data.message).addClass("hide")) : data.message && ($(".matching-profile-div").find(".error-message-container").html(data.message).removeClass("hide"), $(".matching-profile-div").find(".success-message-container").html(data.message).addClass("hide"))
            }
        })
    }), $.fn.updateCompanyFields = function(element, datum) {
        element.val("");
        var marketplaceCatalogId = $("#MarketplaceRateCatalogId").val();
        if ($("#AgentSupplier_existingAgentId").val(""), $("#AgentSupplier_agentCompanyName").val(""), $("#AgentSupplier_resellerCode").val(""), $("#AgentSupplier_firstName").val(""), $("#AgentSupplier_lastName").val(""), $("#AgentSupplier_phone").val(""), $("#AgentSupplier_companyUrl").val(""), $("#AgentSupplier_agent_email").val(""), $("#AgentSupplier_agent_supplierType").val(""), $("#AgentSupplier_agent_mailingAddress_addressLine").val(""), $("#AgentSupplier_agent_mailingAddress_city").val(""), $("#AgentSupplier_agent_mailingAddress_state").val(""), $("#AgentSupplier_agent_mailingAddress_postCode").val(""), $("#AgentSupplier_agent_mailingAddress_countryCode").val(""), $(".agent-users").html("").parents("div").addClass("hide"), datum.hasOwnProperty("id") && $("#AgentSupplier_existingAgentId").val(datum.id), datum.hasOwnProperty("companyName")) {
            $("#AgentSupplier_agentCompanyName").val(datum.companyName);
            var resellerCode = datum.companyName.replace(/[^_a-z0-9]/gi, "").toUpperCase();
            $("#AgentSupplier_resellerCode").val(resellerCode)
        }
        if (datum.hasOwnProperty("firstName") && $("#AgentSupplier_firstName").val(datum.firstName), datum.hasOwnProperty("lastName") && $("#AgentSupplier_lastName").val(datum.lastName), datum.hasOwnProperty("phone") && $("#AgentSupplier_phone").val(datum.phone), datum.hasOwnProperty("companyUrl") && $("#AgentSupplier_companyUrl").val(datum.companyUrl), datum.hasOwnProperty("email") && ($("#AgentSupplier_agent_email").val(datum.email), $("#AgentSupplier_agent_email").typeahead("destroy")), datum.hasOwnProperty("mailingAddress")) {
            var mailingAddress = datum.mailingAddress;
            if (mailingAddress.hasOwnProperty("addressLine") && $("#AgentSupplier_agent_mailingAddress_addressLine").val(mailingAddress.addressLine), mailingAddress.hasOwnProperty("city") && $("#AgentSupplier_agent_mailingAddress_city").val(mailingAddress.city), mailingAddress.hasOwnProperty("state") && $("#AgentSupplier_agent_mailingAddress_state").val(mailingAddress.state), mailingAddress.hasOwnProperty("postCode") && $("#AgentSupplier_agent_mailingAddress_postCode").val(mailingAddress.postCode), mailingAddress.hasOwnProperty("countryCode")) {
                $("#AgentSupplier_agent_mailingAddress_countryCode").val(mailingAddress.countryCode);
                var countrySelectize = $("#AgentSupplier_agent_mailingAddress_countryCode")[0].selectize;
                countrySelectize && countrySelectize.setValue(mailingAddress.countryCode)
            }
        }
        if (datum.hasOwnProperty("supplierType") && ($("#AgentSupplier_agent_supplierType").val(datum.supplierType), $("#AgentSupplier_agent_supplierType").trigger("change")), datum.hasOwnProperty("publicAgentUsers") && $(".agent-users").html(datum.publicAgentUsers).parents("div").removeClass("hide"), $(".agent-type-container").addClass("hide"), $(".preferred-agent-permissions").toggleClass("hide", $("#AgentSupplier_catalog_id").val() == marketplaceCatalogId), datum.hasOwnProperty("apiName") || isFullPaymentNonOTA(datum)) {
            $("#rezdy-price-ota").length && handleOTAPriceOptIn(datum), $("#AgentSupplier_agent_supplierType").val("Online Travel Agency"), $("#AgentSupplier_agent_supplierType").trigger("change"), $('#AgentSupplier_catalog_id option[value="' + marketplaceCatalogId + '"]').remove(), $("#AgentSupplier_catalog_id").trigger("change");
            var agentPayment = document.getElementById("AgentSupplier_agentPayment");
            Array.from(agentPayment.options).filter(function(opt) {
                return opt.hasAttribute("disabled")
            }).forEach(function(opt) {
                opt.removeAttribute("disabled")
            }), Array.from(agentPayment.options).filter(function(opt) {
                return "FULL_AGENT" !== opt.value
            }).forEach(function(opt) {
                opt.setAttribute("disabled", "disabled")
            }), agentPayment.value = "FULL_AGENT", $(agentPayment).trigger("change"), $(".preferred-agent-permissions").addClass("hide")
        }
        $(".agent-container .companyFields").each(function() {
            if ($(this).is(":text") && $(this).attr("readonly", !0), $(this).is("select"))
                if ($(this).hasClass("selectized")) {
                    var select = $(this).selectize(),
                        selectize = select[0].selectize;
                    selectize.disable()
                } else $(this).attr("disabled", "disabled");
            $(".notOverrideWarning").removeClass("hide")
        })
    }, $.fn.initAutocompleteFields = function() {
        if (!$("[data-editing-marketplace-agent]").length) {
            var bhSearchAgentsByCompany = new Bloodhound({
                "remote": "/agents/listAgentsAjax?term=%QUERY",
                "rateLimitWait": 800,
                "datumTokenizer": Bloodhound.tokenizers.obj.whitespace("companyName"),
                "queryTokenizer": Bloodhound.tokenizers.whitespace
            });
            bhSearchAgentsByCompany.initialize(), $("#AgentSupplier_agentCompanyName").typeahead({
                "minLength": 3,
                "highlight": !0,
                "hint": !1
            }, {
                "name": "agentsByCompany",
                "source": bhSearchAgentsByCompany.ttAdapter(),
                "displayKey": "companyName",
                "templates": {
                    "header": function(query) {
                        return "<a href='#' class='tt-dismiss pull-right pr-sm pt-sm' title='Dismiss'><i class='fa fa-times'></i></a>" + (query && query.isEmpty ? "" : "<h3 class='clear clearfix pd-sm text-primary'>Check if your agent already has a public profile.</h3>")
                    },
                    "empty": function() {
                        return "<p class='empty'>No result</p>"
                    },
                    "suggestion": function(data) {
                        var companyName = "",
                            supplierType = "Unknown",
                            email = "";
                        return data.hasOwnProperty("companyName") && data.companyName && (companyName = data.companyName), data.hasOwnProperty("email") && data.email && (email = data.email), data.hasOwnProperty("supplierType") && data.supplierType && (supplierType = data.supplierType), "<p><span class='block'>" + companyName + "</span><span class='block'> " + supplierType + "</span><span class='block'><small>E:</small> " + email + "</span></p>"
                    }
                }
            }).bind("typeahead:selected", function(obj, datum, name) {
                $.fn.updateCompanyFields($(this), datum), datum.hasOwnProperty("apiName") && "GOOGLE" === datum.apiName && (window.location.href = "/agents/new/" + datum.id + "?apiCompany=")
            });
            var bhSearchAgentsByEmail = new Bloodhound({
                "remote": "/agents/listAgentsAjax?term=%QUERY&byEmail=1",
                "rateLimitWait": 800,
                "datumTokenizer": Bloodhound.tokenizers.obj.whitespace("email"),
                "queryTokenizer": Bloodhound.tokenizers.whitespace
            });
            bhSearchAgentsByEmail.initialize(), $("#AgentSupplier_agent_email").typeahead({
                "minLength": 3,
                "highlight": !0,
                "hint": !1
            }, {
                "name": "agentsByEmail",
                "source": bhSearchAgentsByEmail.ttAdapter(),
                "displayKey": "email",
                "templates": {
                    "header": function(query) {
                        return "<a href='#' class='tt-dismiss pull-right pr-sm pt-sm' title='Dismiss'><i class='fa fa-times'></i></a>" + (query && query.isEmpty ? "" : "<h3 class='clear clearfix pd-sm text-primary'>Check if your agent already has a public profile.</h3>")
                    },
                    "empty": function() {
                        return "<p class='empty'>No result</p>"
                    },
                    "suggestion": function(data) {
                        var companyName = "",
                            supplierType = "Unknown",
                            email = "";
                        return data.hasOwnProperty("companyName") && data.companyName && (companyName = data.companyName), data.hasOwnProperty("email") && data.email && (email = data.email), data.hasOwnProperty("supplierType") && data.supplierType && (supplierType = data.supplierType), "<p><span class='block'>" + email + "</span><span class='block'>" + companyName + "</span><span class='block'> " + supplierType + "</span></p>"
                    }
                }
            }).bind("typeahead:selected", function(obj, datum, name) {
                $.fn.updateCompanyFields($(this), datum)
            })
        }
    }, $.fn.initAutocompleteFields(), $(document).on("change", "#AgentSupplier_catalog_id", function() {
        $(".catalog-details").html($(".catalog-details-" + $(this).val()).html())
    }), $(".catalog-details").html($(".catalog-details-" + $("#AgentSupplier_catalog_id").val()).html()), $.fn.prepopulateAgentCode = function(element) {
        if ("" != element.val() && "" == $("#AgentSupplier_resellerCode").val()) {
            var companyName = element.val().replace(/[^_a-z0-9]/gi, "").toUpperCase();
            $("#AgentSupplier_resellerCode").val(companyName)
        }
    }, $(document).on("focusout", "#AgentSupplier_agentCompanyName", function() {
        $.fn.prepopulateAgentCode($(this))
    }), $.fn.prepopulateAgentCode($("#AgentSupplier_agentCompanyName")), $(document).on("click", ".accept-marketplace", function() {
        $.ajax({
            "url": "/marketplace/marketplaceAgreementAjax",
            "type": "POST",
            "dataType": "json",
            "success": function(data) {
                data.success && window.location.reload()
            }
        })
    }), $(document).on("click", ".test-invite-agent", function() {
        var form = $("#message");
        $.ajax({
            "data": form.trimSerialize() + "&test=test",
            "type": form.attr("method"),
            "url": form.attr("action"),
            "success": function(data) {
                $(".block-test-invite-agent").find(".send-test").removeClass("block").addClass("hide"), $(".block-test-invite-agent").find(".alert").removeClass("hide")
            }
        })
    }), $(document).on("click", ".invite-to-marketplace", function(e) {
        e.preventDefault();
        var url = $(this).attr("href"),
            isEmptyVal = !1;
        if (isEmptyVal = "" == $("#AgentSupplier_agent_email").val(), $(".mandatoryForMarketplace").each(function() {
                "" == $(this).val() && (isEmptyVal = !0)
            }), isEmptyVal) $(".error-message-container").html("First Name, Last Name and Email are mandatory to invite an agent to the Marketplace.").removeClass("hide");
        else {
            var input = $("<input>").attr("type", "hidden").attr("name", "returnUrl").val(url);
            $("#agents").append($(input)).submit()
        }
    }), $(document).on("click", "#PublicProfile", function(e) {
        var isPrivateAgent = "true" != $(this).val(),
            canOverride = $(this).parents(".agent-type-container").data("override");
        $.ajax({
            "url": "/agents/changeScenario",
            "method": "GET",
            "data": "isPrivateAgent=" + isPrivateAgent + "&canOverride=" + canOverride,
            "success": function(data) {
                $(".agent-information-container").html(data), $.fn.initAutocompleteFields()
            }
        })
    }), $(document).on("click", ".decline-request", function(e) {
        e.preventDefault();
        var btn = $(this),
            agentSupplierId = btn.data("id"),
            agentCompanyId = btn.data("agent-id");
        $.ajax({
            "url": "/agents/declineRequest/" + agentSupplierId,
            "method": "GET",
            "dataType": "json",
            "beforeSend": function() {
                btn.button("loading")
            },
            "success": function(data) {
                btn.button("reset"), data.success ? (btn.removeClass("btn-white decline-request").addClass("btn-grey undecline-request").text("Declined, Undo?").attr("href", "/agents/new/" + agentCompanyId), btn.siblings(".accept-request").remove(), btn.closest(".agent-action-container").find(".message").html(data.message).addClass("text-success").removeClass("hide text-error")) : btn.closest(".agent-action-container").find(".message").html(data.message).addClass("text-error").removeClass("hide text-success"), btn.allowDefault = !0
            }
        })
    }), $(function() {
        function change_people(amt, input) {
            var intRegex = /^\d+$/,
                currentVal = parseInt(input.val(), 10);
            intRegex.test(input.val()) ? 1 == amt && input.attr("min-qty") > 0 && 0 == currentVal ? input.val(parseInt(currentVal + input.attr("min-qty"))) : -1 == amt && input.attr("min-qty") > 0 && currentVal == input.attr("min-qty") ? input.val(0) : 1 == amt && input.attr("max-qty") > 0 && currentVal >= input.attr("max-qty") ? input.val(input.attr("max-qty")) : -1 == amt && input.attr("max-qty") > 0 && currentVal > input.attr("max-qty") ? input.val(input.attr("max-qty")) : input.val(currentVal + amt) : input.val(0), input.trigger("change")
        }
        $(document).off("click", ".increase").on("click", ".increase", function() {
            change_people(1, $(this).parent().find(".input-quantities"))
        }), $(document).off("click", ".decrease").on("click", ".decrease", function() {
            var input = $(this).parent().find(".input-quantities");
            input.val() > 0 && change_people(-1, input)
        }), $(document).on("blur", ".input-quantities", function() {
            /^\d+$/.test($(this).val()) || $(this).val(0)
        })
    });
var loading, startTime;
$(document).on("click", ".form-availability .session-picker td:not(.session-empty)", function(e) {
    e.preventDefault();
    var selectLink = $(this).find("a.session-select-link"),
        sessionId = selectLink.attr("data-sessionid");
    if (sessionId) {
        var isMpCheckout = selectLink.attr("data-is-mp-checkout");
        if (!window.durationSettings || !window.durationSettings.isDuration) {
            if (isMpCheckout) {
                var amountElement = $(this).find("a.session-select-link .price"),
                    productId = selectLink.attr("data-product-id"),
                    startingSessionData = getSessionData(selectLink);
                return void mpUpdateSession(productId, startingSessionData, null, amountElement.attr("data-amount"), null)
            }
            if ($(this).hasClass("session-fade")) return;
            return $("#OrderItem_sessionId").val($(this).find("a.session-select-link").attr("data-sessionid")), $("#availability-form").submit(), !1
        }
        var sessionId = $(this).find("a.session-select-link").attr("data-sessionid");
        if (sessionId) switch (resetWarnings(), durationSettings.selecting) {
            case "start":
                $(this).hasClass("session-fade") || (window.durationSettings.selecting = "end", $(".reset-selection").removeClass("hidden"), $("#OrderItem_sessionId").val(sessionId), loadCalculateEndingSessionsAjax(sessionId), $(this).addClass("active"), $(this).addClass("starting-session"), startTime = $(this).closest("tr").find("th .session-start-time").text());
                break;
            case "end":
                if (!$(this).hasClass("session-fade")) {
                    if (isMpCheckout) {
                        var amountElement = $(this).find("a.session-select-link .session-detail .amount"),
                            sessionDetail = $(this).find("a.session-select-link .session-detail"),
                            date = sessionDetail.attr("data-session-date"),
                            time = sessionDetail.attr("data-session-time"),
                            endAvailability = window.endAvailability[date][time],
                            priceOptions = endAvailability ? endAvailability.quote.usedPriceOptions : [],
                            mpQuantity = $(".mp-quantity"),
                            priceOptionsWithQty = priceOptions.map(function(priceOption) {
                                return Object.assign({
                                    "quantity": mpQuantity.val()
                                }, priceOption)
                            }),
                            amount = amountElement.attr("data-amount"),
                            productId = selectLink.attr("data-product-id"),
                            startingSessionData = getSessionData($(".starting-session a"));
                        return void mpUpdateSession(productId, startingSessionData, getSessionData(selectLink), amount, priceOptionsWithQty)
                    }
                    window.durationSettings.selecting = "finish", "ANY" == durationSettings.durationType ? $("#OrderItem_endSessionId").val(sessionId) : "LIST" == durationSettings.durationType && $("#OrderItem_durationValue").val($(this).find(".durationLabel").attr("data-duration-value")), setLoading(), $(this).addClass("active"), $("#availability-form").submit()
                }
        }
    }
}), $(document).on("change", "#OrderItem_quantity", function(e) {
    qtyChange()
}), $(document).on("click", ".book-now-mp", function(e) {
    e.preventDefault();
    var formData = $("form").serializeArray(),
        data = {
            "preferredDate": null,
            "preferredTime": null,
            "preferredEndDate": null,
            "preferredEndTime": null,
            "productId": null
        },
        isFixedBookingMode = $(this).hasClass("is-fixed"),
        isDurationProduct = $(this).hasClass("is-duration");
    (formData || []).forEach(function(item) {
        "OrderItem[preferredDate]" === item.name && (data.preferredDate = item.value), "OrderItem[preferredTime]" === item.name && (data.preferredTime = item.value), "OrderItem[product][id]" === item.name && (data.productId = item.value), isDurationProduct && ("OrderItem[preferredEndDate]" === item.name && (data.preferredEndDate = new Date(item.value)), "OrderItem[preferredEndTime]" === item.name && (data.preferredEndTime = item.value))
    }), isFixedBookingMode || (data = Object.assign(data, {
        "preferredTime": data.preferredTime ? new Date(data.preferredDate + " " + data.preferredTime + ":00") : null
    })), window.postMessage({
        "type": "MP_UPDATE_NON_INVENTORY",
        "data": data
    }, "*")
}), $(document).on("change", ".quantity-refresh", function(e) {
    var isMpQuantity = $(this).hasClass("mp-quantity"),
        noSession = $(this).hasClass("no-session"),
        form = $("form");
    if (noSession) {
        e.preventDefault();
        var data = buildPriceOptionsObjectFromForm(form.serializeArray());
        return void window.postMessage({
            "type": "MP_UPDATE_QUANTITIES",
            "data": data
        }, "*")
    }
    if (0 != $("table.session-picker").length) {
        e.preventDefault();
        var dateRegExp = /\d{4}\-\d{2}\-\d{2}/i,
            oldDate = $(this).closest("form").attr("action").match(dateRegExp),
            formUrl = $(this).closest("form").attr("action");
        oldDate && oldDate.length && (oldDate = oldDate.toString(), formUrl = formUrl.replace(oldDate, $("#selectedDate").val())), $.ajax({
            "url": formUrl + "&updateQuantities=true",
            "type": "POST",
            "dataType": "text",
            "data": $("form").serialize(),
            "beforeSend": function() {
                setLoading()
            },
            "complete": function() {
                clearLoading()
            }
        }).done(function(data, textStatus, jqXHR) {
            if (buildSessionPickerFromAjax(data), initCalendarSelectedDate(), isMpQuantity) {
                var firstAmount = $(data).find(".first-amount").val(),
                    data = Object.assign({
                        "amount": firstAmount ? Number(firstAmount) : 0
                    }, buildPriceOptionsObjectFromForm(form.serializeArray()));
                window.postMessage({
                    "type": "MP_UPDATE_QUANTITIES",
                    "data": data
                }, "*")
            }
        })
    }
}), $(document).on("click", ".reset-selection", function(e) {
    e.preventDefault(), window.durationSettings.selecting = "start", window.endAvailability = {}, window.endingSessions = [], window.allSessions = [], $(this).addClass("hidden"), resetWarnings(), $(".starting-session").removeClass("starting-session"), $(".originally-empty").each(function() {
        $(this).removeClass("originally-empty").removeClass("availableSession").addClass("session-empty"), $(this).find(".unavailable").show(), $(this).find("a").hide()
    }), "ONE" == durationSettings.nextDayType && (resetSessionIds(), window.shifted = !1), $(".session-picker .session-detail .durationLabel").each(function(key, element) {
        $(element).attr("data-duration-value", !1).text("")
    }), $("#OrderItem_sessionId").val(""), $("#OrderItem_sessionEndId").val(""), $("#OrderItem_durationValue").val(""), $(".first-amount").val("0"), $(".prompt-session-starting").addClass("hidden"), $(".session-picker .prompt-session-start").removeClass("hidden"), $(".session-picker .session-seats-available").removeClass("hidden"), $(".session-picker .session-detail").addClass("hidden"), $(".session-picker .session-fade").removeClass("session-fade"), $(".session-picker .availableSession").removeClass("availableSession"), $(".session-picker .session-row").removeClass("hidden"), $(".session-picker tr.no-availability").remove(), fadeOutOfQty()
}), $(document).on("mouseenter mouseleave", ".form-availability .session-picker td", function(e) {
    if (!isLoading() && ($(".session-picker td.session-cell").removeClass("active"), $(this).hasClass("availableSession") && !$(this).hasClass("session-fade"))) {
        var sessionId = $(this).find("a.session-select-link").attr("data-sessionid");
        void 0 !== sessionDetails[sessionId] && ($.each(sessionDetails[sessionId].quote.usedSessions, function(key, usedSessionId) {
            sessionId != usedSessionId && $(".session-picker td a.session-select-link[data-sessionid=" + usedSessionId + "]").closest("td").addClass("active")
        }), $(".session-picker td.session-cell.starting-session").addClass("active"))
    }
}), $(document).on("click", ".form-availability .session-date-nav a", function(e) {
    e.preventDefault(), $(e.target).attr("href") && $.ajax({
        "url": $(e.target).attr("href") + "&ajaxRequest=true",
        "dataType": "text",
        "beforeSend": function() {
            setLoading()
        },
        "complete": function() {
            clearLoading(), initCalendarSelectedDate()
        }
    }).done(function(data, textStatus, jqXHR) {
        direction = $(e.target).hasClass("prev-week") ? "prev" : "next", buildSessionPickerFromAjax(data, direction), "start" == durationSettings.selecting && $("#OrderItem_quantity").trigger("change")
    })
});