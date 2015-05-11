<?

namespace MP\Lib;

class DocDataObject extends DataObject
{
	
	public $classes = array('docdataobject');
	
	/*
    public function getThumbnailUrl($size = '2')
    {

        $dokument_id = $this->getData('dokument_id');
        return $dokument_id ? 'http://docs.sejmometr.pl/thumb/' . $size . '/' . $dokument_id . '.png' : false;

    }
    */
    
    public function getIcon()
	{
		return '<i class="object-icon glyphicon glyphicon-file"></i>';
	}
}