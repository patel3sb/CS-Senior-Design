<!doctype html>
<html>
	<!-------------------- Misc. Webpage Settings ------------------------->
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="WebpageStyle16.css" rel="stylesheet" type="text/css"/>
		<meta charset="utf-8">
		<!-------------------- Webpage Tab Name ------------------------->
		<title>Rainfall on UC Campus - Structures</title>
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
				<table id="navButtonsTable" style="empty-cells:show; border-radius:40px; border:2px solid #ffffff;  border-style:solid" width=20px height=10px
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
					$MaterialType = $KgPerM3 = $LbsPerFt3 = $BuildingName = "";
					$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
					unset($sql);

					function TestInput($data) {
					  $data = trim($data);
					  $data = stripslashes($data);
					  $data = htmlspecialchars($data);
					  return $data;
					}
					?>
					
					<h3>Building Status + Erosion Estimator</h3>
					<h4>Please enter desired UC building then click "Calculate".</h4>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
						
						<tr>
							<td align="right">UC Building: </td>
								<td align="right">	
									<select name='BuildingName'>
										<?php
											$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
											$sql="select BuildingName from buildings;";
											$results=mysqli_query($connection,$sql);
											while($row=mysqli_fetch_array($results)){
												
												$BuildingName = $row['BuildingName'];

												echo '<option value="'.$BuildingName.'">'.$BuildingName.'</option>';
												echo "<br>";
												
											}
											mysqli_close($connection);
										?>
									</select>
									
								</td>
							</td>
						</tr>
								
						
						<input type="submit" name="submit" value="Calculate">  					
					</form>

						
					<h2>
						<?php
							if ($_SERVER["REQUEST_METHOD"] == "POST") {
							
							
								$BuildingName= $_POST['BuildingName'];
								
								$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
								$sql="select MaterialType from buildings where BuildingName='$BuildingName';";
								$results=mysqli_query($connection,$sql);
								
								while($row=mysqli_fetch_array($results)){	
									$MaterialType = $row['MaterialType'];
								}
								mysqli_close($connection);
					
								$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
								$sql2 = "SELECT DensityInLbsPerCubicFt FROM materials WHERE MaterialType='".$MaterialType."';";
								$result2 = mysqli_query($connection,$sql2);
								$row2 = mysqli_fetch_row($result2);
								$LbsPerFt3 = $row2[0];
								mysqli_close($connection);
								
								
								$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
								$sql3 = "SELECT YearConstructionCompleted FROM buildings WHERE BuildingName='".$BuildingName."';";
								$result3 = mysqli_query($connection,$sql3);
								$row3 = mysqli_fetch_row($result3);
								$YearConstructionCompleted = $row3[0];
								mysqli_close($connection);
								
								
								$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
								$sql4 = "SELECT SquareFootage FROM buildings WHERE BuildingName='".$BuildingName."';";
								$result4 = mysqli_query($connection,$sql4);
								$row4 = mysqli_fetch_row($result4);
								$SquareFootage = $row4[0];
								mysqli_close($connection);
								
								$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
								$sql5 = "SELECT ActualCost FROM buildings WHERE BuildingName='".$BuildingName."';";
								$result5 = mysqli_query($connection,$sql5);
								$row5 = mysqli_fetch_row($result5);
								$ActualCost = $row5[0];
								mysqli_close($connection);
								
								$Operation="DisplayNumberOfYearsSinceBuildingCreated";
								$output = shell_exec("python CalculateErosion.py $MaterialType $LbsPerFt3 $YearConstructionCompleted $SquareFootage $Operation");
								
								$Operation="PrintSqFt";
								$output2 = shell_exec("python CalculateErosion.py $MaterialType $LbsPerFt3 $YearConstructionCompleted $SquareFootage $Operation");
								
								$Operation="EstimateRainfall";
								$output3 = shell_exec("python CalculateErosion.py $MaterialType $LbsPerFt3 $YearConstructionCompleted $SquareFootage $Operation");
								
								$Operation="PrintDensity";
								$output4 = shell_exec("python CalculateErosion.py $MaterialType $LbsPerFt3 $YearConstructionCompleted $SquareFootage $Operation");
								
								$Operation="PrintTextInBox";
								$output5 = shell_exec("python CalculateErosion.py $MaterialType $LbsPerFt3 $YearConstructionCompleted $SquareFootage $Operation");
								
								$Operation="PrintStatus";
								$output6 = shell_exec("python CalculateErosion.py $MaterialType $LbsPerFt3 $YearConstructionCompleted $SquareFootage $Operation");

								$Operation="PrintReason";
								$output7 = shell_exec("python CalculateErosion.py $MaterialType $LbsPerFt3 $YearConstructionCompleted $SquareFootage $Operation");
								
								$Operation="EstimateErosion";
								$output8 = shell_exec("python CalculateErosion.py $MaterialType $LbsPerFt3 $YearConstructionCompleted $SquareFootage $Operation");
								echo "Submitted Building Name: ";
								echo "<p style='display:inline;font-size:1.2em;'>".$BuildingName."</p>";
								echo "<br>";
								echo $output;
								echo "<br>";
								if ($output2 == "" ) {
								} else {
									echo $output2;
									echo "<br>";
									
								}
								
								echo $output3;								
								echo "<br>";
								echo $output4;								
								echo "<br>";
								echo "<br>";
								echo "<div class='boxed'>$output5$output6</div>";							
								echo "<br>";
								echo $output7;								
								echo "<br>";
								echo "<br>";
								echo $output8;	
							
							}
							
							
						?>
					</h2>	
				</div>	
				
				<br>
				<br>
			<div id="MaterialsFloatArea" class="float-child" align="right">
				<tbody id="materialsdata">
					<table id="StructuresTable">
						<tr id="StructuresArea">
							<th id="Materials_DATA_HeaderBox">Building Name</th>
							<th id="Materials_DATA_HeaderBox">Material Type</th>
							<th id="Materials_DATA_HeaderBox">Year Constructed</th>
							<th id="Materials_DATA_HeaderBox">Size (Square Feet)</th>
							<th id="Materials_DATA_HeaderBox">Cost ($)</th>
						</tr> 
						
						<tr id="StructuresArea">
						
							<!--------------------------- BuildingName --------------------------->
							
							
							<td id="StructuresRows">
								<div id="Columns2">
									<?php
										/*
											BuildingName varchar(32) unique not null,
											MaterialType varchar(32),
											YearConstructionCompleted varchar(4) NOT NULL,
											EstLength varchar(32),
											EstWidth varchar(32),
											EstHeight varchar(32),
										*/
										$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
										$sql="select BuildingName from buildings;";
										$results=mysqli_query($connection,$sql);
										while($row=mysqli_fetch_array($results)){
											echo $row[0];
											echo "<br>";
											
										}
										mysqli_close($connection);
									?>
								</div>
							</td>
						
							<!--------------------------- MaterialType --------------------------->
							<td id="StructuresRows">
								<div id="Columns2">
									<?php
										$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
										$sql="select MaterialType from buildings ORDER BY buildings.BuildingName;";
										$results=mysqli_query($connection,$sql);
										while($row=mysqli_fetch_array($results)){
											
											echo $row[0];
											echo "<br>";
											
										}
										mysqli_close($connection);
									?>
								</div>
							</td>
							
							<!--------------------------- YearConstructionCompleted --------------------------->
							<td id="StructuresRows">
								<div id="Columns2">
									<?php
										$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
										$sql="select YearConstructionCompleted from buildings ORDER BY buildings.BuildingName;";
										$results=mysqli_query($connection,$sql);
										while($row=mysqli_fetch_array($results)){
											
											echo $row[0];
											echo "<br>";
											
										}
										mysqli_close($connection);
									?>
								</div>
							</td>
							
							<!--------------------------- Size (Square Feet) --------------------------->
							<td id="StructuresRows">
								<div id="Columns2">
									<?php
										$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
										$sql="select SquareFootage from buildings ORDER BY buildings.BuildingName;";
										$results=mysqli_query($connection,$sql);
										while($row=mysqli_fetch_array($results)){
											
											echo $row[0];
											echo "<br>";
											
										}
										mysqli_close($connection);
									?>
								</div>
							</td>
							
							<!--------------------------- ActualCost --------------------------->
							<td id="StructuresRows">
								<div id="Columns2">
									<?php
										$connection=mysqli_connect("localhost","root","","raspberrypi_seniordesign");
										$sql="select ActualCost from buildings ORDER BY buildings.BuildingName;";
										$results=mysqli_query($connection,$sql);
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
				
		<div id="BottomOfPage">	
			<footer>
				<br>This website was created for CS5002 Senior Design Project
			</footer>
		</div>

	</body>

</html>