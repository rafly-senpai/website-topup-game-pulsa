<?php

   session_start();
   
   // cek user sudah login atau belum
   if (!isset($_SESSION["loginSuccess"])) {
      header("location:/public/auth/masuk.php");
      exit;
   }
   
   // includes
   include_once $_SERVER["DOCUMENT_ROOT"] . "/app/configs/koneksi.php";
   include_once $_SERVER["DOCUMENT_ROOT"] . "/app/helpers/functions.php";
   
   // ambil data dari session
   $userId = $_SESSION["loginSuccess"];
   
   // ambil data dari database
   $user = getDataFromDatabase($usersDb, "SELECT * FROM users WHERE id = $userId");

?>
<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Akun</title>
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
         <div class="flex flex-col gap-5">
            
            <!-- page title -->
            <div class="flex flex-col">
               <span class="text-[20px] font-semibold">Akun</span>
               <span>Berikut ini adalah informasi tentang akun kamu</span>
            </div>
            
            <hr>
            
            <!-- saldo akun -->
            <section class="p-5 bg-white border shadow-md shadow-gray-200 rounded">
               <div class="flex flex-col gap-5">
                  <div class="text-center flex flex-col">
                     <span class="text-gray-500">Saldo akun</span>
                     <span class="font-semibold">IDR <?= htmlspecialchars(number_format($user[0]["balance"], 0, ",", ".")); ?></span>
                  </div>
                  <hr>
                  <div class="flex items-center justify-center gap-3">
                     <a class="w-full text-center text-white py-2 px-3 bg-[#2a005c] border rounded" href="/public/deposit.php">Deposit</a>
                     <a class="w-full text-center py-2 px-3 bg-white border rounded" href="/public/tarik-saldo.php">Tarik Saldo</a>
                  </div>
               </div>
            </section>
            
            <!-- profile -->
            <section class="bg-white border shadow-md shadow-gray-200 overflow-hidden rounded">
               <div class="p-5 bg-white border-b">
                  <div class="flex items-center justify-center">
                     <div class="w-fit mx-auto text-center">
                        <span class="font-semibold">Profile</span>
                     </div>
                  </div>
               </div>
               <div class="p-5">
                  <div class="flex flex-col gap-5">
                     <div class="flex flex-col">
                        <div class="py-3 bg-gray-50 border-b">
                           <div class="w-fit flex items-center gap-5">
                              <span class="flex items-center justify-center">
                                 <i class="hgi hgi-stroke hgi-user-03"></i>
                              </span>
                              <div class="flex flex-col">
                                 <span class="text-gray-500">Nama</span>
                                 <span><?= htmlspecialchars($user[0]["name"]); ?></span>
                              </div>
                           </div>
                        </div>
                        <div class="py-3 border-b">
                           <div class="w-fit flex items-center gap-5">
                              <span class="flex items-center justify-center">
                                 <i class="hgi hgi-stroke hgi-call-02"></i>
                              </span>
                              <div class="flex flex-col">
                                 <span class="text-gray-500">Nomor HP</span>
                                 <span><?= htmlspecialchars($user[0]["phone"]); ?></span>
                              </div>
                           </div>
                        </div>
                        <div class="py-3 bg-gray-50 border-b">
                           <div class="w-fit flex items-center gap-5">
                              <span class="flex items-center justify-center">
                                 <i class="hgi hgi-stroke hgi-clock-03"></i>
                              </span>
                              <div class="flex flex-col">
                                 <span class="text-gray-500">Waktu Mendaftar</span>
                                 <span><?= htmlspecialchars($user[0]["created_at"]); ?></span>
                              </div>
                           </div>
                        </div>
                     </div>
                     <a class="text-center text-white p-3 bg-red-500 rounded" href="/app/services/logout-process.php">Keluar</a>
                  </div>
               </div>
            </section>
            
         </div>
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