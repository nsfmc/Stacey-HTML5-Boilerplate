<?php
include "helpers.inc.php";
ob_start();

  // change these variables ----------------------------------------------------------------------
  
$mailto= "";								// where the email should be sent
$CCmail= "";											// optional: enter CC email adress
$BCCmail= "";										// optional: enter BCC email adress

$subject="Website Contact Form Inquiry";				// subject of the email
$redirect_OK = Helpers::relative_root_path()."../contact/thanks.html";				// redirect url if no error
$redirect_error = Helpers::relative_root_path()."../error.html";			// redirect url if ERROR

  $valid_ref1="http://$host/contact/";			// where your contact form is. "$host" will be automaticaly filled by your domain so do not change it.
  $valid_ref2="http://$host/contact/";				// a second valid page. "$host" will be automaticaly filled by your domain so do not change it.

    // validation functions ------------------------------------------------------------------------
     
    function validref($valid_ref1,$valid_ref2,$ref_page) {                  
        $valid_referrer=0;
        if($ref_page==$valid_ref1) $valid_referrer=1;
        elseif($ref_page==$valid_ref2) $valid_referrer=1;
        return $valid_referrer;        
    }
    
    //check user input for possible header injection attempts
    function is_forbidden($str,$check_all_patterns = true) {
        $patterns[0] = 'content-type:';
        $patterns[1] = 'mime-version';
        $patterns[2] = 'multipart/mixed';
        $patterns[3] = 'Content-Transfer-Encoding';
        $patterns[4] = 'to:';
        $patterns[5] = 'cc:';
        $patterns[6] = 'bcc:';
        $forbidden = 0;
        for ($i=0; $i<count($patterns); $i++)
        {
        $forbidden = eregi($patterns[$i], strtolower($str));
        if ($forbidden) break;
        }
        //check for line breaks if checking all patterns
        if ($check_all_patterns AND !$forbidden) $forbidden = preg_match("/(%0a|%0d|\\n+|\\r+)/i", $str);
        if ($forbidden) {
            echo "<font color=red><center><h3>Message not sent.</font></h3><br><b>
            The text you entered is forbidden, it includes one or more of the following:
            <br><br><textarea rows=9 cols=25>";
            foreach ($patterns as $key => $value) echo $value."\n";
            echo "</textarea><br><br>Click back on your browser, remove any instances of the above characters and try again.
            </b><br><br><br><br>";
            exit();
        }
        else return $str;
    }
    
    function all_ok() {
    	echo "<p>Thank you for contacting us. We will get back to you as soon as possible.</p>"; 
		$_SESSION['done'] = true;
	}

	function not_ok($sError,$ref_page,$valid_ref1,$valid_ref2) {
		echo "<p>Error: $sError <br />Referring page: <b> $ref_page </b> <br />
		Allowed refferers: <b> $valid_ref1 </b>and <b>  $valid_ref2 </b></p>"; 
		exit();
	}	
    // ---------------------------------------------------------------------------------------------
    
  
    $sName = (isset($_POST['name']) && $_POST['name'] != '' ? $_POST['name'] : false);
    $sEmail = (isset($_POST['email']) && $_POST['email'] != '' ? $_POST['email'] : false);
    $sPhone = (isset($_POST['phone']) && $_POST['phone'] != '' ? $_POST['phone'] : false);
    $sNotes = (isset($_POST['text']) && $_POST['text'] != '' ? $_POST['text'] : false);   
	$ref_page = "unset";
	
if (isset($_POST['btnSubmit'])) {                

    $nError = 0;
    $sError = "";
    $host = $_SERVER["HTTP_HOST"];


    // ---------------------------------------------------------------------------------------------
    

    if( isset($_SESSION['done']) ){
        $sError = "You have already submitted form";
        $nError = 1;
    } 

    $sName = is_forbidden($sName);
    $sEmail = is_forbidden($sEmail);
    $sPhone = is_forbidden($sPhone);
    $sNotes = is_forbidden($sNotes, false);

	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/plain; charset=utf-8' . "\r\n";

	// Additional headers
	$headers .= "From: $sName <$sEmail>" . "\r\n";
	$headers .= "Reply-To: $sName <$sEmail>" . "\r\n";
	$headers .= "Cc: $CCmail" . "\r\n";
	$headers .= "Bcc: $BCCmail" . "\r\n";
	
    $sMessage = "email enquiry received from $host \r\n\n" .
                "Name : $sName \r\n" .
                "Email : $sEmail \r\n" .
                "Number : $sPhone \n" .
                "Enquiry : \r\n $sNotes \n\n"  .
                "-- end --";
				
    if ($nError==0) { mail( $mailto, $subject, $sMessage, $headers );
		all_ok();
		header("Location: $redirect_OK");
	}else{
		not_ok($sError,$ref_page,$valid_ref1,$valid_ref2);
		header("Location: $redirect_error");
    }    
}

ob_flush();

?>