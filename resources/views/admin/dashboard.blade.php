@extends('layouts.admin')

@section('title', 'Dashboard')
@section('meta_description', 'Ringkasan kinerja App Renang: pendaftaran atlet, event aktif, perkumpulan, dan aktivitas terbaru.')
@section('header_title', 'Dashboard')
@section('header_subtitle', 'Ringkasan aktivitas kejuaraan renang')

@php
    $trendMax   = max($trend->max('total'), 1);
    $trendTotal = $trend->sum('total');
    $genderL    = (int) ($gender['L'] ?? 0);
    $genderP    = (int) ($gender['P'] ?? 0);
    $genderSum  = max($genderL + $genderP, 1);
    $hour       = now()->hour;
    $greeting   = $hour < 11 ? 'Selamat pagi' : ($hour < 15 ? 'Selamat siang' : ($hour < 19 ? 'Selamat sore' : 'Selamat malam'));
    $fmt        = fn ($n) => number_format($n, 0, ',', '.');

    $kpis = [
        [
            'label' => 'Total Pendaftaran', 'value' => $fmt($stats['pendaftaran_total']),
            'meta'  => $fmt($stats['pendaftaran_week']) . ' dalam 7 hari terakhir',
            'trend' => $stats['pendaftaran_trend'],
            'tone'  => 'brand',
            'icon'  => 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108M6.75 7.5h.008v.008H6.75V7.5Zm-1.5 13.5h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H5.25c-.621 0-1.125.504-1.125 1.125v10.5c0 .621.504 1.125 1.125 1.125Z',
        ],
        [
            'label' => 'Event Aktif', 'value' => $fmt($stats['events_active']),
            'meta'  => $fmt($stats['events_open']) . ' pendaftaran dibuka · ' . $fmt($stats['events_total']) . ' total',
            'trend' => null, 'tone' => 'accent',
            'icon'  => 'M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0',
        ],
        [
            'label' => 'Perkumpulan', 'value' => $fmt($stats['clubs_total']),
            'meta'  => $fmt($stats['clubs_active']) . ' akun aktif',
            'trend' => null, 'tone' => 'emerald',
            'icon'  => 'M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z',
        ],
        [
            'label' => 'Atlet Unik', 'value' => $fmt($stats['atlet_unik']),
            'meta'  => $fmt($stats['nt_count']) . ' entri tanpa waktu (NT)',
            'trend' => null, 'tone' => 'sky',
            'icon'  => 'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z',
        ],
    ];

    $tones = [
        'brand'   => 'bg-brand-50 text-brand-700 ring-brand-600/15',
        'accent'  => 'bg-accent-50 text-accent-700 ring-accent-600/20',
        'emerald' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/15',
        'sky'     => 'bg-sky-50 text-sky-700 ring-sky-600/15',
    ];
@endphp

@section('header_actions')
    <a href="{{ route('admin.events.create') }}" class="btn btn-primary hidden sm:inline-flex">
        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Event Baru
    </a>
@endsection

