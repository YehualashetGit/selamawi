<?php 
	
	$db = null;

	require_once "DataGenrator.php";

	class AccountTest extends DataGenrator{

		private $userID;
		private $account;

		public function setUp(){
			global $db;
			
			$db = new DB();

			$this->userID = 1;
			
			$this->account = new Account( $this->userID );
			
		}

		/**
		 * @test
		 */
		public function can_retrieve_user_info(){
			
			$this->assertNotNull( $this->account->getStudent() );
			
		}
		

		/**
		 * @test
		 * @dataProvider retrieve_petitions_data
		 * @param int num [ page number ]
		 * @param int $pet_type [ Resolved/Unresolved ]
		 */
		public function can_retrieve_all_petitions($num, $pet_type){
			
			
			$petitions = $this->account->listAllPetitions($num, $pet_type);

			//number of returned petitions is less or equal to the number of petitions requested
			//asserts if the returned number of petition is less than or equal to allowed petition number per page
			$this->assertLessThanOrEqual( PETPERP, count($petitions));


			foreach ($petitions as $petition) {
				
				//check each petition is instance of Petition
				$this->assertInstanceOf(Petition::class, $petition);

				//check the returned petitions are the e*act type
				$this->assertEquals($petition->isSent(), $pet_type);
			}

		

			
		}

		/**
		 * @test
		 * 
		*/
		public function can_retrieve_popular_petitions_or_besnayt_algorithm(){
			
			$popular_petitions = $this->account->popularPetitions();

			//only Petition::TOP number of popular petitions are allowed listed
			$this->assertLessThanOrEqual( Account::TOP, count($popular_petitions));

			$prev_score = -1;

			//check if the petitions are in the right order
			foreach ($popular_petitions as $petition) {
				
				$num_votes = $petition->getNumVotes();

				$cur_score = ($petition->getNumComments_() *  FACT_COM)  + ($petition->getNumUpVote_() * FACT_UP)  -( $petition->getNumDownVote_() * FACT_DOWN) ;
				
				if( $prev_score == -1){
				
					$prev_score = $cur_score;
					continue;
				
				}

				$this->assertLessThanOrEqual($prev_score, $cur_score);
				
				$prev_score = $cur_score;

			}


		}

		/**
		 * @test
		 * @dataProvider interest_tags_data
		 */
		public function myInterest( $interest_tags){
			

			$interest_petitions = $this->account->myInterest( $interest_tags );

			foreach( $interest_petitions as $petition){
				
				$tag_ids = array();

				foreach( $petition->getTags() as $tag )
					$tag_ids[] = $tag->getID();

				$intersection = array_intersect($tag_ids, $interest_tags);

				$this->assertGreaterThan(0, count($intersection));

			}


		}

		



	}