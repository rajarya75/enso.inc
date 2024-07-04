<?php

include 'constants.php';


/*echo "<pre>"; print_r($_GET); die();*/

$tariffArr = array(); 

$state = "Default";

if(isset($_GET['pincode']) && $_GET['pincode'] != ""){

	$get_state = $conn->prepare("SELECT * FROM solar_pincode WHERE pincode = ?");
	$get_state->bind_param('s', $_GET['pincode']);
	$get_state->execute();

	$state_result = $get_state->store_result();

	// $state_result = $get_state->get_result();

	if($get_state->num_rows > 0) {
		// while($row = $state_result->fetch_assoc()) {
		while($row = fetchAssocStatement($get_state)){
			$state = $row['state'];
		}
		$get_state->close();
	}else{
		echo '{"is_valid":0}';
		die();
	}

}

//get Tariff array
$get_tarrif = $conn->prepare("SELECT * FROM electricity_tariff WHERE state = ?");
$get_tarrif->bind_param('s', $state);
$get_tarrif->execute();

$tariff_result = $get_tarrif->store_result();
// $tariff_result = $get_tarrif->get_result();

// while($row = $tariff_result->fetch_assoc()) {
while($row = fetchAssocStatement($get_tarrif)){
	//echo json_encode($row);
	$tariffArr = $row;
}
$get_tarrif->close();

	
	$result = array();	

	$solar_geocode = ''; 
	// $solar_geocode = $_GET['solar_geocode']; 
	$monthly_bill = $_GET['solar_monthly_bill']; 
	$rooftop_area = $_GET['solar_roof_area'];

	if($rooftop_area == ""){
		$rooftop_area = 0;
	}

	$pincode = $_GET['pincode'];
	$sanctioned_load = $_GET['solar_sanc_load'];
	if($sanctioned_load == ""){
		$sanctioned_load = 0;
	}

	$loan_amount = $_GET['solar_loan_amt'];
	$loan_tenure = $_GET['solar_loan_tenure']; 

	$customer_category = strtolower($_GET['type']);
	
	if($state == ""){
		$state = "Default";
	}

	$electricity_cost = $tariffArr[$customer_category]; 

	// $per_kw_electricity_generation =  state['Electricity generation per KW']; data sheet
	$per_kw_electricity_generation = $tariffArr['electricity_generation'];

	$system_size_bill = (($monthly_bill / $electricity_cost) / 30) / $per_kw_electricity_generation; 

	// capacity_arr 
	$capacity_arr = array();
	$capacity_arr[] = $system_size_bill;

	$module_capacity = 0.365; // Predefined

	$kws_per_sq_ft = (($module_capacity/2)/10.7639)/1.1; 

	$system_size_tra = $rooftop_area * $kws_per_sq_ft; 

	if($system_size_tra > 0){
		$capacity_arr[] = $system_size_tra;
	}
	//=D6*VLOOKUP(Assumptions $H17,Data!$B6:$E42,4,FALSE)
	//vlookup(lookupvalue, table_array, col_index_num, [range_lookup] );

	//$multiplication_factor_on_sanctioned_load = state['Multiplication Factor on Sanctioned Load'];

	$multiplication_factor_on_sanctioned_load = 0.8; //database // data sheet
	$system_size_sl = $sanctioned_load * $multiplication_factor_on_sanctioned_load;
	if($system_size_sl > 0){
		$capacity_arr[] = $system_size_sl;
	}

	$solar_capacity = min($capacity_arr); //do not take '0' value
	$result['solar_capacity'] = round($solar_capacity,2);
	
	//--------------------------- price_range -------------------------------------------//
	$benchmark_cost = vlookup($solar_capacity, $benchmark_cost_arr ); //"INR"(between system size range)  constants		

	$system_cost = ($solar_capacity * $benchmark_cost)/ 100000; //output 1.6

	$price_range = round($system_cost, 2)." Lakhs";
	$result['price_range'] = $price_range;

