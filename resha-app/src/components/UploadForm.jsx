import { useState } from 'react';

const ART_TYPES = ['Abstract', 'Portrait', 'Digital', 'Landscape', 'Still Life', 'Calligraphy', 'Sculpture', 'Photography'];

const INITIAL = { title: '', description: '', price: '', art_type: '', image_url: '' };

export default function UploadForm({ onAdd }) {
  const [form, setForm] = useState(INITIAL);
  const [preview, setPreview] = useState(null);
  const [submitting, setSubmitting] = useState(false);
  const [success, setSuccess] = useState(false);

  function handleChange(e) {
    const { name, value } = e.target;
    setForm(f => ({ ...f, [name]: value }));
  }

  function handleImageChange(e) {
    const file = e.target.files[0];
    if (!file) return;
    const url = URL.createObjectURL(file);
    setPreview(url);
    setForm(f => ({ ...f, image_url: url }));
  }

  function handleSubmit(e) {
    e.preventDefault();
    setSubmitting(true);
    setTimeout(() => {
      onAdd({ ...form, id: Date.now(), status: 'available', created_at: new Date().toISOString() });
      setForm(INITIAL);
      setPreview(null);
      setSubmitting(false);
      setSuccess(true);
      setTimeout(() => setSuccess(false), 3000);
    }, 600);
  }

  const isValid = form.title && form.price && form.art_type;

  return (
    <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
      <h2 className="text-xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
        <span className="text-2xl">🖼️</span> List a New Artwork
      </h2>

      {success && (
        <div className="mb-5 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
          ✅ Artwork listed successfully!
        </div>
      )}

      <form onSubmit={handleSubmit} className="space-y-5">
        <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
          {/* Title */}
          <div className="md:col-span-2">
            <label className="block text-sm font-medium text-gray-700 mb-1.5">Title <span className="text-rose-500">*</span></label>
            <input
              name="title"
              value={form.title}
              onChange={handleChange}
              placeholder="e.g., Golden Horizon"
              className="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-violet-400 focus:border-transparent transition"
              required
            />
          </div>

          {/* Price */}
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-1.5">Price (USD) <span className="text-rose-500">*</span></label>
            <div className="relative">
              <span className="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 font-medium">$</span>
              <input
                type="number"
                name="price"
                value={form.price}
                onChange={handleChange}
                placeholder="0.00"
                min="0"
                step="0.01"
                className="w-full pl-8 pr-4 py-2.5 rounded-xl border border-gray-200 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-violet-400 focus:border-transparent transition"
                required
              />
            </div>
          </div>

          {/* Art Type */}
          <div>
            <label className="block text-sm font-medium text-gray-700 mb-1.5">Art Type <span className="text-rose-500">*</span></label>
            <select
              name="art_type"
              value={form.art_type}
              onChange={handleChange}
              className="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-gray-900 focus:outline-none focus:ring-2 focus:ring-violet-400 focus:border-transparent transition bg-white"
              required
            >
              <option value="" disabled>Select a type...</option>
              {ART_TYPES.map(t => <option key={t} value={t.toLowerCase()}>{t}</option>)}
            </select>
          </div>

          {/* Description */}
          <div className="md:col-span-2">
            <label className="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
            <textarea
              name="description"
              value={form.description}
              onChange={handleChange}
              rows={3}
              placeholder="Tell buyers about this piece — materials, inspiration, dimensions..."
              className="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-violet-400 focus:border-transparent transition resize-none"
            />
          </div>

          {/* Image Upload */}
          <div className="md:col-span-2">
            <label className="block text-sm font-medium text-gray-700 mb-1.5">Artwork Image</label>
            <div className="flex items-start gap-4">
              <label className="flex-1 flex flex-col items-center justify-center gap-2 border-2 border-dashed border-gray-200 rounded-xl py-8 cursor-pointer hover:border-violet-400 hover:bg-violet-50 transition group">
                <span className="text-3xl">📁</span>
                <span className="text-sm text-gray-500 group-hover:text-violet-600 transition">Click to upload image</span>
                <span className="text-xs text-gray-400">PNG, JPG, WEBP up to 10MB</span>
                <input type="file" accept="image/*" className="hidden" onChange={handleImageChange} />
              </label>
              {preview && (
                <div className="w-32 h-32 rounded-xl overflow-hidden border border-gray-200 flex-shrink-0">
                  <img src={preview} alt="Preview" className="w-full h-full object-cover" />
                </div>
              )}
            </div>
          </div>
        </div>

        <button
          type="submit"
          disabled={!isValid || submitting}
          className="w-full py-3 rounded-xl bg-violet-600 text-white font-semibold text-sm hover:bg-violet-700 active:scale-95 transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
        >
          {submitting ? (
            <><span className="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin" /> Listing...</>
          ) : (
            '+ List Artwork'
          )}
        </button>
      </form>
    </div>
  );
}
