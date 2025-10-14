<div>
    {{-- Toaster --}}
    @if (session('toast'))
        <script>
            window.Laravel = window.Laravel || {};
            window.Laravel.toast = @json(session('toast'));
        </script>
    @endif
    @php
        $toasterPath = public_path('vendor/nawasara-toaster/js/toaster.js');
        $toasterVersion = file_exists($toasterPath) ? '?v=' . filemtime($toasterPath) : '';
    @endphp
    <script src="{{ asset('vendor/nawasara-toaster/js/toaster.js') }}{{ $toasterVersion }}"></script>
    {{-- End Toaster --}}
</div>
