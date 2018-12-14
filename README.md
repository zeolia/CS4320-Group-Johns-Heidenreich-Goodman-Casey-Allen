#Group 11 - Improved I.T. Inventory System
##Electronic Archive Guide

###E-Archive Guide written by Elliot Goodman and Aaryn Johns

####All File Names and Descriptions

####Exact process of how to compile your source code and build a runnable file

Establish a web hosting site for the application to be run from. Alter the MySQL credentials in the code to match that of your website. In the MySQL workbench of your choice connected to your website, establish schema of tables that match that from our Reports. Upload all code files to your HTDocs folder and navigate to index.php to begin using the application.

####Where to find the runnable file

 As the application is a web page, you need only navigate to the index.php at itinventorysystem.epizy.com to access and run it.

####How exactly to run the runnable – what are the allowed input parameters/Describe the allowed values of all parameters that need to be entered while running your program

Use the Add Item page to add technology devices to the database. Use the Add User page to add owners of devices. The only parameters we have are for validly defined pawprints to link to devices and for searching for devices that are actually in the database.

When the webpage has loaded, the full Devices table will be displayed. Above this table, aligned left, is a text field stating “Search here” with a “Search Devices” button to its right, and “Add Device”, “Add User”, and “View Relegated Devices” buttons below the text field. Entering a string into the “Search here” text field then clicking the “Search Devices” button will check every attribute of every record in the Devices table for matching strings. 

Clicking the “Add Device” and “Add User” will redirect you to pages of the same name 
and implied function. Both the “Add Device” and “Add User” pages allow you to put a new record into the Device or User table, and have a variety of text fields that correspond to the attribute columns every entry in the database has. At the bottom of each page is a “submit” button which sends the input information to the database to be logged.

	Back on the main page, each record has an “update” and “delete” button in their rightmost two columns. Upon clicking the former button, you are redirected to the “Edit a Device” page. It is formatted exactly like the “Add a Device” page, but upon clicking the “submit” button, the record whose “update” button you clicked will have its information overwritten with whatever was just entered.
	
	Finally, the aforementioned delete button on the far right column can be clicked to “relegate” a device. When clicked, the device does not disappear, but rather its “Date Relegated” attribute is updated with the time the record’s “delete” button was clicked. Normally, the delete button would only be clicked when a device is being officially junked or recycled. The record relegated will remain in the table for clerical purposes.

	As all functionalities are mapped to various menus and buttons, there are no parameters needed to use the webpage’s functions. Here’s a list of the back-end functions used, and what they do:

run (controller): switches between use cases, leading off with the full inventory

inventory (controller): calls getInventory in model and generateInventoryHTML in view

relegatedInventory (controller): no actual functionality currently

getInventory (model): Takes in a string variable called “message”.  Message becomes the error if any sql statements fail. This function posts the array pulled from the database.

presentInventory (view): Takes in an array called “devices” from post and a string argument called “message”. Outputs an html page using those devices at that message.

searchDevices (model): Takes in nothing. Retrieves the string used to search the database through the Post array, and generates an array of devices to post.

deleteDevice (model): Retrieves the id of the element to be deleted from the database from the Post array, changes the relegation date to the current timestamp

presentAddUser (view): Generates a page that has input fields for First Name, Last Name, Pawprint, Office Number, and Office Letter, if applicable, along with a submit button.

addUser (model): Takes the above information from Post and inserts an element into the database.

presentAddDevice (view): see presentAddUser but for the information: User, Serial Number, Brand, Type, Model, Department, and MoCode

addDevice (model): see addUser for the addDevice information

beginUpdateDevice (model): retrieves the id of the device to be updated from Post, and fills in input fields with the current information, to be updated.

updateDevice (model): see addDevice


####If authentication is necessary, provide some example user IDs and passwords that will work

Authentication is not necessary to run the Improved I.T. Inventory System.

####PDF  files  containing  the  entire  Report  1  and  Report  2  as  these  were  originally  submitted,  not  as modified as part of Report 3. PDF file containing the entire Report 3 as in the version submitted earlier.  The report should appear as a single file.

PDFs of Reports 1, 2, and 3 are available in the folder marked Reports.

####Microsoft PowerPoint files containing slides you used for your first and second demo.

Folders of our submissions after each Demo are available in the folder marked Demos.


####Complete project source code (Java files, or other programming or markup language, if such is used)/Images or button icons loaded by the program when run/Shell-scripts, CGI scripts, HTML files, and any and all other files needed to run the program

All code is available in this Git Repository

####Database tables and files or plain files containing example data to run the program

An example of data running our program is available at itinventorysystem.epizy.com .

####Anything else that your program requires to be run

Once you have altered the credentials to match that of your MySQL database, a reliable internet connection and internet-capable device is all that’s necessary.

####Unit and Integration Tests

We are expecting correct input to work correctly and expecting incorrect input to return error messages. Our fields are so open-ended, though, that we don't have very much incorrect input possible.
