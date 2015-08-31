<ul class="dataAggs">
    <li class="agg special">
         
		<div class="agg agg-List agg-Datasets showCounters">

	        <ul class="nav nav-pills nav-stacked">
	            	            
	            <? foreach ($app_chapters['items'] as $item) {
	                
	                $active = false;
	                
	                if(
		                (
			                !$app_chapters['selected'] &&
			                (
				                !isset($item['id']) || 
				                !$item['id']
			                )
		                ) || 
		                (
			                @$app_chapters['selected'] && 
			                @$item['id'] && 
			                ( $app_chapters['selected']==$item['id'] )
		                )
	                )
	                	$active = true;
	                	                  						
                ?>
	
	                <li<? if($active) { ?> class="active"<?}?>>
	                	<a href="<?= $item['href'] ?>">
		                	<?= $item['label'] ?><? if (isset($item['count'])) { ?> <span class="counter"><?= $item['count'] ?></span><? } ?>
	                    </a>
	                    
	                    <? if( isset($item['element']) ) echo $this->element($item['element']['path']); ?>
	                    
	                </li>
	                
	            <? } ?>
	            
	        </ul>
	        
		</div>
               
    </li>
</ul>
