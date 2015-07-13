<?

namespace MP\Lib;

class Sejm_wystapienia extends DataObject
{

    protected $tiny_label = 'Wystąpienie w Sejmie';

    public function __construct($params = array())
    {
        parent::__construct($params);
        $this->data['stanowisko_mowca'] = $this->data['stanowiska.nazwa'] . ' ' . $this->data['ludzie.nazwa'];
    }

    protected $schema = array(
        array('stanowisko_mowca', 'Mówca', 'string', array(
            'link' => array(
                'dataset' => 'poslowie',
                'object_id' => '$ludzie.posel_id',
            ),
        )),
        array('sejm_debaty.tytul', 'Debata', 'string', array(
            'truncate' => 90,
        )),
        array('data', 'Data wystąpienia', 'date'),
    );

    protected $routes = array(
        'title' => 'skrot',
        'shortTitle' => false,
        'date' => 'data',
    );

    protected $hl_fields = array(
        'stanowisko_mowca', 'sejm_debaty.tytul'
    );

    public function getLabel()
    {
        return '<strong>Wystąpienie</strong> w Sejmie';
    }

    public function getThumbnailUrl($size = '0')
    {

        return false;

    }

    public function hasHighlights(){
        return false;
    }

    public function getUrl() {

        $output = '/dane';

        if( $this->getData('punkt_id') ) {

            $output .= '/sejm_posiedzenia_punkty/' . $this->getData('punkt_id');

            if( $this->getData('debata_id') ) {

                $output .= '/debaty/' . $this->getData('debata_id');

            }

        } elseif( $this->getData('debata_id') ) {

            $output .= '/sejm_debaty/' . $this->getData('debata_id');

        }

        $output .= '/wystapienia/' . $this->getId();

        return $output;

    }

}