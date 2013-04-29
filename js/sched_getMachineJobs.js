function sched_getMachineJobs(machine) {
	$.getJSON('ajax/getMachineJobs.php', {
        version: '1',
        m: machine
    }, function(data) {
    	var tblData = "<tr><th>Machine</th><th>Time</th></tr>";
    	$.each(data, function(job, data){
    		tblData += '<tr>';
    		tblData += '<td>' + data.machine + '</td>';
    	});
    	$('#jobTable').replaceWith(tblData);
    })
    .error(function() {
        $('#jobTable').replaceWith('<p>Error loading schedule data.</p>');
    });
}