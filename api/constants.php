<?php



include 'config.php';



$module_capacity = 0.365; 

$tariff_escalation_percentage = 2/100;

$degradation_factor_plus = 0.70;

$rate_of_interest = 12/100;


$accuracy_weightage_arr = array(
	'monthly_bill' 		=> 50, 
	'rooftop_area' 		=> 20, 
	'pincode' 			=> 5, 
	'solar_geocode' 	=> 5, 
	'sanctioned_load' 	=> 5
);

$benchmark_cost_arr	= array(
			0 => 55000, //for values <=3 but >2
			2 => 54000,
			3 => 53500,
			4 => 52000,
			6 => 50000,
			10 => 48000,
			20 => 45000,
			35 => 42000,
			100 => 41000
		);

function vlookup($lookupValue,$array){

    $result = "";

    //test each set against the $lookupValue variable,
    //and set/reset the $result value

    foreach($array as $key => $value)
    {
        if($lookupValue > $key)
        {
        	$result = $value;
        }
    }

    return $result;

}


?>