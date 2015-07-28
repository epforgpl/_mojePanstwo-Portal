<?
$this->Combinator->add_libs('css', $this->Less->css('view-administracjapubliczna', array('plugin' => 'Dane')));
// ////$this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane')));

echo $this->Element('dataobject/pageBegin');
?>

    <div class="administracjaPubliczna row">

        <div class="col-md-10 col-md-offset-1">
            <div class="object">

                <h1 class="light"><a href="<?= $object->getUrl() ?>"
                                     class="btn-back glyphicon glyphicon-circle-arrow-left"></a> Instytucje nadzorowane
                    przez <?= $object->getTitle() ?></h1>

                <?
                $tree = $object->getLayer('tree');
                $items = $tree['items'];
                ?>

                <div class="block">
                    <div class="tree">
                        <ul>
                            <li>
                                <?
                                echo $this->Element('Dane.objects/instytucje/list', array(
                                    'items' => $items,
                                    'i' => 0,
                                ));
                                ?>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

    </div>

<?= $this->Element('dataobject/pageEnd'); ?>