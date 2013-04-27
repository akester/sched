function sched_jobFormSubmit() {
	var valid = sched_validateJobForm();
	if (valid != true) {
		return false;
	}
    var url = "ajax.php?p=newJobExec";

    $.ajax({
           type: "POST",
           url: url,
           data: $("#jobForm").serialize(),
           success: function(data) {
               alert(data);
           },
           error: function() {
        	   alert('An error occured.')
           }
         });

    return false;
}