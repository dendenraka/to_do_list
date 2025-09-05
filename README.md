
📋 Aplikasi To-Do List sederhana berbasis Laravel.

---

## Persyaratan Sistem

- PHP >= 8.2
- Composer
- MySQL
- Git

---

## Langkah Instalasi

### 1. Clone Repository
```
git clone https://github.com/dendenraka/to_do_list.git
cd repo
```

### 2. Install Dependencies
```
composer install
```

### 3. Buat File .env dan cnfigurasi database
```
cp .env.example .env
```

###  4. Generate App Key
```
php artisan key:generate
```

###  5. Jalankan Migrasi
```
php artisan migrate
```

###  6. Jalankan Server Laravel
```
php artisan serve
```
