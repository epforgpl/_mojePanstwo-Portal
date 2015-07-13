<div id="docsToolbar">
    <div class="toolbarSticker">
        <div class="toolbarActions">
            <div class="docPages form-group">
                        <span
                            class="control-label"><?php echo __d('dane', 'LC_DANE_TOOLBAR_STRONA'); ?></span>
                <input type="text" name="document_page" value="1" class="form-control"
                       autocomplete="off"/>
                        <span
                            class="control-label"><?php echo __d('dane', 'LC_DANE_TOOLBAR_STRONA_Z') . ' ' . $document['pages_count']; ?></span>
            </div>
            <?php if ($document['packages_count'] > 1) { ?>
                <div class="docPagesAll">
                    <span><?php echo __d('dane', 'LC_DANE_TOOLBAR_LOADING_NEW'); ?></span>
                    <a href="#">
                        <?php echo __d('dane', 'LC_DANE_TOOLBAR_LOADING_ALL'); ?>
                    </a>
                </div>
            <?php } ?>
            <div class="docDownload">
                <a class="btn btn-default"
                   href="/docs/<?php echo $document['id']; ?>/download"><?php echo __d('dane', 'LC_DANE_TOOLBAR_DOWNLOAD'); ?></a>
            </div>
        </div>
    </div>
</div>