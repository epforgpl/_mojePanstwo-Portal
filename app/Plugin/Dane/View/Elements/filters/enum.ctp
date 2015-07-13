<ul class="options list-group">
    <?
    $field = $filter['filter']['field'];
    $name = str_replace('.', ':', $field);
    $value = array_key_exists($field, $conditions) ? $conditions[$field] : false;

    if (isset($facet['params']['options']) && is_array($facet['params']['options']) && !empty($facet['params']['options'])) {
        foreach ($facet['params']['options'] as $option) {

            if ($option['count']) {

                $fid = 'filter_input_' . $field . $option['id'];
                if (!$value) {
                    $checked = false;
                } elseif (is_array($value)) {
                    $checked = in_array($option['id'], $value);
                } else {
                    $checked = ($option['id'] == $value);
                }
                ?>
                <li class="option checkbox list-group-item<? if ($checked) { ?> active<? } ?>">
					<span
                        class="badge"><?= $this->Number->currency($option['count'], '', array('places' => 0)) ?></span>

                    <div class="checkbox-inline">
                        <input<? if ($checked) { ?> checked="checked"<? } ?> id="<?= $fid ?>" type="checkbox"
                                                                             name="<?= $name ?>[]"
                                                                             value="<?= $option['id'] ?>"/>
                        <label title="<?= addslashes($option['label']) ?>"
                               for="<?= $fid ?>"><?= $this->Text->truncate($option['label'], 45) ?></label>
                    </div>
                </li>

            <?
            }
        }
    }
    ?>
</ul>