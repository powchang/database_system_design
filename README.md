# database_system_design
Database Management System Design Source Code

The project discussed is the development of a library management system using a MySQL database. The system is designed to help library authorised staffs to manage books, authors, publishers, categories, members, loans, reservations, and penalties. The system allows only the staffs who have access to the on-promises server to add, modify, and delete records in the database, as well as perform search and update operations. The project provides a user-friendly interface for librarians and members to manage library resources more efficiently and reliably.
The value proposition of the project is to provide a more organized and efficient way to manage library resources. The system allows librarians to keep track of book loans, reservations, and penalties, which helps them to manage the library more effectively. Members can also use the system to search for books and reserve them, which makes the borrowing process more convenient.
Overall Architecture Design:
A 3-tier architecture using technology stack, PHP, MySQL and Javascript together with HTML/CSS were implemented in this project.
Presentation tier:
The presentation tier is responsible for handling the user interface and displaying information to users. In this tier, we will create HTML, CSS, and JavaScript files to build the user interface. These files will be hosted on a web server such as Apache.
Application tier:
The application tier handles the business logic and processes requests from the presentation tier. In this tier, we will create PHP files to handle the business logic of the application. These PHP files will communicate with the data tier to retrieve and store data.
Data tier:
The data tier manages the storage and retrieval of data. In this tier, we will create a MySQL database to store the data. We will also create a PHP file to establish a connection with the database and perform database operations such as inserting, updating, deleting, and retrieving data.
