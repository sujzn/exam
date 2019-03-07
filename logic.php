<?php

	for($i =1; $i<=100; $i++){
		//echo '&nbsp'.$i.',';
		if(($i % 3 == 0) && ($i % 5 == 0)){
			echo '&nbsp foobar,';
		} elseif ($i % 5 == 0) {
			echo '&nbsp bar,';
		} elseif ($i % 3 == 0) {
			echo '&nbsp foo,';	
		} else {
			echo '&nbsp'.$i.',';
		}
	}

?>