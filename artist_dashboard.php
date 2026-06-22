<?php
// artist_dashboard.php — Resha Art · Artist Dashboard
// Drop this file into your Hostinger public_html folder.
// Tailwind CSS is loaded via CDN — no build step required.

$artist_name    = "Layla Ibrahim";
$artist_title   = "Artist · Riyadh";
$artist_initials = "لي";
$today = date('l, F j, Y');

$artworks = [
    [
        "id"          => 1,
        "title"       => "Desert Whispers",
        "description" => "Acrylic on canvas. A journey through the golden dunes of the Empty Quarter.",
        "price"       => 1200,
        "art_type"    => "abstract",
        "status"      => "available",
        "image_url"   => "https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?w=400&q=80",
        "created_at"  => "May 10, 2026",
    ],
    [
        "id"          => 2,
        "title"       => "Blue Serenity",
        "description" => "Watercolor, inspired by the Arabian Gulf at dawn.",
        "price"       => 850,
        "art_type"    => "landscape",
        "status"      => "sold",
        "image_url"   => "https://images.unsplash.com/photo-1547891654-e66ed7ebb968?w=400&q=80",
        "created_at"  => "Apr 22, 2026",
    ],
    [
        "id"          => 3,
        "title"       => "Silent Portrait",
        "description" => "Oil on linen. A study of light and shadow in the modern Arab face.",
        "price"       => 2400,
        "art_type"    => "portrait",
        "status"      => "auction",
        "image_url"   => "https://images.unsplash.com/photo-1578301978069-55e07489cfe1?w=400&q=80",
        "created_at"  => "Jun 1, 2026",
    ],
    [
        "id"          => 4,
        "title"       => "Neon Medina",
        "description" => "Digital art fusing traditional Arabesque patterns with cyberpunk aesthetics.",
        "price"       => 600,
        "art_type"    => "digital",
        "status"      => "available",
        "image_url"   => "https://images.unsplash.com/photo-1637858868799-7f26a0640eb6?w=400&q=80",
        "created_at"  => "Jun 15, 2026",
    ],
];

