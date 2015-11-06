<!DOCTYPE html>
<html lang='en'>
<head>
<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
<div class='container'>
<?php

try {
	//127.0.0.1 = localhost
	$dbh = new PDO("mysql:host=localhost;dbname=movieReviews;", "developer", "password");

	$stmt = $dbh->prepare("select * from reviews
	inner join genre on genre.genreId = reviews.reviewgenreId
	inner join type on type.id = reviews.typeId;");
	$stmt->execute();

	if($stmt->rowCount()) {
		echo "<strong>Total Reviews:</strong> {$stmt->rowCount()}"; ?>

		<div class='settings'>
			<a href='addReview.php'><img src='images/add.png' /></a>
		</div>


		<?php
		

		while($row = $stmt->fetch()) {
			echo "<p class='eachReview'>
				<img src='images/artwork/{$row['artwork']}' class='artwork' /><br />
				<h1>{$row['movieTitle']}</h1>
				<strong>Genre:</strong> {$row['genreName']} 
				<strong>Type:</strong> {$row['type']}
				<strong>Rating: </strong> ";

				if($row['ratingId'] == 5) {
					echo "<img src='images/star.png' /><img src='images/star.png' /><img src='images/star.png' /><img src='images/star.png' /><img src='images/star.png' />";
				} else if($row['ratingId'] == 4) {
					echo "<img src='images/star.png' /><img src='images/star.png' /><img src='images/star.png' /><img src='images/star.png' />";
				} else if($row['ratingId'] == 3) {
					echo "<img src='images/star.png' /><img src='images/star.png' /><img src='images/star.png' />";
				} else if($row['ratingId'] == 2) {
					echo "<img src='images/star.png' /><img src='images/star.png' />";
				} else if($row['ratingId'] == 1) {
					echo "<img src='images/star.png' />";
				}

				echo "<br />
				<span class='review'>{$row['reviewText']}</span></p>";
		}

		
	} else {
		echo "No reviews currently available.";
		die();
	}
	
} catch (PDOException $e) {
	echo $e->getMessage();
}

?>
</div>

</body>
</html>
