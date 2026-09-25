@extends('layouts.app')

@section('title', 'Pendaftaran Atlet - ' . $event->nama_event)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('perkumpulan.dashboard') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">
            <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-indigo-50 to-slate-50">
            <h3 class="text-xl font-bold text-slate-800">Daftarkan Atlet Baru</h3>
            <p class="text-sm text-slate-500 mt-1">Event: <span class="font-semibold text-slate-700">{{ $event->nama_event }}</span></p>
        </div>

        <div class="p-8">
            <form action="{{ route('perkumpulan.pendaftaran.store', $event) }}" method="POST" id="pendaftaranForm">
                @csrf

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm">
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-6">
                    <!-- Data Atlet -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2 relative">
                            <label for="nama_atlet" class="block text-sm font-bold text-slate-700 mb-1">Nama Atlet <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_atlet" id="nama_atlet" value="{{ old('nama_atlet') }}" required autocomplete="off"
                                class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors"
                                placeholder="Ketik nama atlet untuk auto-complete...">
                            <!-- Autocomplete Dropdown -->
                            <div id="autocomplete-results" class="absolute z-10 w-full bg-white mt-1 rounded-xl shadow-lg border border-slate-200 hidden max-h-60 overflow-y-auto"></div>
                        </div>

                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-bold text-slate-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                                class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors">
                            <!-- Info KU hasil deteksi otomatis -->
                            <div id="ku-suggestion" class="mt-2 hidden">
                                <p class="text-xs text-indigo-600 font-medium" id="ku-suggestion-text"></p>
                            </div>
                        </div>

                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-bold text-slate-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select name="jenis_kelamin" id="jenis_kelamin" required
                                class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors">
                                <option value="">-- Pilih --</option>
                                <option value="putra" {{ old('jenis_kelamin') == 'putra' ? 'selected' : '' }}>Putra</option>
                                <option value="putri" {{ old('jenis_kelamin') == 'putri' ? 'selected' : '' }}>Putri</option>
                            </select>
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    <!-- Pemilihan Kategori Lomba -->
                    <div>
                        <label for="kelompok_umur_id" class="block text-sm font-bold text-slate-700 mb-1">Kelompok Umur (KU) <span class="text-red-500">*</span></label>
                        <select name="kelompok_umur_id" id="kelompok_umur_id" required
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors">
                            <option value="">-- Pilih Kelompok Umur --</option>
                            @foreach($kelompokUmur as $ku)
                                <option value="{{ $ku->id }}"
                                    data-nomor='@json($ku->nomorLomba)'
                                    data-usia-min="{{ $ku->usia_min ?? 0 }}"
                                    data-usia-max="{{ $ku->usia_max ?? 999 }}"
                                    {{ old('kelompok_umur_id') == $ku->id ? 'selected' : '' }}>
                                    {{ $ku->nama_ku }} ({{ $ku->usia_min ?? 0 }} - {{ $ku->usia_max ?? 'Unlimited' }} thn)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nomor Lomba — Checklist + input waktu per nomor -->
                    <div>
                        <div class="flex items-end justify-between mb-1">
                            <label class="block text-sm font-bold text-slate-700">
                                Nomor Lomba <span class="text-red-500">*</span>
                                <span class="text-xs font-normal text-slate-500 ml-1">(Bisa pilih lebih dari 1)</span>
                            </label>
                            <span class="text-xs text-slate-400 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Input waktu bersifat opsional per nomor
                            </span>
                        </div>

                        <!-- Placeholder saat KU belum dipilih -->
                        <div id="nomor-lomba-placeholder" class="rounded-xl border border-slate-200 bg-slate-50 p-5 text-center text-sm text-slate-400">
                            <svg class="w-6 h-6 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Pilih Kelompok Umur terlebih dahulu
                        </div>

                        <!-- Container checklist nomor lomba -->
                        <div id="nomor-lomba-checklist" class="hidden">
                            <div id="nomor-lomba-items" class="rounded-xl border border-slate-200 divide-y divide-slate-100 overflow-hidden">
                                <!-- Di-render oleh JavaScript -->
                            </div>
                            <div id="nomor-lomba-empty" class="hidden rounded-xl border border-slate-200 bg-slate-50 p-5 text-center text-sm text-slate-400">
                                Tidak ada nomor lomba tersedia untuk kelompok umur &amp; jenis kelamin ini.
                            </div>
                            <p id="nomor-lomba-counter" class="mt-2 text-xs text-right"></p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-end space-x-4">
                    <a href="{{ route('perkumpulan.dashboard') }}" class="px-6 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-2.5 bg-indigo-600 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5">
                        Daftarkan Atlet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputNama         = document.getElementById('nama_atlet');
        const inputTglLahir     = document.getElementById('tanggal_lahir');
        const inputGender       = document.getElementById('jenis_kelamin');
        const resultsContainer  = document.getElementById('autocomplete-results');

        const selectKu          = document.getElementById('kelompok_umur_id');
        const kuSuggestion      = document.getElementById('ku-suggestion');
        const kuSuggestionText  = document.getElementById('ku-suggestion-text');

        const placeholder       = document.getElementById('nomor-lomba-placeholder');
        const checklist         = document.getElementById('nomor-lomba-checklist');
        const itemsContainer    = document.getElementById('nomor-lomba-items');
        const emptyMsg          = document.getElementById('nomor-lomba-empty');
        const counter           = document.getElementById('nomor-lomba-counter');

        const autoMatchRoute    = `{{ route('perkumpulan.autocomplete.waktu') }}`;
        const oldLimitWaktu     = @json(old('limit_waktu_per_nomor', []));

        let timeoutId;

        // ─────────────────────────────────────────────
        // 1. Auto-complete Nama Atlet
        // ─────────────────────────────────────────────
        inputNama.addEventListener('input', function() {
            clearTimeout(timeoutId);
            const query = this.value.trim();

            if (query.length < 2) {
                resultsContainer.classList.add('hidden');
                return;
            }

            timeoutId = setTimeout(() => {
                fetch(`{{ route('perkumpulan.autocomplete.atlet') }}?q=${encodeURIComponent(query)}`)
                    .then(r => r.json())
                    .then(data => {
                        resultsContainer.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(atlet => {
                                const div = document.createElement('div');
                                div.className = 'px-4 py-3 hover:bg-indigo-50 cursor-pointer border-b border-slate-100 last:border-b-0 transition-colors';
                                div.innerHTML = `
                                    <div class="font-bold text-slate-800">${atlet.nama_atlet}</div>
                                    <div class="text-xs text-slate-500">${atlet.jenis_kelamin.toUpperCase()} | Lahir: ${atlet.tanggal_lahir}</div>
                                `;
                                div.addEventListener('click', () => {
                                    inputNama.value = atlet.nama_atlet;
                                    if (atlet.tanggal_lahir) {
                                        inputTglLahir.value = atlet.tanggal_lahir;
                                        autoDetectKU();
                                    }
                                    if (atlet.jenis_kelamin) {
                                        inputGender.value = atlet.jenis_kelamin;
                                        updateNomorLombaChecklist();
                                    }
                                    resultsContainer.classList.add('hidden');
                                });
                                resultsContainer.appendChild(div);
                            });
                            resultsContainer.classList.remove('hidden');
                        } else {
                            resultsContainer.classList.add('hidden');
                        }
                    });
            }, 300);
        });

        document.addEventListener('click', function(e) {
            if (e.target !== inputNama && !resultsContainer.contains(e.target)) {
                resultsContainer.classList.add('hidden');
            }
        });

        // ─────────────────────────────────────────────
        // 2. Auto-detect KU dari Tanggal Lahir
        // ─────────────────────────────────────────────
        function getUmur(tglLahir) {
            if (!tglLahir) return null;
            const today = new Date();
            const lahir = new Date(tglLahir);
            let umur    = today.getFullYear() - lahir.getFullYear();
            const m     = today.getMonth() - lahir.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < lahir.getDate())) umur--;
            return umur;
        }

        function autoDetectKU() {
            const umur = getUmur(inputTglLahir.value);
            if (umur === null) { kuSuggestion.classList.add('hidden'); return; }

            const options = Array.from(selectKu.options);
            let matched   = null;
            for (const opt of options) {
                if (!opt.value) continue;
                const min = parseInt(opt.dataset.usiaMin ?? 0);
                const max = parseInt(opt.dataset.usiaMax ?? 999);
                if (umur >= min && umur <= max) { matched = opt; break; }
            }

            if (matched) {
                selectKu.value = matched.value;
                kuSuggestionText.textContent = `✓ KU otomatis terdeteksi: ${matched.textContent.trim()} (Umur: ${umur} tahun)`;
                kuSuggestion.classList.remove('hidden');
            } else {
                kuSuggestion.classList.add('hidden');
            }
            updateNomorLombaChecklist();
        }

        inputTglLahir.addEventListener('change', autoDetectKU);

        // ─────────────────────────────────────────────
        // 3. Render Checklist Nomor Lomba + Input Waktu
        // ─────────────────────────────────────────────
        function updateNomorLombaChecklist() {
            const selectedOption = selectKu.options[selectKu.selectedIndex];
            const selectedGender = inputGender.value;
            const oldIds         = @json(old('nomor_lomba_ids', []));

            itemsContainer.innerHTML = '';
            counter.textContent = '';

            if (!selectedOption || !selectedOption.value) {
                checklist.classList.add('hidden');
                placeholder.classList.remove('hidden');
                return;
            }

            const nomorLomba = JSON.parse(selectedOption.dataset.nomor || '[]');
            const filtered   = nomorLomba.filter(n => {
                if (!selectedGender) return true;
                return n.jenis_kelamin === 'campuran' || n.jenis_kelamin === selectedGender;
            });

            placeholder.classList.add('hidden');
            checklist.classList.remove('hidden');

            if (filtered.length === 0) {
                itemsContainer.classList.add('hidden');
                emptyMsg.classList.remove('hidden');
                return;
            }

            emptyMsg.classList.add('hidden');
            itemsContainer.classList.remove('hidden');

            filtered.forEach(nomor => {
                const isChecked   = oldIds.includes(String(nomor.id)) || oldIds.includes(nomor.id);
                const oldWaktu    = (oldLimitWaktu && oldLimitWaktu[nomor.id]) ? oldLimitWaktu[nomor.id] : '';
                const genderBadge = nomor.jenis_kelamin === 'campuran'
                    ? `<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700">Campuran</span>`
                    : nomor.jenis_kelamin === 'putra'
                        ? `<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Putra</span>`
                        : `<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-700">Putri</span>`;

                const wrapper = document.createElement('div');
                wrapper.className = 'transition-colors';
                wrapper.innerHTML = `
                    <!-- Baris checklist utama -->
                    <label for="nomor_${nomor.id}" class="flex items-center gap-4 px-5 py-3.5 cursor-pointer hover:bg-indigo-50 transition-colors group">
                        <input type="checkbox"
                            name="nomor_lomba_ids[]"
                            value="${nomor.id}"
                            id="nomor_${nomor.id}"
                            class="nomor-checkbox w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer shrink-0"
                            ${isChecked ? 'checked' : ''}>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-semibold text-slate-800 text-sm group-hover:text-indigo-700 transition-colors">${nomor.nama_nomor}</span>
                                ${genderBadge}
                            </div>
                            <div class="text-xs text-slate-500 mt-0.5">${nomor.jarak}m &bull; Gaya ${nomor.gaya}</div>
                        </div>
                        <div class="text-xs font-mono text-slate-300 shrink-0">#${nomor.id}</div>
                    </label>

                    <!-- Panel input waktu — hanya tampil jika checkbox dicentang -->
                    <div class="waktu-panel ${isChecked ? '' : 'hidden'} px-5 pb-4 bg-indigo-50 border-t border-indigo-100">
                        <div class="flex items-center gap-3 pt-3">
                            <svg class="w-4 h-4 text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1">
                                <label class="block text-xs font-semibold text-indigo-800 mb-1">
                                    Limit Waktu
                                    <span class="font-normal text-indigo-500 ml-1">(Opsional — kosongkan untuk auto-match dari riwayat)</span>
                                </label>
                                <div class="flex items-center gap-2">
                                    <input type="text"
                                        name="limit_waktu_per_nomor[${nomor.id}]"
                                        class="waktu-input block w-36 rounded-lg border-indigo-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-3 font-mono bg-white placeholder-slate-300"
                                        placeholder="MM:SS.ss"
                                        value="${oldWaktu}"
                                        autocomplete="off">
                                    <button type="button"
                                        class="btn-auto-match inline-flex items-center gap-1.5 px-3 py-2 bg-white text-indigo-600 border border-indigo-200 rounded-lg text-xs font-semibold hover:bg-indigo-100 transition-colors shadow-sm disabled:opacity-40 disabled:cursor-not-allowed"
                                        data-nomor-id="${nomor.id}"
                                        data-nomor-label="${nomor.nama_nomor} ${nomor.jarak}m ${nomor.gaya}"
                                        disabled>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                        Auto Match
                                    </button>
                                    <span class="auto-match-status text-xs font-medium hidden"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                // Toggle panel waktu saat checkbox berubah
                const cb       = wrapper.querySelector('input[type=checkbox]');
                const panel    = wrapper.querySelector('.waktu-panel');
                const waktuIn  = wrapper.querySelector('.waktu-input');
                const btnMatch = wrapper.querySelector('.btn-auto-match');
                const statusEl = wrapper.querySelector('.auto-match-status');

                cb.addEventListener('change', () => {
                    if (cb.checked) {
                        panel.classList.remove('hidden');
                        checkBtnAutoMatch(btnMatch, waktuIn);
                    } else {
                        panel.classList.add('hidden');
                        waktuIn.value = '';
                    }
                    updateCounter();
                });

                // Aktifkan tombol auto-match jika nama atlet sudah diisi
                inputNama.addEventListener('input', () => checkBtnAutoMatch(btnMatch, waktuIn));
                inputNama.addEventListener('change', () => checkBtnAutoMatch(btnMatch, waktuIn));
                checkBtnAutoMatch(btnMatch, waktuIn);

                // Auto-match per nomor
                btnMatch.addEventListener('click', function() {
                    const nama    = inputNama.value.trim();
                    const nomorId = this.dataset.nomorId;
                    if (!nama) return;

                    btnMatch.disabled = true;
                    btnMatch.innerHTML = `<svg class="animate-spin w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mencari...`;

                    fetch(`${autoMatchRoute}?nama_atlet=${encodeURIComponent(nama)}&nomor_lomba_id=${nomorId}`)
                        .then(r => r.json())
                        .then(data => {
                            statusEl.classList.remove('hidden');
                            if (data.limit_waktu) {
                                waktuIn.value = data.limit_waktu;
                                statusEl.textContent = '✓ ' + data.message;
                                statusEl.className = 'auto-match-status text-xs font-medium text-emerald-600';
                            } else {
                                waktuIn.value = '';
                                statusEl.textContent = '⚠ ' + data.message;
                                statusEl.className = 'auto-match-status text-xs font-medium text-amber-600';
                            }
                        })
                        .catch(() => {
                            statusEl.textContent = '✗ Gagal auto-match.';
                            statusEl.className = 'auto-match-status text-xs font-medium text-red-500';
                            statusEl.classList.remove('hidden');
                        })
                        .finally(() => {
                            btnMatch.disabled = false;
                            btnMatch.innerHTML = `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg> Auto Match`;
                        });
                });

                itemsContainer.appendChild(wrapper);
            });

            updateCounter();
        }

        function checkBtnAutoMatch(btn, input) {
            const nama = inputNama.value.trim();
            if (btn && btn.closest('.waktu-panel') && !btn.closest('.waktu-panel').classList.contains('hidden')) {
                btn.disabled = nama.length === 0;
            }
        }

        function updateCounter() {
            const total   = itemsContainer.querySelectorAll('.nomor-checkbox').length;
            const checked = itemsContainer.querySelectorAll('.nomor-checkbox:checked').length;
            counter.textContent = `${checked} dari ${total} nomor lomba dipilih`;
            counter.className = checked > 0
                ? 'mt-2 text-xs font-medium text-right text-indigo-600'
                : 'mt-2 text-xs font-medium text-right text-slate-400';
        }

        selectKu.addEventListener('change', updateNomorLombaChecklist);
        inputGender.addEventListener('change', updateNomorLombaChecklist);

        // Trigger pada load untuk old() data
        if (selectKu.value) {
            updateNomorLombaChecklist();
        }
    });
</script>
@endpush
@endsection