$active_listings = count(array_filter($artworks, fn($a) => in_array($a['status'], ['available', 'auction'])));
$sold_artworks   = array_filter($artworks, fn($a) => $a['status'] === 'sold');
$sold_count      = count($sold_artworks);
$total_sales     = array_sum(array_column(iterator_to_array((function() use ($sold_artworks) { foreach($sold_artworks as $a) yield $a; })()), 'price'));
$auction_count   = count(array_filter($artworks, fn($a) => $a['status'] === 'auction'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Artist Dashboard — Resha Art</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            violet: {
              50:  '#f5f3ff',
              100: '#ede9fe',
              200: '#ddd6fe',
              400: '#a78bfa',
              600: '#7c3aed',
              700: '#6d28d9',
            }
          }
        }
      }
    }
  </script>
  <style>
    [x-cloak] { display: none !important; }
    .line-clamp-2 {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    .card-img { transition: transform 0.5s ease; }
    .artwork-card:hover .card-img { transform: scale(1.05); }
    /* Mobile sidebar overlay */
    #sidebar-overlay { display: none; }
    #sidebar-overlay.open { display: block; }
    #mobile-sidebar { transform: translateX(-100%); transition: transform 0.3s ease; }
    #mobile-sidebar.open { transform: translateX(0); }
    /* Spinner */
    @keyframes spin { to { transform: rotate(360deg); } }
    .spinner { animation: spin 0.7s linear infinite; }
    /* Success toast */
    #success-toast { transition: opacity 0.4s ease; }
  </style>
</head>
<body class="bg-gray-50 font-sans">

<!-- ═══════════════════════════════════════════
     MOBILE SIDEBAR OVERLAY
════════════════════════════════════════════ -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/40 z-30 md:hidden" onclick="closeSidebar()"></div>

<!-- ═══════════════════════════════════════════
     LAYOUT WRAPPER
════════════════════════════════════════════ -->
<div class="flex min-h-screen">

  <!-- ─── SIDEBAR (desktop) ─── -->
  <aside class="hidden md:flex flex-col w-60 min-h-screen bg-white border-r border-gray-100 px-4 py-8 sticky top-0 h-screen overflow-y-auto">
    <?php include_once __DIR__ . '/sidebar_inner.php'; /* optional include */ ?>
    <!-- Brand -->
    <div class="flex items-center gap-2 px-2 mb-10">
      <div class="w-9 h-9 rounded-xl bg-violet-600 flex items-center justify-center text-white font-bold text-lg select-none">R</div>
      <div>
        <p class="font-bold text-gray-900 leading-tight">Resha Art</p>
        <p class="text-xs text-gray-400">Artist Studio</p>
      </div>
    </div>
    <!-- Nav -->
    <nav class="flex-1 space-y-1">
      <?php
      $nav_items = [
        ['icon'=>'📊','label'=>'Dashboard',    'active'=>true],
        ['icon'=>'🖼️','label'=>'My Portfolio', 'active'=>false],
        ['icon'=>'➕','label'=>'List Artwork',  'active'=>false],
        ['icon'=>'🏷️','label'=>'Auctions',     'active'=>false],
        ['icon'=>'💬','label'=>'Messages',      'active'=>false],
        ['icon'=>'💰','label'=>'Earnings',      'active'=>false],
        ['icon'=>'⚙️','label'=>'Settings',      'active'=>false],
      ];
      foreach ($nav_items as $item):
        $cls = $item['active']
          ? 'bg-violet-50 text-violet-700'
          : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900';
      ?>
      <button class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition <?= $cls ?>">
        <span class="text-base"><?= $item['icon'] ?></span>
        <?= htmlspecialchars($item['label']) ?>
      </button>
      <?php endforeach; ?>
    </nav>
    <!-- Artist footer -->
    <div class="mt-6 pt-6 border-t border-gray-100 px-2 flex items-center gap-3">
      <div class="w-9 h-9 rounded-full bg-gradient-to-br from-violet-400 to-fuchsia-500 flex items-center justify-center text-white font-semibold text-sm select-none">
        <?= htmlspecialchars($artist_initials) ?>
      </div>
      <div class="flex-1 min-w-0">
        <p class="text-sm font-medium text-gray-900 truncate"><?= htmlspecialchars($artist_name) ?></p>
        <p class="text-xs text-gray-400 truncate"><?= htmlspecialchars($artist_title) ?></p>
      </div>
    </div>
  </aside>

  <!-- ─── MOBILE SIDEBAR (slide-in) ─── -->
  <aside id="mobile-sidebar" class="fixed top-0 left-0 h-full w-64 bg-white border-r border-gray-100 px-4 py-8 z-40 flex flex-col md:hidden overflow-y-auto">
    <div class="flex items-center justify-between mb-8">
      <div class="flex items-center gap-2">
        <div class="w-9 h-9 rounded-xl bg-violet-600 flex items-center justify-center text-white font-bold text-lg">R</div>
        <p class="font-bold text-gray-900">Resha Art</p>
      </div>
      <button onclick="closeSidebar()" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
    </div>
    <nav class="flex-1 space-y-1">
      <?php foreach ($nav_items as $item):
        $cls = $item['active'] ? 'bg-violet-50 text-violet-700' : 'text-gray-600 hover:bg-gray-50'; ?>
      <button onclick="closeSidebar()" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition <?= $cls ?>">
        <span><?= $item['icon'] ?></span><?= htmlspecialchars($item['label']) ?>
      </button>
      <?php endforeach; ?>
    </nav>
    <div class="mt-6 pt-6 border-t border-gray-100 flex items-center gap-3">
      <div class="w-9 h-9 rounded-full bg-gradient-to-br from-violet-400 to-fuchsia-500 flex items-center justify-center text-white font-semibold text-sm">
        <?= htmlspecialchars($artist_initials) ?>
      </div>
      <div class="min-w-0">
        <p class="text-sm font-medium text-gray-900 truncate"><?= htmlspecialchars($artist_name) ?></p>
        <p class="text-xs text-gray-400 truncate"><?= htmlspecialchars($artist_title) ?></p>
      </div>
    </div>
  </aside>

  <!-- ═══════════════════════════════════════════
       MAIN CONTENT
  ════════════════════════════════════════════ -->
  <main class="flex-1 p-5 md:p-10 overflow-auto">

    <!-- Mobile top bar -->
    <div class="flex items-center justify-between mb-6 md:hidden">
      <button onclick="openSidebar()" class="p-2 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
      <div class="flex items-center gap-2">
        <div class="w-8 h-8 rounded-xl bg-violet-600 flex items-center justify-center text-white font-bold text-sm">R</div>
        <span class="font-bold text-gray-900 text-sm">Resha Art</span>
      </div>
      <div class="w-9"></div>
    </div>

    <!-- ── PAGE HEADER ── -->
    <div class="flex items-start justify-between mb-8">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Artist Dashboard</h1>
        <p class="text-gray-500 text-sm mt-1">Welcome back, <?= htmlspecialchars($artist_name) ?> — here's how your studio is doing.</p>
      </div>
      <p class="text-sm text-gray-400 hidden sm:block"><?= $today ?></p>
    </div>

    <!-- ── STATS ── -->
    <section class="mb-10">
      <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-4">Summary</p>
      <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

        <!-- Card: Active Listings -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-start gap-4">
          <div class="w-12 h-12 rounded-xl bg-violet-100 flex items-center justify-center text-2xl">🖼️</div>
          <div>
            <p class="text-sm text-gray-500 font-medium">Active Listings</p>
            <p class="text-3xl font-bold text-gray-900 mt-0.5" id="stat-active"><?= $active_listings ?></p>
            <p class="text-xs text-gray-400 mt-1">Available + Auction</p>
          </div>
        </div>

        <!-- Card: Total Sales -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-start gap-4">
          <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-2xl">💰</div>
          <div>
            <p class="text-sm text-gray-500 font-medium">Total Sales</p>
            <p class="text-3xl font-bold text-gray-900 mt-0.5" id="stat-sales">$<?= number_format($total_sales) ?></p>
            <p class="text-xs text-gray-400 mt-1" id="stat-sold-count"><?= $sold_count ?> artwork<?= $sold_count !== 1 ? 's' : '' ?> sold</p>
          </div>
        </div>

        <!-- Card: Live Auctions -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-start gap-4">
          <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-2xl">🔨</div>
          <div>
            <p class="text-sm text-gray-500 font-medium">Live Auctions</p>
            <p class="text-3xl font-bold text-gray-900 mt-0.5" id="stat-auctions"><?= $auction_count ?></p>
            <p class="text-xs text-gray-400 mt-1">Currently bidding</p>
          </div>
        </div>

        <!-- Card: Total Artworks -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-start gap-4">
          <div class="w-12 h-12 rounded-xl bg-sky-100 flex items-center justify-center text-2xl">📦</div>
          <div>
            <p class="text-sm text-gray-500 font-medium">Total Artworks</p>
            <p class="text-3xl font-bold text-gray-900 mt-0.5" id="stat-total"><?= count($artworks) ?></p>
            <p class="text-xs text-gray-400 mt-1">In your portfolio</p>
          </div>
        </div>

      </div>
    </section>

    <!-- ── UPLOAD FORM ── -->
    <section class="mb-10">
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
          <span class="text-2xl">🖼️</span> List a New Artwork
        </h2>

        <!-- Success toast -->
        <div id="success-toast" class="hidden mb-5 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
          ✅ Artwork listed successfully!
        </div>

        <form id="upload-form" onsubmit="handleUpload(event)" class="space-y-5" novalidate>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <!-- Title -->
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 mb-1.5">
                Title <span class="text-rose-500">*</span>
              </label>
              <input id="f-title" type="text" placeholder="e.g., Golden Horizon" required
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-violet-400 focus:border-transparent transition" />
            </div>

            <!-- Price -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1.5">
                Price (USD) <span class="text-rose-500">*</span>
              </label>
              <div class="relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 font-medium">$</span>
                <input id="f-price" type="number" placeholder="0.00" min="0" step="0.01" required
                  class="w-full pl-8 pr-4 py-2.5 rounded-xl border border-gray-200 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-violet-400 focus:border-transparent transition" />
              </div>
            </div>

            <!-- Art Type -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1.5">
                Art Type <span class="text-rose-500">*</span>
              </label>
              <select id="f-type" required
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-gray-900 focus:outline-none focus:ring-2 focus:ring-violet-400 focus:border-transparent transition bg-white">
                <option value="" disabled selected>Select a type...</option>
                <?php foreach (['Abstract','Portrait','Digital','Landscape','Still Life','Calligraphy','Sculpture','Photography'] as $t): ?>
                <option value="<?= strtolower($t) ?>"><?= $t ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
              <textarea id="f-desc" rows="3" placeholder="Tell buyers about this piece — materials, inspiration, dimensions..."
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-violet-400 focus:border-transparent transition resize-none"></textarea>
            </div>

            <!-- Image Upload -->
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 mb-1.5">Artwork Image</label>
              <div class="flex items-start gap-4">
                <label class="flex-1 flex flex-col items-center justify-center gap-2 border-2 border-dashed border-gray-200 rounded-xl py-8 cursor-pointer hover:border-violet-400 hover:bg-violet-50 transition group">
                  <span class="text-3xl">📁</span>
                  <span class="text-sm text-gray-500 group-hover:text-violet-600 transition">Click to upload image</span>
                  <span class="text-xs text-gray-400">PNG, JPG, WEBP up to 10MB</span>
                  <input id="f-image" type="file" accept="image/*" class="hidden" onchange="previewImage(this)" />
                </label>
                <div id="image-preview-wrap" class="hidden w-32 h-32 rounded-xl overflow-hidden border border-gray-200 flex-shrink-0">
                  <img id="image-preview" src="" alt="Preview" class="w-full h-full object-cover" />
                </div>
              </div>
            </div>

          </div><!-- /grid -->

          <button type="submit" id="submit-btn"
            class="w-full py-3 rounded-xl bg-violet-600 text-white font-semibold text-sm hover:bg-violet-700 active:scale-95 transition flex items-center justify-center gap-2">
            + List Artwork
          </button>
        </form>
      </div>
    </section>

    <!-- ── PORTFOLIO GRID ── -->
    <section>
      <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
          🎨 My Portfolio
          <span class="text-sm font-normal text-gray-400" id="portfolio-count">(<?= count($artworks) ?>)</span>
        </h2>
        <!-- Filter Tabs -->
        <div class="flex items-center gap-1 bg-gray-100 rounded-xl p-1">
          <?php foreach (['all','available','auction','sold'] as $tab): ?>
          <button onclick="filterPortfolio('<?= $tab ?>')" data-tab="<?= $tab ?>"
            class="tab-btn px-3 py-1.5 rounded-lg text-xs font-semibold capitalize transition <?= $tab === 'all' ? 'bg-white text-violet-700 shadow-sm' : 'text-gray-500 hover:text-gray-700' ?>">
            <?= $tab ?>
          </button>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Grid -->
      <div id="portfolio-grid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-5">

        <?php foreach ($artworks as $aw):
          $status_cls = match($aw['status']) {
            'available' => 'bg-emerald-100 text-emerald-700',
            'sold'      => 'bg-gray-100 text-gray-500',
            'auction'   => 'bg-amber-100 text-amber-700',
            default     => 'bg-emerald-100 text-emerald-700',
          };
          $placeholder = 'https://images.unsplash.com/photo-1578301978018-3005759f48f7?w=400&q=80';
          $img = $aw['image_url'] ?: $placeholder;
        ?>
        <div class="artwork-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow"
             data-status="<?= htmlspecialchars($aw['status']) ?>">
          <!-- Image -->
          <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
            <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($aw['title']) ?>"
              class="card-img w-full h-full object-cover"
              onerror="this.src='<?= $placeholder ?>'" />
            <span class="absolute top-3 right-3 text-xs font-semibold px-2.5 py-1 rounded-full capitalize <?= $status_cls ?>">
              <?= htmlspecialchars($aw['status']) ?>
            </span>
            <?php if ($aw['art_type']): ?>
            <span class="absolute top-3 left-3 text-xs font-medium px-2.5 py-1 rounded-full bg-white/80 backdrop-blur text-gray-700 capitalize">
              <?= htmlspecialchars($aw['art_type']) ?>
            </span>
            <?php endif; ?>
          </div>
          <!-- Info -->
          <div class="p-4">
            <h3 class="font-semibold text-gray-900 truncate"><?= htmlspecialchars($aw['title']) ?></h3>
            <?php if ($aw['description']): ?>
            <p class="text-sm text-gray-500 mt-1 line-clamp-2"><?= htmlspecialchars($aw['description']) ?></p>
            <?php endif; ?>
            <div class="flex items-center justify-between mt-3">
              <span class="text-violet-600 font-bold text-lg">$<?= number_format($aw['price']) ?></span>
              <span class="text-xs text-gray-400"><?= htmlspecialchars($aw['created_at']) ?></span>
            </div>
            <div class="flex gap-2 mt-3">
              <button class="flex-1 py-1.5 text-xs font-medium rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 transition">Edit</button>
              <button class="flex-1 py-1.5 text-xs font-medium rounded-lg border border-violet-200 text-violet-600 hover:bg-violet-50 transition">Mark Sold</button>
            </div>
          </div>
        </div>
        <?php endforeach; ?>

      </div><!-- /portfolio-grid -->

      <!-- Empty state -->
      <div id="empty-state" class="hidden text-center py-20 bg-white rounded-2xl border border-dashed border-gray-200">
        <p class="text-4xl mb-3">🖼️</p>
        <p class="text-gray-500 text-sm">No artworks in this category yet.</p>
      </div>

    </section>

  </main><!-- /main -->
</div><!-- /layout -->


<!-- ═══════════════════════════════════════════
     JAVASCRIPT
════════════════════════════════════════════ -->
<script>
// ── Mobile sidebar ──────────────────────────
function openSidebar() {
  document.getElementById('mobile-sidebar').classList.add('open');
  document.getElementById('sidebar-overlay').classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeSidebar() {
  document.getElementById('mobile-sidebar').classList.remove('open');
  document.getElementById('sidebar-overlay').classList.remove('open');
  document.body.style.overflow = '';
}

// ── Image preview ────────────────────────────
function previewImage(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => {
      document.getElementById('image-preview').src = e.target.result;
      document.getElementById('image-preview-wrap').classList.remove('hidden');
    };
    reader.readAsDataURL(input.files[0]);
  }
}

// ── Upload form ──────────────────────────────
let artworkCounter = 1000;

function handleUpload(e) {
  e.preventDefault();
  const title   = document.getElementById('f-title').value.trim();
  const price   = parseFloat(document.getElementById('f-price').value);
  const type    = document.getElementById('f-type').value;
  const desc    = document.getElementById('f-desc').value.trim();
  const preview = document.getElementById('image-preview').src;

  if (!title || !price || !type) return;

  const btn = document.getElementById('submit-btn');
  btn.disabled = true;
  btn.innerHTML = '<span class="w-4 h-4 border-2 border-white border-t-transparent rounded-full spinner inline-block"></span> Listing...';

  setTimeout(() => {
    artworkCounter++;
    const imgSrc = preview && !preview.endsWith('undefined') ? preview
      : 'https://images.unsplash.com/photo-1578301978018-3005759f48f7?w=400&q=80';

    const today = new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });

    const card = buildCard({
      id: artworkCounter,
      title, price, type, desc,
      imgSrc, date: today,
    });

    const grid = document.getElementById('portfolio-grid');
    grid.insertAdjacentHTML('afterbegin', card);
    document.getElementById('empty-state').classList.add('hidden');
    grid.classList.remove('hidden');

    // Update stats
    const totalEl  = document.getElementById('stat-total');
    const activeEl = document.getElementById('stat-active');
    totalEl.textContent  = parseInt(totalEl.textContent)  + 1;
    activeEl.textContent = parseInt(activeEl.textContent) + 1;
    updatePortfolioCount();

    // Reset form
    document.getElementById('upload-form').reset();
    document.getElementById('image-preview-wrap').classList.add('hidden');
    document.getElementById('image-preview').src = '';
    btn.disabled = false;
    btn.innerHTML = '+ List Artwork';

    // Toast
    const toast = document.getElementById('success-toast');
    toast.classList.remove('hidden');
    toast.style.opacity = '1';
    setTimeout(() => {
      toast.style.opacity = '0';
      setTimeout(() => toast.classList.add('hidden'), 400);
    }, 3000);

    // Reapply current filter
    filterPortfolio(currentFilter);
  }, 600);
}

