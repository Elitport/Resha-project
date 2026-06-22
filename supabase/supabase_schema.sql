-- تفعيل إضافات قاعدة البيانات المطلوبة لحسابات المستخدمين
create extension if not exists "uuid-ossp";

-- 1. إنشاء جدول الملفات الشخصية للمستخدمين بحسب نوع الحساب
create table public.profiles (
    id uuid references auth.users on delete cascade primary key,
    full_name text not null,
    role text check (role in ('artist', 'buyer', 'institute', 'gallery', 'admin')) not null,
    bio text,
    avatar_url text,
    updated_at timestamp with time zone default timezone('utc'::text, now()) not null
);

-- 2. إنشاء جدول اللوحات والأعمال الفنية المتاحة للبيع أو المزاد
create table public.artworks (
    id bigint generated always as identity primary key,
    artist_id uuid references public.profiles(id) on delete cascade not null,
    title text not null,
    description text,
    price numeric not null check (price >= 0),
    image_url text not null,
    status text default 'available' check (status in ('available', 'sold', 'auction')) not null,
    art_type text not null, -- تجريدي، بورتريه، رقمي، إلخ
    created_at timestamp with time zone default timezone('utc'::text, now()) not null
);

-- تفعيل الحماية لبيانات المستخدمين لضمان الأمان والموثوقية
alter table public.profiles enable row level security;
alter table public.artworks enable row level security;
