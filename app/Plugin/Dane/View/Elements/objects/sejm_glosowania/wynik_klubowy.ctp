<div class="wynikiKlubowe col-sm-<?= $width ?>">
    <p><?= $label ?>:</p>
    <ul>
        <?
        foreach ($items as $item) {
            $parts = explode("\t", $item);
            ?>
            <li>
                <a href="<?= $url ?>?poslowie_glosy:klub_id[]=<?= $parts[0] ?>"><?= $parts[1] ?></a>
                <? if ($parts[2]) { ?>
                    <span class="exception">z wyjątkiem <a
                            href="<?= $url ?>?poslowie_glosy:klub_id[]=<?= $parts[0] ?>&poslowie_glosy:bunt[]=1"><?= pl_dopelniacz($parts[2], 'posła', 'posłów', 'posłów') ?></a></span>
                <? } ?>
            </li>
        <?
        }
        ?>
    </ul>
</div>