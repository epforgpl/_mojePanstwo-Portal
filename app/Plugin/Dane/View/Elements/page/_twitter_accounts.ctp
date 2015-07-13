<?

$number_format = array(
    'places' => 0,
    'before' => '',
    'escape' => false,
    'decimals' => '.',
    'thousands' => ' '
);

?>

<p class="line signature">
    <?= $object->getData('description'); ?>
</p>


<div>

    <?

    $a2013 = array(
        'liczba_retweetow_wlasnych_2013',
        'liczba_tweetow_wlasnych_2013',
        'liczba_wzmianek_rts_2013',
        'liczba_odpowiedzi_rts_2013'
    );

    $ord = @substr($this->request->query['order'], 0, stripos($this->request->query['order'], ' '));

    echo $this->Dataobject->highlights();

    ?>
</div>