<!DOCTYPE html>

<?php
	//these are the mysql variables
	$server = "localhost";
	$username = "root";
	$password = "StudyAbroad2018";
	$insurance = 0;
	$appfee = 0;
	$progfee = 0;
	$tuition = 0;
	$studyabroadfee = 175;
	$passport = 0;
	$immunizations = 0;
	$airfare = 0;
	$taxes = 0;
	$food = 0;
	$housing = 0;
	$transport = 0;
	$personal = 0;
	$other = 0;
	$scholarships = 0;
	if( isset($_GET["region"]) && isset($_GET["length"]) ){
		$region = $_GET["region"];
                $length = $_GET["length"];
		$conn = new mysqli($server, $username, $password, "studycost");
		 if(!$conn->connect_error){
                        if(($stmt = $conn->prepare("Select * From programs Where region = ? AND length = ?"))){
                                $stmt->bind_param("ss", $region, $length);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_array(1);
                                $count = 0;
                                //this binds the information from the database to php variables
                                //We start at the third element since the first is a auto incrimented
                                //int primary key that only serves to exist to ensure there is a primary key
                                //the next two items are the region and length which are what we selected on
                                foreach($row as $r){
                                        switch ($count){
                                                case 3:
                                                        $progfee = $r;
                                                        break;
                                                case 4:
                                                        $passport = $r;
                                                        break;
                                                case 5:
                                                        $airfare = $r;
                                                        break;
                                                case 6:
                                                        $food = $r;
                                                        break;
                                                case 7:
                                                        $housing = $r;
                                                        break;
                                                case 8:
                                                        $insurance = $r;
                                                        break;
                                                case 9:
                                                        $transport = $r;
                                                        break;
                                                case 10:
                                                        $personal = $r;
                                                        break;
                                        }
                                        $count++;
                                }
				// Get the link for program search
				$regionSearch = "pr=$region";
				if(strcmp($region, 'Asia') == 0){
					$regionSearch = 'pr=Asia%7F&pr=Middle East';
				}else if(strcmp($region,'Australia') == 0){
					$regionSearch = 'pr=Australia%2FPacific+Islands';
				}else if(strcmp($region,'Latin America') == 0){
					$regionSearch = 'pr=Central+America%7F&pr=South+America%7F&pr=West+Indies';
				}else if(strcmp($region,'Luxemberg-MUDEC') == 0){
					$regionSearch = 'p_10007=Luxembourg%7F&p_10007_t=MULTI';
				}
				$firstTerm = '';
				$secondTerm = '';
				if(strcmp($length,'long') == 0){
					$firstTerm = 'Fall';
					$secondTerm = 'Spring';
				}else{
					$firstTerm = 'Summer';
					$secondTerm = 'Winter';
				}
				$link = "http://miamioh-sa.terradotta.com/index.cfm?FuseAction=Programs.SearchResults&Program_Type_ID=1&$regionSearch%7F&pt=$firstTerm%7F&pt=$secondTerm%7F&&Sort=Program_Name&Order=asc&&pp=10007";
                        }
                }

	}
	else{
                $region = "Asia";
                $length = "long";
        }
	if($region == "Luxemberg-MUDEC"){
                $tuition = $progfee;
                $progfee = 0;
        }
?>



<html lang="en-US">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Miami Study Abroad Calculator</title>
    <link rel="shortcut icon" href="https://miamioh.edu/favicon.ico" >

    <link href="https://www.apps.miamioh.edu/courselist/vendor/MiamiTheme/css/style.min.css" rel="stylesheet">

    <!-- Page-specific CSS -->
        <style>#advancedSearch {
            display:  none ;
        }</style>

	<link href="css/universal.css" rel="stylesheet">
	<link href="css/multiple-select.css" rel="stylesheet">
    	<link href="css/jquery-ui.css" rel="stylesheet">
    	<link href="css/time-slider.css" rel="stylesheet">
    	<link href="css/main.css" rel="stylesheet">
    	<link href="css/datatables.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src = "http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
</head>
<body>
<div class="container">
    <div class="site-logo col-3">
        <a href="http://miamioh.edu">
            <h1>
                <img src="FSL_186K2_GI.jpg" alt="Miami University Logo" style="width:200%;height:200%;">
                <span class="sr-only">Miami University</span>
            </h1>
        </a>
    </div>
