<table border="0" class="table-price-option" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <th style="text-align:left;">{$core->get_Lang('Visitor Type')}</th>
        {section name=k loop=$lstNationality}
        <th style="text-align:center;">{$lstNationality[k].title}</th>
        {/section}
    </tr>
    {section name=i loop=$lstVisitorType}
    <tr class="{if $smarty.section.i.index%2 eq '0'}even{else}odd{/if}">
        <td>{$lstVisitorType[i].title}</td>
        {section name=k loop=$lstNationality}
        {assign var=price value=$clsTourPriceVal->getPrice($lstVisitorType[i].tour_property_id,$lstNationality[k].tour_property_id,$tour_id)}
        <td style="text-align:center;"> 
        {if $price ne 'null'}
        {$price}
        <input type="number" name="national_people" id="national_people" value="1" style="width: 50px;float: right;">
        {else}Updating....{/if}</td>
        {/section}</tr>
        {/section}
    <tr>
        <td>Thành tiền</td>
        <td><span id="national_total">0đ</span></td>
        <td><span id="overseas_total">0đ</span></td>
        <td><span id="foreigner_total">0đ</span></td>
    </tr>
    <tr>
      <td>Tổng tiền</td>
      <td colspan="3">
        <span id="total">0đ</span>
        </td>
    </tr>
</table>
<div class="clearfix mt30"></div>
{if $clsTour->getNote($tour_id) ne ''}
<h3 class="h3bold">{$core->get_Lang('Note Price Tables')}</h3>
<div class="formatTextStandard">{$clsTour->getNote($tour_id)}</div>
{/if}
{if $clsTour->getInclusion($tour_id)}
<h3 class="h3bold">{$core->get_Lang('Trip Inclusion')}</h3>
<div class="formatTextStandard">{$clsTour->getInclusion($tour_id)}</div>
{/if} 
{if $clsTour->getExclusion($tour_id)}
<h3 class="h3bold">{$core->get_Lang('Trip Exclusion')}</h3>
<div class="formatTextStandard">{$clsTour->getExclusion($tour_id)}</div>
{/if} 