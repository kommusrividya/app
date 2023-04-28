<?php
// include database connection file
session_start();

$APPDIR = dirname(dirname(__FILE__));

require_once "$APPDIR/constant.php";
require_once "$APPDIR/ssdbconfig.php";

if (isset($_POST['query'])) {
	$search = mysqli_real_escape_string($link_test, $_POST['query']);
	$sql = "SELECT * 
		FROM BSPD_Member
		WHERE 
		Alias LIKE '%$search%'

		LIMIT 10;";
	/**/

	$query = mysqli_query($link, $sql);
	if (mysqli_num_rows($query) > 0) {
		$i = 0;
		while ($row = mysqli_fetch_assoc($query)) {
			$output[$i] = (object) array(
				'memid' => $row['MEMBER_ID'],
				'memsurname' => $row['Surname'],
				'memname' => $row['Name']
			);
			$i++;
		}
		echo json_encode($output);
	} else {
		echo json_encode("No records found");
	}
}

if (isset($_POST['bring_batches'])) {
	$search = mysqli_real_escape_string($link, $_POST['event_id']);
	$sql = "SELECT id, batch_name FROM BSPD_TNG_Event_Batch where event_id = $search;";
	$query = mysqli_query($link, $sql);
	if (mysqli_num_rows($query) > 0) {
		$i = 0;
		while ($row = mysqli_fetch_assoc($query)) {
			$output[$i] = (object) array(
				'id' => $row['id'],
				'batch_name' => $row['batch_name']
			);
			$i++;
		}
		echo json_encode($output);
	} else {
		echo json_encode("No records found");
	}
}

if (isset($_POST['bring_event_details'])) {
	$search = mysqli_real_escape_string($link, $_POST['event_id']);
	$sql = "SELECT * FROM BSPD_Event where EVENT_ID = '$search';";
	$query = mysqli_query($link, $sql);
	if (mysqli_num_rows($query) > 0) {
		$i = 0;
		while ($row = mysqli_fetch_assoc($query)) {
			$output[$i] = (object) array(
				'event_date' => $row['Event_date'],
				'event_status' => $row['Event_status'],
				'event_description' => $row['Event_Description'],
				'event_location' => $row['Event_Location'],
				'event_notes' => $row['Event_Notes']
			);
			$i++;
		}
		echo json_encode($output);
	} else {
		echo json_encode("No records found");
	}
}

if (isset($_POST['event_registration_form'])) {
	$event_id = $_POST['event_id'];
	$member_id = $_POST['member_id'];
	$reg = $_POST['reg'];

	$sql = "SELECT * FROM BSPD_Member where MEMBER_ID = $member_id;";
	$query = mysqli_query($link, $sql);
	if (!(mysqli_num_rows($query) > 0)) {
		echo "Member does not exist";
		return;
	}

	$sql = "SELECT * FROM BSPD_Event_Registration where EVENT_ID = '$event_id' and MEMBER_ID = $member_id;";
	$query = mysqli_query($link, $sql);
	if (mysqli_num_rows($query) > 0) {
		$sql1 = "UPDATE BSPD_Event_Registration SET `Registered` = '$reg', `UpdatedBy` = '".$_SESSION['id']."' WHERE (`MEMBER_ID` = '$member_id') and (`EVENT_ID` = '$event_id');";
		$query1 = mysqli_query($link, $sql1);
		if ($query1) echo "MEMBER HAS ALREADY REGISTERED FOR THIS EVENT.\nRegistration updated successfully.";
		else echo "Registration failed" . mysqli_error($link);
		return;
	}

	$sql = "INSERT INTO BSPD_Event_Registration (`MEMBER_ID`, `EVENT_ID`, `Registered`, `Attended`, `CreatedBy`, `UpdatedBy`) VALUES ('$member_id', '$event_id', '$reg', ' ', '".$_SESSION['id']."', '".$_SESSION['id']."');";
	$query = mysqli_query($link, $sql);

	if ($query) echo "Registration successful";
	else echo "Registration failed" . mysqli_error($link);
}
//start creation
if (isset($_POST["event_form"])) {
	$event_id =  $_POST["event_id"];
	$event_date = $_POST["event_date"];
	$event_status =  $_POST["event_status"];
	$event_location = $_POST["event_location"];
	$event_description =  $_POST["event_description"];
	$event_notes = $_POST["event_notes"];
	$form_mode = $_POST["form_mode"];

	if ($form_mode == "create") {
		$sql = "select * from BSPD_Event where EVENT_ID = '$event_id';";
		$result = mysqli_query($link, $sql);
		if (mysqli_num_rows($result) > 0) {
			echo "Event ID already exists";
			return;
		}

		$message = "";
		$sql = "INSERT INTO BSPD_Event 
		(`EVENT_ID`, `Event_date`, `Event_Description`, `Event_Location`,`Event_Notes`, `Event_status`) 
		VALUES ('$event_id', '$event_date', '$event_description', '$event_location', '$event_notes', '$event_status');";
		if (mysqli_query($link, $sql))
			$message .= "Event created successfully!";
		else
			$message .= mysqli_error($link);

		echo $message;
	} else if ($form_mode == "update") {
		$message = "";
		$sql = "UPDATE BSPD_Event SET 
		`Event_date` = '$event_date', 
		`Event_Description` = '$event_description', 
		`Event_Location` = '$event_location', 
		`Event_Notes` = '$event_notes', 
		`Event_status` = '$event_status' WHERE (`EVENT_ID` = '$event_id');";
		if (mysqli_query($link, $sql))
			$message .= "Event updated successfully!";
		else
			$message .= mysqli_error($link);

		echo $message;
	}
}
//end creation

if (isset($_POST["event_updation_form"])) {
	$event_id =  $_POST["event_id"];
	$event_description = $_POST["event_description"];
	$event_date =  $_POST["event_date"];
	$event_active =  $_POST["event_active"];
	$event_mc =  $_POST["event_mc"];

	$sql = "UPDATE BSPD_TNG_Event SET 
	`event_description` = '$event_description', `event_mc_id` = '$event_mc', `event_active` = '$event_active', `event_date` = '$event_date' WHERE (`id` = '$event_id');";
	$message = "";
	if (mysqli_query($link, $sql))
		$message .= "Event updated successfully";
	else
		$message .= mysqli_error($link);

	for ($i = 1; $i <= 5; $i++) {
		if (!isset($_POST['batchname' . $i])) continue;
		if (!isset($_POST['batchtime' . $i])) continue;

		$batchname = $_POST['batchname' . $i];
		$batchtime = $_POST['batchtime' . $i];

		$sql = "INSERT INTO BSPD_TNG_Event_Batch (`event_id`, `batch_name`, `batch_mc`, `batch_time`) VALUES ('$event_id', '$batchname', '$event_mc','$batchtime');";
		if (mysqli_query($link, $sql));
		//$message.= "Event $batchname successfully added";
		else
			$message .= mysqli_error($link);
	}
	echo $message;
}

//start member creation
if (isset($_POST["member_creation_form"])) {
	$last_name =  $_POST["last_name"];
	$first_name = $_POST["first_name"];
	$phone_num = $_POST["phone_num"];
	$email_id =  $_POST["email_id"];
	$yob =  $_POST["yob"];
	$gender =  $_POST["gender"];
	$gotram = $_POST["gotram"];
	$location = $_POST["location"];
	$referrer_id = $_POST["referrer_id"];
	$blood_group = $_POST["blood_group"];
	$notes = $_POST["notes"];
	$createdby = $_SESSION["id"];

	$message = "";

	$sql = "SELECT * FROM BSPD_Member where MEMBER_ID = $referrer_id;";
	$query = mysqli_query($link, $sql);
	$referrer_name = "";
	$referrer_email = "";
	$referrer_ph = "";
	if (mysqli_num_rows($query) > 0) {
		$row = mysqli_fetch_array($query);
		$referrer_name = $row["Alias"];
		$referrer_email = $row["Email_ID"];
		$referrer_ph = $row["Phone_Num"];
	} else {
		echo "Referrer ID does not exist";
		return;
	}

	$sql = "INSERT INTO BSPD_Member 
	(`Surname`, `Name`, `Gender`, `Year_Of_Birth`, `Gotram_ID`, `Gotram`, `Email_ID`, `Phone_Num`, 
	`Referrer_ID`, `DOJ`, `Location`, `BloodGroup`, `Created_By`, `Password`, `Notes`) 
	VALUES ('$last_name', '$first_name', '$gender', '$yob', '$gotram', '$gotram', '$email_id', '$phone_num', 
	'$referrer_id', '" . date("Y-m-d") . "', '$location', '$blood_group', $createdby, md5('$phone_num'), '$notes');";

	if (mysqli_query($link, $sql)) {
		$last_id = mysqli_insert_id($link);
		$message .= "Member created successfully for $last_name $first_name";
		$message .= "\r\n Member ID : $last_id";
		if ($email_id != "nobody@bspd.in") {
			$to = $email_id;
			$header = 'Your Brahmana Sabha (Pancha Dravida) Membership number: ' . $last_id;
			$From = 'From: bspd.hyd@gmail.com';
			$Message = "Namaste " . $last_name . " " . $first_name . " Garu,\r\n";
			$Message .= "BSPD Member Id : MA" . str_pad($last_id, 8, "0", STR_PAD_LEFT) . "\r\n";
			$Message .= "\r\n";
			$Message .= "Your contact details as per our records:\r\n";
			$Message .= "Ph: " . $phone_num . " Email: " . $email_id . "\r\n";
			$Message .= "\r\n";
			$Message .= "You have been referred to BSPD by " . $referrer_name . " Ph: " . $referrer_ph . " Email: " . $referrer_email . "\r\n";
			$Message .= "\r\n";
			$Message .= "Brahmana Sabha ( Pancha Dravida ) in short BSPD started in 2012 to serve Brahmanas from Pancha Dravida regions. According to ancient classification the regions speaking (1)Telugu (2)Tamil / Malayalam (3) Kannada (4)Gujarati (5)Marathi are the Pancha Dravida regions.\r\n"; //About BSPD
			$Message .= "\r\n";
			$Message .= "BSPD consists of Brahmanas in worldly professions like Engineers,Doctors,Finance,CAs and also of Brahmanas in Vaidika profession working for welfare. Primarily working on timely marriages and restoration of basic traditions. BSPD is created at the instruction of Jagadguru Sankaracharya of Sri Kanchi Kamakoti Peetham and works under his guidance.\r\n";
			$Message .= "\r\n";
			$Message .= "BSPD works on self service model. To maintain your details please log in to\r\n";
			$Message .= "www.bspd.in\r\n";
			$Message .= "Enter SCREEN-PASSWORD ( check with your referrer )\r\n";
			$Message .= "Select Member Activities Tab and SelfService option.\r\n";
			$Message .= "Enter your 4/5 digit Member ID.\r\n";
			$Message .= "Enter your PASSWORD ( Check with your referrer )\r\n";
			$Message .= "\r\n";
			$Message .= "Your contributions can be sent to Bank Virtual Account Numbers.\r\nTo find Trust sub account number dedicated for your member id , UpdateScreens-> Request VAN and select the purpose.\r\n\r\n";
			$Message .= "Jaya Jaya Sankara Hara Hara Sankara\r\n";
			$Message .= "Brahmana Sabha(Pancha Dravida), Hyderabad\r\n\r\n\r\n";
			$Message .= "Dharmo Rakshati Rakshitah\r\n";
			$this_mail = mail($to, $header, $Message, $From);
		}
		if ($this_mail) {
			$message .= "\r\nEmail sent to Member with member details.";
		} else $message .= "ERROR Name: $last_name $first_name Email: $email_id<br>";
	} else
		$message .= mysqli_error($link);

	echo $message;
}
//end member creation

