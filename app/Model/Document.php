<?php

class Document extends AppModel
{

    public $useDbConfig = 'mpAPI';
    public $useTable = false;

    // function to load document content's package. if package === 0, then we are loading whole content.

    public function load($id, $package = 1)
    {
        /*if ($package === 0) {
            try {
                $doc = $this->getDataSource()->loadDocument($id, 1);
            } catch (Exception $e) {
                return false;
            }
            if ($doc['Document']['packages_count'] > 1) {
                for ($i = 2; $i++; $doc['Document']['packages_count']) {
                    $temp = $this->getDataSource()->loadDocument($id, $i);
                    $doc['Package'] .= $temp['Package'];
                }
            }
            return $doc;
        } else {*/

            try {
                return $this->getDataSource()->loadDocument($id, $package);
            } catch (Exception $e) {
                return false;
            }
       // }

    }

}
