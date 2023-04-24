<?php 
function CheckField($field, $isRequiered, $pattern){
	if(empty($field) && $isRequiered)
	{
		return false;
	} 
	if(!empty($pattern))
	{
		if(!preg_match($pattern,$field)){
			return false;
		}
	} 
	return true;
}
?>