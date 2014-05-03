<script src='http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js'></script>
<script src="jquery.numeric.js" type="text/javascript"></script>
<script src='http://www.parsecdn.com/js/parse-1.2.18.min.js'></script>

<?php
   if (isset($_GET['id'])) {
      echo "
         <script type='text/javascript'>
    
         Parse.initialize('s1F3uXdfPUqib5Eac1Q1yGQ5r9YTSNrCXHeXoH50', 'JBa4CTi202x38k5z7XdYE2xfdJjbpMg8phJNmwEP');            
   
         var MissingPerson = Parse.Object.extend(\"MissingPerson\");
         var query = new Parse.Query(MissingPerson);
         query.get(\"".$_GET['id']."\", {
            success: function(missingPerson) {
               missingPerson.destroy({
				  success: function(myObject) {
					$('.success').show();
				  },
				  error: function(myObject, error) {
					$('.error').show();
				  }
			   });
            },
            error: function(object, error) {
               $('.error').show();
            }
         });
            
	     </script>";
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
      An error ocurred. Try again later.
   </div>

   <div style="display:none" class="success">
      Person was set as found!!!!<br> We are very happy with the news, now install our extension for Chrome and let us help to find others too.
   </div>
   <h2>Person found !!!!!!!!!!</h2>
</div>   
</body>
</html>