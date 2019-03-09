<?php

	for($i =1; $i<=100; $i++){
		//echo '&nbsp'.$i.',';
		if(($i % 3 === 0) && ($i % 5 === 0)){
			echo 'foobar';
		} elseif ($i % 5 === 0) {
			echo 'bar';
		} elseif ($i % 3 === 0) {
			echo 'foo';	
		} else {
			echo $i;
		}

		if ($i === 100) {
			echo ', '
		}
	}
