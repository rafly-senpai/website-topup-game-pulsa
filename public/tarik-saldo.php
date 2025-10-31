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
   $withdrawal = getDataFromDatabase($withdrawalDb, "SELECT * FROM withdrawal WHERE user_id = '$userId'");

?>
<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Tarik Saldo</title>
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
            
            <!-- deposit -->
            <?php $_SESSION["request"] = true; ?>
            <form class="bg-white border shadow-md shadow-gray-200 overflow-hidden rounded" action="/app/services/withdrawal-process.php" method="post">
               <div class="p-5 bg-white border-b">
                  <div class="flex items-center justify-center">
                     <div class="w-fit mx-auto text-center">
                        <span class="font-semibold">Tarik Saldo</span>
                     </div>
                  </div>
               </div>
               <div class="p-5">
                  <div class="flex flex-col gap-5">
                     <?php if (isset($_SESSION["withdrawalError"])) : ?>
                        <div class="w-fit">
                           <span class="text-red-500"><?= htmlspecialchars($_SESSION["withdrawalError"]); ?></span>
                        </div>
                        <?php unset($_SESSION["withdrawalError"]); ?>
                     <?php endif; ?>
                     <input class="p-3 bg-white border outline-none rounded" type="text" id="amountInput" name="amountInput" placeholder="Masukkan jumlah penarikan" required>
                     <div class="flex flex-col gap-3">
                        <span>Jumlah Instan</span>
                        <div class="grid grid-cols-3 gap-3 sm:grid-cols-4 md:grid-cols-5">
                           <button class="p-3 bg-white border rounded cursor-pointer" type="button" onclick="instantAmount(50000);">50.000</button>
                           <button class="p-3 bg-white border rounded cursor-pointer" type="button" onclick="instantAmount(100000);">100.000</button>
                           <button class="p-3 bg-white border rounded cursor-pointer" type="button" onclick="instantAmount(200000);">200.000</button>
                           <button class="p-3 bg-white border rounded cursor-pointer" type="button" onclick="instantAmount(300000);">300.000</button>
                           <button class="p-3 bg-white border rounded cursor-pointer" type="button" onclick="instantAmount(400000);">400.000</button>
                           <button class="p-3 bg-white border rounded cursor-pointer" type="button" onclick="instantAmount(500000);">500.000</button>
                        </div>
                     </div>
                     <button class="text-white p-3 bg-[#2a005c] rounded cursor-pointer" type="submit">Lanjutkan</button>
                  </div>
               </div>
            </form>
            
            <!-- riwayat deposit -->
            <section class="flex flex-col gap-5">
               <div class="flex flex-col">
                  <span class="text-[20px] font-semibold">Riwayat Penarikan</span>
                  <span>Semua riwayat penarikan kamu akan ditampilkan disini</span>
               </div>
               <hr>
               <?php if (!empty($withdrawal)) : ?>
                  <div class="flex flex-col gap-3">
                     <?php foreach (array_reverse($withdrawal) as $wd) : ?>
                        <div class="flex flex-col">
                           <div class="w-fit">
                              <span class="text-gray-500"><?= htmlspecialchars($wd["time"]); ?></span>
                           </div>
                           <a class="p-3 bg-white border shadow-md shadow-gray-200 rounded" href="/public/transaksi/detail-penarikan.php?id=<?= htmlspecialchars($wd["withdrawal_id"]); ?>">
                              <div class="flex items-center justify-between gap-3">
                                 <div class="flex items-center gap-3">
                                    <div class="w-[50px] h-[50px] bg-orange-500 flex items-center justify-center border-[3px] rounded-lg">
                                       <span class="text-2xl text-white flex items-center justify-center">
                                          <i class="hgi hgi-stroke hgi-wallet-01"></i>
                                       </span>
                                    </div>
                                    <div class="flex flex-col">
                                       <span><?= htmlspecialchars(number_format($wd["amount"], 0, ",", ".")); ?></span>
                                       <span class="text-[13px] text-gray-500">Tarik Saldo</span>
                                    </div>
                                 </div>
                                 <div class="text-end flex flex-col">
                                    <span>IDR <?= htmlspecialchars(number_format($wd["amount"] + 0, 0, ",", ".")); ?></span>
                                    <?php if ($wd["status"] === 0) : ?>
                                       <span class="text-[13px] text-orange-500">Sedang diproses</span>
                                    <?php elseif ($wd["status"] === 1) : ?>
                                       <span class="text-[13px] text-green-500">Sukses</span>
                                    <?php else : ?>
                                       <span class="text-[13px] text-red-500">Gagal</span>
                                    <?php endif; ?>
                                 </div>
                              </div>
                           </a>
                        </div>
                     <?php endforeach; ?>
                  </div>
               <?php else : ?>
                  <div class="h-[300px] p-5 bg-gray-50 rounded">
                     <div class="w-fit text-center flex flex-col">
                        <span class="text-[20px] font-semibold">Belum ada penarikan</span>
                        <span>Sistem penarikan saldo di Tokoisicash sudah terjamin aman dan terpercaya</span>
                     </div>
                  </div>
               <?php endif; ?>
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
               <span class="text-white"><a class="hover:underline" href="/public/beranda.php">Tokoisicash</a> merupakan platform topup murah dan terpercaya. Tokoisicash sudah dipercaya oleh lebih dari 100 ribu pelanggan di Indonesia.</div>
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
      
      // penarikan
      const amountInput = document.getElementById("amountInput");
      
      function instantAmount(amount) {
         amountInput.value = amount;
      }
      
   </script>
   
</body>
</html>