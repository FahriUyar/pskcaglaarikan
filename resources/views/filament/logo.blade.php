@php
    $logo = null;
    $brandName = 'Psk. Çağla Arıkan';
    try {
        if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
            $logo = \App\Models\Setting::get('logo');
            $siteTitle = \App\Models\Setting::get('site_title');
            if ($siteTitle) {
                $brandName = $siteTitle;
            }
        }
    } catch (\Throwable $e) {}
@endphp

@if($logo)
    <div class="flex items-center justify-center h-full w-full py-1">
        <img src="{{ \Illuminate\Support\Facades\Storage::url($logo) }}" alt="{{ $brandName }}" class="h-10 w-auto max-w-full object-contain" style="max-height: 40px;">
    </div>
@else
    <div class="text-xl font-bold tracking-tight text-primary-600 dark:text-primary-400">
        {{ $brandName }}
    </div>
@endif
