<?

class Subscription extends AppModel
{

    public $useDbConfig = 'mpAPI';

    public function save($data = array())
    {

        if (
        !empty($data)
        ) {

            return $this->getDataSource()->request('dane/subscriptions', array(
                'method' => 'POST',
                'data' => $data,
            ));

        }

    }

    public function delete($id)
    {

        if (
        !empty($id)
        ) {

            return $this->getDataSource()->request('dane/subscriptions/' . $id, array(
                'method' => 'DELETE',
            ));

        }

    }

    public function load($id)
    {

        if (
        !empty($id)
        ) {

            return $this->getDataSource()->request('dane/subscriptions/' . $id);

        }

    }

    public function transfer_anonymous($anonymous_user_id)
    {

        $res = $this->getDataSource()->request('dane/subscriptions/transfer_anonymous', array(
            'method' => 'GET',
            'data' => array(
                'anonymous_user_id' => $anonymous_user_id,
            ),
        ));

        return $res;

    }

}