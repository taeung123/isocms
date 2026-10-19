<h3 class="title_box mb0">{$core->get_Lang('Why choose country')}
    {assign var= why_country value='why_country'}
    {assign var= help_first value=$why_country}
    {if $CHECKHELP eq 1}
        <button data-key="{$why_country}" data-label="{$core->get_Lang('Why choose country')}" type="button"
                title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default">
            <i class="fa fa-plus-circle"></i>
        </button>
    {/if}
    <div class="text_help" hidden="">{$clsConfiguration->getValue($why_counhelp_firsthelp_firsttry)|html_entity_decode}</div>
</h3>
<p class="intro_box mb40">{$core->get_Lang('Intro why choose country')}</p>
<div class="form_option_tour">
    <div class="inpt_tour">
        <div class="hastable">
            <table class="full-width tbl-grid table-striped table_responsive" cellspacing="0">
                <thead>
                    <tr>
                        <th class="gridheader hiden_responsive" style="width: 50px;">
                            <strong>{$core->get_Lang('ID')}</strong></th>
                        <th class="gridheader name_responsive name_responsive2" style="text-align:left">
                            <strong>{$core->get_Lang('Title')}</strong></th>
                        <th class="gridheader hiden_responsive" style="text-align:left; width: 190px;">
                            <strong>{$core->get_Lang('Status')}</strong></th>
                        <th class="gridheader hiden_responsive" style="width: 50px"></th>
                    </tr>
                </thead>
                <tbody id="tblWhyCountry"></tbody>
            </table>
        </div>
        {if $clsWhyChooseCountry->checkExistWhyCountry($pvalTable)}
            <a href="javascript:void(0);" id="clickToAddWhyCountry" class="btn_additinerary"
               title="{$core->get_Lang('Add why choose country')}">+ {$core->get_Lang('Add why choose country')}</a>
        {/if}
    </div>
</div>

{literal}
    <script>
        loadWhyCountry(country_id);
    </script>
{/literal}