{assign var=link_event value=$clsISO->getLinkEvent($oneEvent.slug,$event_id)}
<div class="page_container page_ticket">
    <div class="ticket_social_box pdt10">
        <a class="w_100" target="_blank" href="{$link_event}" title="{$oneEvent.title}">
            <img src="{$oneOrder.img_ticket}" alt="{$oneEvent.title}">
        </a>
        <div class="share_social mt20 mb30 text-center">
            <a class="facebook mgr10" href="javascript:void(0);" rel="nofollow" onclick="javascript:generic_social_share('//www.facebook.com/sharer/sharer.php?u={$DOMAIN_NAME}{$link_event}&title={$oneEvent.title}');">
                <i class="fa fa-facebook" aria-hidden="true"></i>
                Facebook
            </a>
            <a class="twitter" href="javascript:void(0);" rel="nofollow" onclick="javascript:generic_social_share('//twitter.com/share?text={$oneEvent.title}&url={$DOMAIN_NAME}{$link_event}');">
                <i class="fa fa-twitter" aria-hidden="true"></i>
                Twitter
            </a>

        </div>
    </div>
</div>
<script type="text/javascript">
    var link_event = '{$DOMAIN_NAME}{$link_event}';
    var img_ticket = '{$oneOrder.img_ticket}';
    var event_id = '{$event_id}';
    var registration = '{$clsISO->getLink('registration')}';
    var registration_sponsor = '{$clsISO->getLink('registration_sponsor')}';
</script>
{literal}
    <style>
        .ticket_social_box{
            max-width: 100%;
            width: 544px;
            margin: 0 auto;
        }
        .ticket_social_box img{
            max-width: 100%;
        }
        .share_social .facebook {
            background-color: #3b5998;
            border-radius: 3px;
            padding: 5px 8px;
            display: inline-block;
            color: #fff;
            font-size: 15px;
        }
        .share_social .twitter {
            background-color: #1b95e0;
            border-radius: 3px;
            padding: 5px 8px;
            display: inline-block;
            color: #fff;
            font-size: 15px;
        }
        .share_social .twitter:hover,.share_social .twitter:focus{
            background-color: #0c7abf;
        }
        .share_social .facebook:hover,.share_social .facebook:focus{
            background-color: #3b5998;
        }
    </style>
    <script>
        function shareit(){
            var url=link_event; //Set desired URL here
            var img=img_ticket; //Set Desired Image here
            var totalurl=encodeURIComponent(url+'?img='+img);

            window.open ('http://www.facebook.com/sharer.php?u='+totalurl,'','width=500, height=500, scrollbars=yes, resizable=no');

        }
    </script>
{/literal}