/*	echo "<pre>";
	print_r($result);
die();*/
//-----------------------Payback period ------------------------------------------//
	
	$tariff_escalation_percentage = 2/100; // pre-defined (percent) 
	$tariff_escalation_rate = 1+1*$tariff_escalation_percentage; //calculated


	////// degradation_factor - for loop - 25 years
	$degradation_factor_plus = 0.70; //predefined
	$degradation_factor = array();

	for ($i=1; $i <= 25; $i++) { 
		
		if($i == 1){
			$degradation_factor[$i] = 0;
		}else{
			$degradation_factor[$i] = round($degradation_factor_plus * ($i - 1), 2);
		}
	}

	$annual_electricity_generation = $solar_capacity * $per_kw_electricity_generation * 365;
	$generation_per_month = $annual_electricity_generation/ 12;
	$savings_per_month = $generation_per_month * $electricity_cost; //dynammic

	////// Net Generation - for loop - 25 years
	$net_generation = array();
	$o_m_expenses = array();

	for ($i=1; $i <= 25; $i++) { 
		$net_generation[$i] =  round ($annual_electricity_generation *(1 - ($degradation_factor[$i]/100)) );
		$o_m_expenses[$i] =  - (round ($annual_electricity_generation *(1 - ($degradation_factor[$i]/100)) ));
		//$net_generation[$i] = $annual_electricity_generation *(1 - ($degradation_factor[$i]/100)) ;
	}


    ////// electricity_savings - for loop - 25 years
	$electricity_savings = array();
	for ($i=1; $i <= 25; $i++) { 
		$electricity_savings[$i] = round ($net_generation[$i] * $electricity_cost * pow($tariff_escalation_rate , ($i- 1)) );
		//$electricity_savings[$i] = $net_generation[$i] * $electricity_cost * pow($tariff_escalation_rate , ($i- 1));
	}

	/*print_r($degradation_factor);
	print_r($net_generation);
	print_r($electricity_savings);*/
	
////////////////////////////////// Bill saving Graph ////////////////////////////////////
	$cumulative_savings_bill_based = array();
	$cumulative_savings_generation_based = array();
	$bill_with_solar = array();
	$cumulative_savings = array();

	for ($year=1; $year<=25; $year++) {
		$cumulative_savings_bill_based[$year] = round ( ($monthly_bill *12) * pow($tariff_escalation_rate,$year-1) );

		$cumulative_savings_generation_based[$year] = round ( (($savings_per_month *12) * pow($tariff_escalation_rate,$year-1)) );

		$bill_with_solar[$year] = $cumulative_savings_bill_based[$year] - $cumulative_savings_generation_based[$year];

		$cumulative_savings[$year] = min($cumulative_savings_bill_based[$year], $cumulative_savings_generation_based[$year]);
	}

	$result['bill_data'] = array(
		'bill_with_solar' => $bill_with_solar,
		'bill_without_solar' => $cumulative_savings_bill_based,
		'cumulative_savings' => $cumulative_savings
	);

