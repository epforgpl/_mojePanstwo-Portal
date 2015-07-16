<?php

class ProjectsController extends AppController {

    public $uses = array('Dane.Dataobject');
    public $components = array('RequestHandler', 'S3');

    public function index() {
        $dzialania = $this->getResponse('GET');
        $this->setResponse('dzialania', $dzialania);
    }

    public function add() {
        $id = (int) $this->getResponse('POST');
        if($id && strlen($this->request->data['cover_photo']) > 100) {
            $image = $this->request->data['cover_photo'];
            $ext = 'jpg';
            $x = (int) $this->request->data['x'];
            $y = (int) $this->request->data['y'];
            $zoom = ((float) $this->request->data['zoom']) * 100;
            $width = 810;
            $height = 320;

            $src = 'pages/dzialania/' . $this->request['dataset'] . '/' . $this->request['object_id'] . '/' . $id . '.' . $ext;
            $tmp_src = APP . 'tmp/' . $id . '.' .$ext;
            $tmp_src_zoom = APP . 'tmp/' . $id . '_zoom.' .$ext;
            $tmp_src_crop = APP . 'tmp/' . $id . '_crop.' .$ext;

            $data = explode(',', $image);
            $decoded = base64_decode($data[1]);

            $object = $this->S3->putObject(
                $decoded,
                S3Component::$bucket,
                'original/'.$src,
                S3::ACL_PUBLIC_READ,
                array(),
                array('Content-Type' => 'image/' . $ext)
            );

            $tmp_image = file_put_contents($tmp_src, file_get_contents('http://sds.tiktalik.com/portal/original/' . $src));
            exec("convert $tmp_src -resize $zoom% $tmp_src_zoom");

            $x = $x >= 0 ? '-' . $x : '+' . (-$x);
            $y = $y >= 0 ? '-' . $y : '+' . (-$y);

            exec("convert $tmp_src_zoom -crop {$width}x{$height}{$x}{$y}\! -background white -flatten $tmp_src_crop");

            $crop_image = file_get_contents($tmp_src_crop);

            $object = $this->S3->putObject(
                $crop_image,
                S3Component::$bucket,
                $src,
                S3::ACL_PUBLIC_READ,
                array(),
                array('Content-Type' => 'image/' . $ext)
            );

            unlink($tmp_src_crop);
            unlink($tmp_src_zoom);
            unlink($tmp_src);
        }

        $this->setResponse('success', $id);
    }

    public function view() {
        $dzialanie = $this->getResponse('GET');
        $this->setResponse('dzialanie', $dzialanie);
    }

    public function edit() {
        $success = $this->getResponse('PUT');
        $this->setResponse('success', $success);
    }

    public function delete() {
        $success = $this->getResponse('DELETE');
        $this->setResponse('success', $success);
    }

    /**
     * @desc Autocomplete `tematy`.`q`
     */
    public function tematy() {
        $response = $this->Dataobject->getDatasource()->request(
            'dane/tematy.json',
            array(
                'method' => 'GET',
                'data' => $this->request->query
            )
        );

        $values = array();
        foreach($response as $temat)
            $values[] = (object) array(
                'value' => $temat['id'],
                'label' => $temat['q']
            );

        $this->autoRender = false;

        return json_encode($values);
    }

    private function getResponse($method) {
        return $this->Dataobject->getDatasource()->request(
            'dane/' . $this->request['dataset'] . '/' . $this->request['object_id'] . '/pages/dzialania' .
            ( isset($this->request['id']) ? '/' . $this->request['id'] : '' ) .
            '.json',
            array(
                'method' => $method,
                'data' => $this->request->data,
            )
        );
    }

    private function setResponse($name, $value) {
        $this->set($name, $value);
        $this->set('_serialize', array($name));
    }

}