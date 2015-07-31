	<?

App::uses('ApplicationsController', 'Controller');

class ApiController extends ApplicationsController
{
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
		$this->menu_selected = 'view';
    }

    public function view($slug)
    {
        $uiRoot = Router::url(array('plugin' => 'api', 'controller' => 'api', 'action' => 'view', 'slug' => $slug), false);

        $this->menu_selected = $slug;
        $this->set(compact('uiRoot', 'slug'));
    }

    public function technical_info()
    {
    }
    
    public function getMenu()
    {
	    
	    $menu = array(
		    'items' => array(
			    array(
				    'label' => 'Start',
					'icon' => array(
						'src' => 'glyphicon',
						'id' => 'home',
					),
			    ),
			    array(
				    'id' => 'technical_info',
				    'label' => 'Opis techniczny',
			    ),
                array(
                    'id' => 'bdl',
                    'label' => 'Statystyki'
                )
		    ),
		    'base' => '/api',
	    );
	    return $menu;
	    
    }
}