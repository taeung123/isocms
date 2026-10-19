<div class="container">
    <section class="col-md-10 col-md-offset-1">
    <form id="formFindTripBig" method="post" action="{$extLang}">
      <div class="find-a-box">
        <select id="boxCountry" class="slb mr5" name="country_id" style="width:135px">
          <option value="1" selected="selected">VietNam </option>
          <option value="2">Laos</option>
          <option value="3">Cambodia</option>
          <option value="4">Myanmar</option>
        </select>
      </div>
      <div class="find-a-box">
        <select id="boxDestination" class="slb mr5" name="city_id" style="width:155px">
          <option value="">-- {$core->get_Lang('Destinations')} --</option>
          {section name=i loop=$listTopCity}
        		<option value="{$listTopCity[i].city_id}">{$clsCity->getTitle($listTopCity[i].city_id)}</option>
          {/section}
        </select>
      </div>
      <div class="find-a-box">
        <select id="boxCategory" class="slb mr5" name="cat_id" style="width:150px">
          <option value="">-- Travel styles --</option>
          <option value="277">Classic &amp; Cultures</option>
        </select>
      </div>
      <div class="find-a-box">
        <select id="boxDuration" class="slb" name="duration" style="width:140px">
          <option value="">-- Duration --</option>
          <option value="1-0">Full day</option>
          <option value="1-1">1 day / 1 night</option>
          <option value="2-1">2 days / 1 night</option>
          <option value="2-3">2 days / 3 nights</option>
          <option value="3-2">3 days / 2 nights</option>
        </select>
      </div>
      <input type="submit" class="btn-search-tours fl ml5" value="FIND VACATIONS">
      <input type="hidden" name="hid_s" value="hid_s">
    </form>
    </section>
</div>