<main role="main">

        <form method="get" id="searchForm" name="searchForm">
            <input type="hidden" name="_token" value="3nZdccZgkcGC9iCYPNsAyHRBSa0G5bhS2tP2maZu">
            <div class="row">
                <div class="col-12">
                                          <!--  <a href="login" class="btn brand small" style="float:right;">Login</a>
                    --!>

                    <ul>
    </ul>

	<form name = "form2" id = "form2" class="form-horizontal" method = "get"  action="">
		<fieldset>
			<!-- Form Name -->
			<legend>Region and Term Selection</legend>
			<!-- Select Box-->
			<div class="form-group" style = "width: 50%; margin-top: 13px;">
				<label class="col-md-4 control-label" for="program">Program Region</label>  
				<div class="col-md-6">
					<select id="region" name = "region">
						<option value="" selected disabled hidden>Select One</option>
						<option value="Asia">Asia</option>
						<option value="Europe">Europe</option>
						<option value="Latin America">Latin America</option>
						<option value="Australia">Australia</option>
						<option value="Luxemberg-MUDEC">MUDEC (Luxembourg)</option>
					</select>
				</div>
			</div>
			<script type="text/javascript">
				document.getElementById("region").value = "<?php echo $region;?>";
			</script>
			<!-- Select Box-->
			<div class="form-group" style = "float: right; width: 50%">
				<label class="col-md-4 control-label" for="program">Program Length</label>  
				<div class="col-md-6">
					<select id="length" name = "length">
						<option value="long">Semester</option>
						<option value="short">Summer/Winter</option>
					</select>
				</div>
			</div>
			<script type="text/javascript">
                                document.getElementById("length").value = "<?php echo "$length";?>";
                        </script>
			</br>
			<!-- Input -->
			 <div class = "form-group">
				<div class = "col-md-4">
					<input type="submit" value="Submit">
				</div>
			</div>
		</fieldset>
	</form>
	<p></br></p>
	<form name = "form1" id = "form1" class="form-horizontal">
		<fieldset>
			<!-- Form Name -->
			<legend>Expense Calculator</legend>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="appfee">Application Fee</label>  
				<div class="col-md-4">
					<input id="appfee" name="appfee" placeholder="" class="form-control input-md" type="text" value = <?php echo $appfee; ?>>
					
			    		<span role="button" tabindex="0" class="applicationHelp" id="applicationFilterHelp" aria-expanded="false" aria-label="Application Help">
            				<!--<span class="fa fa-question-circle-o" aria-hidden="true"></span>-->
					<span class="help-block">This is the fee for applying to a program. This varies from program to program.</span> 
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="programfee">Program Fee</label>  
				<div class="col-md-4">
					<input id="programfee" name="programfee" placeholder="ex 90 -100" class="form-control input-md" type="text" value = <?php echo $progfee; ?>>
					<span class="help-block">The program fee is the fee for participating in the program; this often includes tuition and excursions.</span> 
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="tuition">Tuition</label>  
				<div class="col-md-4">
					<input id="tuition" name="tuition" placeholder="" class="form-control input-md" type="text" value = <?php echo $tuition; ?>>
					<span class="help-block">Tuition is often included in the program fee. Please check with the program to make sure.
						<?php 
							if($region == "Luxemberg-MUDEC" && $length == "long"){
								echo "For the MUDEC program this is your Miami tuition. This numebr is for instate students. Out of state students should use their tuition.";
							} 
							else if($region == "Luxemberg-MUDEC"){
								echo "For the MUDEC program this is your Miami tuition. This number depends solely on the number";
								echo " of hours you are taking. Please see an advisor for more information.";
							}
						?>
					</span> 
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="studyAbroadFee">Study Abroad Fee</label>  
				<div class="col-md-4">
					<input id="studyAbroadFee" name="studyAbroadFee" placeholder="" class="form-control input-md" type="text" value = <?php echo $studyabroadfee; ?>>
					<span class="help-block">The study abroad fee is charged by Miami for all students who study abroad.</span> 
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="passport">Passport and Student Visa Fees</label>  
				<div class="col-md-4">
					<input id="passport" name="passport" placeholder="" class="form-control input-md" type="text" value = <?php echo $passport; ?>>
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="immunizations">Immunizations</label>  
				<div class="col-md-4">
					<input id="immunizations" name="immunizations" placeholder="" class="form-control input-md" type="text" value = <?php echo $immunizations; ?>>
					<span class="help-block">Many destinations require special vaccinations. You can check with the CDC or Miami's travel nurse.</span> 
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="airfare">Airfare</label>  
				<div class="col-md-4">
					<input id="airfare" name="airfare" placeholder="" class="form-control input-md" type="text" value = <?php echo $airfare; ?>>
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="taxes">Entry and Exit Taxes</label>  
				<div class="col-md-4">
					<input id="taxes" name="taxes" placeholder="" class="form-control input-md" type="text" value = <?php echo $taxes; ?>>
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="food">Meals</label>  
				<div class="col-md-4">
					<input id="food" name="food" placeholder="" class="form-control input-md" type="text" value = <?php echo $food; ?>>
					<span class="help-block">Some programs include food and housing but some do not.</span> 
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="housing">Housing</label>  
				<div class="col-md-4">
					<input id="housing" name="housing" placeholder="" class="form-control input-md" type="text" value = <?php echo $housing; ?>>
					<span class="help-block">Some programs include food and housing but some do not. Please check with your program for more details.</span>
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="insurance">Health insurance</label>  
				<div class="col-md-4">
					<input id="insurance" name="insurance" placeholder="" class="form-control input-md" type="text" value = <?php echo $insurance; ?>>
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="transport">Local transport</label>  
				<div class="col-md-4">
					<input id="transport" name="transport" placeholder="" class="form-control input-md" type="text" value = <?php echo $transport; ?>>
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="personal">Personal expenses</label>  
				<div class="col-md-4">
					<input id="personal" name="personal" placeholder="" class="form-control input-md" type="text" value = <?php echo $personal; ?>> 
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="Other">Other</label>  
				<div class="col-md-4">
					<input id="Other" name="Other" placeholder="" class="form-control input-md" type="text" value = <?php echo $other; ?>>
				</div>
			</div>
			<!-- Text input-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="scholarships">Scholarships</label>
				<div class="col-md-4">
					<input id="scholar" name="scholar" placeholder ="" class = "form-control input-md" type="text" value = <?php echo $scholarships; ?>>
					<span class="help-block">Some scholarships can be applied to study abroad programs as well as normal tuition. Please check with the study aborad office to confirm.</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label" for="total">Total</label>  
				<div class="col-md-4">
					<input id="total" name="total" placeholder="" class="form-control input-md" type="text">
				</div>
			</div>
		</fieldset>
	</form>
	<div class="col-md-4"></div>
	<div class="col-md-8">
		<button id= "btn" name = "btn" style = "color: white;">Calculate</button><br /><br />
		<section class="col-sm-6 doubleBorder">
			<div><div><div class="componentContainer componentRichText">
				<h2 class="componentHeader componentHeaderAlt hide-for-small">Schedule Advising</h2>
				<p>Schedule an appointment with one of our advisors to discuss your study abroad or away options.</p>
				<a class="redButton" href='https://miamioh.campus.eab.com/student/appointments/new'>Schedule Now</a>
			</div></div></div>
		</section>
	</div>
	<!--Add url to program search here-->
