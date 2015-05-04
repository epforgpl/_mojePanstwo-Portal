<?

class ApiController extends AppController
{
    public $helpers = array();

    public $components = array();

    public $uses = array('Api.Api');

    public function beforeFilter()
    {
        parent::beforeFilter();
    }

    public function index()
    {
        $apis = $this->Api->getAllApis();

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

        $this->set(compact('api'));
    }

    public function technical_info()
    {
    }
}