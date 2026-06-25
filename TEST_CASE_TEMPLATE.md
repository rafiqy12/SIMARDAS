# TEST CASE TEMPLATE SIMARDAS

## TEST CASE TEMPLATE - WHITE BOX TESTING

### Module: Authentication
### Feature: Login
### Tested By: QA Team
### Date: April 2026

---

### Test Case TC-WB-001: Validasi Input Email Kosong

| Aspek | Detail |
|-------|--------|
| **Test ID** | TC-WB-001 |
| **Feature** | Login - Validasi Input |
| **Test Type** | White Box |
| **Condition** | Field email kosong, password terisi |
| **Expected Result** | Error message "Email harus diisi" ditampilkan |
| **Actual Result** | Error message "Email harus diisi" ditampilkan |
| **Status** | ✅ PASS |
| **Notes** | Validation rule berfungsi dengan baik |

---

### Test Case TC-WB-002: Validasi Format Email Invalid

| Aspek | Detail |
|-------|--------|
| **Test ID** | TC-WB-002 |
| **Feature** | Login - Validasi Email Format |
| **Test Type** | White Box |
| **Input** | email: "invalidemail", password: "test123" |
| **Expected Result** | Error message "Format email tidak valid" |
| **Actual Result** | Error message "Format email tidak valid" |
| **Status** | ✅ PASS |
| **Notes** | Laravel validation rule 'email' bekerja sempurna |

---

### Test Case TC-WB-003: Email Tidak Ditemukan

| Aspek | Detail |
|-------|--------|
| **Test ID** | TC-WB-003 |
| **Feature** | Login - User Lookup |
| **Test Type** | White Box |
| **Input** | email: "notfound@gmail.com", password: "correct123" |
| **Expected Result** | Error "Email tidak ditemukan", redirect ke login |
| **Actual Result** | Error message ditampilkan dengan benar |
| **Status** | ✅ PASS |
| **Code Path** | if (!$user) { return back()->withErrors(...) } |
| **Notes** | Database query dan error handling berfungsi |

---

### Test Case TC-WB-004: Password Incorrect

| Aspek | Detail |
|-------|--------|
| **Test ID** | TC-WB-004 |
| **Feature** | Login - Password Verification |
| **Test Type** | White Box |
| **Input** | email: "admin@gmail.com", password: "wrongpass" |
| **Expected Result** | Error "Password salah", redirect ke login |
| **Actual Result** | Error message ditampilkan |
| **Status** | ✅ PASS |
| **Code Path** | if (!Hash::check($request->password, $user->password)) |
| **Notes** | Hash verification dan bcrypt check berfungsi |

---

### Test Case TC-WB-005: Login Success - Admin

| Aspek | Detail |
|-------|--------|
| **Test ID** | TC-WB-005 |
| **Feature** | Login - Successful Admin Login |
| **Test Type** | White Box |
| **Input** | email: "admin@gmail.com", password: "admin123" |
| **Expected Result** | Login berhasil, redirect ke dashboard admin |
| **Actual Result** | User ter-login, session tersimpan, redirect dashboard |
| **Status** | ✅ PASS |
| **Code Path** | Auth::login($user); if ($user->role === 'Admin') { redirect dashboard } |
| **Notes** | Full login flow untuk admin berfungsi |

---

### Test Case TC-WB-006: Login Success - Regular User

| Aspek | Detail |
|-------|--------|
| **Test ID** | TC-WB-006 |
| **Feature** | Login - Successful User Login |
| **Test Type** | White Box |
| **Input** | email: "user@gmail.com", password: "user123" |
| **Expected Result** | Login berhasil, redirect ke home page |
| **Actual Result** | User ter-login, session tersimpan, redirect home |
| **Status** | ✅ PASS |
| **Code Path** | Auth::login($user); redirect home |
| **Notes** | Role-based redirect berfungsi untuk user biasa |

---

### Test Case TC-WB-007: Logout

| Aspek | Detail |
|-------|--------|
| **Test ID** | TC-WB-007 |
| **Feature** | Login - Logout |
| **Test Type** | White Box |
| **Precondition** | User sudah login |
| **Expected Result** | Session dihapus, redirect ke login |
| **Actual Result** | Session invalidated, token regenerated, redirect ok |
| **Status** | ✅ PASS |
| **Code Path** | Auth::logout(); $session->invalidate(); $session->regenerateToken() |
| **Notes** | Logout mengikuti best practices Laravel |

---

## TEST CASE TEMPLATE - BLACK BOX TESTING

### Module: User Management
### Feature: Create User
### Tested By: QA Team

---

### Test Case TC-BB-001: Create User - All Fields Valid

