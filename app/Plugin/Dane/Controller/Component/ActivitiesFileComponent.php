<?php

App::uses('Component', 'Controller');

class ActivitiesFileComponent extends Component {

    public $components = array('S3', 'Auth', 'Session');

    private static $name = 'activities_files';
    private static $path = 'activities/files/';

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
            $files = $this->Session->read(self::$name);
            if (!$files)
                $files = array();

            $files[] = array(
                'filename' => $name,
                'src_filename' => $file['name']
            );
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

    public function delete() {
        foreach($this->getFiles() as $file) {
            $this->S3->deleteObject(S3Component::$bucket, self::$path . $file['filename']);
        }

        $this->clear();
    }

}
