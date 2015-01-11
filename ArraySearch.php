<?php

/**
 * 
 * ArraySearch
 * 
 * Created for do to search inside of array.
 * if you do $all is 1, all results will return to array 
 * 
 * Example: ArraySearch( array $dizi, string "key1 = 'bunaesitolmali1' and key2 >= 'bundanbuyukolmali' or key3 != 'bunaesitolmasin3'", int $all = 0 );
 * 
 */

function ArraySearch($SearchArray, $query, $all = 0, $Return = 'direct')
{
    
    $SearchArray	    =	json_decode(json_encode($SearchArray), true);
    
    $ResultArray    =	array();
    
    if (is_array($SearchArray))
    {
	
	$desen = "@[\s*]?[\'{1}]?([a-zA-Z\ç\Ç\ö\Ö\ş\Ş\ı\İ\ğ\Ğ\ü\Ü[:space:]0-9-_]*)[\'{1}]?[\s*]?(\<\=|\>\=|\=|\!\=|\<|\>)\s*[\'{1}]?([a-zA-Z\ç\Ç\ö\Ö\ş\Ş\ı\İ\ğ\Ğ\ü\Ü[:space:]0-9-_]*)[\'{1}]?[\s*]?(and|or|\&\&|\|\|)?@si";
	$DonenSonuc	=	preg_match_all($desen,$query,$Result);

	if ( $DonenSonuc )
	{

	    foreach ( $SearchArray as $i => $ArrayElement )
	    {

		$SearchStatus = 0;

		$EvalString   = "";
		
		for( $r = 0; $r < count($Result[1]); $r++ ):

		    if ( $Result[2][$r] == '=' ) {
			$Operator   =	"==";
		    }elseif ( $Result[2][$r] == '!=' ) {
			$Operator   =	"!=";
		    }elseif ( $Result[2][$r] == '>=' ) {
			$Operator   =	">=";
		    }elseif ( $Result[2][$r] == '<=' ) {
			$Operator   =	"<=";
		    }elseif ( $Result[2][$r] == '>' ) {
			$Operator   =	">";
		    }elseif ( $Result[2][$r] == '<' ) {
			$Operator   =	"<";
		    }else{
			$Operator   =	"==";
		    }
		    
		    $AndOperator    =	"";
		    
		    if ( $r != count ($Result[1]) - 1 ) {
			$AndOperator = $Result[4][$r]?:'and';
		    }

		    $EvalString	.=   '("' . $ArrayElement[ $Result[1][$r] ] . '"' . $Operator . '"' . $Result[3][$r] . '") ' . $AndOperator . ' ';
		    
		endfor;
		
		eval('if( ' . $EvalString . ' ) $SearchStatus = 1;');

		if ( $SearchStatus === 1 ) {

		    if ( $all === 1 ) {
			
			if ( $Return == 'direct' ) :
			
			    $ResultArray[]	    =	$ArrayElement;
			    
			elseif ( $Return == 'array' ) :
			
			    $ResultArray['index'][] =	$i;
			    $ResultArray['array'][] =	$ArrayElement;
			    
			endif;

		    } else {
			
			if ( $Return == 'direct' ) :
			    $ResultArray	    =	$i;
			elseif ( $Return == 'array' ) :    
			    $ResultArray['index']   =	$i;
			endif;

			return $ResultArray;

		    }

		}

	    }

	    if ( $all === 1 ){
		return $ResultArray;
	    }

	}
	
    }
    
    return false;
   
}
