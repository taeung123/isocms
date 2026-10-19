<div id="hnv_setting_companytravelmaster" role="tabpanel">
    <div class="hnv_setting_main_right_title">
        <h2>{$core->get_Lang('TravelMaster Connections')}</h2>
        <p>{$core->get_Lang('Manage operations and sales processes, access large customer data sources via API & ODS and use in-depth reporting to track Travel business performance.')}</p>
    </div>
    <div class="hnv_setting_main_right_content">
        <div id="hnv_setting_companytravelmaster_main">
            <form method="post">
                <div class="row">
                    <div class="col-md-12 col-lg-9">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb_24">
                                    <label for="tmdn"
                                           class="form-label">{$core->get_Lang('TMS Domain')}</label>
                                    <input type="text" class="form-control" id="tms_domain"
                                           name="iso-tms_domain" value="{$clsConfiguration->getValue('tms_domain')}">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb_24">
                                    <label for="tmtoken" class="form-label">
                                        {$core->get_Lang('TMS Token')}
                                        <a href="javascript:void(0);" title="{$core->get_Lang('Instruct')}">
                                            {$core->get_Lang('Instruct')}
                                        </a>
                                    </label>
                                    <input type="text" class="form-control" id="tms_token" name="iso-tms_token"
                                           value="{$clsConfiguration->getValue('tms_token')}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{literal}
    <style>
        @media (min-width: 992px) and (max-width: 1199px) {
        }
        @media (min-width: 375px) {
        }
        @media (min-width: 576px) {
        }
        @media (min-width: 768px) {
        }
        @media (min-width: 992px) {
        }
        @media (min-width: 1200px) {
        }
        @media (min-width: 1401px) {
        }
        @media (max-width: 1400px) {
        }
        @media (max-width: 1200px) {
        }
        @media (max-width: 992px) {
        }
        @media (max-width: 768px) {
        }
        @media (max-width: 576px) {
        }
        @media (max-width: 375px) {
        }
    </style>
    <script>
    </script>
{/literal}