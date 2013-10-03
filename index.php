<?php 

/**
* Roman Numeral Generator:
* 
* Approach:
* 
* The first thing that comes to mind is starting with the biggest roman numerals and seeing if the number is divisible by it, if so, an integer devision would give the number of times that letter should be represented.
* 
* i.e.
* 
* $number_of_Ms = floor($number / 1000);
* 
* This approach seems to get tricky when it comes to 4 and 9.
* 
* 
* The next approach that jumps to mind is to map the behavior for each order of digits, and map them to the formula that generates them.
* 
* eg.
* array(
* 	0 => '',
* 	1 => 'single_unit',
* 	2 => 'single_unit' . 'single_unit',
* 	3 => 'single_unit' . 'single_unit' . 'single_unit',
* 	4 => 'single_unit' . 'five_unit',
* 	5 => 'five_unit',
* 	6 => 'five_unit' . 'single_unit',
* 	7 => 'five_unit' . 'single_unit' . 'single_unit',
* 	8 => 'five_unit' . 'single_unit' . 'single_unit' . 'single_unit',
* 	9 => 'single_unit' . 'ten_unit',
* )
* 
* And then map the orders
* 
* array(
* 	1 => array(
* 		'single' => 'I',
* 		'five' => 'V'
* 	),
* 	2 => array(
* 		'single' => 'X',
* 		'five' => 'L'
* 	),
* 	3 => array(
* 		'single' => 'C',
* 		'five' => 'D'
* 	),
* 	4 => array(
* 		'single' => 'M'
* 	)
* )
* 
* with that in mind I created the following class
**/


//create a class to handle the conversion from integer to Roman Numeral format

class RomanNumeralGenerator
{
	private $number_formula_array = array(
			0 => '',
			1 => 'single_unit',
			2 => 'single_unitsingle_unit',
			3 => 'single_unitsingle_unitsingle_unit',
			4 => 'single_unitfive_unit',
			5 => 'five_unit',
			6 => 'five_unitsingle_unit',
			7 => 'five_unitsingle_unitsingle_unit',
			8 => 'five_unitsingle_unitsingle_unitsingle_unit',
			9 => 'single_unitten_unit',
		);
	private $numeral_mapping = array(
			1 => array(
				'single' => 'I',
				'five' => 'V'
			),
			2 => array(
				'single' => 'X',
				'five' => 'L'
			),
			3 => array(
				'single' => 'C',
				'five' => 'D'
			),
			4 => array(
				'single' => 'M'
			)
		);

	public function generate($input_number) {
		//return false if input is not valid
		if(!is_integer($input_number) || $input_number < 1 || $input_number > 3999)
		{
			return FALSE;
		}
		//convert number to array
		$number_array = str_split($input_number);
		//reverse array
		$number_array = array_reverse($number_array);
		//create new indexes
		$number_array = array_values($number_array);
		// unshift so that keys represent number order
		array_unshift($number_array, 'placehoder');
		//get rid of unnecessary value;
		unset($number_array[0]);
		//create return array
		$return_array = array();
		//loop through number array and get roman numerals
		foreach ($number_array as $order => $digit) {
			$return_array[] = $this->_get_numberals($digit, $order);
		}
		//reverse array to original orientation;
		$return_array = array_reverse($return_array);
		//convert array to string
		$return_string = implode($return_array);
		return $return_string;
	}

	private function _get_numberals($digit, $order)
	{
		//get the format string for this digit
		$return_string = $this->number_formula_array[$digit];
		//replace the single units in this string with the relevant numeral
		$single_unit = $this->numeral_mapping[$order]['single'];
		$return_string = str_replace('single_unit', $single_unit, $return_string);
		if($order < 4)
		{
			//replace the five and ten units in this string with the relevant numeral
			$five_unit = $this->numeral_mapping[$order]['five'];
			$ten_unit = $this->numeral_mapping[$order + 1]['single'];
			$return_string = str_replace('five_unit', $five_unit, $return_string);
			$return_string = str_replace('ten_unit', $ten_unit, $return_string);
		}
		return $return_string;
	}
}



//testing
$roman = new RomanNumeralGenerator();
echo 123;
echo '<br/>';
echo $roman->generate(123);
echo '<br/>';

echo 1;
echo '<br/>';
echo $roman->generate(1);
echo '<br/>';

echo 513;
echo '<br/>';
echo $roman->generate(513);
echo '<br/>';

echo 3999;
echo '<br/>';
echo $roman->generate(3999);
echo '<br/>';

echo 4000;
echo '<br/>';
echo $roman->generate(4000);
echo '<br/>';

echo 0;
echo '<br/>';
echo $roman->generate(0);
echo '<br/>';

echo 0.2;
echo '<br/>';
echo $roman->generate(0.2);
echo '<br/>';
