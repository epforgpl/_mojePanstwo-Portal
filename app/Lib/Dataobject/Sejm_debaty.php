<?php
/**
 * Created by PhpStorm.
 * User: adamciezkowski
 * Date: 03/12/13
 * Time: 13:04
 */

namespace MP\Lib;


class Sejm_debaty extends DataObject
{
	
	protected $tiny_label = 'Sejm';
	
	protected $schema = array(
		array('sejm_posiedzenia.tytul', 'Numer posiedzenia', 'string', array(
			'link' => array(
				'dataset' => 'sejm_posiedzenia',
				'object_id' => '$posiedzenie_id',
			),
		)),
		array('punkt_nr', 'Numer punktu', 'string', array(
			'link' => array(
				'dataset' => 'sejm_posiedzenia_punkty',
				'object_id' => '$punkt_id',
			),
		)),
		array('liczba_wystapien', 'Liczba wystąpień', 'integer'),
		array('liczba_glosowan', 'Liczba głosowań', 'integer'),
	);
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
    );
    
    protected $hl_fields = array(
    	'sejm_posiedzenia.tytul', 'punkt_nr', 'liczba_wystapien', 'liczba_glosowan'
    );

    public function getLabel()
    {
        return 'Debata na posiedzeniu Sejmu';
    }   
	
	public function getTitleAddon()
	{
		return $this->getData('tytul_prefix');
	}
	
	public function getBreadcrumbs()
	{
				
		$label = $this->getData('sejm_posiedzenia.tytul');
		if( stripos($label, 'Posiedzenie')===false )
			$label = 'Posiedzenie #' . $label;
				
		return array(
			array(
				'id' => '/dane/instytucje/3214,sejm/posiedzenia/' . $this->getData('posiedzenie_id'),
				'label' => $label,
			),
			array(
				'id' => '/dane/instytucje/3214,sejm/posiedzenia/' . $this->getData('posiedzenie_id') . '/dni/' . $this->getData('dzien_id'),
				'label' => dataSlownie( $this->getDate() ),
			),
		);
				
	}
	
	public function getMetaDescriptionParts($preset = false)
	{
				
		$output = array();
		
		if( $preset!='dzien' )
			$output[] = dataSlownie($this->getDate());
		
		if( $this->getData('sejm_debaty.liczba_wystapien') )
			$output[] = pl_dopelniacz( $this->getData('sejm_debaty.liczba_wystapien'), 'wystąpienie', 'wystąpienia', 'wystąpień' );
			
		if( $this->getData('sejm_debaty.liczba_glosowan') )
			$output[] = pl_dopelniacz( $this->getData('sejm_debaty.liczba_glosowan'), 'głosowanie', 'głosowania', 'głosowań' );
		
		return $output;
		
	}
	
	public function getShortTitle() {
		return $this->getData('tytul') ? $this->getData('tytul') : 'Poza punktami porządku dziennego';
	}
	
	public function getTitle() {
		return $this->getShortTitle();
	}
	
	public function getUrl()
	{
		
		return '/dane/instytucje/3214,sejm/debaty/' . $this->getId();
		
	}
} 