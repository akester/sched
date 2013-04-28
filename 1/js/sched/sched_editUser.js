function sched_editUser(user) {
	var editUserDialog = $("#dialog").dialog({ autoOpen: false,
		height: 600,
		width: 350
	});
	
	var url = 'ajax/sched_editUser.php';
	editUserDialog.load(url).dialog('open');
	
	return false;
}