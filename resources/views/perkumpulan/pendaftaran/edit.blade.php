@extends('layouts.app')

@section('title', 'Edit Pendaftaran - ' . $event->nama_event)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('perkumpulan.dashboard') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">
            <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-slate-50">
            <h3 class="text-xl font-bold text-slate-800">Edit Data Pendaftaran</h3>
            <p class="text-sm text-slate-500 mt-1">Event: <span class="font-semibold text-slate-700">{{ $event->nama_event }}</span></p>
        </div>

        <div class="p-8">
            <form action="{{ route('perkumpulan.pendaftaran.update', $pendaftaran) }}" method="POST" id="pendaftaranForm">
                @csrf
                @method('PUT')

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
                            <input type="text" name="nama_atlet" id="nama_atlet" value="{{ old('nama_atlet', $pendaftaran->nama_atlet) }}" required autocomplete="off"
                                class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors"
                                placeholder="Ketik nama atlet untuk auto-complete...">
                            <!-- Autocomplete Dropdown -->
                            <div id="autocomplete-results" class="absolute z-10 w-full bg-white mt-1 rounded-xl shadow-lg border border-slate-200 hidden max-h-60 overflow-y-auto"></div>
                        </div>

                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-bold text-slate-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $pendaftaran->tanggal_lahir?->format('Y-m-d')) }}" required
                                class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors">
                        </div>

                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-bold text-slate-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select name="jenis_kelamin" id="jenis_kelamin" required
                                class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors">
                                <option value="">-- Pilih --</option>
                                <option value="putra" {{ old('jenis_kelamin', $pendaftaran->jenis_kelamin) == 'putra' ? 'selected' : '' }}>Putra</option>
                                <option value="putri" {{ old('jenis_kelamin', $pendaftaran->jenis_kelamin) == 'putri' ? 'selected' : '' }}>Putri</option>
                            </select>
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    <!-- Pemilihan Kategori Lomba -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="kelompok_umur_id" class="block text-sm font-bold text-slate-700 mb-1">Kelompok Umur (KU) <span class="text-red-500">*</span></label>
                            <select name="kelompok_umur_id" id="kelompok_umur_id" required
                                class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors">
                                <option value="">-- Pilih Kelompok Umur --</option>
                                @foreach($kelompokUmur as $ku)
                                    <option value="{{ $ku->id }}" data-nomor='@json($ku->nomorLomba)' {{ old('kelompok_umur_id', $pendaftaran->kelompok_umur_id) == $ku->id ? 'selected' : '' }}>
                                        {{ $ku->nama_ku }} ({{ $ku->usia_min ?? 0 }} - {{ $ku->usia_max ?? 'Unlimited' }} thn)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="nomor_lomba_id" class="block text-sm font-bold text-slate-700 mb-1">Nomor Lomba <span class="text-red-500">*</span></label>
                            <select name="nomor_lomba_id" id="nomor_lomba_id" required
                                class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors">
                                <option value="">-- Pilih Nomor Lomba --</option>
                                <!-- Will be populated by JS -->
                            </select>
                        </div>
                    </div>

                    <!-- Limit Waktu & Auto Match -->
                    <div class="bg-amber-50 rounded-xl p-5 border border-amber-100">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <label for="limit_waktu" class="block text-sm font-bold text-amber-900 mb-1">Limit Waktu (Opsional)</label>
                                <p class="text-xs text-amber-700 mb-3">Format: <span class="font-mono">MM:SS.ss</span> (contoh: 01:23.45). Saat ini status waktu: <span class="font-semibold">{{ $pendaftaran->status_waktu === 'NT' ? 'NT (No Time)' : 'Normal' }}</span></p>
                                <input type="text" name="limit_waktu" id="limit_waktu" value="{{ old('limit_waktu', $pendaftaran->status_waktu === 'NT' ? '' : $pendaftaran->limit_waktu) }}"
                                    class="block w-full md:w-1/2 rounded-xl border-amber-200 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-3 px-4 font-mono bg-white"
                                    placeholder="MM:SS.ss">
                            </div>
                            
                            <div class="ml-4 flex flex-col items-end">
                                <button type="button" id="btnAutoMatch" class="inline-flex items-center px-4 py-2 bg-white text-amber-700 border border-amber-200 rounded-lg text-sm font-semibold hover:bg-amber-100 transition-colors shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    Auto Match Waktu
                                </button>
                                <div id="autoMatchStatus" class="mt-2 text-xs font-medium text-right hidden"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-end space-x-4">
                    <a href="{{ route('perkumpulan.dashboard') }}" class="px-6 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-2.5 bg-amber-600 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all transform hover:-translate-y-0.5">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputNama = document.getElementById('nama_atlet');
        const inputTglLahir = document.getElementById('tanggal_lahir');
        const inputGender = document.getElementById('jenis_kelamin');
        const resultsContainer = document.getElementById('autocomplete-results');
        
        const selectKu = document.getElementById('kelompok_umur_id');
        const selectNomor = document.getElementById('nomor_lomba_id');
        
        const inputLimitWaktu = document.getElementById('limit_waktu');
        const btnAutoMatch = document.getElementById('btnAutoMatch');
        const autoMatchStatus = document.getElementById('autoMatchStatus');
        
        const initialNomorId = '{{ old("nomor_lomba_id", $pendaftaran->nomor_lomba_id) }}';

        let timeoutId;

        // 1. Auto-complete Nama Atlet
        inputNama.addEventListener('input', function() {
            clearTimeout(timeoutId);
            const query = this.value.trim();
            
            if (query.length < 2) {
                resultsContainer.classList.add('hidden');
                checkAutoMatchEligibility();
                return;
            }

            timeoutId = setTimeout(() => {
                fetch(`{{ route('perkumpulan.autocomplete.atlet') }}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        resultsContainer.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(atlet => {
                                const div = document.createElement('div');
                                div.className = 'px-4 py-3 hover:bg-amber-50 cursor-pointer border-b border-slate-100 last:border-b-0 transition-colors';
                                div.innerHTML = `
                                    <div class="font-bold text-slate-800">${atlet.nama_atlet}</div>
                                    <div class="text-xs text-slate-500">${atlet.jenis_kelamin.toUpperCase()} | Lahir: ${atlet.tanggal_lahir}</div>
                                `;
                                div.addEventListener('click', () => {
                                    inputNama.value = atlet.nama_atlet;
                                    if(atlet.tanggal_lahir) inputTglLahir.value = atlet.tanggal_lahir;
                                    if(atlet.jenis_kelamin) inputGender.value = atlet.jenis_kelamin;
                                    
                                    resultsContainer.classList.add('hidden');
                                    checkAutoMatchEligibility();
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

        // Hide autocomplete when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target !== inputNama && e.target !== resultsContainer) {
                resultsContainer.classList.add('hidden');
            }
        });

        // 2. Dependent Dropdown (KU -> Nomor Lomba)
        function updateNomorLombaDropdown() {
            const selectedOption = selectKu.options[selectKu.selectedIndex];
            selectNomor.innerHTML = '<option value="">-- Pilih Nomor Lomba --</option>';
            
            if (selectedOption && selectedOption.value) {
                const nomorLomba = JSON.parse(selectedOption.dataset.nomor || '[]');
                const selectedGender = inputGender.value;
                
                nomorLomba.forEach(nomor => {
                    // Filter based on gender
                    if (selectedGender && nomor.jenis_kelamin !== 'campuran' && nomor.jenis_kelamin !== selectedGender) {
                        return;
                    }

                    const option = document.createElement('option');
                    option.value = nomor.id;
                    option.textContent = `${nomor.nama_nomor} (${nomor.jarak}m ${nomor.gaya})`;
                    if (initialNomorId == nomor.id) {
                        option.selected = true;
                    }
                    selectNomor.appendChild(option);
                });
                selectNomor.disabled = false;
                selectNomor.classList.remove('bg-slate-100', 'cursor-not-allowed');
                selectNomor.classList.add('bg-slate-50', 'hover:bg-white');
            } else {
                selectNomor.disabled = true;
                selectNomor.classList.add('bg-slate-100', 'cursor-not-allowed');
                selectNomor.classList.remove('bg-slate-50', 'hover:bg-white');
            }
            checkAutoMatchEligibility();
        }

        selectKu.addEventListener('change', updateNomorLombaDropdown);
        inputGender.addEventListener('change', updateNomorLombaDropdown);
        
        // Trigger on load for old data
        if (selectKu.value) {
            updateNomorLombaDropdown();
        }

        // 3. Auto-Match Logic
        function checkAutoMatchEligibility() {
            const nama = inputNama.value.trim();
            const nomorId = selectNomor.value;

            if (nama.length > 0 && nomorId) {
                btnAutoMatch.disabled = false;
            } else {
                btnAutoMatch.disabled = true;
            }
        }

        inputNama.addEventListener('change', checkAutoMatchEligibility);
        selectNomor.addEventListener('change', checkAutoMatchEligibility);

        btnAutoMatch.addEventListener('click', function() {
            const nama = inputNama.value.trim();
            const nomorId = selectNomor.value;

            if (!nama || !nomorId) return;

            btnAutoMatch.disabled = true;
            btnAutoMatch.innerHTML = '<svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mencari...';

            fetch(`{{ route('perkumpulan.autocomplete.waktu') }}?nama_atlet=${encodeURIComponent(nama)}&nomor_lomba_id=${nomorId}`)
                .then(response => response.json())
                .then(data => {
                    autoMatchStatus.classList.remove('hidden');
                    if (data.limit_waktu) {
                        inputLimitWaktu.value = data.limit_waktu;
                        autoMatchStatus.textContent = data.message;
                        autoMatchStatus.className = 'mt-2 text-xs font-medium text-right text-emerald-600';
                    } else {
                        inputLimitWaktu.value = '';
                        autoMatchStatus.textContent = data.message;
                        autoMatchStatus.className = 'mt-2 text-xs font-medium text-right text-amber-600';
                    }
                })
                .catch(error => {
                    console.error('Error auto-match:', error);
                    autoMatchStatus.textContent = 'Gagal melakukan auto-match.';
                    autoMatchStatus.className = 'mt-2 text-xs font-medium text-right text-red-600';
                    autoMatchStatus.classList.remove('hidden');
                })
                .finally(() => {
                    btnAutoMatch.disabled = false;
                    btnAutoMatch.innerHTML = '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg> Auto Match Waktu';
                });
        });
    });
</script>
@endpush
@endsection
