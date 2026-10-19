	

  <nav class="booking-list-breadcrumb v2-breadcrumb" aria-label="Breadcrumb">
    <a href="{$PCMS_URL}"><i class="fa fa-home" aria-hidden="true"></i> {$core->get_Lang('Dashboard')}</a>
    <i class="fa fa-angle-right" aria-hidden="true"></i>
    <a href="{$PCMS_URL}/?mod=property&act=transport">{$core->get_Lang('Tour setting')}</a>
    {if $act eq ''}
      <i class="fa fa-angle-right" aria-hidden="true"></i>
      <span>{$core->get_Lang('')}</span>
    {/if}
    
</nav>
{literal}
<style>

</style>
{/literal}