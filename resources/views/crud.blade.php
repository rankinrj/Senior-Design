<?php
session_start();
$message='';
//include "creds.php";
$user='root';
$password='StudyAbroad2018';
$database='studycost';
@$mysqli=new mysqli("localhost",$user,$password,$database);
if ($mysqli->connect_errno) {
        die("Can't connect to db");
};
if(isset($_REQUEST['expend']) && isset($_REQUEST['cost']) && isset($_REQUEST['region']) && isset($_REQUEST['term']) && is_numeric($_REQUEST['cost'])){
        $expend = htmlspecialchars($_REQUEST['expend']);
	$cost = htmlspecialchars($_REQUEST['cost']);
	$region = htmlspecialchars($_REQUEST['region']);
	$term = htmlspecialchars($_REQUEST['term']);
	if(strcmp($expend,'other') != 0){
        	$q="UPDATE programs SET $expend='$cost' WHERE region='$region' AND length='$term';";
	        $r=$mysqli->query($q);
        	if ($r==null){
			$message='error';
	        }else{
        	        $message='Updated';
	        }
	}else{
		if(isset($_REQUEST['new'])){
			$new = htmlspecialchars($_REQUEST['new']);
			$q="ALTER TABLE programs ADD $new INTEGER(11);";
			$r=$mysqli->query($q);
        		if ($r==null){
				$message='error';
		        }else{
        		        $newQuery="UPDATE programs SET $new='$cost' WHERE region='$region' AND length='$term';";
				$res=$mysqli->query($newQuery);
        			if ($res==null){
					$message='error';
	        		}else{
		        	        $message='Updated';
	        		}
	        	}
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Update Values</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<style>
/* Remove the navbar's default margin-bottom and rounded borders */
.navbar {
        margin-bottom: 0;
        border-radius: 0;
}

/* Set height of the grid so .sidenav can be 100% (adjust as needed) */
.row.content {height: 450px}

/* Set gray background color and 100% height */
.sidenav {
        padding-top: 20px;
        background-color: #f1f1f1;
height: 100%;
}

/* Set black background color, white text and some padding */
footer {
        background-color: #555;
color: white;
padding: 15px;
}

/* On small screens, set height to 'auto' for sidenav and grid */
@media screen and (max-width: 767px) {
        .sidenav {
height: auto;
padding: 15px;
        }
        .row.content {height:auto;}
}
th, td{
	border: 1px solid black;
	padding: 5px;
}
</style>
</head>
<body>

<nav class="navbar navbar-inverse">
<div class="container-fluid">
<div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
</div>
<div class="collapse navbar-collapse" id="myNavbar">
<ul class="nav navbar-nav">
</ul>
<ul class="nav navbar-nav navbar-right">
</ul>
</div>
</div>
</nav>

<div class="container-fluid text-center">
<div class="row content">
<div class="col-sm-2 sidenav">
</div>
<div class="col-sm-8 text-left">
<div class="container">
<div class="jumbotron">Update Value Form</div>
</div>

<div id="result">
        <form method='post' action="">
		Region <select name="region">
			<option value="Asia">Asia</option>
			<option value="Europe">Europe</option>
			<option value="Latin America">Latin America</option>
			<option value="Australia">Australia</option>
			<option value="Luxemberg-MUDEC">MUDEC (Luxembourg)</option>
		</select><br />
		Term <select name = "term">
			<option value="long">Semester</option>
			<option value="short">Summer/Winter</option>
		</select><br />
                Expenditure <select name='expend'>
			<?php
				$q="SELECT * from programs;";
				$r=$mysqli->query($q);
				if ($r==null){
					print('error');
				}else{
					$row = $r->fetch_assoc();
					foreach($row as $key=>$value){
						$comp = strcmp($key,'id') != 0 && strcmp($key,'region') != 0 && strcmp($key,'length') != 0;
						if($comp){
							print("<option value='$key'>$key</option>");
						}
					}
				}
			?>
		<option value='other'>New Expenditure</option>
		</select><br />
		Other <input type='text' name='new'></input><br />
		Cost <input type='text' name='cost'></input>
                <input type='submit' name='submit' value='submit'>
        </form>
        <?php
                print("$message<br >");
	?>
	<?php
                $q="SELECT * from programs;";
                $r=$mysqli->query($q);
                if ($r==null){
			print('error');
                }else{
			$i = 0;
			print('<table>');
			while($row = $r->fetch_assoc()){
				print('<tr>');
				if($i == 0){
					foreach($row as $key=>$value){
						print("<th>$key</th>");
					}
					print('</tr><tr>');
				}
				foreach($row as $key=>$value){
					print("<td>$value</td>");
				}
				print('</tr>');
				$i += 1;
			}
			print('</table>');
		}
        ?>
</div>
</div>
</div>
</div>
</body>
</html>

