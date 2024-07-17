# School Management System

A web-based application to manage students, teachers, classes, and grades.

## Table of Contents

- [Introduction](#introduction)
- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## Introduction

The School Management System is designed to simplify the management of students, teachers, classes, and grades in an educational institution. The system allows administrators to easily add, view, and manage information related to students, teachers, classes, and grades.

## Features

- Add, view, and manage students
- Add, view, and manage teachers
- Add, view, and manage classes
- Add, view, and manage grades

## Installation

### Prerequisites

- [XAMPP](https://www.apachefriends.org/index.html) or any other web server with PHP and MySQL support
- Web browser

### Steps

1. Clone the repository:

    ```sh
    git clone https://github.com/yourusername/school-management-system.git
    ```

2. Move the project files to your web server's root directory (e.g., `C:/xampp/htdocs/school-management-system`).

3. Start your web server and MySQL server using XAMPP or another server.

4. Create a database named `school_management` and import the provided SQL file:

    ```sh
    mysql -u root -p school_management < path/to/database.sql
    ```

5. Update the database connection settings in `config.php`:

    ```php
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'school_management');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    ```

6. Open your web browser and navigate to:

    ```
    http://localhost/school-management-system
    ```

## Usage

### Adding a Student

1. Fill out the form under "Add Student".
2. Click "Add Student".

### Adding a Teacher

1. Fill out the form under "Add Teacher".
2. Click "Add Teacher".

### Adding a Class

1. Fill out the form under "Add Class".
2. Select a teacher from the dropdown.
3. Click "Add Class".

### Adding a Grade

1. Fill out the form under "Add Grade".
2. Select a student and a class from the dropdowns.
3. Enter the grade.
4. Click "Add Grade".

### Viewing Lists

- View lists of students, teachers, classes, and grades in their respective sections.

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository.
2. Create a new branch:

    ```sh
    git checkout -b feature/your-feature-name
    ```

3. Commit your changes:

    ```sh
    git commit -m 'Add some feature'
    ```

4. Push to the branch:

    ```sh
    git push origin feature/your-feature-name
    ```

5. Open a pull request.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
