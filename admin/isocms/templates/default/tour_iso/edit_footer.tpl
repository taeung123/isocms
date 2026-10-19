<footer class="tm-action-bar">
	{* ================= PREV STEP ================= *}
	{if empty($child_cat_menu_j_index_prev)}
		{if empty($list_cat_menu_prev)}
			{assign var="prev_step" value=$child_cat_menu_j|trim}
		{else}
			{assign var="prev_item" value=$child_cat_menu_prev[$count_child_cat_menu_prev]}
			{if is_array($prev_item)}
				{assign var="prev_id" value=$prev_item.id}
			{else}
				{assign var="prev_id" value=$prev_item}
			{/if}

			{assign var="prev_step" value="`$list_cat_menu_prev|trim`/`$prev_id|trim`"}
		{/if}
	{else}
		{assign var="prev_step" value=$child_cat_menu_j_index_prev|trim}
	{/if}

	{* ================= NEXT STEP ================= *}
	{if empty($child_cat_menu_j_index_next)}
		{if empty($list_menu_tour_i_index_next.cat_menu)}
			{assign var="next_step" value="SaveAll"}
		{else}
			{assign var="next_item" value=$child_cat_menu_next[0]}
			{if is_array($next_item)}
				{assign var="next_id" value=$next_item.id}
			{else}
				{assign var="next_id" value=$next_item}
			{/if}
			{assign var="next_step" value="`$list_cat_menu_next|trim`/`$next_id|trim`"}
		{/if}
	{else}
		{assign var="next_step" value=$child_cat_menu_j_index_next|trim}
	{/if}

	{* ================= FOOTER ================= *}

	<a tour_id="{$pvalTable}" cat_run="{$cat_run|trim}" prev_step="{$prev_step|escape:'html'}"
		class="back_step tm-btn tm-btn--back">
		{$core->get_Lang('Back')}
	</a>
	<div class="tm-action-bar__right">
		<span class="tm-action-bar__status" id="saveStatus">
			<i class="fa-solid fa-circle-check"></i>
			<span>All changes saved</span>
			<strong>
				· Last saved:
				{$clsISO->formatDateTime($oneItem.upd_date, "d/m/Y H\:i", 0)}
			</strong>
		</span>
		<a id="btn-save-img-file" tour_id="{$pvalTable}" cat_run="{$cat_run|trim}" status=""
			present_step="{$child_cat_menu_j|trim}" next_step="{$next_step|escape:'html'}"
			class="save_and_continue_tour tm-btn tm-btn--save">
			{$core->get_Lang("Save &amp; Continue")}
			<i class="fa-solid fa-arrow-right"></i>
		</a>
	</div>
</footer>