<?php 
	$page_action = '<button type="button" style="margin-top: 7px;" class="btn-action" data-toggle="modal" data-target="#addBucketModal">Add a bucketlist</button>';
	$pageTitle = "About Me"; 
	
	@include("header.php");
	
	require_once("classes/BucketList.php");
	
	$bucketlist = new BucketList();
	$bucketlist_items = array();
	$bucketlist_items = $bucketlist->getBucketList();
	
	$keys = array_keys($bucketlist_items);
	$iterations = count($bucketlist_items[$keys[0]]);
	$collapsecount = 0;

?>

<div class="container">
<?php	
	// show negative messages
	if ($bucketlist->errors) {
		foreach ($bucketlist->errors as $error) 
		{
			echo "<div class='alert alert-danger'>".$error."<button type='button' class='close' aria-hidden='true'>&times;</button></div>";    
		}
	}
	// show positive messages
	if ($bucketlist->messages) {
		foreach ($bucketlist->messages as $message) 
		{
			echo "<div class='alert alert-success'>".$message."<button type='button' class='close' aria-hidden='true'>&times;</button></div>";
		}
	}
?>     

<?php


for($i = 0; $i < $iterations; $i++) {

    $data = array();
    
    $collapsecount++;
        
    foreach($bucketlist_items as $key => $value) {
        $data[$key] = $value[$i];
    }
    
    $milestone_keys = array_keys($data['milestones']);
	$milestone_count = count($milestone_keys);
    
    //if the bucketlist array contains bucketlists
    if (!empty($data['buckets']))
    {
    	//print_r($data['buckets']['title']);		
		
		//html for showing the bucketlist item	
		?>
		
		
<form class="" role="form" method="post" action="bucketlist.php">				
	<div class="panel-group" id="accordion">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title" id="bucket_title<?php echo $data['buckets']['bucket_id']; ?>"><?php echo $data['buckets']['title']; ?></h4>
				<!--
				<h5>
					ID <?php echo $data['buckets']['bucket_id']; ?>
				</h5>
				-->
			</div>
			<div class="panel-body">    	
				<input type="hidden" name="bucket_id" value="<?php echo $data['buckets']['bucket_id']; ?>">
				<p id="bucket_body<?php echo $data['buckets']['bucket_id']; ?>"><?php echo $data['buckets']['body']; ?></p>
				<p id="bucket_completed<?php echo $data['buckets']['bucket_id']; ?>"><?php if ($data['buckets']['completed']==1) echo "Completed";	?></p>
			</div>
			
		
<?php			

	if (!empty($data['milestones']))
	{
	?>
			<!-- progress bar for the bucketlist item -->
			<div class="progress progress-striped active">
				<div class="progress-bar" style="width: 45%"></div>
			</div>
			<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $collapsecount; ?>" style="padding:15px;">
				Show Milestones <span class="badge"><?php echo $milestone_count; ?></span>
			</a>      
			<!-- for default opened view use <div id="collapseOne" class="panel-collapse collapse in"> -->
			<div id="collapse<?php echo $collapsecount; ?>" class="panel-collapse collapse">
				<table class="table">		  
					<thead>
						<tr>
							<th>Milestone</th>
							<th>Completed</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>		
	<?php  		
		for($c = 0; $c < $milestone_count; $c++)
		{
			?>
			<tr>
				<td>
					<p id="milestone_text<?php echo $data['milestones'][$c]['milestone_id']; ?>"><?php echo $data['milestones'][$c]['milestone']; ?></p>
				</td>
				<td>
					<?php 
						if (!empty($data['milestones'][$c]['reached'])) 
						{ 
							echo $data['milestones'][$c]['reached']; 
						} 
						else 
						{ 
							echo 'Add Reached';  
						} 
					?>
				</td>
				<td>
					<button class="btn-edit"
							type="button"
							name="edit"
							title="edit" 
							data-toggle="modal" 
							data-target="#editMilestoneModal" 
							onclick="milestoneIDForEditModal(<?php echo $data['milestones'][$c]['milestone_id']; ?>)">
							Edit
					</button>
					<button class="btn-delete"
						type="button"
						name="deleteMilestone"
						title="deleteMilestone"
						data-toggle="modal"
						data-target="#deleteMilestoneModal"
						onclick="milestoneIDforDeleteModal(<?php echo $data['milestones'][$c]['milestone_id']; ?>)">
						Delete
					</button>
				</td>
			</tr>
<?php
	
		} 
		?>
					</tbody>
				</table>
			</div>
		<?php
	}

?>		
		
					
			<!-- end of collapse -->
			<div class="panel-footer">
				<div class="bucketListItemMenu">
					<button class="btn-edit"
						type="button"
						name="edit"
						title="edit" 
						data-toggle="modal" 
						data-target="#editbucketModal" 
						onclick="bucketIDForEditModal(<?php echo $data['buckets']['bucket_id']; ?>)">
						Edit Bucketlist
					</button>					
					<button class="btn-close" 
						type="button" 
						name="delete" 
						title="Delete"
						data-toggle="modal"
						data-target="#deleteBucketModal"
						onclick="bucketIDforDeleteModal(<? echo $data['buckets']['bucket_id']; ?>)">
						Delete Bucketlist
					</button>
				</div>
				<?php
					// if there's 5 milestones then remove the button	
					if ($milestone_count < 5)
					{
						?>
							<button type="button"
								class="btn-add" 
								data-toggle="modal" 
								data-target="#addMilestoneModal" 
								onclick="bucketIDForModal(<?php echo $data['buckets']['bucket_id']; ?>)">
								Add Milestone
							</button>	
						<?php
					}
					else
					{
						?>
							<button type="button" 
								class="btn btn-default" 
								data-container="body" 
								data-toggle="popover" 
								data-placement="top" 
								data-content="You can buy more milestone slots." data-original-title="" title="">
								MAX Milestones reached
							</button>
						<?php
					}
				?>
				
			</div>
		</div> 
	</div>
</form>		

</br>
		
		<?php
			
	}
}

