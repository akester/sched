function sched_validateJobForm() {
	var jobId = document.forms['jobForm']['jobId'].value;
	var machine = document.forms['jobForm']['machine'].value;
	var hours = document.forms['jobForm']['hours'].value;
	var hoursToGo = document.forms['jobForm']['hoursToGo'].value;
	var partNo = document.forms['jobForm']['partNo'].value;
	var material = document.forms['jobForm']['material'].value;
	var qtyRemain = document.forms['jobForm']['qtyRemain'].value;
	var due = document.forms['jobForm']['due'].value;
	
	if (jobId==null || jobId=="") {
		alert("Job ID is required.");
		$('[name=jobId]').focus();
		return false;
	}
	if (machine==null || machine=="") {
		alert("Machine is required.");
		$('[name=machine]').focus();
	  	return false;
	}
	if (hours==null || hours=="") {
		alert("Total Hours is required.");
		$('[name=hours]').focus();
		return false;
	}
	if (hoursToGo==null || hoursToGo=="") {
		alert("Hours Remain is required.");
		$('[name=hoursToGo]').focus();
		return false;
	}
	if (partNo==null || partNo=="") {
		alert("Part Number is required.");
		$('[name=partNo]').focus();
		return false;
	}
	if (material==null || material=="") {
		alert("Material is required.");
		$('[name=material]').focus();
		return false;
	}
	if (qtyRemain==null || qtyRemain=="") {
		alert("Remaining Qty is required.");
		$('[name=qtyRemain]').focus();
		return false;
	}
	if (due==null || due=="") {
		alert("Date Due is required");
		$('[name=due]').focus();
		return false;
	}
	
	return true;
}