<?
	$url = 'http://localhost/jne-scrap/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
	<meta name="author" content="" />

	<title>JNE Scrapping City</title>
	<script src="<?=$url;?>js/jquery-1.11.0.min.js"></script>
</head>

<body>

<style>
	td {text-align:center;};
</style>
JNE Scrapping City
<br/>
<br/>
<input type="radio" class="city_source" name="city_source" value="origin" checked> Origin<br>
<input type="radio" class="city_source" name="city_source" value="destination"> Destination<br><br>
<input type="submit" id="scrap" name="scrap" value="Scrap Now!"></input>
<br/>
<br/>

<table border="1" width="450">
	<tr>
		<th width="5%" >Line</th>
		<th width="20%">Status</th>
		<th width="35%" style="text-align: center;">Query</th>		
		<th width="20%">Total Success</th>
		<th width="20%">Total Failed</th>
	<tr>

	
	<tr>
		<td><div id="line">-</div></td>
		<td><div id="status">-</div></td>
		<td><div id="query">-</div></td>
		<td><div id="total-success">-</div></td>
		<td><div id="total-failed">-</div></td>
	<tr>
</table>

<script type="text/javascript">
	jQuery(document).ready(function($){
		var city_source;
		
		var keyword_list;
		var total_lines=0;
		var row=0;
		var success=0;
		var invalid=0;
		var keyword="";
		
		$("#scrap").click(function() {
			load_query();
		});
		
		function load_query() {
			$.ajax({
				url: "<?=$url;?>load-data.php" ,
				type: 'POST', 
				data : {},
				dataType: "json",
				beforeSend: function (){                          
					$('#status').html('load data...');  
				},
				success: function(data) {
					keyword_list = data.content;
					total_lines = keyword_list.length; 					
					scrapit(row);
				},
				cache: false,
			});
		}
		
		function scrapit(row) {		
			if (row < total_lines){
				keyword = keyword_list[row];				
				$.ajax({
					url: "<?=$url;?>scrap.php" ,
					type: 'POST', 
					data: { city_source : city_source, keyword : keyword},
					dataType: "json",
					beforeSend: function () {
						$('#query').html(keyword);                                                       
						$('#status').html('processing...');  
					},
					success: function(data) {
						if(data.status=='valid'){
							success++;
							$('#total-success').html(success);
						}else{
							invalid++;
							$('#total-failed').html(invalid);
						}
						
						$('#status').html(data.status);
						
						row++;
						$('#line').html(row);
						scrapit(row).delay(3000);
						
					},
					cache: false,
				}); 
			}
		}
		
	});	
</script>

</body>

</html>
