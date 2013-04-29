function sched_grid(scale) {
	$.getJSON('ajax/getGridData.php', {
        version: '1',
        s: scale
    }, function(data) {
    	var tblData = "<tr><th>Machine</th><th>Time</th></tr>";
    	$.each(data, function(machine, grid){
    		tblData += '<tr>';
    		tblData += '<td>' + machine + '</td>';
    		tblData += '<td class="timeColumn">';
    		$.each(grid, function(key, value){
    			tblData += '<span class="jobBox ' + value.status + '" style="width: ' + value.pct + '%;">';
    			tblData += key + '</span>';
    		});
    	});
    	$('#gridTable').replaceWith(tblData);
    })
    .error(function() {
        $('#gridTable').replaceWith('<p>Error loading schedule data.</p>');
    });
}