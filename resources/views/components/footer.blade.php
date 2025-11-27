{{-- 
    File: resources/views/components/footer.blade.php
    atau
    File: resources/views/partials/footer.blade.php
--}}

<footer class="mt-5 bg-dark text-white pt-4 pb-3">
    <div class="container">

        <div class="row gy-4">

            {{-- Kolom kiri --}}
            <div class="col-md-6">
                <h5 class="fw-bold mb-3">Kota Baru Keandra</h5>
                <p class="small text-white-50 mb-0">
                    Portal informasi resmi untuk warga Kota Baru Keandra.
                    Menyediakan layanan data dan informasi lingkungan secara
                    transparan, aman, dan mudah diakses.
                </p>
            </div>

            {{-- Kolom kanan --}}
            <div class="col-md-6">
                <div class="row">

                    {{-- Media Sosial --}}
                    <div class="col-6">
                        <h5 class="fw-bold mb-3">Media Sosial</h5>
                        <ul class="list-unstyled small mb-0">

                            <li class="mb-2 d-flex align-items-center">
                                <svg width="26" height="26" viewBox="0 0 24 24" class="me-2">
                                    <defs>
                                        <linearGradient id="igGradient" x1="0%" y1="0%" x2="100%"
                                            y2="100%">
                                            <stop offset="0%" stop-color="#fdf497" />
                                            <stop offset="25%" stop-color="#fd5949" />
                                            <stop offset="50%" stop-color="#d6249f" />
                                            <stop offset="100%" stop-color="#285AEB" />
                                        </linearGradient>
                                    </defs>
                                    <path fill="url(#igGradient)"
                                        d="M7 2C4.243 2 2 4.243 2 7v10c0 2.757 2.243 5 5 5h10c2.757 0 5-2.243 5-5V7c0-2.757-2.243-5-5-5H7zm10 2c1.654 0 3 1.346 3 3v10c0 1.654-1.346 3-3 3H7c-1.654 0-3-1.346-3-3V7c0-1.654 1.346-3 3-3h10zm-5 3c-2.757 0-5 2.243-5 5s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5zm0 2c1.654 0 3 1.346 3 3s-1.346 3-3 3-3-1.346-3-3 1.346-3 3-3zm4.5-.75a1.25 1.25 0 110 2.5 1.25 1.25 0 010-2.5z" />
                                </svg>
                                <a class="text-white-50 text-decoration-none" target="_blank"
                                    href="https://www.instagram.com">Instagram</a>
                            </li>

                            <li class="mb-2 d-flex align-items-center">
                                <svg width="26" height="26" viewBox="0 0 24 24" class="me-2">
                                    <path fill="#1877F2"
                                        d="M22 12a10 10 0 10-11.5 9.9v-7H8v-3h2.5V9.5a3.5 3.5 0 013.7-3.9c1 0 2 .1 2 .1v2.3H15c-1.2 0-1.6.8-1.6 1.6V12H18l-.5 3h-3.1v7A10 10 0 0022 12" />
                                </svg>
                                <a class="text-white-50 text-decoration-none" target="_blank"
                                    href="https://www.facebook.com">Facebook</a>
                            </li>

                            <li class="d-flex align-items-center">
                                <svg width="26" height="26" viewBox="0 0 48 48" class="me-2">
                                    <path fill="#69C9D0"
                                        d="M34.5 14.2c-2.8-1.4-5-3.7-6.4-6.5v18.2c0 5.8-4.7 10.5-10.5 10.5S7 31.7 7 25.9 S11.7 15.4 17.5 15.4c1 .0 2 .1 3 .4v6.7c-.9-.4-1.9-.6-3-.6c-3.6 0-6.5 2.9-6.5 6.5S13.9 35 17.5 35 s6.5-2.9 6.5-6.5V4h6v1.7c0 2.9 1.5 5.6 4 7.1c1.2.7 2.5 1.1 3.9 1.2v6.1c-2.1-.2-4.2-.8-6.4-1.9z" />
                                    <path fill="#EE1D52"
                                        d="M38.4 11.9c-1.4-.1-2.7-.5-3.9-1.2c-2.5-1.5-4-4.2-4-7.1V4h-6v24.5 c0 3.6-2.9 6.5-6.5 6.5v6.7c5.8 0 10.5-4.7 10.5-10.5V13.8c1.4 2.8 3.6 5.1 6.4 6.5c2.1 1.1 4.3 1.7 6.4 1.9 v-6.1c-1.4-.1-2.7-.5-3.9-1.2z" />
                                    <path fill="#010101"
                                        d="M30.7 10.4c-2.8-1.4-5-3.7-6.4-6.5V4H18v24.5c0 3.6-2.9 6.5-6.5 6.5 S5 32.1 5 28.5s2.9-6.5 6.5-6.5c1.1 0 2.1.2 3 .6v-6.7c-1-.3-2-.4-3-.4C5.8 15.4 1 20.2 1 25.9 S5.8 36.4 11.5 36.4S22 31.7 22 25.9V9c1.4 2.8 3.6 5.1 6.4 6.5c2.2 1.1 4.3 1.7 6.4 1.9v-6.1 c-1.4-.1-2.7-.5-3.9-1.2z" />
                                </svg>
                                <a class="text-white-50 text-decoration-none" target="_blank"
                                    href="https://www.tiktok.com">TikTok</a>
                            </li>

                        </ul>
                    </div>

                    {{-- Navigasi --}}
                    <div class="col-6">
                        <h5 class="fw-bold mb-3">Navigasi</h5>
                        <ul class="list-unstyled small mb-0">
                            <li class="mb-2"><a href="{{ route('dashboard') }}#statistik"
                                    class="text-white-50 text-decoration-none">Statistik</a></li>
                            <li class="mb-2"><a href="{{ route('dashboard') }}#pengurus-warga"
                                    class="text-white-50 text-decoration-none">Pengurus</a></li>
                            <li><a href="{{ route('dashboard') }}#maps" class="text-white-50 text-decoration-none">Peta
                                    Lokasi</a></li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>

        <hr class="border-secondary mt-4">

        <div class="text-center small text-white-50">
            © {{ date('Y') }} Kota Baru Keandra. All rights reserved.
        </div>

    </div>
</footer>
