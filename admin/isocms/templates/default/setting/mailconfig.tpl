{literal}
    <style>
        #clienttabs > ul > li > a {
            padding: 0px 10px !important;
        }
    </style>
{/literal}
<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$curl}" title="{$mod}">{$core->get_Lang('mailconfig')}</a>
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2><i class="fa fa-wrench"></i> {$core->get_Lang('mailconfig')}</h2>
        <p>{$core->get_Lang('systemmanagementsettings')}</p>
    </div>
    <div class="clearfix"></div>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="{$action|default:''}" value="{$action|default:''}">
        <table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
            <tr>
                <td class="fieldlabel span25">{$core->get_Lang('Mail type')}</td>
                <td class="fieldarea">
                    <select class="select slb span20" name="iso-SiteMailType"
                            style="padding: 6px;height: 33px;font-size: 13px;line-height: 19px;font-weight: 400;">
                        <option {if $clsConfiguration->getValue('SiteMailType') eq 'sendgrid'}selected="selected"{/if}
                                value="sendgrid"> -- SendGrid --
                        </option>
                        <option {if $clsConfiguration->getValue('SiteMailType') eq 'smtp'}selected="selected"{/if}
                                value="smtp"> -- SMTP --
                        </option>
                        <option {if $clsConfiguration->getValue('SiteMailType') eq 'mail'}selected="selected"{/if}
                                value="mail"> -- PHP Mail() --
                        </option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="fieldlabel">{$core->get_Lang('Mail Encoding')}</td>
                <td class="fieldarea">
                    <select class="select slb span20" name="iso-SiteMailEncoding"
                            style="padding: 6px;height: 33px;font-size: 13px;line-height: 19px;font-weight: 400;">
                        <option {if $clsConfiguration->getValue('SiteMailEncoding') eq '8bit'}selected="selected"{/if}
                                value="8bit"> -- 8bit --
                        </option>
                        <option {if $clsConfiguration->getValue('SiteMailEncoding') eq '7bit'}selected="selected"{/if}
                                value="7bit"> -- 7bit --
                        </option>
                        <option {if $clsConfiguration->getValue('SiteMailEncoding') eq 'binary'}selected="selected"{/if}
                                value="binary"> -- binary --
                        </option>
                        <option {if $clsConfiguration->getValue('SiteMailEncoding') eq 'base64'}selected="selected"{/if}
                                value="base64"> -- base64 --
                        </option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="fieldlabel">{$core->get_Lang('SMTP Port')}</td>
                <td class="fieldarea">
                    <input type="number" class="text full span20" name="iso-SiteSmtpPort"
                           value="{$clsConfiguration->getValue('SiteSmtpPort')}"/>
                    <span class="notice-short">{$core->get_Lang('The port your mail server uses')}</span>
                </td>
            </tr>
            <tr>
                <td class="fieldlabel">{$core->get_Lang('SMTP Host')}</td>
                <td class="fieldarea">
                    <input type="text" class="text span50" name="iso-SiteSmtpHost"
                           value="{$clsConfiguration->getValue('SiteSmtpHost')}"/>
                    <span class="notice-full">{$core->get_Lang('The host your mail server uses')} <strong
                                class="color_r">smtp.gmail.com</strong>, <strong class="color_r">mail.yahoo.com</strong></span>
                </td>
            </tr>
            <tr>
                <td class="fieldlabel">{$core->get_Lang('SMTP Username')}</td>
                <td class="fieldarea">
                    <input type="text" class="text span50" name="iso-SiteSmtpUsername"
                           value="{$clsConfiguration->getValue('SiteSmtpUsername')}"/>
                </td>
            </tr>
            <tr>
                <td class="fieldlabel">{$core->get_Lang('SMTP Password')}</td>
                <td class="fieldarea">
                    <input type="password" class="text span50" name="iso-SiteSmtpPassword"
                           value="{$clsConfiguration->getValue('SiteSmtpPassword')}"/>
                </td>
            </tr>
            <tr>
                <td class="fieldlabel">{$core->get_Lang('SMTP SSL Type')}</td>
                <td class="fieldarea">
                    <label><input name="SiteSmtpSSL"
                                  {if $clsConfiguration->getValue('SiteSmtpSSL') eq 'none' or $clsConfiguration->getValue('SiteSmtpSSL') eq ''}checked="checked"{/if}
                                  type="radio" value="none"/> None</label>
                    <label><input {if $clsConfiguration->getValue('SiteSmtpSSL') eq 'ssl'}checked="checked"{/if}
                                  name="SiteSmtpSSL" type="radio" value="ssl"/> SSL</label>
                    <label><input {if $clsConfiguration->getValue('SiteSmtpSSL') eq 'tls'}checked="checked"{/if}
                                  name="SiteSmtpSSL" type="radio" value="tls"/> TLS</label>
                </td>
            </tr>
            <tr>
                <td class="fieldlabel">{$core->get_Lang('System Emails From Name')}</td>
                <td class="fieldarea">
                    <input style="width:50%;" type="text" class="text" name="iso-SiteReplyName"
                           value="{$clsConfiguration->getValue('SiteReplyName')}">
                </td>
            </tr>
            <tr>
                <td class="fieldlabel">{$core->get_Lang('System Emails From Email')}</td>
                <td class="fieldarea">
                    <input class="span50 text" type="text" name="iso-SiteReplyEmail" value="{$clsConfiguration->getValue('SiteReplyEmail')}">
                </td>
            </tr>
            <tr>
                <td class="fieldlabel">{$core->get_Lang('Send Test Email')}</td>
                <td class="fieldarea">
                    <div class="box_mail">
                        <input type="email" class="span50 text" name="email_test" id="email_test"
                               placeholder="Ex: {$clsConfiguration->getValue('CompanyEmail')}">
                        <div class="box_mail_item">
                            <a href="javascript:void()" class="iso-button-primary SiteSendTest">
                                <i class="fa fa-paper-plane"></i> Send Test Email
                            </a>
                            <span id="testmail"></span>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <fieldset class="submit-buttons">
            {$saveBtn}
            <input value="UpdateConfiguration" name="submit" type="hidden">
        </fieldset>
    </form>
</div>
<script type="text/javascript" src="{$URL_THEMES}/setting/jquery.setting.js"></script>
{literal}
    <style>
        .box_mail {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .box_mail_item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
    </style>
    <script type="text/javascript">
        $(function () {
            $('select[name^=iso]').each(function () {
                var $_this = $(this);
                if ($_this.val() == 1) {
                    $_this.css({'border-color': '#0C0', 'background': '#e9ffd9'});
                }
            });
        });
    </script>
{/literal}