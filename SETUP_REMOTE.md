# 🔧 Setup Remote Repository (GitHub & GitLab)

## 📋 Langkah-langkah Setup

### 1️⃣ Buat Repository Baru

#### GitHub:

1. Login ke https://github.com
2. Klik tombol **"+"** di pojok kanan atas → **"New repository"**
3. Isi detail:
    - **Repository name**: `msj-perpustakaan`
    - **Description**: `Sistem Manajemen Perpustakaan Mini dengan Laravel`
    - **Visibility**: Public atau Private (pilih sesuai kebutuhan)
    - ❌ **JANGAN** centang "Add a README file" (karena sudah ada)
    - ❌ **JANGAN** centang ".gitignore" (sudah ada)
    - ❌ **JANGAN** pilih license (sudah ada)
4. Klik **"Create repository"**
5. Copy URL repository (contoh: `https://github.com/username/msj-perpustakaan.git`)

#### GitLab:

1. Login ke https://gitlab.com
2. Klik **"New project"** → **"Create blank project"**
3. Isi detail:
    - **Project name**: `msj-perpustakaan`
    - **Project URL**: Pilih namespace
    - **Visibility Level**: Public atau Private
    - ❌ **JANGAN** centang "Initialize repository with a README"
4. Klik **"Create project"**
5. Copy URL repository (contoh: `https://gitlab.com/username/msj-perpustakaan.git`)

---

### 2️⃣ Jalankan Command Berikut

Buka terminal di folder project, lalu jalankan command sesuai pilihan:

#### Option A: Push ke GitHub Saja

```bash
# Tambah remote GitHub
git remote add origin https://github.com/USERNAME/msj-perpustakaan.git

# Push ke GitHub
git branch -M main
git push -u origin main
```

#### Option B: Push ke GitLab Saja

```bash
# Tambah remote GitLab
git remote add origin https://gitlab.com/USERNAME/msj-perpustakaan.git

# Push ke GitLab
git branch -M main
git push -u origin main
```

#### Option C: Push ke GitHub DAN GitLab (Recommended)

```bash
# Tambah remote GitHub (sebagai origin)
git remote add github https://github.com/USERNAME/msj-perpustakaan.git

# Tambah remote GitLab (sebagai gitlab)
git remote add gitlab https://gitlab.com/USERNAME/msj-perpustakaan.git

# Push ke GitHub
git branch -M main
git push -u github main

# Push ke GitLab
git push -u gitlab main
```

---

### 3️⃣ Verifikasi Remote

Cek remote yang sudah ditambahkan:

```bash
git remote -v
```

**Output yang diharapkan (jika pilih Option C):**

```
github  https://github.com/USERNAME/msj-perpustakaan.git (fetch)
github  https://github.com/USERNAME/msj-perpustakaan.git (push)
gitlab  https://gitlab.com/USERNAME/msj-perpustakaan.git (fetch)
gitlab  https://gitlab.com/USERNAME/msj-perpustakaan.git (push)
```

---

### 4️⃣ Push Perubahan Selanjutnya

Setelah setup awal, untuk push perubahan selanjutnya:

#### Jika pakai Option A atau B (single remote):

```bash
git add .
git commit -m "Your commit message"
git push
```

#### Jika pakai Option C (multiple remotes):

```bash
git add .
git commit -m "Your commit message"
git push github main    # Push ke GitHub
git push gitlab main    # Push ke GitLab
```

**Atau buat script helper** (lihat bagian Script Helper di bawah)

---

## 🚀 Script Helper untuk Push ke Multiple Remotes

Buat file `push-all.sh` (Linux/Mac) atau `push-all.bat` (Windows):

### Windows (`push-all.bat`):

```batch
@echo off
echo =======================================
echo  Push to GitHub and GitLab
echo =======================================
echo.

REM Add all changes
git add .

REM Commit with message from argument or default message
if "%~1"=="" (
    git commit -m "Update: automated commit"
) else (
    git commit -m "%*"
)

REM Push to GitHub
echo.
echo Pushing to GitHub...
git push github main

REM Push to GitLab
echo.
echo Pushing to GitLab...
git push gitlab main

echo.
echo =======================================
echo  Push completed successfully!
echo =======================================
pause
```

