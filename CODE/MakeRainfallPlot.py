#import matplotlib.pyplot as plt 
import matplotlib
import pylab
import math
import os,sys
import cgi
import cgitb; cgitb.enable()
from matplotlib.pyplot import figure

with open('PythonErrorsMakeRainfallPlot.log', 'w') as log, open('xvalues.txt', 'r', encoding='utf-8') as x, open('yvalues.txt', 'r', encoding='utf-8') as y:
	try:
	
	#log = open("PythonErrorsMakeRainfallPlot.log", "w")
		content = x.readlines()
		content = [lines.strip() for lines in content] 
		xvalues=""
		yvalues=""
		for line in content:
			if line.find("xvalues") != -1:
				xvalues=line
		
		content = y.readlines()
		content = [lines.strip() for lines in content] 
		for line in content:
			if line.find("yvalues") != -1:
				yvalues=line

		xvalues = xvalues[18:-3]
		yvalues = yvalues[18:-3]
		xvals=xvalues.split(",")
		yvals=yvalues.split(",")
		xlist = list()
		ylist = list()
		for item in xvals:
			xlist.append(item)
		for item in yvals:
			ylist.append(float(item))
		
		miny = min(ylist)
		maxy = max(ylist)
		# xvals=list()
		# yvals=list()

		x.close()
		y.close()
		matplotlib.use( 'Agg' )
		
		figure(num=None, figsize=(6,5), facecolor='w', edgecolor='k')
		matplotlib.pyplot.plot(xvals,ylist)
		matplotlib.pyplot.xticks(rotation=90)
		# matplotlib.pyplot.yticks(miny,maxy)
		bottom, top = matplotlib.pyplot.ylim()
		matplotlib.pyplot.ylim(bottom, top)   # set the ylim to bottom, top
		matplotlib.pyplot.ylim(bottom, top)
		matplotlib.pyplot.title("Rainfall on UC Campus by Date")
		matplotlib.pyplot.xlabel("Date")
		matplotlib.pyplot.ylabel("Rainfall (inches)")
		matplotlib.pyplot.savefig('img.png')
		
		
	except Exception as e: 
		log.write("\nERROR: "+str(e)+"\n")
		#logger.log(1,e)
	
	log.close()