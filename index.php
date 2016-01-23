<?php
include("search.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Zillow Search</title>
		<link rel="stylesheet" type="text/css" href="resources/main.css"/>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	</head>
	<body>
		<div id="main-container">
			<div class="container">
				<form id="search-form" class="search-form" action="" method="POST">
					<h3>Search a home</h3>
					<input name="address" placeholder="Address"/>
					<input name="city_state_zip" class="medium" placeholder="City, State, Zip"/>
					<input name="search_submit" type="submit" value="Submit" />
				</form> 
			</div>
			
			<div class="container search-result">
				<?php if( ! empty($result) ): ?>
					<?php if($result["code"] != 0): ?>
						<div class="error-message">
							<?php echo $result["message"] ?>
						</div>
					<?php else: ?>
						<div class="result">
							<img src="<?php echo $result["photo"] ?>" />
							
							<div class="result-detail">
								<p>Address: <?php echo $result["address"] ?></p>
								<p>Estimated Price: <?php echo "$". number_format( floatval($result["estimate"]), 2 ) ?></p><br/><br/>
								<p><a class="btn" href="<?php echo $result["details"] ?>" target="blank">Continue to Zillow for detailed infomation</a></p>
							</div>
						</div>
					<?php endif; ?>			
				<?php elseif( ! empty($_POST) ): ?>
					<div class="invalid-search">
						There was a problem during the search process. <br/>
						Make sure the <b>address, city and state</b> are entered.
					</div>
				<?php endif; ?>
			</div>
		</div>
	</body>
</html>