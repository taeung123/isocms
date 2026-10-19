<div class="list_work_step_insert">
	<div class="panel-group" id="accordion">
		{foreach from = $frames key = k item = frame name = root}
		{assign var = lstStep value = $frame.steps}
		<div class="panel panel-edited panel-default panel--{$k}" panel="{$panel}">
			<div class="panel-heading {if $panel eq $k} current{/if}">
				<a data-toggle="collapse" data-parent="#accordion" href="#{$k}" class="{if $panel eq $k}{else}collapsed{/if}">
					<h4 class="panel-title"><i class="ico ico-{$frame.icon}"></i>
					{$frame.name}
					</h4>
				</a>
			</div>
			<div id="{$k}" class="panel-collapse collapse {if $panel eq $k}in{else}{/if}">
				<div class="panel-body">
					<ul class="stepbar-list stepbar-list_{$pvalTable}">
						{foreach from = $lstStep key = key item = step name = cdn}
						<li><a href="javascript:void(0);" class="loadYieldStep{if $currentstep eq $key} active{/if} {if $step.status eq '1'}valid{/if}" data-route="{$clsISO->getLinkAdmin($mod)}/{$act}/{$pvalTable}/{$k}/{$key}" id="step_{$key}" data-table_id="{$pvalTable}" data-step="{$key}" panel="{$k}" title="{$step.name}">{$step.name}</a></li>
						{/foreach}
					</ul>
				</div>
			</div>
		</div>
		{/foreach}
	</div>
</div>