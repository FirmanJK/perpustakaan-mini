# 🚀 Quick Guide: Push ke GitHub & GitLab

## 📝 Langkah Singkat

### 1. Buat Repository Baru

#### GitHub:

1. Buka https://github.com/new
2. Repository name: `msj-perpustakaan`
3. **Jangan centang** "Add a README file"
4. Klik "Create repository"
5. **Copy URL** yang muncul (contoh: `https://github.com/yourusername/msj-perpustakaan.git`)

#### GitLab:

1. Buka https://gitlab.com/projects/new
2. Project name: `msj-perpustakaan`
3. **Jangan centang** "Initialize repository with a README"
4. Klik "Create project"
5. **Copy URL** yang muncul (contoh: `https://gitlab.com/yourusername/msj-perpustakaan.git`)

---

### 2. Setup Remote (Pilih salah satu cara)

#### ⚡ Cara Otomatis (Recommended):

```bash
# Jalankan script setup
setup-remotes.bat

# Ikuti instruksi, masukkan URL GitHub dan GitLab
```

#### 🔧 Cara Manual:

```bash
# Tambah remote GitHub
git remote add github https://github.com/YOURUSERNAME/msj-perpustakaan.git

# Tambah remote GitLab
git remote add gitlab https://gitlab.com/YOURUSERNAME/msj-perpustakaan.git

# Rename branch ke main
git branch -M main
```

---

### 3. Push Pertama Kali

```bash
# Push ke GitHub
git push -u github main

# Push ke GitLab
git push -u gitlab main
```

**Atau gunakan script:**

```bash
push-all.bat "Initial commit: MSJ Perpustakaan"
```

---

### 4. Push Perubahan Selanjutnya

Setiap kali ada perubahan:

```bash
# Gunakan script (mudah!)
push-all.bat "Deskripsi perubahan"

# Atau manual
git add .
git commit -m "Deskripsi perubahan"
git push github main
git push gitlab main
```

---

## 🔐 Authentication

Saat pertama kali push, Anda akan diminta login:

### GitHub:

- **Username**: username GitHub Anda
- **Password**: gunakan **Personal Access Token** (bukan password)
    - Buat di: Settings → Developer settings → Personal access tokens → Generate new token
    - Pilih scope: `repo`

### GitLab:

- **Username**: username GitLab Anda
- **Password**: gunakan **Personal Access Token**
    - Buat di: User Settings → Access Tokens
    - Pilih scope: `write_repository`

---

## ✅ Verifikasi

Cek apakah remote sudah benar:

```bash
git remote -v
```

Output yang benar:

```
github  https://github.com/YOURUSERNAME/msj-perpustakaan.git (fetch)
github  https://github.com/YOURUSERNAME/msj-perpustakaan.git (push)
gitlab  https://gitlab.com/YOURUSERNAME/msj-perpustakaan.git (fetch)
gitlab  https://gitlab.com/YOURUSERNAME/msj-perpustakaan.git (push)
```

---

## 🎯 Perintah Git yang Sering Dipakai

```bash
# Lihat status perubahan
git status

# Lihat history commit
git log --oneline

# Lihat remote yang terkonfigurasi
git remote -v

# Batalkan perubahan file (sebelum add)
git checkout -- namafile.php

# Batalkan staging (setelah add, sebelum commit)
git reset HEAD namafile.php

# Edit commit terakhir (sebelum push)
git commit --amend -m "Pesan baru"
```

---

## 🆘 Troubleshooting

### Error: "remote origin already exists"

```bash
git remote remove origin
# Lalu setup ulang dengan setup-remotes.bat
```

### Error: "failed to push some refs"

```bash
# Pull dulu dari remote
git pull github main --allow-unrelated-histories
git pull gitlab main --allow-unrelated-histories

# Lalu push lagi
git push github main
git push gitlab main
```

### Error: "Permission denied"

- Pastikan Personal Access Token sudah benar
- Token harus punya scope `repo` (GitHub) atau `write_repository` (GitLab)

### Lupa token/password tersimpan

```bash
# Windows - reset credential
git config --global credential.helper wincred
# Atau hapus dari Credential Manager Windows
```

---

## 📚 Resources

- **GitHub Docs**: https://docs.github.com/en/get-started
- **GitLab Docs**: https://docs.gitlab.com/ee/user/
- **Git Cheatsheet**: https://education.github.com/git-cheat-sheet-education.pdf

---

**Happy Coding! 🎉**
