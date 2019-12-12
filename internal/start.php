<?php 
$sql = "select * from v_best_sellers";
if( $stmt = $mysqli->prepare($sql) ) {
	$stmt->execute();
	$bestSellers = $stmt->get_result();
}

$sql = "select * from v_new_books";
if( $stmt = $mysqli->prepare($sql) ) {
	$stmt->execute();
	$newBooks = $stmt->get_result();
}
require "menuleft.php";
?>
<br>
<br>
<div class="row m-0">
	<div class="col-12 col-md-6 mb-5 mb-md-0">
		<div class="text-center h3">New Books</div>
	<?php if(isset($newBooks) && $newBooks->num_rows > 0):?>
		<div id="carouselNewBooks" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
			<?php
				$index = 0;
				while ($row = $newBooks->fetch_assoc()) {
					$active = (!$index)?'active':'';
					echo "
					<a class='carousel-item $active' href='index.php?p=productinfo&pid=$row[id]'>
						<div class='img-container'>
						<div class='img-container-text'>$row[title]</div>
							<img src='./img/$row[img]' class='d-block w-100' alt='$row[title]'>
						</div>
					</a>
					";
					$index++;
				}
			?>
			</div>
			<a class="carousel-control-prev" href="#carouselNewBooks" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselNewBooks" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	<?php else:?>
		<div class="text-center">No new books yet!</div>
	<?php endif;?>
	</div>
	<div class="col">
		<div class="text-center h3">Best Sellers!</div>
	<?php if(isset($bestSellers) && $bestSellers->num_rows > 0):?>
		<div id="carouselBestSellers" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
			<?php
				$index = 0;
				while ($row = $bestSellers->fetch_assoc()) {
					$active = (!$index)?'active':'';
					echo "
					<a class='carousel-item $active' href='index.php?p=productinfo&pid=$row[id]'>
						<div class='img-container'>
						<div class='img-container-text'>$row[title]</div>
							<img src='./img/$row[img]' class='d-block w-100' alt='$row[title]'>
						</div>
					</a>
					";
					$index++;
				}
			?>
			</div>
			<a class="carousel-control-prev" href="#carouselBestSellers" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselBestSellers" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	<?php else:?>
		<div class="text-center">No sells yet!</div>
	<?php endif;?>
	</div>
</div>