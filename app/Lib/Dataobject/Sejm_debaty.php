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
} 