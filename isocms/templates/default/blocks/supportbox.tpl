<div class="supportBox">
    <h2 class="heading_box">{$core->get_Lang('Call for Expert Advice')}</h2>
    <div id="support_phone" onclick="window.location.href='tel:{$clsConfiguration->getValue('CompanyPhone')}'">{$clsConfiguration->getValue('CompanyPhone')}</div>
    <div class="support_text">{$core->get_Lang('We&acute;ll beat any package price')}.</div>
    <div class="row">
        <div class="col-xs-6 prm ">
             <img class="imgUser" src="{$URL_IMAGES}/users.png" alt="User" />
        </div>
        <div class="col-xs-6 plm">
            <ul class="link_online">
                <li><a href="javascript:void(0);"><i class="chat"></i> <u>{$core->get_Lang('Chat Online')}</u></a></li>
                <li><a href="{$clsConfiguration->getValue('SiteFacebookLink')}"><i class="fb"></i> <u>Facebook</u></a></li>
                <li><a href="{$clsConfiguration->getValue('SiteTwitterLink')}"><i class="tw"></i> <u>Twitter</u></a></li>
                <li><a href="{$clsConfiguration->getValue('SiteGoogleLink')}"><i class="plus"></i> <u>Google+</u></a></li>
            </ul>
        </div>
    </div>
    <div class="covered">{$core->get_Lang('You are covered by Silkqueen Hotel Ltd')}.,</div>
</div>