| Aspek | Detail |
|-------|--------|
| **Test ID** | TC-BB-001 |
| **Feature** | Create User - Successful Creation |
| **Test Type** | Black Box |
| **Step** | 1. Navigate to Create User form<br>2. Fill all fields with valid data<br>3. Click Save button |
| **Input Data** | nama: "John Doe"<br>email: "john@gmail.com"<br>role: "Petugas"<br>password: "password123"<br>password_confirm: "password123" |
| **Expected Result** | User berhasil ditambahkan, redirect ke user list, success message tampil |
| **Actual Result** | User berhasil ditambahkan, redirect successful, message "User berhasil ditambahkan" |
| **Status** | ✅ PASS |
| **Screenshot** | [User list showing new entry] |
| **Notes** | Database insert berhasil, email valid and unique |

---

### Test Case TC-BB-002: Create User - Nama Kosong

| Aspek | Detail |
|-------|--------|
| **Test ID** | TC-BB-002 |
| **Feature** | Create User - Validation Nama |
| **Test Type** | Black Box |
| **Input** | nama: ""<br>email: "test@gmail.com"<br>role: "User"<br>password: "pass123456" |
| **Expected Result** | Error message "Nama harus diisi", form tetap ditampilkan |
| **Actual Result** | Error message ditampilkan dengan jelas |
| **Status** | ✅ PASS |
| **Screenshot** | [Form with error message] |

---

### Test Case TC-BB-003: Create User - Email Sudah Terdaftar

| Aspek | Detail |
|-------|--------|
| **Test ID** | TC-BB-003 |
| **Feature** | Create User - Email Unique Validation |
| **Test Type** | Black Box |
| **Input** | nama: "New User"<br>email: "existing@gmail.com"<br>role: "User"<br>password: "pass123456" |
| **Expected Result** | Error "Email sudah terdaftar" |
| **Actual Result** | Error message "Email sudah terdaftar" ditampilkan |
| **Status** | ✅ PASS |

---

### Test Case TC-BB-004: Create User - Password < 6 Karakter

| Aspek | Detail |
|-------|--------|
| **Test ID** | TC-BB-004 |
| **Feature** | Create User - Password Strength |
| **Test Type** | Black Box |
| **Input** | nama: "John Doe"<br>email: "john@gmail.com"<br>password: "pass1"<br>password_confirm: "pass1" |
| **Expected Result** | Error "Password minimal 6 karakter" |
| **Actual Result** | Error message ditampilkan |
| **Status** | ✅ PASS |

---

### Test Case TC-BB-005: Create User - Password Tidak Cocok

| Aspek | Detail |
|-------|--------|
| **Test ID** | TC-BB-005 |
| **Feature** | Create User - Password Confirmation |
| **Test Type** | Black Box |
| **Input** | password: "password123"<br>password_confirm: "password456" |
| **Expected Result** | Error "Konfirmasi password tidak cocok" |
| **Actual Result** | Error message ditampilkan |
| **Status** | ✅ PASS |

---

## TEST CASE SUMMARY

| Test ID | Feature | Type | Status | Notes |
|---------|---------|------|--------|-------|
| TC-WB-001 | Login Validation | White Box | ✅ PASS | Email required validation |
| TC-WB-002 | Login Validation | White Box | ✅ PASS | Email format validation |
| TC-WB-003 | Login Lookup | White Box | ✅ PASS | User not found handling |
| TC-WB-004 | Login Auth | White Box | ✅ PASS | Password verification |
| TC-WB-005 | Login Success | White Box | ✅ PASS | Admin role redirect |
| TC-WB-006 | Login Success | White Box | ✅ PASS | User role redirect |
| TC-WB-007 | Logout | White Box | ✅ PASS | Session cleanup |
| TC-BB-001 | Create User | Black Box | ✅ PASS | Successful creation |
| TC-BB-002 | Create User | Black Box | ✅ PASS | Nama validation |
| TC-BB-003 | Create User | Black Box | ✅ PASS | Email unique validation |
| TC-BB-004 | Create User | Black Box | ✅ PASS | Password min length |
| TC-BB-005 | Create User | Black Box | ✅ PASS | Password confirmation |

**Total: 12 test cases**  
**Pass: 12 (100%)**  
**Fail: 0 (0%)**

---

## HOW TO USE THIS TEMPLATE

1. **Copy template untuk setiap test case yang akan dibuat**
2. **Isi semua field sesuai dengan test yang dilakukan**
3. **Update status setelah test dijalankan**
4. **Screenshot hasil test untuk dokumentasi**
5. **Catat notes dan issues yang ditemukan**

---

**For detailed instructions on how to conduct these tests, refer to TESTING_WHITEBOX_BLACKBOX.md**
