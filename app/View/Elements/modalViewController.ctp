<? if (isset($_observeOptions) && !empty($_observeOptions)) {
    echo $this->element('modals/dataobject-observe');
}

if (isset($_collectionsOptions) && !empty($_collectionsOptions)) {
    echo $this->element('modals/dataobject-collections');
}

if (isset($_manageOptions) && !empty($_manageOptions)) {
    echo $this->element('modals/dataobject-manage');
}
