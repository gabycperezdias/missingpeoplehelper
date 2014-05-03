<script src='http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js'></script>
<script src="jquery.maskedinput.js" type="text/javascript"></script>
<script src="jquery.numeric.js" type="text/javascript"></script>
<script src='http://www.parsecdn.com/js/parse-1.2.18.min.js'></script>

<script>
   jQuery(function($){
      $(".date").mask("99/99/9999");
      $(".numeric").numeric();
   });
</script>

<?php
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $error_message = Array();
      
      if (empty($_POST["first-name"]))
         $error_message[] = "First Name is required.\n";
      if (empty($_POST["last-name"]))
         $error_message[] = "Last Name is required.\n";
      if (empty($_POST["birth-date"]))
         $error_message[] = "Birth Date is required.\n";
      if (empty($_POST["city"]))
         $error_message[] = "City is required.\n";
      if (empty($_POST["state"]))
         $error_message[] = "State is required.\n";
      if (empty($_POST["nationality"]))
         $error_message[] = "Nationality is required.\n";
      if (empty($_POST["skin-color"]))
         $error_message[] = "Skin Color is required.\n";
      if (empty($_POST["height"]))
         $error_message[] = "Height is required.\n";
      if (empty($_POST["weight"]))
         $error_message[] = "Weight is required.\n";
      if (empty($_POST["eyes-color"]))
         $error_message[] = "Eyes Color is required.\n";
      if (empty($_POST["hair-color"]))
         $error_message[] = "Hair Color is required.\n";
      if (empty($_POST["disappearance-date"]))
         $error_message[] = "Disappearance Date is required.\n";
      if (empty($_POST["contact-email"]))
         $error_message[] = "Contact Email is required.\n";
      if (empty($_POST["disappearance-city"]))
         $error_message[] = "Disappearance City is required.\n";
      if (empty($_POST["contact-email"]))
         $error_message[] = "Disappearance State is required.\n";
      if (empty($_FILES['photo']['name']))
         $error_message[] = "Photo is required.\n";
         
      // if pass in all validations.
      if (empty($error_message)) {
         // saving in the database.
         echo "
            <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
            <script src='http://www.parsecdn.com/js/parse-1.2.18.min.js'></script>
            <script type='text/javascript'>
    
               Parse.initialize('s1F3uXdfPUqib5Eac1Q1yGQ5r9YTSNrCXHeXoH50', 'JBa4CTi202x38k5z7XdYE2xfdJjbpMg8phJNmwEP');            
   
               var MissingPerson = Parse.Object.extend(\"MissingPerson\");
               var missingPerson = new MissingPerson();
               var file = new Parse.File(\"".$_FILES["photo"]["name"]."\", { \"base64\": \"".base64_encode(file_get_contents($_FILES['photo']['tmp_name']))."\" });

               missingPerson.save({
                  \"firstName\": \"".$_POST["first-name"]."\",
                  \"lastName\": \"".$_POST["last-name"]."\",
                  \"birthDate\": \"".$_POST["birth-date"]."\",
                  \"city\": \"".$_POST["city"]."\",
                  \"state\": \"".$_POST["state"]."\",
                  \"nationality\": \"".$_POST["nationality"]."\",
                  \"skinColor\": \"".$_POST["skin-color"]."\",
                  \"height\": \"".$_POST["height"]."\",
                  \"weigth\": \"".$_POST["weight"]."\",
                  \"sex\": \"".$_POST["sex"]."\",
                  \"eyesColor\": \"".$_POST["eyes-color"]."\",
                  \"hairColor\": \"".$_POST["hair-color"]."\",
                  \"disappearanceDate\": \"".$_POST["disappearance-date"]."\",
                  \"contactEmail\": \"".$_POST["contact-email"]."\",                  
                  \"disappearanceCity\": \"".$_POST["disappearance-city"]."\",
                  \"disappearanceState\": \"".$_POST["disappearance-state"]."\",
                  \"otherInformation\": \"".(isset($_POST["other-information"]) ? isset($_POST["other-information"]) : ' ')."\",
                  \"photo\": file,
               }, {
                  success: function(object) {
                     $('.success').show();
                  },
                  error: function(model, error) {
                     $('.error').show();
                  }
               });
            </script>"
         ;
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
	<span class="del">Have you found a person? <a href="remove_person.php" class="btn">Mark-it here</a></span>
   <div style="display:none" class="error">
      Looks like there was a problem while saving this profile.
   </div>

   <div style="display:none" class="success">
      Profile created successfully. We will try to find him/her.
   </div>
   <h2>Missing person registration</h2>
   <div class="content">
	   <form name="contactform" method="post" action="index.php" enctype="multipart/form-data">
		  
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

		  <div class="form-item" id="edit-birth-date">
			 <label for="birth-date">Birth Date: <span class="form-required" title="Esse campo é obrigatório.">*</span></label>
			 <input type="text" name="birth-date" maxlength="10" size="7" class="date" />
		  </div>  

		  <div class="form-item" id="edit-city">
			 <label for="city">City: <span class="form-required" title="Esse campo é obrigatório.">*</span></label>
			 <input type="text" name="city" maxlength="50" size="30" />
		  </div> 

		  <div class="form-item" id="edit-state">
			 <label for="state">State: <span class="form-required" title="Esse campo é obrigatório.">*</span></label>
			 <input type="text" name="state" maxlength="50" size="30" />
		  </div> 

		  <div class="form-item" id="edit-nationality">
			 <label for="nationality">Nationality: <span class="form-required" title="Esse campo é obrigatório.">*</span></label>
			 <input type="text" name="nationality" maxlength="50" size="30" />
		  </div> 

		  <div class="form-item" id="edit-skin-color">
			 <label for="skin-color">Skin Color: <span class="form-required" title="Esse campo é obrigatório.">*</span></label>
			 <select name="skin-color">
			   <option value="" selected>---</option>
			   <option value="Light">Light</option>
			   <option value="Fair">Fair</option>
			   <option value="Medium">Medium</option>
			   <option value="Olive">Olive</option>
			   <option value="Brown">Brown</option>
			   <option value="Black">Black</option>
			 </select>
		  </div> 

		  <div class="form-item" id="edit-height">
			 <label for="height">Height (cm): <span class="form-required" title="Esse campo é obrigatório.">*</span></label>
			 <input type="text" name="height" maxlength="3" size="30" class="numeric"/>
		  </div> 

		  <div class="form-item" id="edit-weigth">
			 <label for="weigth">Weight (kg): <span class="form-required" title="Esse campo é obrigatório.">*</span></label>
			 <input type="text" name="weight" maxlength="3" size="30" class="numeric"/>
		  </div> 

		  <div class="form-item" id="edit-sex">
			 <label for="sex">Sex: <span class="form-required" title="Esse campo é obrigatório.">*</span></label>
			 <input type="radio" name="sex" value="Male" checked>Male</input>
			 <input type="radio" name="sex" value="Female">Female</input>
		  </div>  

		  <div class="form-item" id="edit-eyes-color">
			 <label for="eyes-color">Eyes Color: <span class="form-required" title="Esse campo é obrigatório.">*</span></label>
			 <select name="eyes-color">
				<option value="" selected>---</option>
				<option value="Black">Black</option>
				<option value="Brown">Brown</option>
				<option value="Blue">Blue</option>
				<option value="Green">Green</option>
				<option value="Other">Other</option>
			 </select>
		  </div> 

		  <div class="form-item" id="edit-hair-color">
			 <label for="hair-color">Hair Color: <span class="form-required" title="Esse campo é obrigatório.">*</span></label>
			 <select name="hair-color">
				<option value="" selected>---</option>
				<option value="Bald">Bald</option>
				<option value="Black">Black</option>
				<option value="Blond">Blond</option>
				<option value="Brown">Brown</option>
				<option value="Gray">Gray</option>
				<option value="Red">Red</option>
				<option value="Other">Other</option>
			 </select>
		  </div> 

		  <div class="form-item" id="edit-disappearance_date">
			 <label for="disappearance_date">Disappearance Date: <span class="form-required" title="Esse campo é obrigatório.">*</span></label>
			 <input type="text" name="disappearance-date" maxlength="10" size="7" class="date" />
		  </div> 
		  
		  <div class="form-item" id="edit-disappearance_city">
			 <label for="disappearance_city">Disappearance City: <span class="form-required" title="Esse campo é obrigatório.">*</span></label>
			 <input type="text" name="disappearance-city" maxlength="50" size="30" />
		  </div> 
		  
		  <div class="form-item" id="edit-disappearance_state">
			 <label for="disappearance_state">Disappearance State: <span class="form-required" title="Esse campo é obrigatório.">*</span></label>
			 <input type="text" name="disappearance-state" maxlength="50" size="30" />
		  </div> 
		  
		  <div class="form-item" id="edit-contact-email">
			 <label for="contact-email">Contact email: <span class="form-required" title="Esse campo é obrigatório.">*</span></label>
			 <input type="text" name="contact-email" maxlength="50" size="30" />
		  </div>
		  
		  <div class="form-item" id="edit-photo">
			 <label for="photo">Photo: <span class="form-required" title="Esse campo é obrigatório.">*</span></label>
			 <input type="file" name="photo"/>
		  </div>
		  
		  <div class="form-item" id="edit-other-information">
			 <label for="other-information">Other Information: </label>
			 <textarea name="other-information" rows="5" cols="46" ></textarea>
		  </div>
		  
		  <input type="submit" name="submit" id="edit-submit" class="btn" value="Submit">
	   </form>
	   
	   
	</div>
</div>
</body>
</html>

