<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
	<!--<meta http-equiv="refresh" content="30">-->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/dygraph/1.1.1/dygraph-combined.js"></script>
    <title>DHT Temperature and Humidity</title>
  </head>
  <body>
  <center>

	Plot data from: 
	<?php
		$directory = './logs/';
		$scanned_directory = str_replace("dht-","", array_diff(scandir($directory,1), array('..', '.', '.htaccess')));
		$scanned_directory = str_replace(".txt","", $scanned_directory);

		// Prepare the select box to echo
		echo "<select id=\"dateselect\" onChange=\"plotInput(this)\">\n";
		echo "<option selected=\"true\" style=\"display:none;\">select date</option>\n";
		foreach ($scanned_directory as $file){
			$filename="dht-$file.txt";
			echo "<option value=\"$filename\">$file</option>\n";
		}
		echo "</select>";
	?><hr/>

	<div id="DHTGraph" style="width:1024px; height:768px;" />
	<script type="text/javascript">
	  function pad(n) {
	    return (n < 10) ? ("0" + n) : n;
	  }
  
      var d = new Date();
	  var dd = pad(d.getDate());
	  var dm = pad(d.getMonth()+1);
	  var dj = pad(d.getYear());
	  if (dj < 999) dj += 1900;
	  var datestring = dj+""+dm+""+dd;
	  infile="dht-"+datestring+".txt";

	  dhtgr = new Dygraph(document.getElementById("DHTGraph"),"logs/"+infile, 
	  {
		  legend: 'always',
	      title: 'DHT Temperature and Humidity',
    	  xValueFormatter: Dygraph.dateValueFormatter,
    	  xValueParser: function(x) { return 1000*parseInt(x); },
    	  xTicker: Dygraph.dateTicker,
    	  rollPeriod: 10,
    	  showRoller: true,
    	  ylabel: 'Value'
      }
    );
 
  	setInterval(function() {
		dhtgr.updateOptions( { 'file': "logs/"+infile } );
  	}, 60000);

	function plotInput(e) {
		infile = e.options[e.selectedIndex].value;
		dhtgr.updateOptions( { 'file': "logs/"+infile } );
	}
   
	</script>
  </center>
  </body>
</html>
