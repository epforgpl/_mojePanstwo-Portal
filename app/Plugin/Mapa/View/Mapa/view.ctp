<? if (!isset($widget) || @$this->request->query['q']) {
    echo $this->element('map');
}
