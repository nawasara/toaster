<div>
    {{-- Toaster --}}
    @if (session('toast'))
        <script>
            window.Laravel = window.Laravel || {};
            window.Laravel.toast = @json(session('toast'));
        </script>
    @endif
    <script src="{{ asset('vendor/nawasara-toaster/js/toaster.js') }}"></script>
    {{-- End Toaster --}}
</div>
