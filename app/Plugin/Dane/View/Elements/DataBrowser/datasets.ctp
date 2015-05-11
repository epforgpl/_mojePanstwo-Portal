<div class="agg agg-List">
        
    <? if($data['buckets']) {?>
	    <ul class="nav nav-pills nav-stacked">
		    <? foreach($data['buckets'] as $b) {?>
			<li>
				<a href="/dane/<?= $b['key'] ?><? if(isset($this->request->query['q'])) echo "?q=" . $this->request->query['q']; ?>"><?= $b['label']['buckets'][0]['key'] ?> <span class="badge"><?= $b['doc_count'] ?></span></a></li>
			</li>
			<? } ?>
		</ul>
	<? } ?>
</div>
