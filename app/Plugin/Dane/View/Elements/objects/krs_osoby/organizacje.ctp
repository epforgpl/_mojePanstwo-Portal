<?
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
?>
<style>
	.objectsPage .dataBrowser {
		margin-top: -15px;
	}
	ul.role {
		margin: -8px 0 10px 57px !important;
	}
</style>
<div class="block">

    <div class="block-header">
        <h2 class="label">Powiązane organizacje:</h2>
    </div>

    <div class="content">

		<div class="dataBrowser">
			<div class="aggs-init">
								
				<div class="dataAggs">
					<div class="agg agg-Dataobjects">
					    <ul class="dataobjects">
						    <? foreach ($organizacje as $organizacja) { 
							    $kapitalZakladowy = (float) $organizacja['kapital_zakladowy'];
						    ?>
						    <li>
							<?
								
								$organizacja['firma'] = $organizacja['nazwa'];
								$role = $organizacja['role'];
								unset( $organizacja['role'] );
								
								$doc = array(
									'fields' => array(
										'dataset' => array(
											'krs_podmioty'
										),
										'source' => array(
											array(
												'data' => $organizacja,
											),
										),
										'id' => array(
											array(
												$organizacja['id'],
											),
										),
									),
									'_id' => false,
									
								);
								
								
								echo $this->Dataobject->render($doc, 'default');
							?>
							
							<? if ($role) { ?>
		                    <ul class="list-group less-borders role">
		                        <? foreach ($role as $rola) {
		                            ?>
		                            <li class="list-group-item">
		                                <p><span
		                                        class="label label-primary"><?= $rola['label'] ?></span> <? if (isset($rola['params']['subtitle']) && $rola['params']['subtitle']) { ?>
		                                        <span
		                                            class="sublabel normalizeText"><?= $rola['params']['subtitle'] ?></span><? } ?>
		                                </p>
		                            </li>
		                        <?
		                        }
		                        ?>
		                    </ul>
		                    <? } ?>
							
						    </li>
						    <? } ?>
					    </ul>
					</div>
				</div>
						
			</div>
		</div>
		
		
		<? /*
        <ul class="list-group less-borders">
            <?
            foreach ($organizacje as $organizacja) {
                $kapitalZakladowy = (float)$organizacja['kapital_zakladowy'];
                ?>
                <li class="list-group-item">
                    <h3><a href="/dane/krs_podmioty/<?= $organizacja['id'] ?>"><?= $organizacja['nazwa'] ?></a>
                    </h3>
					
					
					
                    <p class="subtitle">
                        <? if ($organizacja['wykreslony'] == '1') { ?><span class="label label-danger">Podmiot wykreślony z KRS</span>
                            <span class="separator">|</span> <? } ?>
                        <span class="normalizeText"><?= $organizacja['forma_prawna_str'] ?></span>
                        <? if ($organizacja['adres_miejscowosc']) { ?>
                            <span class="separator">|</span> <?
                            echo $organizacja['adres_miejscowosc'];
                        } ?>
                        <? if ($kapitalZakladowy) { ?>
                            <span class="separator">|</span> kapitał zakładowy: <?
                            //setlocale(LC_MONETARY, 'pl_PL');
                            //echo money_format('%i', $organizacja['kapital_zakladowy']);
                            echo number_format($organizacja['kapital_zakladowy'], 2, ',', ' ') . ' PLN';
                        } ?>
                    </p>

                        
                </li>
            <? } ?>
        </ul>
        */ ?>
    </div>
</div>