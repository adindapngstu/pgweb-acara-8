<!DOCTYPE html>
<html>

<body>
    <h2>Form Input</h2>
    <form action="input.php" method="post" onsubmit="return validateForm()">
        <label for="kecamatan">Kecamatan:</label><br>
        <input type="text" id="Kecamatan" name="Kecamatan" required><br>
        <label for="longitude">Longitude:</label><br>
        <input type="number" id="Longitude" name="Longitude" step="any" required><br>
        <label for="latitude">Latitude:</label><br>
        <input type="number" id="Latitude" name="Latitude" step="any" required><br>
        <label for="luas">Luas:</label><br>
        <input type="number" id="Luas" name="Luas" required><br>
        <label for="jumlah_penduduk">Jumlah Penduduk:</label><br>
        <input type="number" id="Jumlah_Penduduk" name="Jumlah_Penduduk" required><br><br>
        <input type="submit" value="Submit">
    </form>

    <p id="informasi"></p>

    <script>
        function validateForm() {
            let luas = document.getElementById("Luas").value;
            let text = "";
            if (isNaN(luas) || luas < 1) {
                text = "Data luas harus angka dan tidak boleh bernilai negatif";
                document.getElementById("informasi").innerHTML = text;
                return false; // Hentikan pengiriman form
            }
            return true; // Izinkan pengiriman form
        }
    </script>

    <?php
    // Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pgweb acara 8";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Memeriksa apakah data ada di POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $kecamatan = $_POST['Kecamatan'];
        $longitude = $_POST['Longitude'];
        $latitude = $_POST['Latitude'];
        $luas = $_POST['Luas'];
        $jumlah_penduduk = $_POST['Jumlah_Penduduk'];

        // Validasi input
        if ($kecamatan && $longitude && $latitude && $luas && $jumlah_penduduk) {
            // Menggunakan prepared statement
            $stmt = $conn->prepare("INSERT INTO database_kecamatan (Kecamatan, Longitude, Latitude, Luas, Jumlah_Penduduk) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssi", $kecamatan, $longitude, $latitude, $luas, $jumlah_penduduk);

            if ($stmt->execute()) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Semua field harus diisi.";
        }
    }

    $conn->close();

    ?>
</body>

</html>