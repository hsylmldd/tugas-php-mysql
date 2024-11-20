<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form dan Tabel Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Form Input Data</h2>

    <!-- Form Input Data -->
    <form action="" method="post" class="mt-4">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="comment" class="form-label">Komentar</label>
            <textarea name="comment" id="comment" rows="3" class="form-control" required></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
    </form>

    <?php
    // Koneksi ke database
    $host = "localhost";
    $port = 3309;
    $database = "belajar_php_db";
    $username = "root";
    $password = "mysql";

    try {
        $connection = new PDO("mysql:host=$host;port=$port;dbname=$database", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Proses Insert Data
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
            $email = $_POST['email'];
            $comment = $_POST['comment'];

            $sql = "INSERT INTO comments (email, comment) VALUES (:email, :comment)";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':comment', $comment);
            $stmt->execute();

            echo "<div class='alert alert-success mt-3'>Data berhasil disimpan.</div>";
        }

    } catch (PDOException $e) {
        die("<div class='alert alert-danger mt-3'>Error: " . $e->getMessage() . "</div>");
    }
    ?>

    <!-- Tabel View Data -->
    <h2 class="text-center mt-5">Data Komentar</h2>
    <table class="table table-striped mt-4">
        <thead>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Komentar</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Tampilkan Data dari Tabel
        try {
            $sql = "SELECT * FROM comments";
            $stmt = $connection->query($sql);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['comment']}</td>
                    </tr>";
            }
        } catch (PDOException $e) {
            echo "<tr><td colspan='3'>Error: " . $e->getMessage() . "</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
