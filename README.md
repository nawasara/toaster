# Nawasara Toaster Package

Professional toast notifications for Laravel 12 with Alpine.js and Tailwind CSS.

## Installation

1. Run: `php generate-toaster-files.php`
2. Run: `composer dump-autoload && composer require nawasara/toaster`
3. Update `tailwind.config.js` with package path
4. Update main layout with `<x-nawasara-toaster::toaster />`
5. Run: `npm run build`
6. Test: Visit `/test-toaster`

## Usage

```javascript
Toast.success("Success message!");
Toast.error("Error message!");
Toast.warning("Warning message!");
Toast.info("Info message!");
```

```php
session()->flash("toast", [
    "type" => "success",
    "message" => "Laravel flash message!"
]);
```

## Features

✅ 4 Toast Types (Success, Error, Warning, Info)
✅ 9 Position Options  
✅ Progress Bar Support
✅ Dark Mode Compatible
✅ Mobile Responsive
✅ Alpine.js Integration
✅ Laravel Flash Messages
✅ AJAX/Promise Support
✅ Customizable Themes

Made with ❤️ for Laravel 12
