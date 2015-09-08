<?
		
	class Gmina extends AppModel
	{
		
		private $populationRanges = array(
	        array(0, 20000),
	        array(20000, 50000),
	        array(50000, 100000),
	        array(100000, 200000),
	        array(200000, 9999999)
	    );
		
		public function getPopulationRange($count) {
	        $min = 0; $max = 0; $count = (int) $count;
	        foreach($this->populationRanges as $range) {
	            if($count >= $range[0] && $count <= $range[1]) {
	                $min = $range[0];
	                $max = $range[1];
	                break;
	            }
	        }
	
	        return array(
	            'min' => $min,
	            'max' => $max
	        );
	    }
	    
	}