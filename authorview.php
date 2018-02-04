<!-- Author Details -->

<?php
	$servername = "localhost";
	$dbusername = "gravity";
	$dbpassword = "gravity";
	$db = "library";
	// Create connection
	$conn = new mysqli($servername, $dbusername, $dbpassword,$db);
?>

<!DOCTYPE html>
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
		  	<h5><a href="booklist.php" class="noline mylink">Books </a>
		  	<a href="authorlist.php" class="noline mylink"> Authors</h5></a>
		  </span>  
		</div>

		<!-- Body content -->
		<div class="bodypadd2" >	
				<div>
					<p><a href="authorlist.php" class="noline" style="color: #787878">Authors</a> / Details</p>
				</div>

				<!-- Author details -->
				<div class="carddisp">
					<div>
						<?php
							// Retreive author details
							$aid=$_GET['id'];
							$sql = "SELECT authorid, name, age, gender, born, about FROM authors WHERE authorid='$aid'";
							$result = $conn->query($sql);
							$row = $result->fetch_assoc();
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
							echo "<h5><img src='images/pen.png'>".$row["name"]. "</h5><p>Age : " . $row["age"]. "</br>" . $gender."</br>Born in " .$row["born"]."</p><p>" .$row["about"]."</p>";
						?>	
					</div>		
					<div>
							<!-- Display books under author -->
							<ul>
									<?php
										$sql = "SELECT bookid, bookname, authorid, isbn, description FROM books WHERE authorid='$aid'";
										$result = $conn->query($sql);
										if ($result->num_rows > 0) {
										    while($row = $result->fetch_assoc()) {
										        echo "<li class='card'>
										        		<a href='bookview.php?id=".$row["bookid"]."' class='noline' style='padding-top:20px'>
										        			<div style='display:flex;'><h5 style='flex:1'> <img src='images/book.png'>". $row["bookname"]. "</h5><h5>ISBN : ". $row["isbn"]."</h5></div>
										        			<p>".$row["description"]."</p>
										        		</a>
										        	</li>";
										    }
										} 
										else {
										    echo "No Books";
										}
									?>
							</ul>
					</div>
				</div>	
		</div>		
</body>
</html>