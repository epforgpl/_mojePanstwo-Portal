<? if(isset($twitterAccountTypes) && isset($twitterAccountType)) { ?>
    <div class="twitter-accounts">
	    <ul class="submenu">
	        <? foreach($twitterAccountTypes as $a => $type) { ?>
	            <li<? if($twitterAccountType == $a) echo ' class="active"'; ?>>
	                <a href="/media?<? if(isset($t)) echo 't=' . $t . '&'; ?>a=<?= $a; ?>">
	                    <?= $type; ?>
	                </a>
	            </li>
	        <? } ?>
	    </ul>
    </div>
<? } ?>
