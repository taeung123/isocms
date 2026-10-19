(function ($) {
    'use strict';

    $(function () {
        $('#page_v2 .booking-legacy-list .chkitem')
            .removeClass('chkitem')
            .prop('disabled', true);

        var $dateFrom = $('#booking_date_from');
        var $dateTo = $('#booking_date_to');
        var $filterForm = $('#forums');

        $dateFrom.add($dateTo).each(function () {
            var $input = $(this);
            var placeholder = $input.attr('data-placeholder') || 'dd/mm/yyyy';

            $input.attr('placeholder', placeholder);
            if (!$.trim($input.val())) {
                $input.val('');
            }
        });

        if (!$dateFrom.length || !$dateTo.length || typeof $.fn.datepicker !== 'function') {
            return;
        }

        var today = new Date();
        today.setHours(0, 0, 0, 0);
        var initialFrom = $dateFrom.datepicker('getDate');

        if (initialFrom) {
            $dateTo.datepicker('option', 'minDate', initialFrom);
        }

        $filterForm.on('submit.bookingDateRange', function (event) {
            var from = $dateFrom.datepicker('getDate');
            var to = $dateTo.datepicker('getDate');
            var dateToInput = $dateTo.get(0);
            dateToInput.setCustomValidity('');

            if ((from && !to) || (!from && to)) {
                event.preventDefault();
                dateToInput.setCustomValidity('Please select both From date and To date.');
                dateToInput.reportValidity();
                return;
            }

            if (from && to && (from > today || to > today || to < from)) {
                event.preventDefault();
                dateToInput.setCustomValidity('Choose a valid date range up to today.');
                dateToInput.reportValidity();
            }
        });
    });
})(jQuery);
