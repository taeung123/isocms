<form class="form-inline" method="post" action="{$extLang}/" role="form">
  <div class="departure_point">
    <p>{$core->get_Lang('Search your ideas')}</p>
    <input type="text" name="key" class="form-control" value="{$keyword}"
           placeholder="{$core->get_Lang('text_key_search_hotel')}"/>
  </div>
  <div class="select_find">
    <div class="form-group">
      <p>{$core->get_Lang('Country')}</p>
      <select class="form-control" name="country_id">
          {$clsCountry->getSelectByCountry($country_id)}
      </select>
    </div>
    <div class="form-group">
      <p>{$core->get_Lang('City')}</p>
      <select class="form-control" name="city_id">
        <option value="0">{$core->get_Lang('Select all')}</option>
      </select>
    </div>
    <div class="form-group"> <p>{$core->get_Lang('Ranking')}</p>
      <select class="form-control" name="star_id">
        <option selected="selected"> {$core->get_Lang('Select all')}</option>
          {$clsISO->makeSelectNumberStart(6,$star_id)}
      </select>
    </div>
      {if $clsConfiguration->getValue('SiteHasHotelPriceRange')}
        <div class="form-group"> <p>{$core->get_Lang('Price')}</p>
          <select class="form-control bdr0" name="price_range">
            <option value="0">{$core->get_Lang('Select all')}</option>
              {section name=i loop=$lstPriceRange}
                <option {if $price_range eq $lstPriceRange[i].hotel_price_range_id}selected="selected"{/if}
                        value="{$lstPriceRange[i].hotel_price_range_id}">{$clsHotelPriceRange->getTitle($lstPriceRange[i].hotel_price_range_id)}</option>
              {/section}
          </select>
        </div>
      {/if} <input type="hidden" value="searchHotel" name="hid"/>
    <button  class="btn btn-default" type="submit">{$core->get_Lang('Search')}</button>
  </div>
  <div class="address_find hidden-xs hidden-sm"> <i class="fa fa-bed" aria-hidden="true"></i> {$core->get_Lang('text_sugges_des_hotel')}</div>
</form>

<link rel="stylesheet" href="{$URL_JS}/selectric/selectric.css?v={$upd_version}">
<script type="text/javascript" src="{$URL_JS}/selectric/jquery.selectric.js?v={$upd_version}"></script>
<script type="text/javascript">
    var city_id = "{$city_id}";
    var Loading = "{$core->get_lang('Loading')}....";
</script>
{literal}
  <style>
    .findform .isoTxt {
      width: 160px;
      height: 22px;
      padding: 0 4px;
      border: 1px solid #BABABA
    }
  </style>
  <script type="text/javascript">
      $(function () {
          loadCity();
          $('select[name=country_id]').change(function () {
              loadCity();
          });
      });

      function loadCity() {
          $.ajax({
              'type': 'POST',
              'url': path_ajax_script + '/index.php?mod=hotel&act=loadCity&lang=' + LANG_ID,
              'data': {"country_id": $('select[name=country_id]').val(), 'city_id': city_id},
              'dataType': 'html',
              'success': function (html) {
                  $('select[name=city_id]').html(html);
              }
          });
      }
  </script>
{/literal}
