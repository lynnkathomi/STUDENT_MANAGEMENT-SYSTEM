<?php
// Configuration and Database Connection
$host = 'localhost';
$db = 'school_managment';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $db :" . $e->getMessage());
}

// Functions
function getStudents() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM students");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



function addStudent($name, $email) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO students (name, email) VALUES (:name, :email)");
    $stmt->execute(['name' => $name, 'email' => $email]);
}

function getTeachers() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM teachers");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addTeacher($name, $email) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO teachers (name, email) VALUES (:name, :email)");
    $stmt->execute(['name' => $name, 'email' => $email]);
}

function getClasses() {
    global $pdo;
    $stmt = $pdo->query("SELECT classes.*, teachers.name as teacher_name FROM classes LEFT JOIN teachers ON classes.teacher_id = teachers.id");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addClass($name, $teacher_id) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO classes (name, teacher_id) VALUES (:name, :teacher_id)");
    $stmt->execute(['name' => $name, 'teacher_id' => $teacher_id]);
}

function getGrades() {
    global $pdo;
    $stmt = $pdo->query("SELECT grades.*, students.name as student_name, classes.name as class_name FROM grades LEFT JOIN students ON grades.student_id = students.id LEFT JOIN classes ON grades.class_id = classes.id");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addGrade($student_id, $class_id, $grade) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO grades (student_id, class_id, grade) VALUES (:student_id, :class_id, :grade)");
    $stmt->execute(['student_id' => $student_id, 'class_id' => $class_id, 'grade' => $grade]);
}

// Handle Form Submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['student_name']) && isset($_POST['student_email'])) {
        addStudent($_POST['student_name'], $_POST['student_email']);
    } elseif (isset($_POST['teacher_name']) && isset($_POST['teacher_email'])) {
        addTeacher($_POST['teacher_name'], $_POST['teacher_email']);
    } elseif (isset($_POST['class_name']) && isset($_POST['teacher_id'])) {
        addClass($_POST['class_name'], $_POST['teacher_id']);
    } elseif (isset($_POST['student_id']) && isset($_POST['class_id']) && isset($_POST['grade'])) {
        addGrade($_POST['student_id'], $_POST['class_id'], $_POST['grade']);
    }
   
}

// Get Lists
$students = getStudents();
$teachers = getTeachers();
$classes = getClasses();
$grades = getGrades();
?>

<!DOCTYPE html>
<html>
<head>
    <title>School Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        h1 {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }
        h2 {
            color: #333;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 5px;
        }
        form {
            background-color: white;
            padding: 20px;
            margin: 20px auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            max-width: 600px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            background-color: white;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .container {
            padding: 20px;
        }
    </style>
</head>
<body>
    <h1>School Management System</h1>
    <div class="container">
        <h2>Add Student</h2>
        <form action="index.php" method="post">
            <label for="student_name">Name:</label>
            <input type="text" id="student_name" name="student_name" required>
            <label for="student_email">Email:</label>
            <input type="email" id="student_email" name="student_email" required>
            <input type="submit" value="Add Student">
        </form>

        <h2>Student List</h2>
        <ul>
            <?php foreach ($students as $student) : ?>
                <li><?php echo $student['name'] . ' (' . $student['email'] . ')'; ?></li>
            <?php endforeach; ?>
        </ul>

        <h2>Add Teacher</h2>
        <form action="index.php" method="post">
            <label for="teacher_name">Name:</label>
            <input type="text" id="teacher_name" name="teacher_name" required>
            <label for="teacher_email">Email:</label>
            <input type="email" id="teacher_email" name="teacher_email" required>
            <input type="submit" value="Add Teacher">
        </form>

        <h2>Teacher List</h2>
        <ul>
            <?php foreach ($teachers as $teacher) : ?>
                <li><?php echo $teacher['name'] . ' (' . $teacher['email'] . ')'; ?></li>
            <?php endforeach; ?>
        </ul>

        <h2>Add Class</h2>
        <form action="index.php" method="post">
            <label for="class_name">Class Name:</label>
            <input type="text" id="class_name" name="class_name" required>
            <label for="teacher_id">Teacher:</label>
            <select id="teacher_id" name="teacher_id" required>
                <?php foreach ($teachers as $teacher) : ?>
                    <option value="<?php echo $teacher['id']; ?>"><?php echo $teacher['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Add Class">
        </form>

        <h2>Class List</h2>
        <ul>
            <?php foreach ($classes as $class) : ?>
                <li><?php echo $class['name'] . ' (Teacher: ' . $class['teacher_name'] . ')'; ?></li>
            <?php endforeach; ?>
        </ul>

        <h2>Add Grade</h2>
        <form action="index.php" method="post">
            <label for="student_id">Student:</label>
            <select id="student_id" name="student_id" required>
                <?php foreach ($students as $student) : ?>
                    <option value="<?php echo $student['id']; ?>"><?php echo $student['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <label for="class_id">Class:</label>
            <select id="class_id" name="class_id" required>
                <?php foreach ($classes as $class) : ?>
                    <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <label for="grade">Grade:</label>
            <input type="text" id="grade" name="grade" required>
            <input type="submit" value="Add Grade">
        </form>

        <h2>Grade List</h2>
        <ul>
            <?php foreach ($grades as $grade) : ?>
                <li><?php echo $grade['student_name'] . ' - ' . $grade['class_name'] . ': ' . $grade['grade']; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
