<ul class="pagination pagination-sm">
    <?

    $this->Paginator->options(array(
        /*
        'convertKeys' => array(
            (int) 0 => 'page',
            (int) 1 => 'limit',
            (int) 2 => 'sort',
            (int) 3 => 'direction'
        ),
        */
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