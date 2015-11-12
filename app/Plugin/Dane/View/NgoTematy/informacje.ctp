<?
	
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
echo $this->Element('dataobject/pageBegin');

$this->Combinator->add_libs('css', $this->Less->css('temat', array('plugin' => 'Ngo')));
$this->Combinator->add_libs('js', 'Ngo.aloha');
$this->Combinator->add_libs('js', 'Ngo.temat');

?>

    <div class="object">
		
		<div class="dataBrowser" style="margin-top: -5px;">
			<div class="row dataBrowserContent">
				<div class="col-md-3 col-xs-12 dataAggsContainer">
					<div class="mp-sticky mp-sticky-disable-sm-4" data-widthFromWrapper="false">
					
						<ul class="dataAggs" style="opacity: 1;">
						    <li class="agg special">
						        <div class="agg agg-List agg-Datasets">
						            <ul id="mp-page-menu" class="nav nav-pills nav-stacked">
						                                    <li class="active">
						                        <a href="#fakty-i-mity">
						                            Fakty i mity                        </a>
						                    </li>
						                                    <li>
						                        <a href="#infografiki">
						                            Infografiki i statystyki                        </a>
						                    </li>
						                                    <li>
						                        <a href="#artykuly-prasowe">
						                            Artykuły prasowe                        </a>
						                    </li>
						                                    
						                            </ul>
						        </div>
						    </li>
						</ul>
					
					</div>
				</div>
				<div class="col-md-9">
					
					<div class="dataWrap">
					<div class="mp-page">
						
						<button class="glyphicon glyphicon-edit btn-editable" type="button" data-target="fakty_i_mity"></button>
						<h2 id="fakty-i-mity" name="fakty-i-mity" class="first">Fakty i mity o uchodźcach</h2>
						
						
						<div id="_editable_fakty_i_mity" class="mp-editable sections">
						<? for($i=0; $i<5; $i++) {?>
						<section>
							<h3>Vestibulum semper metus ac mi condimentum varius</h3>
							<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sit amet sagittis tellus. Ut sagittis felis non purus tempus, quis faucibus est hendrerit. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla a arcu vel dui aliquet sodales. Donec quis elementum diam, tincidunt accumsan nisi.</p>
							<p>Quisque pulvinar risus a vehicula rutrum. Etiam at vestibulum lorem. Nam dapibus ultricies metus vel malesuada. In ac feugiat diam. Maecenas sapien nisi, porttitor nec porta eget, consectetur at sapien. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aliquam molestie felis nulla. Phasellus porta risus nec mauris pretium sodales.</p>
							<p>Nunc et tempor leo, sit amet gravida lorem. Vivamus metus nisl, maximus ut enim nec, elementum condimentum nisi. Vestibulum scelerisque magna et molestie molestie. </p>
						</section>
						<? } ?>
						</div>
						
						
						<button class="glyphicon glyphicon-edit btn-editable" type="button" data-target="infografiki"></button>

						<h2 id="infografiki" name="infografiki" >Infografiki i statystyki</h2>
						
						<div id="_editable_infografiki" class="mp-editable sections">
						<? for($i=0; $i<2; $i++) {?>
						<section>
							<h3>Vestibulum semper metus ac mi condimentum varius</h3>
							
							<img class="thumb" style="margin-top: 0; margin-left: -15px; margin-right: 0;" src="/ngo/img/1447332951_paper4.svg" />
							
							<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sit amet sagittis tellus. Ut sagittis felis non purus tempus, quis faucibus est hendrerit. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla a arcu vel dui aliquet sodales. Donec quis elementum diam, tincidunt accumsan nisi.</p>
							<p>Nunc et tempor leo, sit amet gravida lorem. Vivamus metus nisl, maximus ut enim nec, elementum condimentum nisi. Vestibulum scelerisque magna et molestie molestie. </p>
						</section>
						<? } ?>
						</div>
						
						
						<button class="glyphicon glyphicon-edit btn-editable" type="button" data-target="artykuly"></button>

						<h2 id="artykuly-prasowe" name="artykuly-prasowe" >Artykuły prasowe</h2>
						
						<div id="_editable_artykuly" class="mp-editable sections">
						<? for($i=0; $i<3; $i++) {?>
						<section>
							<h3>Vestibulum semper metus ac mi condimentum varius</h3>
							
							<img class="thumb sm" src="/ngo/img/press.svg" />
							
							<p>Nunc et tempor leo, sit amet gravida lorem. Vivamus metus nisl, maximus ut enim nec, elementum condimentum nisi. Vestibulum scelerisque magna et molestie molestie. </p>
						</section>
						<? } ?>
						</div>
						
					</div>
					</div>
					
				</div>
			</div>
		</div>
        
    </div>        


<?= $this->Element('dataobject/pageEnd'); ?>
