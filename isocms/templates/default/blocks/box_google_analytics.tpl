<!-- Sao chép và dán mã này làm mục đầu tiên trong <head> của mỗi trang web mà bạn muốn đo lường. -->
<!-- Global site tag (gtag.js) - Google Analytics -->
{assign var=SiteGoogleAnalyticsCode value=$clsConfiguration->getValue('SiteGoogleAnalyticsCode')}
{if $SiteGoogleAnalyticsCode}
<script async src="https://www.googletagmanager.com/gtag/js?id={$SiteGoogleAnalyticsCode}"></script>
{literal}
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', '{/literal}{$SiteGoogleAnalyticsCode}{literal}');
</script>
{/literal}
{/if}