<?php if(isset($link)): ?>
	<p>You can look up programs in your chosen region and term at <a href="<?php echo $link?>"><?php echo $link?></a></p>
<?php endif ?>
	</main>
</div>
	<script>
		function calc(){
			var to = 0;
			to += parseInt($('#appfee').val(), 10);
			to += parseInt($('#programfee').val(), 10);
			to += parseInt($('#tuition').val(), 10);
			to += parseInt($('#studyAbroadFee').val(), 10);
			to += parseInt($('#passport').val(), 10);
			to += parseInt($('#immunizations').val(), 10);
			to += parseInt($('#airfare').val(), 10);
			to += parseInt($('#taxes').val(), 10);
			to += parseInt($('#food').val(), 10);
			to += parseInt($('#housing').val(), 10);
			to += parseInt($('#insurance').val(), 10);
			to += parseInt($('#transport').val(), 10);
			to += parseInt($('#Other').val(), 10);
			to += parseInt($('#personal').val(), 10);
			to = to - parseInt($('#scholar').val(), 10);
			$('#total').val(to);
		}
		
		$(document).ready(function(){
			
			$("#form1").validate({
				rules:{
		
					appfee: {
						required: true,
						number: true
		                     
					},
		  			programfee: {
						required: true,
						number: true
		
					},
					tuition: {
						required: true,
						number: true
		
					},
					studyAbroadFee: {
						required: true,
						number: true
		
					},
					passport: {
						required: true,
						number: true
		
					},
					immunizations: {
						required: true,
						number: true
		
					},
					airfare: {
						required: true,
						number: true
		
					},
					taxes: {
						required: true,
						number: true
		
					},
					food: {
						required: true,
						number: true
		
					},
					housing: {
						required: true,
						number: true
		
					},
					insurance: {
						required: true,
						number: true
		
					},
					transport: {
						required: true,
						number: true
		
					},
					Other: {
						required: true,
						number: true
		
					},
					personal: {
						required: true,
						number: true
		
					},
					scholar: {
						required: true,
						number: true
		
					}
				}
			})
			
			$("#btn").click(function(e){
				e.preventDefault();
				if($("#form1").valid()){
					calc();
				}
			});
		          
		});
	</script>
</body>
