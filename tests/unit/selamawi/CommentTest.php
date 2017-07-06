<?php 
	
	$db = null;

	require_once 'DataGenrator.php';
	
	class CommentTest extends DataGenrator{

		private $commentID;
		private $comment;

		private $commentMes;
		private $commentCommentorID;
		private $commentPetitionID;
		private $commentDate;

		public function setUp(){
			global $db;
			
			$db = new DB();

			$this->commentID = 49;

			$query = "SELECT * FROM " . TABLE_COM . " WHERE commentID = " . $this->commentID . " LIMIT 1";
			$db->prp_stmt($query);
			$result = $db->get_resultset();

			$comment = $result[0];
			
			$this->comment = new Comment(  $comment );

			$this->commentMes = "I am barsenet";
			$this->commentCommentorID = 2;
			$this->commentPetitionID = 133;
			$this->commentDate = "2017-07-03 12:04:20";
			
		}

		/** @test */
		public function message_set_correctly(){
			$this->assertEquals( $this->commentMes, $this->comment->getMessage() );
		}

		/** @test */
		public function date_set_correctly(){
			$this->assertEquals( $this->commentDate, $this->comment->getDate() );
		}

		/** @test */
		public function commenter_set_correctly(){
			$commentor =  $this->comment->getCommenter();
			$this->assertInstanceOf(Student::class, $commentor );
			$this->assertEquals($commentor->getstudentID(), $this->commentCommentorID );
		}

		/** @test */
		public function petition_set_correctly(){
			$petition = $this->comment->getPetition();
			
			
			$this->assertInstanceOf(Petition::class, $petition);
			$this->assertEquals($petition->getPetID(), $this->commentPetitionID);
		}

		/** 
		 * @test 
		 * @dataProvider comment_data
		*/
		public function comment_create_for_petition( $comment, $result ){

			$comment = (new Comment($comment))->create();

			if($result)
				$this->assertTrue( $comment );
			else{
				if( $comment === false)
					$this->assertFalse( $comment );
				else
					$this->assertNull( $comment );
			}


		}

		

	}