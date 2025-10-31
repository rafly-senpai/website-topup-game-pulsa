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
   
   // ambil data dari database
   $products = getDataFromDatabase($productsDb, "SELECT * FROM products");

?>
<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Tokoisicash - Platform Topup Murah dan Terpercaya</title>
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
         <div class="flex items-center justify-between gap-5">
            <button class="text-white flex items-center justify-center cursor-pointer" type="button" onclick="showSidebar();">
               <i class="hgi hgi-stroke hgi-menu-01"></i>
            </button>
            <a href="/public/beranda.php">
               <img class="w-[100px] h-auto flex items-center justify-center" src="/public/assets/images/logo/logo.png" alt="Tokoisicash">
            </a>
            <button class="text-white flex items-center justify-center cursor-pointer" type="button" onclick="showSearch();">
               <i class="hgi hgi-stroke hgi-search-01"></i>
            </button>
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
      
      <!-- search -->
      <?php $_SESSION["request"] = true; ?>
      <div class="top-0 left-0 w-full h-full fixed z-10 hidden" id="search">
         <div class="max-w-3xl mx-auto h-full bg-black/0 transition duration-300 overflow-hidden" id="searchOverlay">
            <div class="h-full bg-white transform translate-y-full transition duration-300" id="searchContent">
               <div class="p-5 bg-white border-b">
                  <div class="flex items-center justify-between gap-5">
                     <span>Pencarian</span>
                     <button class="flex items-center justify-center cursor-pointer" type="button" onclick="hideSearch();">
                        <i class="hgi hgi-stroke hgi-cancel-01"></i>
                     </button>
                  </div>
               </div>
               <div class="p-5">
                  <div class="flex flex-col gap-5">
                     <form class="flex items-center gap-5" action="/app/services/search-process.php" method="post">
                        <input class="w-full p-3 bg-white border outline-none rounded" type="text" name="searchInput" placeholder="Masukkan nama produk" required>
                        <button class="text-white p-3 bg-[#2a005c] border rounded cursor-pointer" type="submit">Cari</button>
                     </form>
                     <?php if (isset($_SESSION["searchResults"])) : ?>
                        <?php $searchResults = $_SESSION["searchResults"]; ?>
                        <?php if (!empty($searchResults)) : ?>
                           <div class="grid grid-cols-3 gap-3 sm:grid-cols-4 md:grid-cols-5">
                              <?php foreach ($searchResults as $searchResult) : ?>
                                 <?php if ($searchResult["category"] === "game") : ?>
                                    <a class="flex flex-col gap-3" href="/public/topup.php?id=<?= htmlspecialchars($searchResult["product_id"]); ?>">
                                       <div class="overflow-hidden rounded">
                                          <img class="w-full h-auto flex items-center justify-center" src="/public/assets/images/produk/game/<?= htmlspecialchars($searchResult["image"]); ?>" alt="Produk">
                                       </div>
                                       <div class="w-fit mx-auto text-center">
                                          <?php if (strlen($searchResult["name"]) > 10) : ?>
                                             <span><?= htmlspecialchars(strtoupper(substr($searchResult["name"], 0, 10))); ?>...</span>
                                          <?php else : ?>
                                             <span><?= htmlspecialchars(strtoupper($searchResult["name"])); ?></span>
                                          <?php endif; ?>
                                       </div>
                                    </a>
                                 <?php elseif ($searchResult["category"] === "pulsa") : ?>
                                    <a class="flex flex-col gap-3" href="/public/topup.php?id=<?= htmlspecialchars($searchResult["product_id"]); ?>">
                                       <div class="overflow-hidden rounded">
                                          <img class="w-full h-auto flex items-center justify-center" src="/public/assets/images/produk/pulsa/<?= htmlspecialchars($searchResult["image"]); ?>" alt="Produk">
                                       </div>
                                       <div class="w-fit mx-auto text-center">
                                          <?php if (strlen($searchResult["name"]) > 10) : ?>
                                             <span><?= htmlspecialchars(strtoupper(substr($searchResult["name"], 0, 10))); ?>...</span>
                                          <?php else : ?>
                                             <span><?= htmlspecialchars(strtoupper($searchResult["name"])); ?></span>
                                          <?php endif; ?>
                                       </div>
                                    </a>
                                 <?php endif; ?>
                              <?php endforeach; ?>
                           </div>
                        <?php else : ?>
                           <div class="w-fit mx-auto text-center">
                              <span>Produk tidak ditemukan.</span>
                           </div>
                        <?php endif; ?>
                        <?php unset($_SESSION["searchResults"]); ?>
                     <?php endif; ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
      <!-- main content -->
      <main class="p-5">
         <div class="flex flex-col gap-5">
            
            <!-- banner -->
            <section class="w-full overflow-x-auto scroll-smooth snap-x snap-mandatory flex gap-4 no-scrollbar">
               <div class="flex-shrink-0 w-full snap-center rounded overflow-hidden">
                  <img class="w-full h-auto object-cover" src="/public/assets/images/banner/topup-game-murah-dan-terpercaya.png" alt="Topup Game Murah dan Terpercaya">
               </div>
               <!-- <div class="flex-shrink-0 w-full snap-center rounded-2xl overflow-hidden">
                  <img class="w-full h-auto object-cover" src="" alt="">
               </div> -->
            </section>
            
            <!-- produk -->
            <section class="flex flex-col gap-5">
               <!-- game -->
               <div class="flex flex-col gap-5">
                  <div class="flex flex-col">
                     <span class="text-[20px] font-semibold">Game</span>
                     <span>Topup game murah dan terpercaya</span>
                  </div>
                  <div class="grid grid-cols-3 gap-3 sm:grid-cols-4 md:grid-cols-5">
                     <?php foreach ($products as $product) : ?>
                        <?php if ($product["category"] === "game") : ?>
                           <?php if ($product["status"] === 1) : ?>
                              <a class="flex flex-col gap-3" href="/public/topup.php?id=<?= htmlspecialchars($product["product_id"]); ?>">
                                 <div class="overflow-hidden rounded">
                                    <img class="w-full h-auto flex items-center justify-center" src="/public/assets/images/produk/game/<?= htmlspecialchars($product["image"]); ?>" alt="Produk">
                                 </div>
                                 <div class="w-fit mx-auto text-center">
                                    <?php if (strlen($product["name"]) > 10) : ?>
                                       <span><?= htmlspecialchars(strtoupper(substr($product["name"], 0, 10))); ?>...</span>
                                    <?php else : ?>
                                       <span><?= htmlspecialchars(strtoupper($product["name"])); ?></span>
                                    <?php endif; ?>
                                 </div>
                              </a>
                           <?php endif; ?>
                        <?php endif; ?>
                     <?php endforeach; ?>
                  </div>
               </div>
               <!-- pulsa -->
               <div class="flex flex-col gap-5">
                  <div class="flex flex-col">
                     <span class="text-[20px] font-semibold">Pulsa</span>
                     <span>Topup pulsa murah dan terpercaya</span>
                  </div>
                  <div class="grid grid-cols-3 gap-3 sm:grid-cols-4 md:grid-cols-5">
                     <?php foreach ($products as $product) : ?>
                        <?php if ($product["category"] === "pulsa") : ?>
                           <?php if ($product["status"] === 1) : ?>
                              <a class="flex flex-col gap-3" href="/public/topup.php?id=<?= htmlspecialchars($product["product_id"]); ?>">
                                 <div class="overflow-hidden rounded">
                                    <img class="w-full h-auto flex items-center justify-center" src="/public/assets/images/produk/pulsa/<?= htmlspecialchars($product["image"]); ?>" alt="Produk">
                                 </div>
                                 <div class="w-fit mx-auto text-center">
                                    <?php if (strlen($product["name"]) > 10) : ?>
                                       <span><?= htmlspecialchars(strtoupper(substr($product["name"], 0, 10))); ?>...</span>
                                    <?php else : ?>
                                       <span><?= htmlspecialchars(strtoupper($product["name"])); ?></span>
                                    <?php endif; ?>
                                 </div>
                              </a>
                           <?php endif; ?>
                        <?php endif; ?>
                     <?php endforeach; ?>
                  </div>
               </div>
            </section>
            
            <hr>
            
            <!-- tentang tokoisicash -->
            <section class="flex flex-col gap-5">
               <div class="flex flex-col gap-3">
                  <span class="text-[20px] font-semibold">Tokoisicash Merupakan Platform Topup Murah dan Terpercaya</span>
                  <span>Tokoisicash merupakan platform top up terpercaya yang menyediakan berbagai kebutuhan digital dengan harga yang murah dan proses yang cepat. Kami hadir untuk mempermudah pengguna dalam melakukan pembelian item game dan pulsa hanya dalam hitungan detik. Dengan sistem otomatis dan layanan yang selalu aktif, Tokoisicash berkomitmen memberikan pengalaman transaksi yang aman, mudah, dan efisien bagi seluruh pelanggan di Indonesia.</span>
                  <span>Kami selalu berupaya memberikan pelayanan terbaik melalui dukungan pelanggan yang responsif dan pembayaran yang aman. Kepercayaan pengguna adalah prioritas utama kami, sehingga setiap transaksi dijamin transparan dan terlindungi. Bersama Tokoisicash, nikmati kemudahan top up tanpa ribet dan rasakan sensasi bertransaksi di platform digital yang cepat, aman, dan terpercaya.</span>
               </div>
               <div class="flex flex-col gap-3">
                  <span class="text-[20px] font-semibold">Mengapa Memilih Tokoisicash Untuk Kebutuhan Digital Kamu?</span>
                  <span>Tokoisicash hadir sebagai solusi terbaik untuk kamu yang ingin melakukan top up dengan cepat, mudah, dan harga bersahabat. Kami memahami bahwa kecepatan dan kepercayaan adalah hal penting dalam setiap transaksi digital, karena itu semua proses di Tokoisicash dibuat otomatis dan real-time. Cukup beberapa langkah sederhana, item yang kamu butuhkan langsung masuk ke akunmu tanpa harus menunggu lama.</span>
               </div>
               <div class="flex flex-col gap-3">
                  <span class="text-[20px] font-semibold">Cara Topup di Tokoisicash</span>
                  <div class="flex flex-col">
                     <span>1. Deposit terlebih dulu jika saldo kamu IDR 0</span>
                     <span>2. Pilih produk yang diinginkan</span>
                     <span>3. Lengkapi data kamu seperti ID atau Nomor HP</span>
                     <span>4. Pilih item yang diinginkan</span>
                     <span>5. Selesaikan pembayaran dan item akan masuk ke akunmu</span>
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
      
      // tampilkan dan sembunyikan search
      const search = document.getElementById("search");
      const searchOverlay = document.getElementById("searchOverlay");
      const searchContent = document.getElementById("searchContent");
      
      if (sessionStorage.getItem("searchActive")) {
         
         search.classList.remove("hidden");
         setTimeout(function() {
            searchOverlay.classList.replace("bg-black/0", "bg-black/50");
            searchContent.classList.replace("translate-y-full", "translate-y-0");
         }, 0);
         
      }
      
      function showSearch() {
         
         sessionStorage.setItem("searchActive", true);
         
         search.classList.remove("hidden");
         setTimeout(function() {
            searchOverlay.classList.replace("bg-black/0", "bg-black/50");
            searchContent.classList.replace("translate-y-full", "translate-y-0");
         }, 0);
         
      }
      
      function hideSearch() {
         
         sessionStorage.removeItem("searchActive");
         
         searchOverlay.classList.replace("bg-black/50", "bg-black/0");
         searchContent.classList.replace("translate-y-0", "translate-y-full");
         setTimeout(function() {
            search.classList.add("hidden");
         }, 300);
         
      }
      
   </script>
   
</body>
</html>