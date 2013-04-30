function sched_moveJob(m, j) {
	$.getJSON('ajax/getMachineJobs.php', {
        version: '1',
        m: machine
    }, function(data) {
    	var tblData = "<tr>";
    	tblData += "<th>Pos</th>";
    	tblData += "<th>Job ID</th>";
    	tblData += "<th>Part No</th>";
    	tblData += "<th>Qty Rem</th>";
    	tblData += "<th>TH</th>";
    	tblData += "<th>HTG</th>";
    	tblData += "<th>Due</th>";
    	tblData += "<th>Move</th>";
    	tblData += "</tr>";
    	var pos = 1;
    	$.each(data, function(job, data){
    		tblData += '<tr class="jobRow ' + data.status + '">';
    		tblData += '<td>' + pos + '</td>';
    		tblData += '<td>' + data.jobId + '</td>';
    		tblData += '<td>' + data.partNo + '</td>';
    		tblData += '<td>' + data.qtyRemain + '</td>';
    		tblData += '<td>' + data.hours + ' h</td>';
    		tblData += '<td>' + data.hoursToGo + ' h</td>';
    		tblData += '<td>' + data.due + '</td>';
    		tblData += '<td>' + data.complete + '</td>';
    		tblData += '<td><a onclick="return sched_moveJobSubmit(\'' 
    			+ j + '\', \'' + data.jobId + '\', \''+ m + '\');" \
    			href="">Move Ahead</a></td>';
    		tblData += '</tr>';
    		pos += 1;
    	});
    	$('#jobTable').replaceWith(tblData);
    })
    .error(function() {
        $('#jobTable').replaceWith('<p>Error loading schedule data.</p>');
    });
}