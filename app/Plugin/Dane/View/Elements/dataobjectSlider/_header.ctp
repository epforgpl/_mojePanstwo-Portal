<div class="header">
    <?
    if (isset($options['labelMode']) && ($options['labelMode'] == 'none')) {
    } else {
        ?>
        <p><?= $object->getFullLabel(); ?></p>
    <?
    }

    if (isset($options['dfFields']) && !empty($options['dfFields'])) {
        $fields = $object->getHiglightedFields($options['dfFields']);
        foreach ($fields as $field) {

            echo $this->Dataobject->getHTMLForField(false, $field, array(
                'col_width' => false,
            ));

        }
    }
    ?>
</div>