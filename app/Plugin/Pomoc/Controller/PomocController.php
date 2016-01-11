<?
App::uses('ApplicationsController', 'Controller', 'HttpSocket', 'Network/Http');

class PomocController extends ApplicationsController
{

    public $_layout = array(
        'body' => array(
            'theme' => 'default',
        ),
    );

    public $settings = array(
        'id' => 'pomoc',
    );

    public function index()
    {
        $this->title = 'Centrum pomocy';
        $epfRSSFeed = $this->epfRSSFeed();
        $playListItems = $this->youtubeList(4);

        $this->set('epfRSSFeed', $epfRSSFeed);
        $this->set('ytPlaylist', $playListItems);
    }

    public function epfRSSFeed()
    {
        $rss = new DOMDocument();
        $rss->load('http://epf.org.pl/pl/category/moje-panstwo/feed/');

        $feed = array();
        foreach ($rss->getElementsByTagName('item') as $node) {
            $item = array(
                'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
                'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
                'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
            );
            array_push($feed, $item);
        }

        return ($feed);
    }

    public function youtubeList($limit)
    {
        $playlist_id = 'PLa_8n5BEWSbnvu-owdDAOCmD2dbI0Zosv';

        $client = new Google_Client();

        $client->setApplicationName(GOOGLE_API_ID);
        $client->setDeveloperKey(GOOGLE_API_SECRET);

        $youtube = new Google_Service_YouTube($client);

        $playlistItems = $youtube->playlistItems->listPlaylistItems('snippet', array(
            'playlistId' => $playlist_id,
            'maxResults' => $limit
        ));

        return $playlistItems['items'];
    }

    public function instrukcje()
    {
        $this->title = 'Instrukcje';
        $epfRSSFeed = $this->epfRSSFeed();

        $this->set('epfRSSFeed', $epfRSSFeed);
    }

    public function filmy()
    {
        $this->title = 'Tutoriale video';
        $playListItems = $this->youtubeList(50);

        $this->set('ytPlaylist', $playListItems);

    }

    public function dane_osobowe()
    {
        $this->title = 'Ochrona danych osobowych';
    }

    public function getChapters()
    {
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
}
