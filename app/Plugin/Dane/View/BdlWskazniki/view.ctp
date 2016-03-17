<?
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock', false);
$this->Combinator->add_libs('js', '../plugins/highstock/locals', false);

$this->Combinator->add_libs('js', 'Dane.view-bdl-wskazniki-map', false);
$this->Combinator->add_libs('js', 'Bdl.bdl_subitem');
?>

<?= $this->Element('dataobject/pageBegin', array('renderFile' => 'page-bdl_wskazniki')); ?>

<?= $this->Element('bdl_select', array('expand_dimension' => $expand_dimension, 'dims' => $dims)); ?>
<div class="row">
    <div id="bdl-wskazniki" class="col-xs-12 col-sm-12 col-md-12">
        <? if (in_array('bdl_opis', $object_editable)) {
            echo $this->element('Dane.bdl_opis');
        } ?>

        <div class="object">
            <?
            if (!empty($expanded_dimension)) {
                foreach ($expanded_dimension['options'] as $option) {
                    if (isset($option['data'])) {
                        echo $this->element('Dane.bdl_wskaznik', array(
                            'data' => $option['data'],
                            'url' => $object->getUrl(),
                            'title' => $option['value'],
                        ));
                    }
                }
            }
            ?>
        </div>
    </div>
</div>

<p class="msg-link">Źródło danych: <a href="https://bdl.stat.gov.pl/BDL/start" target="_blank">Główny Urząd Statystyczny</a></p>

<?= $this->Element('dataobject/pageEnd'); ?>
