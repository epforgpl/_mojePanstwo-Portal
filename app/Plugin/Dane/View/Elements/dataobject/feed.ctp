<div class="row row-feed">
    <div class="col-md-3 objectSide col-feed-side col-feed-side-left">
		
		<? echo $this->Element('Dane.sides/' . $dataFeed['side']); ?>

    </div>
    <div class="col-md-7 col-feed-main">
        <div class="object">
            
            <? echo $this->Element('Dane.DataFeed/feed'); ?>
            
        </div>
    </div>
    <div class="col-md-2 col-feed-side col-feed-side-right">
		
		<? echo $this->Element('Dane.object-actions'); ?>
		
    </div>
</div>