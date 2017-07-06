<?php 

function meanigfy_data( $data ){

				$word_lens = [5, 4, 3, 6,7];
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

function randomWord(){
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

	function generateRandomString( $num_words = 1){

			

			$words = "";

			for( $i=0; $i < $num_words; $i++)
				$words .= randomWord();

			$words = meanigfy_data( $words );

			return  ucfirst( $words );

	}

	function generateRandomEmail(){

			
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

			$rand_word = randomWord();

			//select the first 5-10 words from generated random word
			$username = substr($rand_word, 0 , rand(5,10));

			return $username . "@" . $host;

		}

		
		
		
		echo md5("password");

		/**
		 	DELETE FROM `last_modf` WHERE studID=2 OR studID=3 OR studID=2;
			UPDATE student SET password='5f4dcc3b5aa765d61d8327deb882cf99' WHERE studID=1;
			UPDATE student SET section=2,lname="Feleke" WHERE studID=2;
			UPDATE student SET year=2 WHERE studID=3;
		

		 */
?>
