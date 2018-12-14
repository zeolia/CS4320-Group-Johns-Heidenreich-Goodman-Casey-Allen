<?php
// ini_set('display_errors', 'On');
	require ('Model.php');
	require ('View.php');
	//require ('inventory.css');

	class Controller {
		private $model;
		private $view;

		private $page = '';
		private $action = '';
		private $message = '';
		// private returnMessage = '';

		// private varibales

		public function __construct() {
			$this->model = new Model();
			$this->view = new View();

			$this->page = $_GET['view']; // error check to see if a result was returned
			$this->action = $_POST['action'];
		}

		public function __destruct() {
			$this->model = null;
			$this->view = null;
		}

		public function run() {

			switch ($this->action) {
				
				case 'presentAddDevice':
				 	$this->view->presentAddDevice();
				 	break;

				case 'addDevice':
					$message = $this->model->addDevice();
					$this->inventory($message);
					break;

				case 'deleteDevice':
					$device = $this->model->beginUpdateDevice();
				 	$message = $this->model->deleteDevice($device);
				 	$this->inventory($message);
				 	break;
		
				case 'beginUpdateDevice':
					$device = $this->model->beginUpdateDevice();
					$this->view->presentUpdateDevice($device);
					
					break;
					
				case 'updateDevice':
					$message = $this->model->updateDevice();
					$this->inventory($message);
					break;
					
//				case 'viewRelegatedDevices':
//					$devices = $this->model->relegatedInventory();
//					break;
					
				case 'searchDevices':
					$devices = $this->model->searchDevices();
					if($devices == -1) {
						$this->inventory("No devices specified to search for");
					}
					else if($devices) $this->view->presentInventory($devices, "");
					else {
						$this->inventory("No device was found matching that search.");
					}
					break;
					
				case 'presentAddUser':
					$this->view->presentAddUser();
					break;
					
				case 'addUser':
					//print("helo");
					$message = $this->model->addUser();
					$this->inventory($message);
					break;
						
				// 		//$message = $this->view->presentUpdateDevice($device);
				// 		break;

				default: 
					$this->inventory($message);
						//view - get all items;
						break;
			}

			// switch ($this->page) {
			// 	// case default: login page
			// 	default:  // works to here
			// 		$this->inventory($message);
			// 		//view - get all items;
			// 		break;
			//}
		}

		private function inventory($message) {
			$devices = $this->model->getInventory($message);
			$this->view->presentInventory($devices, $message);
			// if($devices) ? $this->view->presentInventory($devices, $message) : print('error');
		}
		
//		private function relegatedInventory($message) {
//			$devices = $this->model->getRelegatedInventory($message);
//			$this->view->presentInventory($devices, $message);
			// if($devices) ? $this->view->presentInventory($devices, $message) : print('error');
//		}
	}
	


?>