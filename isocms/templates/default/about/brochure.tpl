<div class="page_container">
	<nav class="breadcrumb-main bg_fff">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="https://schema.org/BreadcrumbList">
						<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
							<a itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">
								<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>
							<meta itemprop="position" content="1" />
						</li>
						<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="current">
							<a itemprop="item" href="{$curl}" title="{$core->get_Lang('Trade Brochures')}">
								<span itemprop="name" class="reb">{$core->get_Lang('Trade Brochures')}</span></a>
							<meta itemprop="position" content="2" />
						</li>
					</ol>
				</div>
			</div>
		</div>
	</nav>
 	<section class="aboutPage whyPage">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="Aboutcontent">
						<h1 class="titlePage">{$core->get_Lang('Trade Brochures')}</h1>
						<ul class="list-brochure" id="listHolderView">  
							{assign var=totalDownload value=$listDownload|@count}    
							{section name=i loop=$listDownload}
							<li class="box bg_fff mb20" {if $smarty.section.i.iteration gt '4'}style="display:none"{/if}>
								<h3><a href="{$listDownload[i].attachment_file}" class="download" title="{$clsDownload->getTitle($listDownload[i].download_id)}">{$clsDownload->getTitle($listDownload[i].download_id)}</a></h3>
								{if $clsDownload->getIntro($listDownload[i].download_id) ne ''}
								<div class="formatTextIntro">{$clsDownload->getIntro($listDownload[i].download_id)}</div>
								{/if}
								<a href="{$listDownload[i].attachment_file}" class="download" title="{$core->get_Lang('Download')}">{$core->get_Lang('Download')} <span class="filesize">({$clsDownload->getFileSize($listDownload[i].download_id)}, {$clsDownload->getFileExtension($listDownload[i].download_id)})</span></a>
							</li>
							{/section}
							{if $totalDownload gt '4'}
							<div class="cleafix"></div>	
							<div id="load_more_collections" class="text_center">
								<a href="javascript:void(0);" rel="nofollow" page="1" class="btn_orance_border show-more" id="show-more"></a>
							</div>
							{/if} 
						</ul>   
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
{literal}
<script>
$(function(){	
    var $number_per_page = 4;	
    var $page =1;	
    var timer = '';
    $('#show-more').click(function(){
        var $_this = $(this);	
        clearTimeout(timer);	
        $page = $page+1;	
        timer = setTimeout(function(){	
            var $start = ($page-1)*$number_per_page;	
            var $end = $start + $number_per_page;	
            for(var i = $start; i < $end; i++){	
                $('.box').eq(i).show();	
            }	
        },500);
        /* Hide load more */	
        setInterval(function(){	
            loadPageFix();	
        },100);	
    });	
}); 
</script>
{/literal}