	<?

App::uses('ApplicationsController', 'Controller');

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
    }

    public function filmy()
    {
        $this->title = 'Tutoriale video';
    }

    public function dane_osobowe()
    {
        $this->title = 'Ochrona danych osobowych';
    }

    public function getChapters() {

		$mode = false;
		$items = array();
		$app = $this->getApplication( $this->settings['id'] );

		$items[] = array(
			'label' => 'Pomoc',
			'href' => '/' . $this->settings['id'],
			'class' => '_label',
            'icon' => 'icon-applications-faq',
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
			'selected' => ($this->chapter_selected=='view') ? false : $this->chapter_selected,
		);

		return $output;

	}
}