function buildCard({ id, title, price, type, desc, imgSrc, date }) {
  const priceFormatted = '$' + Number(price).toLocaleString();
  return `
  <div class="artwork-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow" data-status="available">
    <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
      <img src="${imgSrc}" alt="${escHtml(title)}" class="card-img w-full h-full object-cover"
           onerror="this.src='https://images.unsplash.com/photo-1578301978018-3005759f48f7?w=400&q=80'" />
      <span class="absolute top-3 right-3 text-xs font-semibold px-2.5 py-1 rounded-full capitalize bg-emerald-100 text-emerald-700">available</span>
      ${type ? `<span class="absolute top-3 left-3 text-xs font-medium px-2.5 py-1 rounded-full bg-white/80 backdrop-blur text-gray-700 capitalize">${escHtml(type)}</span>` : ''}
    </div>
    <div class="p-4">
      <h3 class="font-semibold text-gray-900 truncate">${escHtml(title)}</h3>
      ${desc ? `<p class="text-sm text-gray-500 mt-1 line-clamp-2">${escHtml(desc)}</p>` : ''}
      <div class="flex items-center justify-between mt-3">
        <span class="text-violet-600 font-bold text-lg">${priceFormatted}</span>
        <span class="text-xs text-gray-400">${date}</span>
      </div>
      <div class="flex gap-2 mt-3">
        <button class="flex-1 py-1.5 text-xs font-medium rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 transition">Edit</button>
        <button class="flex-1 py-1.5 text-xs font-medium rounded-lg border border-violet-200 text-violet-600 hover:bg-violet-50 transition">Mark Sold</button>
      </div>
    </div>
  </div>`;
}

