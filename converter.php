<?php
function toBangla($number){
	$var="";

	if($number==false) return '০';
	while($number!=0){
		$mod = $number % 10;
		if($mod==1) $var = '১'.$var;
		if($mod==2) $var = '২'.$var;
		if($mod==3) $var = '৩'.$var;
		if($mod==4) $var = '৪'.$var;
		if($mod==5) $var = '৫'.$var;
		if($mod==6) $var = '৬'.$var;
		if($mod==7) $var = '৭'.$var;
		if($mod==8) $var = '৮'.$var;
		if($mod==9) $var = '৯'.$var;
		if($mod==0) $var = '০'.$var;
		$number = intdiv($number,10);
	} 
	return $var;
}
?>