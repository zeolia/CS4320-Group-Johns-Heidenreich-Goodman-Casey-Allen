<?php
	class Model {

		public function getInventory($message){
			$devices = array();

			// Create Connection
			require('db_credentials.php');
			$mysqli = new mysqli($servername, $username, $password, $dbname);

			if($mysqli->connect_error){

				$message = $mysqli->connect_error;

			} else {

				// This string is the SQL statement to be executed

				$sql = "SELECT Devices.Brand, Devices.Model, Devices.Type, (SELECT Users.FirstName FROM Users WHERE Devices.Owner = Users.Id) as UserFirstName, (SELECT Users.LastName FROM Users WHERE Devices.Owner = Users.Id) as UserLastName, (SELECT Users.Pawprint FROM Users WHERE Devices.Owner = Users.Id) as UserPawprint, (SELECT Users.OfficeNumber FROM Users WHERE Devices.Owner = Users.Id) as UserOfficeNumber, (SELECT Users.OfficeLetter FROM Users WHERE Devices.Owner = Users.Id) as UserOfficeLetter, Devices.SerialNumber, Devices.DepartmentOwner, Devices.MoCodePurchasedBy, Devices.ID  FROM Devices";

				// Preforms the SQL query and checks to see if there was an error.
				if ($result = $mysqli->query($sql)) {
					if ($result->num_rows > 0) {
						// If no error, then turns the data into an associative array
						while($row = $result->fetch_assoc()) {
							array_push($devices, $row);
						}
					}
					$result->close();
				} else {
					// If there was an error from the SQL statement
					$message = $mysqli->error;
				}
				$mysqli->close();
			}
			return $devices;
		}
		
		/*public function getRelegatedInventory($message){
			$devices = array();

			// Create Connection
			require('db_credentials.php');
			$mysqli = new mysqli($servername, $username, $password, $dbname);

			if($mysqli->connect_error){

				$message = $mysqli->connect_error;

			} else {

				// This string is the SQL statement to be executed

				$sql = "SELECT RelegatedDevices.Brand, RelegatedDevices.Model, RelegatedDevices.Type, RelegatedDevices.Owner, RelegatedDevices.SerialNumber, RelegatedDevices.DepartmentOwner, RelegatedDevices.MoCodePurchasedBy, RelegatedDevices.ID, RelegatedDevices.DeleteDate FROM RelegatedDevices";

				// Preforms the SQL query and checks to see if there was an error.
				if ($result = $mysqli->query($sql)) {
					if ($result->num_rows > 0) {
						// If no error, then turns the data into an associative array
						while($row = $result->fetch_assoc()) {
							array_push($devices, $row);
						}
					}
					$result->close();
				} else {
					// If there was an error from the SQL statement
					$message = $mysqli->error;
				}
				$mysqli->close();
			}
			return $devices;
		}*/
		
		public function beginUpdateDevice(){
		 	$message = "";
		 	$device;

		 	$id = $_POST['ID'];

		 	if (!$id) {
		 		$message = "No device was specified to update.";
		 	} else {
		 		// Create connection
		 		require('db_credentials.php');
		 		$mysqli = new mysqli($servername, $username, $password, $dbname);
		 		// Check connection
		 		if ($mysqli->connect_error) {
		 			$message = $mysqli->connect_error;
		 		} else {
		 			$id = $mysqli->real_escape_string($id);

		 			$sql = "SELECT Devices.Brand, Devices.Model, Devices.Type, (SELECT Users.FirstName FROM Users WHERE Devices.Owner = Users.Id) as UserFirstName, (SELECT Users.LastName FROM Users WHERE Devices.Owner = Users.Id) as UserLastName, (SELECT Users.Pawprint FROM Users WHERE Devices.Owner = Users.Id) as UserPawprint, (SELECT Users.OfficeNumber FROM Users WHERE Devices.Owner = Users.Id) as UserOfficeNumber, (SELECT Users.OfficeLetter FROM Users WHERE Devices.Owner = Users.Id) as UserOfficeLetter, Devices.SerialNumber, Devices.DepartmentOwner, Devices.MoCodePurchasedBy, Devices.ID  FROM Devices WHERE Devices.ID = $id";

		 			if ( $result = $mysqli->query($sql) ) {
		 				$device = $result->fetch_assoc();
		 				$mysqli->close();
		 			} else {
		 				//$message = $mysqli->error;
		 				$mysqli->close();
		 			}
		 		}
		 	}
		 	return $device;
		}

		public function addDevice(){
			$message = "";

			$serialNumber = $_POST['SerialNumber'];
			$brand = $_POST['Brand'];
			$model = $_POST['Model'];
			$owner = $_POST['Owner'];
			$departmentOwner = $_POST['DepartmentOwner'];
			$moCode = $_POST['MoCodePurchasedBy'];
			$type = $_POST['Type'];

			require('db_credentials.php');
			$mysqli = new mysqli($servername, $username, $password, $dbname);

			// Check connection
			if ($mysqli->connect_error) {
				$message = $mysqli->connect_error;
			} else {
				$serialNumber = $mysqli->real_escape_string($serialNumber);
				$brand = $mysqli->real_escape_string($brand);
				$model = $mysqli->real_escape_string($model);
				$owner = $mysqli->real_escape_string($owner);
				$departmentOwner = $mysqli->real_escape_string($departmentOwner);
				$moCode = $mysqli->real_escape_string($moCode);
				$type = $mysqli->real_escape_string($type);

				$sql = "SELECT ID FROM Users WHERE Pawprint = '$owner'";

				if ($result = $mysqli->query($sql)) {
					$thing = $result->fetch_assoc();
					$holder = $thing['ID'];

					$sql = "INSERT INTO Devices (SerialNumber, Brand, Model, Owner, DepartmentOwner, MoCodePurchasedBy, Type) VALUES ('$serialNumber', '$brand', '$model', '$holder', '$departmentOwner', '$moCode', '$type')";
					if ($result = $mysqli->query($sql)) {
						$message = "Device was added";
						$mysqli->close();
					} else {
						$message = $mysqli->error;
						$mysqli->close();
					}
				} else {
					$sql = "INSERT INTO Devices (SerialNumber, Brand, Model, Owner, DepartmentOwner, MoCodePurchasedBy, Type) VALUES ('$serialNumber', '$brand', '$model', '', '$departmentOwner', '$moCode', '$type')";
					if ($result = $mysqli->query($sql)) {
						$message = "Device was added";
						$mysqli->close();
					} else {
						$message = $mysqli->error;
						$mysqli->close();
					}
				}		
			}
			return $message;
		}
		
		public function deleteDevice($device){
//	 	$id = $_POST['ID'];

	 	$message = "";
		
		$brand = $device['Brand'];
		$model = $device['Model'];
		$type = $device['Type'];
		$pawprint = $device['Owner'];
		$serialNumber = $device['SerialNumber'];
		$id = $device['ID'];
		$departmentOwner = $device['DepartmentOwner'];
		$mocode = $device['MoCodePurchasedBy'];

	 	if(!$device){
	 		$message = "No device was found to delete";
	 	} else {
	 		require('db_credentials.php');
	 		$mysqli = new mysqli($servername, $username, $password, $dbname);
	 		if ($mysqli->connect_error) {
	 			$message = $mysqli->connect_error;
	 		} else {
				
				$sql = "SELECT ID FROM Users WHERE Pawprint = '$owner'";
				if ($result = $mysqli->query($sql)) {
					$thing = $result->fetch_assoc();
					$pawprint = $thing['ID'];
				} else $pawprint = "";					
				
				$sql = "INSERT INTO RelegatedDevices (SerialNumber, Brand, Model, Owner, DepartmentOwner, MoCodePurchasedBy, Type, DeleteDate) VALUES ('$serialNumber', '$brand', '$model', '$pawprint', '$departmentOwner', '$mocode', '$type', NOW())";

				if ($result = $mysqli->query($sql)) {
					$message = "Device was added";
				} else {
					$message = $mysqli->error;
					$mysqli->close();
					return $message;
				}
				
	 			$id = $mysqli->real_escape_string($id);
	 			$sql = "DELETE FROM Devices WHERE ID = $id";
	 			if ( $result = $mysqli->query($sql) ) {
	 				$message = "Device was deleted.";
	 			} else {
	 				$message = $mysqli->error;
	 			}
	 			$mysqli->close();
	 		}	
	 	}
	 	return $message;
	}
	 
		public function updateDevice(){
		$message = "";

		$id = $_POST['ID'];
		$serialNumber = $_POST['SerialNumber'];
		$brand = $_POST['Brand'];
		$model = $_POST['Model'];
		$owner = $_POST['User'];
		$departmentOwner = $_POST['DepartmentOwner'];
		$moCode = $_POST['MoCodePurchasedBy'];
		$type = $_POST['Type'];

		require('db_credentials.php');
		$mysqli = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if ($mysqli->connect_error) {
			$message = $mysqli->connect_error;
		} else {
			$serialNumber = $mysqli->real_escape_string($serialNumber);
			$brand = $mysqli->real_escape_string($brand);
			$model = $mysqli->real_escape_string($model);
			$owner = $mysqli->real_escape_string($owner);
			$departmentOwner = $mysqli->real_escape_string($departmentOwner);
			$moCode = $mysqli->real_escape_string($moCode);
			$type = $mysqli->real_escape_string($type);

			$sql = "SELECT ID FROM Users WHERE Pawprint = '$owner'";

			if ($result = $mysqli->query($sql)) {
				$thing = $result->fetch_assoc();
				$holder = $thing['ID'];

				$sql = "UPDATE Devices SET SerialNumber = '$serialNumber', Brand = '$brand', Model = '$model', Owner = '$holder', DepartmentOwner = '$departmentOwner', MoCodePurchasedBy = '$moCode', Type = '$type' WHERE Devices.ID = '$id'";

				if ($result = $mysqli->query($sql)) {
					$mysqli->close();
					return("Device was updated");
				} else {
					$mysqli->close();
					return($mysqli->error);
				}

			} else {
				$sql = "UPDATE Devices SET SerialNumber = '$serialNumber', Brand = '$brand', Model = '$model', Owner = '', DepartmentOwner = '$department', MoCodePurchasedBy = '$mocode', Type = '$type' WHERE Devices.ID = '$id'";
				if ($result = $mysqli->query($sql)) {
					$mysqli->close();
					return("Device was updated");
				} else {
					$mysqli->close();
					return($mysqli->error);
				}
			}
		}
	}

		public function searchDevices(){
			$searchString = $_POST['searchString'];

			if(!$searchString){
				//getInventory("No devices specified to search for");
				return -1;
			}

			$stylesheet = 'inventory.css';

			$devices = array();

			// Create Connection
			require('db_credentials.php');
			$mysqli = new mysqli($servername, $username, $password, $dbname);

			if($mysqli->connect_error){

				$message = $mysqli->connect_error;

			} else {

				// This string is the SQL statement to be executed
				$sql = "SELECT Devices.Brand, Devices.Model, Devices.Type, (SELECT Users.FirstName FROM Users WHERE Devices.Owner = Users.Id) as UserFirstName, (SELECT Users.LastName FROM Users WHERE Devices.Owner = Users.Id) as UserLastName, (SELECT Users.Pawprint FROM Users WHERE Devices.Owner = Users.Id) as UserPawprint, (SELECT Users.OfficeNumber FROM Users WHERE Devices.Owner = Users.Id) as UserOfficeNumber, (SELECT Users.OfficeLetter FROM Users WHERE Devices.Owner = Users.Id) as UserOfficeLetter, Devices.SerialNumber, Devices.DepartmentOwner, Devices.MoCodePurchasedBy, Devices.ID  FROM Devices WHERE Devices.Brand LIKE '%$searchString%' || Devices.Model LIKE '%$searchString%' || Devices.Type LIKE '%$searchString%' || (SELECT Users.FirstName FROM Users WHERE Devices.Owner = Users.Id) LIKE '%$searchString%' || (SELECT Users.LastName FROM Users WHERE Devices.Owner = Users.Id) LIKE '%$searchString%' || (SELECT Users.Pawprint FROM Users WHERE Devices.Owner = Users.Id) LIKE '%$searchString%' || (SELECT Users.OfficeNumber FROM Users WHERE Devices.Owner = Users.Id) LIKE '%$searchString%' || (SELECT Users.OfficeLetter FROM Users WHERE Devices.Owner = Users.Id) LIKE '%$searchString%' || Devices.SerialNumber LIKE '%$searchString%' || Devices.DepartmentOwner LIKE '%$searchString%' || Devices.MoCodePurchasedBy LIKE '%$searchString%'";

				// Preforms the SQL query and checks to see if there was an error.
				if ($result = $mysqli->query($sql)) {
					if ($result->num_rows > 0) {
						// If no error, then turns the data into an associative array
						while($row = $result->fetch_assoc()) {
							array_push($devices, $row);
						}
					}
					$result->close();
				} else {
					// If there was an error from the SQL statement
					$message = $mysqli->error;
				}
				$mysqli->close();
			}			
			return $devices;

			//print generatePageHTML("Devices", generateInventoryHTML($devices, $message), $stylesheet);
		}
	
		public function addUser(){
		$firstName = $_POST['FirstName'];
		$lastName = $_POST['LastName'];
		$pawprint = $_POST['Pawprint'];
		$number = $_POST['Number'];
		$letter = $_POST['Letter'];
		
		// Create connection
		require('db_credentials.php');
		$mysqli = new mysqli($servername, $username, $password, $dbname);
		if ($mysqli->connect_error) {
				$message = $mysqli->connect_error;
				//print("here2");
		} else {
				$firstName = $mysqli->real_escape_string($firstName);
				$lastName = $mysqli->real_escape_string($lastName);
				$pawprint = $mysqli->real_escape_string($pawprint);
				$number = $mysqli->real_escape_string($number);
				$letter = $mysqli->real_escape_string($letter);
				$sql = "INSERT INTO Users (FirstName, LastName, Pawprint, OfficeNumber, OfficeLetter) VALUES ('$firstName', '$lastName', '$pawprint', '$number', '$letter')";
				if ( $result = $mysqli->query($sql) ) {
					$message = "User added";
				} else {
					$message = $mysqli->error;
				}
				$mysqli->close();
			}
		return $message;
		}
	} 

?>