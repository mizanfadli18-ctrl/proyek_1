<!DOCTYPE html>
<html>
<head>
    <title>Form Kontak</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        body {
            background: #f5f5f5;
            padding-top: 50px;
        }
        .contact-form {
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .btn-kirim {
            background-color: #007BFF;
            color: white;
            font-weight: bold;
            border: none;
        }
        .btn-kirim:hover {
            background-color: #0056b3;
        }
        h3 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="contact-form">
    <h3>Form Kontak</h3>
    <form action="proses_kontak.php" method="post">
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control">
        </div>
        <div class="form-group">
            <label>Pesan</label>
            <textarea name="pesan" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-kirim btn-block">KIRIM</button>
    </form>
</div>

</body>
</html>
