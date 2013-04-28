function sched_moveJob(target, job, machine) {
	
	var url = "ajax.php?p=moveJobExec";

    $.ajax({
           type: "POST",
           url: url,
           data: {jobId: job, target: target, machine: machine},
           success: function(data) {
        	   window.location = "?p=machine&m=" + machine;
           },
           error: function(xhr, status, error) {
        	    alert("An error occured: " + xhr.responseText);
        	    /* FIXME: stop clearing of form when there was an error */
        	 }
         });
	
	return false;
}