#!/usr/bin/env python
import sys

log = open("PythonErrorsEstimateCosts.log", "w")

def convertStringsToValuesThatCanBeMultiplied(valueToBeConverted):
	convertedValue = ""
	if valueToBeConverted.find(".") != -1:
		#print("value to be converted to float: ",valueToBeConverted)
		#means theres a decimal so convert to float not int
		convertedValue=float(valueToBeConverted)
	else:
		#means theres NO decimal so convert to int not float
		#print("value to be converted to int: ",valueToBeConverted)
		convertedValue=int(valueToBeConverted)
	return convertedValue
	
def ConvertUnitToDesiredOutputUnit(value,valueUnit,UnitToConvertTo):
	if UnitToConvertTo == "feetcubed":
		if valueUnit == "meters":
			#1 meter = 3.28084 ft
			value=value*3.28084
		else:
			pass
			
	elif UnitToConvertTo == "meterscubed":
		if valueUnit == "feet":
			#1 ft = 0.3048 m
			value=value*0.3048
		else:
			pass
			
	elif UnitToConvertTo == "feetsquared":
		if valueUnit == "meters":
			#1 meter = 3.28084 ft
			value=value*3.28084
		else:
			pass

	elif UnitToConvertTo == "meterssquared":
		if valueUnit == "feet":
			#1 ft = 0.3048 m
			value=value*0.3048
		else:
			pass			

	else:
		print("Unknown unit type: ",UnitToConvertTo)
	
	return value


