<div class="row">
    <div class="col-md-12 pismoTitle">
                
        <div class="titleBlock">
            <h1<? if (isset($editable)) echo(' contenteditable="true"') ?> spellcheck="false"
                                                                           data-url="<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>"><a href="/pisma/<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>">
                <?= $pismo['nazwa'] ?>
	           </a>
            </h1>
        </div>
		
		<div class="row">
			<div class="col-md-10">
				
				<div class="letter-meta">
					<p class="pull-left">
						Autor: <b><?
							if( $pismo['from_user_type']=='account' ) {
								echo $pismo['from_user_name'];
							} else {
								echo "Anonimowy użytkownik";
							}
						?></b>
					</p>
					<p class="pull-right">
						Utworzono: <b><?= dataSlownie(substr($pismo['created_at'], 0, 10)) ?></b>
					</p>
				</div>
		
			</div>
		</div>

    </div>
</div>