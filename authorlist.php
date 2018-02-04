<!-- Author List Page -->

<?php
    $servername = "localhost";
	$dbusername = "gravity";
	$dbpassword = "gravity";
	$db = "library";

	// Create connection
	$conn = new mysqli($servername, $dbusername, $dbpassword,$db);

?>

	<html>
	<head>
		<title>
			Library
		</title>

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

		<!-- CSS -->
		<link rel="stylesheet" href="booklist.css">
	</head>
	<body>

		<!-- Navigation Bar -->
		<div class="navbar">
		  <span>
		  	<h2>Library.</h2>
		  </span>
		  <span class="navbarlink">
		  	<a href="booklist.php" class="noline mylink"><h5>Books </a>
		  	<a href="authorlist.php" class="noline mylink"> Authors</h5></a>
		  </span>  
		</div>	

		<!-- Body content -->
		<div class="bodypadd">
				<div class="heading">
					<p>Authors</p>
				</div>

				<!-- Author list -->
				<div style="display: flex;">
					<div style="flex: 7;">
						<ul>
								<?php
									// Retreive author details
									$sql = "SELECT authorid, name, age, gender, born, about FROM authors";
									$result = $conn->query($sql);
									if ($result->num_rows > 0) {
									    while($row = $result->fetch_assoc()) {
									    	// Display authors
									        echo "<li class='card' style='padding-top:20px'>
									        	<div style='display:flex;'>
								        			<div style='flex:1;'>
								        				<img src='images/pen.png'>
								        			</div>
								        			<div style='flex:13;'>	
												        	<a href='authorview.php?id=".$row["authorid"]."' class='noline' ><h5>". $row["name"]. " </h5><p>Age : " . $row["age"]. "</br>";
													        switch ($row["gender"]) {
													        	case 1:
													        		$gender = "Male";
													        		break;
													        	case 2:
													        		$gender = "Feale";
													        		break;
													        	
													        	default:
													        		$gender = "Other";
													 
													        }    
										        			echo $gender."</br>Born in " .$row["born"]."</p><p>" .$row["about"]."</p></a>
										        	</div>
										        </div>			
									        </li>";
									    }
									} 
									else {
									    echo "No Authors";
									}

								?>
						</ul>
					</div>

					<!-- Add author modal -->
					<div style="flex: 2;">
						<button type="button" class="btn add-btn btn-lg" data-toggle="modal" data-target="#myModal">Add Author</button>
						<div id="myModal" class="modal fade" role="dialog">
						  <div class="modal-dialog">

						    <!-- Modal content-->
						    <div class="modal-content" align="center">
						      <div class="modal-header">
						      	<h6 class="modal-title">Add Author</h6>
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						      </div>
						      <div class="modal-body">
						        <form action="authorlist.php" method="post">
									<input type="text" name="name" placeholder="Name" /><br>
									<input type="text" name="age" placeholder="Age" /><br>
									<span>Gender</span>
									<select name="gender">
										<option value="1">Male</option>
										<option value="2">Female</option>
										<option value="3">Other</option>
									</select><br>
									<input type="text" name="born" placeholder="Born" /><br>
									<input type="text" name="about" placeholder="About" /><br>
									<button type="button" data-dismiss="modal" class="btn add-btn btn-md">Cancel</button>
						        	<button type="submit" name="saveauthor" class="btn add-btn btn-md">Save</button>
								</form>
						      </div>
						    </div>

						  </div>
						</div>

					</div>	
				</div>
		</div>		
		
	</body>
	</html>

<!-- Adding new author to database -->
<?php
if (isset($_POST['saveauthor'])) 
{

	$name = $_POST['name'];
	$age = $_POST['age'];
	$gender = $_POST['gender'];
	$born = $_POST['born'];
	$about = $_POST['about'];

	$sql = "INSERT INTO authors (name, age, gender, born, about) VALUES ('$name', '$age', '$gender', '$born', '$about')";

	if ($conn->query($sql) === TRUE) {
    unset($_POST);
	} 
}
?>