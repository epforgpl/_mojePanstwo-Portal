<?

App::uses('ApplicationsController', 'Controller');

class ApiController extends ApplicationsController
{
	
	public $_layout = array(
        'header' => false,
        'body' => array(
            'theme' => 'default',
        ),
        'footer' => array(
            'element' => 'default',
        ),
    );
    
    public $helpers = array();

    public $components = array();

	public $settings = array(
		'id' => 'api',
	);
	
    public function beforeFilter()
    {
        parent::beforeFilter();
    }

    public function index()
    {
        header('Location: https://rejestr.io/api');
        $this->title = 'API - Buduj aplikacje w oparciu o dane publiczne';
    }
    
    public function bdl()
    {
        header('Location: https://rejestr.io/api');
        $this->title = 'API - Bank Danych Lokalnych';
    }
    
    public function sejmometr()
    {
        header('Location: https://rejestr.io/api');
        $this->title = 'API - Sejmometr';
    }
    
    public function finanse()
    {
        header('Location: https://rejestr.io/api');
        $this->title = 'API - Finanse';
    }
    
    public function krs()
    {
        header('Location: https://rejestr.io/api');
        $this->title = 'API - KRS';
    }
    
    public function zamowienia_publiczne()
    {
        header('Location: https://rejestr.io/api');
        $this->title = 'API - Zamówienia publiczne';
    }

    public function view($slug)
    {
        header('Location: https://rejestr.io/api');
        $uiRoot = Router::url(array('plugin' => 'api', 'controller' => 'api', 'action' => 'view', 'slug' => $slug), false);

        $this->chapter_selected = '';
        $this->set(compact('uiRoot', 'slug'));
    }
        
    public function getChapters() {

		$mode = false;
		$items = array();
		$app = $this->getApplication( $this->settings['id'] );
		
		$items[] = array(
			'label' => 'Krajowy Rejestr Sądowy',
			'href' => '/api/krs',
			'id' => 'krs',
			'icon' => 'icon-datasets-dot',
		);
		
		$items[] = array(
			'label' => 'Zamówienia publiczne',
			'href' => '/api/zamowienia_publiczne',
			'id' => 'zamowienia_publiczne',
			'icon' => 'icon-datasets-dot',
		);
		
		$items[] = array(
			'label' => 'Sejmometr',
			'href' => '/api/sejmometr',
			'id' => 'sejmometr',
			'icon' => 'icon-datasets-dot',
		);
		
		/*
		$items[] = array(
			'label' => 'Finanse',
			'href' => '/api/finanse',
			'id' => 'finanse',
			'icon' => 'icon-datasets-dot',
		);
		*/
		
		$items[] = array(
			'label' => 'Bank Danych Lokalnych',
			'href' => '/api/bdl',
			'id' => 'bdl',
			'icon' => 'icon-datasets-dot',
		);
        
		
		$output = array(
			'items' => $items,
			'selected' => ($this->chapter_selected=='view') ? false : $this->chapter_selected,
		);

		return $output;

	}
}