//------------------- LOAN -----------------------------------------------//
	if($loan_amount != "" && $loan_tenure != ""){
		$rate_of_interest = 12/100; //%//predefined  //per year
		$rate_of_interest_monthly = $rate_of_interest/12;

		$max_loan_amount = 0.9 * $system_cost * 100000;
		$initial_payment = $system_cost * 100000 - $loan_amount;
		$result['initial_payment'] = round($initial_payment);

		$debt_to_equity_mix = $loan_amount / ($system_cost * 100000);

		$no_of_payments = $loan_tenure * 12;
		$result['no_of_payments'] = $no_of_payments;

		$emi_per_month = ceil ($loan_amount * $rate_of_interest_monthly * (pow(1 + $rate_of_interest_monthly, $no_of_payments) / (pow(1 + $rate_of_interest_monthly, $no_of_payments) - 1)) );

		$result['emi_per_month'] = $emi_per_month;

		//monthly
		$opening_balance_arr = array();
		$interest_arr = array();
		$principal_arr = array();
		$closing_balance_arr = array();

		$opening_balance_arr[1] = $debt_to_equity_mix * $system_cost * 100000; //first an pick from loan amt
		$interest_arr[1] = ceil($opening_balance_arr[1] * $rate_of_interest/12); 
		$principal_arr[1] = ceil($emi_per_month - $interest_arr[1]);
		$total_emi = ceil($principal_arr[1] + $interest_arr[1]);
		$closing_balance_arr[1] = ceil($opening_balance_arr[1] - $principal_arr[1]);

		/*echo "<br> ".$opening_balance_arr[1] = $debt_to_equity_mix * $system_cost * 100000; //first month , you can pick from loan amt
		echo "<br> ".$interest_arr[1] = $opening_balance_arr[1] * $rate_of_interest/12; 
		echo "<br> ".$principal_arr[1] = $emi_per_month - $interest_arr[1];
		echo "<br> ".$total_emi = $principal_arr[1] + $interest_arr[1];
		echo "<br> ".$closing_balance_arr[1] = $opening_balance_arr[1] - $principal_arr[1];*/

		for ($month=2; $month <= $no_of_payments; $month++) { 
			$opening_balance_arr[$month] = ceil($opening_balance_arr[$month-1] - $principal_arr[$month-1]);
			$interest_arr[$month] = ceil($opening_balance_arr[$month] * $rate_of_interest/12 );
			$principal_arr[$month] = ceil($emi_per_month - $interest_arr[$month] );
			$closing_balance_arr[$month] = ceil($opening_balance_arr[$month] - $principal_arr[$month] );

			if($closing_balance_arr[$month] < 0){
				$closing_balance_arr[$month] = 0;
			}
			/*$opening_balance_arr[$month] = $opening_balance_arr[$month-1] - $principal_arr[$month-1];
			$interest_arr[$month] = $opening_balance_arr[$month] * $rate_of_interest/12;
			$principal_arr[$month] = $emi_per_month - $interest_arr[$month];
			$closing_balance_arr[$month] = $opening_balance_arr[$month] - $principal_arr[$month];*/
		}

		/*echo "<pre>";
		print_r($opening_balance_arr);
		print_r($principal_arr);
		print_r($interest_arr);*/
		//print_r($closing_balance_arr);

		$opening_balance_arr_temp = $principal_arr_temp = $interest_arr_temp = array();

		for ($year=1; $year <= 10 ; $year++) { 
			
			if($year <= $loan_tenure){
				$targetIn = ($year-1) * 12 + 1;

				$opening_balance_arr_temp[$year] = round($opening_balance_arr[$targetIn]);
				$principal_arr_temp[$year] = round($principal_arr[$targetIn]);
				$interest_arr_temp[$year] = round($interest_arr[$targetIn]);
			}else{
				$opening_balance_arr_temp[$year] = 0;
				$principal_arr_temp[$year] = 0;
				$interest_arr_temp[$year] = 0;
			}
		}

		$result['loan_data'] = array(
			'opening_balance' => $opening_balance_arr_temp,
			'principal' => $principal_arr_temp,
			'interest' => $interest_arr_temp
		);
		
	}

	//irr sheet ///////////////////////////////
		//$debt_to_equity_mix = 18/100; //18 %

	if($loan_amount > 0){
		$debt_to_equity_mix = $loan_amount / ($system_cost * 100000);
		$new_principal_arr = $principal_arr;
		$new_interest_arr = $interest_arr;
	}else{
		$debt_to_equity_mix = 0;
		$new_principal_arr = array_fill(0, 25, 0);
		$new_interest_arr = array_fill(0, 25, 0);
	}

	// echo "<pre>";
	$upfront_cost = - ($system_cost * 100000 * (1 - $debt_to_equity_mix )); //first year
	//upfront cost  = 0 for remaining years

	
	// print_r($new_principal_arr);

	$irr_principal_arr = array();
	for ($year=1; $year <= 25 ; $year++) { 
		$start_months = ($year-1) * 12;
		$end_months = 12;

		$irr_principal_arr[$year] = -(array_sum(array_slice($new_principal_arr, $start_months, $end_months)) );
		///echo 'start months : '.$start_months. ' start months : '.$end_months; echo "<br>";
	}
	
	//print_r($irr_principal_arr);
	//die();

	$irr_interest_arr = array();
	for ($year=1; $year <= 25 ; $year++) { 
		$start_months = ($year - 1) * 12;
		$end_months = 12;
		$irr_interest_arr[$year] = -(array_sum(array_slice($new_interest_arr, $start_months, $end_months)) );
	}

	//echo $upfront_cost;
