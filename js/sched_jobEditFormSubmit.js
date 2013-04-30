function sched_jobEditFormSubmit() {
	var valid = sched_validateJobForm();
	if (valid != true) {
		return false;
	}
    var url = "ajax/editJob.php";

    $.ajax({
           type: "POST",
           url: url,
           data: $("#jobForm").serialize(),
           success: function(data) {
        	   window.location = "viewMachine.php?m=" + data;
           },
           error: function(xhr, status, error) {
        	    alert("An error occured: " + xhr.responseText);
        	 }
         });
    
    return false;
}
