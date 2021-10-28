<?php

use \Core\Storage;

namespace App\Entities {
     
	class Occupation extends \Core\Storage\DatabaseObject {
		
		public function __construct() {
			
			parent::__construct();
			
			$this->table = 'occupation';
		}
	} 
}