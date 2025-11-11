# Registration Control System - VASEL 2025

Hệ thống quản lý đóng/mở form đăng ký cho VASEL 2025.

## Tính năng

- Đóng/mở tất cả form đăng ký bằng middleware
- Hiển thị thông báo đăng ký đã đóng với thiết kế chuyên nghiệp
- Quản lý qua file .env và artisan command
- Hỗ trợ đa ngôn ngữ (English/Vietnamese)

## Cấu hình

### 1. Thêm vào file .env:

```bash
# Registration Settings
REGISTRATION_ENABLED=false
SPEAKER_REGISTRATION_ENABLED=false
DELEGATE_REGISTRATION_ENABLED=false
```

### 2. Middleware đã được áp dụng cho các route sau:

- `speaker-registration` (GET/POST)
- `speaker-registration-vn` (GET/POST)
- `delegate-registration` (GET/POST)
- `delegate-registration-vn` (GET/POST)

## Sử dụng Artisan Command

### Đóng tất cả form đăng ký:

```bash
php artisan registration:control disable
```

### Mở tất cả form đăng ký:

```bash
php artisan registration:control enable
```

### Đóng/mở form cụ thể:

```bash
# Chỉ form speaker
php artisan registration:control disable --type=speaker
php artisan registration:control enable --type=speaker

# Chỉ form delegate
php artisan registration:control disable --type=delegate
php artisan registration:control enable --type=delegate
```

## Files đã tạo/chỉnh sửa

1. **Middleware**: `app/Http/Middleware/RegistrationClosed.php`
2. **Config**: `config/registration.php`
3. **View**: `Themes/vasel2025/views/partials/registration-closed.blade.php`
4. **Command**: `app/Console/Commands/RegistrationControl.php`
5. **Routes**: `Themes/vasel2025/routes/web.php` (đã áp dụng middleware)
6. **Kernel**: `app/Http/Kernel.php` (đã đăng ký middleware)

## Cách hoạt động

1. Khi `REGISTRATION_ENABLED=false`, middleware sẽ chặn tất cả request đến các form đăng ký
2. Hiển thị trang thông báo đăng ký đã đóng với thiết kế responsive
3. Người dùng có thể quay lại trang chủ thông qua nút "Back to Homepage"

## Customization

Bạn có thể tùy chỉnh:

- Thông báo trong file `config/registration.php`
- Thiết kế trang thông báo trong `registration-closed.blade.php`
- Logic middleware trong `RegistrationClosed.php`

## Lưu ý

- Sau khi thay đổi .env, cần chạy `php artisan config:clear`
- Middleware chỉ áp dụng cho các route đã được chỉ định
- Trang chủ và các trang khác không bị ảnh hưởng
