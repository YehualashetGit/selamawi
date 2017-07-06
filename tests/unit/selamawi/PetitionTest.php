<?php 
	require_once "DataGenrator.php";

	$db = null;

	class PetitionTest extends DataGenrator {

		private $petitionID = 148;

		private $petition;

		public function setUp(){
			global $db;
			
			$db = new DB();
			
			$this->petition = new Petition( $this->petitionID );
		}

		/** 
		 * @test
		 * @dataProvider number_of_comments_data
		 * checks if the getNumComments method returns valid number of comments for a petiion 
		 */
		public function can_get_number_of_comments($petID, $number){
			$petition = new Petition($petID);
			$this->assertEquals($petition->getNumComments(), $number);
		}

		/** 
		 * @test
		 */
		public function can_get_all_comments(){
			$comments = $this->petition->getComments();
			$this->assertCount( $this->petition->getNumComments(),  $comments);

			$this->assertContainsOnlyInstancesOf(Comment::class, $comments);
		}
		
		/**
		 * @test
		 */
		public function can_get_all_votes(){

			$votes = $this->petition->getVotes();
			$vote_count = $this->petition->getNumVotes();
			$vote_count = $vote_count['UP'] + $vote_count['DOWN'];

			$this->assertCount( $vote_count, $votes );

			$this->assertContainsOnlyInstancesOf( Vote::class, $votes);
		}

		/** 
		 * @test 
		 * @dataProvider number_of_votes_data
		 * checks if the getNumVotes method returns valid number of up and down votes for a petition 
		 * 
		*/
		public function can_get_number_of_votes($petID, $number){
			$petition = new Petition($petID);

			$num_votes = $petition->getNumVotes();

			foreach( $num_votes as $key=>$num_vote){

				$num_votes[ $key ] = (int)$num_vote;
			}

			$this->assertEquals($num_votes, $number);
		}

		/** 
		 * @test 
		 * @dataProvider petition_data
		 * tests if pettion can be created using the specified data
		*/
		public function can_create_petition( $petition_data){
			$petition = new Petition( $petition_data );
			$this->assertTrue( $petition->create() );
		}

		/** 
		 * @test 
		 * @dataProvider user_has_voted__data
		*/
		public function can_check_user_has_voted($petID, $studID, $voted){
			
			$petition = new Petition($petID);

			$has_voted = $petition->hasVoted( $studID );

			if ( $voted )
				$this->assertNotEquals( $has_voted , VOTE_NONE);
			else
				$this->assertEquals( $has_voted , VOTE_NONE);

		}

		
	}

?>