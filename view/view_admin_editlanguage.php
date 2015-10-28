<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title><?=$data["website_title"]?></title>
	<link href="<?=STYLES?>reset.css" type="text/css" rel="stylesheet" /> 
	<link href="<?=PLUGINS."font-awesome-4.3.0/css/font-awesome.css"?>" type="text/css" rel="stylesheet" />
	<link href="<?=STYLES?>en.css" type="text/css" rel="stylesheet" /> 
	<link href="<?=STYLES?>general.css" type="text/css" rel="stylesheet" /> 
	<script src="<?=SCRIPTS?>jquery-1.11.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?=SCRIPTS?>javascript.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?=SCRIPTS?>drop.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="<?=PLUGINS?>jquery-ui-1.11.4.custom/jquery-ui.css">
	<script src="<?=PLUGINS?>jquery-ui-1.11.4.custom/jquery-ui.js"></script>
</head>
<body>
	<?php
	@include("view/parts/header.php");
	?>
	<main>
		<div class="center">
			<?php
			@include("view/parts/breadcrups.php");
			?>
			<div class="content">

				<?php
				if(!empty($data["outMessage"]) && $data["outMessage"]==1){
				?>
					<div class="success message" onclick="hideMe('.message')">
					  <h2>Success</h2>
						<p>Data updated !</p>
					</div>
				<?php
				}
				if(!empty($data["outMessage"]) && $data["outMessage"]==2){
				?>
					<div class="error message" onclick="hideMe('.message')">
					  <h2>Error</h2>
						<p>Something went wrong !</p>
					</div>
				<?php
				}
				?>

				<form action="" method="post" class="my-form hundredPorsent" autocomplete="off">
					<div class="from-header" style="color:#ef4836; text-transform:uppercase">Edit language</div>
					
					<label for="name">Name: <font color="RED">*</font></label>
					<input type="text" name="name" id="name" value="<?=$data["info"]["text"]?>" autocomplete="off" />

					<label for="slug">slug (length: 2): <font color="RED">*</font></label>
					<input type="text" name="slug" id="slug" value="<?=$data["info"]["langs"]?>" autocomplete="off" disabled="disabled" />

					<label for="backgroundImage">Image:</label><br />
					<input type="hidden" name="background" id="background" value="" />
					<div class="dragableArea">
						<h3>Drag and drop image (jpeg,jpg,gif,png)</h3>
						<div id="progress-bar"></div>
					</div><br />
					<div id="img">
						<?php
						if($data["info"]["lang_img"]!="false" && !empty($data["info"]["lang_img"])){
							echo '<img src="/'.$data["info"]["lang_img"].'" />';
						}else{
							echo '<p>No Image</p>';
						}
						?>
					</div>
					<div class="clearfix"></div>

					
					<input type="submit" name="edit_language" id="submit" value="Submit"><br>
				</form>
			</div>
		</div>
	</main>
	<div class="clearfix"></div>
	<?php
	@include("view/parts/footer.php");
	?>
</body>
</html>