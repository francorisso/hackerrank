<?php

function partition( $ar, $from, $to ){
	if($to<$from){
		return $ar;
	}
	
	$pivot 		= $ar[ $from ];
	$from_idx 	= $from+1;
	$to_idx 	= $to;
	while( $from_idx < $to_idx ){
		while($from_idx<$to && $ar[$from_idx]<$pivot){
			$from_idx++;
		}
		while($to_idx>$from && $ar[$to_idx]>$pivot){
			$to_idx--;
		}
		if( $from_idx < $to_idx ){
			echo "\nChange: $from_idx - $to_idx \n";
			$aux 			= $ar[$from_idx];
			$ar[$from_idx] 	= $ar[$to_idx];
			$ar[$to_idx] 	= $aux;
		
			$from_idx++;
			$to_idx--;
		}
	}

	if( $ar[$from]>$ar[$to_idx]){
		$aux 		 = $ar[$from];
		$ar[$from] 	 = $ar[$to_idx];
		$ar[$to_idx] = $aux;
	}
	
		
	$ar = partition($ar, $from, $to_idx-1);
	$ar = partition($ar, $to_idx+1, $to);

	return $ar;
}

function quickSort( $ar ){
	$N = count($ar);
    return partition( $ar, 0, $N-1 );
}

//process input and call function
$s = fgets(STDIN);
$ar = fgets(STDIN);
$ar = preg_split("/ /",$ar);
foreach($ar as &$e){
	$e = intval($e);
}

$res = quickSort( $ar );
echo implode(" ", $res);
