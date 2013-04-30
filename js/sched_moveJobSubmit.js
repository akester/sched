function sched_moveJobSubmit(j, t, m) {
	var url = "ajax/moveJob.php";

    $.ajax({
           type: "POST",
           url: url,
           data: {j: j, t: t, m: m},
           success: function(data) {
        	   window.location = "viewMachine.php?m=" + m;
           },
           error: function(xhr, status, error) {
        	    alert("An error occured: " + xhr.responseText);
        	 }
         });
	
	return false;
}