<div class="row block">

    <div class="avatar col-md-12">
        <div class="col-md-2">
            <div class="row">
                <img onerror="imgFixer(this)"
                     src="http://resources.sejmometr.pl/mowcy/a/2/<?php echo $item['data']['ludzie_poslowie.mowca_id'] ?>.jpg"/>
            </div>
        </div>
        <div class="col-md-10">
            <p class="header">
                <a href="/dane/poslowie/<?php echo $item['data']['poslowie.id']; ?>"><?php echo $item['data']['poslowie.nazwa']; ?></a>
            </p>

            <p>(<?php echo $item['data']['sejm_kluby.skrot']; ?>)</p>
        </div>
    </div>

</div>
