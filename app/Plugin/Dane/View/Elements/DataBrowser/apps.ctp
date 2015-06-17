<div class="agg agg-List apps">

    <? if ($data['buckets']) { ?>
        <ul class="nav nav-pills nav-stacked">
            <? foreach ($data['buckets'] as $b) { ?>
			<li>
				<a href="<?= $b['app']['href'] ?><? if (isset($this->request->query['q'])) echo "?q=" . $this->request->query['q']; ?>">
					<div class="icon"><i data-icon-applications="<?=$b['app']['icon']?>"></i></div>
					<span class="title"><?= $b['app']['name'] ?></span>
					<span class="count"><?= pl_dopelniacz($b['doc_count'], 'wynik', 'wyniki', 'wyników') ?></span>
					<div class="glyphicon glyphicon-chevron-right pull-right"></div>
					
				</a></li>
			</li>
			<? } ?>
        </ul>
    <? } ?>

</div>
