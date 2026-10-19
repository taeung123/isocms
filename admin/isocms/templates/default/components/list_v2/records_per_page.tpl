<div class="booking-records-per-page v2-records-per-page">
    <label for="{$records_per_page_id}">{$records_per_page_label}</label>
    <select id="{$records_per_page_id}" name="recordperpage" onchange="window.location=this.value">
        <option value="{$records_per_page_base_url}{$records_per_page_query}&recordperpage=20" {if $records_per_page_value eq 20}selected{/if}>20</option>
        <option value="{$records_per_page_base_url}{$records_per_page_query}&recordperpage=50" {if $records_per_page_value eq 50}selected{/if}>50</option>
        <option value="{$records_per_page_base_url}{$records_per_page_query}&recordperpage=100" {if $records_per_page_value eq 100}selected{/if}>100</option>
        <option value="{$records_per_page_base_url}{$records_per_page_query}&recordperpage=200" {if $records_per_page_value eq 200}selected{/if}>200</option>
    </select>
</div>
