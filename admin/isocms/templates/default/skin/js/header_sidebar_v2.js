(function (window, document) {
    'use strict';

    function ready(callback) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', callback);
            return;
        }
        callback();
    }

    ready(function () {
        var body = document.body;
        var header = document.getElementById('header');
        var sidebar = document.getElementById('sidebar');
        var toggle = document.getElementById('sidebar-collapse-click');

        if (!body || !header || !sidebar || !toggle) {
            return;
        }

        body.classList.add('iso-admin-shell-v2');

        var sidebarStateKey = 'isocms_admin_sidebar_collapsed_v2';
        var savedSidebarState = null;
        try {
            savedSidebarState = window.localStorage.getItem(sidebarStateKey);
        } catch (ignoreStorageRead) {
            savedSidebarState = null;
        }

        function applySavedSidebarState() {
            if (savedSidebarState !== '1' && savedSidebarState !== '0') {
                return;
            }
            var collapsed = savedSidebarState === '1';
            sidebar.classList.toggle('menu-min', collapsed);
            toggle.classList.toggle('closed', collapsed);
            toggle.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
        }

        function saveSidebarState(collapsed) {
            savedSidebarState = collapsed ? '1' : '0';
            try {
                window.localStorage.setItem(sidebarStateKey, savedSidebarState);
            } catch (ignoreStorageWrite) {
                /* The server-side setting remains the fallback when storage is unavailable. */
            }
        }

        applySavedSidebarState();

        /* Keep legacy ready handlers from replacing the restored state before first paint. */
        var sidebarInitializationGuard = null;
        if (savedSidebarState === '1' || savedSidebarState === '0') {
            sidebarInitializationGuard = new MutationObserver(function () {
                var shouldBeCollapsed = savedSidebarState === '1';
                if (sidebar.classList.contains('menu-min') !== shouldBeCollapsed) {
                    applySavedSidebarState();
                }
            });
            sidebarInitializationGuard.observe(sidebar, {
                attributes: true,
                attributeFilter: ['class']
            });
        }

        /* Capture the user's intention before the legacy jQuery click handler changes the class. */
        toggle.addEventListener('click', function () {
            if (!window.matchMedia('(max-width: 991px)').matches) {
                saveSidebarState(!sidebar.classList.contains('menu-min'));
            }
        }, true);

        /* Enable normal transitions only after all DOM-ready handlers have settled. */
        window.requestAnimationFrame(function () {
            window.requestAnimationFrame(function () {
                applySavedSidebarState();
                if (sidebarInitializationGuard) sidebarInitializationGuard.disconnect();
                body.classList.remove('iso-sidebar-initializing');
            });
        });

        /* Reconcile the legacy active class (the Tour condition is true on every page). */
        if (typeof window.mod !== 'undefined') {
            var topMenuItems = sidebar.querySelectorAll('#sidebar-nav > li');
            for (var menuIndex = 0; menuIndex < topMenuItems.length; menuIndex += 1) {
                var topLink = topMenuItems[menuIndex].querySelector(':scope > a.nav-header');
                var itemLinks = topMenuItems[menuIndex].querySelectorAll('a[href]');
                var isCurrentItem = window.mod === 'home' ? menuIndex === 0 : false;
                for (var linkIndex = 0; linkIndex < itemLinks.length && !isCurrentItem; linkIndex += 1) {
                    var href = itemLinks[linkIndex].getAttribute('href') || '';
                    try {
                        isCurrentItem = new URL(href, window.location.href).searchParams.get('mod') === window.mod;
                    } catch (ignoreInvalidUrl) {
                        isCurrentItem = false;
                    }
                }
                topMenuItems[menuIndex].classList.toggle('active', isCurrentItem);
                if (topLink) {
                    if (isCurrentItem) topLink.setAttribute('aria-current', 'page');
                    else topLink.removeAttribute('aria-current');
                }
                var itemSubmenu = topMenuItems[menuIndex].querySelector(':scope > .submenu');
                if (itemSubmenu && !isCurrentItem) itemSubmenu.style.display = 'none';
            }
        }

        var logo = header.querySelector('.logo');
        var menu = header.querySelector('.menu_header');
        var headerRight = header.querySelector('.header_right');

        var sidebarPromoElement = sidebar.querySelector('.iso-sidebar-promo');
        if (sidebarPromoElement) {
            var promoCollapseElement = sidebarPromoElement.querySelector('.iso-sidebar-promo__collapse');
            var syncPromoElementState = function () {
                var collapsed = sidebar.classList.contains('menu-min');
                promoCollapseElement.setAttribute('aria-label', collapsed ? 'Expand sidebar' : 'Collapse sidebar');
                promoCollapseElement.setAttribute('title', collapsed ? 'Expand sidebar' : 'Collapse sidebar');
                promoCollapseElement.querySelector('i').className = collapsed ? 'fa fa-arrow-right' : 'fa fa-arrow-left';
            };
            promoCollapseElement.addEventListener('click', function () {
                toggle.click();
                window.setTimeout(syncPromoElementState, 0);
            });
            new MutationObserver(syncPromoElementState).observe(sidebar, { attributes: true, attributeFilter: ['class'] });
            syncPromoElementState();
        }

        var search = header.querySelector('.iso-shell-search');
        if (search) {
            var searchInput = search.querySelector('input');
            var searchResults = search.querySelector('.iso-shell-search__results');
            var searchTimer = null;
            var searchRequest = null;
            var lastSearchQuery = '';

            function setSearchOpen(open) {
                searchResults.hidden = !open;
                searchInput.setAttribute('aria-expanded', open ? 'true' : 'false');
            }

            function renderSearchMessage(message, icon) {
                searchResults.innerHTML = '';
                var state = document.createElement('div');
                state.className = 'iso-shell-search__state';
                state.innerHTML = '<i class="' + icon + '" aria-hidden="true"></i><span></span>';
                state.querySelector('span').textContent = message;
                searchResults.appendChild(state);
                setSearchOpen(true);
            }

            function renderSearchResults(items) {
                searchResults.innerHTML = '';
                if (!items.length) {
                    renderSearchMessage('No matching results', 'fa fa-search');
                    return;
                }
                items.forEach(function (item) {
                    var link = document.createElement('a');
                    link.className = 'iso-shell-search__item';
                    link.href = item.url;
                    link.setAttribute('role', 'option');

                    var content = document.createElement('span');
                    content.className = 'iso-shell-search__content';
                    var title = document.createElement('strong');
                    title.textContent = item.title;
                    var type = document.createElement('small');
                    type.textContent = item.type;
                    content.appendChild(title);
                    content.appendChild(type);

                    var arrow = document.createElement('span');
                    arrow.className = 'iso-shell-search__arrow';
                    arrow.setAttribute('aria-hidden', 'true');
                    link.appendChild(content);
                    link.appendChild(arrow);
                    searchResults.appendChild(link);
                });
                setSearchOpen(true);
            }

            function runGlobalSearch() {
                var query = searchInput.value.trim();
                if (query.length < 2) {
                    setSearchOpen(false);
                    searchResults.innerHTML = '';
                    return;
                }
                if (typeof path_ajax_script === 'undefined') {
                    renderSearchMessage('Search is unavailable', 'fa fa-exclamation-circle');
                    return;
                }
                if (searchRequest && typeof searchRequest.abort === 'function') {
                    searchRequest.abort();
                }
                renderSearchMessage('Searching...', 'fa fa-spinner fa-spin');
                var request = new XMLHttpRequest();
                searchRequest = request;
                request.open('POST', path_ajax_script + '/index.php?mod=home&act=ajGlobalSearch', true);
                request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
                request.onreadystatechange = function () {
                    if (request.readyState !== 4 || request !== searchRequest) return;
                    if (request.status < 200 || request.status >= 300) {
                        renderSearchMessage('Unable to load results', 'fa fa-exclamation-circle');
                        return;
                    }
                    try {
                        var response = JSON.parse(request.responseText);
                        lastSearchQuery = query;
                        renderSearchResults(response.results || []);
                    } catch (invalidResponse) {
                        renderSearchMessage('Unable to load results', 'fa fa-exclamation-circle');
                    }
                };
                request.send('keyword=' + encodeURIComponent(query));
            }

            searchInput.addEventListener('input', function () {
                window.clearTimeout(searchTimer);
                searchTimer = window.setTimeout(runGlobalSearch, 280);
            });

            searchInput.addEventListener('focus', function () {
                var query = searchInput.value.trim();
                if (query.length < 2) return;
                if (query === lastSearchQuery && searchResults.children.length) {
                    setSearchOpen(true);
                    return;
                }
                runGlobalSearch();
            });

            search.addEventListener('submit', function (event) {
                event.preventDefault();
                var firstResult = searchResults.querySelector('.iso-shell-search__item');
                if (firstResult) window.location.href = firstResult.href;
                else runGlobalSearch();
            });

            document.addEventListener('keydown', function (event) {
                if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'k') {
                    event.preventDefault();
                    searchInput.focus();
                    searchInput.select();
                }
                if (event.key === 'Escape') setSearchOpen(false);
            });

            document.addEventListener('click', function (event) {
                if (!search.contains(event.target)) setSearchOpen(false);
            });
        }

        var datePicker = header.querySelector('.iso-shell-date');
        if (datePicker) {
            var today = new Date();
            today.setHours(0, 0, 0, 0);
            var weekStart = new Date(today.getTime());
            weekStart.setDate(weekStart.getDate() - 7);
            var toIsoDate = function (date) {
                var month = String(date.getMonth() + 1).padStart(2, '0');
                var day = String(date.getDate()).padStart(2, '0');
                return date.getFullYear() + '-' + month + '-' + day;
            };
            var formatDate = function (date) {
                return String(date.getDate()).padStart(2, '0') + '/' +
                    String(date.getMonth() + 1).padStart(2, '0') + '/' + date.getFullYear();
            };
            var fromIsoDate = function (value) {
                var parts = String(value || '').split('-');
                if (parts.length !== 3) return null;
                var date = new Date(Number(parts[0]), Number(parts[1]) - 1, Number(parts[2]));
                date.setHours(0, 0, 0, 0);
                return isNaN(date.getTime()) ? null : date;
            };
            var dateToggle = datePicker.querySelector('.iso-shell-date__toggle');
            var dateLabel = dateToggle.querySelector('span');
            var datePanel = datePicker.querySelector('.iso-shell-date__panel');
            var dateFrom = datePicker.querySelector('[name="iso_date_from"]');
            var dateTo = datePicker.querySelector('[name="iso_date_to"]');
            var dateError = datePicker.querySelector('.iso-shell-date__error');
            var minimumRange = 7 * 86400000;
            var initialFrom = fromIsoDate(datePicker.getAttribute('data-from-date')) || weekStart;
            var initialTo = fromIsoDate(datePicker.getAttribute('data-to-date')) || today;
            var setError = function (message) {
                dateError.textContent = message || '';
                dateError.hidden = !message;
            };
            var syncLabel = function (from, to) {
                dateLabel.textContent = formatDate(from) + ' - ' + formatDate(to);
            };

            $(dateFrom).datepicker({
                dateFormat: 'dd/mm/yy',
                maxDate: -7,
                changeMonth: true,
                changeYear: true,
                onSelect: function () {
                    var from = $(dateFrom).datepicker('getDate');
                    var minTo = new Date(from.getTime() + minimumRange);
                    $(dateTo).datepicker('option', 'minDate', minTo);
                    if ($(dateTo).datepicker('getDate') < minTo) {
                        $(dateTo).datepicker('setDate', minTo);
                    }
                    setError('');
                }
            });
            $(dateTo).datepicker({
                dateFormat: 'dd/mm/yy',
                minDate: new Date(initialFrom.getTime() + minimumRange),
                maxDate: today,
                changeMonth: true,
                changeYear: true,
                onSelect: function () { setError(''); }
            });
            $(dateFrom).datepicker('setDate', initialFrom);
            $(dateTo).datepicker('setDate', initialTo);
            syncLabel(initialFrom, initialTo);
            dateToggle.addEventListener('click', function () {
                var open = datePanel.hidden;
                datePanel.hidden = !open;
                dateToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
            datePicker.querySelector('[data-range="week"]').addEventListener('click', function () {
                $(dateFrom).datepicker('setDate', weekStart);
                $(dateTo).datepicker('option', 'minDate', today);
                $(dateTo).datepicker('setDate', today);
                setError('');
            });
            datePicker.querySelector('[data-apply]').addEventListener('click', function () {
                var from = $(dateFrom).datepicker('getDate');
                var to = $(dateTo).datepicker('getDate');
                if (!from || !to || to > today || (to.getTime() - from.getTime()) < minimumRange) {
                    setError('Choose a past date range of at least 7 days.');
                    dateFrom.focus();
                    return;
                }
                syncLabel(from, to);
                var rangeState = { from_date: toIsoDate(from), to_date: toIsoDate(to) };
                var cookieOptions = '; Max-Age=31536000; Path=/; SameSite=Lax' +
                    (window.location.protocol === 'https:' ? '; Secure' : '');
                document.cookie = 'iso_dashboard_from=' + encodeURIComponent(rangeState.from_date) + cookieOptions;
                document.cookie = 'iso_dashboard_to=' + encodeURIComponent(rangeState.to_date) + cookieOptions;

                // Applying a new range is the only action that reloads the dashboard.
                // Remove legacy date parameters while preserving any unrelated query data.
                var cleanUrl = new URL(window.location.href);
                cleanUrl.searchParams.delete('from_date');
                cleanUrl.searchParams.delete('to_date');
                window.location.assign(cleanUrl.toString());
                return;
            });
        }

        var notificationWrap = header.querySelector('.iso-shell-notifications');
        if (notificationWrap) {
            var notification = notificationWrap.querySelector('.iso-shell-action');
            var notificationPanel = notificationWrap.querySelector('.iso-shell-notifications__panel');
            var listHolder = notificationPanel.querySelector('.iso-shell-notifications__list');
            var badge = notification.querySelector('.iso-shell-notifications__badge');

            function relativeBookingTime(timestamp) {
                var seconds = Math.max(0, Math.floor(Date.now() / 1000) - Number(timestamp || 0));
                if (seconds < 60) return 'Just now';
                if (seconds < 3600) return Math.floor(seconds / 60) + ' minutes ago';
                if (seconds < 86400) return Math.floor(seconds / 3600) + ' hours ago';
                var days = Math.floor(seconds / 86400);
                return days === 1 ? '1 day ago' : days + ' days ago';
            }

            function renderBookingNotifications(payload) {
                var items = payload && Array.isArray(payload.items) ? payload.items : [];
                var total = payload && Number(payload.total) ? Number(payload.total) : 0;
                var dashboardList = document.querySelector('.dash_notif_card .dash_notif_list');
                listHolder.innerHTML = '';
                badge.hidden = total < 1;
                badge.textContent = total > 9 ? '9+' : String(total);

                if (!items.length) {
                    listHolder.innerHTML = '<div class="iso-shell-empty">No new bookings this week</div>';
                    if (dashboardList) {
                        dashboardList.innerHTML = '<div class="iso-shell-empty">No new bookings this week</div>';
                    }
                    return;
                }

                var list = document.createElement('div');
                list.className = 'dash_notif_list';
                items.forEach(function (item) {
                    var link = document.createElement('a');
                    link.className = 'dash_notif_item';
                    link.href = item.url;

                    var icon = document.createElement('div');
                    icon.className = 'dash_notif_icon';
                    icon.style.background = '#FEEFEE';
                    icon.style.color = '#EE5D50';
                    icon.innerHTML = '<i class="fa fa-calendar" aria-hidden="true"></i>';
                    var content = document.createElement('div');
                    content.className = 'dash_notif_content';
                    var title = document.createElement('div');
                    title.className = 'dash_notif_title';
                    title.textContent = item.title || 'New booking received';
                    var description = document.createElement('div');
                    description.className = 'dash_notif_desc';
                    description.textContent = item.description || '';
                    var time = document.createElement('div');
                    time.className = 'dash_notif_time';
                    time.textContent = relativeBookingTime(item.created_at);
                    content.appendChild(title);
                    content.appendChild(description);
                    content.appendChild(time);
                    link.appendChild(icon);
                    link.appendChild(content);
                    list.appendChild(link);
                });
                listHolder.appendChild(list);

                // The dashboard card shares the same source but intentionally
                // shows only the five newest weekly bookings.
                if (dashboardList) {
                    dashboardList.innerHTML = '';
                    var dashboardItems = list.querySelectorAll('.dash_notif_item');
                    for (var index = 0; index < Math.min(5, dashboardItems.length); index += 1) {
                        var dashboardItem = document.createElement('div');
                        dashboardItem.className = 'dash_notif_item';
                        dashboardItem.innerHTML = dashboardItems[index].innerHTML;
                        dashboardItem.setAttribute('role', 'link');
                        dashboardItem.setAttribute('tabindex', '0');
                        dashboardItem.setAttribute('data-booking-url', dashboardItems[index].href);
                        dashboardItem.addEventListener('click', function () {
                            window.location.href = this.getAttribute('data-booking-url');
                        });
                        dashboardItem.addEventListener('keydown', function (event) {
                            if (event.key === 'Enter' || event.key === ' ') {
                                event.preventDefault();
                                this.click();
                            }
                        });
                        dashboardList.appendChild(dashboardItem);
                    }
                }
            }

            var notificationRequest = new XMLHttpRequest();
            notificationRequest.open('GET', path_ajax_script + '/index.php?mod=home&act=ajWeeklyBookingNotifications', true);
            notificationRequest.onreadystatechange = function () {
                if (notificationRequest.readyState !== 4 || notificationRequest.status < 200 || notificationRequest.status >= 300) return;
                try {
                    renderBookingNotifications(JSON.parse(notificationRequest.responseText));
                } catch (ignore) {}
            };
            notificationRequest.send();
            notification.addEventListener('click', function () {
                var open = notificationPanel.hidden;
                notificationPanel.hidden = !open;
                notification.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
        }

        document.addEventListener('click', function (event) {
            if (event.target.closest && event.target.closest('#ui-datepicker-div')) return;
            var openPopovers = header.querySelectorAll('.iso-shell-popover:not([hidden])');
            for (var p = 0; p < openPopovers.length; p += 1) {
                if (!openPopovers[p].parentNode.contains(event.target)) {
                    openPopovers[p].hidden = true;
                    var popoverToggle = openPopovers[p].parentNode.querySelector('[aria-expanded]');
                    if (popoverToggle) popoverToggle.setAttribute('aria-expanded', 'false');
                }
            }
        });

        var overlay = document.querySelector('.iso-shell-overlay');

        function isMobile() {
            return window.matchMedia('(max-width: 991px)').matches;
        }

        function setMobileSidebar(open) {
            sidebar.classList.toggle('iso-sidebar-open', open);
            body.classList.toggle('iso-sidebar-visible', open);
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            if (open) {
                sidebar.classList.remove('menu-min');
                window.requestAnimationFrame(function () {
                    if (sidebar.classList.contains('iso-sidebar-open')) {
                        sidebar.classList.remove('menu-min');
                    }
                });
            }
        }

        toggle.setAttribute('aria-controls', 'sidebar');
        toggle.setAttribute('aria-label', 'Toggle navigation');
        toggle.setAttribute('aria-expanded', 'false');

        /* Capture phase runs before the legacy jQuery handler and only adds mobile state. */
        toggle.addEventListener('click', function () {
            if (isMobile()) {
                setMobileSidebar(!sidebar.classList.contains('iso-sidebar-open'));
            }
        }, true);

        if (overlay) {
            overlay.addEventListener('click', function () {
                setMobileSidebar(false);
            });
        }

        sidebar.addEventListener('click', function (event) {
            if (isMobile() && event.target.closest('a[href]') && !event.target.closest('.dropdown-toggle')) {
                setMobileSidebar(false);
            }
        });

        window.addEventListener('resize', function () {
            if (!isMobile()) {
                setMobileSidebar(false);
                applySavedSidebarState();
            }
        });

        if (logo) {
            logo.setAttribute('aria-label', 'isoCMS');
        }
    });
}(window, document));
