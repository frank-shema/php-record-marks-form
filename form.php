<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
          
        }
        
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f2f2f2;
        }

        form{
            margin: auto;
            width: 50vw;
           display: flex;
           flex-direction: column;
           justify-content: center;
            
        }
    </style>
</head>

<body>
    <form action="" method="POST">
        <fieldset>
            <h1>Enter the marks of students</h1>
            <label for="regno">RegNo</label><br>
            <input type="text" name="regno" ><br>

            <label for="cat">CAT</label><br>
            <input type="text" name="CAT" ><br>

            <label for="exam">Exam</label><br>
            <input type="text" name="exam" ><br>

            <label for="class">Class</label><br>
            <input type="text" name="class"><br>

            <button style="margin-top: 10px;">Save Marks</button>
        </fieldset>
    </form>
    
    <?php
        // Establish a connection to the database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "marks_management";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Retrieve form data
            $regno = $conn->real_escape_string($_POST["regno"]);
            $cat = floatval($_POST["CAT"]);
            $exam = floatval($_POST["exam"]);
            $class = $_POST["class"];
            $total = $cat + $exam;

            // Prepare the SQL statement
            $sql = "INSERT INTO marks (registration_number, cat, exam, class, total) 
                    VALUES ('$regno', '$cat', '$exam', '$class', '$total')";

            // Execute the SQL statement
            if ($conn->query($sql) === true) {
                echo "Marks saved successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        // Retrieve the marks from the database
        $sql = "SELECT registration_number, cat, exam, class, total FROM marks";
        $result = $conn->query($sql);

        // Display the table
        if ($result->num_rows > 0) {
            echo"<h1>The Entered Student Marks are:</h1>";
            echo "<table style='border-collapse: collapse;'>";
            echo "<tr><th>Registration Number</th><th>CAT</th><th>Exam</th><th>Class</th><th>Total</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["registration_number"]."</td>";
                echo "<td>".$row["cat"]."</td>";
                echo "<td>".$row["exam"]."</td>";
                echo "<td>".$row["class"]."</td>";
                echo "<td>".$row["total"]."</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No marks found.";
        }

        // Close the database connection
        $conn->close();
    ?>
</body>
</html>
