<?php

namespace App\Entities {

	class Member extends \Core\Storage\DatabaseObject {
		
		public function __construct() {
			
			parent::__construct();
			
			$this->table = 'member';
		}     
	} 
}

?>