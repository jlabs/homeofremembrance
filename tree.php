<?php 	
	//button on should show if $get_tree_owner == "owner"
	$page_action = '<button type="button" style="margin-top: 7px;" class="btn-action" data-toggle="modal" data-target="#addRootModal">Add relation</button>';

	$pageTitle = "Home of Remembrance - Family Tree";
	@include("header.php"); 
	
	require_once("classes/Tree.php");
	
	$tree = new Tree();
	$show_tree = array();
	$show_tree = $tree->getTree();
	$get_tree_owner = $tree->getTreeOwner();
	
	
?>



<!-- header area-->
<div class="container">

<?php
	// show negative messages
	if ($tree->errors) {
	    foreach ($tree->errors as $error) {
	        echo "<div class='alert alert-danger'>".$error."<button type='button' class='close' aria-hidden='true'>&times;</button></div>";    
	    }
	}
	
	// show positive messages
	if ($tree->messages) {
	    foreach ($tree->messages as $message) {
	        echo "<div class='alert alert-success'>".$message."<button type='button' class='close' aria-hidden='true'>&times;</button></div>";
	    }
	}

?>

</div>


      
<!--Main content area-->
<div class="container">
	<div class="row">



	
<?php
	$grandparents = array();
	$parents = array();
	$siblings = array();
	$children = array();
	
	if (!empty($show_tree))
	{	
		foreach($show_tree as $row)
		{ 
			$user_id = $row['user_id']; 
			$get_root = $tree->getRoot($user_id);
			
			if ($row['family_status'] == "grandfather" || $row['family_status'] == "grandmother")
			{
				$grandparents[] = $get_root->user_fullname.";".$row['family_status'].";".$user_id.";".$get_root->user_email;
			} 
			elseif ($row['family_status'] == "father" || $row['family_status'] == "mother") 
			{
				$parents[] = $get_root->user_fullname.";".$row['family_status'].";".$user_id.";".$get_root->user_email.";".$user_id;
			} 
			elseif ($row['family_status'] == "brother" || $row['family_status'] == "sister") 
			{
				$siblings[] = $get_root->user_fullname.";".$row['family_status'].";".$user_id.";".$get_root->user_email;
			}
			elseif ($row['family_status'] == "son" || $row['family_status'] == "daughter")
			{
				$children[] = $get_root->user_fullname.";".$row['family_status'].";".$user_id.";".$get_root->user_email;
			}
			
		}
		
		
	} 
	else 
	{
		?> 
		<div class="alert alert-info">
			<h3>Looks like you don't have a family tree ... yet.</h3>
			<p>Don't worry though, you can plant a new tree by <a class="text-info" href="tree.php?plant_tree=true">clicking here</a></p> 
		</div>
		<?php 	
	}
?>

<?php if (!empty($grandparents)) { ?>
<div class="col-lg-8 col-lg-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading"><h2>Grandparents</h2></div>
		<div class="panel-body">
			<ul class="list-inline">
				<?php
					//for each person in array echo the html
					foreach($grandparents as $person)
					{
						$person_split = split(";", $person);
						
				?>
					<li>
						<h3 id="<?php echo $person_split[1].$person_split[2]; ?>"><?php echo $person_split[0]; ?></h3>
						<p class="text-muted"><?php echo $person_split[1]; ?></p>
						<button class="btn-edit btn-lg btn-block"
							type="button"
							onclick="editRoot('<?php echo $person_split[1]; ?>',<?php echo $person_split[2]; ?>, '<?php echo $person_split[1]; ?>')"
							data-toggle="modal"
							data-target="#editRootModal">Edit</button>
						<input type="hidden" id="mail<?php echo $person_split[2]; ?>" value="<?php echo $person_split[3]; ?>" />
					</li>	
					<!-- edit form goes to the details page to update all the information -->
					
				<?php
					//end of for each
					}
				?>				
			</ul>
		</div>
	</div>
</div>
<?php } ?>

<?php if (!empty($parents)) { ?>
<div class="col-lg-8 col-lg-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading"><h2>Parents</h2></div>
		<div class="panel-body">
			<ul class="list-inline">
				<?php
					//for each person in array echo the html
					foreach($parents as $person)
					{
						$person_split = split(";", $person);
						// [0] is the fullname
						// [1] is relation
						// [2] is the id
				?>
					<li>
						<h3 id="<?php echo $person_split[1].$person_split[2]; ?>"><?php echo $person_split[0]; ?></h3>
						<p class="text-muted"><?php echo $person_split[1]; ?></p>
						<button class="btn-edit btn-lg btn-block"
							type="button"
							onclick="editRoot('<?php echo $person_split[1]; ?>',<?php echo $person_split[2]; ?>, '<?php echo $person_split[1]; ?>')"
							data-toggle="modal"
							data-target="#editRootModal">Edit</button>
						<button class="btn-delete btn-lg btn-block"
							type="button"
							onclick="deleteRoot('<?php echo $person_split[2]; ?>')"
							data-toggle="modal"
							data-target="#deleteRootModal">Delete</button>	
						<input type="hidden" id="mail<?php echo $person_split[2]; ?>" value="<?php echo $person_split[3]; ?>" />
					</li>	
				<?php
					//end of for each
					}
				?>				
			</ul>
		</div>
	</div>
</div>
<?php } ?>