?>

</div>




<!-- 
	Bucketlist modals 
-->
<!-- Adding bucketlist modal -->
<div class="modal fade" id="addBucketModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form class="form-horizontal" action="bucketlist.php" name="addBucketList" id="addBucketList" method="post">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h4 class="modal-title">Add a Bucketlist</h4>
				</div>
				<div class="modal-body">		
					<label class="control-label">Title</label>
					<input class="form-control" type="text" name="title" id="title" />
					<label class="control-label">Body</label>
					<input class="form-control" type="text" name="body" id="body"/>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn-save" name="addBucketList">Save</button>
					<button type="button" class="btn-close" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</form>
</div>
<!-- /modal -->

<!-- Edit bucketlist item modal -->
<div class="modal fade" id="editbucketModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form class="form-horizontal" action="bucketlist.php" name="" id="" method="post">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">
						Edit bucketlist <?php echo $bucket_id; ?>
					</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label col-lg-4">Title</label>
						<div class="col-lg-8">
							<input type="text" name="title" id="bucket_title" />
						</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-4">Body</label>
							<div class="col-lg-8">
								<textarea cols="40" rows="5" id="bucket_body" name="body">body text here</textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-8 col-lg-offset-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="completed" id="bucket_editcompleted" />
									</label>
								</div>
							</div>
						</div>
						<input type="text" id="bucket_id" name="bucket_id" value="hi"/>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn-save" name="bucketlist_edit">Save</button>
					<button type="button" class="btn-close" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</form>
</div>
<!-- /modal -->

<!-- Deleting a bucket modal -->
<div class="modal fade" id="deleteBucketModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form class="" action="bucketlist.php" name="deleteMilestone" id="deleteMilestone" method="post">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h4 class="modal-title">Delete?</h4>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label for="" class="control-label">Are you sure you wish to delete this bucketlist?</label>
						<input type="hidden" value="" id="bucketIDDeleteModal" name="bucketID"/>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn-delete" name="bucketlist_delete">Yes</button>	
					<button type="button" class="btn-close" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</form>
</div>
<!-- /modal -->




<!--
	Milestones modal
-->
<!-- Adding a milestone modal -->
<div class="modal fade" id="addMilestoneModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form class="" action="bucketlist.php" name="addMilestone" id="addMilestone" method="post">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">
						Add a milestone <?php echo $bucket_id; ?>
					</h4>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label for="" class="col-lg-4 control-label">What did you do?</label>
						<div class="col-lg-8">
							<textarea name="milestone_text" cols="40" rows="5"></textarea>
						</div>
					</div>
					<input type="hidden" class="col-lg-offset-4 col-lg-8" id="bucketIDAddModal" name="milestone_bucketid"/>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn-add" name="milestone_add">Add</button>	
					<button type="button" class="btn-close" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</form>
</div>
<!-- /modal -->

<!-- Editing a milestone modal -->
<div class="modal fade" id="editMilestoneModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form class="" action="bucketlist.php" name="editMilestone" id="editMilestone" method="post">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h4 class="modal-title">Edit a milestone</h4>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label for="" class="col-lg-4 control-label">What did you do?</label>
						<div class="col-lg-8">
							<textarea name="milestone_text" cols="40" rows="5" id="editMilestoneText"></textarea>
						</div>
					</div>
					<input type="hidden" id="milestone_id" name="milestone_id" />
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn-save" name="milestone_edit">Save</button>				
					<button type="button" class="btn-close" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</form>
</div>
<!-- /modal -->

<!-- Deleting a milestone modal -->
<div class="modal fade" id="deleteMilestoneModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form class="" action="bucketlist.php" name="deleteMilestone" id="deleteMilestone" method="post">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h4 class="modal-title">Delete?</h4>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label for="" class="control-label">Are you sure you wish to delete this milestone?</label>
						<input type="hidden" value="" id="milestoneIDDeleteModal" name="milestoneID"/>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn-delete" name="milestone_delete">Yes</button>	
					<button type="button" class="btn-close" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</form>
</div>
<!-- /modal -->
      
<?php @include("footer.php"); ?>