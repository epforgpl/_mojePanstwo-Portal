<div class="row row-feed">
    <div class="col-xs-12 col-sm-3 objectSide col-feed-side col-feed-side-left">
        <? echo $this->Element('Dane.sides/' . $dataFeed['side']); ?>
    </div>
    <div class="col-xs-12 col-sm-7 col-feed-main">
        <div class="object">
	        
	        <? /*
	        <form action="<?= $dataFeed['subscribeAction'] ?>" method="post">
		        <button type="submit">Obserwuj</button>
	        </form>
	        */ ?>
	        
            <? echo $this->Element('Dane.DataFeed/feed'); ?>
        </div>
    </div>
    <div class="col-xs-12 col-sm-2 col-feed-side col-feed-side-right">
        <? echo $this->Element('Dane.object-actions'); ?>
        
        <?
        if(
	       isset( $object ) &&
	       ( $subs = $object->getLayer('subscriptions') )
        ) {
	    ?>
	    	
	    
	    <? /*
	    <h2>Subskrypcje</h2>
	    <ul>
		<? foreach( $subs as $sub ) { ?>
			<li class="<? if(
				isset( $this->request->query['subscription'] ) && 
				( $this->request->query['subscription'] == $sub['id'] )
			) { echo "active "; }?>">
				<a href="<?= $sub['url'] ?>"><?= $sub['title'] ?></a>
			</li>
		<? } ?> 
	    </ul>
	    */ ?>
	    
	    <?
        }
        ?>
        
    </div>
</div>