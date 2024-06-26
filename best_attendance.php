<!DOCTYPE html>
<html>

<head>
    <title>Best Attendance of the Month</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            background-color: #141414;
        }

        th,
        table,
        td,
        h2 {
            color: white;
            font-family: sans-serif;
        }

        h1 {
            color: white !important;
            text-align: center !important;
            margin-bottom: 50px;
            font-size: bold;
        }

        .btn {
            color: white !important;
            background-color: #141414 !important;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-weight: 400;
            border-color: white !important;
        }

        .btn:hover {
            color: black !important;
            background-color: white !important;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>CAFE CERVEZA ATTENDANCE AND PAYROLL SYSTEM</h1>
        <h2>Best Attendance of the Month</h2>
        <a href="index.php" class="btn mb-3">Back</a>

        <table class="table">
            <thead>
                <tr>
                    <th colspan="8">Best Attendance for <?php echo date('F Y'); ?></th>
                </tr>
                <tr>
                    <th>Rank</th>
                    <th>Employee ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Attendance Count</th>
                    <th>Best Attendance GIF</th>
                </tr>
            </thead>
            <tbody>
                <?php

                include 'conn.php';

                function generateTrophyURL1()
                {
                    return "https://github-profile-trophy.vercel.app/?username=uhrzel&title=Stars";
                }
                function generateTrophyURL2()
                {
                    return "https://github-profile-trophy.vercel.app/?username=reydelshit&title=Stars";
                }
                function generateTrophyURL3()
                {
                    return "https://github-profile-trophy.vercel.app/?username=aynjel&title=Stars";
                }

                $sql = "SELECT 
                            e.employee_id,
                            e.firstname,
                            e.lastname,
                            COUNT(a.id) AS attendance_count
                        FROM 
                            employees e
                        LEFT JOIN
                            attendance a ON e.id = a.employee_id 
                            AND MONTH(a.date) = MONTH(CURRENT_DATE()) 
                            AND YEAR(a.date) = YEAR(CURRENT_DATE()) 
                            AND a.status = 1
                        GROUP BY 
                            e.employee_id
                        ORDER BY 
                            attendance_count DESC
                        LIMIT 3";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $rank = 1;
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo '<td style="font-size: 16px; font-weight: bold; font-family: Arial, sans-serif;">' . $rank . '</td>';
                        echo '<td style="font-size: 16px; font-weight: bold; font-family: Arial, sans-serif;">' . $row["employee_id"] . '</td>';
                        echo '<td style="font-size: 16px; font-weight: bold; font-family: Arial, sans-serif;">' . $row["firstname"] . '</td>';
                        echo '<td style="font-size: 16px; font-weight: bold; font-family: Arial, sans-serif;">' . $row["lastname"] . '</td>';
                        echo '<td style="font-size: 16px; font-weight: bold; font-family: Arial, sans-serif;">' . $row["attendance_count"] . '</td>';


                        if ($rank === 1) {
                            $trophyURL1 = generateTrophyURL1($row["attendance_count"]);
                            $trophyURL2 = generateTrophyURL2($row["attendance_count"]);
                            $trophyURL3 = generateTrophyURL3($row["attendance_count"]);
                            echo '<td><div style="width:100%;height:0;padding-bottom:56%;position:relative;"><img src="' . $trophyURL1 . '" style="position:absolute"></img></div></td>';
                        } else if ($rank === 2) {
                            echo '<td><div style="width:100%;height:0;padding-bottom:56%;position:relative;"><img src="' . $trophyURL2 . '" style="position:absolute"></img></div></td>';
                        } else if ($rank === 3) {
                            echo '<td><div style="width:100%;height:0;padding-bottom:56%;position:relative;"><img src="' . $trophyURL3 . '" style="position:absolute"></img></div></td>';
                        } else {
                            echo '<td></td>';
                        }

                        echo "</tr>";
                        $rank++;
                    }
                } else {
                    echo "<tr><td colspan='4'>No data found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>