<?

namespace MP\Lib;

class Dotacje_ue extends DataObject
{
	
	protected $tiny_label = 'Dotacja UE';
	
	protected $schema = array(
		array('symbol', 'Umowa'),
		array('beneficjent_nazwa', 'Nazwa', 'string', array(
			'link' => array(
				'dataset' => 'dotacje_ue_beneficjenci',
				'object_id' => '$beneficjent_id',
			),
			'truncate' => 50,
		)),
		array('data_podpisania', 'Data podpisania umowy', 'date'),
		array('data_rozpoczecia', 'Data rozpoczęcia realizacji', 'date'),
		array('data_utworzenia_ksi', 'Data utworzenia w KSI', 'date'),
		array('data_zakonczenia', 'Data zakończenia realizacji', 'date'),		
		
		array('wartosc_ogolem', 'Wartość projektu', 'pln'),		
		array('wartosc_wydatki_kwalifikowane', 'Wydatki kwalifikowane', 'pln'),		
		array('wartosc_dofinansowanie', 'Dofinansowanie', 'pln'),		
		array('wartosc_dofinansowanie_ue', 'Dofinansowanie UE', 'pln'),	
		
		array('forma_prawna_str', 'Forma prawna')	
				
	);
	
    protected $routes = array(
        'title' => 'tytul',
        'shortTitle' => 'tytul',
        'date' => 'data_podpisania',
    );
    
    protected $hl_fields =array(
    	'symbol', 'beneficjent_nazwa', 'wartosc_ogolem', 'dofinansowanie_ue'
    );
		
    public function getLabel()
    {
        return 'Dotacja unijna';
    }
    
    public function getMetaDescriptionParts($preset = false)
	{
		
		$output = array(
			dataSlownie( $this->getDate() ),
			$this->getData('dotacje_ue.beneficjent_nazwa'),
		);
		
		if( $this->getData('dotacje_ue.wartosc_dofinansowanie') )
			$output[] = number_format_h($this->getData('dotacje_ue.wartosc_dofinansowanie')) . ' PLN';
		
		return $output;
		
	}
    
}