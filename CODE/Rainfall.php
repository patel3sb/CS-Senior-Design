<!doctype html>
<html>
	<!-------------------- Misc. Webpage Settings ------------------------->
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="WebpageStyle16.css" rel="stylesheet" type="text/css"/>
		<meta charset="utf-8">
		<!-------------------- Webpage Tab Name ------------------------->
		<title>Rainfall on UC Campus - Rainfall</title>
	</head>
	
	<body>	
		<header>
			<a href= "https://www.uc.edu/" title="UC Homepage">
				<img id="UClogo" src="UniversityOfCincinnatiLogo.png" alt="UniversityOfCincinnatiLogo" align="right" style="width:229px;height:76px;">	
				<h1>Rainfall - UC Main Campus</h1>
				
			</a>
		</header>
		<!--------------------------------DISPLAY BUTTONS: Home, Rainfall, Structures, etc...------------------------------------>
		<div id ="navigator"> 
			
			<div id="navigatorButtons">
				<table id="navButtonsTable" style="empty-cells:show; border-radius:40px; border:2px solid #ffffff;  border-style:solid" width=20px height=10px
				cellspacing="0" align="left">
					<tr>
						<td  style="line-height:9px; color:#423F3D; padding:6px 6px 6px 6px;position:relative" >
							<a href="Rainfall.php?page=1">Rainfall</a>
						</td>
					</tr>
				</table>
			</div>
			
			<div id="navigatorButtons">
				<table style="empty-cells:show; border-radius:40px; border:2px solid #ffffff;  border-style:solid" width=20px height=10px
				cellspacing="0" align="left">
					<tr>
						<td style="line-height:9px; color:#423F3D; padding:6px 6px 6px 6px;position:relative" >
							<a href="Structures.php">Structures</a>
						</td>
					</tr>
				</table>
			</div>
			
			<div id="navigatorButtons">
				<table style="empty-cells:show; border-radius:40px; border:2px solid #ffffff;  border-style:solid" width=20px height=10px
				cellspacing="0" align="left">
					<tr>
						<td style="line-height:9px; color:#423F3D; padding:6px 6px 6px 6px;position:relative" >
							<a href="Tools.php">Tools</a>
						</td>
					</tr>
				</table>
			</div>
			
			<div id="navigatorButtons">
				<table style="empty-cells:show; border-radius:40px; border:2px solid #ffffff;  border-style:solid" width=20px height=10px
				cellspacing="0" align="left">
					<tr>
						<td style="line-height:9px; color:#423F3D; padding:6px 6px 6px 6px;position:relative" >
							<a href="About.php">About</a>
						</td>
					</tr>
				</table>
			</div>
			
			<div id="navigatorButtons">
				<table style="empty-cells:show; border-radius:40px; border:2px solid #ffffff;  border-style:solid" width=20px height=10px
				cellspacing="0" align="left">
					<tr>
						<td style="line-height:9px; color:#423F3D; padding:6px 6px 6px 6px;position:relative" >
							<a href="Contact.php">Contact</a>
						</td>
					</tr>
				</table>
			</div>
			
		</div>
		
		<div id="home"> 
			<!--------------------------CONNECT TO MYSQL------------------------------>
			<?php
			$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");

			if ($connection) {
				#echo "Connection established.";
			} else {
				die( "Connection failed. Reason: ".mysqli_connect_error());
			}

			echo "<br>";
			mysqli_close($connection);
			?>

			<!-------------------------DISPLAY PAGE NUMBERS------------------------------>
			<tbody id = "rainfalldata">
				<table id = "PageNumbersTable" align="left">
					<tr>
						<th id="Rainfall_PAGE_NUMS_HeaderBox">Pages</th>
					</tr>
					
					
					
					<tr>
						<td id="PagesTableDataArea"><br>
							<?php
								if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
								if (isset($_GET["results_per_page"])) { $results_per_page  = $_GET["results_per_page"]; } else { $results_per_page=22; };
								$start_from = ($page-1) * $results_per_page;
								
								$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
								$sql="select Date from SensorReadings;";
								$results=mysqli_query($connection,$sql);
								$num_rows = mysqli_num_rows($results);
								$total_pages = ceil($num_rows / $results_per_page);
								for ($i=1; $i<=$total_pages; $i++) {  // loop to print page numbers
									echo "<a id='PageNumberLinks' href='Rainfall.php?page=".$i."'";
									if ($i==$page)  echo " class='curPage'";
									echo ">".$i."</a> "; 
								}; 
							?>
							
							<br><br>
							<table>
							
							<!-- Make Next button go to next page-->
							<form method="post" action="Rainfall.php?page=<?php 
																			if($page < $total_pages){
																				echo $page+1; 
																			} else {
																				echo $page;
																			}
																			
																		?>" id="form">
							<!-- Next button -->
							<input id="NextAndPreviousButtons" type="submit" class="button" name="but_next" value="Next">
							</form>	
								


							<!-- Make Previous button go to previous page-->
							<form method="post" action="Rainfall.php?page=<?php 
																			if($page == 2) {
																				echo 1;
																			}
																			else{
																				if($page < 2){
																					echo 1;
																				}else{	
																				echo $page-1;
																				}																				
																			}
																		?>" id="form2">
							<!-- Previous button -->
							<input id="NextAndPreviousButtons" type="submit" class="button" name="but_prev" value="Previous">
							</form>	
							</table>
							<br>
						</td>

					
					</tr>
					
					
				</table>
			</tbody>			
			
			<br>
			<br>
			<!-------------------------DISPLAY DATA------------------------------>
			
			<tbody id = "rainfalldata">
				<table id="RainfallDataTable" align="center">
					<tr>
						<th id="Rainfall_DATA_HeaderBox">Date</th>
						<th id="Rainfall_DATA_HeaderBox">Time</th>
						<th id="Rainfall_DATA_HeaderBox">Rainfall (in.)</th>
					</tr>
					
					<tr>
						<!--------------------------- Date --------------------------->
						<td id="SensorReadingsRows">
							<div id="Columns">
								<?php
									if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
									if (isset($_GET["results_per_page"])) { $results_per_page  = $_GET["results_per_page"]; } else { $results_per_page=22; };
									$start_from = ($page-1) * $results_per_page;
									$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
									
									$sql="select Date from sensorreadings LIMIT $start_from, ".$results_per_page;
									$results=mysqli_query($connection,$sql);
									$num_rows = mysqli_num_rows($results);
									
									$xvalues = "xvalues: ";
									
									$total_pages = ceil($num_rows / $results_per_page); 
									while($row=mysqli_fetch_array($results)){
										echo $row[0];
										echo "<br>";
										$xvalues .= $row[0];
										$xvalues .= ",";
										

									}
									mysqli_close($connection);
								?>	
							</div>
						</td>
						
						

						<!--------------------------- Time --------------------------->
						
						<td id="SensorReadingsRows">
							<div id="Columns">
								<?php
									if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
									if (isset($_GET["results_per_page"])) { $results_per_page  = $_GET["results_per_page"]; } else { $results_per_page=22; };
									$start_from = ($page-1) * $results_per_page;
									$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
									
									$sql="select time from SensorReadings ORDER BY sensorreadings.Date LIMIT $start_from, ".$results_per_page;

									$results=mysqli_query($connection,$sql);
									$num_rows = mysqli_num_rows($results);
									
									$total_pages = ceil($num_rows / $results_per_page); 
									while($row=mysqli_fetch_array($results)){
										echo $row[0];
										echo "<br>";
									}
									mysqli_close($connection);
								?>	
							</div>
						</td>
						
						<!--------------------------- SensorReading --------------------------->
						
						<td id="SensorReadingsRows">
							<div id="Columns">
								<?php
									if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
									if (isset($_GET["results_per_page"])) { $results_per_page  = $_GET["results_per_page"]; } else { $results_per_page=22; };
									$start_from = ($page-1) * $results_per_page;
									$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
									
									$sql="select sensorreading from SensorReadings ORDER BY sensorreadings.Date LIMIT $start_from, ".$results_per_page;

									$results=mysqli_query($connection,$sql);
									$num_rows = mysqli_num_rows($results);
									$yvalues = "yvalues: ";

									$total_pages = ceil($num_rows / $results_per_page); 
									while($row=mysqli_fetch_array($results)){
										echo $row[0];
										echo "<br>";
										$yvalues .= $row[0];
										$yvalues .= ",";
										
										
									}
									mysqli_close($connection);
								?>	
							</div>
						</td>
						
					</tr>
				</table>
			</tbody>

			
			
			
			<?php
				//echo $xvalues;
				$var_str1 = var_export($xvalues, true);
				$var_str2 = var_export($yvalues, true);
				$x = "<?php\n\n\$text = $var_str1;\n\n?>";
				$y = "<?php\n\n\$text = $var_str2;\n\n?>";
				file_put_contents('xvalues.txt', $x);
				file_put_contents('yvalues.txt', $y);
				
				//$r = 'python MakeRainfallPlot.py $xvalues $yvalues';
				//exec($r);
				$output5 = shell_exec("python MakeRainfallPlot.py");
				echo "<h2>$output5</h2>";
			?>
			<img id="RainfallGraph" src="img.png" alt="img" width="300" height="250">
			<br><br><br><br>

		</div>
		
	

		<div id="BottomOfPage">	
			<footer>
				<br>This website was created for CS5002 Senior Design Project
			</footer>
		</div>

	</body>

	

</html>