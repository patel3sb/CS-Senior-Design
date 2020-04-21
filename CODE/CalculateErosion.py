#!/usr/bin/env python
import sys
from datetime import date

log = open("PythonErrorsCalculateErosion.log", "w")

try:
	MaterialType=sys.argv[1]
	LbsPerFt3=sys.argv[2]
	YearConstructionCompleted=sys.argv[3]
	SquareFootage=sys.argv[4]
	Operation=sys.argv[5]
		
	############### DETERMINE ESTIMATE OF RAINFALL ON STRUCTURE #################	
		
	#In 2011, Cincinnati got 73.28 inches of precipitation. 
	#In 1990, Cincinnati got 57.58 inches of precipitation.
	#In 2018, Cincinnati saw 55.90 inches of precipitation.	
	#avg: 62.253
	
	CurrentYear = int(date.today().year)
	YearConstructionCompleted=int(YearConstructionCompleted)
	ElapsedYearsSinceConstruction=CurrentYear-YearConstructionCompleted
	#62.253 average yearly rainfall in inches
	EstimatedRainfall=float(ElapsedYearsSinceConstruction)*62.253
	EstimatedRainfall=str(EstimatedRainfall//12.0)
	
	if EstimatedRainfall.find(".") != -1:
		PeriodIdx=EstimatedRainfall.find(".")+1
		
	if EstimatedRainfall.find(".") != -1:
		if EstimatedRainfall[PeriodIdx:] == "0":
			if(len(EstimatedRainfall[PeriodIdx:]) == 1):
				#if value ends in .0, remove this
				EstimatedRainfall=EstimatedRainfall[:-2]
	if EstimatedRainfall.find(".") != -1:
		PeriodIdx=EstimatedRainfall.find(".")+3
		EstimatedRainfall=EstimatedRainfall[:PeriodIdx]
		EstimatedRainfall=float(EstimatedRainfall)
	else:
		EstimatedRainfall=int(EstimatedRainfall)
	
	BadStatus="<p style='color:red'>BAD</p>"
	GoodStatus="<p style='color:#90ee90'>Good</p>"
	FairStatus="<p style='color:orange'>Fair</p>"
	
	if Operation == "DisplayNumberOfYearsSinceBuildingCreated":
		print("Years since construction: <p style='font-size:1.2em;display:inline;'>"+str(ElapsedYearsSinceConstruction)+"</p>")
	elif Operation == "PrintSqFt":
		if SquareFootage.find("NotAvailable") == -1:
			print("Square footage: <p style='font-size:1.2em;display:inline;'>"+str(SquareFootage)+" cubic feet</p>")	
	elif Operation == "EstimateRainfall":
		print("Estimated Structure Rainfall: <p style='font-size:1.2em;display:inline;'>"+str(EstimatedRainfall)+" feet</p>")
	elif Operation == "PrintDensity":
		print("Density of "+MaterialType+": <p style='font-size:1.2em;display:inline;'>"+str(LbsPerFt3)+" lbs/ft^3</p>")
	elif Operation == "PrintTextInBox":
		print("Status of Building: ")
	
	################################## CALCULATE ESTIMATED EROSION #######################################
	#source for wood material types: https://www.fpl.fs.fed.us/documnts/pdf2001/willi01a.pdf	
	#in this site, the amount of erosion / lost material in micrometers is given for pine wood. So, determine erosion for other materials using the following info:
	
		#the density of pine wood is on average 26.5 lbs/ft^3 (source: google search, pops up at the top)
		#if 1500 micrometers are lost every 15 years, thats ~100 micrometers every year lost when density is 26.5 lbs/ft^3
		#pine (26.5lbs/ft^3) loses ~100 micrometers every year = 10000 square micrometers = .0000155 square inches lost per year
	
	#Therefore: 
	#oak, density of 47 lbs/ft^3, would lose 100*(26.5/47) = 56.38 micrometers
		
	#EQUATION:
	#1 square micrometer = 0.00000000155 square inches
	
	ErosionLoss = ElapsedYearsSinceConstruction*((100*(26.5/float(LbsPerFt3)))*0.00000000155)
	
	##########################################################################################################
	
	Status=""
	if ElapsedYearsSinceConstruction > 50:
		if float(LbsPerFt3) >= 150.0:
			Status=FairStatus
			if Operation == "PrintReason":
				print("<p style='display:inline;color:white;'>-Reason: Building age > 50 years. However, building is made of "+MaterialType+", so status = FAIR not BAD.</p>")
			if Operation == "EstimateErosion":
				print("<p style='display:inline;color:white;'>-Erosion: negligible, material density > 150 Lbs/Ft^3</p>")
		else:
			Status=BadStatus
			if Operation == "PrintReason":
				print("<p style='display:inline;color:white;'>-Reason: Building age and density are less than ideal.</p>")
			if Operation == "EstimateErosion":
				if SquareFootage.find("NotAvailable") == -1:
					print("<p style='display:inline;color:white;'>-Erosion: An estimated "+str(ErosionLoss)+" in<sup>2</sup> has been lost due to erosion, primarily caused by rain/wind.</p>")
	else: #Building is less than 50 years old
		if float(LbsPerFt3) >= 150.0:
			Status=GoodStatus
			if Operation == "PrintReason":
				print("<p style='display:inline;color:white;'>-Reason: Building age < 50 years, high density")
			if Operation == "EstimateErosion":
				print("<p style='display:inline;color:white;'>-Erosion: negligible, material density > 150 Lbs/Ft^3</p>")
		else:
			#could be good or bad
			if ElapsedYearsSinceConstruction < 25:
				Status=GoodStatus
				if Operation == "PrintReason":
					print("<p style='display:inline;color:white;'>-Reason: Building age < 25 years")
				if Operation == "EstimateErosion":
					if SquareFootage.find("NotAvailable") == -1:
						print("<p style='display:inline;color:white;'>-Erosion: An estimated "+str(ErosionLoss)+" in<sup>2</sup> has been lost due to erosion, primarily caused by rain/wind.</p>")
			elif ElapsedYearsSinceConstruction > 25:
				Status=FairStatus
				if Operation == "PrintReason":
					print("<p style='display:inline;color:white;'>-Reason: Material type is not dense (is less than 150 lbs/ft<sup>3</sup>), and building age > 25 years")
				if Operation == "EstimateErosion":
					if SquareFootage.find("NotAvailable") == -1:
						print("<p style='display:inline;color:white;'>-Erosion: An estimated "+str(ErosionLoss)+" in<sup>2</sup> has been lost due to erosion, primarily caused by rain/wind.</p>")
			else:
				print("Error in logic. Are the DB values correct?")
	
	

	
	
	if Operation == "PrintStatus":
		print(Status)

	
	#print(str(Volume)+" cubic "+UnitToConvertTo)
	
	
	
	# source for wood material types: https://www.fpl.fs.fed.us/documnts/pdf2001/willi01a.pdf
	# 
		
		
except Exception as e: 
	log.write("\nERROR: "+str(e)+"\n")
	#logger.log(1,e)
	
log.close()


	