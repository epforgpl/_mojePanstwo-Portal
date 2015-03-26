<?

class mpapiComponent extends Component
{
    public $components = array('Session');

    public function initialize(Controller $controller)
    {

        if ($controller->Auth->loggedIn()) {
            $controller->API = $this->getAPI(array(
                'user_id' => $controller->Auth->user('id'),
            ));
        } else {
            $controller->API = $this->getAPI();
        }

        $data = $controller->API->Paszport()->info(array());


        // PROCESSING USER

        if (isset($data['user'])) {
            $this->User = $data['user'];
            $controller->Session->write('Auth.User', $this->User);
            $controller->set('_USER', $this->User);
        }

    }

    public static function getAPI($options = array())
    {
        $options = array_merge(array(
            'user_id' => SessionComponent::read('Auth.User.id'),
            'stream_id' => SessionComponent::read('Stream.id'),
        ), $options);

        require_once(MPAPI_path . 'loader.php');

        return new MP\API($options);

    }

}