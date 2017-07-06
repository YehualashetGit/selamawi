<?php
		
	class DataGenrator extends PHPUnit_Framework_TestCase{
		

		/**
		 * split one long word in to different words.
		 * the split is done at different point in the long string
		 */
		public static function meanigfy_data( $data ){

				$word_lens = [5, 4, 3, 6,7, 2];
				$cur = 0;

				$words = [];

				
				for($i=0; $i < strlen($data); ){
					
					$word_len = $word_lens[  rand(1,100)%count($word_lens) ];
					
					$cur_word = substr($data, $i, $word_len);
					
					if ( array_search( strlen($cur_word), $word_lens ) > 0 )
						$words[] = $cur_word;
					
					$i += $word_len;

				}

				return implode(" ", $words);
		}

		/** returns random string */
		public static function randomWord(){

			$cur_time = time();
				
			$random = rand(10000,10000000);

			$word1 = md5($cur_time . " - " . $random) . " ";
			$word2 = md5($cur_time . " - " . $random . " ");

			$word = base64_encode( $word1.$word2 );

			//remove the equal sign at the end of base 64 encoded string
			$word = substr( $word, 0, strlen( $word ) -1 );

			$word = strtolower( preg_replace( "/\d+/", "", $word) );

			$vowels = ['e','i','o','u','a'];

			//counts number of consequent consonants 
			$consonant_counter = 0;

			$new_word = "";

			for( $i =0; $i < strlen( $word ); $i++ ){

				// 3 consonants in sequence, add one vowel in between
				if ( $consonant_counter == 2 ){

					$new_word .= $vowels[ rand(1,100) % count( $vowels ) ];
					$consonant_counter = 0;
				}

				$is_vowl = is_int(array_search( $word[$i], $vowels));

				if ( !$is_vowl )
					$consonant_counter += 1;
				else
					$consonant_counter = 0;

				$new_word .= $word[ $i ];

			}

			return $new_word;
		}

		/** return string of words */
		public static function generateRandomString( $num_words = 1){

			

			$words = "";

			for( $i=0; $i < $num_words; $i++)
				$words .= self::randomWord();

			$words = self::meanigfy_data( $words );

			return  ucfirst( $words );

		}

		public static function generateRandomEmail(){

			
			$hosts = [
							"gmail.com",
							"hotmail.com",
							"yahoo.com",
							"selamawi.net",
							"aait.edu.et",
							"facebook.com",
							"ghostmail.com",
							"jimma.eud.et",
							"youtube.com"
			];

			//selects random host from hosts array
			$host = $hosts[ rand(1, 100) % count( $hosts ) ];

			$rand_word = self::randomWord();

			//select the first 5-10 words from generated random word
			$username = substr($rand_word, 0 , rand(5,10));

			return $username . "@" . $host;

		}

		public static function getAWord(){
			$random_word = self::randomWord();

			$word_len = [5,6,7,8,9];

			return substr( $random_word, 0, $word_len[rand(1,10) % count( $word_len )] );
		}

		/**
		 * 
		 * Student Data generator ***
		 * 
		*/
		
		private $first_name;
		private $middle_name ;
		private $last_name;

		//data generation methods
		public function initializer_data(){
			
			$db = new DB();

			$studentID = 1;

			$query = "SELECT * FROM " . TABLE_STUD . " WHERE studID = " . $studentID . " LIMIT 1";
			
			$db->prp_stmt($query);
			
			$result = $db->get_resultset();

			$student = $result[0];
			
			return [
						"integer" => [1],
						"Object"  => [$result[0]],
						"Array"   => [ 
										[
											"fname" => "Test",
											"mname" => "Data",
											"lname" => "Student",
											"ID" => "TEST/001",
											"email" => "test@testdata.com",
											"department" => 1,
											"year" => 1,
											"semester" => 1
										] 
						]

					];

		}

		

		public function register_student_data(){

			return [	
						//email is not in databasae
						"Unknown Email" => [self::generateRandomEmail(), "strongpassword", False],

						//already registred with this email 
						"Already registered email"=>["student@testdata.com", "strongpassword", False],

						//email in database and not registred
						"Unregistered email"=>["student@gmail.com", self::getAWord(), true]
					];
		}

		public function search_petition_data(){
			return [
						"no-keyword" => [ substr(self::generateRandomString(), 0, 10), false ],
						"keyword" => ["computer", true]
			];
		}

		public function password_data(){

			return [
					"wrong-old-password" => [self::generateRandomString(), self::generateRandomString(), false],
					'valid-old-password' => [self::generateRandomString(), 'password', true]
			];
		}

		public function change_name_data(){
			return [
					"way-different" => [1, self::getAWord(), self::getAWord(),self::getAWord(), false],
					"less-than-semester" => [1, "tabar","nekatibeb","shiferaw", false],
					"correct-data" => [2, "Yehuala eshet", "Abebe", "Felek", true]
			];
		}

		public function change_section_year_data(){
			return [
						"section-less-than-semester" => [1, SET_SEC, 3, false],
						"section" => [2, SET_SEC, 3, true],
						"year" => [3, SET_YEAR, 3, true],
			];

		}

		public function number_of_comments_data(){
			return [
						[153, 1],
						[152, 1],
						[148, 1],
						[147, 1],
					];
		}

		public function number_of_votes_data(){
			return [
						
						[133, ["UP" => 2, "DOWN" => 0] ],
						[140, ["UP" => 2, "DOWN" => 0] ],
						//[144, ["UP" => 1, "DOWN" => 1] ],
					];	
		}

		/** 
		 * [petition_data description]
		 * @return [type] [description]
		 */
		public function petition_data(){
			
			return [

						"first" => [
										"title" => self::generateRandomString(), 
										"description" => self::generateRandomString(),
										"date" => '2016-06-23 09:11:53', 
										"sent" => 1, 
										"to" => self::generateRandomEmail(),
										"owner" => 1,
										"imageUrl" => '', 
										"audience" => '4c9184f37cff01bcdc32dc486ec36961', 
									]
			];

		}

		public function user_has_voted__data(){
			return [
						[133, 6, true],
						[140, 2, false],
						[144, 8, true]
			];

		}

		public function retrieve_petitions_data(){

			return [
						[0, 1],
						[0, 2],
						[1, 1]
			];
		}

		public function interest_tags_data(){
			
			return [
						[ 
							[1,3,5,7],
							[6,7,8,9]

						]
			];


		}

		public function comment_data(){
			
			
			$date = "2016-06-23 10:40:23";
			$message = "Test Commenet ";

			//control flow Testing [ Statement coverage criterion]
			return 	[
							//no petition
							["No petition" => ["petitionID" => 2, "message" => $message . " 1 ", "date" => $date, "seen" => 2, "commenter" => 1], false ],

							//empty message
							["Empty message" => ["petitionID" => 110, "message" => "", "date" => $date, "seen" => 1, "commenter" => 10], false],

							["All set" => ["petitionID" => 125, "message" => $message . " 2 ", "date" => $date, "seen" => 1, "commenter" => 1], true],
							
							
							
			];

		}



	}

?>