<?php if (!empty($siblings)) { ?>
<div class="col-lg-8 col-lg-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading"><h2>Siblings</h2></div>
		<div class="panel-body">
			<ul class="list-inline">
				<?php
					//for each person in array echo the html
					foreach($siblings as $person)
					{
						$person_split = split(";", $person);
						
				?>
					<li>
						<h3 id="<?php echo $person_split[1].$person_split[2]; ?>"><?php echo $person_split[0]; ?></h3>
						<p class="text-muted"><?php echo $person_split[1]; ?></p>
						<button class="btn-edit btn-lg btn-block"
							type="button"
							onclick="editRoot('<?php echo $person_split[1]; ?>',<?php echo $person_split[2]; ?>, '<?php echo $person_split[1]; ?>')"
							data-toggle="modal"
							data-target="#editRootModal">Edit</button>
						<input type="hidden" id="mail<?php echo $person_split[2]; ?>" value="<?php echo $person_split[3]; ?>" />
					</li>	
				<?php
					//end of for each
					}
				?>				
			</ul>
		</div>
	</div>
</div>
<?php } ?>

<?php if (!empty($children)) { ?>
	<div class="col-lg-8 col-lg-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2>Children</h2>
			</div>
			<div class="panel-body">
				<ul class="list-inline">
					<?php
						//for each person in array echo the html
						foreach($children as $person)
						{
							$person_split = split(";", $person);
							
					?>
						<li>
						<h3 id="<?php echo $person_split[1].$person_split[2]; ?>"><?php echo $person_split[0]; ?></h3>
						<p class="text-muted"><?php echo $person_split[1]; ?></p>
						<button class="btn-edit btn-lg btn-block"
							type="button"
							onclick="editRoot('<?php echo $person_split[1]; ?>',<?php echo $person_split[2]; ?>, '<?php echo $person_split[1]; ?>')"
							data-toggle="modal"
							data-target="#editRootModal">Edit</button>
						<input type="hidden" id="mail<?php echo $person_split[2]; ?>" value="<?php echo $person_split[3]; ?>" />
					</li>	
	
					<?php
						//end of for each
						}
					?>				
				</ul>
			</div>
		</div>
	</div>
<?php } ?>
		
	
	</div>
</div>





<!-- 
	Modals
-->
<!-- add root -->
<div class="modal fade" id="addRootModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form class="form-horizontal" action="tree.php" method="post" role="form">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h4 class="modal-title">Add a root to your family tree.</h4>
				</div>
				<div class="modal-body">		
					<label class="control-label">Name</label>
					<input type="text" class="form-control" name="person_name" placeholder="First and Last name">
					<label class="control-label">Email</label>
					<input type="email" class="form-control" placeholder="Leave blank if not known" name="person_mail">
					<label class="control-label">Relation to you</label>
					<select class="form-control" name="relation">
						<option>grandmother</option>
						<option>grandfather</option>
						<option>mother</option>
						<option>father</option>
						<option>brother</option>
						<option>sister</option>
						<option>daughter</option>
						<option>son</option>
					</select>
					<!-- <input type="hidden" name="addRoot_treeID" value="<?php echo $_SESSION['tree_id']; ?>"> -->
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn-save" name="add_root">Save</button>
					<button type="button" class="btn-close" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</form>
</div>
<!-- end modal -->

<!-- Editing a root modal -->
<div class="modal fade" id="editRootModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form class="" action="tree.php" method="post">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h4 class="modal-title">Edit root</h4>
				</div>
				<div class="modal-body">					
					<label class="control-label">Name</label>
					<input type="text" 
						class="form-control" 
						name="editRoot_personName"
						id="editRoot_personName" 
						placeholder="First and Last name">
					<label class="control-label">Email</label>
					<input type="email" 
						class="form-control" 
						id="editRoot_personMail"
						placeholder="Leave blank if not known" 
						name="editRoot_personMail"
						disabled>
					<label class="control-label">Relation to you</label>
					<select class="form-control" name="relation" id="rootRelation">
						<option>grandmother</option>
						<option>grandfather</option>
						<option>mother</option>
						<option>father</option>
						<option>aunt</option>
						<option>uncle</option>
						<option>sister</option>
						<option>brother</option>
						<option>daughter</option>
						<option>son</option>	
					</select>
					<!-- treeid -->
					<input type="hidden" name="editRoot_treeID" value="<?php echo $_SESSION['tree_id']; ?>">
					<!-- userid -->
					<input type="hidden" name="userID" id="userID"/>
					<!-- relation -->
					<input type="hidden" name="editRoot_prevRelation" id="editRoot_prevRelation"/>
				</div>
				<div class="modal-footer">				
					<button type="submit" class="btn-save" name="btn-editRoot">Save</button>				
					<button type="button" class="btn-delete" name="btn-deleteRoot" id="btn-deleteRoot" onclick="deleteRoot()">Delete</button>
					<button type="button" class="btn-close" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</form>
</div>
<!-- /modal -->

<!-- add root -->
<div class="modal fade" id="deleteRootModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form class="form-horizontal" action="tree.php" method="post" role="form">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h4 class="modal-title">Delete root.</h4>
				</div>
				<div class="modal-body">		
					<label class="control-label">Are you sure you want to delete?</label>
					<input type="text" name="delete_userID" id="delete_userID"/>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn-delete" name="delete_root">Delete</button>
					<button type="button" class="btn-close" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</form>
</div>
<!-- end modal -->
            
<?php @include("footer.php"); ?>