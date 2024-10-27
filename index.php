<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pgweb acara 8"; // Pastikan nama database sesuai

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fungsi untuk menghapus data
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM database_kecamatan WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    
    if ($stmt->execute()) {
        echo "Data berhasil dihapus.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Ambil data dari database
$sql = "SELECT * FROM database_kecamatan";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<table border='1px'>
            <tr>
                <th>Kecamatan</th>
                <th>Longitude</th>
                <th>Latitude</th>
                <th>Luas</th>
                <th>Jumlah Penduduk</th>
                <th>Aksi</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["Kecamatan"]) . "</td>
                <td>" . htmlspecialchars($row["Longitude"]) . "</td>
                <td>" . htmlspecialchars($row["Latitude"]) . "</td>
                <td>" . htmlspecialchars($row["Luas"]) . "</td>
                <td align='right'>" . htmlspecialchars($row["Jumlah_Penduduk"]) . "</td>
                <td><a href='index.php?delete_id=" . $row["id"] . "' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?')\">Hapus</a></td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>
