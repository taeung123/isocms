<section id="information" class="desktop768" style="margin-top:0">
    <ul id="tabsrl" class="clienttabs">
    	{assign var=cat_id value=$clsGuideCat->getGuideCatId($listGuideCat[0].guidecat_id)}
        <li class="first"><a href="{$clsCity->getLink($city_id)}" title="{$clsGuideCat->getTitle($listGuideCat[0].guidecat_id)}" class="{if $guidecat_id eq $listGuideCat[0].guidecat_id}current{/if}">{$clsGuideCat->getTitle($listGuideCat[0].guidecat_id)}</a></li>
        {if $listTour[0].tour_id ne ''}
        <li><a class="{if $mod eq 'destination' && $act eq 'city'}current{/if}" href="{$clsCity->getLink($city_id,'Landtour')}" title="Land Tours">Land Tours</a></li>
        {/if}
        {if $listHotelCity[0].hotel_id ne ''}
        <li ><a class="{if $mod eq 'hotel' && $act eq 'place'}current{/if}" href="{$clsCity->getLink($city_id,'Hotel')}" title="Hotels">Hotels</a></li>
        {/if}
        {section name=i loop=$listGuideCat start=1 max=3 step=1}
        {assign var=cat_id value=$clsGuideCat->getGuideCatId($listGuideCat[i].guidecat_id)}
        <li><a href="{$clsCity->getLinkGuide($cat_id,$city_id)}" title="{$clsGuideCat->getTitle($listGuideCat[i].guidecat_id)}" class="{if $guidecat_id eq $listGuideCat[i].guidecat_id}current{/if}">{$clsGuideCat->getTitle($listGuideCat[i].guidecat_id)}</a></li>
        {/section}
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">More <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            {section name=i loop=$listGuideCat start=4}
            {assign var=cat_id value=$clsGuideCat->getGuideCatId($listGuideCat[i].guidecat_id)}
            <li><a href="{$clsCity->getLinkGuide($cat_id,$city_id)}" title="{$clsGuideCat->getTitle($listGuideCat[i].guidecat_id)}" class="{if $guidecat_id eq $listGuideCat[i].guidecat_id}current{/if}">{$clsGuideCat->getTitle($listGuideCat[i].guidecat_id)}</a></li>
            {/section}
          </ul>
        </li>     
    </ul>
</section>
<section class="bs-example mobile768" style="display:none">
    <nav class="navbar navbar-inverse" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-9">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Menu</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="navbar-collapse collapse" id="bs-example-navbar-collapse-9" style="height: 1px;">
          <ul class="nav navbar-nav">
            {if $listTour[0].tour_id ne ''}
            <li><a class="{if $mod eq 'destination' && $act eq 'city'}current{/if}" href="{$clsCity->getLink($city_id,'Landtour')}" title="Land Tours">Land Tours</a></li>
            {/if}
            {if $listHotelCity[0].hotel_id ne ''}
            <li ><a class="{if $mod eq 'hotel' && $act eq 'place'}current{/if}" href="{$clsCity->getLink($city_id,'Hotel')}" title="Hotels">Hotels</a></li>
            {/if}
            {section name=i loop=$listGuideCat}
            {assign var=cat_id value=$clsGuideCat->getGuideCatId($listGuideCat[i].guidecat_id)}
            <li><a href="{$clsCity->getLinkGuide($cat_id,$city_id)}" title="{$clsGuideCat->getTitle($listGuideCat[i].guidecat_id)}" class="{if $guidecat_id eq $listGuideCat[i].guidecat_id}current{/if}">{$clsGuideCat->getTitle($listGuideCat[i].guidecat_id)}</a></li>
            {/section}
          </ul>
        </div>
      </div>
    </nav>
  </section>