Senior Design CS5002 -- User Documentation

How to Use Our Website

UC Rainfall Analysis

Group:\
Collin Fox

Smit Patel

Prathamesh B.\
Jessica Doyal

**Table of Contents**

**[1 Objective. 1](#_Toc37770509)**

**[2 DEXcenter Installer Enhancements. 1](#_Toc37770510)**

**[2.1 Visual Appearance -- GUI Installer  2](#_Toc37770511)**

**[2.2 Panel Organization Changes. 2](#_Toc37770512)**

**[2.3 Comments in IA Project File. 4](#_Toc37770513)**

**[2.4 Clarity and Grammar  4](#_Toc37770514)**

**[2.5 Miscellaneous. 5](#_Toc37770515)**

**[3 The Future of DEXcenter's InstallAnywhere Project File. 6](#_Toc37770516)**

**[3.1 Finish Removal of AIX/Unix Code. 7](#_Toc37770517)**

**[3.2 Installer Size Concerns. 7](#_Toc37770518)**

**1 ****Objective**

O

**2 ****DEXcenter Installer Enhancements**

Enhancements to the DEXcenter installer were made while working on the removal of OS-specific rules and rows from our IA code, typically while searching for a cause of an issue in the IA project file or while searching for the existence of a setting. Several installer steps, features, and settings like default Linux install method were discovered, and edited as seen fit. These enhancements, although requiring relatively little time to implement, are still valuable changes and is a big step in the right direction towards the upcoming DEXcenter V13 release. Testing changes was performed concurrently with testing Linux and Windows silent installs - editing a row in the IA project file may cause errors in the non-silent install, so visual changes were able to be tested while also confirming the silent-install changes don't negatively impact the Windows GUI installer. Below is the full list of installer enhancements made. Note: Because the panel screenshots were taken from a higher resolution monitor than is typically used, the panels in the images below are slightly more zoomed out than they would be when ran from a normal resolution screen.

**2.1 ****Visual Appearance -- GUI Installer**

The most visually-obvious change made to the DEXcenter installer is the theme. A more modern theme was applied:

![](file:///C:/Users/Collin/AppData/Local/Temp/msohtmlclip1/01/clip_image002.jpg)

(Note: since my installer screenshots were taken from a very high-resolution screen, the install steps icons may appear blurry, but they look fine when ran on a normal resolution)

**2.2 ****Panel Organization Changes**

The number of panels/windows shown during DEXcenter installation was reduced by merging several similar panels into one, without compromising functionality or simplicity. The following panel changes were made:

 I. Panels requiring the user to enter file/folder paths were merged into one panel with 4 path entries, see above image ("**Specify Paths**".) All path entry panels now lie in "Specify Paths", other than one path for entry in "License Information" panel

 II. Warning message about running as admin were merged with the existing installer info page ("install anywhere will guide you through the installation process ...") New panel is called "**Notice**"

 III. Removed panel where the user enters the webdata directory, Java directory, and DB type all in same page (these are different things and should be separated.) Now, the Java directory is entered from the "Specify Paths" page (see image above) and the DB type is selected from the same page you enter your DB credentials:

![](file:///C:/Users/Collin/AppData/Local/Temp/msohtmlclip1/01/clip_image004.jpg)

As you can see, the default ports are now listed -- this avoids the issue of using the wrong DB type's port (e.g. using MySQL port for Mssql, etc.) which requires reinstallation.

Before, there were 6 rows in the IA code for setting DB information, one for DXS installs, one for DTS installs, and for each of these there being 3 possible DB types (2 x 3 = 6 rows just for DB information)

Since the suggestions/default values for DB information are dependent on your own DB configuration, there will not be suggested default values unless they exist in your installer.properties. This requires the user to be more aware of the values they are entering and be less likely to enter incorrect values - the DB type is explicitly stated on the same page, just above where DB information is entered.

*The installer will skip the "DTS information" page if "DXS/DTS" was selected in the "Installation Type" page.

 IV. The installation panel where the user indicates yes or no to CADIQ install was removed - The CADIQ installation directory is now prompted in the "Specify Paths" panel, with "Optional" in parenthesis, denoting this can be left blank. Leaving this blank is equivalent to choosing "No" to CADIQ install. Since users may want to install CADIQ after dexcenter is installed, there no longer is a check for whether the CADIQ directory exists. This is fine and can be edited later in SYSTEM.CFG anyways. There is still a check for the existence of the installation directory, Java 8 JDK path, and license file, as there are required to be correctly set for dexcenter to function and the installation to complete.

**2.3 ****Comments in IA Project File**

There are clearly defined sections in the IA project file now denoted by comments that are hard to miss. Reorganizing the panels enabled these comments to be accurate / in order.

![](file:///C:/Users/Collin/AppData/Local/Temp/msohtmlclip1/01/clip_image006.jpg)

**2.4 ****Clarity and Grammar**

-Removed capitalization of every word just before beginning of license agreement (did NOT edit license text file)

-Fixed spelling & grammatical issues, particularly in the "Notice" and "Wildfly Information" panels (see image below)

![](file:///C:/Users/Collin/AppData/Local/Temp/msohtmlclip1/01/clip_image008.jpg)

**2.5 ****Miscellaneous**

-The Windows installer now sets PYTHONHOME system variable and adds it to the beginning of PATH variable (does NOT replace your PATH system variable.) Setting Linux system variables using built in InstallAnywhere code doesn't work, so it wasn't implemented for Linux.

-Edited default Java JDK to be in "Program Files" folder and not "Program Files (x86)" folder. Most machines are 64-bit now and the installer will get stuck at 100% if a 32-bit JDK is specified.

-Edited default CADIQ path to be v12.3.1

-Added the below red-boxed text to the "Notice" panel:

![](file:///C:/Users/Collin/AppData/Local/Temp/msohtmlclip1/01/clip_image010.png)

-Added the below text to "Set External URL" page

![](file:///C:/Users/Collin/AppData/Local/Temp/msohtmlclip1/01/clip_image012.png)

Typically people expect a URL to contain http or https, however, if http or https are specified in the external URL, system parameters may have an **extra** http/https at the beginning of them, causing issues (primarily with Email and logging into dexcenter.) So, the above comment was added.

-Installer no longer builds AIX (removed from build targets to speed up testing, but might as well keep this change since we no longer support/test AIX.) Also edited BuildInstaller.bat so it doesn't attempt to copy the AIX installer, as it will no longer exist. Although AIX was removed from the build targets (i.e. BuildInstaller.bat no longer will produce an aix DEXcenter installer), changes are still needed to remove AIX code entirely, particularly the AIX python files in /release and /exchange projects. For now, simply removing AIX from the build targets will not cause errors with builds and will drastically speed up build & testing time.

-The Linux installer now defaults to silent install, and no longer requires the "-i silent" argument. If we choose to implement a GUI installer for Linux in the future, this silent argument can be overridden by specifying "-i GUI" instead.

**3 ****The Future of DEXcenter's InstallAnywhere Project File**

The DEXcenter Installer is around 1.3GB (as of version 12.2.2.1). To reduce the amount of memory DEXcenter occupies on a user's machine, several changes can be made, which also have the potential to speed up the build and installation process. There are a few other small changes that could be made if desired, such as:

-Add comment about DTS DB info panel being purposefully skipped if DXS/DTS was selected

-Try getting installer to say "DXS**+**DTS" instead of "DXS**/**DTS"

-Replace text containing "Default Ports" and make it say "Default Database Ports" instead

-May want to put dexcenter logo in middle of "Installing..." page, directly on top of blue

 fade/gradient

-Make a note to the user that if they leave the cadiq path blank it'll be equivalent to saying

no to cadiq install (already relatively obvious with the "Optional" text next to the CADIQ path

input box)

-Make progress bar a slightly lighter shade of blue

**3.1 ****Finish Removal of AIX/Unix ****Code**

Although AIX was removed from the build targets (i.e. BuildInstaller.bat no longer will produce an aix DEXcenter installer), changes are still needed to remove AIX code entirely, particularly the AIX python files in /release and /exchange projects. For now, removing AIX from the build targets will not cause errors with builds and will drastically speed up build & testing time.

Due to the low demand for AIX changes, we have not used or tested any AIX DEXcenter installers for quite some time. I have received approval to remove the AIX code, but this will hopefully be done in the near-future.

**3.2 ****Installer Size Concerns**

As the size of the DEXcenter installer increases with each new feature we add, the time required to build a DEXcenter Installer increases, as well as the time required to install DEXcenter. The size of the installer can be addressed by viewing a DEXcenter installer from 7-zip, then examining the files in each folder. PDFTDP "hoops" files take up a significant amount of space. Removal of AIX code is another way the installer size can be reduced.
