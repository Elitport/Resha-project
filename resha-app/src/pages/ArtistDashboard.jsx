import { useState } from 'react';
import Sidebar from '../components/Sidebar';
import StatCard from '../components/StatCard';
import UploadForm from '../components/UploadForm';
import ArtworkCard from '../components/ArtworkCard';

const SAMPLE_ARTWORKS = [
  {
    id: 1,
    title: 'Desert Whispers',
    description: 'Acrylic on canvas. A journey through the golden dunes of the Empty Quarter.',
    price: 1200,
    art_type: 'abstract',
    status: 'available',
    image_url: 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?w=400&q=80',
    created_at: '2026-05-10T10:00:00Z',
  },
  {
    id: 2,
    title: 'Blue Serenity',
    description: 'Watercolor, inspired by the Arabian Gulf at dawn.',
    price: 850,
    art_type: 'landscape',
    status: 'sold',
    image_url: 'https://images.unsplash.com/photo-1547891654-e66ed7ebb968?w=400&q=80',
    created_at: '2026-04-22T08:30:00Z',
  },
  {
    id: 3,
    title: 'Silent Portrait',
    description: 'Oil on linen. A study of light and shadow in the modern Arab face.',
    price: 2400,
    art_type: 'portrait',
    status: 'auction',
    image_url: 'https://images.unsplash.com/photo-1578301978069-55e07489cfe1?w=400&q=80',
    created_at: '2026-06-01T14:00:00Z',
  },
  {
    id: 4,
    title: 'Neon Medina',
    description: 'Digital art fusing traditional Arabesque patterns with cyberpunk aesthetics.',
    price: 600,
    art_type: 'digital',
    status: 'available',
    image_url: 'https://images.unsplash.com/photo-1637858868799-7f26a0640eb6?w=400&q=80',
    created_at: '2026-06-15T09:00:00Z',
  },
];

export default function ArtistDashboard() {
  const [artworks, setArtworks] = useState(SAMPLE_ARTWORKS);
  const [activeTab, setActiveTab] = useState('all');

  const activeListings = artworks.filter(a => a.status === 'available' || a.status === 'auction').length;
  const soldCount = artworks.filter(a => a.status === 'sold').length;
  const totalSales = artworks.filter(a => a.status === 'sold').reduce((s, a) => s + Number(a.price), 0);
  const auctionCount = artworks.filter(a => a.status === 'auction').length;

  function handleAdd(artwork) {
    setArtworks(prev => [artwork, ...prev]);
  }

  const filtered = activeTab === 'all' ? artworks : artworks.filter(a => a.status === activeTab);

  return (
    <div className="flex min-h-screen bg-gray-50">
      <Sidebar />

      <main className="flex-1 p-6 md:p-10 space-y-10 overflow-auto">
        {/* Header */}
        <div className="flex items-start justify-between">
          <div>
            <h1 className="text-2xl font-bold text-gray-900">Artist Dashboard</h1>
            <p className="text-gray-500 text-sm mt-1">Welcome back, Layla — here's how your studio is doing.</p>
          </div>
          <div className="text-sm text-gray-400 hidden sm:block">{new Date().toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' })}</div>
        </div>

        {/* Stats */}
        <section>
          <h2 className="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Summary</h2>
          <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <StatCard icon="🖼️" label="Active Listings" value={activeListings} sub="Available + Auction" color="bg-violet-100" />
            <StatCard icon="💰" label="Total Sales" value={`$${totalSales.toLocaleString()}`} sub={`${soldCount} artwork${soldCount !== 1 ? 's' : ''} sold`} color="bg-emerald-100" />
            <StatCard icon="🔨" label="Live Auctions" value={auctionCount} sub="Currently bidding" color="bg-amber-100" />
            <StatCard icon="📦" label="Total Artworks" value={artworks.length} sub="In your portfolio" color="bg-sky-100" />
          </div>
        </section>

        {/* Upload Form */}
        <section>
          <UploadForm onAdd={handleAdd} />
        </section>

        {/* Portfolio Grid */}
        <section>
          <div className="flex items-center justify-between mb-5">
            <h2 className="text-xl font-semibold text-gray-900 flex items-center gap-2">
              🎨 My Portfolio
              <span className="text-sm font-normal text-gray-400">({filtered.length})</span>
            </h2>

            {/* Filter Tabs */}
            <div className="flex items-center gap-1 bg-gray-100 rounded-xl p-1">
              {['all', 'available', 'auction', 'sold'].map(tab => (
                <button
                  key={tab}
                  onClick={() => setActiveTab(tab)}
                  className={`px-3 py-1.5 rounded-lg text-xs font-semibold capitalize transition
                    ${activeTab === tab
                      ? 'bg-white text-violet-700 shadow-sm'
                      : 'text-gray-500 hover:text-gray-700'}`}
                >
                  {tab}
                </button>
              ))}
            </div>
          </div>

          {filtered.length === 0 ? (
            <div className="text-center py-20 bg-white rounded-2xl border border-dashed border-gray-200">
              <p className="text-4xl mb-3">🖼️</p>
              <p className="text-gray-500 text-sm">No artworks in this category yet.</p>
            </div>
          ) : (
            <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-5">
              {filtered.map(artwork => (
                <ArtworkCard key={artwork.id} artwork={artwork} />
              ))}
            </div>
          )}
        </section>
      </main>
    </div>
  );
}
