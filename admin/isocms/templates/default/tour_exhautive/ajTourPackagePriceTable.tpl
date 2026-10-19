{if $listGroupPeople}
<table class="table table-iloocal table-bordered mb-0 radius-3">
    <tbody>
    {foreach from=$listGroupPeople key=people_type item=ranges}
        {assign var=people_rowspan value=0}
        {foreach from=$ranges item=paxes}
            {math assign=people_rowspan equation="x + y" x=$people_rowspan y=$paxes|@count}
        {/foreach}

        {assign var=first_people value=true}

        {foreach from=$ranges key=group_range item=paxes}
            {assign var=range_rowspan value=$paxes|@count}
            {assign var=first_range value=true}
            {foreach from=$paxes key=key_pax item=group_pax}
                <tr>
                    {if $first_people}
                        <td width="25%" rowspan="{$people_rowspan}">{$clsTourProperty->getTitle($people_type)}</td>
                        {assign var=first_people value=false}
                    {/if}
                    {if $group_range == 0}
                        <td width="40%" colspan="2">{$clsTourOption->getTitle($key_pax)}</td>
                    {else}
                        {if $first_range}
                            <td width="25%" rowspan="{$range_rowspan}">{$clsTourOption->getTitle($group_range)}</td>
                            {assign var=first_range value=false}
                        {/if}
                        <td>{$clsTourOption->getTitle($key_pax)}</td>
                    {/if}
                    <td class="text-left">
                        <div class="input-group">
                            <input class="form-control price-In fontLarge" name="price[{$group_pax.tp_price_cfg_id}]" value="price[{$group_pax.price}]" type="text">
                            <span class="input-group-addon">USD</span>
                        </div>
                    </td>
                </tr>
            {/foreach}
        {/foreach}
    {/foreach}
    </tbody>
</table>
{else}
<div>
    {$core->get_Lang("No data yet! Please set up the group of people configuration first")}
</div>
{/if}