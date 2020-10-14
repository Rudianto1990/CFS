<?php

/*|	
 | Function Name	: testService
 | Description 		: Just for testing
 | */
function testService($in_param) {
	try {
		//$conn = oriDb();
		
		//if(!checkOriDb($conn,$err)) 
			//goto Err;

		$message = "Success";
		goto Success;
	}
	catch (Exception $e) {
		$err = $e->getMessage();
		goto Err;
	}
	
	$message = $in_param;
	
	goto Success;
	
	Err:
		//closeOriDb($conn);
		return "F^".$err;
	
	Success:
		//closeOriDb($conn);
		return "S^".$message;
}

?>