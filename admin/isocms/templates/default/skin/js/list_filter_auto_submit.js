(function ($) {
    'use strict';

    var formSelector = 'form[data-auto-filter="true"]';

    function submitFilter(form) {
        if (!form || form.dataset.autoFilterSubmitting === 'true') {
            return;
        }

        form.dataset.autoFilterSubmitting = 'true';
        if (typeof form.requestSubmit === 'function') {
            form.requestSubmit();
            return;
        }
        $(form).trigger('submit');
    }

    $(document).on('change.listAutoFilter', formSelector + ' select, ' + formSelector + ' input[type="date"], ' + formSelector + ' input[type="checkbox"], ' + formSelector + ' input[type="radio"], ' + formSelector + ' input[data-auto-filter-change="true"]', function () {
        var form = this.form;
        window.setTimeout(function () { submitFilter(form); }, 0);
    });

    $(document).on('keydown.listAutoFilter', formSelector + ' input[type="search"], ' + formSelector + ' input[type="text"]', function (event) {
        if (event.key !== 'Enter' || event.isComposing) {
            return;
        }
        event.preventDefault();
        submitFilter(this.form);
    });

    $(document).on('submit.listAutoFilter', formSelector, function () {
        this.dataset.autoFilterSubmitting = 'true';
    });
})(jQuery);
