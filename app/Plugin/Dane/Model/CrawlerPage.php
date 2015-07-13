<?

class CrawlerPage extends AppModel
{
    public function careIt($page)
    {

        $status = 200;
        $data = array();
        $content = '';

        $content .= '<br/><br/><p class="source"><a href="' . $page['url'] . '" title="' . $page['title'] . '" target="_blank">Source</a></p>';

        $url = 'http://hfhr.epf.org.pl/server.php';
        $params = array(
            'SECRET' => HFHR_SECRET,
            'title' => $page['title'],
            'content' => $content,
        );

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($params),
            ),
        );

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $response = @json_decode($response, true);

        if ($response) {
            $data = $response['data'];
            if (isset($data['post_id'])) {
                return 'http://hfhr.epf.org.pl/wp-admin/post.php?post=' . $data['post_id'] . '&action=edit';
            }
        } else {
            $status = 500;
        } // niezrozumiałe dane

        return false;
    }
}