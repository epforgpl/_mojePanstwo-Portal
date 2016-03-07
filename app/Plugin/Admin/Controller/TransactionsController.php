<?php

App::uses('AdminAppController', 'Admin.Controller');

class TransactionsController extends AdminAppController
{

    public $uses = array('Admin.AdminTransaction');
    public $components = array('RequestHandler');
    private static $perPage = 20;

    private static $statusDict = array(
        '' => 'Nie potwierdzona',
        'TRUE' => 'Poprawna',
        'FALSE' => 'Błędna'
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->set('action', 'transactions');
        $this->set('statusDict', self::$statusDict);
    }

    public function index()
    {
        if(isset($this->request->data['id'])) {
            $results = $this->AdminTransaction->save(
                $this->request->data
            );

            $msg = $results ? 'Zmiany zostały poprawnie zapisane' : 'Wystąpił błąd';
            $this->Session->setFlash($msg, 'default');
            $this->redirect('/' . $this->request->url);
        }

        $page = isset($this->request->query['page']) ?
            (int) $this->request->query['page'] : 0;

        $q = isset($this->request->query['q']) ?
            $this->request->query['q'] : false;

        $conditions = array();
        if($q) {
            $conditions['or'] = array(
                array('id LIKE' => "%$q%")
            );
            $this->set('q', $q);
        }

        $count = $this->AdminTransaction->find('count', array(
                'conditions' => $conditions
            )
        );

        $this->set('page', $page);
        $this->set('pages', ceil($count / self::$perPage));
        $this->set('rows', $this->AdminTransaction->find('all', array(
            'fields' => 'id, krs_pozycje_id, user_id, form_send_at, res_received_at, amount, email, surname, firstname, res_status, is_transferred',
            'conditions' => $conditions,
            'order' => 'form_send_at DESC',
            'limit' => self::$perPage,
            'offset' => $page * self::$perPage
        )));
    }

    public function getMassCSV() {
        $results = $this->AdminTransaction->query('
            SELECT
              `transactions`.*,
              `krs_pozycje_bank_accounts`.`bank_account`,
              `krs_pozycje`.`nazwa`
            FROM `transactions`
            JOIN `krs_pozycje_bank_accounts`
              ON `krs_pozycje_bank_accounts`.`krs_pozycje_id` = `transactions`.`krs_pozycje_id`
            JOIN `krs_pozycje`
              ON `krs_pozycje`.`id` = `transactions`.`krs_pozycje_id`
            WHERE
              `transactions`.`is_transferred` = 0 AND
              `transactions`.`res_status` = "TRUE" AND
              `krs_pozycje_bank_accounts`.`status` = 1
            ORDER BY `krs_pozycje_bank_accounts`.`created_at` DESC
        ');

        $csv = array();
        $ids = array();

        foreach($results as $row) {
            $ids[] = $row['transactions']['id'];
            $r = array();
            $r[] = $row['krs_pozycje_bank_accounts']['bank_account'];

            $name = str_replace(';', '.', $row['krs_pozycje']['nazwa']);
            $nameParts = str_split($name, 35);
            for($i = count($nameParts); $i < 4; $i++) {
                $nameParts[] = '';
            }

            foreach($nameParts as $part)
                $r[] = $part;

            $r[] = $row['transactions']['amount'];
            $title = 'MojePaństwo.pl - ' . $row['transactions']['firstname'] . ' ' . $row['transactions']['surname']  . ' ' . $row['transactions']['email'];
            $title = str_replace(';', '.', $title);
            $titleParts = str_split($title, 35);

            for($i = count($titleParts); $i < 2; $i++) {
                $titleParts[] = '';
            }

            $r[] = $titleParts[0];
            $r[] = $titleParts[1];
            $csv[] = $r;
        }

        $name = 'transferuj_' . date('Y_m_d_H_i_s') . '.csv';
        $file = APP . 'tmp/' . $name;

        $csvRows = array();
        foreach($csv as $c) {
            $csvRows[] = implode(";", $c);
        }

        $content = implode("\n", $csvRows);
        file_put_contents($file, $content);

        $this->response->file($file,
            array('download' => true, 'name' => $name));

        $res = $this->AdminTransaction->query('
            UPDATE `transactions` SET
              `is_transferred` = 1,
              `transfered_at` = NOW()
            WHERE `id` IN('. implode(",", $ids) .')
        ');

        return $this->response;
    }

}