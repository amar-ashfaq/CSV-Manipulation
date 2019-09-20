<?php
	
	/*author: Amar Ashfaq*/

	//refine the implementation
	//apply comments
	//review it and make any necessary changes
	
	/*
		Note: I did my best to avoid using prohibited functions however there was one that I couldn't quite avoid due to complexity.
		I used the arsort() function in the end since I wasn't able to sort the array in a non-asc manner... I do apologise
	*/
	
  $bigDataArr = [];
	$newArr = [];
	$ultimateArr = Array("total","mean","modal","frequency","median");
	$finalArrVals = [];

		//open the csv file
		if(($h = fopen("testdata.csv", "r")) !== FALSE){
			
			//read each line
			while (($data = fgetcsv($h,1000,",")) !== FALSE){
				
				if(!is_numeric($data[0])){
					$data = fgetcsv($h);
					$bigDataArr[] = $data;
				}			
                else{
					$bigDataArr[] = $data;
                }	
			}
			fclose($h);
			
			//foreach array entry inside big array
			//grab the second index (i.e. the value we want)
			//then add them to the newArr Array 
			foreach($bigDataArr as $singleArr){
				$newArr[] = $singleArr[1];
			}
		}
		
		//var_dump($newArr);
		
		$total = 0;
		
		for($x = 0; $x < count($newArr); $x++){
			$total = $total + $newArr[$x];
		}
		
		$mean = $total / count($newArr);
		
		$count = count($newArr); //total numbers in array
		$mid = floor(($count-1)/2); //find the mid value, or the lowest mid
		
		if($count % 2) { //if odd number, middle is the median
			$median = $newArr[$mid];
		} 
		else { //if even number, calculate avg of 2 medians
			$low = $newArr[$mid];
			$high = $newArr[$mid + 1];
			$median = ($low + $high) / 2;
		}
		
		$frequency = 0;
		
		  $values = array();
		  
		  foreach ($newArr as $v) {
			if (isset($values[$v])) {
			  $values[$v] ++;
			} else {
			  $values[$v] = 1;  //counter of appearance
			}
		  } 
		  arsort($values);  //sort the array by values, in non-asc order.
		  
		  $modes = array();
		  $x = $values[key($values)]; //get the most appeared value
		  reset($values); 
		  foreach ($values as $key => $value) {
			if ($value == $x) {   //if there are multiple 'most'
			  $modes[] = $key;  //push to the modes array
			  $frequency = $value;
			} else {
			  break;
			}
		  }
		//push each of the computed results into the finalArrVals array
		array_push($finalArrVals, $total);
		array_push($finalArrVals, $mean);
		array_push($finalArrVals, $modes);
		array_push($finalArrVals, $frequency);
		array_push($finalArrVals, $median);
				
		//create an associative array which you can encode as JSON String...
		header('Content-Type: application/json');
		
		//print out the JSON String and voila...
		echo json_encode(array_combine($ultimateArr, $finalArrVals));
?>