@section('content')
<div class="space-y-6">

    {{-- ============ Welcome banner ============ --}}
    <section aria-labelledby="welcome-heading"
             class="relative overflow-hidden rounded-card bg-gradient-to-br from-brand-800 via-brand-700 to-brand-600 px-5 py-6 text-white shadow-card sm:px-8 sm:py-7 motion-safe:animate-fade-up">
        {{-- decorative waves --}}
        <svg class="pointer-events-none absolute inset-x-0 bottom-0 h-24 w-full text-white/10" viewBox="0 0 1200 120" preserveAspectRatio="none" aria-hidden="true">
            <path fill="currentColor" d="M0 60c100 0 100-30 200-30s100 30 200 30 100-30 200-30 100 30 200 30 100-30 200-30 100 30 200 30v60H0Z"/>
            <path fill="currentColor" opacity=".6" d="M0 85c100 0 100-25 200-25s100 25 200 25 100-25 200-25 100 25 200 25 100-25 200-25 100 25 200 25v35H0Z"/>
        </svg>
        <div class="relative flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
            <div class="max-w-2xl">
                <p class="text-sm font-medium text-brand-100">{{ $greeting }},</p>
                <h2 id="welcome-heading" class="mt-1 text-xl font-bold tracking-tight text-balance sm:text-2xl">
                    {{ auth()->user()->name ?? 'Administrator' }}
                </h2>
                <p class="mt-2 text-sm text-brand-100 text-pretty">
                    Ada <span class="num font-semibold text-white">{{ $fmt($stats['events_open']) }}</span> event dengan pendaftaran dibuka
                    dan <span class="num font-semibold text-white">{{ $fmt($trendTotal) }}</span> pendaftaran baru dalam 14 hari terakhir.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.events.create') }}" class="btn bg-accent-500 text-slate-950 hover:bg-accent-100 focus-visible:outline-white">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Buat Event
                </a>
                <a href="{{ route('admin.import.form') }}" class="btn bg-white/10 text-white ring-1 ring-inset ring-white/25 hover:bg-white/20 focus-visible:outline-white">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/></svg>
                    Import Riwayat
                </a>
            </div>
        </div>
    </section>

    {{-- ============ KPI cards ============ --}}
    <section aria-labelledby="kpi-heading">
        <h2 id="kpi-heading" class="sr-only">Indikator utama</h2>
        <ul role="list" class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach($kpis as $i => $kpi)
                <li class="card group p-5 transition-shadow duration-200 hover:shadow-card-hover motion-safe:animate-fade-up"
                    style="animation-delay: {{ 60 + $i * 50 }}ms">
                    <div class="flex items-start justify-between gap-3">
                        <p class="text-sm font-medium text-ink-muted">{{ $kpi['label'] }}</p>
                        <span class="grid size-10 shrink-0 place-items-center rounded-lg ring-1 ring-inset {{ $tones[$kpi['tone']] }}" aria-hidden="true">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $kpi['icon'] }}"/></svg>
                        </span>
                    </div>
                    <div class="mt-2 flex items-baseline gap-2">
                        <p class="num text-3xl font-semibold tracking-tight text-ink">{{ $kpi['value'] }}</p>
                        @if(!is_null($kpi['trend']))
                            @php $up = $kpi['trend'] >= 0; @endphp
                            <span class="badge {{ $up ? 'badge-success' : 'badge-danger' }}">
                                <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $up ? 'M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25' : 'M4.5 4.5l15 15m0 0V8.25m0 11.25H8.25' }}"/>
                                </svg>
                                <span class="num">{{ $kpi['trend'] > 999 ? '>999' : ($up ? '+' : '') . $kpi['trend'] }}%</span>
                                <span class="sr-only">{{ $up ? 'naik' : 'turun' }} dibanding minggu lalu</span>
                            </span>
                        @endif
                    </div>
                    <p class="mt-1 text-xs text-ink-muted">{{ $kpi['meta'] }}</p>
                </li>
            @endforeach
        </ul>
    </section>

    {{-- ============ Trend + Composition ============ --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        {{-- Trend chart --}}
        <section class="card lg:col-span-8" aria-labelledby="trend-heading">
            <div class="card-header">
                <div>
                    <h2 id="trend-heading" class="card-title">Tren Pendaftaran</h2>
                    <p class="card-subtitle">14 hari terakhir · total <span class="num font-medium text-ink">{{ $fmt($trendTotal) }}</span></p>
                </div>
                <span class="badge badge-info">
                    <span class="size-1.5 rounded-full bg-brand-600" aria-hidden="true"></span>
                    Harian
                </span>
            </div>
            <div class="px-5 pt-6 pb-4">
                <div class="relative">
                    {{-- grid lines --}}
                    <div class="pointer-events-none absolute inset-0 flex flex-col justify-between pb-6" aria-hidden="true">
                        @foreach([1, 0.5, 0] as $g)
                            <div class="flex items-center gap-2">
                                <span class="num w-6 text-right text-[10px] text-slate-400">{{ (int) round($trendMax * $g) }}</span>
                                <span class="h-px flex-1 border-t border-dashed border-slate-200"></span>
                            </div>
                        @endforeach
                    </div>

                    <ol class="relative ml-8 flex h-56 items-end gap-1 sm:gap-2" aria-label="Jumlah pendaftaran per hari">
                        @foreach($trend as $point)
                            @php $h = $point['total'] > 0 ? max(($point['total'] / $trendMax) * 100, 4) : 0; @endphp
                            <li class="group relative flex h-full flex-1 flex-col items-center justify-end pb-6 outline-none"
                                tabindex="0"
                                aria-label="{{ $point['day'] }} {{ $point['label'] }}: {{ $point['total'] }} pendaftaran">
                                {{-- tooltip: hover & keyboard focus --}}
                                <span class="pointer-events-none absolute z-10 -translate-y-2 rounded-md bg-slate-900 px-2 py-1 text-[11px] font-medium whitespace-nowrap text-white opacity-0 shadow-lg transition-opacity duration-150 group-hover:opacity-100 group-focus-visible:opacity-100"
                                      style="bottom: calc({{ $h }}% + 1.5rem - {{ $h * 0.015 }}rem)" aria-hidden="true">
                                    <span class="num">{{ $point['total'] }}</span> · {{ $point['label'] }}
                                </span>
                                <span class="w-full max-w-8 rounded-t-md transition-colors duration-200
                                             {{ $point['total'] > 0 ? 'bg-brand-500 group-hover:bg-brand-700 group-focus-visible:bg-brand-700' : 'bg-slate-200' }}
                                             group-focus-visible:ring-2 group-focus-visible:ring-brand-600 group-focus-visible:ring-offset-2"
                                      style="height: {{ $point['total'] > 0 ? $h : 1.5 }}%" aria-hidden="true"></span>
                                <span class="absolute bottom-0 text-[10px] font-medium text-slate-500 {{ $loop->index % 2 ? 'hidden sm:block' : '' }}" aria-hidden="true">
                                    {{ \Illuminate\Support\Str::before($point['label'], ' ') }}
                                </span>
                            </li>
                        @endforeach
                    </ol>
                </div>
                <p class="mt-2 text-xs text-ink-muted">Arahkan kursor atau fokus (Tab) pada batang untuk melihat detail.</p>
            </div>
        </section>

        {{-- Composition --}}
        <section class="card lg:col-span-4 flex flex-col" aria-labelledby="comp-heading">
            <div class="card-header">
                <div>
                    <h2 id="comp-heading" class="card-title">Komposisi</h2>
                    <p class="card-subtitle">Peserta & status event</p>
                </div>
            </div>
            <div class="flex-1 space-y-6 p-5">
                {{-- Gender split --}}
                <div>
                    <div class="mb-2 flex items-center justify-between text-xs font-medium text-ink-muted">
                        <span>Jenis kelamin peserta</span>
                        <span class="num">{{ $fmt($genderL + $genderP) }}</span>
                    </div>
                    <div class="flex h-3 overflow-hidden rounded-full bg-slate-100" role="img"
                         aria-label="Putra {{ $genderL }} ({{ round($genderL / $genderSum * 100) }}%), Putri {{ $genderP }} ({{ round($genderP / $genderSum * 100) }}%)">
                        <span class="bg-brand-600" style="width: {{ $genderL / $genderSum * 100 }}%"></span>
                        <span class="bg-accent-500" style="width: {{ $genderP / $genderSum * 100 }}%"></span>
                    </div>
                    <dl class="mt-3 grid grid-cols-2 gap-3">
                        <div class="rounded-lg border border-line p-3">
                            <dt class="flex items-center gap-2 text-xs text-ink-muted"><span class="size-2 rounded-sm bg-brand-600" aria-hidden="true"></span>Putra</dt>
                            <dd class="num mt-1 text-lg font-semibold">{{ $fmt($genderL) }} <span class="text-xs font-normal text-ink-muted">{{ round($genderL / $genderSum * 100) }}%</span></dd>
                        </div>
                        <div class="rounded-lg border border-line p-3">
                            <dt class="flex items-center gap-2 text-xs text-ink-muted"><span class="size-2 rounded-sm bg-accent-500" aria-hidden="true"></span>Putri</dt>
                            <dd class="num mt-1 text-lg font-semibold">{{ $fmt($genderP) }} <span class="text-xs font-normal text-ink-muted">{{ round($genderP / $genderSum * 100) }}%</span></dd>
                        </div>
                    </dl>
                </div>

                {{-- Event status bars --}}
                @php
                    $evTotal = max($stats['events_total'], 1);
                    $evRows = [
                        ['Pendaftaran dibuka', $stats['events_open'], 'bg-emerald-500'],
                        ['Aktif', $stats['events_active'], 'bg-brand-500'],
                        ['Draft / nonaktif', $stats['events_total'] - $stats['events_active'], 'bg-slate-400'],
                    ];
                @endphp
                <div>
                    <p class="mb-3 text-xs font-medium text-ink-muted">Status event</p>
                    <ul role="list" class="space-y-3">
                        @foreach($evRows as [$label, $val, $color])
                            <li>
                                <div class="mb-1 flex justify-between text-sm">
                                    <span class="text-ink">{{ $label }}</span>
                                    <span class="num text-ink-muted">{{ $val }}/{{ $stats['events_total'] }}</span>
                                </div>
                                <div class="h-2 overflow-hidden rounded-full bg-slate-100" role="progressbar"
                                     aria-label="{{ $label }}" aria-valuemin="0" aria-valuemax="{{ $stats['events_total'] }}" aria-valuenow="{{ $val }}">
                                    <div class="h-full rounded-full {{ $color }}" style="width: {{ $val / $evTotal * 100 }}%"></div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>
    </div>

    {{-- ============ Upcoming events + Top clubs ============ --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        <section class="card lg:col-span-8 overflow-hidden" aria-labelledby="events-heading">
            <div class="card-header">
                <div>
                    <h2 id="events-heading" class="card-title">Event Mendatang & Berlangsung</h2>
                    <p class="card-subtitle">5 event terdekat berdasarkan tanggal mulai</p>
                </div>
                <a href="{{ route('admin.events.index') }}" class="btn btn-ghost min-h-9 px-3 text-xs">
                    Lihat semua
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                </a>
            </div>

            @if($upcomingEvents->isEmpty())
                <div class="flex flex-col items-center px-6 py-12 text-center">
                    <span class="grid size-12 place-items-center rounded-full bg-slate-100 text-slate-400" aria-hidden="true">
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
                    </span>
                    <p class="mt-3 text-sm font-semibold text-ink">Belum ada event mendatang</p>
                    <p class="mt-1 max-w-sm text-sm text-ink-muted">Buat event kejuaraan baru agar perkumpulan dapat mulai mendaftarkan atlet.</p>
                    <a href="{{ route('admin.events.create') }}" class="btn btn-primary mt-4">Buat Event</a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-line">
                        <caption class="sr-only">Daftar event mendatang dan yang sedang berlangsung</caption>
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="table-th">Event</th>
                                <th scope="col" class="table-th">Tanggal</th>
                                <th scope="col" class="table-th">Status</th>
                                <th scope="col" class="table-th text-right">Peserta</th>
                                <th scope="col" class="table-th w-12"><span class="sr-only">Aksi</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @foreach($upcomingEvents as $event)
                                @php
                                    $today = now()->startOfDay();
                                    if (! $event->is_active) {
                                        [$badge, $status] = ['badge-neutral', 'Draft'];
                                    } elseif ($event->tanggal_mulai && $event->tanggal_mulai->lte($today)) {
                                        [$badge, $status] = ['badge-info', 'Berlangsung'];
                                    } elseif (! $event->isDeadlinePassed()) {
                                        [$badge, $status] = ['badge-success', 'Pendaftaran dibuka'];
                                    } else {
                                        [$badge, $status] = ['badge-warning', 'Pendaftaran ditutup'];
                                    }
                                @endphp
                                <tr class="transition-colors hover:bg-slate-50">
                                    <td class="table-td whitespace-normal min-w-[12rem]">
                                        <p class="line-clamp-1 font-medium text-ink">{{ $event->nama_event }}</p>
                                        <p class="mt-0.5 flex items-center gap-1 text-xs text-ink-muted">
                                            <svg class="size-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                                            <span class="line-clamp-1">{{ $event->lokasi ?? '—' }}</span>
                                        </p>
                                    </td>
                                    <td class="table-td">
                                        <p class="text-sm tabular-nums">{{ $event->tanggal_mulai?->locale('id')->translatedFormat('d M Y') }}</p>
                                        @if($event->deadline_pendaftaran)
                                            <p class="mt-0.5 text-xs text-ink-muted tabular-nums">Batas {{ $event->deadline_pendaftaran->locale('id')->translatedFormat('d M, H:i') }}</p>
                                        @endif
                                    </td>
                                    <td class="table-td"><span class="badge {{ $badge }}">{{ $status }}</span></td>
                                    <td class="table-td num text-right font-medium">{{ $fmt($event->pendaftaran_count) }}</td>
                                    <td class="table-td text-right">
                                        <a href="{{ route('admin.events.show', $event) }}" class="btn-icon size-9" aria-label="Lihat detail {{ $event->nama_event }}">
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        {{-- Top clubs --}}
        <section class="card lg:col-span-4" aria-labelledby="clubs-heading">
            <div class="card-header">
                <div>
                    <h2 id="clubs-heading" class="card-title">Perkumpulan Teraktif</h2>
                    <p class="card-subtitle">Berdasarkan jumlah pendaftaran</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-ghost min-h-9 px-3 text-xs">Semua</a>
            </div>
            @php $clubMax = max($topClubs->max('pendaftaran_count') ?? 0, 1); @endphp
            @if($topClubs->isEmpty())
                <p class="px-5 py-10 text-center text-sm text-ink-muted">Belum ada perkumpulan terdaftar.</p>
            @else
                <ol role="list" class="divide-y divide-slate-100">
                    @foreach($topClubs as $club)
                        <li>
                            <a href="{{ route('admin.users.show', $club) }}" class="flex items-center gap-3 px-5 py-3 transition-colors hover:bg-slate-50 focus-visible:bg-slate-50 focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-brand-600">
                                <span class="num grid size-7 shrink-0 place-items-center rounded-md text-xs font-semibold
                                             {{ $loop->first ? 'bg-accent-100 text-accent-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $loop->iteration }}
                                </span>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="truncate text-sm font-medium text-ink">{{ $club->nama_klub ?: $club->name }}</p>
                                        <span class="num shrink-0 text-sm font-semibold text-ink">{{ $fmt($club->pendaftaran_count) }}</span>
                                    </div>
                                    <div class="mt-1.5 h-1.5 overflow-hidden rounded-full bg-slate-100" aria-hidden="true">
                                        <div class="h-full rounded-full bg-brand-500" style="width: {{ $club->pendaftaran_count / $clubMax * 100 }}%"></div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ol>
            @endif
        </section>
    </div>

    {{-- ============ Recent activity ============ --}}
    <section class="card" aria-labelledby="activity-heading">
        <div class="card-header">
            <div>
                <h2 id="activity-heading" class="card-title">Aktivitas Terbaru</h2>
                <p class="card-subtitle">Jejak audit perubahan data</p>
            </div>
            <a href="{{ route('admin.audit-log') }}" class="btn btn-ghost min-h-9 px-3 text-xs">
                Audit Log
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
            </a>
        </div>
        @if($recentActivities->isEmpty())
            <p class="px-5 py-10 text-center text-sm text-ink-muted">Belum ada aktivitas tercatat.</p>
        @else
            <ul role="list" class="grid grid-cols-1 divide-y divide-slate-100 md:grid-cols-2 md:divide-y-0">
                @foreach($recentActivities as $log)
                    @php
                        $action = strtolower((string) $log->action);
                        $tone = str_contains($action, 'delete') || str_contains($action, 'hapus') ? 'badge-danger'
                              : (str_contains($action, 'create') || str_contains($action, 'store') || str_contains($action, 'tambah') ? 'badge-success'
                              : (str_contains($action, 'update') || str_contains($action, 'override') || str_contains($action, 'edit') ? 'badge-warning' : 'badge-neutral'));
                        $actor = $log->user?->nama_klub ?: ($log->user?->name ?? 'Sistem');
                    @endphp
                    <li class="flex items-start gap-3 px-5 py-3.5 md:border-b md:border-slate-100 md:odd:border-r">
                        <span class="grid size-8 shrink-0 place-items-center rounded-full bg-slate-100 text-xs font-semibold text-slate-600" aria-hidden="true">
                            {{ mb_strtoupper(mb_substr($actor, 0, 1)) }}
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm text-ink">
                                <span class="font-medium">{{ $actor }}</span>
                                <span class="badge {{ $tone }} ml-1 align-middle">{{ \Illuminate\Support\Str::headline($log->action) }}</span>
                            </p>
                            <p class="mt-0.5 truncate text-xs text-ink-muted">
                                {{ class_basename($log->model_type ?? '') ?: 'Data' }}
                                @if($log->model_id) <span class="num">#{{ $log->model_id }}</span> @endif
                                · <time datetime="{{ $log->created_at?->toIso8601String() }}">{{ $log->created_at?->locale('id')->diffForHumans() }}</time>
                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
</div>
@endsection
