<ul class="pagination pagination-sm">
    <?

    $this->Paginator->options(array(
        'url' => array(
            '?' => $this->request->query,
        )
    ));

    echo $this->Paginator->numbers(array(
        'tag' => 'li',
        'currentTag' => 'a',
        'currentClass' => 'active',
        'separator' => false,
        'escape' => false,
    ));
    ?>
</ul>
