function sched_getMachineJobs(machine) {
	$.getJSON('ajax/getMachineJobs.php', {
        version: '1',
        m: machine
    }, function(data) {
    	var tblData = "<tr><th>Machine</th><th>Time</th></tr>";
    	var pos = 1;
    	$.each(data, function(job, data){
    		tblData += '<tr class="jobRow ' + data.status + '">';
    		tblData += '<td>' + pos + '</td>';
    		tblData += '<td>' + data.jobId + '</td>';
    		tblData += '<td>' + data.partNo + '</td>';
    		tblData += '<td>' + data.qtyRemain + '</td>';
    		tblData += '<td>' + data.hours + '</td>';
    		tblData += '<td>' + data.hoursToGo + '</td>';
    		tblData += '<td>' + data.due + '</td>';
    		tblData += '<td>' + data.complete + '</td>';
    		tblData += '</tr>';
    		pos += 1;
    	});
    	$('#jobTable').replaceWith(tblData);
    })
    .error(function() {
        $('#jobTable').replaceWith('<p>Error loading schedule data.</p>');
    });
}