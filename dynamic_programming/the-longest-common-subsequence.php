<?php

class LCS extends Model{
	public $seqA;
	public $seqB;
	private $memory;
	private $directions;

	public function getLCS($seqA, $seqB){
		$this->seqA = $seqA;
		$this->seqB = $seqB;
		$this->memory = array();
		for($i=0; $i<count($this->seqA); $i++){
			$this->memory[$i] = array();
		}

		for($a=0; $a<count($this->seqA); $a++){
			for($b=0; $b<count($this->seqB); $b++){
				$aValue = $this->seqA[$a];
				$bValue = $this->seqB[$b];
				if( $this->isEqual( $aValue, $bValue ) ){
					$this->memory[$a][$b] = 1 + $this->memoryValue( $a-1, $b-1 );
					$this->directions[$a][$b] = array($a-1, $b-1);
				} else {
					list($maxA, $maxB) = $this->getMax( array($a-1,$b), array($a, $b-1));
					$this->memory[$a][$b] = $this->memoryValue( $maxA, $maxB );
					$this->directions[$a][$b] = ( $maxA!=$a? array($a-1,$b) : array($a, $b-1) );
				}
			}
		}

		return $this->getPath();
	}

	//once I have memory matrix complete, with counters of the longest subsequences
	//I traceback for the subsequence
	private function getPath(){
		$path = array();
		$a = count($this->seqA)-1;
		$b = count($this->seqB)-1;
		$len = 99;
		while( $len>0 ){
			list( $a_new, $b_new ) = $this->directions[$a][$b];
			$len = $this->memoryValue($a_new, $b_new);
			if($this->memoryValue($a,$b)!=$len && $len>=0){
				$path[] = $this->seqA[$a];
			}
			$a = $a_new; $b = $b_new;
		}
		return array_reverse($path);
	}

	//return the value of memory array on (a,b) point
	private function memoryValue( $a, $b ){
		if($a<0 || $b<0 ){
			return 0;
		}

		return $this->memory[$a][$b];
	}

	private function getMax($pointA, $pointB){
		if( $this->memoryValue( $pointA[0], $pointA[1] ) > $this->memoryValue( $pointB[0], $pointB[1] ) ){
			return $pointA;
		} else {
			return $pointB;
		}
	}
	
	private function getMin($pointA, $pointB){
		if( $this->memoryValue( $pointA[0], $pointA[1] ) <= $this->memoryValue( $pointB[0], $pointB[1] ) ){
			return $pointA;
		} else {
			return $pointB;
		}
	}

	private function isEqual($a, $b){
		return $a==$b;
	}

	private function printMemory(){
		echo "\n\n";
		for($i=0; $i<count($this->seqA); $i++):
			if($i==0):
				echo " ";
				for($j=0; $j<count($this->seqB); $j++):
					echo " ".$this->seqB[$j];
				endfor;
			endif;
			
			echo "\n".$this->seqA[$i]." ";
			for($j=0; $j<count($this->seqB); $j++):
				echo $this->memory[$i][$j]." ";
			endfor;
		endfor;
		echo "\n\n";
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

//process input and call function
$s = fgets(STDIN);
$A = fgets(STDIN);
$B = fgets(STDIN);

$A = preg_split("/ /",$A);
for($i=0; $i<count($A); $i++){
	$A[$i] = intval($A[$i]);
}

$B = preg_split("/ /",$B);
for($i=0; $i<count($B); $i++){
	$B[$i] = intval($B[$i]);
}

$LCS = new LCS;
$path = $LCS->getLCS($A,$B);
print implode(" ",$path);
