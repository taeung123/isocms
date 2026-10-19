<div class="booking-field booking-date-field v2-date-field">
    <label class="booking-field-label" for="{$date_picker_id}">{$date_picker_label}</label>
    <input id="{$date_picker_id}"
           type="text"
           name="{$date_picker_name}"
           value="{$date_picker_value|default:''|trim}"
           placeholder="{$date_picker_placeholder|default:'dd/mm/yyyy'}"
           data-placeholder="{$date_picker_placeholder|default:'dd/mm/yyyy'}"
           title="{$date_picker_label}"
           aria-label="{$date_picker_label}"
           {if $date_picker_auto_filter|default:false}data-auto-filter-change="true"{/if}
           autocomplete="off" />
    <i class="fa fa-calendar" aria-hidden="true"></i>
</div>
