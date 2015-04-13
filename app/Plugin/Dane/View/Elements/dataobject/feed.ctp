<?
		
	$path = APP.'Plugin'.DS.'Dane'.DS.'View'.DS.'Elements'.DS.'sides'.DS.$dataFeed['side'].'-left.ctp';
	$side_left = file_exists($path);
	
	$path = APP.'Plugin'.DS.'Dane'.DS.'View'.DS.'Elements'.DS.'sides'.DS.$dataFeed['side'].'-right.ctp';
	$side_right = file_exists($path);

?>
<div class="row row-feed dataBrowser dataFeed">
	<? if( $side_left ) {?>    
    <div class="col-xs-12 col-sm-3 objectSide col-feed-side col-feed-side-left">
        <? echo $this->Element('Dane.sides/' . $dataFeed['side'] . '-left'); ?>
    </div>
    <? } ?>
    <div class="col-xs-12 col-sm-7 col-feed-main<? if(!$side_left) {?> col-sm-offset-1<?}?>">
        <div class="object">
            <? echo $this->Element('Dane.DataFeed/feed'); ?>
        </div>
    </div>
    <div class="col-xs-12 col-sm-2 col-feed-side col-feed-side-right">
                
        <? if (isset($object_subscriptions) && $object_subscriptions) { ?>
        <div class="subscription">
            <h2><span class="glyphicon glyphicon-star"></span> Obserwowane dane</h2>
            <ul>
                <? foreach ($object_subscriptions as $sub) { ?>
                    <li class="overflow-auto<? if (
                        isset($this->request->query['subscription']) &&
                        ($this->request->query['subscription'] == $sub['id'])
                    ) {
                        echo " active";
                    } ?>">
                        <a class="pull-left" href="<?= $sub['url'] ?>"><?= $sub['title'] ?></a>

                        <div class="cancel-subscription pull-right">
                        	<form action="/dane/subscriptions/<?= $sub['id'] ?>/delete.json" method="post">
                            	<button class="glyphicon glyphicon-remove" title="Usuń tę subskrypcję"></button>
                        	</form>
                        </div>
                    </li>
                <? } ?>
            </ul>
        </div>
        <? } ?>
        
        <? echo $this->Element('Dane.DataBrowser/aggs', array('data' => $dataFeed)); ?>
        
        <?
	        if( $side_right ) 
	        	echo $this->Element('Dane.sides/' . $dataFeed['side'] . '-right');
	        
	        // else
	        	// echo $this->Element('Dane.object-actions');
	    ?>            
        
    </div>
</div>