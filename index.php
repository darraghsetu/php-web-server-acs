<?php
$host = getenv('DB_HOST');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASS');
$port = 3306;

$conn = mysqli_init();

mysqli_ssl_set($conn, NULL, NULL, "/var/www/html/global-bundle.pem", NULL, NULL);

try {
    if (!mysqli_real_connect($conn, $host, $user, $password, $db, $port, NULL, MYSQLI_CLIENT_SSL)) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }

    echo "<h1>simpsons.character Table:</h1>";

    $sql = "SELECT first_name, last_name, age, occupation, hair_desc FROM characters";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        throw new Exception("Query failed: " . mysqli_error($conn));
    }

    echo "<table border='1' cellpadding='10'>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Occupation</th>
                <th>Hair</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['first_name']}</td>
                <td>{$row['last_name']}</td>
                <td>{$row['age']}</td>
                <td>{$row['occupation']}</td>
                <td>{$row['hair_desc']}</td>
              </tr>";
    }
    echo "</table>";

} catch (Exception $e) {
    echo "<div style='color:red;'>Database error: " . $e->getMessage() . "</div>";
} finally {
    if ($conn) {
        mysqli_close($conn);
    }
}
?>