try:

	length=sys.argv[1]
	LengthUnit=sys.argv[2]
	width=sys.argv[3]
	WidthUnit=sys.argv[4]
	height=sys.argv[5]
	HeightUnit=sys.argv[6]
	UnitToConvertTo=sys.argv[7]
	MaterialType=sys.argv[8]
	CostPerSquareFt = sys.argv[9]
	CostPerSquareMeter = sys.argv[10]
	CostPerCubicFt = sys.argv[11]
	CostPerCubicMeter = sys.argv[12]
	Operation = sys.argv[13]
	#UnitToConvertTo="meters"
	
	# BuildingName = sys.argv[16]
	
	# print("BuildingName: ",BuildingName)
	
	
	# print("asdf")
	# if BuildingName != "none":
		# print("Building name does not apply to estimating costs. Set building name to 'none' and try again.")
		# return

	#print("MaterialType: ",MaterialType)
	#print("KgPerM3: ",KgPerM3)
	#print("LbsPerFt3: ",LbsPerFt3)
	#print("UnitToConvertTo: ",UnitToConvertTo)
	# print("CostPerSquareFt: ",CostPerSquareFt)
	# print("CostPerSquareMeter: ",CostPerSquareMeter)
	# print("CostPerCubicFt: ",CostPerCubicFt)
	# print("CostPerCubicMeter: ",CostPerCubicMeter)
	
	########################## CONVERT DATA TYPES TO VALUES THAT CAN BE MULTIPLIED #########################

	length=convertStringsToValuesThatCanBeMultiplied(length)
	width=convertStringsToValuesThatCanBeMultiplied(width)
	
	if height != "NA":
		height=convertStringsToValuesThatCanBeMultiplied(height)
	
	length=ConvertUnitToDesiredOutputUnit(length,LengthUnit,UnitToConvertTo)
	width=ConvertUnitToDesiredOutputUnit(width,WidthUnit,UnitToConvertTo)
	
	if height != "NA":
		height=ConvertUnitToDesiredOutputUnit(height,HeightUnit,UnitToConvertTo)	
	
	##########################################################################################################	
	
	if height != "NA":
		Volume=length*width*height
		Volume=str(Volume)
		if Volume.find(".") != -1:
			PeriodIdx=Volume.find(".")+3
			Volume=Volume[:PeriodIdx]
			Volume=float(Volume)
		else:
			Volume=int(Volume)
	
	
	Area=length*width
	Area=str(Area)

	if Area.find(".") != -1:
		PeriodIdx=Area.find(".")+3
		Area=Area[:PeriodIdx]
		Area=float(Area)
	else:
		Area=int(Area)
	

	# print(str(Volume)+" "+UnitToConvertTo)	
	# print(str(Area)+" "+UnitToConvertTo)
	
	#################DONE CALCULATING VOLUME########################
	
	#print(str(Volume)+" cubic "+UnitToConvertTo)
	
	EstimatedCost=0

	
	################## PERFORM COST ESTIMATION ######################

	printedWarning=False

	if UnitToConvertTo == "feetcubed":
		if height != "NA":	
			if Operation == "DisplayConvertingUnits":
				print("Converting to: cubic feet")
			elif Operation == "DisplayVolumeOrArea":
				print("Volume: "+str(Volume)+" cubic feet")	
			elif Operation == "DisplayCostPerCubicFootOrMeter":
				print("Cost per cubic foot: $",CostPerCubicFt)
			EstimatedCost=float(CostPerCubicFt)*float(Volume)
		else:
			if Operation == "DisplayEstimatedCost":
				print("Warning: if cubic units are chosen, a height must be given.")
				printedWarning=True
	elif UnitToConvertTo == "meterscubed": 
		if height != "NA":	
			if Operation == "DisplayConvertingUnits":
				print("Converting to: cubic meters")
			elif Operation == "DisplayVolumeOrArea":
				print("Volume: "+str(Volume)+" cubic meters")	
			elif Operation == "DisplayCostPerCubicFootOrMeter":
				print("Cost per cubic meter: $",CostPerCubicMeter)
			EstimatedCost=float(CostPerCubicMeter)*float(Volume)
		else:
			if Operation == "DisplayEstimatedCost":
				print("Warning: if cubic units are chosen, a height must be given.")
				printedWarning=True
	elif UnitToConvertTo == "feetsquared": 
		if Operation == "DisplayConvertingUnits":
			print("Converting to: square feet")
		elif Operation == "DisplayVolumeOrArea":
			print("Area: "+str(Area)+" square feet")	
		elif Operation == "DisplayCostPerCubicFootOrMeter":
			print("Cost per square foot: $",CostPerSquareFt)
		EstimatedCost=float(CostPerSquareFt)*float(Area)
	elif UnitToConvertTo == "meterssquared": 
		if Operation == "DisplayConvertingUnits":
			print("Converting to: square meters")
		elif Operation == "DisplayVolumeOrArea":
			print("Area: "+str(Area)+" square meters")	
		elif Operation == "DisplayCostPerCubicFootOrMeter":
			print("Cost per square meter: $",CostPerSquareMeter)
		EstimatedCost=float(CostPerSquareMeter)*float(Area)
	else:
		print("unknown unit type")
	
	#float or int
	#print("estimated cost: ",EstimatedCost)
	

	EstimatedCostStr=str(EstimatedCost)
	
	if EstimatedCostStr.find(".") != -1:
		PeriodIdx=EstimatedCostStr.find(".")+3
		EstimatedCostStr=EstimatedCostStr[:PeriodIdx]
	PeriodIdx=EstimatedCostStr.find(".")+2
	if EstimatedCostStr[PeriodIdx:] == "":
		#add an extra 0 to ensure we get a dollar amount in form $xxxx.xx
		EstimatedCostStr=EstimatedCostStr+"0"
	
	# print("Operation: ",Operation)
	# if Operation == "EstimatedCost":
	
	
	if UnitToConvertTo == "meterscubed" or UnitToConvertTo == "feetcubed": 
		if height != "NA":
			if Operation == "DisplayEstimatedCost":
				print("Estimated Cost: $"+EstimatedCostStr)
	else:
		if Operation == "DisplayEstimatedCost":
			print("Estimated Cost: $"+EstimatedCostStr)
		
		
except Exception as e: 
	log.write("\nERROR: "+str(e)+"\n")
	#logger.log(1,e)
	
log.close()


	