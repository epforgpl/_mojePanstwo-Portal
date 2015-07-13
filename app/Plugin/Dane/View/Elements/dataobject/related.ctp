<?
if (
    ($object = $this->viewVars['object']) &&
    ($data = $object->getLayer('related')) &&
    (isset($data['groups'])) &&
    (!empty($data['groups']))
) {
    foreach ($data['groups'] as $group) {

        ?>
        <div class="col-lg-9">
            <div class="block">

                <h2><?php echo $group['title']; ?></h2>

                <div class="content">
                    <?
                    foreach ($group['objects'] as $obj) {

                        echo $this->Dataobject->render($obj, 'default');

                    }
                    ?>
                </div>

            </div>
        </div>
    <?

    }
}
