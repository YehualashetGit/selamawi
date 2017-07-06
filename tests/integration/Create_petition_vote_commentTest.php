<?php 
		
	require_once __DIR__ . "/../unit/selamawi/DataGenrator.php";

	$db = null;

	class Create_petition_vote_commentTest extends DataGenrator {

		private $studentID = 1;

		private $student;
		private $account;

		public function setUp(){

			global $db;
			
			$db = new DB();

			$this->account = new Account( $this->studentID );
			$this->student = $this->account->getStudent();
			
		}

		
		/** setup all variables required to create petition */
		public function setUpForCreatePetition(){

			return [
			
				"title" => substr(DataGenrator::generateRandomString( 1 ),0, 100),
				"description" => DataGenrator::generateRandomString( 2 ),
				"to" => DataGenrator::generateRandomEmail(),
				"audience" => "4c9184f37cff01bcdc32dc486ec36961",
				"tags" => [1,2,3],
			
			];


		}

		/** setup data for comment  */
		public function setUpComment(){
			return [
				"petitionID" => $this->petition->getPetID(),
				"message"	 => DataGenrator::generateRandomString(1),
				"date"		 => date('Y-m-d h:i:s'),

				//selects between seen and not seen
				"seen"		 => rand(1,2),
				"commenter"	 => $this->studentID
			];
		}

		/** setup data for vote  */
		public function setUpVote(){
			return [

					//seleect between vote up and down
					"type" => rand(1,2),

					"date" => date('Y-m-d h:i:s'), 
					"voter" => $this->studentID,
					"petitionID" => $this->petition->getPetID(), 
			];
		}

		/** create peition */
		public function createPetition(){
			
			$petitionData = $this->setUpForCreatePetition();

			$petition = $this->account
							 ->create_petition(
									$petitionData['title'], $petitionData['description'], 
									$petitionData['to'], $petitionData['tags'],
									$petitionData['audience']);


			//$return_data = $petition->create();

			$this->petition = $petition;

			return $petition;
		}

		
		/** add comment to a petition */
		public function addComment(){
			$this->comment = new Comment( $this->setUpComment() );

			$this->petition->addComment( $this->comment );

			return $this->comment;
		}

		/** cast vote on petition */
		public function castVote(){

			$this->vote = new Vote( $this->setUpVote());

			$this->petition->castVote( $this->vote );

			return $this->vote;
		}

		/** @test */
		public function perform_integration_test(){

			//test if student is able to create petition 
			$this->assertNotNull( $this->createPetition() );

			//check if the petition is created by the specified student
			$this->assertEquals( $this->petition->getOwnerObject()->getStudentID(), $this->studentID);

			//test if the student is able to comment on the created petition
			$this->assertNotNull( $this->addComment() );

			//check if the comment is for the specified petition
			$this->assertEquals( $this->comment->getPetition()->getPetID(),  $this->petition->getPetID());

			//check if hte comment is commented by the specified student
			$this->assertEquals( $this->comment->getCommenter()->getStudentID(), $this->studentID);

			//test if the student is able to vote on the created petition
			$this->assertNotNull( $this->castVote() );

			//check if the vote is casted for the specified petition
			$this->assertEquals( $this->vote->getPetition()->getPetID(), $this->petition->getPetID());
		}


	}

?>