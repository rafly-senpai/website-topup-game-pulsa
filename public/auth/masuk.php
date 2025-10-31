<?php

   session_start();
   
   // cek user sudah login atau belum
   if (isset($_SESSION["loginSuccess"])) {
      header("location:/public/beranda.php");
      exit;
   }

?>
<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Masuk</title>
   <!-- CDN -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Zalando+Sans:ital,wght@0,200..900;1,200..900&display=swap">
   <link rel="stylesheet" href="https://use.hugeicons.com/font/icons.css">
   <script type="text/javascript" src="https://cdn.tailwindcss.com"></script>
</head>
<body class="w-screen min-h-screen select-none bg-gray-50 cursor-default" style="font-family: 'Zalando Sans';">
   
   <!-- container -->
   <div class="max-w-3xl mx-auto min-h-screen bg-white overflow-hidden">
      
      <!-- header -->
      <header class="p-5 bg-[#2a005c]">
         <div class="flex items-center">
            <div class="w-fit flex items-center gap-5">
               <button class="text-white flex items-center justify-center cursor-pointer" type="button" onclick="showSidebar();">
                  <i class="hgi hgi-stroke hgi-menu-01"></i>
               </button>
               <a href="/public/beranda.php">
                  <img class="w-[100px] h-auto flex items-center justify-center" src="/public/assets/images/logo/logo.png" alt="Tokoisicash">
               </a>
            </div>
         </div>
      </header>
      
      <!-- sidebar -->
      <div class="top-0 left-0 w-full h-full fixed z-10 hidden" id="sidebar">
         <div class="max-w-3xl mx-auto h-full bg-black/0 transition duration-300 overflow-hidden" id="sidebarOverlay">
            <div class="w-[300px] h-full bg-[#2a005c] transform -translate-x-full transition duration-300" id="sidebarContent">
               <div class="p-5 bg-[#2a005c] border-b border-b-white/30">
                  <div class="flex items-center justify-between gap-5">
                     <a href="/public/beranda.php">
                        <img class="w-[100px] h-auto flex items-center justify-center" src="/public/assets/images/logo/logo.png" alt="Tokoisicash">
                     </a>
                     <button class="text-white flex items-center justify-center cursor-pointer" type="button" onclick="hideSidebar();">
                        <i class="hgi hgi-stroke hgi-cancel-01"></i>
                     </button>
                  </div>
               </div>
               <div class="p-5">
                  <div class="flex flex-col">
                     <a class="text-white p-5 transition duration-300 hover:bg-black/30" href="/public/beranda.php">Beranda</a>
                     <a class="text-white p-5 transition duration-300 hover:bg-black/30" href="/public/riwayat-transaksi.php">Riwayat Transaksi</a>
                     <a class="text-white p-5 transition duration-300 hover:bg-black/30" href="/public/informasi.php">Informasi</a>
                     <a class="text-white p-5 transition duration-300 hover:bg-black/30" href="/public/akun.php">Akun</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
      <!-- main content -->
      <main class="p-5">
         
         <!-- masuk -->
         <?php $_SESSION["request"] = true; ?>
         <form class="bg-white border shadow-md shadow-gray-200 overflow-hidden rounded" action="/app/services/login-process.php" method="post">
            <div class="p-5 bg-white border-b">
               <div class="flex items-center justify-center">
                  <div class="w-fit mx-auto text-center">
                     <span class="font-semibold">Masuk</span>
                  </div>
               </div>
            </div>
            <div class="p-5">
               <div class="flex flex-col gap-5">
                  <?php if (isset($_SESSION["loginError"])) : ?>
                     <div class="w-fit">
                        <span class="text-red-500"><?= htmlspecialchars($_SESSION["loginError"]); ?></span>
                     </div>
                     <?php unset($_SESSION["loginError"]); ?>
                  <?php endif; ?>
                  <div class="flex flex-col gap-3">
                     <input class="p-3 bg-white border outline-none rounded" type="text" name="phoneInput" placeholder="Masukkan nomor hp" required>
                     <input class="p-3 bg-white border outline-none rounded" type="password" name="passwordInput" placeholder="Masukkan kata sandi" required>
                  </div>
                  <button class="text-white p-3 bg-[#2a005c] rounded cursor-pointer" type="submit">Masuk</button>
                  <div class="w-fit flex items-center">
                     <span class="text-gray-500">Belum punya akun?</span>
                     <a class="hover:underline" href="/public/auth/daftar.php">Daftar</a>
                  </div>
               </div>
            </div>
         </form>
         
      </main>
      
      <!-- footer -->
      <footer class="p-5 bg-[#2a005c]">
         <div class="flex flex-col gap-5">
            <div class="flex flex-col gap-3">
               <a class="w-fit" href="/public/beranda.php">
                  <img class="w-[100px] h-auto flex items-center justify-center" src="/public/assets/images/logo/logo.png" alt="Tokoisicash">
               </a>
               <span class="text-white"><a class="hover:underline" href="/public/beranda.php">Tokoisicash</a> merupakan platform topup murah dan terpercaya. Tokoisicash sudah dipercaya oleh lebih dari 100 ribu pelanggan di Indonesia.</a>
            </div>
            <div class="grid grid-cols-2 gap-5 sm:grid-cols-3">
               <div class="flex flex-col gap-3">
                  <span class="text-white font-semibold">PETA SITUS</span>
                  <a class="w-fit text-white/70 hover:underline" href="/public/beranda.php">Beranda</a>
                  <a class="w-fit text-white/70 hover:underline" href="/public/riwayat-transaksi.php">Riwayat Transaksi</a>
                  <a class="w-fit text-white/70 hover:underline" href="/public/informasi.php">Informasi</a>
                  <a class="w-fit text-white/70 hover:underline" href="/public/akun.php">Akun</a>
               </div>
               <div class="flex flex-col gap-3">
                  <span class="text-white font-semibold">TOPUP</span>
                  <a class="w-fit text-white/70 hover:underline" href="/public/topup.php?id=free-fire">Free Fire</a>
                  <a class="w-fit text-white/70 hover:underline" href="/public/topup.php?id=mobile-legends">Mobile Legends</a>
                  <a class="w-fit text-white/70 hover:underline" href="/public/topup.php?id=pubg-mobile">PUBG Mobile</a>
                  <a class="w-fit text-white/70 hover:underline" href="/public/topup.php?id=blood-strike">Blood Strike</a>
               </div>
               <div class="flex flex-col gap-3">
                  <span class="text-white font-semibold">BANTUAN</span>
                  <a class="w-fit text-white/70 hover:underline" href="https://wa.me/6285123088237" target="_blank">WhatsApp</a>
               </div>
            </div>
            <hr>
            <div class="w-fit mx-auto text-center">
               <span class="text-white">&copy;2025 Tokoisicash. All Rights Reserved.</span>
            </div>
         </div>
      </footer>
      
   </div>
   
   <!-- script -->
   <script type="text/javascript">
      
      // tampilkan dan sembunyikan sidebar
      const sidebar = document.getElementById("sidebar");
      const sidebarOverlay = document.getElementById("sidebarOverlay");
      const sidebarContent = document.getElementById("sidebarContent");
      
      function showSidebar() {
         
         sidebar.classList.remove("hidden");
         setTimeout(function() {
            sidebarOverlay.classList.replace("bg-black/0", "bg-black/50");
            sidebarContent.classList.replace("-translate-x-full", "-translate-x-0");
         }, 0);
         
      }
      
      function hideSidebar() {
         
         sidebarOverlay.classList.replace("bg-black/50", "bg-black/0");
         sidebarContent.classList.replace("-translate-x-0", "-translate-x-full");
         setTimeout(function() {
            sidebar.classList.add("hidden");
         }, 300);
         
      }
      
   </script>
   
</body>
</html>