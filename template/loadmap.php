<?php 
	@include("parts/header.php"); 
?>
<div class="container" id="container">
	<div class="col-sm-3" id="sidebar">
		<div class="sidebar_menu">
			<ul>
				<?=$data["left_menu"]?>
			</ul>
		</div>
	</div>
	<div class="col-sm-9" id="content">
		<iframe src="http://trade.404.ge/_plugins/jvectormap/index.php" style="margin:0; padding:0; border:0; overflow:hidden; width:100%; height:660px"></iframe>
	</div>
</div>
<?php @include("parts/footer.php"); ?>