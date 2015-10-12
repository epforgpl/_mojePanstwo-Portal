<?php

App::uses('Component', 'Controller');

class LettersResponseFileComponent extends Component {

    public $components = array('S3', 'Auth', 'Session');

    private static $name = 'letters_response_files';
    private static $path = 'letters/responses/%s';

    public function save($file) {
        $name = uniqid() . '.' . end(explode('.', $file['name']));
        $content = file_get_contents($file['tmp_name']);

        if($content && $this->S3->putObject(
            $content,
            S3Component::$bucket,
            printf(self::$path, $name),
            S3::ACL_PRIVATE,
            array(),
            array('Content-Type' => $file['type'])
        )) {
            $files = $this->Session->read(self::$name);
            if (!$files)
                $files = array();

            $files[] = $name;
            $this->Session->write(self::$name, $files);
            return true;
        }

        return false;
    }

    public function getFiles() {
        $files = $this->Session->read(self::$name);
        return $files ? $files : array();
    }

    public function clear() {
        $this->Session->delete(self::$name);
    }

}
