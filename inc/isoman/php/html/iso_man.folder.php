<div id="isoman-64-absend" class="isoman-abs-end"></div>
<div id="isoman-path" class="isoman-path isoman-first isoman-abs-layout-item" style="left: 0px; top: 0px; width: 962px; height: 32px;">
    <div role="button" class="isoman-path-item isoman-open-path" isoman-dir="<?= $isoman_dir_root ?>" isoman-url="<?= $isoman_url_root ?>">
        root
    </div>
    <?php
    if (vnSessionGetVar("isoman_dir_root") != $dir) {
        $currentPath = $isoman_dir_root;
        $currentUrl  = $isoman_url_root;

        foreach ($dirArr as $key => $item) {
            if ($key > 0) {
                $currentPath .= '/' . $item;
                $currentUrl  .= '/' . $item;
    ?>
                <div class="isoman-divider" aria-hidden="true"> / </div>
                <div
                    role="button"
                    class="isoman-path-item isoman-open-path"
                    isoman-dir="<?= $currentPath ?>"
                    isoman-url="<?= $currentUrl ?>">
                    <?= htmlspecialchars($item) ?>
                </div>
    <?php
            }
        }
    }
    ?>

</div>
<div id="isoman-main-container" class="isoman-thumbnailview isoman-container isoman-last isoman-abs-layout-item" role="undefined" style="border-width: 1px 0px 0px; left: 0px; top: 32px; width: 962px; height: 426px;">
    <div id="isoman-main-container-body" class="isoman-container-body isoman-flow-layout" style="width: 962px; height: 426px;">
        <div style="display: flex; flex-direction: column; gap: 20px; padding: 10px 0">
            <div>
                <div id="iso_man_folders">
                    <? if (vnSessionGetVar("isoman_dir_root") != $dir) { ?>
                        <div class="isoman-image isoman-path-item isoman-open-path" unselectable="on" data-isoman-isparent="parent" isoman-dir="<?= $data_parent_dir ?>" isoman-url="<?= $data_parent_url ?>">
                            <i class="isoman-ico isoman-thumb isoman-i-parent"></i>
                            <div class="isoman-info" title="..">..</div>
                        </div>
                    <? } ?>
                    <? if (count($folders) > 0) {
                        foreach ($folders as $kf => $folder) {
                            $isoman_full_url = $url . '/' . $folder;
                            $isoman_short_url = $isoman_full_url; ?>
                            <div isoman_dir="<?= "{$dir}/{$folder}" ?>" isoman_url="<?= "{$isoman_short_url}" ?>" isoman_type="0" class="isoman-image" unselectable="on" data-isoman-isparent="">
                                <i class="isoman-ico isoman-thumb isoman-i-folder" isoman_dir="<?= "{$dir}/{$folder}" ?>" isoman_url="<?= $isoman_short_url ?>" data="<?= $folder ?>" isoman_dir="<?= "{$dir}/{$folder}" ?>" isoman_type="0"></i>
                                <div class="isoman-info isoman-open-folder" isoman_dir="<?= "{$dir}/{$folder}" ?>" isoman_url="<?= $isoman_short_url ?>" title="<?= $folder ?>">
                                    <i class="isoman-ico isoman-i-checkbox" isoman_dir="<?= "{$dir}/{$folder}" ?>" isoman_type="0"></i>
                                    <?= $folder ?>
                                </div>
                            </div>
                    <? }
                    } ?>
                </div>
            </div>
            <? if (count($files) > 0) { ?>
                <div style="display: flex; flex-direction: column;">
                    <h3 style="padding: 0 5px;">🖼️ <?= $core->get_Lang('Images') ?></h3>
                    <div id="iso_man_images">
                        <? foreach ($files as $kf => $file) {
                            $extension = $clsISO->getExtension($file['url']);
                        ?>
                            <div isoman_dir="<?= $file['dir'] ?>" isoman_url="<?= $file['url'] ?>" isoman_type="1" class="isoman-image" unselectable="on" data-isoman-isparent="">
                                <? if (in_array($extension, $imgExtension)) { ?>
                                    <img src="<?= recove_images($file['url'], 100, 77) ?>" style="height:77px !important;width:100px !important; margin-top:0px !important;" extension="<?= $extension ?>">
                                <? } elseif (in_array($extension, $videoExtension)) { ?>
                                    <img src="/files/thumb?w=100&h=77&src=uploads/AdminButton/video_png.png" style="height:77px !important;width:100px !important; margin-top:0px !important;" extension="<?= $extension ?>">
                                <? } elseif (in_array($extension, $pdfExtension)) { ?>
                                    <img src="/files/thumb?w=100&h=77&src=uploads/AdminButton/icon_pdf.png" style="height:77px !important;width:100px !important; margin-top:0px !important;" extension="<?= $extension ?>">
                                <? } else { ?>
                                    <img src="/files/thumb?w=100&h=77&src=uploads/AdminButton/icon_file.png" style="height:77px !important;width:100px !important; margin-top:0px !important;" extension="<?= $extension ?>">
                                <? } ?>
                                <div class="isoman-info" title="<?= $clsISO->getFileName($file['url']) ?>">
                                    <i class="isoman-ico isoman-i-checkbox" isoman_url="<?= $file['url'] ?>" isoman_dir=" <?= $file['dir'] ?>" isoman_type="1"></i>
                                    <?= $clsISO->getFileName($file['url']) ?>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                    <? if ($totalPage > 1) { ?>
                        <div id="iso_man_pagination" style="display: flex; flex-wrap: wrap; gap: 5px 10px; padding: 10px;">
                            <? for ($i = 1; $i <= $totalPage; $i++) { ?>
                                <div class="isoman-pagination <?= $i == $page ? 'active' : '' ?>" data-page="<?= $i ?>" isoman-dir="<?= $dir ?>" isoman-url="<?= $url ?>">
                                    <?= $i ?>
                                </div>
                            <? } ?>
                        </div>
                    <? } ?>
                </div>
            <? } ?>
        </div>
    </div>
</div>