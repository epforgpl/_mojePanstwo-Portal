<?

class Mapaprawa extends AppModel
{

    public function getPath($object)
    {

        if (!$object) {
            return false;
        }

        $related = $object->loadRelated();

        $groups = $related['groups'];
        $path = array();
        $prev_object = false;


        for ($g = 0; $g < count($groups); $g++) {

            $group = $groups[$g];
            $objects = $group['objects'];


            for ($o = 0; $o < count($objects); $o++) {

                $object = $objects[$o];

                // var_export( $object ); die();

                $dataset = $object->getDataset();
                $main_icon = 'pass';
                $nodes = array(
                    array(
                        'id' => $object->getDataset() . '-' . $object->getId(),
                        'icon' => 'pass',
                        'status' => '1',
                        'parent_id' => $prev_object ? array($prev_object->getDataset() . '-' . $prev_object->getId()) : array(),
                    )
                );


                if ($dataset == 'rcl_etapy') {

                    $main_icon = 'doc';
                    $nodes = array(
                        array(
                            'id' => $object->getDataset() . '-' . $object->getId(),
                            'icon' => 'doc',
                            'status' => '1',
                            'parent_id' => $prev_object ? array($prev_object->getDataset() . '-' . $prev_object->getId()) : array(),
                        )
                    );

                } elseif ($dataset == 'sejm_posiedzenia_punkty') {

                    $nodes = array(
                        array(
                            'id' => $object->getDataset() . '-' . $object->getId(),
                            'icon' => 'pass',
                            'status' => '1',
                            'parent_id' => array($prev_object->getDataset() . '-' . $prev_object->getId()),
                        ),
                        array(
                            'id' => $object->getDataset() . '-' . $object->getId(),
                            'icon' => 'deny',
                            'status' => '0',
                        ),
                    );

                    $main_icon = 'pass';

                } elseif ($dataset == 'sejm_druki') {


                    $nodes = array(
                        array(
                            'id' => $object->getDataset() . '-' . $object->getId(),
                            'icon' => 'doc',
                            'status' => '1',
                            'parent_id' => array($prev_object->getDataset() . '-' . $prev_object->getId()),
                        ),
                    );

                    $main_icon = 'doc';

                } elseif ($dataset == 'sejm_zamrazarka') {

                    $nodes = array(
                        array(
                            'id' => $object->getDataset() . '-' . $object->getId(),
                            'icon' => 'doc',
                            'status' => '1',
                            'parent_id' => array($prev_object->getDataset() . '-' . $prev_object->getId()),
                        ),
                    );

                    $main_icon = 'doc';

                } elseif ($dataset == 'sejm_glosowania') {


                } elseif ($dataset == 'prawo') {

                    $nodes = array(
                        array(
                            'id' => $object->getDataset() . '-' . $object->getId(),
                            'icon' => 'accept',
                            'status' => '1',
                            'parent_id' => array($prev_object->getDataset() . '-' . $prev_object->getId()),
                        ),
                    );

                    $main_icon = 'accept';

                }


                if ($dataset != 'sejm_glosowania') {

                    $label = $dataset;
                    $sublabel = '';

                    switch ($dataset) {

                        case 'rcl_etapy': {

                            $label = $object->getShortTitle();
                            break;

                        }

                        case 'sejm_posiedzenia_punkty': {

                            $label = 'Obrady Sejmu';
                            $sublabel = $object->getData('opis');
                            break;

                        }

                        case 'sejm_zamrazarka': {

                            $label = 'Projekt wpłynął do Sejmu';
                            break;

                        }

                        case 'sejm_druki': {

                            if ($object->getData('typ_id') == '1') {
                                $label = 'Projekt został doręczony posłom';
                            } else {
                                $label = $object->getData('druk_typ_nazwa');
                            }

                            $sublabel = 'Druk nr ' . $object->getData('numer');
                            break;

                        }

                        case 'prawo': {

                            $label = 'Publikacja ustawy w Dziennku Ustaw';
                            $sublabel = $object->getData('sygnatura');
                            break;

                        }

                    }

                    $path[] = array(
                        'id' => $object->getDataset() . '-' . $object->getId(),
                        'label' => $label,
                        'sublabel' => $sublabel,
                        'date' => $object->getDate(),
                        'icon' => $main_icon,
                        'nodes' => $nodes,
                    );

                    $prev_object = $object;

                }

            }
        }

        return $path;

    }

}