<div id="isoman-95" class="isoman-abs-layout-item isoman-grid" style="border-width: 0px 0px 0px; left: 0px; width: 962px; height: 426px;">
    <div class="isoman-grid-head" unselectable="true">
        <table id="isoman-95-head" class="isoman-grid-head">
            <tbody>
                <tr id="isoman-95-headr">
                    <td class="isoman-grid-head-item" style="width: 25px">
                        <div class="isoman-txt isoman-grid-cell"><i class="isoman-ico isoman-i-checkbox" unselectable="on"></i>&nbsp;</div>
                    </td>
                    <td class="isoman-grid-head-item">
                        <div class="isoman-txt isoman-grid-cell">Filename</div>
                    </td>
                    <td class="isoman-grid-head-item" style="width: 60px">
                        <div class="isoman-txt isoman-grid-cell">Size<i class="isoman-caret"></i></div>
                    </td>
                    <td class="isoman-grid-head-item" style="width: 70px">
                        <div class="isoman-txt isoman-grid-cell">Type<i class="isoman-caret"></i></div>
                    </td>
                    <td class="isoman-grid-head-item" style="width: 200px">
                        <div class="isoman-txt isoman-grid-cell">Size/Modification date<i class="isoman-caret isoman-up"></i><i class="isoman-caret"></i></div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div id="isoman-95-body" class="isoman-grid-body" style="width: 962px; height: 398px;">
        <table>
            <thead id="isoman-95-thead">
                <tr>
                    <td style="width: 25px">
                        <div class="isoman-txt isoman-grid-cell">0</div>
                    </td>
                    <td>
                        <div class="isoman-txt isoman-grid-cell">1</div>
                    </td>
                    <td style="width: 60px">
                        <div class="isoman-txt isoman-grid-cell">2</div>
                    </td>
                    <td style="width: 70px">
                        <div class="isoman-txt isoman-grid-cell">3</div>
                    </td>
                    <td style="width: 200px">
                        <div class="isoman-txt isoman-grid-cell">4</div>
                    </td>
                </tr>
            </thead>
            <tbody id="isoman-95-tbody">
                <? if (vnSessionGetVar("isoman_dir_root") != $dir) { ?>
                    <tr class="isoman-grid-row">
                        <td>
                            <div class="isoman-txt isoman-grid-cell">
                                <span class="isoman-txt isoman-reset" title="undefined">&nbsp;</span>
                            </div>
                        </td>
                        <td>
                            <div class="isoman-txt isoman-grid-cell isoman-open-path" style="cursor:pointer;" data-isoman-isparent="parent" isoman-dir="<?= $data_parent_dir ?>" isoman-url="<?= $data_parent_url ?>">
                                <i class="isoman-ico isoman-i-parent" unselectable="on"></i>
                                <span class="isoman-txt isoman-reset" title="..">..</span>
                            </div>
                        </td>
                        <td>
                            <div class="isoman-txt isoman-grid-cell">
                                <span class="isoman-txt isoman-reset" title="">&nbsp;</span>
                            </div>
                        </td>
                        <td>
                            <div class="isoman-txt isoman-grid-cell">
                                <span class="isoman-txt isoman-reset" title="undefined">&nbsp;</span>
                            </div>
                        </td>
                        <td>
                            <div class="isoman-txt isoman-grid-cell">
                                <span class="isoman-txt isoman-reset" title="-">-</span>
                            </div>
                        </td>
                    </tr>
                <? } ?>
                <? if (count($folders) > 0) {
                    foreach ($folders as $kf => $folder) { ?>
                        <tr class="isoman-grid-row" isoman_url="" isoman_dir="<?= "{$dir}/{$folder}" ?>" isoman_url="<?= $folder ?>" isoman_type="0">
                            <td>
                                <div class="isoman-txt isoman-grid-cell">
                                    <i class="isoman-ico isoman-i-checkbox" unselectable="on"></i>
                                    <span class="isoman-txt isoman-reset" title="undefined">&nbsp;</span>
                                </div>
                            </td>
                            <td>
                                <div class="isoman-txt isoman-grid-cell isoman-open-folder" style="cursor:pointer;" isoman_dir="<?= "{$dir}/{$folder}" ?>" isoman_url="<?= $folder ?>" data="<?= $folder ?>" isoman_type="0">
                                    <i class="isoman-ico isoman-i-folder" unselectable="on" isoman_dir="<?= "{$dir}/{$folder}" ?>" isoman_url="<?= $folder ?>" data="<?= $folder ?>" isoman_type="0"></i>
                                    <span class="isoman-txt isoman-reset" title="<?= $folder ?>"><?= $folder ?></span>
                                </div>
                            </td>
                            <td align="right">
                                <div class="isoman-txt isoman-grid-cell">
                                    <span class="isoman-txt isoman-reset" title="">
                                        -
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="isoman-txt isoman-grid-cell">
                                    <span class="isoman-txt isoman-reset" title="dir">
                                        dir
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="isoman-txt isoman-grid-cell">
                                    <span class="isoman-txt isoman-reset" title="'-'">
                                        -
                                    </span>
                                </div>
                            </td>
                        </tr>
                <? }
                } ?>

                <? foreach ($files as $kf => $file) {
                    $extension = $clsISO->getExtension($file['url']);  ?>
                    <tr class="isoman-grid-row" isoman_url="<?= $file['url'] ?>" isoman_dir="<?= $file['dir'] ?>" isoman_type="1">
                        <td>
                            <div class="isoman-txt isoman-grid-cell">
                                <i class="isoman-ico isoman-i-checkbox" unselectable="on"></i>
                                <span class="isoman-txt isoman-reset" title="undefined">&nbsp;</span>
                            </div>
                        </td>
                        <td>
                            <div class="isoman-txt isoman-grid-cell isoman-image-list" style="cursor:pointer;" isoman_dir="<?= $file['dir'] ?>" isoman_url="<?= $file['url'] ?>" data="<?= $file['url'] ?>" isoman_type="1">
                                <i class="isoman-ico isoman-i-file-image" unselectable="on" isoman_dir="<?= $file['dir'] ?>" isoman_url="<?= $file['url'] ?>" data="<?= $file['url'] ?>" isoman_type="1"></i>
                                <span class="isoman-txt isoman-reset" title="<?= $file['url'] ?>"><?= $file['url'] ?></span>
                            </div>
                        </td>
                        <td align="right">
                            <div class="isoman-txt isoman-grid-cell">
                                <span class="isoman-txt isoman-reset" title="">
                                    <?= isoman_FileSizeConvert(filesize($file['dir'])) ?>
                                </span>
                            </div>
                        </td>
                        <td>
                            <div class="isoman-txt isoman-grid-cell">
                                <span class="isoman-txt isoman-reset" title="dir">
                                    <?= $extension ?>
                                </span>
                            </div>
                        </td>
                        <td>
                            <div class="isoman-txt isoman-grid-cell">
                                <span class="isoman-txt isoman-reset" title="<?= date('d/m/Y h:i:s a', filemtime($file['dir'])) ?>">
                                    <?= date('d/m/Y h:i:s a', filemtime($file['dir'])) ?>
                                </span>
                            </div>
                        </td>
                    </tr>
                <? } ?>
            </tbody>
        </table>
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
</div>