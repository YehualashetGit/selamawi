<?php 
	
	require_once "DataGenrator.php";

	$db = null;

	class StudentTest extends DataGenrator{

		
		private $student;

		//test student data
		private $studentID = 1;
		private $first_name = "tabor";
		private $middle_name = "nekatibeb";
		private $last_name = "shiferaw";
		private $year = 1;
		private $department = 1;
		private $section = 1;
		private $semester = 2;

		public function setUp(){
			global $db;
			
			$db = new DB();
			
			
			$this->student = new Student( $this->studentID );


		}

		/** 
		 * @test
		 * @dataProvider initializer_data
		 * checks if student object can be initialized properly for valid studetn ID
		 */
		public function can_initialize_properly( $stud_info ){
			$student = new Student( $stud_info );
		}


		/** 
		 * @test
		 * asserts if getFName method of student class returns valid first name
		 */
		public function can_get_the_first_name( ){
			
			$this->assertEquals( $this->student->getFName(), $this->first_name );
		}

		/** 
		 * @test
		 * asserts if getmName method of student class returns valid middle name
		 */
		public function can_get_the_middle_name( ){
			$this->assertEquals( $this->student->getMName(), $this->middle_name );
		}


		/** 
		 * @test
		 * asserts if getLName method of student class returns valid last name
		 */
		public function can_get_the_last_name( ){
			$this->assertEquals( $this->student->getLName(), $this->last_name );
		}

		/** 
		 * @test
		 */
		public function can_get_full_name(){
			

			$this->assertEquals($this->student->getFullName(), ucwords( $this->first_name . " ". $this->middle_name . " ". $this->last_name ));
		}

		/** 
		 * @test
		 */
		public function can_get_department( ){
			$this->assertEquals( $this->student->getDepartment(), $this->department );
		}


		/** 
		 * @test
		 */
		public function can_get_studentID( ){
			$this->assertEquals( $this->student->getstudentID(), $this->studentID );
		}

		/** 
		 * @test
		 */
		public function can_get_year( ){
			$this->assertEquals( $this->student->getYear(), $this->year );
		}

		/** 
		 * @test
		 */
		public function can_get_semester( ){
			$this->assertEquals( $this->student->getSemester(), $this->semester );
		}

		/** 
		 * @test
		 */
		public function can_get_section( ){
			$this->assertEquals( $this->student->getSection(), $this->section );
		}

		/** 
		 * @test
		 */
		public function can_get_exist( ){
			$this->assertTrue( $this->student->exist() );
		}

		/** 
		 * @test
		 */
		public function can_get_is_blocked( ){
			$this->assertFalse( $this->student->blocked() );
		}

		/** 
		 * @test 
		 * asserts if confirmation token for registred student is set properly
		*/
		public function can_store_conf_msg(){
			
			$token = self::generateRandomString();

			$this->assertTrue( $this->student->storeConfMsg( $this->studentID, $token ) );
		}

		/** 
		 * @test
		 * @dataProvider register_student_data
		 */
		public function can_register_student($email, $password, $result){

			$student_data = [
											"fname" => "Test",
											"mname" => "Data",
											"lname" => "Student",
											"ID" => "TEST/001",
											"email" => "",
											"department" => 1,
											"year" => 1,
											"semester" => 1
							];

			$student = new Student($student_data);
			$registred = $student->register($email, $password);

			if( !$result and is_int( $registred ) )
					$this->assertEquals( $registred, $registred );

			else
				$this->assertEquals( $registred, $result );
			

		}

		

		/** @test */
		public function can_retrieve_student_petition(){

			$sec = "s-" . $this->student->getSection();
			$year = "y-" . $this->student->getYear();
			$dept = "d-" . $this->student->getDepartment();
			$all = AUD_PUB;

			$class = md5($dept . "-" . $sec . "-" . $year);
			$year  = md5($year);
			$dept = md5($dept);

			$audc = array(
							'class' => $class,
							'year'  => $year,
							'dept'  => $dept,
							'all'   => AUD_PUB
						);

			$num = 0;

			$petitions = $this->student->myPetitions($num, $audc);
			
			$this->assertContainsOnlyInstancesOf(Petition::class, $petitions);

			foreach( $petitions as $petition ){
				$this->assertContains($petition->getAudience(), $audc);
				$this->assertEquals( $petition->getOwner(), $this->studentID);
			}

		}

	
		
		/** @test */
		public function can_retrieve_student_activity(){
			$recent_activities = $this->student->recentActivities();

			$this->assertContainsOnlyInstancesOf(Activity::class, $recent_activities);

			foreach( $recent_activities as $recent_activity ){
				
				$petition = new Petition( (int)$recent_activity->getOnID() ) ;
				
				$this->assertNotNull( $petition );
			}

		}

		/** 
		 * @test 
		 * @dataProvider search_petition_data
		 * asserts if the result of searching petition contains petitions which have the specified
		 * keyword in their title
		*/
		public function can_search_petition($keyword, $result){

			$sec = "s-" . $this->student->getSection();
			$year = "y-" . $this->student->getYear();
			$dept = "d-" . $this->student->getDepartment();
			$all = AUD_PUB;

			$class = md5($dept . "-" . $sec . "-" . $year);
			$year  = md5($year);
			$dept = md5($dept);

			$audc = array(
							'class' => $class,
							'year'  => $year,
							'dept'  => $dept,
							'all'   => AUD_PUB
						);

			$petitions = $this->student->searchPetition($keyword, $audc);

			if( $result )
				$this->assertGreaterThan(0, count( $petitions ));
			else
				$this->assertEquals( count( $petitions ), 0);

			foreach ($petitions as $petition) {
				$this->assertContains( $petition->getAudience(), $audc );
				$this->assertContains( strtolower($keyword), strtolower($petition->getTitle()));
			}


		}

		/**
		 *  @test
		 *  @dataProvider password_data
		 */
		public function can_change_password($newPassword, $oldPassword, $result){
		
			$changed = $this->student->changePassOld($newPassword, $oldPassword);
			$this->assertEquals( $changed, $result );
		}



		/** 
		 * @test 
		 * @dataProvider change_name_data
		 * asserts if student name can be changed
		*/
		public function can_change_name($studentID, $fname, $mname, $lname, $result){
			
			$student = new Student($studentID);

			$changed = $student->changeName($fname, $mname, $lname);
			
			if(!$result and is_int( $changed) )
				$this->assertEquals( $changed, $changed);
			else
				$this->assertEquals( $changed, $result);

			$student = new Student( $studentID);
			
			$full_name = strtolower( $student->getFullName() );
			$my_full_name = strtolower($fname. " " . $mname . " " . $lname);
			
			if( $result )
				$this->assertEquals( $full_name, $my_full_name );
			else
				$this->assertNotEquals( $full_name, $my_full_name);
		}

		/** 
		 * @test
		 * @dataProvider change_section_year_data
		 */
		public function can_change_information($studentID, $type, $data, $result){	
			$student = new Student($studentID);

			$changed = $student->change($type, $data);

			if( !$result and is_int($changed))
				$this->assertEquals( $changed, $changed);
			else
				$this->assertEquals( $changed , $result);
		}

	}

?>