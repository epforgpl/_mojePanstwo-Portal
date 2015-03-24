<?

$this->Combinator->add_libs('css', $this->Less->css('appheader'));

$img = false;
if( isset($appSettings['headerImg']) )
    $img = ( $appSettings['headerImg'][0]=='/' ) ? $appSettings['headerImg'] : '/' . strtolower($this->request->params['plugin']) . '/img/header_' . $appSettings['headerImg'] . '.png';
?>

<div class="appHeader"<? if( $img ) echo ' style="background-image: url(' . $img . ')"'; ?>>
    <div class="container">
        <div class="holder">
            <? if (isset($appSettings['title'])) { ?>
                <h1><?= $appSettings['title'] ?></h1>
            <? } ?>

            <? if (isset($appSettings['subtitle'])) { ?>
                <h2><?= $appSettings['subtitle'] ?></h2>
            <? } ?>
    </div>
    </div>
    <? if (isset($appSettings['menu'])) { ?>
        <div class="menu">
            <div class="container">
                <ul>
                    <?
                    foreach ($appSettings['menu'] as $item) { 
		              	
		              	$href = isset( $item['href'] ) ? 
		              		'/' . $item['href'] : 
		              		'/' . strtolower($this->request->params['plugin']) . '/' . $item['id'];
		            	     
                    ?>
                        <li<? if (isset($appSettings['menuSelected']) && ($item['id'] == $appSettings['menuSelected'])) {
                            echo ' class="active"';
                        } ?>>
                            <a href="<?= $href ?>" target="_self"><?= $item['label']; ?></a>
                        </li>
                    <? } ?>
                </ul>
        </div>
        </div>
    <? } ?>
</div>