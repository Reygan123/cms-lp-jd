@php
    $translationRecord = null;
    foreach (get_defined_vars() as $candidate) {
        if ($candidate instanceof \Illuminate\Database\Eloquent\Model && $candidate->exists && isset(config('content_translations')[$candidate->getTable()])) {
            $translationRecord = $candidate;
            break;
        }
    }
@endphp
@if($translationRecord)
    <aside class="container pt-3" aria-label="Terjemahan konten">
        <a class="btn btn-outline-primary" href="{{ route('admin.translations.edit', [$translationRecord->getTable(), $translationRecord->getKey()]) }}">Edit versi English untuk data ini</a>
        <p class="small mt-2">Simpan perubahan Indonesia sebelum membuka editor English.</p>
    </aside>
@endif
