const STATUS_STYLES = {
  available: 'bg-emerald-100 text-emerald-700',
  sold:      'bg-gray-100 text-gray-500',
  auction:   'bg-amber-100 text-amber-700',
};

const PLACEHOLDER = 'https://images.unsplash.com/photo-1578301978018-3005759f48f7?w=400&q=80';

export default function ArtworkCard({ artwork }) {
  const { title, description, price, art_type, status, image_url, created_at } = artwork;
  const date = created_at ? new Date(created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : '';

  return (
    <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-shadow">
      {/* Image */}
      <div className="relative aspect-[4/3] overflow-hidden bg-gray-100">
        <img
          src={image_url || PLACEHOLDER}
          alt={title}
          className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
          onError={e => { e.target.src = PLACEHOLDER; }}
        />
        <span className={`absolute top-3 right-3 text-xs font-semibold px-2.5 py-1 rounded-full capitalize ${STATUS_STYLES[status] || STATUS_STYLES.available}`}>
          {status}
        </span>
        {art_type && (
          <span className="absolute top-3 left-3 text-xs font-medium px-2.5 py-1 rounded-full bg-white/80 backdrop-blur text-gray-700 capitalize">
            {art_type}
          </span>
        )}
      </div>

      {/* Info */}
      <div className="p-4">
        <h3 className="font-semibold text-gray-900 truncate">{title}</h3>
        {description && (
          <p className="text-sm text-gray-500 mt-1 line-clamp-2">{description}</p>
        )}
        <div className="flex items-center justify-between mt-3">
          <span className="text-violet-600 font-bold text-lg">${Number(price).toLocaleString()}</span>
          {date && <span className="text-xs text-gray-400">{date}</span>}
        </div>
        <div className="flex gap-2 mt-3">
          <button className="flex-1 py-1.5 text-xs font-medium rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 transition">
            Edit
          </button>
          <button className="flex-1 py-1.5 text-xs font-medium rounded-lg border border-violet-200 text-violet-600 hover:bg-violet-50 transition">
            Mark Sold
          </button>
        </div>
      </div>
    </div>
  );
}
