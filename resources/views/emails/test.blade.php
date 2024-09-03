<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ganti Password - MR+</title>
</head>
<body>
    <div style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; margin: 0; padding: 20px; color: #333;">
        <h2 style="color: #333;">Reset Password</h2>
        <p>
            Halo {{$details['nama']}},
        </p>
        <p>
            Kami menerima permintaan untuk mengganti password akun Anda pada Medical Record +. berikut password baru anda:
            <h3>{{$details['password']}}</h3>
        </p>
        <p>
         Setelah berhasil login segera ganti password anda di profil.
        </p>
        <p>
            Terima kasih,<br>
            Tim MR+
        </p>
    </div>
</body>
</html>

