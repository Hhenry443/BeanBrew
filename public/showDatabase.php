<?php
// Database connection
$host = 'localhost';
$dbname = 'beanandbrew';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Function to fetch tables, columns, and foreign key relationships
function getDatabaseRelations($pdo, $dbname)
{
    $tables = [];
    $stmt = $pdo->query("SHOW TABLES");

    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $table = $row[0];
        $tables[$table] = ['columns' => [], 'fks' => []];

        // Get table columns
        $colQuery = $pdo->prepare("SHOW COLUMNS FROM $table");
        $colQuery->execute();
        while ($column = $colQuery->fetch(PDO::FETCH_ASSOC)) {
            $tables[$table]['columns'][] = $column;
        }

        // Get foreign key relationships
        $fkQuery = $pdo->prepare("
            SELECT 
                COLUMN_NAME, 
                REFERENCED_TABLE_NAME, 
                REFERENCED_COLUMN_NAME 
            FROM 
                INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
            WHERE 
                TABLE_SCHEMA = :dbname 
                AND TABLE_NAME = :table 
                AND REFERENCED_TABLE_NAME IS NOT NULL
        ");
        $fkQuery->execute(['dbname' => $dbname, 'table' => $table]);
        while ($fk = $fkQuery->fetch(PDO::FETCH_ASSOC)) {
            $tables[$table]['fks'][] = $fk;
        }
    }

    return $tables;
}

// Helper function to safely use htmlspecialchars
function safeHtml($value)
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

// Get the relations
$relations = getDatabaseRelations($pdo, $dbname);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Relations</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">
    <div class="container mx-auto">
        <h1 class="text-4xl font-bold text-center mb-10 text-orange-600">Database Relations for '<?php echo safeHtml($dbname); ?>'</h1>

        <?php foreach ($relations as $table => $data): ?>
            <div class="bg-orange-700 text-white font-bold text-lg py-2 px-4 mb-4 rounded">Table: <?php echo safeHtml($table); ?></div>

            <!-- Display Table Columns -->
            <div class="mb-4">
                <h2 class="text-xl font-semibold mb-2">Columns:</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300 mb-6">
                        <thead class="bg-orange-500 text-white">
                            <tr>
                                <th class="text-left py-2 px-4">Field</th>
                                <th class="text-left py-2 px-4">Type</th>
                                <th class="text-left py-2 px-4">Null</th>
                                <th class="text-left py-2 px-4">Key</th>
                                <th class="text-left py-2 px-4">Default</th>
                                <th class="text-left py-2 px-4">Extra</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['columns'] as $column): ?>
                                <tr class="border-b">
                                    <td class="py-2 px-4"><?php echo safeHtml($column['Field']); ?></td>
                                    <td class="py-2 px-4"><?php echo safeHtml($column['Type']); ?></td>
                                    <td class="py-2 px-4"><?php echo safeHtml($column['Null']); ?></td>
                                    <td class="py-2 px-4"><?php echo safeHtml($column['Key']); ?></td>
                                    <td class="py-2 px-4"><?php echo safeHtml($column['Default']); ?></td>
                                    <td class="py-2 px-4"><?php echo safeHtml($column['Extra']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Display Foreign Key Relationships -->
            <?php if (count($data['fks']) > 0): ?>
                <h2 class="text-xl font-semibold mb-2">Foreign Key Relations:</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300 mb-6">
                        <thead class="bg-orange-500 text-white">
                            <tr>
                                <th class="text-left py-2 px-4">Column</th>
                                <th class="text-left py-2 px-4">References Table</th>
                                <th class="text-left py-2 px-4">References Column</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['fks'] as $fk): ?>
                                <tr class="border-b">
                                    <td class="py-2 px-4"><?php echo safeHtml($fk['COLUMN_NAME']); ?></td>
                                    <td class="py-2 px-4"><?php echo safeHtml($fk['REFERENCED_TABLE_NAME']); ?></td>
                                    <td class="py-2 px-4"><?php echo safeHtml($fk['REFERENCED_COLUMN_NAME']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-gray-600 mb-6">No foreign keys found for this table.</p>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</body>

</html>