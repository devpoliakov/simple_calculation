<?php

/*
Write a class Calculator in PHP that should implement `add` functionality of 2 numbers.
As a user of this class I should be able to make such call "$calculator->add(2, 3)".
Constructor implementation is of your choice.
If any of numbers is < 1000 class will calculate in memory.
If any number is >= 1000 class will calculate via http call to remote server.
If any number is >= 100000 class will calculate via SOAP call
Make sure that your Calculator is SOLIDly designed

*/


// should be extend from an Abstract

 class Connection {
	protected $number_handler;

	public function __construct($number_handler = array()){
		$this->number_handler = $number_handler;
	}

	protected function connect_false(){
		return false;
	}

	protected function connect_remoteServer(){			
		$connection = 'connect by remoteServer';

		return $connection;
	}
		
	protected function connect_SOAP(){
		$connection = 'connect by SOAP';

		return $connection;
	}

    public function return_connection($number_arr = array()){
    	$top_number = max($number_arr);
    	$connect_by = 'connect_false';

    	foreach ($this->number_handler as $key => $value) {
    		if($top_number >= $key){
				$connect_by = $value;
				break;    			
    		}
    	}

    	$connection = $this->{$connect_by}();

    	return $connection;

    }
}



class Calucation {
	protected $connection;

	public function __construct($connection = false){
		$this->connection = $connection;
	}

	protected function adding($number_arr = array()){

		$result = 0;

		foreach($number_arr as $val) {
		  $result += $val;
		}
		return $result;

	}

	protected function need_connection($number_arr){
		$method_connection = $this->connection->return_connection($number_arr);

		return $method_connection;
	}

	protected function use_sender_class($method_connection){
		return "Your data sent to the $method_connection";
	}

	public function processing($number_arr = array(), $operation = 'adding'){

		$method_connection = $this->need_connection($number_arr);

		if($method_connection){
			$this->use_sender_class($method_connection);
			echo "Your data sent to the \"$method_connection\": \n";
		}else{

			$result = $this->{$operation}($number_arr);

			echo "Your $operation result: \n";
			echo $result;
		}
	}
}

$connection_params = array(
	'1000' => 'connect_remoteServer',
	'100000' => 'connect_SOAP'
);

$connect = new Connection($connection_params);
$calculate = new Calucation($connect);

$calculate->processing(array(77,80,15));

