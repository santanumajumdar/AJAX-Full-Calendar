## Introduction

Use the 'connection.php' found at 'includes' to configure your database (in case one click install fails)


This demo does support multi-users private events. 
(Copy of demo 1 with different loader.php, session.php, cal_save.php and cal_quicksave.php implemented)


The Basic Idea:
You add users to have full access to the calendar, each user that creates a event is visible just to him. If you want each user
to register themself you can implement that. 

------------------------------------------------------------------------------------------------------------------------------------------------
Preventive Questions:
------------------------------------------------------------------------------------------------------------------------------------------------
Q: Where the database connection is found?
A: The database connection is found at 'includes' folder its named 'connection.php'. For some reason if you found that file outside the includes
folder remove it. One click install will setup this file for you if you don't know what I am saying.

Q: Why I am not seeing any events?
A: By default when you install the system no events is there, create your events and they will automatically appear on the calendar.

Q: Why I am adding events and it`s not being saved or displayed to the calendar?
A: You installed it wrong, your database connections are not created or are not valid or even
   you could be using a incompatible PHP version or you have issues with your mysql or server.

Q: Why I am unable to login?
A: Please check if you are using the correct credentials or if your database connections are ok as well as your user table.
By default use: demouser or testuser with the password: 12345

Q: How can I use my own login system?
A: You can use your own login system by using a main file and incorporating the "Simple Demos" and protect the pages and use the proper loader.php from sources or from this demo and include your own session file inside the loader.php

Any Other Questions? Please e-mail me on my codecanyon profile page.
