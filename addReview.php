<?php


if($_SERVER['REQUEST_METHOD'] === 'POST') {

	$uploaddir = 'images/artwork/';
	$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);

	if($_FILES['userfile']['type'] == "image/jpeg") {

		if(move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
		echo "File is valid and was successfully uploaded! <a href='activity1-4.php'>Upload another?</a><br />";
		echo "<img src='".$uploadfile."' />";
		} else  {
			echo "Possible file upload attack!<br />";
		}

	} else {
		echo "This upload form ONLY supports JPEG files! Please upload a JPEG file: <a href='activity1-4.php'>Try again!</a>";
	}

	try {
	$dbh = new PDO("mysql:host=localhost;dbname=movieReviews;", "developer", "password");

	$stmt = $dbh->prepare("insert into reviews (movieTitle, reviewText, artwork) values (?, ?, ?)");

	$stmt->bindParam(1, $movieTitle);
	$stmt->bindParam(2, $reviewText);

	$movieTitle = $_POST['movieTitle'];
	$reviewText = $_POST['movieReview'];
	$stmt->execute();

		if($stmt) {
			echo "Review has been added!";
		} else {
			echo "Something went wrong...";
		}

	} catch (PDOException $e) {
		echo $e->getMessage();
	}

} else {
	echo "<form action='' method='POST' enctype='multipart/form-data'>";
	echo "<input type='text' name='movieTitle' size='45' placeholder='Movie or TV Show Title' required /><br />";
	echo "<textarea name='movieReview' placeholder='Write your review here...' cols='41' rows='8' required></textarea><br />";
	echo "<input type='file' name='fileToUpload' id='fileToUpload'><br />";
	echo "<input type='submit' value='Add Review' required/><br />";
	echo "</form>";
}







?>