<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Butik Dayu')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream text-ink overflow-x-hidden">

    @yield('content')

    @include('partials.footer')

    <div id="modal-konfirmasi" class="hidden fixed inset-0 z-50 bg-ink/50 items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full p-6 text-center">
            <div class="w-14 h-14 rounded-full bg-red-50 text-red-500 flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>
            <p id="modal-konfirmasi-pesan" class="text-sm text-ink/70 mb-6"></p>
            <div class="flex gap-3">
                <button type="button" data-tutup-konfirmasi class="flex-1 border border-brand-200 text-ink/70 text-sm font-semibold rounded-lg py-2.5 hover:bg-brand-50 transition-colors">Batal</button>
                <button type="button" data-lanjut-konfirmasi class="flex-1 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg py-2.5 transition-colors">Lanjutkan</button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const modal = document.getElementById('modal-konfirmasi');
            const pesan = document.getElementById('modal-konfirmasi-pesan');
            let formAktif = null;

            document.querySelectorAll('[data-confirm]').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.dataset.confirmed === 'true') return;
                    event.preventDefault();
                    formAktif = form;
                    pesan.textContent = form.dataset.confirm;
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });
            });

            function tutup() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                formAktif = null;
            }

            modal.querySelector('[data-tutup-konfirmasi]').addEventListener('click', tutup);
            modal.querySelector('[data-lanjut-konfirmasi]').addEventListener('click', function () {
                if (!formAktif) return;
                formAktif.dataset.confirmed = 'true';
                formAktif.submit();
            });
            modal.addEventListener('click', function (event) {
                if (event.target === modal) tutup();
            });
        })();
    </script>

</body>
</html>