if (isset($_POST["member_update_form"])) {

	$MEMBER_ID =  $_POST["MEMBER_ID"];
	$Phone_Num = $_POST["Phone_Num"];
	$first_name = $_POST["first_name"];
	$last_name =  $_POST["last_name"];
	$yob =  $_POST["yob"];
	$father_id = $_POST['father_id'];
	$mother_id = $_POST['mother_id'];
	$spouse_id = $_POST['spouse_id'];
	$gotra = $_POST["gotra"];
	$nakshatra = $_POST["nakshatra"];
	$pada = "";
	if( $_POST["pada"] == 'null' ) $pada = "null";
	else $pada = "'".$_POST["pada"]."'"; 
	$smartha_purohit = $_POST["smartha_purohit"];
	$veda_pandit = $_POST["veda_pandit"];
	$jp = $_POST["jp"];
	$blood_group = $_POST['blood_group'];
	$location = $_POST["location"];
	$email =  $_POST["email"];
	$address1 = $_POST["address1"];
	$address2 = $_POST["address2"];
	$city = $_POST["city"];
	$state = $_POST["state"];
	$country = $_POST["country"];
	$PIN_or_ZIP = $_POST["PIN_or_ZIP"];
	$updated_by = $_SESSION['id'];

	$message = "";
	/** 	`Surname` = '$last_name', 
	 * `Name` = '$first_name',
	 * `Phone_Num` = '$Phone_Num',*/

	$sql = "UPDATE BSPD_Member SET 
	`Year_Of_Birth` = '$yob', 
	`Gotram_ID` = '$gotra', 
	`Nakshatra` = $nakshatra, 
	`Pada` = $pada, 
	`Email_ID` = '$email',  
	`Spouse_ID` = '$spouse_id', 
	`Father_ID` = '$father_id', 
	`Mother_ID` = '$mother_id', 
	`Address1` = '$address1', 
	`Address2` = '$address2', 
	`City` = '$city', 
	`PIN_or_ZIP` = '$PIN_or_ZIP', 
	`State` = '$state', 
	`Country` = '$country', 
	`Location` = '$location',
	`BloodGroup` = '$blood_group',
	`Updated_By` = '$updated_by' 
	WHERE (`MEMBER_ID` = '$MEMBER_ID');
	";
	/**
	 * , `Smarta_Purohit` = '$smartha_purohit', `Veda_Pandit` = '$veda_pandit'
	 */
	$sql1 = "UPDATE BSPD_Member_Privileges 
	SET `JP` = '$jp' WHERE (`MEMBER_ID` = '$MEMBER_ID');	";

	if (mysqli_query($link, $sql)) {
		$message .= "Member updated successfully for $last_name $first_name";
	} else
		$message .= mysqli_error($link);

	if (mysqli_query($link, $sql1)) {
		$message .= "\n\r Privileges updated successfully for $last_name $first_name";
	} else
		$message .= mysqli_error($link);

	echo $message;
}

if (isset($_POST['bring_member_details'])) {
	$search = mysqli_real_escape_string($link, $_POST['MEMBER_ID']);
	$sql = "SELECT * FROM BSPD_Member where MEMBER_ID = '$search';";
	$query = mysqli_query($link, $sql);

	$sql1 = "SELECT * FROM BSPD_Member_Privileges where MEMBER_ID = '$search';";
	$query1 = mysqli_query($link, $sql1);
	$row1 = mysqli_fetch_assoc($query1);


	if (mysqli_num_rows($query) > 0) {
		$i = 0;
		while ($row = mysqli_fetch_assoc($query)) {
			$output[$i] = (object) array(
				'MEMBER_ID' => $row['MEMBER_ID'],
				'Phone_Num' => $row['Phone_Num'],
				'last_name' => $row['Surname'],
				'first_name' => $row['Name'],
				'yob' => $row['Year_Of_Birth'],
				'father_id' => $row['Father_ID'],
				'mother_id' => $row['Mother_ID'],
				'spouse_id' => $row['Spouse_ID'],
				'gotra' => $row['Gotram_ID'],
				'nakshatra' => $row['Nakshatra'],
				'pada' => $row['Pada'],
				'blood_group' => $row['BloodGroup'],
				'location' => $row['Location'],
				'email' => $row['Email_ID'],
				'address1' => $row['Address1'],
				'address2' => $row['Address2'],
				'city' => $row['City'],
				'state' => $row['State'],
				'country' => $row['Country'],
				'PIN_or_ZIP' => $row['PIN_or_ZIP'],
				'Smarta_Purohit' => $row1['Smarta_Purohit'],
				'Veda_Pandit' => $row1['Veda_Pandit'],
				'JP' => $row1['JP']
			);
			$i++;
		}
		echo json_encode($output);
	} else {
		echo json_encode("No records found");
	}
}

if (isset($_POST["jp_register_form"])) {
	$MEMBER_ID = $_POST['MEMBER_ID'];
	$jpregister = $_POST['jpregister'];
	$sql = "SELECT * FROM BSPD_Member where MEMBER_ID = $MEMBER_ID;";
	$query = mysqli_query($link, $sql);
	$message = "";
	if (mysqli_num_rows($query) > 0) {
		$row = mysqli_fetch_array($query);
		if (($row['Gender'] == 'M') && (date("Y") - $row['Year_Of_Birth'] < 21) ||
			($row['Gender'] == 'F') && (date("Y") - $row['Year_Of_Birth'] < 18)
		) {
			echo "Member not eligible for Jathaka Parivarthana";
			return;
		} else {
			$sql1 = "update BSPD_Member_Privileges set JP = '$jpregister' where MEMBER_ID = $MEMBER_ID;";
			if (mysqli_query($link, $sql1)) {
				if ($jpregister == 'Y')
					$message .= "Member registered for Jathaka Parivarthana successfully";
				else if ($jpregister == 'N')
					$message .= "Member deregistered for Jathaka Parivarthana successfully";
			} else
				$message .= mysqli_error($link);
			echo $message;
			return;
		}
	} else
		echo "Member does not exist";
}

if (isset($_POST["change_password_form"])) {
	$MEMBER_ID = $_POST['MEMBER_ID'];
	$old_password = $_POST['old_password'];
	$new_password = $_POST['new_password'];
	$new_password2 = $_POST['new_password2'];
	if ($new_password != $new_password2) {
		echo "New passwords not matching";
		return;
	}
	$sql = "SELECT * FROM BSPD_Member where MEMBER_ID = $MEMBER_ID;";
	$query = mysqli_query($link, $sql);
	$message = "";
	if (mysqli_num_rows($query) > 0) {
		$row = mysqli_fetch_array($query);
		if (md5($old_password) != $row['Password']) {
			echo "Incorrect old password.";
			return;
		} else {
			$sql = "update BSPD_Member set Password = md5('$new_password') where MEMBER_ID = $MEMBER_ID;";
			if (mysqli_query($link, $sql))
				$message .= "Password changed successfully";
			else
				$message .= mysqli_error($link);
			echo $message;
			return;
		}
	} else
		echo "Member ID does not exist.";
}

