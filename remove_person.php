<?php
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $error_message = Array();
      
      if (empty($_POST["first-name"]))
         $error_message[] = "First Name is required.\n";
      if (empty($_POST["last-name"]))
         $error_message[] = "Last Name is required.\n";
         
      // if pass in all validations.
      if (empty($error_message)) {
         // saving in the database.
         echo "
            <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
            <script src='http://www.parsecdn.com/js/parse-1.2.18.min.js'></script>
            <script type='text/javascript'>
    
               Parse.initialize('s1F3uXdfPUqib5Eac1Q1yGQ5r9YTSNrCXHeXoH50', 'JBa4CTi202x38k5z7XdYE2xfdJjbpMg8phJNmwEP'); 
   
               var MissingPerson = Parse.Object.extend('MissingPerson');
               var query = new Parse.Query(MissingPerson);
               query.equalTo('firstName', \"".$_POST["first-name"]."\");
               query.equalTo('lastName', \"".$_POST["last-name"]."\");
               query.find({
                 success: function(results) {
					for (var i = 0; i < results.length; i++) { 
					   var object = results[i];
					   window.location = \"http://missingpeoplehelper.herokuapp.com//remove_person.php?email=\"+object.get('contactEmail')+\"&name=\"+object.get('firstName')+\"&id=\"+object.id;
					}
                 },
                 error: function(model, error) {
                    $('.error').show();
                 }
               });
            </script>"
         ;
      }
   }
   if (isset($_GET['email'])) {
      require_once "Mail.php";
		  
	  $from = "missingpeoplehelper@gmail.com";
	  $to = $_GET['email'];
	  $subject = "Someone was found!";
	  $body = "Hi, we heard that you found " . $_GET['name'] . ", please, confirm that on the link bellow:\n\n";
	  $body .= "http://missingpeoplehelper.herokuapp.com/confirmation.php?id=". $_GET['id'];

      $host = "ssl://smtp.gmail.com";
	  $port = "465";
	  $username = "missingpeoplehelper@gmail.com";
	  $password = "senha.123";

	  $headers = array ('From' => $from,
	     'To' => $to,
	     'Subject' => $subject);
	  $smtp = Mail::factory('smtp',
	     array ('host' => $host,
				'port' => $port,
				'auth' => true,
				'username' => $username,
				'password' => $password));
				
	  $mail = $smtp->send($to, $headers, $body);

	  if (PEAR::isError($mail)) {
	     echo "$('.error').show();";
	  } else {
	     echo "$('.success').show();";
	  }
   }
?>

<html>
<head>
<link type="text/css" rel="stylesheet" href="css/general.css">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<title>Missing People Helper</title>
<body>
<div class="wrapper">
	<div class="top">
		<h1>Missing People Helper</h1>
		<div class="links">
			<a href="index.php">Register missing</a>&nbsp;&#x25cf;&nbsp;
			<a href="about.php">Explaining a little</a>&nbsp;&#x25cf;&nbsp;
			<a href="downloads.php">Download</a>
		</div>
	</div>
   <div style="display:none" class="error">
      Looks like there was a problem while removing this profile.
   </div>

   <div style="display:none" class="success">
      A request to the creator of this profile was sent.
   </div>
   <h2>Mark person as found</h2>
   <div class="content">
   <form name="contactform" method="post" action="remove_person.php" enctype="multipart/form-data">
      
      <div class="messages-wrapper">         
         <?php if (isset($error_message) && !empty($error_message)) { ?>
            <ul>
            <?php foreach ($error_message as $message) { ?>
               <li><?php print $message; ?></li>
            <?php
            }
         } ?>
      </div>
      
      <div class="form-item" id="edit-first-name">
         <label for="first-name">First Name: <span class="form-required" title="Esse campo é obrigatório.">*</span></label>
         <input type="text" name="first-name" maxlength="50" size="30" />
      </div>

      <div class="form-item" id="edit-last-name">
         <label for="last-name">Last Name: <span class="form-required" title="Esse campo é obrigatório.">*</span></label>
         <input type="text" name="last-name" maxlength="50" size="30" />
      </div>
      
      <input type="submit" name="submit" id="edit-submit" class="form-submit btn" value="Submit">
   </form>
   </div>
</div>   
</body>
</html>

