<?

namespace MP\Lib;
require_once('DocDataObject.php');

class Sejm_komisje_opinie extends DocDataObject
{
	
	protected $tiny_label = 'Sejm';
	
    public function getLabel()
    {
        return '<strong>Opinia</strong> ' . $this->getData('sejm_komisje.dopelniacz');
    }

    public function getShortTitle()
    {
        return $this->getData('tytul');
    }

    public function getTitle()
    {
        return $this->getShortTitle();
    }

    public function getUrl() {

        return '/dane/instytucje/3214/komisje_opinie/' . $this->getId() . ',' . $this->getSlug();

    }

    public function getBreadcrumbs()
    {

        return array(
            array(
                'id' => '/dane/instytucje/3214,sejm-rzeczypospolitej-polskiej/komisje_opinie',
                'label' => 'Opinie komisji sejmowych',
            ),
        );

    }
    
    public function getMetaDescriptionParts($preset = false)
	{
						
		$output = array();
		
		if( $this->getDate() )
			$output[] = dataSlownie($this->getDate());
			
		if( $this->getData('sejm_komisje_opinie.adresat') )	
			$output[] = $this->getData('sejm_komisje_opinie.adresat');
				
		return $output;
		
	}
} 