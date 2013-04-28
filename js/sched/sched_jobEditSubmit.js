function sched_jobEditSubmit() {
	var valid = sched_validateJobForm();
	if (valid != true) {
		return false;
	}
    var url = "ajax.php?p=editJobExec";
    var machine = $('[name=machine]').val();

    $.ajax({
           type: "POST",
           url: url,
           data: $("#jobForm").serialize(),
           success: function(data) {
        	   window.location = "?p=machine&m=" + machine;
           },
           error: function(xhr, status, error) {
        	    alert("An error occured: " + xhr.responseText);
        	 }
         });

    return false;
}