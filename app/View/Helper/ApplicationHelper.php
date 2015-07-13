<?

App::uses('Helper', 'View');

class ApplicationHelper extends Helper
{

    public function renderHeader($application)
    {
        $application = $application['Application'];

        return '<div id="applicationHeader"><div class="container"><h1>' . $application['name'] . '</h1></div></div>';

    }

}