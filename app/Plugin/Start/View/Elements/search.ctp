<?
    			    
    echo $this->element('Dane.DataBrowser/browser-content-header', array(
	    'dataWrap' => false,
	    'params' => $this->Paginator->params(),
	    'datasetsFilter' => isset( $datasetsFilter ) ? $datasetsFilter : false,
    ));