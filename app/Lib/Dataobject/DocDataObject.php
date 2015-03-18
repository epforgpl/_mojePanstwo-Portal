<?

namespace MP\Lib;

class DocDataObject extends DataObject
{

    public function getThumbnailUrl($size = '2')
    {

        $dokument_id = $this->getData('dokument_id');
        return $dokument_id ? 'http://docs.sejmometr.pl/thumb/' . $size . '/' . $dokument_id . '.png' : false;

    }
}