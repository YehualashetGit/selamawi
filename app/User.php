<?php 
	class User{

		public $firstName;
		public $lastName;

		public function setFirstName($name){
			$this->firstName = trim($name);
		}

		public function getFirstName(){
			return $this->firstName;
		}

		public function setLastName($name){
			$this->lastName = trim($name);
		}

		public function getLastName(){
			return $this->lastName;
		}


		public function getFullName(){
			return $this->firstName . " " . $this->lastName;
		}

		public function setEmail( $email ){
			$this->email =  $email;
		}

		public function getEmail( ){
			return $this->email;
		}

		public function getEmailVariables(){
			return [
					'full_name' => $this->firstName . " ". $this->lastName,
					"email" => $this->email
			];

		}
	}

?>