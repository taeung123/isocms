<div class="headPop">
    <a href="javascript:void();" class="closeEv close_pop"></a>
    <b>IsoManager</b>
</div>
<input type="hidden" id="clsTableCurrent" name="clsTable" value="<?= $clsTable ?>" />
<input type="hidden" class="isoman-current-for_id" value="<?= $for_id ?>" />
<input type="hidden" class="isoman-current-multiple-<?= $for_id ?>" value="<?= $isoman_multiple ?>" />
<input type="hidden" class="isoman-current-multiple-store-<?= $for_id ?>" value="" />
<input type="hidden" id="isoman-current-abs_url-<?= $for_id ?>" value="<?= $abs_url ?>" />
<input type="hidden" id="isoman-current-typelist-<?= $for_id ?>" value="<?= ($typelist == 1 ? '1' : '0') ?>" />
<input type="hidden" id="isoman-current-dir-<?= $for_id ?>" value="<?= $dir ?>" />
<input type="hidden" id="isoman-current-url-<?= $for_id ?>" value="<?= $url ?>" />
<input type="hidden" id="isoman-current-level-<?= $for_id ?>" value="<?= $level ?>" />
<input type="hidden" id="isoman-current-dir_root-<?= $for_id ?>" value="<?= vnSessionGetVar(" isoman_dir_root") ?>" />
<input type="hidden" class="isInIframe" id="isoman-current-isInIframe-<?= $for_id ?>" value="<?= $isInIframe ?>" />
<input type="hidden" id="isoman-current-domain-<?= $for_id ?>" value="<?= _isoman_domain ?>" />
<div id="isoman-46-body" class="isoman-container-body isoman-abs-layout" style="width: 962px; height: 498px;">
    <div id="isoman-46-absend" class="isoman-abs-end"></div>
    <div id="isoman-create" class="isoman-container isoman-panel isoman-first isoman-abs-layout-item" hidefocus="1" tabindex="-1" style="border-width: 0px 0px 1px; left: 0px; top: 0px; width: 962px; height: 38px;">
        <div id="isoman-47-body" class="isoman-container-body isoman-abs-layout" style="width: 962px; height: 38px;">
            <div id="isoman-47-absend" class="isoman-abs-end"></div>
            <div id="isoman-48" class="isoman-folder-create isoman-widget isoman-btn isoman-menubtn isoman-first isoman-abs-layout-item" tabindex="-1" role="button" aria-haspopup="true" aria-disabled="false" style="left: 4px; top: 4px; width: 95.8125px; height: 28px;" aria-expanded="true" title="' . $core->get_Lang('Create Folder') . '">
                <button id="isoman-48-open" role="presentation" type="button" tabindex="-1" style="height: 100%; width: 100%;">
                    <i class="isoman-ico isoman-i-create"></i><span>&nbsp;<?= $core->get_Lang('Folder') ?></span>
                </button>
            </div>
            <div id="isoman-49" class="isoman-widget isoman-btn isoman-abs-layout-item" tabindex="-1" role="button" aria-disabled="false" style="left: 105.8125px; top: 4px; width: 84.265625px; height: 28px;" title="<?= $core->get_Lang('Upload File') ?>">
                <form method="post" action="" enctype="multipart/form-data">
                    <button class="isoman-upload-file" role="presentation" type="button" tabindex="-1" style="height: 100%; width: 100%;" ondragover="return false">
                        <i class="isoman-ico isoman-i-upload"></i>&nbsp;<?= $core->get_Lang('Upload') ?>
                    </button>
                    <input class="isoman-upload-file-input" name="attachments[]" type="file" id="isoman-upload-file-<?= $for_id ?>" style="display:none;" multiple="multiple" />
                </form>
            </div>
            <div id="isoman-50" class="isoman-menu-paste isoman-widget isoman-btn isoman-abs-layout-item" tabindex="-1" role="button" style="display: none;left: 196.078125px;top: 4px;">
                <button role="presentation" type="button" tabindex="-1">
                    <i class="isoman-ico isoman-i-paste"></i>&nbsp;Paste
                </button>
            </div>
            <div id="isoman-action" class="isoman-widget isoman-btn isoman-menubtn isoman-abs-layout-item" tabindex="-1" role="button" aria-haspopup="true" aria-disabled="false" style="left: 196.078125px; top: 4px; width: 104.375px; height: 28px; display:none;" aria-expanded="true">
                <button id="isoman-51-open" role="presentation" type="button" tabindex="-1" style="height: 100%; width: 100%;">
                    <i class="isoman-ico isoman-i-manage"></i><span>&nbsp;Manage</span> <i class="isoman-caret"></i>
                </button>
            </div>
            <div id="isoman-52" class="isoman-abs-layout-item isoman-spacer" style="left: 306.453125px; top: 4px; width: 97.96875px; height: 0px;"></div>
            <div class="isoman-widget isoman-btn isoman-abs-layout-item" tabindex="-1" role="button" aria-labeledby="isoman-53" aria-label="Refresh file list" style="left: 490.421875px; top: 4px; width: 36px; height: 28px;">
                <button role="presentation" type="button" tabindex="-1" style="height: 100%; width: 100%;">
                    <i class="isoman-ico isoman-i-refresh" id="isoman-reload-<?= $for_id ?>" cval=""></i>
                </button>
            </div>
            <div id="isoman-54" class="isoman-container isoman-abs-layout-item isoman-btn-group" role="toolbar" style="left: 532.421875px; top: 4px; width: 74px; height: 30px;">
                <div id="isoman-54-body" style="width: 74px; height: 30px;">
                    <div id="isoman-55" typelist="1" class="isoman-widget isoman-switch isoman-btn isoman-first <?= ($typelist == 0 ? '' : 'isoman-active') ?>" tabindex="-1" role="button" aria-pressed="false" aria-labeledby="isoman-55" aria-label="List" style="margin-right:-5px;" title="<?= $core->get_Lang('View By List') ?>">
                        <button role="presentation" type="button" tabindex="-1" style="padding: 6px;"><i class="isoman-ico isoman-i-list"></i></button>
                    </div>
                    <div id="isoman-56" typelist="0" class="isoman-widget isoman-switch isoman-btn isoman-last <?= ($typelist == 1 ? '' : 'isoman-active') ?>" tabindex="-1" role="button" aria-labeledby="isoman-56" aria-label="Thumbnails" aria-pressed="true" title="<?= $core->get_Lang('View By Thumbail') ?>">
                        <button role="presentation" type="button" tabindex="-1" style="padding: 6px;"><i class="isoman-ico isoman-i-thumbs"></i></button>
                    </div>
                </div>
            </div>
            <div id="isoman-sort" class="isoman-widget isoman-btn isoman-menubtn isoman-abs-layout-item" tabindex="-1" role="button" aria-haspopup="true" style="left: 528.421875px; top: 4px; width: 59.578125px; height: 28px; display:none;">
                <button id="isoman-57-open" role="presentation" type="button" tabindex="-1" style="height: 100%; width: 100%;">
                    <span><?= $core->get_Lang('Sort') ?></span> <i class="isoman-caret"></i>
                </button>
            </div>
            <div id="isoman-58" class="isoman-combobox isoman-placeholder isoman-abs-layout-item isoman-has-open" aria-disabled="false" style="left: 594px; top: 4px; width: 200px; height: 30px;">
                <input id="isoman-search-<?= $for_id ?>" class="isoman-textbox isoman-placeholder isoman-search" value="" placeholder="<?= $core->get_Lang('Filter') ?>" hidefocus="true" style="width: 157px; margin-right:-5px;">
                <div id="isoman-58-open" class="isoman-btn isoman-open isoman-search-action" tabindex="-1">
                    <button id="isoman-search-action-<?= $for_id ?>" type="button" hidefocus="" tabindex="-1" style="padding: 6px;"><i class="isoman-ico isoman-i-search"></i></button>
                </div>
            </div>
            <div id="isoman-59" class="isoman-widget isoman-btn isoman-last isoman-abs-layout-item" tabindex="-1" role="button" aria-labeledby="isoman-59" aria-label="<?= $core->get_Lang('logout') ?>" style="left: 756px; top: 4px; width: 36px; height: 28px; display: none;">
                <button role="presentation" type="button" tabindex="-1" style="height: 100%; width: 100%;">
                    <i class="isoman-ico isoman-i-logout"></i>
                </button>
            </div>
        </div>
    </div>
    <div id="isoman-63" class="isoman-container isoman-panel isoman-last isoman-abs-layout-item" hidefocus="1" tabindex="-1" style="top: 39px; width: 962px; height: 459px;">
        <div id="isoman-63-body" class="isoman-container-body isoman-abs-layout isoman_container_body" style="width: 962px; height: 459px;">
            <div id="isoman-63-absend" class="isoman-abs-end"></div>
            <div id="isoman-64" class="isoman-container isoman-panel isoman-first isoman-last isoman-abs-layout-item" hidefocus="1" tabindex="-1" style="border-width: 0px; left: 0px; top: 0px; width: 962px; height: 459px;">
                <div id="isoman-64-body" class="isoman-container-body isoman-abs-layout" style="width: 962px; height: 459px;">
                    <div id="isoman-64-absend" class="isoman-abs-end"></div>
                    <div id="isoman-path" class="isoman-path isoman-first isoman-abs-layout-item" style="left: 0px; top: 0px; width: 962px; height: 32px;">

                    </div>
                    <div id="isoman-main-container" class="isoman-thumbnailview isoman-container isoman-last isoman-abs-layout-item" role="undefined" style="border-width: 1px 0px 0px; left: 0px; top: 32px; width: 962px; height: 426px;">
                        <div id="isoman-main-container-body" class="isoman-container-body isoman-flow-layout" style="width: 962px; height: 426px;">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="isoman-action-menu" class="isoman-container isoman-panel isoman-floatpanel isoman-menu isoman-menu-has-icons isoman-fixed isoman-menu-align" hidefocus="1" tabindex="-1" role="menu" style="border-width: 1px; z-index: 65540; <?= ($isInIframe == 1 ? 'left: 227.078125px;top: 87.5px;' : 'left: 449.078125px; top: 120.5px;') ?>  width: 178.5px; display:none;">
    <div id="isoman-309-body" class="isoman-container-body isoman-stack-layout" style="width: 178.5px;">
        <div id="isoman-menu-cut-<?= $for_id ?>" class="isoman-menu-cut isoman-menu-item isoman-menu-item-normal isoman-stack-layout-item isoman-first" tabindex="-1" role="menuitem">
            <i class="isoman-ico isoman-i-cut"></i>&nbsp;
            <span id="isoman-310-text" class="isoman-text"><?= $core->get_Lang('cut') ?></span>
            <div id="isoman-310-shortcut" class="isoman-menu-shortcut">Ctrl+X</div>
        </div>
        <div id="isoman-menu-copy-<?= $for_id ?>" class="isoman-menu-copy isoman-menu-item isoman-menu-item-normal isoman-stack-layout-item" tabindex="-1" role="menuitem">
            <i class="isoman-ico isoman-i-copy"></i>&nbsp;
            <span id="isoman-311-text" class="isoman-text"><?= $core->get_Lang('copy') ?></span>
            <div id="isoman-311-shortcut" class="isoman-menu-shortcut">Ctrl+C</div>
        </div>
        <div style="display:none;" id="isoman-menu-paste-<?= $for_id ?>" class="isoman-menu-paste isoman-menu-item isoman-menu-item-normal isoman-stack-layout-item" tabindex="-1" role="menuitem" aria-disabled="true">
            <i class="isoman-ico isoman-i-paste"></i>&nbsp;
            <span id="isoman-312-text" class="isoman-text"><?= $core->get_Lang('Paste') ?></span>
            <div id="isoman-312-shortcut" class="isoman-menu-shortcut">Ctrl+V</div>
        </div>
        <div id="isoman-313" class="isoman-menu-item isoman-menu-item-sep isoman-menu-item-normal isoman-stack-layout-item" tabindex="-1" role="separator"></div>
        <div id="isoman-menu-view-<?= $for_id ?>" class="isoman-disabled isoman-menu-view isoman-menu-item isoman-menu-item-normal isoman-stack-layout-item" tabindex="-1" role="menuitem" aria-disabled="false">
            <i class="isoman-ico isoman-i-view"></i>&nbsp;
            <span id="isoman-314-text" class="isoman-text"><?= $core->get_Lang('view') ?></span>
        </div>
        <div id="isoman-316" class="isoman-rename isoman-menu-item isoman-menu-item-normal isoman-stack-layout-item" tabindex="-1" role="menuitem" aria-disabled="false">
            <i class="isoman-ico isoman-i-none"></i>&nbsp;
            <span id="isoman-316-text" class="isoman-text"><?= $core->get_Lang('Rename') ?></span>
        </div>
        <!--<div id="isoman-317" class="isoman-menu-item isoman-menu-item-normal isoman-stack-layout-item" tabindex="-1" role="menuitem"><i class="isoman-ico isoman-i-download"></i>&nbsp;<span id="isoman-317-text" class="isoman-text">' . $core->get_Lang('Download') . '</span></div>
			<div id="isoman-319" class="isoman-menu-item isoman-menu-item-sep isoman-menu-item-normal isoman-stack-layout-item" tabindex="-1" role="separator"></div>-->
        <!--<div id="isoman-320" class="isoman-menu-item isoman-menu-item-normal isoman-stack-layout-item" tabindex="-1" role="menuitem"><i class="isoman-ico isoman-i-zip"></i>&nbsp;<span id="isoman-320-text" class="isoman-text">' . $core->get_Lang('Zip') . '</span></div>
			<div id="isoman-321" class="isoman-menu-item isoman-menu-item-normal isoman-stack-layout-item isoman-disabled" tabindex="-1" role="menuitem" aria-disabled="true"><i class="isoman-ico isoman-i-none"></i>&nbsp;<span id="isoman-321-text" class="isoman-text">' . $core->get_Lang('Unzip') . '</span></div>-->
        <div id="isoman-322" class="isoman-menu-item isoman-menu-item-sep isoman-menu-item-normal isoman-stack-layout-item" tabindex="-1" role="separator"></div>
        <div id="isoman-323" class="isoman-menu-remove isoman-menu-item isoman-menu-item-normal isoman-stack-layout-item isoman-last" tabindex="-1" role="menuitem">
            <i class="isoman-ico isoman-i-delete"></i>&nbsp;
            <span id="isoman-323-text" class="isoman-text"><?= $core->get_Lang('delete') ?></span>
            <div id="isoman-323-shortcut" class="isoman-menu-shortcut"><?= $core->get_Lang('delete') ?></div>
        </div>
    </div>
