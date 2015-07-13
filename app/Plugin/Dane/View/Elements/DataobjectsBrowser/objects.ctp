<?
if (isset($objects)) {
    if (empty($objects)) {
        echo '<p class="noResults">' . __d('dane', 'LC_DANE_BRAK_WYNIKOW') . '</p>';
    } else {
        ?>
        <ul class="list-group list-dataobjects">
            <?
            foreach ($objects as $object) {

                echo $this->Dataobject->render($object['Dataobject'], (isset($renderFile) && $renderFile) ? $renderFile : 'default', array(
                    'hlFields' => $dataBrowser->hlFields,
                    'hlFieldsPush' => $dataBrowser->hlFieldsPush,
                    'routes' => $dataBrowser->routes,
                    'forceLabel' => in_array($page['mode'], array('*', 'datachannel')),
                    'defaults' => $defaults,
                ));
            }
            ?>
        </ul>
    <?
    }
}
?>