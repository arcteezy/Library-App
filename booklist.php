<!-- Book List Page -->

<?php
    $servername = "localhost";
	$dbusername = "gravity";
	$dbpassword = "gravity";
	$db = "library";

	// Create connection
	$conn = new mysqli($servername, $dbusername, $dbpassword,$db);
	// Get Author names
	$sql = "SELECT authorid, name FROM authors";
	$result = $conn->query($sql);
	$authors = [];
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$authors[] = [$row['authorid'],$row['name']];
		}
	}
?>

	<html>
	<head>
		<title>
			Library
		</title>

		<!-- Adding Bootstrap -->
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
		  	<a href="booklist.php" class="noline mylink"><h5>Books</a>
		  	<a href="authorlist.php" class="noline mylink">Authors</h5></a>
		  </span> 
		</div>

		<!-- Body -->
		<div class="bodypadd">
			<div class="heading">
				<p>Books</p>
			</div>
			
			<!-- Book List -->	
			<div style="display: flex;">
				<div style="flex: 7;">
					<ul>
							<?php
								// Retrieving book details
								$sql = "SELECT bookid, bookname, authorid, isbn, description FROM books";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
								    while($row = $result->fetch_assoc()) {
								    	// Display details
								        echo "<li class='card' style='padding-top:20px'>
								        		<div style='display:flex;'>
								        			<div style='flex:1;'>
								        				<img src='images/book.png'>
								        			</div>
								        			<div style='flex:13;'>	
											        		<a href='bookview.php?id=".$row["bookid"]."' class='noline' >
												        			<div style='display:flex;'><h5 style='flex:1'>". $row["bookname"]. "</h5><h5>ISBN : ". $row["isbn"]."</h5></div>
												        			<p>By " ;
												        			$name = '';
												        			foreach($authors as $author) {
												        			 if($row["authorid"] == $author[0]) {
												        			 	$name = $author[1];
												        			 	break;
												        			 }
												        			}
												        			echo $name."</p>
												        			<p>".$row["description"]."</p>
											        		</a>
											        </div>		
									        	</div>	
								        	</li>";
								    }
								} else {
								    echo "No Books";
								}

							?>
					</ul>
				</div>

				<!-- Modal -->
				<div style="flex: 2;">
					<button type="button" class="btn add-btn btn-lg" data-toggle="modal" data-target="#myModal" >Add Book</button>
					<div id="myModal" class="modal fade" role="dialog">
					  <div class="modal-dialog">

					    <!-- Modal content-->
					    <div class="modal-content" align="center">
					      <div class="modal-header">
					      	<h6 class="modal-title">Add Book</h6>
					        <button type="button" class="close" data-dismiss="modal">&times;</button>
					      </div>
					      <div class="modal-body">
					        <form action="booklist.php" method="post">
								<input type="text" name="bookname" placeholder="Book Name" /><br>
								Select Author
								<select name="author" placeholder="Author" >
									<?php
									foreach ($authors as $author) {
										echo "<option value=".$author[0].">".$author[1]."</option>";
									}
									?>
								</select><br>
								<input type="text" name="isbn" placeholder="ISBN Number" /><br>
								<input type="text" name="description" placeholder="Description" /><br>
								<button type="button" data-dismiss="modal" class="btn add-btn btn-md">Cancel</button>
					        	<button type="submit" name="savebook" class="btn add-btn btn-md">Save Book</button>
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


<!-- Adding New Book to database -->
<?php
if (isset($_POST['savebook'])) 
{

	$bookname = $_POST['bookname'];
	$author = $_POST['author'];
	$isbn = $_POST['isbn'];
	$description = $_POST['description'];

	$sql = "INSERT INTO books (bookname, authorid, isbn, description) VALUES ('$bookname', '$author', '$isbn', '$description')";

	$conn->query($sql);
    unset($_POST);
	
}
?>