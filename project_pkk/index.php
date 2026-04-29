<?php
session_start();
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JACHIVE | Premium Thrift</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;700;800&family=Playfair+Display:italic,wght@700&display=swap" rel="stylesheet">
    
    <style>
        :root { --sky-primary: #0ea5e9; }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: #f0f9ff; 
            color: #0f172a;
            scroll-behavior: smooth;
        }
        /* Glassmorphism Effect */
        .glass {
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        /* Soft Floating Animation */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .animate-float { animation: float 4s ease-in-out infinite; }
        .font-playfair { font-family: 'Playfair Display', serif; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #0ea5e9; border-radius: 10px; }
    </style>
</head>
<body>

    <div class="fixed top-0 left-0 w-full h-full -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-sky-300/30 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-blue-400/20 blur-[150px] rounded-full"></div>
    </div>

    <nav class="fixed top-6 left-1/2 -translate-x-1/2 w-[90%] max-w-6xl glass rounded-2xl z-50 px-8 py-4 flex justify-between items-center">
        <div class="text-xl font-800 tracking-tighter flex items-center gap-2">
            <div class="w-8 h-8 bg-sky-500 rounded-lg flex items-center justify-center text-white text-xs italic">JA</div>
            JACHIVE.
        </div>
        <ul class="hidden md:flex space-x-10 text-[11px] font-bold uppercase tracking-[0.2em]">
            <li class="hover:text-sky-500 transition cursor-pointer"><a href="#">New Arrivals</a></li>
            <li class="hover:text-sky-500 transition cursor-pointer"><a href="#catalog">Collections</a></li>
            <li class="hover:text-sky-500 transition cursor-pointer"><a href="#">About</a></li>
        </ul>
        <div class="flex items-center gap-6">
            <?php if(isset($_SESSION['user'])): ?>
                <div class="flex items-center gap-3">
                    <span class="text-[11px] font-800 text-slate-800 uppercase italic">Hi, <?= $_SESSION['user'] ?>!</span>
                    <a href="logout.php" class="text-[10px] text-red-500 font-bold hover:underline">Logout</a>
                </div>
            <?php else: ?>
                <a href="login.php" class="text-sm font-bold opacity-70 hover:opacity-100 transition-all hover:text-sky-500">Login</a>
            <?php endif; ?>

            <div onclick="openCart()" class="relative bg-sky-500 text-white p-2 px-4 rounded-xl text-xs font-bold shadow-lg shadow-sky-200 cursor-pointer hover:bg-sky-600 transition">
                CART (<span id="cart-count">0</span>)
            </div>
        </div>
    </nav>
    <div id="cart-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] hidden items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-[2rem] overflow-hidden shadow-2xl">
        <div class="bg-sky-500 p-6 text-white flex justify-between items-center">
            <h3 class="font-800 italic uppercase tracking-tighter text-xl">Your Bag</h3>
            <button onclick="closeCart()" class="text-white opacity-70 hover:opacity-100">✕ Close</button>
        </div>
        
        <div id="cart-items" class="p-6 max-h-[400px] overflow-y-auto space-y-4">
            </div>

        <div class="p-6 border-t border-slate-100 bg-slate-50">
            <div class="flex justify-between items-center mb-4">
                <span class="font-bold text-slate-500 text-sm">TOTAL</span>
                <span id="cart-total" class="font-800 text-xl text-slate-800 italic">Rp 0</span>
            </div>
            <button onclick="checkoutWhatsApp()" class="w-full bg-slate-900 text-white py-4 rounded-xl font-bold hover:bg-sky-600 transition uppercase text-xs tracking-widest">
                Checkout via WhatsApp
            </button>
        </div>
    </div>
</div>

    <header class="pt-48 pb-20 px-6 container mx-auto flex flex-col items-center text-center">
        <span class="bg-sky-100 text-sky-600 px-4 py-1.5 rounded-full text-[10px] font-800 uppercase tracking-widest mb-6 border border-sky-200">New Thrift for YOU</span>
        <h1 class="text-6xl md:text-8xl font-800 tracking-tighter mb-8 leading-[0.9]">
            WEAR THE <br> <span class="font-playfair text-sky-500 italic lowercase tracking-normal">technic</span> ATTIRE.
        </h1>
        <p class="max-w-md text-slate-500 leading-relaxed mb-12 text-sm font-medium">
            Discover a curated archive of authentic thrifted pieces. High quality, hand-picked, and ready to refresh your daily outfit.
        </p>
        <div class="flex gap-4">
            <a href="#catalog" class="bg-slate-900 text-white px-10 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest hover:scale-105 transition active:scale-95 shadow-xl">Start Shopping</a>
            <button class="glass px-10 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-white/60 transition">Lookbook</button>
        </div>
    </header>

    <main id="catalog" class="container mx-auto px-6 py-20">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-4">
    <div>
        <h2 class="text-4xl font-800 tracking-tighter uppercase mb-2 italic">
            <?= isset($_GET['category']) ? $_GET['category'] : 'Selected Archive'; ?>
        </h2>
        <div class="w-20 h-1.5 bg-sky-500 rounded-full"></div>
    </div>

    <div class="flex gap-3">
        <a href="index.php#catalog" class="glass px-4 py-2 rounded-full text-[10px] font-bold hover:bg-sky-500 hover:text-white transition">ALL</a>
        
        <a href="index.php?category=Shirts#catalog" class="glass px-4 py-2 rounded-full text-[10px] font-bold hover:bg-sky-500 hover:text-white transition">SHIRTS</a>
        
        <a href="index.php?category=Pants#catalog" class="glass px-4 py-2 rounded-full text-[10px] font-bold hover:bg-sky-500 hover:text-white transition">PANTS</a>
        
        <a href="index.php?category=Jackets#catalog" class="glass px-4 py-2 rounded-full text-[10px] font-bold hover:bg-sky-500 hover:text-white transition">JACKETS</a>
    </div>
</div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-8 px-4 md:px-0">
            <?php
include 'config.php';

// Menangkap kategori dari klik tombol (URL)
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';

if ($category_filter) {
    // Jika ada filter, ambil produk yang kategorinya sesuai
    // Kita gunakan JOIN agar bisa memfilter berdasarkan NAMA kategori
    $sql = "SELECT products.* FROM products 
            JOIN categories ON products.id_category = categories.id_category 
            WHERE categories.nama_kategori = '$category_filter'";
    $query = mysqli_query($conn, $sql);
} else {
    // Jika tidak ada filter (halaman awal), tampilkan semua
    $query = mysqli_query($conn, "SELECT * FROM products");
}
?>

<?php while($row = mysqli_fetch_assoc($query)): ?> <div class="group relative">
                <div class="glass rounded-[2rem] p-5 transition-all duration-500 group-hover:bg-white group-hover:shadow-[0_30px_60px_-15px_rgba(14,165,233,0.2)]">
                    <div class="relative rounded-[1.5rem] overflow-hidden aspect-[4/5] mb-6 shadow-inner bg-sky-50">
                        <img src="assets/<?= $row['gambar']; ?>" alt="<?= $row['nama_produk']; ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-[10px] font-800 text-sky-600 border border-sky-100">
                            LIMITED PIECE
                        </div>
                    </div>

                    <div class="flex justify-between items-start px-2 mb-6">
                        <div>
                            <h3 class="text-lg font-800 uppercase tracking-tight text-slate-800"><?= $row['nama_produk'] ?></h3>
                            <p class="text-sky-500 text-sm font-bold">Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
                        </div>
                        
                        <button onclick="addToCart('<?= $row['nama_produk'] ?>', <?= $row['harga'] ?>)" 
                                class="w-10 h-10 rounded-full border border-slate-200 flex items-center justify-center hover:bg-sky-500 hover:text-white hover:border-sky-500 transition-all">
                            +
                        </button>
                    </div>

                    <button onclick="buyNow('<?= $row['nama_produk']; ?>')" class="w-full bg-slate-900 text-white py-4 rounded-2xl text-[10px] font-800 uppercase tracking-[0.2em] transition-all hover:bg-sky-500 hover:shadow-lg hover:shadow-sky-200 active:scale-95">
                        Grab This Look
                    </button>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </main>

    <footer class="mt-32 pb-20 px-8">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center border-t border-slate-200 pt-10 gap-8">
        <div>
            <div class="text-xl font-800 tracking-tighter flex items-center gap-2 mb-2">
                <div class="w-6 h-6 bg-slate-900 rounded flex items-center justify-center text-white text-[10px] italic">JA</div>
                JACHIVE.
            </div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">© 2026 Developed by ZakiRojabi • XI SIJA A</p>
        </div>

        <div class="flex gap-4">
            <a href="https://instagram.com/jaky4.2" target="_blank" class="w-12 h-12 bg-white/50 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white hover:bg-gradient-to-tr hover:from-yellow-400 hover:via-red-500 hover:to-purple-500 hover:text-white transition-all shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
            </a>

            <a href="https://wa.me/6285724956289" target="_blank" class="w-12 h-12 bg-white/50 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white hover:bg-green-500 hover:text-white transition-all shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 1 1-7.6-11.7 8.38 8.38 0 0 1 3.8.9L21 3z"></path></svg>
            </a>
        </div>
    </div>
</footer>

    <script>
        function addToCart(name) {
            Swal.fire({
                title: 'Saved!',
                text: `${name} has been added to your collection.`,
                iconHtml: '<span class="text-sky-500 italic">★</span>',
                confirmButtonText: 'Great',
                confirmButtonColor: '#0ea5e9',
                background: '#fff',
                customClass: {
                    popup: 'rounded-[2rem] border-4 border-sky-50'
                }
            });
        }

        function buyNow(name) {
            const adminWA = "6285724956289"; // GANTI DENGAN NOMOR KAMU
            const text = encodeURIComponent(`Halo Jachive, saya ingin mengamankan item: ${name}. Apakah masih tersedia?`);
            
            Swal.fire({
                title: 'Secure This Piece?',
                text: 'You will be redirected to WhatsApp for instant checkout.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#0ea5e9',
                cancelButtonColor: '#0f172a',
                confirmButtonText: 'Yes, secure it!',
                cancelButtonText: 'Wait'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open(`https://wa.me/${adminWA}?text=${text}`, '_blank');
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    // 1. Inisialisasi keranjang dari memori browser (biar kalau refresh gak ilang)
    let cart = JSON.parse(localStorage.getItem('skythrift_cart')) || [];

    // 2. Fungsi untuk update tampilan angka di navbar
    function updateCartUI() {
        const cartCount = document.getElementById('cart-count');
        if (cartCount) {
            // Menghitung total jumlah barang di keranjang
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            cartCount.innerText = totalItems;
        }
        // Simpan perubahan ke memori browser
        localStorage.setItem('skythrift_cart', JSON.stringify(cart));
    }

    // 3. Fungsi utama saat tombol "+" diklik
    function addToCart(name, price) {
        // Cek apakah barang sudah ada di keranjang
        const existingItem = cart.find(item => item.name === name);

        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            // Kalau barang baru, tambahkan ke list
            cart.push({ name: name, price: price, quantity: 1 });
        }

        // Update angka di navbar
        updateCartUI();

        // 4. Munculkan notifikasi estetik ala Gen Z
        Swal.fire({
            title: 'Added to Bag!',
            text: name + ' berhasil masuk keranjang.',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    }

    // Fungsi Buka Modal
function openCart() {
    renderCart(); // Update tampilan sebelum buka
    document.getElementById('cart-modal').classList.remove('hidden');
    document.getElementById('cart-modal').classList.add('flex');
}

// Fungsi Tutup Modal
function closeCart() {
    document.getElementById('cart-modal').classList.add('hidden');
    document.getElementById('cart-modal').classList.remove('flex');
}

// Fungsi untuk Menampilkan List Barang & Hapus
function renderCart() {
    const cartItemsDiv = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');
    let total = 0;

    if (cart.length === 0) {
        cartItemsDiv.innerHTML = '<p class="text-center text-slate-400 py-10">Keranjang masih kosong nih...</p>';
        cartTotal.innerText = 'Rp 0';
        return;
    }

    cartItemsDiv.innerHTML = '';
    cart.forEach((item, index) => {
        total += item.price * item.quantity;
        cartItemsDiv.innerHTML += `
            <div class="flex justify-between items-center border-b border-slate-100 pb-4">
                <div>
                    <h4 class="font-bold text-slate-800 text-sm uppercase">${item.name}</h4>
                    <p class="text-xs text-sky-500 font-bold">${item.quantity}x - Rp ${item.price.toLocaleString('id-ID')}</p>
                </div>
                <button onclick="removeFromCart(${index})" class="text-red-400 hover:text-red-600 text-xs font-bold">Remove</button>
            </div>
        `;
    });
    cartTotal.innerText = 'Rp ' + total.toLocaleString('id-ID');
}

// Fungsi Hapus Barang
function removeFromCart(index) {
    cart.splice(index, 1); // Hapus item berdasarkan urutan
    updateCartUI(); // Update angka navbar
    renderCart(); // Update tampilan modal
}

// Bonus: Fungsi Checkout WA
function checkoutWhatsApp() {
    let message = "Halo Skythrift, saya mau pesan:%0A%0A";
    cart.forEach(item => {
        message += `- ${item.name} (${item.quantity}x)%0A`;
    });
    message += `%0A*Total: ${document.getElementById('cart-total').innerText}*`;
    window.open(`https://wa.me/6285724956289?text=${message}`, '_blank'); // Ganti nomor WA kamu
}

    // Jalankan fungsi update UI saat website pertama kali dibuka
    document.addEventListener('DOMContentLoaded', updateCartUI);
    </script>
</body>
</html>