/*	print_r($irr_principal_arr);
	print_r($irr_interest_arr);
	print_r($electricity_savings);
	print_r($o_m_expenses);*/


	// Operation and Maintenance Expenses - 25 years
		//$o_m_expenses = - $net_generation;

	$total_cash_flow_arr = array();
	$cumulative_cash_flow_arr = array();

	for ($year=1; $year <= 25; $year++) { 
		if($year != 1){
			$upfront_cost = 0;
		}
		$total_cash_flow_arr[$year] = $upfront_cost + $irr_principal_arr[$year] + $irr_interest_arr[$year] + $electricity_savings[$year] + $o_m_expenses[$year];

		if($year == 1){
			$cumulative_cash_flow_arr[$year] = $total_cash_flow_arr[$year];
		}else{
			$cumulative_cash_flow_arr[$year] = $total_cash_flow_arr[$year] + $cumulative_cash_flow_arr[$year - 1];
		}
	}
	/*$me = array_merge_recursive($irr_principal_arr,$irr_interest_arr, $electricity_savings, $o_m_expenses );
	print_r($me);*/

/*	$nj = array();
	for($i = 1; $i <= 25; $i++) {
		$nj[$i]['principal'] = $irr_principal_arr[$i];
		$nj[$i]['interest'] = $irr_interest_arr[$i];
		$nj[$i]['elect sav'] = $electricity_savings[$i];
		$nj[$i]['Expenses'] = $o_m_expenses[$i];
		$nj[$i]['total cash'] = $total_cash_flow_arr[$i];
	}
	print_r($nj);
	//print_r($total_cash_flow_arr);
	//print_r($cumulative_cash_flow_arr);
	die();*/

	function neg($var){
	    if($var < 0){
	        return $var;
	    }        
	}

	$payback_period =  count(array_filter($cumulative_cash_flow_arr, "neg"));
	$result['payback_period'] = $payback_period;

	//print_r($total_cash_flow_arr);
	//print_r($cumulative_cash_flow_arr);

	
	

	//------------------- Environment ---------------------------------------------//
	// YEARLY
	$co2_saved = array();
	$cumulative_co2_saved = array();
	$equivalent_trees_planted = array();
	$cumulative_equivalent_trees_planted = array();
	

	for ($year=1; $year <= 25 ; $year++) { 
		$co2_saved[$year] = $net_generation[$year] * pow(0.997,($year-1)); 

		$equivalent_trees_planted[$year] = ($net_generation[$year] * pow(0.997,($year-1)) ) * 0.1;

		if($year == 1){
			$cumulative_co2_saved[$year] = $co2_saved[$year];

			$cumulative_equivalent_trees_planted[$year] = $equivalent_trees_planted[$year];
		}else{

			$cumulative_co2_saved[$year] = $cumulative_co2_saved[$year-1] + $co2_saved[$year];

			$cumulative_equivalent_trees_planted[$year] = $cumulative_equivalent_trees_planted[$year - 1] + $equivalent_trees_planted[$year];
		}

	}

	$result['cumulative_co2_saved'] = round($cumulative_co2_saved[25]) ." kg";
	$result['cumulative_equivalent_trees_planted'] = round($cumulative_equivalent_trees_planted[25]);

	/*	
	print_r($co2_saved);
	print_r($cumulative_co2_saved);
	print_r($equivalent_trees_planted);
	print_r($cumulative_equivalent_trees_planted);
	*/

	$m1 = $monthly_bill ? $accuracy_weightage_arr['monthly_bill'] : 0;
	$m2 = $rooftop_area ? $accuracy_weightage_arr['rooftop_area'] : 0;
	$m3 = $pincode ? $accuracy_weightage_arr['pincode'] : 0;
	$m4 = $sanctioned_load ? $accuracy_weightage_arr['sanctioned_load'] : 0;
	$m5 = $solar_geocode ? $accuracy_weightage_arr['solar_geocode'] : 0;

	$result['accuracy'] = ($m1 + $m2 + $m3 + $m4 + $m5). '%';

	header('Content-Type: application/json');
	echo json_encode($result);
	/*echo "<pre>";
	print_r($result);
	die();*/

?>