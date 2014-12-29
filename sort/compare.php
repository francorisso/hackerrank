<?php

Class QuickSort extends Model {
	private $items;
	private $items_count;
	public $swaps = 0;

	public function __construct(){}

	public function sort( $array ){
		$this->items = (array) $array;
		$this->items_count = count($this->items);
    	$this->_sort();

    	return $this->items;
	}


	private function _sort($from=false, $to=false){
		if( $from===false || $to===false ){
			//$this->items = $this->partition_aux($this->items);
			$this->partition(0, $this->items_count);
		} else {
			$this->partition($from, $to);
		}
	}

	private function partition( $from, $to ){
		if( $to-$from < 2 ){
			return;
		}
		
		//token random, but moved to last element, so everything works clear
		//$token = rand( $from, $to-1);
		//$this->elem_switch($from, $token );
		$token = $to-1;
		$token_val = $this->items[$token];

		//indexes for low and high ends.
		//lo ends moves forward, while hi end move backwards
		$lo_idx = $from;
		$hi_idx = $token-1;
		for($i=$lo_idx; $i<=$hi_idx; $i++){
			$elem = $this->items[$i];
			if( $elem < $token_val ){				
				$this->elem_switch($i, $lo_idx++);
				$this->swaps++;
			}
		}
		
		$this->elem_switch($token, $lo_idx);
		$this->swaps++;
		$token = $lo_idx;

		$this->_sort($from, $token);
		$this->_sort($token+1, $to);
	}

	//partition using aux arrays
	private function partition_aux( $ar ){
		if( empty($ar) ){
			return array();
		}
		
		//token random, but moved to first element, so everything works clear
		//$token = rand( $from, $to-1);
		//$this->elem_switch($from, $token );
		$from = 0;
		$to = count($ar);
		$token = $from;
		$token_val = $ar[ $token ];

		//indexes for low and high ends.
		//lo ends moves forward, while hi end move backwards
		$lo_idx = $token+1;
		$hi_idx = $to-1;
		$lo_ar = $hi_ar = array();
		for($i=$lo_idx; $i<=$hi_idx; $i++){
			$elem = $ar[$i];
			if( $elem > $token_val ){
				//I switch with the element in the greater index
				//increase the greater index (by decreasing its value)
				//and decrease the counter $i, so it checks for this position again
				$hi_ar[] = $elem;
			} else {
				$lo_ar[] = $elem;
			}
		}

		if(!empty($lo_ar)){
			$lo_ar = $this->partition_aux( $lo_ar );
			$this->print_array_nl( $lo_ar );
		}
		if(!empty($hi_ar)){
			$hi_ar = $this->partition_aux($hi_ar);
			$this->print_array_nl( $hi_ar );
		}

		return array_merge(
				$lo_ar,
				array($token_val),
				$hi_ar
		);
	}

	private function elem_switch( $elem1, $elem2){
		$elem1_value  = $this->items[$elem1]; 
		$this->items[$elem1]  = $this->items[$elem2];
		$this->items[$elem2]  = $elem1_value;
	}

	private function is_sorted($from, $to){
		for($i=$from+1; $i<$to; $i++){
			if($this->items[$i-1]>$this->items[$i]){
				return false;
			}
		}
		return true;
	}

}

class Model {
	protected function print_array_nl( $array, $sep=" " ){
		if(count($array)<2){
			return;
		}
		print implode( $sep, $array )."\n";
	}
}

function insertionSort( $ar ){
	$output = array();
	$swifts = 0;
	for ( $i=1; $i<count($ar); $i++ ){
		for ( $j=$i; $j>0; $j-- ){
			if( $ar[$j] >= $ar[$j-1]){
				break;
			}
			$swifts++;
			$aux = $ar[$j-1];
			$ar[$j-1] = $ar[$j];
			$ar[$j] = $aux;
		}
		$output[] = implode(" ", $ar);
	}
	return $swifts;
}

//process input and call function
$s = fgets(STDIN);
$ar = fgets(STDIN);
$ar = preg_split("/ /",$ar);
for($i=0; $i<count($ar); $i++){
	$ar[$i] = (int) $ar[$i];
}

$ar2 = array();
foreach($ar as $e){
	$ar2[] = $e;
}

function iquants($array){
	return insertionSort($array);
}

function qquants($array){
	$quickSort = new QuickSort;
	$quickSort->sort($array);

	return $quickSort->swaps;
}
echo iquants($ar) - qquants($ar2);
