<?

class Dataliner extends AppModel
{
    public function index($query)
    {

        App::import('model', 'Dane.Dataobject');
        $dataobject = new Dataobject();

        $data = array();

        if (!isset($query['page']) || !is_numeric($query['page'])) {
            $query['page'] = 1;
        }


        $conditions = isset($query['conditions']) ? $query['conditions'] : array();
        $facets = isset($query['facets']) ? $query['facets'] : array();
        $order = isset($query['order']) ? $query['order'] : '_date desc';

        $objects = $dataobject->find('all', array(
            'conditions' => $conditions,
            'order' => $order,
            'limit' => 20,
            'page' => $query['page'],
        ));

        foreach ($objects as $object) {

            $object = $object['Dataobject'];
            $data[] = array(
                'type' => 'blog_post',
                'date' => $object->getData('data_wejscia_w_zycie'),
                'title' => $object->getData('typ_nazwa'),
                'content' => '<a href="/dane/prawo/' . $object->getId() . '">' . $object->getTitle() . '</a>',
            );

        }

        return $data;

    }
}