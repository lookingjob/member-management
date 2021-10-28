<?php

namespace App\Handling {

	class Dispatcher {

		private $path;
		private $query;
		private $target;
		private $action;

		public function __construct() {

			$request = new \Core\Http\Request();
			
			$this->entity = $request->post('entity');
			$this->action = $request->post('action');
		}
		
		public function execute() {
			
			try {
				$classname = sprintf('\App\Controllers\%sController', ucfirst($this->entity));  
				$controller = new $classname;  
				if (method_exists($controller, $this->action)) {
					$controller->{$this->action}($this->query);	
				} else {
					throw new \Exception('Method not allowed');
				}
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}

}

?>