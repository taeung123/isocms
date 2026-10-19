<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('mailconfig')}</h2>
        <p>{$core->get_Lang('systemmanagementsettings')}</p>
    </div>
    <form method="post" enctype="multipart/form-data" class="iso_form_mail_config">
        <div class="row">
            <div class="col-12 col-lg-4">
                <p class="iso_title">{$core->get_Lang('Mail type')}</p>
                <select class="iso_select" name="iso-SiteMailType">
                    <option {if $clsConfiguration->getValue('SiteMailType') eq 'sendgrid'}selected="selected"{/if} value="sendgrid"> 
                        -- SendGrid --
                    </option>
                    <option {if $clsConfiguration->getValue('SiteMailType') eq 'smtp'}selected="selected"{/if} value="smtp"> 
                        -- SMTP --
                    </option>
                    <option {if $clsConfiguration->getValue('SiteMailType') eq 'mail'}selected="selected"{/if} value="mail"> 
                        -- PHP Mail() --
                    </option>
                </select>
            </div>
            <div class="col-12 col-lg-4">
                <p class="iso_title">{$core->get_Lang('Mail Encoding')}</p>
                <select class="iso_select" name="iso-SiteMailEncoding">
                    <option {if $clsConfiguration->getValue('SiteMailEncoding') eq '8bit'}selected="selected"{/if} value="8bit"> 
                        -- 8bit --
                    </option>
                    <option {if $clsConfiguration->getValue('SiteMailEncoding') eq '7bit'}selected="selected"{/if}value="7bit"> 
                        -- 7bit --
                    </option>
                    <option {if $clsConfiguration->getValue('SiteMailEncoding') eq 'binary'}selected="selected"{/if} value="binary"> 
                        -- binary --
                    </option>
                    <option {if $clsConfiguration->getValue('SiteMailEncoding') eq 'base64'}selected="selected"{/if} value="base64"> 
                        -- base64 --
                    </option>
                </select>
            </div>
            <div class="col-12 col-lg-4">
                <p class="iso_title">{$core->get_Lang('SMTP Port')}</p>
                <input type="number" class="iso_select" name="iso-SiteSmtpPort" value="{$clsConfiguration->getValue('SiteSmtpPort')}"/>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="iso_box">
                    <p class="iso_title">{$core->get_Lang('SMTP Host')} </p>
                    <span class="notice-full">( {$core->get_Lang('The host your mail server uses')} <strong class="color_r">smtp.gmail.com</strong>, <strong class="color_r">mail.yahoo.com</strong> )</span>
                </div>
                <input type="text" class="iso_select" name="iso-SiteSmtpHost" value="{$clsConfiguration->getValue('SiteSmtpHost')}"/>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6">
                <p class="iso_title">{$core->get_Lang('SMTP Username')}</p>
                <input type="text" class="iso_select" name="iso-SiteSmtpUsername" value="{$clsConfiguration->getValue('SiteSmtpUsername')}"/>
            </div>
            <div class="col-12 col-lg-6">
                <p class="iso_title">{$core->get_Lang('SMTP Password')}</p>
                <input type="password" class="iso_select" name="iso-SiteSmtpPassword" value="{$clsConfiguration->getValue('SiteSmtpPassword')}"/>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p class="iso_title">{$core->get_Lang('SMTP SSL Type')}</p>
                <div class="iso_box_input">
                    <label>
                        <input name="iso-SiteSmtpSSL" {if $clsConfiguration->getValue('SiteSmtpSSL') eq 'none' or $clsConfiguration->getValue('SiteSmtpSSL') eq ''}checked="checked"{/if} type="radio" value="none"/>
                        None
                    </label>
                    <label>
                        <input {if $clsConfiguration->getValue('SiteSmtpSSL') eq 'ssl'}checked="checked"{/if} name="iso-SiteSmtpSSL" type="radio" value="ssl"/> 
                        SSL
                    </label>
                    <label>
                        <input {if $clsConfiguration->getValue('SiteSmtpSSL') eq 'tls'}checked="checked"{/if} name="iso-SiteSmtpSSL" type="radio" value="tls"/> 
                        TLS
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p class="iso_title">{$core->get_Lang('System Emails From Name')}</p>
                <input class="iso_select" type="text" name="iso-SiteReplyName" value="{$clsConfiguration->getValue('SiteReplyName')}">
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p class="iso_title">{$core->get_Lang('System Emails From Email')}</p>
                <input class="iso_select" type="text" name="iso-SiteReplyEmail" value="{$clsConfiguration->getValue('SiteReplyEmail')}">
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p class="iso_title">{$core->get_Lang('Send Test Email')}</p>
                <div class="iso_send_test">
                    <input type="email" class="span50 text" name="email_test" id="email_test" placeholder="Ex: {$clsConfiguration->getValue('CompanyEmail')}">
                    <div class="box_mail_item">
                        <a href="javascript:void()" class="iso-button-primary SiteSendTest">
                            <i class="fa fa-paper-plane"></i> Send Test Email
                        </a>
                        <span id="testmail"></span>
                    </div>
                </div>
            </div>
        </div>
        <input value="{$action}" name="submit" type="hidden">
    </form>
</div>
<script type="text/javascript" src="{$URL_THEMES}/setting/jquery.setting.js"></script>