<?

$fid = 'switcher_input_' . $switcher['name'];
$fname = '!' . $switcher['name'];

$checked = (array_key_exists($fname, $conditions) && ($conditions[$fname] == '1'));

?>
<li class="option checkbox list-group-item<? if ($checked) { ?> active<? } ?>">
    <? /*<span class="badge"><?=$this->Number->currency($option['count'], '', array('places' => 0)) ?></span> */ ?>
    <div class="checkbox-inline">
        <input<? if ($checked) { ?> checked="checked"<? } ?> id="<?= $fid ?>" type="checkbox" name="<?= $fname ?>"
                                                             value="1"/>
        <label for="<?= $fid ?>"><?= $switcher['label'] ?></label>
    </div>
</li>