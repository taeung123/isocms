<div class="page-title  d-flex">
    {if $type|default:'' == 'Unit'}
        <a href="{$PCMS_URL}/?mod=voucher" class="back"></a>
    {else}
        <a href="{$PCMS_URL}/?mod={$mod}" class="back"></a>
    {/if}
    <div class="title">
        <h1>
            {$core->get_Lang('Setting')}
        </h1>
        <p>{$core->get_Lang('The system manages settings related to')} {$mod}</p>
    </div>
</div>