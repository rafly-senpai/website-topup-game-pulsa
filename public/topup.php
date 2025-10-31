<?php

   session_start();
   
   // cek user sudah login atau belum
   if (!isset($_SESSION["loginSuccess"])) {
      header("location:/public/auth/masuk.php");
      exit;
   }
   
   // ambil data dari url
   $productId = $_GET["id"];
   if (str_contains($productId, "'")) {
      header("location:/public/beranda.php");
      exit;
   }
   
   // includes
   include_once $_SERVER["DOCUMENT_ROOT"] . "/app/configs/koneksi.php";
   include_once $_SERVER["DOCUMENT_ROOT"] . "/app/helpers/functions.php";
   
   // ambil data dari database
   $product = getDataFromDatabase($productsDb, "SELECT * FROM products WHERE product_id = '$productId'");
   $items = getDataFromDatabase($itemsDb, "SELECT * FROM items WHERE product_id = '$productId'");
   if (empty($product) || empty($items)) {
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
   <title><?= htmlspecialchars(strtoupper($product[0]["name"])); ?></title>
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
            
            <!-- track -->
            <div class="flex items-center gap-1">
               <a class="text-gray-500 hover:underline" href="/public/beranda.php">Beranda</a>
               <span>/</span>
               <a class="text-gray-500 hover:underline" href="/public/topup.php?id=<?= htmlspecialchars($productId); ?>">Topup</a>
               <span>/</span>
               <a class="text-gray-500 hover:underline" href="/public/topup.php?id=<?= htmlspecialchars($productId); ?>"><?= htmlspecialchars(strtoupper($product[0]["name"])); ?></a>
            </div>
            
            <?php if (isset($_SESSION["topupError"])) : ?>
               <!-- error -->
               <span class="text-red-500"><?= htmlspecialchars($_SESSION["topupError"]); ?></span>
               <?php unset($_SESSION["topupError"]); ?>
            <?php endif; ?>
            
            <!-- data tujuan -->
            <section class="bg-white border shadow-md shadow-gray-200 overflow-hidden rounded">
               <div class="p-3 bg-[#2a005c]">
                  <div class="flex items-center">
                     <span class="text-white font-semibold">1. Lengkapi Data Tujuan</span>
                  </div>
               </div>
               <div class="p-5">
                  <div class="flex flex-col gap-3">
                     <?php if ($product[0]["category"] === "game") : ?>
                        <input class="p-3 bg-white border outline-none rounded" type="text" id="destinationInput" placeholder="Masukkan <?= htmlspecialchars($product[0]["name"]); ?> id">
                     <?php elseif ($product[0]["category"] === "pulsa") : ?>
                        <input class="p-3 bg-white border outline-none rounded" type="text" id="destinationInput" placeholder="Masukkan nomor hp">
                     <?php endif; ?>
                     <span>Kami memerlukan data tujuan agar tidak terjadi kesalahan dalam bertransaksi.</span>
                  </div>
               </div>
            </section>
            
            <!-- pilihan item -->
            <section class="bg-white border shadow-md shadow-gray-200 overflow-hidden rounded">
               <div class="p-3 bg-[#2a005c]">
                  <div class="flex items-center">
                     <span class="text-white font-semibold">2. Pilih Item</span>
                  </div>
               </div>
               <div class="p-5">
                  <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                     <?php foreach ($items as $item) : ?>
                        <?php if ($item["status"] === 1) : ?>
                           <div class="p-5 border rounded cursor-pointer active:bg-gray-50" onclick="selectItem('<?= htmlspecialchars($item["item"]); ?>', <?= htmlspecialchars($item["price"]); ?>);">
                              <div class="flex flex-col">
                                 <span><?= htmlspecialchars($item["item"]); ?></span>
                                 <s class="text-gray-500">IDR <?= htmlspecialchars(number_format($item["price"] + 850, 0, ",", ".")); ?></s>
                                 <span class="text-[#2a005c]">IDR <?= htmlspecialchars(number_format($item["price"], 0, ",", ".")); ?></span>
                              </div>
                           </div>
                        <?php endif; ?>
                     <?php endforeach; ?>
                  </div>
               </div>
            </section>
            
            <!-- detail pembelian -->
            <?php $_SESSION["request"] = true; ?>
            <div class="top-0 left-0 w-full h-full fixed z-10 hidden" id="purchaseDetails">
               <div class="max-w-3xl mx-auto h-full p-5 bg-black/0 flex flex-col justify-end transition duration-300 overflow-hidden" id="purchaseDetailsOverlay">
                  <div class="bg-white transform translate-y-full transition duration-300 overflow-hidden rounded" id="purchaseDetailsContent">
                     <div class="p-5 bg-white border-b">
                        <div class="flex items-center justify-between gap-5">
                           <span>Detail Pembelian</span>
                           <button class="flex items-center justify-center cursor-pointer" type="button" onclick="hidePurchaseDetais();">
                              <i class="hgi hgi-stroke hgi-cancel-01"></i>
                           </button>
                        </div>
                     </div>
                     <div class="p-5">
                        <div class="flex flex-col gap-5">
                           
                           <div class="flex flex-col">
                              <div class="p-3 bg-gray-50 flex items-center justify-between gap-5 border-b">
                                 <span>Data tujuan</span>
                                 <span class="font-semibold" id="destinationDataResult"></span>
                              </div>
                              <div class="p-3 flex items-center justify-between gap-5 border-b">
                                 <span>Item</span>
                                 <span class="font-semibold" id="itemResult"></span>
                              </div>
                              <div class="p-3 bg-gray-50 flex items-center justify-between gap-5 border-b">
                                 <span>Harga</span>
                                 <span class="font-semibold" id="priceResult"></span>
                              </div>
                           </div>
                           
                           <hr>
                           
                           <div class="flex items-center justify-between gap-5">
                              <div class="flex flex-col">
                                 <span class="text-gray-500">Total pembayaran</span>
                                 <span class="text-[#2a005c] font font-semibold" id="totalPaymentResult"></span>
                              </div>
                              <form action="/app/services/topup-process.php" method="post">
                                 <div class="hidden">
                                    <input type="text" id="idInput" name="idInput" value="" readonly>
                                    <input type="text" name="productIdInput" value="<?= htmlspecialchars($productId); ?>" readonly>
                                    <input type="text" id="itemInput" name="itemInput" value="" readonly>
                                    <input type="text" id="priceInput" name="priceInput" value="" readonly>
                                 </div>
                                 <button class="text-white p-3 bg-[#2a005c] rounded cursor-pointer" type="submit">Bayar Sekarang</button>
                              </form>
                           </div>
                           
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            
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
      
      // tampilkan dan sembunyikan detail pembelian
      const purchaseDetails = document.getElementById("purchaseDetails");
      const purchaseDetailsOverlay = document.getElementById("purchaseDetailsOverlay");
      const purchaseDetailsContent = document.getElementById("purchaseDetailsContent");
      
      // pilih item
      const destinationInput = document.getElementById("destinationInput");
      
      const destinationDataResult = document.getElementById("destinationDataResult");
      const itemResult = document.getElementById("itemResult");
      const priceResult = document.getElementById("priceResult");
      
      const totalPaymentResult = document.getElementById("totalPaymentResult");
      
      const idInput = document.getElementById("idInput");
      const itemInput = document.getElementById("itemInput");
      const priceInput = document.getElementById("priceInput");
      
      
      function selectItem(item, price) {
         
         destinationDataResult.textContent = destinationInput.value;
         itemResult.textContent = item;
         priceResult.textContent = `IDR ${price.toLocaleString()}`;
         
         totalPaymentResult.textContent = `IDR ${price.toLocaleString()}`;
         
         idInput.value = destinationInput.value;
         itemInput.value = item;
         priceInput.value = price;
         
         purchaseDetails.classList.remove("hidden");
         setTimeout(function() {
            purchaseDetailsOverlay.classList.replace("bg-black/0", "bg-black/50");
            purchaseDetailsContent.classList.replace("translate-y-full", "translate-y-0");
         }, 0);
         
      }
      
      function hidePurchaseDetais() {
         
         purchaseDetailsOverlay.classList.replace("bg-black/50", "bg-black/0");
         purchaseDetailsContent.classList.replace("translate-y-0", "translate-y-full");
         setTimeout(function() {
            purchaseDetails.classList.add("hidden");
         }, 300);
         
      }
      
   </script>
   
</body>
</html>