<? if( @$this->MPaginator->params->paging['Dataobject']['count'] ) { ?>
				
	<div class="dataBrowser upper margin-top-0">
		<div class="container">
			<div class="dataBrowserContent">
				
				
				
			
				<div class="row">
					<div class="col-md-8">
			
						<div class="dataPagination margin-top-25">
						    <ul class="pagination">
						        <?php
						
						        $this->MPaginator->options['url'] = array('alias' => 'prawo');
						        $this->MPaginator->options['paramType'] = 'querystring';
						
						        echo $this->MPaginator->first('<span data-icon="&#xe627;"></span>', array('tag' => 'li', 'escape' => false), '<a href="#"><span data-icon="&#xe627;"></span></a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => true));
						        echo $this->MPaginator->prev('<span data-icon="&#xe626;"></span>', array('tag' => 'li', 'escape' => false), '<a href="#"><span data-icon="&#xe626;"></span></i></a>' , array('class' => 'prev disabled hidden', 'tag' => 'li', 'escape' => true));
						//
						        ?></ul>
						    <ul class="pagination"><?
						        echo $this->MPaginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'active', 'currentTag' => 'a'));
						        ?></ul>
						    <ul class="pagination"><?
						        echo $this->MPaginator->next('<span data-icon="&#xe625;"></span>', array('tag' => 'li', 'escape' => false), '<a href="#"><span data-icon="&#xe625;"></span></a>', array('class' => 'prev disabled hidden', 'tag' => 'li', 'escape' => false));
						        echo $this->MPaginator->last('<span data-icon="&#xe628;"></span>', array('tag' => 'li', 'escape' => false), '<a href="#"><span data-icon="&#xe628;"></span></a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
						        ?>
						    </ul>
						</div>
						
						<?
						if (isset($dataBrowser['afterBrowserElement']))
						    echo $this->element($dataBrowser['afterBrowserElement']);
						?>
						
					</div>
				</div>
			
			
			</div>
		</div>
	</div>
<? } ?>