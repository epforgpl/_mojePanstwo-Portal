<?

class Pismo extends AppModel
{

    public function save($data)
    {

        $this->API = mpapiComponent::getApi()->Pisma();
        return $this->API->save($data);

    }

    public function getTemplate($id)
    {

        $this->API = mpapiComponent::getApi()->Pisma();
        return $this->API->getTemplate($id);

    }

}