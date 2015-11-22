<?php

App::uses('Component', 'Controller');

class LettersResponseFileComponent extends Component {

    public $components = array('S3', 'Auth', 'Session');

    private $name = 'letters_response_files';
    private static $path = 'letters/responses/';

    private static $extensions = array('pdf','docx','doc','tif','html','jpg','xml','xls','xlsx','rtf','png');

    public function save($file) {
        $ext = end(explode('.', $file['name']));
        $name = uniqid() . '.' . $ext;
        $content = file_get_contents($file['tmp_name']);

        $res = $this->S3->putObject(
            $content,
            S3Component::$bucket,
            self::$path . $name,
            S3::ACL_PRIVATE,
            array(),
            array('Content-Type' => $file['type'])
        );

        if(
            $content &&
            in_array($ext, self::$extensions) &&
            $res
        ) {
            $files = $this->Session->read($this->name);
            if (!$files)
                $files = array();

            $files[] = array(
                'filename' => $name,
                'src_filename' => $file['name']
            );
            $this->Session->write($this->name, $files);
            return true;
        }

        return false;
    }

    public function getFiles() {
        $files = $this->Session->read($this->name);
        return $files ? $files : array();
    }

    public function clear() {
        $this->Session->delete($this->name);
    }

    public function delete() {
        foreach($this->getFiles() as $file) {
            $this->S3->deleteObject(S3Component::$bucket, $this->name . $file['filename']);
        }

        $this->clear();
    }

    public function setName($name) {
        $this->name = $name;
    }

}
