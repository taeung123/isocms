</div>
</div>
</div>
<div class="clearfix"></div>
<div class="page-footer">
    Powered by ISOCMS &copy; 2006-{'Y'|date} <a href="http://www.vietiso.com/">VietISO</a><br/>
    Developed by VietISO Technical Team. Email: <a href="mailto:support@vietiso.com">support@vietiso.com</a>.
</div>
{if $update_sitemap}
    <img src="{$DOMAIN_NAME}/inc/tech/sitemapvis.php?token={$clsISO->hashHmacIsoCms()}" style="display:none"/>
{/if}
</div>

<div class="ticket-now">
    <div class="in-ticket-now" data-total="1"></div>
</div>
<div class="pop-ticket-now">
    <div class="d-flex" style="align-items: center; justify-content: space-between">
        <img src="{$URL_IMAGES}/ticket/viso-logo.png" alt="">
        <span class="close-pop-ticket-now">{makeIMO('minimize')}</span>
    </div>
    <p class="bold font-18 mt-20">{__('Contact VietISO team')}</p>
    <p class="font-14 mb-5">{__('ticket_now_content')}</p>
    <a class="btn btn-warning color-fff w-100" href="{$clsISO->getLinkTicket('my_ticket')}"
       target="_blank">{__('Send Ticket')}</a>
    <p class="mt-20 text-center underline"><a href="{$clsISO->getLinkTicket('ticket')}"
                                              target="_blank">{__('Access the documentation')}</a></p>
</div>
{literal}
    <script type="text/javascript">
        $(".toggle-row").click(function () {
            var $_this = $(this);
            if ($_this.parents("tr").hasClass("open_tr")) {
                $_this.closest("tr").removeClass("open_tr");
                $_this.closest("tr").find(".fa-caret").removeClass("fa-caret-up");
            } else {
                $_this.parents("tr").addClass("open_tr");
                $_this.closest("tr").find(".fa-caret").addClass("fa-caret-up");
            }
        });
    </script>
{/literal}