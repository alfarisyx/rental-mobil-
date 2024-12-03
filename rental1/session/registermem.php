<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <title>Document</title>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 130vh;
        }
    </style>
</head>
<body>
    <div class="container pt-8">
        <div class="bg-white pt-8 p-8 rounded-lg shadow-lg w-full max-w-md">
            <h1 class="text-2xl pt-8 font-bold mb-6 text-center">Register member</h1>
            <form action="memregproses.php" method="POST">
                <div class="mb-4">
                    <label for="nik" class="block text-gray-700">NIK</label>
                    <input type="text" id="nik" name="nik" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="nama" class="block text-gray-700">Nama</label>
                    <input type="text" id="nama" name="nama" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="jk" class="block text-gray-700">Jenis Kelamin</label>
                    <select id="jk" name="jk" class="w-full px-3 py-2 border rounded-lg" required>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="telp" class="block text-gray-700">Telepon</label>
                    <input type="text" id="telp" name="telp" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="alamat" class="block text-gray-700">Alamat</label>
                    <textarea id="alamat" name="alamat" class="w-full px-3 py-2 border rounded-lg" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="user" class="block text-gray-700">Username</label>
                    <input type="text" id="user" name="user" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="pass" class="block text-gray-700">Password</label>
                    <input type="password" id="pass" name="pass" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Register</button>
                </div>
                <div class="text-center mt-6">
                    <p>Sudah punya akun? <a href="login.php" class="text-blue-500">Login</a></p>
                </div>
            </form>
        </div>
    </div>



    


<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>
</html>