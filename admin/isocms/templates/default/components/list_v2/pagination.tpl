<footer class="booking-table-footer">
    <span>
        {$pagination_showing_label} {$pagination_showing_start} - {$pagination_showing_end}
        {$pagination_of_label} {$pagination_total_records} {$pagination_entity_label}
    </span>
    {if $pagination_total_pages gt 0}
        <nav class="booking-pagination" aria-label="{$pagination_label}">
            {if $pagination_current_page gt 1}
                <a href="{$pagination_base_url}/{$pagination_page_query}&page={$pagination_previous_page}" aria-label="{$pagination_previous_label}">
                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                </a>
            {else}
                <span class="is-disabled" aria-disabled="true">
                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                </span>
            {/if}

            {foreach from=$pagination_pages item=page_number}
                <a class="{if $page_number eq $pagination_current_page}is-current{/if}"
                   href="{$pagination_base_url}/{$pagination_page_query}&page={$page_number}"
                   {if $page_number eq $pagination_current_page}aria-current="page"{/if}>
                    {$page_number}
                </a>
            {/foreach}

            {if $pagination_current_page lt $pagination_total_pages}
                <a href="{$pagination_base_url}/{$pagination_page_query}&page={$pagination_next_page}" aria-label="{$pagination_next_label}">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </a>
            {else}
                <span class="is-disabled" aria-disabled="true">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </span>
            {/if}
        </nav>
    {/if}
</footer>
