<?
echo $this->Html->css($this->Less->css('app'));
$this->Combinator->add_libs('js', 'app');

$displayAggs = isset($displayAggs) ? (boolean)$displayAggs : true;
$columns = isset($columns) ? $columns : array(9, 3);

echo $this->element('headers/main');
echo $this->element('app/sidebar');
?>
<div class="app-content-wrap">
    <div class="objectsPage">
        
        <?
        $options = array(
            'displayAggs' => false,
            'columns' => $columns,
            'searcher' => true,
        );

        /*
        if(isset($menu)) {
            $options['menu'] = $menu;
        }
        */

        echo $this->element('Dane.DataBrowser/browser-content', $options);
        ?>
                
    </div>
</div>
