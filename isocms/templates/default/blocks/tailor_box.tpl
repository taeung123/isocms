<div class="boxTailorMade">
    <h2 class="title">{$core->get_Lang('Tailor-Made your Ideas')}</h2>
    <div class="line">
        <label>{$core->get_Lang('Select')}:</label>
        <div class="slbBox">
            <select class="selectbox" name="country_id">
                {section name=i loop=$lstCountryEx}
                <option value="{$lstCountryEx[i].country_id}">{$clsCountryEx->getTitle($lstCountryEx[i].country_id)}</option>
                {/section}
            </select>
        </div>
    </div>
    <input type="submit" class="btn_submit fr" id="choose_CountrTailor" value="{$core->get_Lang('Go')}" />
</div>