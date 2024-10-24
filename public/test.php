<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Dump</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">

    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Database Dump</h1>

        <?php
        $dsn = 'mysql:host=localhost;dbname=beanandbrew';
        $username = 'root'; // Update with your DB username
        $password = 'root'; // Update with your DB password

        try {
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Query to get all table names
            $tablesStmt = $pdo->query("SHOW TABLES");
            $tables = $tablesStmt->fetchAll(PDO::FETCH_COLUMN);

            // Loop through each table and display its data
            foreach ($tables as $table) {
                echo '<h2 class="text-2xl font-bold mb-4 text-center text-gray-800">Table: ' . htmlspecialchars($table) . '</h2>';

                // Query to fetch all records from the current table
                $stmt = $pdo->query("SELECT * FROM $table");

                // Check if any records were returned
                if ($stmt->rowCount() > 0) {
                    echo '<table class="min-w-full bg-white border border-gray-300 rounded-lg mb-8">';
                    echo '<thead>';
                    echo '<tr class="bg-gray-800 text-white text-left">';

                    // Dynamically output the column names
                    for ($i = 0; $i < $stmt->columnCount(); $i++) {
                        $columnMeta = $stmt->getColumnMeta($i);
                        echo '<th class="py-3 px-4">' . htmlspecialchars($columnMeta['name']) . '</th>';
                    }

                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody class="text-gray-700">';

                    // Output each row of data
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr class="border-t border-gray-200 hover:bg-gray-100">';
                        foreach ($row as $cell) {
                            echo '<td class="py-3 px-4">' . htmlspecialchars($cell) . '</td>';
                        }
                        echo '</tr>';
                    }

                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo '<p class="text-center text-red-500">No records found in table ' . htmlspecialchars($table) . '.</p>';
                }
            }
        } catch (PDOException $e) {
            echo '<p class="text-center text-red-500">Connection failed: ' . $e->getMessage() . '</p>';
        }
        ?>

    </div>

</body>

</html>