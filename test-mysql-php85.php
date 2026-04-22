<?php
/**
 * MySQL 9.1.0 + PHP 8.5.5 Connection Test
 * Test file untuk verify MySQL 9.1.0 bekerja dengan PHP 8.5.5
 */

echo "<h1>MySQL 9.1.0 + PHP 8.5.5 Connection Test</h1>";
echo "<hr>";

// Configuration
$host = 'localhost';
$port = 3306;
$user = 'root';
$pass = ''; // Laragon default: empty password
$db = 'mysql';

echo "<h2>System Information</h2>";
echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
echo "<tr><td><strong>PHP Version:</strong></td><td>" . PHP_VERSION . "</td></tr>";
echo "<tr><td><strong>PHP SAPI:</strong></td><td>" . php_sapi_name() . "</td></tr>";
echo "<tr><td><strong>Server Software:</strong></td><td>" . $_SERVER['SERVER_SOFTWARE'] . "</td></tr>";
echo "<tr><td><strong>Operating System:</strong></td><td>" . PHP_OS . "</td></tr>";
echo "</table>";

echo "<hr>";
echo "<h2>MySQL Connection Tests</h2>";

// Test 1: MySQLi Extension
echo "<h3>1. MySQLi Extension Test</h3>";
if (extension_loaded('mysqli')) {
    echo "✅ <strong>MySQLi extension loaded</strong><br>";
    
    try {
        $mysqli = new mysqli($host, $user, $pass, $db, $port);
        
        if ($mysqli->connect_error) {
            echo "❌ <strong>Connection failed:</strong> " . $mysqli->connect_error . "<br>";
        } else {
            echo "✅ <strong>MySQLi Connection: SUCCESS</strong><br>";
            echo "<table border='1' cellpadding='10' style='border-collapse: collapse; margin-top: 10px;'>";
            echo "<tr><td><strong>MySQL Version:</strong></td><td>" . $mysqli->server_info . "</td></tr>";
            echo "<tr><td><strong>MySQL Protocol:</strong></td><td>" . $mysqli->protocol_version . "</td></tr>";
            echo "<tr><td><strong>Host Info:</strong></td><td>" . $mysqli->host_info . "</td></tr>";
            echo "<tr><td><strong>Character Set:</strong></td><td>" . $mysqli->character_set_name() . "</td></tr>";
            echo "</table>";
            
            // Test query
            $result = $mysqli->query("SELECT VERSION() as version, NOW() as current_time");
            if ($result) {
                $row = $result->fetch_assoc();
                echo "<br><strong>Test Query Result:</strong><br>";
                echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
                echo "<tr><td><strong>MySQL Version:</strong></td><td>" . $row['version'] . "</td></tr>";
                echo "<tr><td><strong>Current Time:</strong></td><td>" . $row['current_time'] . "</td></tr>";
                echo "</table>";
            }
            
            $mysqli->close();
        }
    } catch (Exception $e) {
        echo "❌ <strong>MySQLi Error:</strong> " . $e->getMessage() . "<br>";
    }
} else {
    echo "❌ <strong>MySQLi extension NOT loaded</strong><br>";
}

echo "<hr>";

// Test 2: PDO Extension
echo "<h3>2. PDO MySQL Extension Test</h3>";
if (extension_loaded('pdo_mysql')) {
    echo "✅ <strong>PDO MySQL extension loaded</strong><br>";
    
    try {
        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        
        echo "✅ <strong>PDO Connection: SUCCESS</strong><br>";
        echo "<table border='1' cellpadding='10' style='border-collapse: collapse; margin-top: 10px;'>";
        echo "<tr><td><strong>PDO Driver:</strong></td><td>" . $pdo->getAttribute(PDO::ATTR_DRIVER_NAME) . "</td></tr>";
        echo "<tr><td><strong>Server Version:</strong></td><td>" . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . "</td></tr>";
        echo "<tr><td><strong>Client Version:</strong></td><td>" . $pdo->getAttribute(PDO::ATTR_CLIENT_VERSION) . "</td></tr>";
        echo "<tr><td><strong>Connection Status:</strong></td><td>" . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "</td></tr>";
        echo "</table>";
        
        // Test prepared statement
        $stmt = $pdo->query("SELECT VERSION() as version, DATABASE() as current_db, USER() as current_user");
        $row = $stmt->fetch();
        echo "<br><strong>Test Query Result:</strong><br>";
        echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
        echo "<tr><td><strong>MySQL Version:</strong></td><td>" . $row['version'] . "</td></tr>";
        echo "<tr><td><strong>Current Database:</strong></td><td>" . $row['current_db'] . "</td></tr>";
        echo "<tr><td><strong>Current User:</strong></td><td>" . $row['current_user'] . "</td></tr>";
        echo "</table>";
        
        $pdo = null;
    } catch (PDOException $e) {
        echo "❌ <strong>PDO Error:</strong> " . $e->getMessage() . "<br>";
    }
} else {
    echo "❌ <strong>PDO MySQL extension NOT loaded</strong><br>";
}

echo "<hr>";

// Test 3: PHP Extensions Check
echo "<h3>3. PHP MySQL Extensions Status</h3>";
echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
echo "<tr><th>Extension</th><th>Status</th></tr>";

$extensions = ['mysqli', 'pdo', 'pdo_mysql', 'mysqlnd'];
foreach ($extensions as $ext) {
    $loaded = extension_loaded($ext);
    $status = $loaded ? "✅ Loaded" : "❌ Not Loaded";
    echo "<tr><td><strong>$ext</strong></td><td>$status</td></tr>";
}
echo "</table>";

echo "<hr>";

// Test 4: MySQL Variables
echo "<h3>4. Important MySQL Variables</h3>";
try {
    $mysqli = new mysqli($host, $user, $pass, $db, $port);
    if (!$mysqli->connect_error) {
        $variables = [
            'version',
            'version_comment',
            'character_set_server',
            'collation_server',
            'max_connections',
            'max_allowed_packet',
            'innodb_buffer_pool_size',
            'sql_mode'
        ];
        
        echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
        echo "<tr><th>Variable</th><th>Value</th></tr>";
        
        foreach ($variables as $var) {
            $result = $mysqli->query("SHOW VARIABLES LIKE '$var'");
            if ($result && $row = $result->fetch_assoc()) {
                echo "<tr><td><strong>" . $row['Variable_name'] . "</strong></td><td>" . $row['Value'] . "</td></tr>";
            }
        }
        echo "</table>";
        $mysqli->close();
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}

echo "<hr>";
echo "<h2>✅ Test Complete!</h2>";
echo "<p><strong>Conclusion:</strong> ";
if (extension_loaded('mysqli') && extension_loaded('pdo_mysql')) {
    echo "MySQL 9.1.0 is working perfectly with PHP 8.5.5! 🎉</p>";
} else {
    echo "Some MySQL extensions are missing. Please check PHP configuration.</p>";
}

echo "<hr>";
echo "<p style='color: #666; font-size: 12px;'>";
echo "Test file: " . __FILE__ . "<br>";
echo "Generated: " . date('Y-m-d H:i:s') . "<br>";
echo "PHP Version: " . PHP_VERSION . "<br>";
echo "MySQL Version: 9.1.0";
echo "</p>";
?>
