<?
$this->Combinator->add_libs('css', $this->Less->css('banners-box', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('krakow-wpf', array('plugin' => 'Dane')));
//$this->Combinator->add_libs('js', 'Dane.krakow-jquery-big-image');
echo $this->Html->script('Dane.krakow-jquery-big-image', array('block' => 'scriptBlock'));
$this->Combinator->add_libs('js', 'Dane.krakow-wpf');
?>
<div class="col-xs-12">
    <div class="banner mapy block">
        <?php echo $this->Html->image('Dane.customObject/krakow/wpf/icon_map.svg', array('width' => '82', 'alt' => 'Zobacz plany inwestycyjne na mapie', 'class' => 'pull-right')); ?>
        <p><b>Zobacz plany inwestycyjne</b> na mapie</p>
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#wpfBigImageModal">Otwórz mapę #1
        </button>
    </div>
    <div class="modal fade" id="wpfBigImageModal" tabindex="-1" role="dialog" aria-labelledby="wpfBigImageModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <a class="wpf-zoom" href="/dane/img/customObject/krakow/wpf/126000_0.jpg">
                        <img src="/dane/img/customObject/krakow/wpf/126000_0_small.jpg" alt="Mapa #1"/>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