function escHtml(str) {
  return String(str)
    .replace(/&/g,'&amp;').replace(/</g,'&lt;')
    .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// ── Portfolio filter ─────────────────────────
let currentFilter = 'all';

function filterPortfolio(tab) {
  currentFilter = tab;

  // Update tab styles
  document.querySelectorAll('.tab-btn').forEach(btn => {
    const active = btn.dataset.tab === tab;
    btn.className = 'tab-btn px-3 py-1.5 rounded-lg text-xs font-semibold capitalize transition '
      + (active ? 'bg-white text-violet-700 shadow-sm' : 'text-gray-500 hover:text-gray-700');
  });

  const cards = document.querySelectorAll('#portfolio-grid .artwork-card');
  let visible = 0;
  cards.forEach(card => {
    const show = tab === 'all' || card.dataset.status === tab;
    card.style.display = show ? '' : 'none';
    if (show) visible++;
  });

  document.getElementById('empty-state').classList.toggle('hidden', visible > 0);
  document.getElementById('portfolio-grid').classList.toggle('hidden', visible === 0);
  updatePortfolioCount();
}

function updatePortfolioCount() {
  const cards = document.querySelectorAll('#portfolio-grid .artwork-card');
  let count = 0;
  cards.forEach(c => { if (c.style.display !== 'none') count++; });
  document.getElementById('portfolio-count').textContent = `(${count})`;
}
</script>

</body>
</html>