if (isset($_POST["login_form"])) {
	$MEMBER_ID = $_POST["MEMBER_ID"];
	$password = $_POST["password"];

	$result = mysqli_query($link, "SELECT * FROM BSPD_Member WHERE MEMBER_ID = $MEMBER_ID and Password = md5('" . $password . "')");
	$row = mysqli_fetch_array($result);
	if (is_array($row)) {
		$_SESSION["id"] = $row['MEMBER_ID'];
		$_SESSION["name"] = $row['Surname'] . " " . $row['Name'];
		$_SESSION["MEMBER_TYPE"] = $row['MEMBER_TYPE'];
		$_SESSION['login']='true';   
        $_SESSION['login_time'] = time(); 
	} else {
		echo json_encode("Invalid Username or Password!");
		return;
	}

	$sql = "Select Permissions from BSPD_Member_Permissions where MEMBER_ID = " . $_SESSION['id'] . ";";
	$query = mysqli_query($link, $sql);
	if (mysqli_num_rows($query) > 0) {
		$row = mysqli_fetch_array($query);
		$_SESSION['permission'] = $row["Permissions"];
	} else $_SESSION['permission'] = 0;

	if (isset($_SESSION["id"])) {
		//User IP address to be retrieved
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if (getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if (getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if (getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if (getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if (getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';
		$createdon = date('Y-m-d H:i:s');
		/*
		$sqlIns = "INSERT INTO bspd_tokens ( emp_uid, createdon, token) " ." select   '" .$_SESSION["id"]. "','" .$createdon. "', '" .$ipaddress. " ' ";
	
		if(mysqli_query($link, $sqlIns)){ echo "Member record was updated successfully.";     } 
		else { echo "ERROR: Could not able to execute $sqlIns. " . mysqli_error($link);   }
		*/
		echo json_encode("Success");
	}
}
function DecryptDetails($link, $value)
{
	//******************Code for Decryption********
	$decryption_iv = '1234567891011121';        // Non-NULL Initialization Vector for decryption 
	//$decryption_Key = $type;
	$decryption_key = "PayeeBankAccountNumber";   // Store the decryption key 
	$ciphering = "AES-128-CTR";
	$options = 0;
	$decryptvalue = openssl_decrypt($value, $ciphering, $decryption_key, $options, $decryption_iv);  // Use openssl_decrypt() function to decrypt the data 
	return $decryptvalue;
	//     echo "Decrypted String: " . $decryptAcct;   // Display the decrypted string 
}

if (isset($_POST["bank_reg"])) {
	$search = mysqli_real_escape_string($link, $_POST['payee_id']);
	$sql = "SELECT * FROM BSPD_Payee_Account where Payee_ID = '$search' and Account_Status = 'Active';";
	
	$sql1 = "SELECT * FROM BSPD_Payee where Payee_ID = '$search'";
	$query1 = mysqli_query($link, $sql1);
	if(mysqli_num_rows($query1) > 0);
	else return;
	$row1 = mysqli_fetch_array($query1);


	$query = mysqli_query($link, $sql);
	if (mysqli_num_rows($query) > 0) {
		$i = 0;
		while ($row = mysqli_fetch_assoc($query)) {
			$value = $row['Payee_Acnt_Num'];
			$Payee_Acnt_Num = DecryptDetails($link, $value);
			$output[$i] = (object) array(
				'Payee_Name' => $row1['Name'],
				'IFSC_CODE' => $row['IFSC_CODE'],
				'Name_In_Account' => $row['Name_In_Account'],
				'Payee_Acnt_Num' => $Payee_Acnt_Num,
				'Bank_Registration_Code' => $row['Bank_Registration_Code'],
				'Bank_Name' => $row['Bank_Name'],
				'Branch' => $row['Branch']
			);
			$i++;
		}
		echo json_encode($output);
	} else {
		$output[0] = (object) array(
			'Payee_Name' => $row1['Name'],
			'IFSC_CODE' => "NONE",
			'Name_In_Account' => "NONE",
			'Payee_Acnt_Num' => "NONE",
			'Bank_Registration_Code' => "NONE",
			'Bank_Name' => "NONE",
			'Branch' => "NONE"
		);
		echo json_encode($output);
	}
}

if (isset($_POST["bring_subcategory"])) {
	$category_id = $_POST["category_id"];

	$sql = "SELECT distinct Sub_Category_ID, Sub_Category_Desc FROM BSPD_Transaction_Code_Master where Category_ID = '$category_id' and Categroy_Type = 'Expense';";
	$query = mysqli_query($link, $sql);

	$i = 0;
	while ($row = mysqli_fetch_assoc($query)) {
		$output[$i] = (object) array(
			'Sub_Category_ID' => $row['Sub_Category_ID'],
			'Sub_Category_Desc' => $row['Sub_Category_Desc']
		);
		$i++;
	}
	echo json_encode($output);
}

if (isset($_POST["expense_form"])) {
	$event =  $_POST["event"];
	$transaction_date = $_POST["transaction_date"];
	$voucher_num = $_POST["voucher_num"];
	$payee =  $_POST["payee"];
	$amount =  $_POST["amount"];
	$expense_type =  $_POST["expense_type"];
	$category = $_POST["category"];
	$sub_category = $_POST["sub_category"];
	$expense_details = $_POST["expense_details"];
	$bill_status = $_POST["bill_status"];
	$soft_copy_bill = $_POST["soft_copy_bill"];
	$soft_copy_voucher = $_POST["soft_copy_voucher"];
	$voucher_signed = $_POST["voucher_signed"];
	$bill_number = $_POST["bill_number"];
	$brc = $_POST["brc"];
	$payment_intimation_url = $_POST["payment_intimation_url"];
	$payment_date = $_POST["payment_date"];
	$payment_status = $_POST["payment_status"];
	$payment_confirmation_id = $_POST["payment_confirmation_id"];
	$utr_number = $_POST["utr_number"];
	$notes = $_POST["notes"];
	$soft_copy_voucher = $_POST["soft_copy_voucher"];
	$form_mode = $_POST["form_mode"];

	$message = "";

	/*
	$sql = "SELECT * FROM urf_sandbox.SBOX_Member where MEMBER_ID = $referrer_id;";
	$query = mysqli_query($link_test, $sql);

	if(mysqli_num_rows($query) > 0);
	else {
		echo "Referrer ID does not exist";
		return;
	}
	*/
	if ($form_mode == "create") {
	    // Retrieve the latest voucher number. DO NOT BRING FROM FRONTEND
		$sql = "SELECT max(Voucher_Num)+1 as voucher FROM BSPD_Expenses where EVENT_ID='$event';";
		$result1 = mysqli_query($link, $sql);
		$row1 = mysqli_fetch_array($result1);
		if($row1["voucher"] != NULL) $voucher_num = $row1["voucher"];
		else $voucher_num = 1;
		
		// At the time of creation, payment status is set to pending
		$payment_status = 'pending';
	    
		$sql = "INSERT INTO BSPD_Expenses 
		(`EVENT_ID`, `TRN_DATE`, `Voucher_Num`, `PAYEE_ID`, `Amount`, `Category_ID`, `Subcategory_ID`, 
		`Amount_Details`, `Expense_Type`, `Bill_Status`, `Expense_Bill_Num`, `SoftCopyVochure`, `SoftCopyBill`, 
		`Voucher_Signed`, `Bank_Registration_Code`, `Pay_Intimation_URL`, `Payment_Date`, `Payment_Status`, 
		`Payment_Confirmation_ID`, `UTR_Number`, `Note`) 
		VALUES ('$event', '$transaction_date', '$voucher_num', '$payee', '$amount', '$category', '$sub_category',
		 '$expense_details', '$expense_type', '$bill_status', '$bill_number', '$soft_copy_voucher', '$soft_copy_bill', '$voucher_signed', 
		'$brc', '$payment_intimation_url', '$payment_date', '$payment_status', '$payment_confirmation_id', '$utr_number', '$notes');";

		if (mysqli_query($link, $sql)) {
			$message .= "Expense record created successfully";
		} else
			$message .= mysqli_error($link);

		echo $message;
	} else if ($form_mode == "update") {
		$sql = "UPDATE BSPD_Expenses 
		SET 
			`PAYEE_ID` = '$payee',
			`Amount` = '$amount',
			`Category_ID` = '$category',
			`Subcategory_ID` = '$sub_category',
			`Amount_Details` = '$expense_details',
			`Expense_Type` = '$expense_type',
			`Bill_Status` = '$bill_status',
			`Expense_Bill_Num` = '$bill_number',
			`SoftCopyVochure` = '$soft_copy_voucher',
			`SoftCopyBill` = '$soft_copy_bill',
			`Voucher_Signed` = '$voucher_signed',
			`Bank_Registration_Code` = '$brc',
			`Pay_Intimation_URL` = '$payment_intimation_url',
			`Payment_Date` = '$payment_date',
			`Payment_Status` = '$payment_status',
			`Payment_Confirmation_ID` = '$payment_confirmation_id',
			`UTR_Number` = '$utr_number',
			`Note` = '$notes'
		WHERE
			(`EVENT_ID` = '$event'
			AND `Voucher_Num` = $voucher_num 
			);
		";

		if (mysqli_query($link, $sql)) {
			$message .= "Expense record updated successfully";
		} else
			$message .= mysqli_error($link);

		echo $message;
	}
}



if (isset($_POST['voucher_details'])) {
	$search = mysqli_real_escape_string($link, $_POST['event']);
	$voucher_num = $_POST['voucher_num'];
	$sql = "SELECT * FROM BSPD_Expenses where EVENT_ID = '$search' and Voucher_Num = $voucher_num;";
	$query = mysqli_query($link, $sql);
	if (mysqli_num_rows($query) > 0) {
		$i = 0;
		while ($row = mysqli_fetch_assoc($query)) {
			$sql1 = "SELECT Payee_ID, Name, Phone_Num FROM BSPD_Payee where Payee_ID = " . $row['PAYEE_ID'] . ";";
			$result1 = mysqli_query($link, $sql1);
			$row1 = mysqli_fetch_array($result1);
			$payee = "";
			$payee .= $row1["Payee_ID"] . " ";
			$payee .= $row1["Name"] . " ";
			$payee .= $row1["Phone_Num"];

			$output[$i] = (object) array(
				'payee' => $row['PAYEE_ID'],
				'payee_id' => $row['PAYEE_ID'],
				'amount' => $row['Amount'],
				'expense_type' => $row['Expense_Type'],
				'category_id' => $row['Category_ID'],
				'subcategory_id' => $row['Subcategory_ID'],
				'expense_details' => $row['Amount_Details'],
				'bill_status' => $row['Bill_Status'],
				'bill_number' => $row['Expense_Bill_Num'],
				'soft_copy_voucher' => $row['SoftCopyVochure'],
				'soft_copy_bill' => $row['SoftCopyBill'],
				'voucher_signed' => $row['Voucher_Signed'],
				'brc' => $row['Bank_Registration_Code'],
				'payment_intimation_url' => $row['Pay_Intimation_URL'],
				'payment_date' => $row['Payment_Date'],
				'payment_status' => $row['Payment_Status'],
				'payment_confirmation_id' => $row['Payment_Confirmation_ID'],
				'utr_number' => $row['UTR_Number'],
				'notes' => $row['Note']
			);
			$i++;
		}
		echo json_encode($output);
	} else {
		echo json_encode("No records found");
	}
}

if (isset($_POST['bring_voucher_details'])) {
	$search = mysqli_real_escape_string($link, $_POST['event_id']);
	$sql = "SELECT * FROM BSPD_View_Expense_Report where EVENT_ID = '$search' LIMIT 10;";
	$query = mysqli_query($link, $sql);
	if (mysqli_num_rows($query) > 0) {
		$output[$i] = (object) array(
			'date' => $row['Payment_Date'],
			'eventid' => $row['EVENT_ID'],
			'vno' => $row['Voucher_Num'],
			'expense_type' => $row["Expense_Type"],
			'payee_id' => $row["Payee_ID"],
			'name' => $row["Name"],
			'phno' => $row["Phone_Num"],
			'Amt_In_Words' => $row["Amt_In_Words"],
			'towards' => $row["Event_Description"],
			'bill' => $row["Expense_Bill_Num"],
			'amount' => $row["Amount"],
			'category' => $row["Category"],
			'sub_category' => $row["Sub_Category"],
			'nameinact' => $row["Name_In_Account"],
			'ifsc' => $row["IFSC_CODE"],
			'accnt_num' => $row["Payee_Acnt_Num"]
		);
		echo json_encode($output);
	} else {
		echo json_encode("No records found");
	}
}

if (isset($_POST['event_report_form'])) {
	$event_id = $_POST['event_id'];
	$event_date = $_POST['event_date'];
	$team = $_POST['team'];
	$registered = $_POST['registered'];
	$attended = $_POST['attended'];
	$gender = $_POST['gender'];
	$age_min = $_POST['age_min'];
	$age_max = $_POST['age_max'];

	$sqlt100 = "SELECT 
			MEMBER_ID
		FROM
			BSPD_Member_Permissions
		WHERE
			Permissions & POWER(2,20);";
	$queryt100 = mysqli_query($link, $sqlt100);
	$t = mysqli_num_rows($queryt100);
	$tr = 0; $ty = 0; $tn = 0; $tu = 0;
	$t100 = [];
	while( $row = mysqli_fetch_array($queryt100) ) $t100[] = $row['MEMBER_ID'];

	$sqlqry = "SELECT * FROM BSPD_Event_Registration where EVENT_ID = '$event_id';";
	$query = mysqli_query($link, $sqlqry);
	$output = "";
	$r_number = 0; $rY = 0; $rN = 0; $rYaY = 0; $rYaN = 0; $rNaY = 0; $aY = 0; $rUaY = 0;
	while($row = mysqli_fetch_array($query))
	{
		if(array_search($row['MEMBER_ID'], $t100)){ 
			if($row['Registered'] == 'Y') $ty++;
			else if($row['Registered'] == 'N') $tn++;
		}
		if($row['Registered'] != '') $r_number++;
		if($row['Registered'] == 'Y') $rY++;
		if($row['Registered'] == 'N') $rN++;
		if($row['Registered'] == 'Y' && $row['Attended'] == 'Y')  $rYaY++;
		if($row['Registered'] == 'Y' && $row['Attended'] == '')  $rYaN++;
		if($row['Registered'] == 'N' && $row['Attended'] == 'Y')  $rNaY++;
		if($row['Registered'] == '' && $row['Attended'] == 'Y')  $rUaY++;
		if($row['Attended'] == 'Y')  $aY++;
	}
	$tu = $t - ($ty+$tn);
	$output .= "<div class='col-sm-2'>";
	$output .= "<table class='table table-bordered table-condensed'>";
	$output .= "<tr><th colspan = '3'style='background-color:#dcdcdc;'><center>Registrations</center></th></tr>";
	$output .= "<tr><th>Yes</th><th>No</th><th>Total</th></tr>";
	$output .= "<tr><td>$rY</td><td>$rN</td><td>$r_number</td></tr>";
	$output .= "</table>";
	$output .= "<table class='table table-bordered table-condensed'>";
	$output .= "<tr><th colspan = '4'style='background-color:#dcdcdc;'><center>Registrations T100</center></th></tr>";
	$output .= "<tr><th>Yes</th><th>No</th><th>Unregistered</th><th>Total</th></tr>";
	$output .= "<tr><td>$ty</td><td>$tn</td><td>$tu</td><td>$t</td></tr>";
	$output .= "</table>";
	if (date('Y-m-d') >= $event_date) {
		$output .= "<b>Registered and did not attend: $rYaN</b>";
		$output .= "<table class='table table-bordered table-condensed'>";
		$output .= "<tr><th colspan = '4' style='background-color:#dcdcdc;'><center>Attendance</center></th></tr>";
		$output .= "<tr><th>Regd Yes</th><th>Regd No</th><th>Unregistered</th><th>Total</th></tr>";
		$output .= "<tr><td>$rYaY</td><td>$rNaY</td><td>$rUaY</td><td>$aY</td></tr>";
		$output .= "</table><br><br>";
	}

	$output .= "</div>";
	

	$unregistered_query = "SELECT
		`a`.`Alias` as Alias,
		`a`.`Year_Of_Birth` as YOB
		FROM
			`BSPD_Member` `a`
		WHERE `a`.`MEMBER_TYPE` = 'ADMIN'
		AND `a`.`MEMBER_ID` 
		NOT IN (";

	$query = "SELECT
		`a`.`Alias` as Alias,
		`a`.`Year_Of_Birth` as YOB,
		`a`.`Phone_Num` as Phone_Num,
		`b`.`CreatedDate` as Registered_Date,
		`c`.`Alias` as Registered_By
	FROM
		`BSPD_Member` `a`
	    JOIN `BSPD_Event_Registration` `b`
		JOIN `BSPD_Member` `c`
	WHERE
		`a`.`MEMBER_ID` = `b`.`MEMBER_ID`
	AND	`c`.`MEMBER_ID` = `b`.`CreatedBy`
	AND `b`.`EVENT_ID` = '$event_id'";

	$query1 = "SELECT
		`a`.`Alias` as Alias,
		`a`.`Year_Of_Birth` as YOB,
		`a`.`Phone_num` as Phone_Num
		`b`.`CreatedDate` as Registered_Date,
		`c`.`Alias` as Registered_By
	FROM
		`BSPD_Member` `a`
	    JOIN `BSPD_Event_Registration` `b`
		JOIN `BSPD_Member` `c`
	WHERE
		`a`.`MEMBER_ID` = `b`.`MEMBER_ID`
	AND	`c`.`MEMBER_ID` = `b`.`CreatedBy`
	AND `b`.`EVENT_ID` = '$event_id'";

	if ($gender != " ") {
		$query .= " AND `a`.`Gender` = '$gender'";
		$query1 .= " AND `a`.`Gender` = '$gender'";
	}

	if ($age_min && $age_max) {
		$query .= " AND (`a`.`Year_of_Birth` BETWEEN " . (date("Y") - $age_max) . " AND " . (date("Y") - $age_min) . ")";
		$query1 .= " AND (`a`.`Year_of_Birth` BETWEEN " . (date("Y") - $age_max) . " AND " . (date("Y") - $age_min) . ")";
	}
	if ($team != " ") {
		$query .= " AND `a`.`MEMBER_TYPE` = '$team'";
		$query1 .= " AND `a`.`MEMBER_TYPE` = '$team'";
	}
	$flag = 0;
	$output .= "<div>Event - $event_id Registration = $registered Attended = $attended</div>";
	if ($registered == "N" &&  $attended == 'N') {
		$sql = $unregistered_query . $query1 . ") order by `a`.`Surname`;";
		$flag = 1;
	} else if ($registered == 'N' && $attended == 'Y') {
		$query .= " AND `b`.`Attended` = 'Y'";
		$query .= " AND `b`.`Registered` = '$registered'";
		$sql = $query . " order by `b`.`CreatedDate` desc;";
	} else if ($registered == 'RY' && $attended == 'N') {
		$query .= " AND `b`.`Registered` = 'Y'";
		$query .= " AND `b`.`Attended` = ''";
		$sql = $query . " order by `b`.`CreatedDate` desc;";
	} else if ($registered == 'RN' && $attended == 'N') {
		$query .= " AND `b`.`Registered` = 'N'";
		$query .= " AND `b`.`Attended` = ''";
		$sql = $query . " order by `b`.`CreatedDate` desc;";
	} else if ($registered == 'RY' && $attended == 'Y'){
		$query .= " AND `b`.`Registered` = 'Y'";
		$query .= " AND `b`.`Attended` = '$attended'";
		$sql = $query . " order by `b`.`CreatedDate` desc;";
	} else if ($registered == 'RN' && $attended == 'Y'){
		$query .= " AND `b`.`Registered` = 'N'";
		$query .= " AND `b`.`Attended` = '$attended'";
		$sql = $query . " order by `b`.`CreatedDate` desc;";
	}
	//echo $sql;
	//die();
	$output .= "<table class='table table-responsive'>
	<tr>
	  <th scope='col'>#</th>
	  <th scope='col'>Name</th>";
	if(EVENT_REPORT_ADMIN & $_SESSION['permission']) $output .= "<th scope='col'>Age</th>";
	if(EVENT_REPORT_ADMIN & $_SESSION['permission']) $output .= "<th scope='col'>Phno</th>";
	$output .=  "<th scope='col'>Reg By</th>
	  <th scope='col'>Registered Date</th>
	</tr>";


	$query = mysqli_query($link, $sql);
	if (mysqli_num_rows($query) > 0) {
		$i = mysqli_num_rows($query) - 1;

		while ($row = mysqli_fetch_assoc($query)) {
			$minutes_to_add = 750;
			$age = (date('Y')-$row['YOB']);
			if($flag != 1)
			{
				$time = new DateTime($row['Registered_Date']);
				$time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
			}

			if ($flag == 1){ 
				 $output .= "<tr><td>" . ($i + 1) . "</td><td>" . $row['Alias'] . "</td>";
				 if(EVENT_REPORT_ADMIN & $_SESSION['permission']) $output .= "<td>".$age."</td>";
				 if(EVENT_REPORT_ADMIN & $_SESSION['permission']) $output .= "<td>".$row['Phone_Num']."</td>";
				 $output .= "<td>".$row['Registered_By']."</td></tr>"; 
			}
			else {
				$output .= "<tr><td>" . ($i + 1) . "</td><td>" . $row['Alias'] . "</td>";
				if(EVENT_REPORT_ADMIN & $_SESSION['permission']) $output .= "<td>".$age."</td>";
				if(EVENT_REPORT_ADMIN & $_SESSION['permission']) $output .= "<td>".$row['Phone_Num']."</td>"; 
				$output .= "<td>".$row['Registered_By']."</td><td>" . $time->format('Y-m-d H:i:s') . "</td></tr>";
			}
			$i--;
		}
		$output .= "</table>";
		echo $output;
	} else {
		echo "No records found";
	}
}

if (isset($_POST['statement_edit_form'])) {
	$van = $_POST["van"];
	$srno = $_POST["srno"];
	$notes = $_POST["notes"];
	$trdate = $_POST["trdate"];

	$length = sizeof($van);
	$flag = 0;
	for ($i = 0; $i < $length; $i++) {
		$sql = "UPDATE `BSPD_SIB_Collection_Report` SET `ID` = '" . $van[$i] . "', `Notes` = '" . $notes[$i] . "', `TRANDATE` = '" . $trdate[$i] . "' WHERE (`SrNo` = '" . $srno[$i] . "');";
		$query = mysqli_query($link, $sql);
		if ($query);
		else {
			echo mysqli_error($link) . "\n";
			$flag = 1;
		}
	}
	echo "Corrected records successfully.";
}

if (isset($_POST['contribution_processing_form'])) {
	//echo "testing response";
	$event = $_POST["event"];
	$SrNo = $_POST["SrNo"];

	$length = sizeof($event);

	for ($i = 0; $i < $length; $i++) {
		$sql = "SELECT * FROM BSPD_View_Convert_Stmt_NonBVCD2022 where SrNo = '$SrNo[$i]' ;";
		$result = mysqli_query($link, $sql);
		$row = mysqli_fetch_array($result);

		if ($event[$i] == "CANCEL") {
			$sqlqry = "UPDATE `BSPD_SIB_Collection_Report` SET `Archive` = '2' WHERE (`SrNo` = '" . $SrNo[$i] . "');";
			if (mysqli_query($link, $sqlqry));
			else echo "ERROR " . mysqli_error($link);
		} else if ($event[$i] == "PROCESS LATER") continue;
		else {
			$sqlqry = "UPDATE `BSPD_SIB_Collection_Report` SET `Archive` = '1' WHERE (`SrNo` = '" . $SrNo[$i] . "');";
			if (mysqli_query($link, $sqlqry));
			else echo "ERROR " . mysqli_error($link);

			$sql1 = "INSERT INTO `BSPD_Member_Contribution` (`Member_id`, `EVENT_ID`, `Amount`, `Contribution_Type`, `Contribution_Date`, `Reference_Details`, `Approved`, `CreatedBy`) 
    		VALUES ('" . $row['Member_id'] . "', '" . $event[$i] . "', '" . $row['Amount'] . "', '" . $row['Contribution_Type'] . "', '" . $row['Contribution_Date'] . "', '" . $row['Reference_Details'] . "', 'Y', '1933');";

			if (mysqli_query($link, $sql1)) { 
				$transaction_id = mysqli_insert_id($link);
				$type="BSPDHYDContributionReceipt";
				$encrypted_id = EncryptDetails($link, $transaction_id, $type);
				$Receipt_PDF_URL = "http://www.bspd.in/app/receiptgenerate?id=$encrypted_id";
				$sql2 = "UPDATE BSPD_Member_Contribution SET Receipt_PDF_URL = '$Receipt_PDF_URL' WHERE Transaction_Code = $transaction_id";
				if(mysqli_query($link, $sql2));
				else echo "ERROR " . mysqli_error($link);
			}
			else echo "ERROR " . mysqli_error($link);
		}
	}
	echo "Records Uploaded successfully.";
}

if (isset($_POST['csv_receipt_generation_form'])) {
	$from_date = $_POST['from_date'];
	$to_date = $_POST['to_date'];
	$response = "";
	$sql = "SELECT 
    Transaction_Code,
    Full_Name,
    BSPD_Member_id,
    Amount,
    Amount_In_Words AS AmountWords,
    Contribution_Type,
    Email_Address,
    Event_Description,
	Event_Location,
    EVENT_ID,
    Reference_Details,
    DATE_FORMAT(Contribution_Date, '%d-%b-%Y') AS Contribution_Date,
	DATE_FORMAT(Receipt_Date, '%d-%b-%Y') AS Receipt_Date,
    '' AS Test
	FROM
    BSPD_View_Contribution_Report
	WHERE
    Contribution_Date BETWEEN '$from_date' AND '$to_date'
        AND TRIM(Receipt_PDF_URL) IS NULL
	ORDER BY Transaction_Code;";
	//echo $sql;
	$query = mysqli_query($link, $sql);
	$response .= "Transaction_Code,Full_Name,BSPD_Member_id,Amount,AmountWords,Contribution_Type,Email_Address,Event_Description,Event_Location,EVENT_ID,Reference_Details,Contribution_Date,Receipt_Date,Test,Receipt_PDF_URL<br>";
	$total_amount = 0;
	$row_count = 0;
	while ($row = mysqli_fetch_array($query)) {
		$response .= $row["Transaction_Code"] . ","
			. $row["Full_Name"] . ","
			. $row["BSPD_Member_id"] . ","
			. $row["Amount"] . ","
			. $row["AmountWords"] . ","
			. $row["Contribution_Type"] . ","
			. $row["Email_Address"] . ","
			. $row["Event_Description"] . ","
			. $row["Event_Location"] . ","
			. $row["EVENT_ID"] . ","
			. $row["Reference_Details"] . ","
			. $row["Contribution_Date"] . ","
			. $row["Receipt_Date"] . ","
			. $row["Test"] . ",";
		$transaction_id = $row["Transaction_Code"];
		$type="BSPDHYDContributionReceipt";
		$encrypted_id = EncryptDetails($link, $transaction_id, $type);
		$Receipt_PDF_URL = "http://www.bspd.in/app/receiptgenerate?id=$encrypted_id";
		$sql2 = "UPDATE BSPD_Member_Contribution SET Receipt_PDF_URL = '$Receipt_PDF_URL' WHERE Transaction_Code = $transaction_id";
		if(mysqli_query($link, $sql2));
		else echo "ERROR " . mysqli_error($link);
		$response .= $Receipt_PDF_URL . "<br>";
		$row_count++;
		$total_amount += $row['Amount'];
	}
	$response .= "<br>No of generated receipts: " . $row_count . " Total amount: " . $total_amount . "<br>";
	echo $response;
}

if (isset($_POST['email_nbv_header'])) {
	$header_id = $_POST['header_id'];
	$transaction_code = $_POST['transaction_code'];

	if ($header_id) {
		$sql = "SELECT UTRNumber from BSPD_NBV_File_Header where HeaderUID = $header_id";
		$query = mysqli_query($link, $sql);
		$row = mysqli_fetch_array($query);
		$utrnumber = $row["UTRNumber"];

		$sql = "SELECT min(Transaction_Code) as min, max(Transaction_Code) as max from BSPD_Member_Contribution where Reference_Details like '%$utrnumber%'";
		$query = mysqli_query($link, $sql);
		$row = mysqli_fetch_array($query);
		$min = $row["min"];
		$max = $row["max"];

		for ($i = $min; $i <= $max; $i++) sendemail($link, $i);
	}

	if ($transaction_code) sendemail($link, $transaction_code);
}

function sendemail($link, $tc)
{
	$output = "";
	$sql = "SELECT * from BSPD_View_Contribution_Report where Transaction_Code = $tc";
	$query = mysqli_query($link, $sql);
	$row = mysqli_fetch_array($query);

	$Email_ID = $row['Email_Address'];
	$Receipt_No = $row['Transaction_Code'];
	$Event_Description = $row['Event_Description'];
	$Full_Name = $row['Full_Name'];
	$MEMBER_ID = $row['Member_ID'];
	$Event_Notes = $row['Event_Notes'];
	$Receipt_PDF_URL = $row['Receipt_PDF_URL'];

	if ($Email_ID != "nobody@bspd.in") {
		$to = $Email_ID;
		$header = 'Receipt No ' . $Receipt_No . ' for ' . $Event_Description;
		$From = 'From: bspd.hyd@gmail.com';
		$Message = "Namaste " . $Full_Name . " Garu,\r\n";
		$Message .= "BSPD Member Id : " . $MEMBER_ID . "\r\n";
		$Message .= "\r\n";
		$Message .= $Event_Notes . "\r\n";
		$Message .= "\r\n";
		$Message .= $Event_Description . "\r\n";
		$Message .= "Receipt link : " . $Receipt_PDF_URL . "\r\n\r\n";
		$Message .= "Jaya Jaya Sankara Hara Hara Sankara\r\n";
		$Message .= "Brahmana Sabha(Pancha Dravida), Hyderabad\r\n\r\n\r\n";
		$Message .= "Dharmo Rakshati Rakshitah\r\n";
		$this_mail = mail($to, $header, $Message, $From);
	}
	if ($this_mail) {
		$output .= "$Receipt_No email sent<br>";
	} else $output .= "$Receipt_No ERROR Name: $Full_Name Email: $Email_ID<br>";

	echo $output;
}

if (isset($_POST['bug_edit_form'])) {
	$id = $_POST["id"];
	$category = $_POST["category"];
	$description = $_POST["description"];
	$status = $_POST["status"];
	$header_uid = $_POST["header_uid"];
	$resolution = $_POST["resolution"];
	$resolved_by = $_POST["resolved_by"];
	$sequence = $_POST["sequence"];

	$length = sizeof($id);

	for ($i = 0; $i < $length; $i++) {
		$sql = "UPDATE `urf_sandbox`.`SBOX_Bug_Report` SET 
		`Category` = '" . $category[$i] . "', `Description` = '" . $description[$i] . "', 
		`Status` = '" . $status[$i] . "', `Header_UID` = '" . $header_uid[$i] . "', 
		`Resolution` = '" . $resolution[$i] . "', `Resolved_By` = '" . $resolved_by[$i] . "', 
		`Sequence` = '" . $sequence[$i] . "' WHERE (`Ticket_No` = '" . $id[$i] . "');";
		if (mysqli_query($link_test, $sql));
		else echo "ERROR " . mysqli_error($link_test);
	}
	echo "Update was successful";
}

if (isset($_POST['ticket_no_form'])) {
	$ticket = $_POST['ticket'];
	$sql = "UPDATE `urf_sandbox`.`SBOX_Bug_Report` SET `Status` = 'Open' WHERE (`Ticket_No` = '$ticket');";
	if (mysqli_query($link_test, $sql));
	else echo "ERROR " . mysqli_error($link_test);

	echo "Ticket reopened";
}

if (isset($_POST['permissions_form'])) {
	$permission = $_POST['permission'];
	$MEMBER_ID = $_POST['MEMBER_ID'];

	/* Check if member ID is valid */
	$sql = "SELECT * FROM BSPD_Member where MEMBER_ID = $MEMBER_ID";
	$query = mysqli_query($link, $sql);
	if (mysqli_num_rows($query) == 0) {
		echo "Invalid member.\nPermissions not Updated.";
		return;
	}

	/** Check if T100 permission is set. If it is set, then set MEMBER_TYPE = 'ADMIN' in BSPD_Member table.
	 * This will be removed in the future.
	 */
	if ($permission & T100) {
		$sql2 = "UPDATE BSPD_Member SET `MEMBER_TYPE` = 'ADMIN' WHERE (`MEMBER_ID` = '$MEMBER_ID');";
		if (mysqli_query($link, $sql2));
		else echo "ERROR " . mysqli_error($link);
	} else {
		$sql2 = "UPDATE BSPD_Member SET `MEMBER_TYPE` = 'MEMBER' WHERE (`MEMBER_ID` = '$MEMBER_ID');";
		if (mysqli_query($link, $sql2));
		else echo "ERROR " . mysqli_error($link);
	}

	/** Check if member record is available in Member permissions table. If yes, update. 
	 * Else, insert new record. */
	$sql1 = "SELECT * FROM BSPD_Member_Permissions where MEMBER_ID = $MEMBER_ID";
	$query1 = mysqli_query($link, $sql1);
	if (mysqli_num_rows($query1) > 0) {
		$sql = "UPDATE BSPD_Member_Permissions SET `Permissions` = '$permission' 
				WHERE (`MEMBER_ID` = '$MEMBER_ID');";
	} else $sql = "INSERT INTO BSPD_Member_Permissions (`MEMBER_ID`, `Permissions`) VALUES ('$MEMBER_ID', '$permission');";

	if (mysqli_query($link, $sql))
		echo "Permissions updated successfully.";
	else
		echo "ERROR " . mysqli_error($link);
}

if (isset($_POST['bring_permissions'])) {
	$MEMBER_ID = $_POST['MEMBER_ID'];

	$sql = "SELECT * FROM BSPD_Member where MEMBER_ID = $MEMBER_ID";
	$query = mysqli_query($link, $sql);
	if (mysqli_num_rows($query) > 0);
	else {
		echo json_encode("Invalid member");
		return;
	}

	$sql = "SELECT * FROM BSPD_Member_Permissions where MEMBER_ID = $MEMBER_ID";
	$query = mysqli_query($link, $sql);

	if (mysqli_num_rows($query) > 0) {
		$row = mysqli_fetch_array($query);
		echo json_encode($row['Permissions']);
	} else echo json_encode("No permissions set for this ID.\nPlease set permissions for this ID and click on update.");
}

if (isset($_POST['event_attendance_form'])) {
	$MEMBER_ID = $_POST['MEMBER_ID'];
	$event_id = $_POST['event_id'];
	$message = "";

	$sql = "SELECT * FROM BSPD_Event where EVENT_ID = '$event_id';";
	$query = mysqli_query($link, $sql);
	$row = mysqli_fetch_array($query);

	if ($row['Event_date'] == date('Y-m-d'));
	else {
		echo "Cannot mark attendance for past or future events.";
		return;
	}

	$sql = "SELECT * FROM BSPD_Event_Registration where MEMBER_ID = $MEMBER_ID and EVENT_ID = '$event_id';";
	$query = mysqli_query($link, $sql);

	if (mysqli_num_rows($query) > 0)
		$sql = "UPDATE BSPD_Event_Registration SET `Attended` = 'Y' WHERE (`MEMBER_ID` = '$MEMBER_ID') and (`EVENT_ID` = '$event_id');";
	else {
		$sql = "INSERT INTO BSPD_Event_Registration (`MEMBER_ID`, `EVENT_ID`, `Registered`, `Attended`) VALUES ('$MEMBER_ID', '$event_id', '', 'Y');";
		$message = "MEMBER HAS NOT REGISTERED FOR THIS EVENT.\n";
	}
	if (mysqli_query($link, $sql))
		echo $message . "Attendance updated successfully.";
	else
		echo "ERROR " . mysqli_error($link);
}

if (isset($_POST['member_report_form'])) {
	$report = $_POST['report'];
	$member_id = $_POST['member_id'];
	$output = "";

	if ($report == "recognition") {
		$sqlqry1 = "Select * from BSPD_View_Recognition where MemberID = '" . $member_id . "' order by Event_ID";
		$result = mysqli_query($link, $sqlqry1);

		$output .= "<table class='table table-responsive'>";
		$output .= "<th>Event Description</th><th>Recognition</th><th>Notes</th>";
		while ($row = mysqli_fetch_array($result)) {
			$output .= "<tr><td>" . $row['Event_Description'] . "</td><td>" . $row['Recognition'] . "</td><td>" . $row['Notes'] . "</td></tr>";
		}
		echo $output;
	}
	if ($report == "attendance") {
		$sqlqry1 = "SELECT * FROM BSPD_View_Event_Registration where MEMBER_ID = '" . $member_id . "' and Attended = 'Y' ";
		$result = mysqli_query($link, $sqlqry1);

		$output .= "<table class='table table-responsive'>";
		$output .= "<th>Event Description</th><th>Event Date</th><th>Attended</th>";
		while ($row = mysqli_fetch_array($result)) {
			$output .= "<tr><td>" . $row['Event_Description'] . "</td><td>" . $row['Event_date'] . "</td><td>" . $row['Attended'] . "</td></tr>";
		}
		echo $output;
	}
	if ($report == "expenses") {
		$sqlqry1 = "SELECT * FROM BSPD_View_Expense_Report where MEMBER_ID = " . $member_id . "";
		$result = mysqli_query($link, $sqlqry1);

		if (!$result) {
		} else {
			$output .= "<table class='table table-responsive'>";
			$output .= "<th>MEMBER Name</th><th>Amount</th><th>Event_Description</th><th>Amt_In_Words</th>";
			while ($row = mysqli_fetch_array($result)) {
				$output .= "<tr><td>" . $row['Name'] . "</td><td>" . $row['Amount'] . "</td><td>" . $row['Event_Description'] . "</td><td>" . $row['Amt_In_Words'] . "</td></tr>";
			}
		}
		echo $output;
	}
	if ($report == "contribution") {
		$sqlqry1 = "Select date_format(Contribution_date,'%d%b%y') as Contribution_Date, Transaction_Code, Event_Description, Contribution_Type, Amount, Receipt_PDF_URL  from BSPD_View_Contribution_Report where Member_ID = " . $member_id . " order by Transaction_Code desc";
		$result = mysqli_query($link, $sqlqry1);

		$output .= "<table class='table table-responsive'>";
		$output .= "<th>C Date</th><th>Receipt#</th><th>Event Description</th><th>Contribution Type</th><th>Amount</th><th>Receipt</th>";
		while ($row = mysqli_fetch_array($result)) {
			$receiptURL = $row['Receipt_PDF_URL'];
			$output .= "<tr><td>" . $row['Contribution_Date'] . "</td><td>" . $row['Transaction_Code'] . "</td><td>" . $row['Event_Description'] . "</td><td>" . $row['Contribution_Type'] . "</td><td>"
				. $row['Amount'] . "</td><td>" . " <a href='$receiptURL' target='_blank'>$receiptURL</a>" . "</td></tr>";
		}
		echo $output;
	}
	if ($report == "reference") {
		$sqlqry1 = "Select * from BSPD_Member where Referrer_ID = '" . $member_id . "' order by MEMBER_ID";
		$result = mysqli_query($link, $sqlqry1);

		$output .= "<table class='table table-responsive'>";
		$output .= "<th>Member ID</th><th>Member Name</th><th>Email ID</th><th>Phone Num</th>";
		while ($row = mysqli_fetch_array($result)) {
			$output .= "<tr><td>" . $row['MEMBER_ID'] . "</td><td>" . $row['Alias'] . "</td><td>" . $row['Email_ID'] . "</td><td>" . $row['Phone_Num'] . "</td></tr>";
		}
		echo $output;
	}
}

if (isset($_POST['event_exp_report_form'])) {
	$report = $_POST['report'];
	$event_id = $_POST['event_id'];
	$output = "";

	if ($report == "recognition") {
		$sqlqry1 = "Select * from BSPD_View_Recognition where Event_ID = '$event_id'";
		$result = mysqli_query($link, $sqlqry1);

		$output .= "<table border='1' style='border-collapse: collapse' class='table table-condensed'>";
		$output .= "<th>Member Name</th><th>Recognition</th><th>Recognition Desc</th>";
		while ($row = mysqli_fetch_array($result)) {
			$output .= "<tr><td>" . $row['Alias'] . "</td><td>" . $row['Recognition'] . "</td><td>" . $row['Notes'] . "</td></tr>";
		}
		echo $output;
	}

	if ($report == "contribution") {
		$sql1 = "Select sum(Amount) as Amount, count(Transaction_Code) as count from BSPD_View_Contribution_Report where EVENT_ID = '$event_id';";
		$result1 = mysqli_query($link, $sql1);
		$row1 = mysqli_fetch_array($result1);


		$sqlqry1 = "Select * from BSPD_View_Contribution_Report where EVENT_ID = '$event_id' order by Full_Name";
		$result = mysqli_query($link, $sqlqry1);
		$output .= "<br>Contribution details for the Event : " . $event_id;

		$output .= "<table border='1' style='border-collapse: collapse' class='table table-condensed'>";
		$output .= "<tr><td style='background-color:aqua;' colspan='6' align='center'><b>Total Amount: Rs." . $row1['Amount'] . "         Number of contributors: " . $row1['count'] . "</b></td></tr>";
		$output .= "<th>Member ID</th><th>Member Name</th><th>Contribution Date</th><th>Contribution_Type</th><th>Amount</th><th>Receipt URL</th>";


		while ($row = mysqli_fetch_array($result)) {
			$receiptURL = $row['Receipt_PDF_URL'];
			$output .= "<tr><td>" . $row['Member_ID'] . "</td><td>" . $row['Full_Name'] . "</td><td>" . $row['Contribution_Date'] . "</td><td>" . $row['Contribution_Type'] . "</td><td>"
				. $row['Amount'] . "</td><td>" . " <a href='$receiptURL' target='_blank'>$receiptURL</a>" . "</td></tr>";
		}
		$output .= "</table>";
		echo $output;
	}

	if ($report == "kindsum") {
		
		$sql = "SELECT EVENT_ID, sum(Amount) as expamount FROM BSPD_Expenses where Expense_Type = 'KIND' group by EVENT_ID;";
		$query = mysqli_query($link, $sql);
		$sql1 = "SELECT EVENT_ID, sum(Amount) as contamount FROM BSPD_Member_Contribution where Contribution_Type = 'KIND' group by EVENT_ID;";
		$query1 = mysqli_query($link, $sql1);
		$array = array();
		$event_ids = array();

		while($row = mysqli_fetch_array($query)) { $array[$row['EVENT_ID']]['exp'] = $row['expamount']; $event_ids[] = $row['EVENT_ID'];}
		while($row = mysqli_fetch_array($query1)) $array[$row['EVENT_ID']]['cont'] = $row['contamount'];
		print_r($array); die();
		$output .= "<table class='table table-condensed table-bordered'>";
		$output .= "<tr><th>Event</th><th>Expense</th><th>Contribution</th></tr>";
		foreach($event_ids as $event_id)
		{
			$output .= "<tr><td>".$array[$event_id]['exp']."</td>";
			$output .= "<td>".$array[$event_id]['cont']."</td></tr>";
		}
		$output .= "</table>";

		
	}

	if ($report == "finsum") {
		$sql = "SELECT DISTINCT
					`E`.Category_ID, `T`.Category_Desc
				FROM
					`BSPD_Expenses` `E` JOIN `BSPD_Transaction_Code_Master` `T`
				WHERE
					`E`.Category_ID = `T`.Category_ID and 
					`T`.Categroy_Type = 'Expense' and
					EVENT_ID = 'CH0073'
				ORDER BY Category_ID;";
		$query = mysqli_query($link, $sql);
		$categories = []; 
		$category_names = [];
		while($row = mysqli_fetch_array($query)) { $categories[] = $row['Category_ID']; $category_names[] = $row['Category_Desc'];}


		$sql = "SELECT Sub_Category_Desc FROM BSPD_Transaction_Code_Master where Categroy_Type = 'Contribution' and Category_ID = 1;";
		$query = mysqli_query($link, $sql);
		$expense_types = []; 
		while($row = mysqli_fetch_array($query)) $expense_types[] = $row['Sub_Category_Desc'];
		
		foreach($categories as $category) foreach($expense_types as $expense_type) $expensedata[$category][$expense_type] = 0;

		$sql = "SELECT 
					Category_ID, Expense_Type, SUM(Amount) AS Amount
				FROM
					BSPD_Expenses
				WHERE
					EVENT_ID = '$event_id'
				GROUP BY Category_ID , Expense_Type
				ORDER BY Category_ID , Expense_Type;";
		$query = mysqli_query($link, $sql);

		while( $row = mysqli_fetch_array($query) )
		{
			$expensedata[$row['Category_ID']][$row['Expense_Type']] = $row['Amount'];
		}

		foreach($expense_types as $expense_type) $contributiondata[$expense_type] = 0;
		
		$sql = "SELECT Contribution_Type, sum(Amount) as Amount FROM BSPD_Member_Contribution where EVENT_ID = '$event_id' group by Contribution_Type;";
		$query = mysqli_query($link, $sql);
		
		while( $row = mysqli_fetch_array($query) ) $contributiondata[$row['Contribution_Type']] = $row['Amount'];

		$output .= "<div class='row col-sm-5'>";
		$output .= "<table class='table table-condensed table-bordered'><tr>";
		$output .= "<tr><th colspan='5'>Expense Summary for : $event_id</th>";
		$output .= "<tr><th>Category</th>";

		foreach($expense_types as $expense_type) $output .= "<th>".$expense_type."</th>";
		$output .= "</tr>";
		$expkindsum = 0;
		$contkindsum = 0;
		$expsum = 0;
		$contsum = 0;
		$i = 0;
		foreach($categories as $category) 
		{	
			$output .= "<tr><td>".$category.": ".$category_names[$i]."</td>";
			$i++;
			foreach($expense_types as $expense_type) 
			{
				$output .= "<td align='right'>".$expensedata[$category][$expense_type]."</td>";
				if($expense_type == 'KIND') $expkindsum += $expensedata[$category][$expense_type];
				else $expsum += $expensedata[$category][$expense_type];
			}
			$output .= "</tr>";
		}

		$output .= "</table>";
		$output .= "</div>";
		$output .= "<div class='row col-sm-2'></div>";
		$output .= "<div class='row col-sm-5'>";
		$output .= "<table class='table table-condensed table-bordered'><tr>";
		$output .= "<th colspan='2'>Contribution Summary for $event_id</th></tr>";
		foreach($expense_types as $expense_type)
		{
			$output .= "<tr><td>".$expense_type."</td><td align='right'>".$contributiondata[$expense_type]."</td></tr>";
			if($expense_type == 'KIND') $contkindsum += $contributiondata[$expense_type];
			else $contsum += $contributiondata[$expense_type];
		}
		//foreach(array_keys($contributiondata) as $parameter) $output .= "<td>".$contributiondata[$parameter]."</td>"; 
		$output .= "</table>";
		$output .= "</div>";
		$output .= "<div class='row col-sm-5'>";
		$output .= "<table class='table table-condensed table-bordered'><tr>";
		$output .= "<tr><th>Type</th><th>Contribution</th><th>Expense</th><th>Deficit/Balance/<br>Discrepency</th></tr>";
		$output .= "<tr><th style='font-size:10px;'>CASH/NEFT/<br>CHEQUE</th><td align='right'>".$contsum."</td><td align='right'>".$expsum."</td><td align='right'>".($contsum-$expsum)."</td></tr>";
		$output .= "<tr><th>KIND</th><td align='right'>".$contkindsum."</td><td align='right'>".$expkindsum."</td><td align='right'>".($contkindsum-$expkindsum)."</td></tr>";
		$output .= "</table></div>";
		echo $output;
		
	}

	if ($report == "expenses") {
		$sqlqry = "SELECT * FROM BSPD_View_Expense_Report where EVENT_ID = '$event_id'";
		$result = mysqli_query($link, $sqlqry);
		$output .= "<br> voucher list for :" . $event_id;

		$output .= "<table border='1' style='border-collapse: collapse' class='table table-condensed'>";
		$output .= "<th>Voucher</th><th>SCat Details</th><th>Amt</th><th>SCBill</th><th>Bill#</th><th>BillSt</th><th>VSig</th><th>PSts</th><th>Payee</th><th>UTR</th><th>Payment Conf</th><th>Amt Details</th>";

		while ($row = mysqli_fetch_array($result)) {
			$output .= "<tr><td>" . $row['Voucher_Num'] . "</td><td>" . $row['Sub_Category'] . "</td><td>" . $row['Amount'] . "</td><td>" . $row['SoftCopyBill'] . "</td><td>" . $row['Expense_Bill_Num'] .
				"</td><td>" . $row['Bill_Status'] . "</td><td>" . $row['Voucher_Signed'] . "</td><td>" . $row['Payment_Status'] . "</td><td>" . $row['Payee_ID'] . " " . substr($row['Name'], 0, 20) . "</td>
              <td>" . $row['UTR_Number'] . "</td><td>" . $row['Payment_Confirmation_ID'] . "</td><td>" . substr($row['Amount_Details'], 0, 50) . "</td></tr>";
		}
		$output .= "</table>";
		echo $output;
	}
}

if (isset($_POST['password_reset_form'])) {
	$member_id = $_POST['member_id'];
	$message = "";

	$sql = "SELECT * FROM BSPD_Member where MEMBER_ID = '$member_id';";
	$query = mysqli_query($link, $sql);
	if(mysqli_num_rows($query) > 0)
	{
		$row = mysqli_fetch_array($query);
		$email_id = $row['Email_ID'];
		
		$pwd = rand(100000,999999);
		$sql1 = "UPDATE BSPD_Member SET `Password` = '".md5($pwd)."' WHERE (`MEMBER_ID` = '$member_id');";
		if(mysqli_query($link, $sql1))
		{
			$to = $email_id;
			$to_bspd = "bspd.hyd@gmail.com";
			$header = 'Password Reset BSPD Self Service Login';
			$From = 'From: bspd.hyd@gmail.com';
			$Message = "Namaste ".$row["Alias"]." garu, \r\n";
			$Message .= "Ph: ".$row["Phone_Num"]."\r\n";
			$Message .= "You have requested a password reset on BSPD Self Service Site.\r\n";
			$Message .= "Please use the pin provided below for login.\r\n\r\n";
			$Message .= "PIN: $pwd \r\n\r\n";

			$Message .= "Request you to change your password after logging in.\r\n\r\n";
			$Message .= "Regards,\r\nTeam BSPD";
			
			
			$this_mail = mail($to, $header, $Message, $From);
			$this_mail1 = mail($to_bspd, $header, $Message, $From);

			if ($this_mail) {
				$message .= "Password has been reset. New password sent to your email: \r\n$email_id";
			} 
			else { echo "ERROR sending mail to : $email_id"; return; }
			
		}
		else { echo "Error in update: ".mysqli_error($link); return; }
	}
	else $message = "Invalid Member ID";
	
	echo $message;
}

if (isset($_POST['payee_form'])) {
	if($_POST["MEMBER_ID"]) $MEMBER_ID =  $_POST["MEMBER_ID"];
	else $MEMBER_ID = 0;
	$Phone_Num = $_POST["Phone_Num"];
	$name = $_POST["name"];
	$link_aadhar = $_POST["link"];
	$govtid_type = $_POST["govtid_type"];
	$govtid = $_POST["govtid"];	
	$email =  $_POST["email"];
	$address1 = $_POST["address1"];
	$address2 = $_POST["address2"];
	$city = $_POST["city"];
	$state = $_POST["state"];
	$country = $_POST["country"];
	$created_by = $_SESSION['id'];
	$sql = "";

	$sql1 = "SELECT * FROM BSPD_Payee where Phone_Num = $Phone_Num ;";
	$query1 = mysqli_query($link, $sql1);
	if(mysqli_num_rows($query1) > 0)
	{
		echo "Another payee has the same phone number.\nAvoiding payee creation due to possible duplicate entry.";
		return;
	}

	$sql = "INSERT INTO BSPD_Payee (`Name`, `MEMBER_ID`, `Aadhar_Img_URL`, `Govt_ID`, `Govt_ID_Num`, `Email_ID`, `Phone_Num`, `Address1`, `Address2`, `City`, `State`, `Country`, `Created_By`) 
	VALUES ('$name', '$MEMBER_ID', '$link_aadhar', '$govtid_type', '$govtid', '$email', '$Phone_Num', '$address1', '$address2', '$city', '$state', '$country', '$created_by');";

	$query = mysqli_query($link, $sql);
	if($query)
		echo "Inserted successfully";
	else
		echo mysqli_error($link);

}

function EncryptDetails($link, $value, $type){ 
	//*****Code for encryption*****************
	// Store a string into the variable which need to be Encrypted 
	   $simple_string = $value; 
	//echo "Original String: " . $simple_string;  // Display the original string 
	   $ciphering = "AES-128-CTR";   // Store the cipher method 
	   $iv_length = openssl_cipher_iv_length($ciphering);  // Use OpenSSl Encryption method 
	   $options = 0; 
	   $encryption_iv = '1234567891011121';   // Non-NULL Initialization Vector for encryption 
	   $encryption_key = $type;  // Store the encryption key 
	   $encryptvalue = openssl_encrypt($simple_string, $ciphering, $encryption_key, $options, $encryption_iv); // Use openssl_encrypt() function to encrypt the data 
	   return $encryptvalue;
	//echo "Encrypted String: " . $encryptAcct . "\n";  // Display the encrypted string 
}

if(isset($_POST['payee_accnt_form'])) {
	$payee = $_POST['payee'];
	$name_in_accnt = $_POST['name_in_accnt'];
	$accnt_num = $_POST['accnt_num'];
	$nickname = substr($_POST['nick_name'], 0, 45);
	$bank_name = $_POST['bank_name'];
	$bank_branch = $_POST['bank_branch'];
	$ifsc = $_POST['ifsc'];
	$link_passbook = $_POST['link'];
	$type = "PayeeBankAccountNumber";
	$encryptednum = EncryptDetails($link, $accnt_num, $type);

	$sql = "INSERT INTO BSPD_Payee_Account (Payee_ID, IFSC_CODE, Passbook_Img_URL, Payee_Acnt_Num, Name_In_Account, Bank_Name, Branch, Nick_Name) " ."SELECT " 
  . $payee . ",'" . $ifsc . "', '" . $link_passbook ."', '" . $encryptednum. "', '" . $name_in_accnt . "', '" . $bank_name . "',  '" . $bank_branch . "',  '" . $nickname . "'";

  $query = mysqli_query($link, $sql);
  if($query)
	echo "Payee Account created successfully";
	else echo mysqli_error($link);

}

if(isset($_POST['cash_collection_form'])) {
	$sno = $_POST["sno"];
	$memberid = $_POST["memberid"];
	$event_id = $_POST["event_id"];
	$amount = $_POST["amount"];
	$note = $_POST["note"];

	$sql = "SELECT * FROM BSPD_Member WHERE MEMBER_ID = $memberid and Status = 'Active'";
	$query = mysqli_query($link, $sql);

	if(mysqli_num_rows($query) <= 0) {
		echo "Invalid/Inactive/Duplicate Member ID.";
		return;
	}

	if($sno == "New") 
	{
		$sql = "INSERT INTO Temp_SBOX_GNCD_Log (`EVENT_ID`, `Collector_ID`, `Contributer_ID`, `Amount`, `Notes`, `Status`) 
		VALUES ('$event_id', '".$_SESSION['id']."', '$memberid', '$amount', '$note', 'entered');";
	}
	else
	{
		$sql = "UPDATE Temp_SBOX_GNCD_Log SET 
		`EVENT_ID` = '$event_id', 
		`Contributer_ID` = '$memberid', 
		`Amount` = '$amount', 
		`Notes` = '$note' WHERE (`SrNo` = '$sno');";
	}
  	$query = mysqli_query($link_test, $sql);
  	if($query)
	echo "Update/Insert successful.";
	else echo mysqli_error($link);

}

if(isset($_POST['preview'])) {
	$sql = "SELECT * FROM Temp_SBOX_GNCD_Log WHERE Status = 'entered' order by SrNo";
	$result = mysqli_query($link_test, $sql);
	$output = "";
	$i = 1;
	$output .= "<table class='table table-condensed'>";
	$output .= "<tr><td>Contributor</td><td>Event ID</td><td>Amount</td><td>Mode</td><td>Create Date</td><td>Reference</td><td>Approved</td><td>Created By</td></tr>";

	while($row = mysqli_fetch_array($result)) {
		$output .= "<tr>";
		$output .= "<td>".$row['Contributer_ID']."</td>";
		$output .= "<td>".$row['EVENT_ID']."</td>";
		$output .= "<td>".$row['Amount']."</td>";
		$output .= "<td>CASH</td>";
		$output .= "<td>".$row['CreatedDate']."</td>";
		$output .= "<td>CASH DESK ".str_pad($i,3,"0",STR_PAD_LEFT)."</td>";
		$output .= "<td>Y</td>";
		$output .= "<td>".$_SESSION['id']."</td>";
		$output .= "</tr>";

		$i++;
	}
	$output .= "</table>";
	 echo $output;
}

if(isset($_POST['cash_record_generate'])) {
	$sql = "SELECT * FROM Temp_SBOX_GNCD_Log WHERE Status = 'entered' order by SrNo";
	$result = mysqli_query($link_test, $sql);
	$i = 1;

	while($row = mysqli_fetch_array($result)) {
		$sql1 = "INSERT INTO BSPD_Member_Contribution (`Member_id`, `EVENT_ID`, `Amount`, `Contribution_Type`, `Contribution_Date`, `Reference_Details`, `Approved`, `CreatedBy`) 
    		VALUES ('" . $row['Contributer_ID'] . "', '" . $row['EVENT_ID'] . "', '" . $row['Amount'] . "', 'CASH', '" . $row['CreatedDate'] . "', 'CASH DESK " . str_pad($i,3,"0",STR_PAD_LEFT) . "', 'Y', '".$_SESSION['id']."');";

			if (mysqli_query($link, $sql1)) { 
				$transaction_id = mysqli_insert_id($link);
				$type="BSPDHYDContributionReceipt";
				$encrypted_id = EncryptDetails($link, $transaction_id, $type);
				$Receipt_PDF_URL = "http://www.bspd.in/app/receiptgenerate?id=$encrypted_id";
				$sql2 = "UPDATE BSPD_Member_Contribution SET Receipt_PDF_URL = '$Receipt_PDF_URL' WHERE Transaction_Code = $transaction_id";
				if(mysqli_query($link, $sql2));
				else echo "ERROR " . mysqli_error($link);
				$sql3 = "UPDATE Temp_SBOX_GNCD_Log SET Status = 'reconciled' WHERE SrNo = ".$row['SrNo'].";";
				if(mysqli_query($link_test, $sql3));
				else echo "ERROR " . mysqli_error($link_test);
			}
			else echo "ERROR " . mysqli_error($link);
			$i++;
	}
	echo "Receipts generated succesfully.";
}

if(isset($_POST['deletemembercontribution'])) {
	$sno = $_POST['sno'];

	$sql = "DELETE FROM Temp_SBOX_GNCD_Log where SrNo = '$sno'";
	$query = mysqli_query($link_test, $sql);

	if($query) echo "Record deleted succesfully";
	else echo mysqli_error($link_test);

}

if(isset($_POST['link_utr_form'])) {
	$snos = $_POST['snos'];
	$utr = $_POST['utr'];
	$message ="";

	$length = sizeof($snos);
	for($i=0;$i<$length;$i++)
	{
		$sql = "UPDATE Temp_SBOX_GNCD_Log SET `UTR` = '$utr', `Status` = 'UTRlinked' WHERE (`SrNo` = '$snos[$i]');";
		$query = mysqli_query($link_test, $sql);
		if($query) $message .= "utr change for $snos[$i] successful\n";
		else $message .= mysqli_error($link_test);
	}
	echo $message;
}

if(isset($_POST['utrsave'])) {
	$utr = $_POST["utr"];
	$newutr = $_POST["newutr"];
	$message = "";

	$sql = "UPDATE Temp_SBOX_GNCD_Log SET `UTR` = '$newutr' WHERE (`UTR` = '$utr');";
	$query = mysqli_query($link_test, $sql);
	if($query) $message .= "utr change to $newutr from $utr successful.\n";
	else $message .= mysqli_error($link_test);

	echo $message;
}

if(isset($_POST['utrdelete'])) {
	$utr = $_POST["utr"];
	$message = "";

	$sql = "UPDATE Temp_SBOX_GNCD_Log SET `UTR` = '0' , `Status` = 'entered' WHERE (`UTR` = '$utr');";
	$query = mysqli_query($link_test, $sql);
	if($query) $message .= "Unlinking UTR successful.\n";
	else $message .= mysqli_error($link_test);

	echo $message;
}

if(isset($_POST['generatereceipt'])) {
	$utr = $_POST["utr"];
	$message = "";

	//BRING RECORD FROM BANK STMT USING SELECTED UTR
	/*$sql1 = "SELECT * FROM SBOX_SIB_Collection_Report where Archive = 0 and SLNO = '$utr' and left(id,4) = 'GNCD';";
	$query1 = mysqli_query($link_test, $sql1);

	if(mysqli_num_rows($query1) == 0)
	{
		echo "UTR/VAN not found in bank records.";
		return;
	}
	$row1 = mysqli_fetch_array($query1);
	//RETRIEVE AMOUNT FROM STMT
	$bank_amount = $row1['TRANAMT'];
	$bank_tran_date = $row1['TRNDATE'];

	//BRING RECORDS FROM LOG TABLE USING UTR
	$sql = "SELECT * FROM Temp_SBOX_GNCD_Log WHERE UTR = '$utr';";
	$query = mysqli_query($link_test, $sql);
	$sumcontribution = 0;
	$rowsinfile = mysqli_num_rows($query);
	
	//SUM OF ALL AMOUNTS FROM CONTRIBUTION RECORDS
	while( $row = mysqli_fetch_array($query) ) $sumcontribution += $row['Amount'];*/

	$sql = "SELECT * FROM SBOX_View_GNCD_CashDesk where SLNO = '$utr';";
	$query = mysqli_query($link_test, $sql);
	$rowsinfile = mysqli_num_rows($query);
	if(mysqli_num_rows($query) == 0)
	{
		echo "UTR/VAN not matching.";
		return;
	}
	$sumcontribution = 0;
	$bank_amount = 0;
	while( $row = mysqli_fetch_array($query) )
	{
		$sumcontribution += $row['Amount'];
		$bank_amount = $row['TRANAMT'];
	}

	if( $sumcontribution != $bank_amount ) { echo "Amount mismatch."; return; }
	
	else { 
		$message = "Amount is matching $sumcontribution\n";
		$i = 1;
		$query = mysqli_query($link_test, $sql);
		while( $row = mysqli_fetch_array($query) ) {

			$reference_str = "GNCD".str_pad($_SESSION['id'],5,"0",STR_PAD_LEFT)." Ref ".$utr." Row ".str_pad($i,3,"0",STR_PAD_LEFT)." of ".str_pad($rowsinfile,3,"0",STR_PAD_LEFT);
			$message .= "$reference_str\n";
			$sql2 = "INSERT INTO SBOX_Member_Contribution 
			(`Member_id`, `EVENT_ID`, `Amount`, `Contribution_Type`, `Contribution_Date`, `Reference_Details`, `Approved`, `CreatedBy`) 
			VALUES ('".$row['Contributer_ID']."', '".$row['EVENT_ID']."', '".$row['Amount']."', 'NEFT', '".$row['Contribution_Date']."', '".$reference_str."', 'Y', '1933');";
			$result = mysqli_query($link_test, $sql2);
			if($result)	$message .= "$reference_str inserted.\n";
			else $message .= mysqli_error($link_test)."\n";

			$i++;
		}
		$sql3 = "UPDATE SBOX_SIB_Collection_Report SET Archive = '1' where SLNO = '$utr';";
		if(mysqli_query($link_test, $sql3))	$message .= "Updated bank record";
		else $message .= mysqli_error($link_test)."\n";

		$sql4 = "UPDATE Temp_SBOX_GNCD_Log set Status = 'reconciled' where UTR = '$utr';";
		if(mysqli_query($link_test, $sql4))	$message .= "Marked records as reconciled";
		else $message .= mysqli_error($link_test)."\n";
		
		echo $message;
	}
}

if(isset($_POST['bring_expense_details']))
{
	$event_id = $_POST['event_id'];

	$sql = "SELECT * FROM BSPD_View_Expense_Report where EVENT_ID = '$event_id'";
	$query = mysqli_query($link, $sql);
	$output = "";
	while ( $row = mysqli_fetch_array($query))
	{
		$output .= "Bill: ".$row['EVENT_ID']." V".str_pad($row['Voucher_Num'],3,"0",STR_PAD_LEFT)." B Payee ".$row['Name']." Rs ".$row['Amount']." ".$row['Amount_Details'].".jpg<br>";
		$output .= "Voucher: ".$row['EVENT_ID']." V".str_pad($row['Voucher_Num'],3,"0",STR_PAD_LEFT)." Payee ".$row['Name']." Rs ".$row['Amount']." ".$row['Amount_Details'].".jpg<br><br>";
		//Bill CH0063 V034 B Payee 1177 Gandikota Satya Ravi Kanth Rs 9440 Sarees and Blouse Pieces( 16 nos).jpg
	}
	echo $output;
}

if(isset($_POST['in_process']))
{
	// updating all records from pay status to in_process status
	$output = "";
	$sql = "Select * from BSPD_Expenses WHERE Payment_status='pay';";
	$query = mysqli_query($link, $sql);
	$count = mysqli_num_rows($query);

	$sql = "UPDATE BSPD_Expenses SET Payment_status ='in_process' WHERE Payment_status='pay';";
	$query = mysqli_query($link, $sql);
	if($query) $output = "Changed $count records to 'In process' status";

	echo $output;

}

if(isset($_POST['reverse_in_process']))
{
	// updating all records from pay status to in_process status
	$output = "";
	$sql = "Select * from BSPD_Expenses WHERE Payment_status='in_process';";
	$query = mysqli_query($link, $sql);
	$count = mysqli_num_rows($query);

	$sql = "UPDATE BSPD_Expenses SET Payment_status ='pay' WHERE Payment_status='in_process';";
	$query = mysqli_query($link, $sql);
	if($query) $output = "Changed $count records to 'Pay' status";

	echo $output;

}

if(isset($_POST['searchfield']))
{
	  $search = $_POST['searchfield'];
	  $output = "";
      $sql = "SELECT * FROM BSPD_Member where (Alias like '%$search%' or MEMBER_ID like '%$search%' or Phone_Num like '%$search%' or Email_ID like '%$search%') and Status = 'Active' LIMIT 25;";
      $result = mysqli_query($link, $sql);
	  $output.= "<table class='table table-condensed table-bordered>'";
	  $output.= "<tr><th>Name</th><th>Email</th><th>Phno</th></tr>";  
      while( $row = mysqli_fetch_array($result) )
      {
		$output.= "<tr>";
		$output.= "<td>".$row['Alias']."</td>";
		$output.= "<td>XXX".substr($row['Email_ID'],3, strlen($row['Email_ID']))."</td>";
		$output.= "<td>XXXXXX".substr($row['Phone_Num'],6,4)."</td>";
		$output.= "</tr>";
      }
	  $output.= "</table>";
	  echo $output;
}

if(isset($_POST['save_denomination'])) {
	$qty_arr = $_POST['qty_arr'];
	$event_id = $_POST['event_id'];

	$sql = "SELECT * FROM `urf_sandbox`.`Temp_SBOX_CashHandOver` WHERE EVENT_ID = '$event_id'";
	$result = mysqli_query($link_test, $sql);

	if(mysqli_num_rows($result) > 0) {
		$sql = "UPDATE `urf_sandbox`.`Temp_SBOX_CashHandOver` SET `N2000` = '".$qty_arr[0]."', `N500` = '".$qty_arr[1]."', `N200` = '".$qty_arr[2]."', `N100` = '".$qty_arr[3]."', `N50` = '".$qty_arr[4]."', `N20` = '".$qty_arr[5]."', `N10` = '".$qty_arr[6]."', `N5` = '".$qty_arr[7]."', `N2` = '".$qty_arr[8]."', `N1` = '".$qty_arr[9]."', `C10` = '".$qty_arr[10]."', `C5` = '".$qty_arr[11]."', `C2` = '".$qty_arr[12]."', `C1` = '".$qty_arr[13]."' WHERE (`EVENT_ID` = '$event_id');";
		if(mysqli_query($link_test, $sql)) {
			echo "Denominations updated successfully";
		}
		else echo "Error $event_id".mysqli_error($link_test);
	}
	else{
		$sql = "INSERT INTO `urf_sandbox`.`Temp_SBOX_CashHandOver` (`EVENT_ID`, `N2000`, `N500`, `N200`, `N100`, `N50`, `N20`, `N10`, `N5`, `N2`, `N1`, `C10`, `C5`, `C2`, `C1`) VALUES ('$event_id', '".$qty_arr[0]."', '".$qty_arr[1]."', '".$qty_arr[2]."', '".$qty_arr[3]."', '".$qty_arr[4]."', '".$qty_arr[5]."', '".$qty_arr[6]."', '".$qty_arr[7]."', '".$qty_arr[8]."', '".$qty_arr[9]."', '".$qty_arr[10]."', '".$qty_arr[11]."', '".$qty_arr[12]."', '".$qty_arr[13]."');";
		if(mysqli_query($link_test, $sql)) {
			echo "Denominations inserted successfully";
		}
		else echo "Error $event_id".mysqli_error($link_test);
	}
}