</div>
<div id="isoman-sort-menu" class="isoman-container isoman-panel isoman-floatpanel isoman-menu isoman-menu-has-icons isoman-fixed isoman-menu-align" hidefocus="1" tabindex="-1" role="menu" style="border-width: 1px; z-index: 65539; left: 781.421875px; top: 120.5px; width: 160px; display:none;">
    <div id="isoman-324-body" class="isoman-container-body isoman-stack-layout" style="width: 160px;">
        <div id="isoman-325" class="isoman-menu-item isoman-menu-item-checkbox isoman-first isoman-stack-layout-item isoman-active" tabindex="-1" role="menuitemcheckbox" aria-checked="true" aria-pressed="true">
            <i class="isoman-ico isoman-i-selected"></i>&nbsp;
            <span id="isoman-325-text" class="isoman-text"><?= $core->get_Lang('Name') ?></span>
        </div>
        <div id="isoman-326" class="isoman-menu-item isoman-menu-item-checkbox isoman-stack-layout-item" tabindex="-1" role="menuitemcheckbox" aria-checked="true" aria-pressed="false">
            <i class="isoman-ico isoman-i-selected"></i>&nbsp;
            <span id="isoman-326-text" class="isoman-text"><?= $core->get_Lang('Size') ?></span>
        </div>
        <div id="isoman-327" class="isoman-menu-item isoman-menu-item-checkbox isoman-stack-layout-item" tabindex="-1" role="menuitemcheckbox" aria-checked="true" aria-pressed="false">
            <i class="isoman-ico isoman-i-selected"></i>&nbsp;
            <span id="isoman-327-text" class="isoman-text"><?= $core->get_Lang('Type') ?></span>
        </div>
        <div id="isoman-328" class="isoman-menu-item isoman-menu-item-checkbox isoman-last isoman-stack-layout-item" tabindex="-1" role="menuitemcheckbox" aria-checked="true" aria-pressed="false">
            <i class="isoman-ico isoman-i-selected"></i>&nbsp;
            <span id="isoman-328-text" class="isoman-text"><?= $core->get_Lang('Modification date') ?></span>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-success isoman-insert" id="isoman-insert-<?= $for_id ?>" isoman_url="" style="display:none;">
        <?= $core->get_Lang('insert') ?>
    </button>
    <button class="btn btn-warning close_pop" data-dismiss="modal" aria-hidden="true"><?= $core->get_Lang('close') ?></button>
</div>