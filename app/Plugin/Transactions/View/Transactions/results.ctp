<?

echo $this->element('headers/main');

if(isset($transaction) && $transaction['Transaction']['res_status'] == 'TRUE') { ?>
    <h2>success</h2>
    <p>message</p>
<? } else { ?>
    <h2>error</h2>
    <p>message</p>
<? }

