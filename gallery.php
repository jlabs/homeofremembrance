<?php 
	$page_action = '<button style="margin-top: 7px;" class="btn" data-toggle="modal" data-target="#myModal">Upload to gallery</button>';
	
	@include("header.php");

	$pageTitle = "Home of Remembrance - About Me";

	// load the diary class
	require_once("classes/Gallery.php");
	$gallery = new Gallery();
?>

<div class="container">
	<!-- errors & messages --->
	<?php
		// show negative messages
		if ($gallery->errors) 
		{
			foreach ($gallery->errors as $error) 
			{
				echo "<div class='alert alert-danger alert-dismissable'>".$error."<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button></div>";
			}
		}
		// show positive messages
		if ($gallery->messages) 
		{
			foreach ($gallery->messages as $message) 
			{
				echo "<div class='alert alert-success alert-dismissable'>".$message."<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button></div>";
			}
		}
	?>      	
</div>

<!--Main content area-->
<div class="container">
	<div class="row">
		<?php
			
			$gallery_images = array();
			$gallery_images = $gallery->getGallery();
			
			if (is_array($gallery_images))
			{
	  		if ($gallery_images != "null" || $gallery_images != "na")
	  		{      		
		  		foreach ($gallery_images as $row)
		  		{	      		
					?>		      			
						<div class="galleryPanel">
						    <div class="thumbnail">
						    	<a href="<?php echo $row['url']; ?>" rel="prettyPhoto[pp_gal]" title="<?php echo $row['title']; ?>">
									<img name="image" 
										class="img-rounded galleryThumbnail"
										src="<?php echo $row['url']; ?>"
										data-toggle="modal" 
										data-target="#myModal"
										alt="<?php echo $row['title']; ?>" />
								</a>
								<div class="caption">
						        	<p><?php echo $row['title']; ?></p>
									<form class="" role="form" method="post" action="gallery.php">
								    	<div class="btn-group" style="margin-bottom: 15px;">
											<button class="btn-edit" type="button" name="edit" disabled>Edit</button>								        											<button class="btn-delete" type="button" name="delete">Delete</button>	
								    	</div>
										<button class="btn btn-default btn-lg btn-block" type="submit" name="profile">Make Profile Pic</button>								
										<input type="hidden" name="image_id" value="<?php echo $row['image_id']; ?>">
										<input type="hidden" name="url" value="<?php echo $row['url']; ?>">
									</form>
								</div>
						    </div>
						</div>	
		      		<?php		      		
	      		}	      		
	  		}      	
	  	}
		?>
	</div>
</div>
      
      
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form class="" enctype="multipart/form-data" action="gallery.php" name="ImageUpload" id="ImageUpload" method="post">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h4 class="modal-title" id="myModalLabel">Upload your images</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="inputPhotoFile" class="col-lg-4 control-label">Select a photo</label>
						<div class="col-lg-8">
							<!--<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />-->
							<input type="file" id="inputPhotoFile" multiple accept='image/*' name="image[]">
							<!-- <p class="help-block">JPG is recommended</p> -->
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn-add" name="add_image">Add</button>
					<button type="button" class="btn-close" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</form>
</div>
<!-- /modal -->      
      
<?php @include("footer.php"); ?>