const NAV = [
  { icon: '📊', label: 'Dashboard', active: true },
  { icon: '🖼️', label: 'My Portfolio' },
  { icon: '➕', label: 'List Artwork' },
  { icon: '🏷️', label: 'Auctions' },
  { icon: '💬', label: 'Messages' },
  { icon: '💰', label: 'Earnings' },
  { icon: '⚙️', label: 'Settings' },
];

export default function Sidebar() {
  return (
    <aside className="hidden md:flex flex-col w-60 min-h-screen bg-white border-r border-gray-100 px-4 py-8 sticky top-0">
      {/* Brand */}
      <div className="flex items-center gap-2 px-2 mb-10">
        <div className="w-9 h-9 rounded-xl bg-violet-600 flex items-center justify-center text-white font-bold text-lg">R</div>
        <div>
          <p className="font-bold text-gray-900 leading-tight">Resha Art</p>
          <p className="text-xs text-gray-400">Artist Studio</p>
        </div>
      </div>

      {/* Nav */}
      <nav className="flex-1 space-y-1">
        {NAV.map(({ icon, label, active }) => (
          <button
            key={label}
            className={`w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
              ${active
                ? 'bg-violet-50 text-violet-700'
                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'}`}
          >
            <span className="text-base">{icon}</span>
            {label}
          </button>
        ))}
      </nav>

      {/* Artist Profile Footer */}
      <div className="mt-6 pt-6 border-t border-gray-100 px-2 flex items-center gap-3">
        <div className="w-9 h-9 rounded-full bg-gradient-to-br from-violet-400 to-fuchsia-500 flex items-center justify-center text-white font-semibold text-sm">
          لي
        </div>
        <div className="flex-1 min-w-0">
          <p className="text-sm font-medium text-gray-900 truncate">Layla Ibrahim</p>
          <p className="text-xs text-gray-400 truncate">Artist · Riyadh</p>
        </div>
      </div>
    </aside>
  );
}
