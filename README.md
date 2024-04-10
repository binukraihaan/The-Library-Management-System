
# Libraria | The Library Management System

This project is a PHP-based web application designed to manage library operations efficiently. It allows librarians to organize books, manage users, handle borrowing and returns, and more.
Not only that this project allows users to find books by it's name, ISBN number and Author. As well as this project allows user to find the relavant book by its location.



Features


Fine Management: Track fines for overdue items and manage payments.
Search and Discovery: Allow users to search for library items based on various criteria.


License
This project is licensed under the MIT License.



## Features

- User Management : 
Register and manage library users (students, teachers, etc.).

- Catalog Management : 
Organize and maintain a catalog of library materials, including books, newspapers, etc.

- Borrowing and Returning : 
Facilitate the process of borrowing and returning library items.

- Access Control : 
Implement security measures to ensure only authorized users (admins and users) can perform certain actions.

- Reporting and Analyzing :
Generate reports on library usage, circulation statistics, popular items, chart mesurements, etc.

- BarCode Gnerating :
From Our System we have provided the special feature for users which is Barcode generation. Here the librarian can generate a barcode for each user.

## Deployment

 - To deploy **Libraria**, run

```bash
 gh repo clone gh repo clone binukraihaan/The-Library-Management-System
```
 - Navigate to Project Directory: 
 ```
 cd library-management-system
 ```
 - Import Database:
 Import the provided SQL file ```db.sql``` into your MySQL database.
  - Configuration: 
  Update the database connection settings in both ```includes/conn.php``` and ```admin/includes/conn.php``` files.
   - Run the Application: 
   Start a local PHP server (XAMMP, WAMP, LAMP, MAMP) and navigate to ```http://localhost/yourdirectry``` in your web browser.
## Screenshots

 - Main View 
![App Screenshot](https://github.com/devkingsDevs/Libraria---The-Library-Management-System/blob/main/images/ss/main_view.jpg)
 - Admin Dashboard
![App Screenshot](https://github.com/devkingsDevs/Libraria---The-Library-Management-System/blob/main/images/ss/main_dashboard.jpg?raw=true)

 - Books Catalog 
![App Screenshot](https://github.com/devkingsDevs/Libraria---The-Library-Management-System/blob/main/images/ss/books.jpg?raw=true)

 - Borrowing Section 
![App Screenshot](https://github.com/devkingsDevs/Libraria---The-Library-Management-System/blob/main/images/ss/borrow.jpg?raw=true)

 - Returning Section 
![App Screenshot](https://github.com/devkingsDevs/Libraria---The-Library-Management-System/blob/main/images/ss/return.jpg?raw=true)

 - Unique Barcode Generation
 ![App Screenshot](https://github.com/devkingsDevs/Libraria---The-Library-Management-System/blob/main/images/ss/generate_barcode.jpg?raw=true)

An explanation video footage will be available soon.

## License

This project is licensed under the [MIT](https://choosealicense.com/licenses/mit/) License.
