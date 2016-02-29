
<div class="container">
    <? if(isset($transaction) && $transaction['Transaction']['res_status'] == 'TRUE') { ?>
        <h2>Dziękujemy!</h2>
        <p>message</p>
    <? } else { ?>
        <h2>Wystąpił błąd</h2>
        <p>Podczas transakcji wystąpił błąd</p>
    <? } ?>
</div>