### Linux/Mac (`push-all.sh`):

```bash
#!/bin/bash

echo "======================================="
echo " Push to GitHub and GitLab"
echo "======================================="
echo ""

# Add all changes
git add .

# Commit with message from argument or default message
if [ -z "$1" ]; then
    git commit -m "Update: automated commit"
else
    git commit -m "$*"
fi

# Push to GitHub
echo ""
echo "Pushing to GitHub..."
git push github main

# Push to GitLab
echo ""
echo "Pushing to GitLab..."
git push gitlab main

echo ""
echo "======================================="
echo " Push completed successfully!"
echo "======================================="
```

**Cara pakai:**

```bash
# Windows
push-all.bat "Your commit message here"

# Linux/Mac
chmod +x push-all.sh
./push-all.sh "Your commit message here"
```

---

## 🔐 Authentication Tips

### Personal Access Token (Recommended)

#### GitHub:

1. Settings → Developer settings → Personal access tokens → Tokens (classic)
2. Generate new token
3. Pilih scope: `repo` (full control)
4. Copy token dan simpan
5. Saat git push pertama kali, gunakan token sebagai password

#### GitLab:

1. User Settings → Access Tokens
2. Buat token baru dengan scope: `write_repository`
3. Copy token dan simpan
4. Saat git push pertama kali, gunakan token sebagai password

### SSH Keys (Alternative)

Jika ingin menggunakan SSH:

```bash
# Generate SSH key
ssh-keygen -t ed25519 -C "your_email@example.com"

# Copy public key
cat ~/.ssh/id_ed25519.pub

# Tambahkan ke GitHub/GitLab Settings → SSH Keys

# Ganti remote URL ke SSH
git remote set-url github git@github.com:USERNAME/msj-perpustakaan.git
git remote set-url gitlab git@gitlab.com:USERNAME/msj-perpustakaan.git
```

---

## 🛠️ Troubleshooting

### Error: Remote already exists

```bash
# Hapus remote yang ada
git remote remove origin
# atau
git remote remove github
git remote remove gitlab

# Tambah lagi remote yang benar
```

### Error: Failed to push some refs

```bash
# Pull dulu perubahan dari remote
git pull github main --rebase
# atau
git pull gitlab main --rebase

# Kemudian push
git push
```

### Error: Permission denied

- Pastikan token akses sudah benar
- Atau setup SSH key dengan benar

---

## 📝 Best Practices

1. **Commit Messages**: Gunakan pesan commit yang jelas dan deskriptif

    ```bash
    git commit -m "Add: fitur auto-generate nomor transaksi"
    git commit -m "Fix: bug stock tidak berkurang saat peminjaman"
    git commit -m "Update: dashboard chart untuk role guest"
    ```

2. **Branch Strategy**:

    ```bash
    # Untuk fitur baru
    git checkout -b feature/nama-fitur

    # Untuk bug fix
    git checkout -b bugfix/nama-bug

    # Setelah selesai, merge ke main
    git checkout main
    git merge feature/nama-fitur
    ```

3. **Ignore Sensitive Files**: Pastikan `.env` sudah ada di `.gitignore`

4. **Regular Backup**: Push perubahan secara teratur, jangan tunggu terlalu banyak perubahan

---

## 🎯 Quick Reference

```bash
# Status
git status

# Add files
git add .
git add file.php

# Commit
git commit -m "Message"

# Push ke specific remote
git push github main
git push gitlab main

# Pull dari remote
git pull github main
git pull gitlab main

# View remotes
git remote -v

# View commit history
git log --oneline

# Create new branch
git checkout -b branch-name

# Switch branch
git checkout branch-name

# Merge branch
git merge branch-name
```

---

**Selamat! Repository Anda sudah siap di GitHub dan GitLab! 🎉**
