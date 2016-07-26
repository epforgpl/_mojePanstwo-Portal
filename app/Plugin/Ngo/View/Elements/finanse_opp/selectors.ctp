<? if (isset($filter_options)) { ?>
    <div class="appSwitchers text-center">
        <div class="container">
            <form id="dataForm" method="get">

                <div class="row">
					
					<div class="col-sm-3">
                        <div class="form-group">
                            <label for="modeSelect">Województwo: </label>
                            <select id="modeSelect" class="form-control" name="w">
                                <? foreach ($filter_options['w']['items'] as $i => $item) { ?>
                                    <option
                                        value="<?= $item['id'] ?>"<? if ($filter_options['w']['selected_id'] == $item['id']) echo ' selected'; ?>>
                                        <?= $item['label'] ?>
                                    </option>
                                <? } ?>
                            </select>
                        </div>
                    </div>
					
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="dataSelect">Wielkość organizacji: </label>
                            <select id="dataSelect" class="form-control" name="size">
                                <? foreach ($filter_options['size']['items'] as $i => $item) { ?>
                                    <option
                                        value="<?= $item['id'] ?>"<? if ($filter_options['size']['selected_id'] == $item['id']) echo ' selected'; ?>>
                                        <?= $item['label'] ?>
                                    </option>
                                <? } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="rangeSelect">Analizowany rocznik: </label>
                            <select id="rangeSelect" class="form-control" name="timerange">
                                <? foreach ($filter_options['timerange']['items'] as $i => $item) { ?>
                                    <option
                                        value="<?= $item['id'] ?>"<? if ($filter_options['timerange']['selected_id'] == $item['id']) echo ' selected'; ?>>
                                        <?= $item['label'] ?>
                                    </option>
                                <? } ?>
                            </select>
                        </div>
                    </div>

                </div>
            </form>			
            
        </div>
        
        

        
    </div>
<? } ?>