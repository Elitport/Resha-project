<?php
// marketplace.php — Resha Art · Buyer Marketplace
// Drop into your Hostinger public_html folder. No build step needed.

$artworks = [
  [
    "id"          => 1,
    "title"       => "Desert Whispers",
    "artist"      => "Layla Ibrahim",
    "location"    => "Riyadh, SA",
    "price"       => 1200,
    "art_type"    => "abstract",
    "status"      => "available",
    "image_url"   => "https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?w=600&q=80",
    "description" => "Acrylic on canvas. A journey through the golden dunes of the Empty Quarter.",
    "badge"       => "New",
  ],
  [
    "id"          => 2,
    "title"       => "Blue Serenity",
    "artist"      => "Omar Al-Rashid",
    "location"    => "Dubai, UAE",
    "price"       => 850,
    "art_type"    => "landscape",
    "status"      => "available",
    "image_url"   => "https://images.unsplash.com/photo-1547891654-e66ed7ebb968?w=600&q=80",
    "description" => "Watercolor inspired by the Arabian Gulf at dawn.",
    "badge"       => "",
  ],
  [
    "id"          => 3,
    "title"       => "Silent Portrait",
    "artist"      => "Nour Khalil",
    "location"    => "Cairo, EG",
    "price"       => 2400,
    "art_type"    => "portrait",
    "status"      => "auction",
    "image_url"   => "https://images.unsplash.com/photo-1578301978069-55e07489cfe1?w=600&q=80",
    "description" => "Oil on linen. A study of light and shadow in the modern Arab face.",
    "badge"       => "Auction",
  ],
  [
    "id"          => 4,
    "title"       => "Neon Medina",
    "artist"      => "Sara Al-Dosari",
    "location"    => "Doha, QA",
    "price"       => 600,
    "art_type"    => "digital",
    "status"      => "available",
    "image_url"   => "https://images.unsplash.com/photo-1637858868799-7f26a0640eb6?w=600&q=80",
    "description" => "Digital art fusing Arabesque patterns with cyberpunk aesthetics.",
    "badge"       => "New",
  ],
  [
    "id"          => 5,
    "title"       => "Golden Hour",
    "artist"      => "Yusuf Al-Amin",
    "location"    => "Amman, JO",
    "price"       => 1750,
    "art_type"    => "landscape",
    "status"      => "available",
    "image_url"   => "https://images.unsplash.com/photo-1501854140801-50d01698950b?w=600&q=80",
    "description" => "Oil painting capturing the warm light of a Jordanian sunset.",
    "badge"       => "",
  ],
  [
    "id"          => 6,
    "title"       => "Fractured Mind",
    "artist"      => "Layla Ibrahim",
    "location"    => "Riyadh, SA",
    "price"       => 980,
    "art_type"    => "abstract",
    "status"      => "available",
    "image_url"   => "https://images.unsplash.com/photo-1541512416146-3cf58d6b27cc?w=600&q=80",
    "description" => "Mixed media on board exploring identity and duality.",
    "badge"       => "",
  ],
  [
    "id"          => 7,
    "title"       => "The Elder",
    "artist"      => "Fatima Al-Zahra",
    "location"    => "Marrakech, MA",
    "price"       => 3200,
    "art_type"    => "portrait",
    "status"      => "available",
    "image_url"   => "https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=600&q=80",
    "description" => "Hyperrealist charcoal portrait of a Moroccan elder.",
    "badge"       => "Featured",
  ],
  [
    "id"          => 8,
    "title"       => "Cyber Souk",
    "artist"      => "Khalid Nasser",
    "location"    => "Beirut, LB",
    "price"       => 450,
    "art_type"    => "digital",
    "status"      => "available",
    "image_url"   => "https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80",
    "description" => "A digital reimagining of a traditional Middle Eastern market.",
    "badge"       => "",
  ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Marketplace — Resha Art</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            violet: { 50:'#f5f3ff',100:'#ede9fe',200:'#ddd6fe',400:'#a78bfa',600:'#7c3aed',700:'#6d28d9' }
          },
          fontFamily: { sans: ['Inter','system-ui','sans-serif'] }
        }
      }
    }
  </script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    body { font-family: 'Inter', system-ui, sans-serif; }
    .line-clamp-2 { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    .card-img { transition: transform 0.6s cubic-bezier(.25,.46,.45,.94); }
    .art-card:hover .card-img { transform: scale(1.07); }
    .art-card { transition: box-shadow .25s, transform .25s; }
    .art-card:hover { transform: translateY(-3px); box-shadow: 0 20px 40px -8px rgba(0,0,0,.13); }
    /* Hero gradient */
    .hero-gradient {
      background: linear-gradient(135deg, #1e1b4b 0%, #4c1d95 40%, #7c3aed 70%, #a855f7 100%);
    }
    /* Floating badge */
    .badge-new      { background:#dbeafe; color:#1d4ed8; }
    .badge-auction  { background:#fef3c7; color:#b45309; }
    .badge-featured { background:#fce7f3; color:#be185d; }
    /* Nav scroll */
    .navbar { backdrop-filter: blur(12px); background: rgba(255,255,255,0.85); }
    /* Search focus ring */
    #search-input:focus { outline: none; box-shadow: 0 0 0 3px rgba(124,58,237,.25); }
    /* Filter tab active */
    .filter-tab.active { background:#7c3aed; color:#fff; box-shadow: 0 4px 12px rgba(124,58,237,.35); }
    /* Detail modal */
    #detail-modal { display:none; }
    #detail-modal.open { display:flex; }
    #modal-overlay { backdrop-filter: blur(4px); }
    /* Animate cards in */
    @keyframes fadeUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
    .art-card { animation: fadeUp .4s ease both; }
    /* Stagger */
    .art-card:nth-child(1){animation-delay:.05s}
    .art-card:nth-child(2){animation-delay:.10s}
    .art-card:nth-child(3){animation-delay:.15s}
    .art-card:nth-child(4){animation-delay:.20s}
    .art-card:nth-child(5){animation-delay:.25s}
    .art-card:nth-child(6){animation-delay:.30s}
    .art-card:nth-child(7){animation-delay:.35s}
    .art-card:nth-child(8){animation-delay:.40s}
  </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

<!-- ══════════════════════════════════════════
     NAVBAR
══════════════════════════════════════════ -->
<header class="navbar sticky top-0 z-50 border-b border-white/60 shadow-sm">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">

    <!-- Brand -->
    <a href="#" class="flex items-center gap-2.5 no-underline">
      <div class="w-9 h-9 rounded-xl bg-violet-600 flex items-center justify-center text-white font-bold text-lg shadow-sm">R</div>
      <span class="font-extrabold text-gray-900 text-lg tracking-tight">Resha Art</span>
    </a>

    <!-- Desktop Nav -->
    <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-600">
      <a href="#" class="hover:text-violet-600 transition">Home</a>
      <a href="#" class="text-violet-600 font-semibold">Marketplace</a>
      <a href="#" class="hover:text-violet-600 transition">Auctions</a>
      <a href="#" class="hover:text-violet-600 transition">Artists</a>
      <a href="#" class="hover:text-violet-600 transition">About</a>
    </nav>

    <!-- CTA -->
    <div class="flex items-center gap-3">
      <a href="artist_dashboard.php"
         class="hidden sm:inline-flex items-center gap-1.5 text-sm font-semibold text-violet-600 hover:text-violet-700 transition">
        Artist Login
      </a>
      <button class="px-4 py-2 rounded-xl bg-violet-600 text-white text-sm font-semibold hover:bg-violet-700 transition shadow-sm">
        Sign Up
      </button>
    </div>
  </div>
</header>


<!-- ══════════════════════════════════════════
     HERO
══════════════════════════════════════════ -->
<section class="hero-gradient relative overflow-hidden">
  <!-- Decorative circles -->
  <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-white/5 pointer-events-none"></div>
  <div class="absolute top-10 -left-16 w-64 h-64 rounded-full bg-white/5 pointer-events-none"></div>
  <div class="absolute bottom-0 right-1/3 w-48 h-48 rounded-full bg-fuchsia-500/20 pointer-events-none"></div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28 relative z-10">
    <div class="max-w-2xl">
      <!-- Tag -->
      <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/15 text-white/90 text-xs font-semibold tracking-wide uppercase mb-5 border border-white/20">
        🎨 Discover Exceptional Art
      </span>
      <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight tracking-tight mb-5">
        Where Art Finds<br />Its True Home
      </h1>
      <p class="text-white/75 text-lg md:text-xl leading-relaxed mb-8 max-w-xl">
        Explore original paintings, portraits, digital art, and more — directly from talented artists across the Arab world.
      </p>
      <div class="flex flex-wrap gap-3">
        <a href="#browse"
           class="px-6 py-3 rounded-xl bg-white text-violet-700 font-bold text-sm hover:bg-violet-50 transition shadow-lg">
          Browse Artworks
        </a>
        <a href="#"
           class="px-6 py-3 rounded-xl bg-white/15 text-white font-semibold text-sm border border-white/30 hover:bg-white/25 transition">
          Meet the Artists →
        </a>
      </div>
    </div>
  </div>

  <!-- Stats bar -->
  <div class="bg-black/20 border-t border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
      <div class="flex flex-wrap gap-6 md:gap-12">
        <?php foreach ([['500+','Original artworks'],['120+','Verified artists'],['40+','Countries reached'],['$2M+','In artist sales']] as [$num,$label]): ?>
        <div class="flex items-baseline gap-2">
          <span class="text-white font-extrabold text-xl"><?= $num ?></span>
          <span class="text-white/60 text-sm"><?= $label ?></span>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>


<!-- ══════════════════════════════════════════
     BROWSE SECTION
══════════════════════════════════════════ -->
<section id="browse" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">

  <!-- Section header -->
  <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
    <div>
      <p class="text-xs font-semibold text-violet-600 uppercase tracking-widest mb-1">Explore</p>
      <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900">Browse the Collection</h2>
    </div>
    <p class="text-sm text-gray-500" id="results-count"><?= count($artworks) ?> artworks</p>
  </div>

  <!-- Search + Filters -->
  <div class="flex flex-col md:flex-row gap-4 mb-8">

    <!-- Search -->
    <div class="relative flex-1">
      <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
      </svg>
      <input id="search-input" type="text" placeholder="Search by title or artist…"
        oninput="applyFilters()"
        class="w-full pl-10 pr-4 py-3 rounded-2xl border border-gray-200 bg-white text-sm text-gray-900 placeholder-gray-400 transition shadow-sm" />
    </div>

    <!-- Sort -->
    <select id="sort-select" onchange="applyFilters()"
      class="px-4 py-3 rounded-2xl border border-gray-200 bg-white text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-violet-400 shadow-sm cursor-pointer min-w-[160px]">
      <option value="default">Sort: Featured</option>
      <option value="price-asc">Price: Low → High</option>
      <option value="price-desc">Price: High → Low</option>
      <option value="title">Title A–Z</option>
    </select>
  </div>

  <!-- Filter Tabs -->
  <div class="flex flex-wrap gap-2 mb-10">
    <?php
    $types = [
      ['all',       'All',       '🖼️'],
      ['abstract',  'Abstract',  '🎨'],
      ['portrait',  'Portrait',  '👤'],
      ['landscape', 'Landscape', '🏔️'],
      ['digital',   'Digital',   '💻'],
    ];
    foreach ($types as [$val, $label, $icon]):
      $active = $val === 'all' ? 'active' : '';
    ?>
    <button
      onclick="setFilter('<?= $val ?>')"
      data-filter="<?= $val ?>"
      class="filter-tab <?= $active ?> flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold border border-gray-200 bg-white text-gray-600 hover:border-violet-300 hover:text-violet-700 transition cursor-pointer">
      <span><?= $icon ?></span> <?= $label ?>
    </button>
    <?php endforeach; ?>
  </div>

  <!-- Artwork Grid -->
  <div id="artwork-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

    <?php foreach ($artworks as $aw):
      $badge_cls = match(strtolower($aw['badge'])) {
        'new'      => 'badge-new',
        'auction'  => 'badge-auction',
        'featured' => 'badge-featured',
        default    => '',
      };
      $status_dot = $aw['status'] === 'auction'
        ? '<span class="w-1.5 h-1.5 rounded-full bg-amber-500 inline-block mr-1"></span>'
        : '<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block mr-1"></span>';
    ?>
    <div class="art-card group bg-white rounded-2xl border border-gray-100 overflow-hidden cursor-pointer"
         data-type="<?= htmlspecialchars($aw['art_type']) ?>"
         data-title="<?= htmlspecialchars(strtolower($aw['title'])) ?>"
         data-artist="<?= htmlspecialchars(strtolower($aw['artist'])) ?>"
         data-price="<?= $aw['price'] ?>"
         onclick="openModal(<?= $aw['id'] ?>)">

      <!-- Image -->
      <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
        <img src="<?= htmlspecialchars($aw['image_url']) ?>"
             alt="<?= htmlspecialchars($aw['title']) ?>"
             class="card-img w-full h-full object-cover"
             onerror="this.src='https://images.unsplash.com/photo-1578301978018-3005759f48f7?w=600&q=80'" />

        <!-- Overlay on hover -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
          <span class="text-white text-xs font-semibold bg-white/20 backdrop-blur px-3 py-1.5 rounded-full border border-white/30">
            View Details →
          </span>
        </div>

        <!-- Badge -->
        <?php if ($aw['badge']): ?>
        <span class="absolute top-3 left-3 text-xs font-bold px-2.5 py-1 rounded-full <?= $badge_cls ?>">
          <?= htmlspecialchars($aw['badge']) ?>
        </span>
        <?php endif; ?>

        <!-- Wishlist -->
        <button onclick="event.stopPropagation(); toggleWishlist(this)"
          class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/80 backdrop-blur flex items-center justify-center text-gray-400 hover:text-rose-500 transition shadow-sm wishlist-btn">
          ♡
        </button>
      </div>

      <!-- Card body -->
      <div class="p-4">
        <!-- Art type pill -->
        <span class="text-xs font-medium text-violet-600 bg-violet-50 px-2 py-0.5 rounded-full capitalize">
          <?= htmlspecialchars($aw['art_type']) ?>
        </span>

        <h3 class="font-bold text-gray-900 mt-2 truncate text-[15px]">
          <?= htmlspecialchars($aw['title']) ?>
        </h3>

        <div class="flex items-center gap-1.5 mt-1">
          <div class="w-5 h-5 rounded-full bg-gradient-to-br from-violet-400 to-fuchsia-500 flex items-center justify-center text-white text-[9px] font-bold flex-shrink-0">
            <?= mb_strtoupper(mb_substr($aw['artist'], 0, 1)) ?>
          </div>
          <span class="text-sm text-gray-500 truncate"><?= htmlspecialchars($aw['artist']) ?></span>
          <span class="text-gray-300 text-xs">·</span>
          <span class="text-xs text-gray-400"><?= htmlspecialchars($aw['location']) ?></span>
        </div>

        <div class="flex items-center justify-between mt-4">
          <div>
            <p class="text-xs text-gray-400 flex items-center">
              <?= $status_dot ?>
              <?= $aw['status'] === 'auction' ? 'Live auction' : 'For sale' ?>
            </p>
            <p class="text-xl font-extrabold text-gray-900 leading-tight">
              $<?= number_format($aw['price']) ?>
            </p>
          </div>
          <button onclick="event.stopPropagation(); openModal(<?= $aw['id'] ?>)"
            class="px-4 py-2 rounded-xl bg-violet-600 text-white text-xs font-semibold hover:bg-violet-700 transition shadow-sm active:scale-95">
            View Details
          </button>
        </div>
      </div>

    </div>
    <?php endforeach; ?>

  </div><!-- /grid -->

  <!-- Empty state -->
  <div id="empty-state" class="hidden text-center py-24">
    <p class="text-5xl mb-4">🔍</p>
    <p class="text-gray-700 font-semibold text-lg">No artworks found</p>
    <p class="text-gray-400 text-sm mt-1">Try a different search term or filter.</p>
    <button onclick="resetFilters()" class="mt-5 px-5 py-2.5 rounded-xl bg-violet-600 text-white text-sm font-semibold hover:bg-violet-700 transition">
      Clear Filters
    </button>
  </div>

</section>


<!-- ══════════════════════════════════════════
     BANNER — Become an Artist
══════════════════════════════════════════ -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
  <div class="rounded-3xl hero-gradient p-10 md:p-14 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden">
    <div class="absolute -top-10 -right-10 w-64 h-64 rounded-full bg-white/5 pointer-events-none"></div>
    <div class="relative z-10">
      <h2 class="text-2xl md:text-3xl font-extrabold text-white mb-3">Are you an artist?</h2>
      <p class="text-white/70 max-w-md text-sm md:text-base">
        Join hundreds of artists already selling on Resha Art. Upload your work, set your price, and reach collectors across the world.
      </p>
    </div>
    <div class="flex gap-3 flex-shrink-0 relative z-10">
      <a href="artist_dashboard.php"
         class="px-6 py-3 rounded-xl bg-white text-violet-700 font-bold text-sm hover:bg-violet-50 transition shadow-lg">
        Open Your Studio →
      </a>
    </div>
  </div>
</section>


<!-- ══════════════════════════════════════════
     DETAIL MODAL
══════════════════════════════════════════ -->
<div id="detail-modal" class="fixed inset-0 z-50 items-center justify-center p-4">
  <div id="modal-overlay" class="absolute inset-0 bg-black/60" onclick="closeModal()"></div>
  <div class="relative bg-white rounded-3xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto z-10">

    <!-- Close -->
    <button onclick="closeModal()"
      class="absolute top-4 right-4 w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200 transition z-20 text-lg font-bold">
      &times;
    </button>

    <!-- Content filled by JS -->
    <div id="modal-content"></div>

  </div>
</div>


<!-- ══════════════════════════════════════════
     FOOTER
══════════════════════════════════════════ -->
<footer class="bg-gray-900 text-white mt-4">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 md:grid-cols-3 gap-8">
    <div>
      <div class="flex items-center gap-2 mb-4">
        <div class="w-9 h-9 rounded-xl bg-violet-600 flex items-center justify-center font-bold text-lg">R</div>
        <span class="font-extrabold text-lg">Resha Art</span>
      </div>
      <p class="text-gray-400 text-sm leading-relaxed">A marketplace celebrating original art from artists across the Arab world and beyond.</p>
    </div>
    <div>
      <p class="font-semibold text-sm uppercase tracking-widest text-gray-500 mb-4">Explore</p>
      <ul class="space-y-2 text-sm text-gray-400">
        <li><a href="#" class="hover:text-white transition">All Artworks</a></li>
        <li><a href="#" class="hover:text-white transition">Auctions</a></li>
        <li><a href="#" class="hover:text-white transition">Featured Artists</a></li>
        <li><a href="#" class="hover:text-white transition">Commissions</a></li>
      </ul>
    </div>
    <div>
      <p class="font-semibold text-sm uppercase tracking-widest text-gray-500 mb-4">Contact</p>
      <ul class="space-y-2 text-sm text-gray-400">
        <li>✉️ hello@reshaart.com</li>
        <li>🐦 @ReshaArt</li>
        <li>📸 @resha.art</li>
      </ul>
    </div>
  </div>
  <div class="border-t border-gray-800 py-4 text-center text-xs text-gray-600">
    © <?= date('Y') ?> Resha Art. All rights reserved.
  </div>
</footer>


<!-- ══════════════════════════════════════════
     JAVASCRIPT
══════════════════════════════════════════ -->
<script>
// ── Artwork data (mirrors PHP) ───────────────
const ARTWORKS = <?= json_encode(array_values($artworks)) ?>;

// ── State ────────────────────────────────────
let currentFilter = 'all';
let currentSearch = '';
let currentSort   = 'default';

// ── Filter tabs ──────────────────────────────
function setFilter(type) {
  currentFilter = type;
  document.querySelectorAll('.filter-tab').forEach(btn => {
    btn.classList.toggle('active', btn.dataset.filter === type);
  });
  applyFilters();
}

function applyFilters() {
  currentSearch = document.getElementById('search-input').value.toLowerCase().trim();
  currentSort   = document.getElementById('sort-select').value;

  const cards = Array.from(document.querySelectorAll('#artwork-grid .art-card'));

  // Gather matching cards
  let matched = cards.filter(card => {
    const typeOk   = currentFilter === 'all' || card.dataset.type === currentFilter;
    const searchOk = !currentSearch ||
      card.dataset.title.includes(currentSearch) ||
      card.dataset.artist.includes(currentSearch);
    return typeOk && searchOk;
  });

  // Sort matched
  matched.sort((a, b) => {
    if (currentSort === 'price-asc')  return +a.dataset.price - +b.dataset.price;
    if (currentSort === 'price-desc') return +b.dataset.price - +a.dataset.price;
    if (currentSort === 'title')      return a.dataset.title.localeCompare(b.dataset.title);
    return 0;
  });

  // Hide all, then show matched in sorted order
  cards.forEach(c => c.style.display = 'none');
  const grid = document.getElementById('artwork-grid');
  matched.forEach(c => {
    c.style.display = '';
    grid.appendChild(c); // re-order in DOM
  });

  // Empty state
  const empty = document.getElementById('empty-state');
  empty.classList.toggle('hidden', matched.length > 0);

  // Count
  document.getElementById('results-count').textContent =
    matched.length + (matched.length === 1 ? ' artwork' : ' artworks');
}

function resetFilters() {
  setFilter('all');
  document.getElementById('search-input').value = '';
  document.getElementById('sort-select').value = 'default';
  currentSearch = '';
  currentSort = 'default';
  applyFilters();
}

// ── Wishlist toggle ──────────────────────────
function toggleWishlist(btn) {
  const active = btn.classList.toggle('active');
  btn.textContent = active ? '♥' : '♡';
  btn.classList.toggle('text-rose-500', active);
  btn.classList.toggle('text-gray-400', !active);
}

// ── Detail Modal ─────────────────────────────
function openModal(id) {
  const aw = ARTWORKS.find(a => a.id === id);
  if (!aw) return;

  const statusLabel = aw.status === 'auction' ? '🔨 Live Auction' : '✅ Available for Sale';
  const statusCls   = aw.status === 'auction'
    ? 'bg-amber-100 text-amber-700'
    : 'bg-emerald-100 text-emerald-700';

  document.getElementById('modal-content').innerHTML = `
    <div class="grid md:grid-cols-2 gap-0">
      <!-- Image -->
      <div class="aspect-square md:aspect-auto md:min-h-[360px] overflow-hidden rounded-t-3xl md:rounded-l-3xl md:rounded-tr-none bg-gray-100">
        <img src="${esc(aw.image_url)}" alt="${esc(aw.title)}"
          class="w-full h-full object-cover"
          onerror="this.src='https://images.unsplash.com/photo-1578301978018-3005759f48f7?w=600&q=80'" />
      </div>
      <!-- Info -->
      <div class="p-7 flex flex-col justify-between">
        <div>
          <span class="text-xs font-semibold text-violet-600 bg-violet-50 px-2.5 py-1 rounded-full capitalize">${esc(aw.art_type)}</span>
          <h2 class="text-2xl font-extrabold text-gray-900 mt-3 mb-1">${esc(aw.title)}</h2>
          <div class="flex items-center gap-2 mb-4">
            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-violet-400 to-fuchsia-500 flex items-center justify-center text-white text-xs font-bold">
              ${esc(aw.artist[0].toUpperCase())}
            </div>
            <div>
              <p class="text-sm font-semibold text-gray-800">${esc(aw.artist)}</p>
              <p class="text-xs text-gray-400">${esc(aw.location)}</p>
            </div>
          </div>
          <p class="text-gray-500 text-sm leading-relaxed mb-5">${esc(aw.description)}</p>
          <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full ${statusCls}">
            ${statusLabel}
          </span>
        </div>
        <div class="mt-6 pt-6 border-t border-gray-100">
          <div class="flex items-end justify-between mb-5">
            <div>
              <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Price</p>
              <p class="text-3xl font-extrabold text-gray-900">$${Number(aw.price).toLocaleString()}</p>
            </div>
          </div>
          <div class="flex gap-3">
            <button onclick="alert('🛒 Purchase flow coming soon!')"
              class="flex-1 py-3 rounded-xl bg-violet-600 text-white font-bold text-sm hover:bg-violet-700 transition active:scale-95 shadow-sm">
              ${aw.status === 'auction' ? '🔨 Place Bid' : '🛒 Buy Now'}
            </button>
            <button onclick="alert('💬 Messaging coming soon!')"
              class="px-4 py-3 rounded-xl border border-gray-200 text-gray-600 text-sm font-semibold hover:bg-gray-50 transition">
              Message Artist
            </button>
          </div>
        </div>
      </div>
    </div>`;

  document.getElementById('detail-modal').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeModal() {
  document.getElementById('detail-modal').classList.remove('open');
  document.body.style.overflow = '';
}

// Close modal on Escape key
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

function esc(str) {
  return String(str ?? '')
    .replace(/&/g,'&amp;').replace(/</g,'&lt;')
    .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
</script>

</body>
</html>
