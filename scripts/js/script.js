function bucketIDForEditModal(parsedID)
{
	//document.getElementById("bucket_id").value = parsedID;
	$("#bucket_id").val(parsedID);
	
	var bucket_body = "bucket_body" + parsedID;
	//document.getElementById("bucket_body").value = document.getElementById(bucket_body).innerHTML;
	$("#bucket_body").val($(bucket_body).innerHTML);
	
	var bucket_title = "bucket_title" + parsedID;
	//document.getElementById("bucket_title").value = document.getElementById(bucket_title).innerHTML;
	$("#bucket_title").val($(bucket_title).innerHTML);
	
	var bucket_completed = "bucket_completed" + parsedID;
	
	if ($(bucket_completed).innerHTML === "Completed")
	{
		//document.getElementById("bucket_editcompleted").checked = true;
		$("#bucket_editcompleted").checked = true;
	}
	else
	{
		//document.getElementById("bucket_editcompleted").checked = false;
		$("#bucket_editcompleted").checked = false;
	}
}

function bucketIDForModal(parsedID)
{
	//document.getElementById("bucketIDAddModal").value = parsedID;
	$("#bucketIDAddModal").val(parsedID);
}

function milestoneIDForEditModal(parsedID)
{			
	//document.getElementById("milestone_id").value = parsedID;
	$("#milestone_id").val(parsedID);
	
	var milestone_text = "milestone_text" + parsedID;
	//document.getElementById("editMilestoneText").value = document.getElementById(milestone_text).innerHTML;
	$("#editMilestoneText").val($(milestone_text).innerHTML);		
}

function milestoneIDforDeleteModal(parsedID)
{
	//document.getElementById("milestoneIDDeleteModal").value = parsedID;
	$("#milestoneIDDeleteModal").val(parsedID);
}

function bucketIDforDeleteModal(parsedID)
{
	//document.getElementById("bucketIDDeleteModal").value = parsedID;
	$("#bucketIDDeleteModal").val(parsedID);
}

function editRoot(relation,parsedID,prevRelation)
{
	//alert(relation);
	//alert(prevRelation);
	var relationSelect = 0;
	
	var rootSelectedName = relation + parsedID;
	var rootSelectedMail = "mail" + parsedID;
		
	switch(relation) {
		case "grandmother":
			relationSelect = 0;
			break;
		case "grandfather":
			relationSelect = 1;
			break;
		case "mother":
			relationSelect = 2;
			break;
		case "father":
			relationSelect = 3;
			break;
		case "aunt":
			relationSelect = 4;
			break;
		case "uncle":
			relationSelect = 5;
			break;
		case "sister":
			relationSelect = 6;
			break;
		case "brother":
			relationSelect = 7;
			break;
		case "daughter":
			relationSelect = 8;
			break;
		case "son":
			relationSelect = 9;
			break;
	}
	
	$("#userID").val(parsedID);
	$("#rootRelation").prop("selectedIndex", relationSelect);
	$("#editRoot_personName").val($("#"+rootSelectedName).text());
	$("#editRoot_personMail").val($("#"+rootSelectedMail).val());
	$("#editRoot_prevRelation").val(prevRelation);
	//document.getElementById("editRoot_personName").value = document.getElementById(rootSelectedName).innerHTML;
}

function deleteRoot(parsedID)
{
	//alert("delete root");
	//use post to delete user and root
	//alert($("#userID").val());
	
	//var sendUserID = $("#userID").val();
	//var toDeleteRoot = "true";	
	
	//alert(userID);
	
	/*
	$.post("classes/Tree.php",
	{
		deleteRoot:toDeleteRoot,
		userID:sendUserID
	},
	function(response, status)
	{
		alert("Response : " + response + "\n\nStatus : " + status);
	});
	*/
	$("#delete_userID").val(parsedID);
}