# Nawasara Toaster

Lightweight, Alpine-based toast notification component for Laravel and Livewire applications. Drop one component into your layout and trigger toasts from JavaScript, Livewire, or session flash.

## Features

- Four toast types: success, error, warning, info
- Configurable position: nine corner/edge anchors
- Optional progress bar countdown indicator
- Dark-mode aware: respects the host application's theme
- Mobile responsive
- Triggers from anywhere: JavaScript (`window.Toast`), Livewire dispatch, or Laravel session flash
- Auto-init from flash: shows the toast on the next page load when you redirect with a flash payload

## Installation

```bash
composer require nawasara/toaster
```

Auto-discovered. Drop the toaster + script components into your layout:

```blade
<x-nawasara-toaster::script />

{{-- … your content … --}}

<x-nawasara-toaster::toaster position="top-right" :duration="5000" />
```

## Usage

### From JavaScript

```js
window.Toast.success('Saved successfully');
window.Toast.error('Something went wrong');
window.Toast.warning('Heads up');
window.Toast.info('FYI');
```

### From Laravel session flash

```php
session()->flash('toast', [
    'type' => 'success',
    'message' => 'Saved successfully',
]);

return redirect()->back();
```

The toaster auto-loads the flash payload via `window.Laravel.toast` on the next page render.

### From Livewire

Use the `HasToaster` trait if you prefer session-flash style (works after a redirect):

```php
use Livewire\Component;
use Nawasara\Toaster\Concerns\HasToaster;

class MyComponent extends Component
{
    use HasToaster;

    public function save()
    {
        // …
        $this->alert('success', 'Saved successfully');
    }
}
```

For real-time toasts inside the same Livewire request (no page reload), use `Nawasara\Ui\Livewire\Concerns\HasBrowserToast` from `nawasara/ui`. It dispatches a browser `toast` event that the toaster listens to.

## Author

**Pringgo J. Saputro** &lt;odyinggo@gmail.com&gt;

## License

MIT
