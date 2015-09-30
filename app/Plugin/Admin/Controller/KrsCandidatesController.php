<?
App::uses('AdminAppController', 'Admin.Controller');

class KrsCandidatesController extends AdminAppController
{

    public function index($type='sejm', $stan=0, $page=1) {
        $page_count= $this->KrsCandidate->pageCount(array('type'=>$type, 'stan'=>$stan));
        if($page>$page_count){
            $page=$page_count;
        }
        $lista = $this->KrsCandidate->all(array('type'=>$type, 'stan'=>$stan, 'page'=>$page));



        $this->set('lista', $lista);
        $this->set('stan', $stan);
        $this->set('type', $type);
        $this->set('page', $page);
        $this->set('page_count', $page_count);
    }

    public function decide(){

        $this->autoRender=false;

        if($this->KrsCandidate->decide($this->request->data)){
            return true;
        }else{
            return false;
        }
    }

}
