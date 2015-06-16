<div class="agg agg-List apps">

    <? if ($data['buckets']) { ?>
        <ul class="nav nav-pills nav-stacked">
            <? foreach ($data['buckets'] as $b) { ?>
			<li>
				<a href="<?= $b['app']['href'] ?><? if (isset($this->request->query['q'])) echo "?q=" . $this->request->query['q']; ?>"><?= $b['app']['name'] ?> <span class="badge"><?= $b['doc_count'] ?></span></a></li>
			</li>
			<? } ?>
        </ul>
    <? } ?>

</div>
