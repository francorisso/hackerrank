<?php


function insertionSort( $ar ){
	$output = array();
	for ( $i=1; $i<count($ar); $i++ ){
		for ( $j=$i; $j>0; $j-- ){
			if( $ar[$j] > $ar[$j-1]){
				break;
			}

			$aux = $ar[$j-1];
			$ar[$j-1] = $ar[$j];
			$ar[$j] = $aux;
		}
		$output[] = implode(" ", $ar);
	}
	return $output;
}


//process input and call function
$s = fgets(STDIN);
$ar = fgets(STDIN);
$ar = preg_split("/ /",$ar);
foreach($ar as &$e){
	$e = intval($e);
}

echo implode("\n", insertionSort($ar));