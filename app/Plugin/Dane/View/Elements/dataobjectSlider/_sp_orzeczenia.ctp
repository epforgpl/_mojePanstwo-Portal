<p class="line signature"><?php if ($item['data']['wydzial'] !== '') {
        echo __d('dane', 'LC_DANE_SP_ORZECZENIA_DEPARTAMENT', true) . ': <strong>' . $item['data']['wydzial'] . '</strong>';
    } ?></p>

<p class="line signature"><?php if ($item['data']['podstawa_prawna'] !== '') {
        echo __d('dane', 'LC_DANE_SP_ORZECZENIA_LEGAL_BASIS', true) . ': <strong>' . $item['data']['podstawa_prawna'] . '</strong>';
    } ?></p>

<p class="line signature"><?php echo __d('dane', 'LC_DANE_SP_ORZECZENIA_THEMED_TAGS', true) . ': <strong>' . $item['data']['hasla_tematyczne'] . '</strong>'; ?></p>
