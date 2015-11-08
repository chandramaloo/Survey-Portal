<?php
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		Graph check
	</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
<canvas id="myChart" width="400" height="400"></canvas>

<script type="text/javascript">
	
	var ctx = document.getElementById("myChart").getContext("2d");
	var data = {
    	labels: ["Option1", "Option2", "Option3", "Option4", "Option5", "Option6", "Option7"],
	    datasets: [
	        {
	            label: "Option1",
	            fillColor: "rgba(220,220,220,0.5)",
	            strokeColor: "rgba(220,220,220,0.8)",
	            highlightFill: "rgba(220,220,220,0.75)",
	            highlightStroke: "rgba(220,220,220,1)",
	            data: [65, 59, 80, 81, 56, 55, 40]
	        }	
	    ]
	};
	var myBarChart = new Chart(ctx).Bar(data);
</script>
</body>
</html>