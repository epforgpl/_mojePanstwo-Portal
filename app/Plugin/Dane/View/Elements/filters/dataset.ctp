<ul class="options list-group">
    <?
    $field = $filter['filter']['field'];
    $name = str_replace('.', ':', $field);
    $value = array_key_exists($field, $conditions) ? $conditions[$field] : false;

    $href_base = '';

    $dictionary = isset($filter['filter']['dictionary']) ? $filter['filter']['dictionary'] : array();

    if ($parts = explode('/', $this->request->url)) {

        $parts = array_filter($parts);
        array_pop($parts);
        $href_base = '/' . implode('/', $parts) . '/';

    }

    if (isset($facet['params']['options']) && is_array($facet['params']['options']) && !empty($facet['params']['options'])) {
        foreach ($facet['params']['options'] as $option) {

            // debug($option, true, false);

            $fid = 'filter_input_' . $field . $option['id'];
            if (is_array($value)) {
                $checked = in_array($option['id'], $value);
            } else {
                $checked = ($option['id'] == $value);
            }

            ?>
            <li class="option checkbox list-group-item<? if ($checked) { ?> active<? } ?>">


                <div class="checkbox-inline">

                    <?

                    $_dataset = $option['id'];
                    $_label = $option['label'];

                    if (array_key_exists($_dataset, $dictionary)) {

                        $_dictionary = $dictionary[$_dataset];
                        $_dataset = $_dictionary['href'];
                        $_label = $_dictionary['label'];

                    }
                    ?>


                    <a href="<?= $href_base . $_dataset ?><? if (isset($this->request->query['q'])) {
                        echo addslashes("?q=" . $this->request->query['q']);
                    } ?>" target="_self"><?= $this->Text->truncate($_label, 27) ?></a>
					<span
                        class="badge"><?= $this->Number->currency($option['count'], '', array('places' => 0)) ?></span>

                </div>

            </li>
        <?
        }
    }
    ?>
</ul>