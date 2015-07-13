<?

App::uses('ApplicationsController', 'Controller');

class ApiController extends ApplicationsController
{
    public $helpers = array();

    public $components = array();

    public $uses = array('Api.Api');
	
	public $settings = array(
		'id' => 'api',
	);
	
    public function beforeFilter()
    {
        parent::beforeFilter();
    }

    public function index()
    {
        $apis = $this->Api->getAllApis();
		$this->menu_selected = 'view';
        $this->set(compact('apis'));
    }

    public function view($slug)
    {
        $apis = $this->Api->getAllApis();
        $api = null;
        foreach ($apis as $_api) {
            if ($_api['slug'] == $slug) {
                $api = $_api;
                break;
            }
        }

        if ($api == null) {
            throw new NotFoundException();
        }

        $uiRoot = Router::url(array('plugin' => 'api', 'controller' => 'api', 'action' => 'view', 'slug' => $slug), false);

        $this->set(compact('api', 'uiRoot'));
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
		    ),
		    'base' => '/api',
	    );
	    return $menu;
	    
    }
}