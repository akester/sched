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
           error: function(xhr, status, error) {
        	    alert("An error occured: " + xhr.responseText);
        	    /* FIXME: stop clearing of form when there was an error */
        	 }
         });
    
    /* Clear the form */
    $('[name=jobForm]')[0].reset();

    return false;
}