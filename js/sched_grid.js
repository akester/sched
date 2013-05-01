function sched_grid(scale) {
	var dateBox = new Array();
	if (scale == 1) {
		dateBox['number'] = 24;
		dateBox['unit'] = 'h';
	}
	if (scale >= 2 && scale <= 14) {
		dateBox['number'] = scale;
		dateBox['unit'] = 'd';
	}
	if (scale >= 15) {
		dateBox['number'] = Math.floor(scale / 7);
		dateBox['unit'] = 'w';
	}
	var pct = Math.floor(99.9 / dateBox['number']);
	$.getJSON('ajax/getGridData.php', {
        version: '1',
        s: scale
    }, function(data) {
    	var tblData = "<tr>" +
    			"<th>Machine</th>" +
    			"<td>";
    	var i = 0;
    	while (i < dateBox['number']) {
    		tblData += '<span class="jobBox" style="width:' + pct + '%;">' 
    			+ i + dateBox.unit + '</span>';
    		i++;
    	};
    	tblData += '</td></tr>';
    	$.each(data, function(machine, grid){
    		tblData += '<tr>';
    		tblData += '<td><a href="viewMachine.php?m=' + machine + '">' + machine + '</td>';
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