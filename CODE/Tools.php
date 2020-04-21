<!doctype html>
<html>
	<!-------------------- Misc. Webpage Settings ------------------------->
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="WebpageStyle16.css" rel="stylesheet" type="text/css"/>
		<meta charset="utf-8">
		<!-------------------- Webpage Tab Name ------------------------->
		<title>Rainfall on UC Campus - Tools</title>
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
				<table style="empty-cells:show; border-radius:40px; border:2px solid #ffffff;  border-style:solid" width=20px height=10px
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
				<table id="navButtonsTable" style="empty-cells:show; border-radius:40px; border:2px solid #ffffff;  border-style:solid" width=20px height=10px
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
			<div class="float-container">

		
				<div id="text" class="float-child">
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
					

					<?php
					
					// initialize variables as empty
					$lengthErr = $widthErr = $heightErr = "";
					$length = $width = $height = $MaterialType = "";
					$LengthUnit = $WidthUnit = $HeightUnit = $UnitToConvertTo = "";
					$CostPerSquareFt = $CostPerSquareMeter = $CostPerCubicFt = $CostPerCubicMeter = "";


					if ($_SERVER["REQUEST_METHOD"] == "POST") {
					  if (empty($_POST["length"])) {
						$lengthErr = "length is required.";
					  } else {
						$length = TestInput($_POST["length"]);
						if (!is_numeric($length)) {
						  $lengthErr = "Only numbers are allowed.";
						}
					  }
					  
					  if (empty($_POST["width"])) {
						$widthErr = "width is required.";
					  } else {
						$width = TestInput($_POST["width"]);
						if (!is_numeric($width)) {
						  $widthErr = "Only numbers are allowed.";
						}
					  }
					  
					  if (empty($_POST["height"])) {
						$heightErr = "height is required.";
					  } else {
						$height = TestInput($_POST["height"]);
						if (!is_numeric($height)) {
						  $heightErr = "Only numbers are allowed.";
						}
					  }
					 
					$LengthUnit = $_POST["LengthUnit"];
					$WidthUnit = $_POST["WidthUnit"];				 
					$HeightUnit = $_POST["HeightUnit"];
					$MaterialType = $_POST["MaterialType"];
					
					$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
					unset($sql);
				

					}
					
					function TestInput($data) {
					  $data = trim($data);
					  $data = stripslashes($data);
					  $data = htmlspecialchars($data);
					  return $data;
					}
					?>
					
					<h3>Cost and Volume/Area Estimator</h3>
					<h4>Enter desired units and building dimensions then "Calculate".</h4>
					<h4>* = required</h4>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  		
						
						<tr>
							<td align="right">*Material Type: </td>
								<td align="right">	
									<select name='MaterialType'>
										<?php
											$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
											$sql="select MaterialType from materials;";
											$results=mysqli_query($connection,$sql);
											while($row=mysqli_fetch_array($results)){
												
												$MaterialType = $row['MaterialType'];

												echo '<option value="'.$MaterialType.'">'.$MaterialType.'</option>';
												echo "<br>";
												
											}
											mysqli_close($connection);
										?>
									</select>
									
								</td>
							</td>
						</tr>
						
						<br><br>  
						  
						<tr>
							<td align="right">*Length: </td>
								<td align="right">		
									<input type="text" name="length" value="<?php echo $length;?>"> 
										<select name="LengthUnit">
										<option value="feet">feet</option>
										<option value="meters">meters</option>
										</select>
								</td>
						</tr>
						<br><br>
						
						
						<tr>
							<td align="right">*Width: </td>
								<td align="right">		
									<input type="text" name="width" value="<?php echo $width;?>"> 
										<select name="WidthUnit">
										<option value="feet">feet</option>
										<option value="meters">meters</option>
										</select>
								</td>
						</tr>
						<br><br>
						
						
						<tr>
							<td align="right">Height: </td>
								<td align="right">		
									<input type="text" name="height" value="<?php echo $height;?>"> 
										<select name="HeightUnit">
										<option value="feet">feet</option>
										<option value="meters">meters</option>
										</select>
								</td>
						</tr>
						<br><br>
						
						
						
						<tr>
							<td align="right">*Unit to evaluate cost: </td>
								<td align="right">		
									<select name="UnitToConvertTo">
									<option value="feetcubed">cubic feet</option>
									<option value="meterscubed">cubic meters</option>
									<option value="feetsquared">square feet</option>
									<option value="meterssquared">square meters</option>
									</select>
								</td>
							</td>
						</tr>
						<br><br>
						
						<input type="submit" name="submit" value="Calculate">  					
					</form>

						
					<h2>
						<?php
							if ($_SERVER["REQUEST_METHOD"] == "POST") {
							
								$MaterialType = $_POST['MaterialType'];
								$UnitToConvertTo = $_POST['UnitToConvertTo'];
								if ($height == "") {
									$height="NA";
								}	
								
													
					
								$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
								$sql3 = "SELECT CostPerSquareFt FROM materials WHERE MaterialType='".$MaterialType."';";
								$result3 = mysqli_query($connection,$sql3);
								$row3 = mysqli_fetch_row($result3);
								$CostPerSquareFt = $row3[0];
								mysqli_close($connection);
								
								$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
								$sql4 = "SELECT CostPerSquareMeter FROM materials WHERE MaterialType='".$MaterialType."';";
								$result4 = mysqli_query($connection,$sql4);
								$row4 = mysqli_fetch_row($result4);
								$CostPerSquareMeter = $row4[0];
								mysqli_close($connection);
								
								$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
								$sql5 = "SELECT CostPerCubicFt FROM materials WHERE MaterialType='".$MaterialType."';";
								$result5 = mysqli_query($connection,$sql5);
								$row5 = mysqli_fetch_row($result5);
								$CostPerCubicFt = $row5[0];
								mysqli_close($connection);
								
								$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
								$sql6 = "SELECT CostPerCubicMeter FROM materials WHERE MaterialType='".$MaterialType."';";
								$result6 = mysqli_query($connection,$sql6);
								$row6 = mysqli_fetch_row($result6);
								$CostPerCubicMeter = $row6[0];
								mysqli_close($connection);
								
								$Operation="DisplayConvertingUnits";
								$output = shell_exec("python EstimateCosts.py $length $LengthUnit $width $WidthUnit $height $HeightUnit $UnitToConvertTo $MaterialType $CostPerSquareFt $CostPerSquareMeter $CostPerCubicFt $CostPerCubicMeter $Operation");
								
								$Operation="DisplayVolumeOrArea";
								$output2 = shell_exec("python EstimateCosts.py $length $LengthUnit $width $WidthUnit $height $HeightUnit $UnitToConvertTo $MaterialType $CostPerSquareFt $CostPerSquareMeter $CostPerCubicFt $CostPerCubicMeter $Operation");
								
								$Operation="DisplayCostPerCubicFootOrMeter";
								$output3 = shell_exec("python EstimateCosts.py $length $LengthUnit $width $WidthUnit $height $HeightUnit $UnitToConvertTo $MaterialType $CostPerSquareFt $CostPerSquareMeter $CostPerCubicFt $CostPerCubicMeter $Operation");
								
								$Operation="DisplayEstimatedCost";
								$output4 = shell_exec("python EstimateCosts.py $length $LengthUnit $width $WidthUnit $height $HeightUnit $UnitToConvertTo $MaterialType $CostPerSquareFt $CostPerSquareMeter $CostPerCubicFt $CostPerCubicMeter $Operation");
								
								
								if ($output == "" ) {
								} else {
									echo "<p style='color:white;font-size:1.2em;display:inline;'>".$output."</p>";
									echo "<br>";
								}
								if ($output2 == "" ) {
								} else {
									echo "<p style='color:white;font-size:1.2em;display:inline;'>".$output2."</p>";
									echo "<br>";
								}
								if ($output3 == "" ) {
								} else {
									echo "<p style='color:white;font-size:1.2em;display:inline;'>".$output3."</p>";
									echo "<br>";
								}
								if ($output4 == "" ) {
								} else {
									echo "<p style='color:white;font-size:1.2em;display:inline;'>".$output4."</p>";
									echo "<br>";
								}
							}
							
							
						?>
					</h2>	
				</div>	
				
				
				
				<div id="MaterialsFloatArea" class="float-child" align="right">
					
					<br>
					<br>
					<tbody id="materialsdata">
						<table align="center">
							<tr id="MaterialsArea">
								<th id="Materials_DATA_HeaderBox">Material Type</th>
								<th id="Materials_DATA_HeaderBox">$ per ft<sup>2</sup></th>
								<th id="Materials_DATA_HeaderBox">$ per m<sup>2</sup></th>
								<th id="Materials_DATA_HeaderBox">$ per ft<sup>3</sup></th>
								<th id="Materials_DATA_HeaderBox">$ per m<sup>3</sup></th>
							</tr>
							
							<tr id="MaterialsArea">
								<!--------------------------- MaterialType --------------------------->
								<td id="MaterialsRows">
									<div id="Columns2">
										<?php
											if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
											if (isset($_GET["results_per_page"])) { $results_per_page  = $_GET["results_per_page"]; } else { $results_per_page=15; };
											$start_from = ($page-1) * $results_per_page;
											$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
											
											$sql="select MaterialType from materials LIMIT $start_from, ".$results_per_page;

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
								
								<!--------------------------- CostPerSquareFt --------------------------->
								
								<td id="MaterialsRows">
									<div id="Columns2">
										<?php
											if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
											if (isset($_GET["results_per_page"])) { $results_per_page  = $_GET["results_per_page"]; } else { $results_per_page=15; };
											$start_from = ($page-1) * $results_per_page;
											$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
											
											$sql="select CostPerSquareFt from materials LIMIT $start_from, ".$results_per_page;

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
								
								<!--------------------------- CostPerSquareMeter --------------------------->
								
								<td id="MaterialsRows">
									<div id="Columns2">
										<?php
											if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
											if (isset($_GET["results_per_page"])) { $results_per_page  = $_GET["results_per_page"]; } else { $results_per_page=15; };
											$start_from = ($page-1) * $results_per_page;
											$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
											
											$sql="select CostPerSquareMeter from materials LIMIT $start_from, ".$results_per_page;

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
								
								<!--------------------------- CostPerCubicFt --------------------------->
								
								<td id="MaterialsRows">
									<div id="Columns2">
										<?php
											if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
											if (isset($_GET["results_per_page"])) { $results_per_page  = $_GET["results_per_page"]; } else { $results_per_page=15; };
											$start_from = ($page-1) * $results_per_page;
											$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
											
											$sql="select CostPerCubicFt from materials LIMIT $start_from, ".$results_per_page;

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
								
								<!--------------------------- CostPerCubicMeter --------------------------->
								
								<td id="MaterialsRows">
									<div id="Columns2">
										<?php
											if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
											if (isset($_GET["results_per_page"])) { $results_per_page  = $_GET["results_per_page"]; } else { $results_per_page=15; };
											$start_from = ($page-1) * $results_per_page;
											$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
											
											$sql="select CostPerCubicMeter from materials LIMIT $start_from, ".$results_per_page;

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
								
							</tr>
						</table>
					</tbody>
				</div>
			</div>
		</div>
				
		<div id="BottomOfPage">	
			<footer>
				<br>This website was created for CS5002 Senior Design Project
			</footer>
		</div>

	</body>

</html>