<div class="list_work_step_insert">
    <div class="panel-group" id="accordion">
        {foreach from=$frames key=k item=frame name=root}
        {assign var=lstStep value=$frame.steps}
        <div class="panel panel-edited panel-default panel--{$k}" panel="{$panel}">
            <div class="panel-heading {if $panel eq $k} current{/if}">
                <a data-bs-toggle="collapse" data-bs-parent="#accordion" href="#collapse_{$k}" class="{if $panel eq $k}{else}collapsed{/if}" aria-expanded="{if $panel eq $k}true{else}false{/if}">
                    <h4 class="panel-title"><i class="ico ico-{$frame.icon}"></i>
                    {$frame.name}
                    </h4>
                </a>
            </div>
            <div id="collapse_{$k}" class="panel-collapse collapse {if $panel eq $k}show{/if}">
                <div class="panel-body">
                    <ul class="stepbar-list stepbar-list_{$pvalTable}">
                        {foreach from=$lstStep key=key item=step name=cdn}
                        <li>
                            <a href="javascript:void(0);" 
                               class="loadYieldStep{if $currentstep|default:'' eq $key} active{/if} {if $step.status|default:'' eq '1'}valid{/if}" 
                               data-route="{$clsISO->getLinkAdmin($mod)}/{$act}/{$pvalTable}/{$k}/{$key}" 
                               id="step_{$key}" 
                               data-table_id="{$pvalTable}" 
                               data-step="{$key}" 
                               panel="{$k}" 
                               title="{$step.name}" 
                               data-step_id="{$step.id|default:0}">
                               {$step.name}
                            </a>
                        </li>
                        {/foreach}
                    </ul>
                </div>
            </div>
        </div>
        {/foreach}
    </div>
</div>
