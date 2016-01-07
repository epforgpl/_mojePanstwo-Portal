<?
App::uses('ApplicationsController', 'Controller', 'HttpSocket', 'Network/Http');

class PomocController extends ApplicationsController
{
    public $settings = array(
        'id' => 'pomoc',
    );

    public function index()
    {
        $this->title = 'Centrum pomocy';
    }

    public function instrukcje()
    {
        $this->title = 'Instrukcje';

        $me = 'http://local.wordpress.dev/wp-json/wp/v2/users/me';
        $client = new GuzzleHttp\Client();
        $json = $client->get($me, [
            'auth' => [
                'admin',
                'password'
            ]
        ]);
        $json = json_decode($json->getBody());
        var_dump($json);

        $HttpSocket = new HttpSocket();

        $results = $HttpSocket->post(
            'http://epf.org.pl/wp-json/wp/v2/posts'
        );
        debug($results);
        die();
    }

    public function filmy()
    {
        $this->title = 'Tutoriale video';
    }

    public function dane_osobowe()
    {
        $this->title = 'Ochrona danych osobowych';
    }

    public function getChapters()
    {

        $mode = false;
        $items = array();
        $app = $this->getApplication($this->settings['id']);

        $items[] = array(
            'label' => 'Pomoc',
            'href' => '/' . $this->settings['id'],
            'class' => '_label',
            'icon' => 'appIcon',
            'appIcon' => $app['icon'],
        );

        $items[] = array(
            'label' => 'Instrukcje',
            'href' => '/pomoc/instrukcje',
            'id' => 'instrukcje',
            'icon' => 'icon-datasets-dot',
        );

        $items[] = array(
            'label' => 'Tutoriale video',
            'href' => '/pomoc/filmy',
            'id' => 'filmy',
            'icon' => 'icon-datasets-dot',
        );

        $items[] = array(
            'label' => 'Ochrona danych osobowych',
            'href' => '/pomoc/dane_osobowe',
            'id' => 'dane_osobowe',
            'icon' => 'icon-datasets-dot',
        );


        $output = array(
            'items' => $items,
            'selected' => ($this->chapter_selected == 'view') ? false : $this->chapter_selected,
        );

        return $output;

    }

    function get_ePF_posts()
    {
        App::uses('HttpSocket', 'Network/Http');

        $HttpSocket = new HttpSocket();

        $results = $HttpSocket->post(
            'http://epf.org.pl/wp-json/wp/v2/posts'
        );
        debug($results);
        die();
    }
}
