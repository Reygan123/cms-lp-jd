@extends('layouts.app', ['title' => 'Edit Terjemahan Konten'])
@section('content')
<main class="container py-4">
    <a href="{{ route('admin.translations.index', ['resource' => $resource]) }}">Kembali ke daftar terjemahan</a>
    <h1 class="mt-3">Terjemahan {{ config('content_translation_labels.'.$resource, $resource) }} #{{ $record->id }}</h1>
    @if(session('success'))<div class="alert alert-success" role="status">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>@endif
    @unless($ready)<div class="alert alert-warning">Migrasi bilingual belum diterapkan.</div>@endunless
    @if($status['needs_review'])<div class="alert alert-warning">Versi Inggris belum dikonfirmasi untuk sumber Indonesia saat ini. Periksa lalu simpan.</div>@endif
    <p>Field Inggris boleh kosong. Website akan menggunakan Indonesia untuk field tersebut. Nama, tautan, harga, dan data transaksi digunakan bersama.</p>
    <form action="{{ route('admin.translations.update', [$resource, $record->id]) }}" method="POST">
        @csrf @method('PUT')
        <input type="hidden" name="source_hash" value="{{ \App\Support\ContentTranslation::hash($source) }}">
        <div class="mb-3" role="group" aria-label="Bahasa editor">
            <button type="button" class="btn btn-outline-primary" data-translation-tab="id" aria-pressed="false">Indonesia (sumber)</button>
            <button type="button" class="btn btn-primary" data-translation-tab="en" aria-pressed="true">English</button>
        </div>
        <section data-translation-panel="id" hidden lang="id">
            @foreach($source as $field => $value)
                <label for="source-{{ $field }}">{{ ucfirst(str_replace('_', ' ', $field)) }} · Indonesia</label>
                <textarea id="source-{{ $field }}" class="form-control mb-3" rows="5" readonly>{{ is_array($value) ? implode("\n", $value) : $value }}</textarea>
            @endforeach
        </section>
        <section data-translation-panel="en" lang="en">
            @foreach($source as $field => $value)
                @if(is_array($value))
                    <fieldset><legend>{{ ucfirst($field) }}</legend>
                    @foreach($value as $index => $item)
                        <label for="english-{{ $field }}-{{ $index }}">{{ $item }}</label>
                        <input id="english-{{ $field }}-{{ $index }}" class="form-control mb-3" name="english[{{ $field }}][{{ $index }}]" value="{{ old('english.'.$field.'.'.$index, $english[$field][$index] ?? '') }}">
                    @endforeach
                    </fieldset>
                @else
                    <label for="english-{{ $field }}">{{ ucfirst(str_replace('_', ' ', $field)) }} · English</label>
                    <p class="small text-muted" lang="id">{{ \Illuminate\Support\Str::limit(strip_tags((string)$value), 240) }}</p>
                    <textarea id="english-{{ $field }}" class="form-control mb-3 {{ preg_match('/content|description|greating/', $field) ? 'translation-rich-text' : '' }}" name="english[{{ $field }}]" rows="5">{{ old('english.'.$field, $english[$field] ?? '') }}</textarea>
                @endif
            @endforeach
        </section>
        <button type="submit" class="btn btn-primary mt-3" @disabled(!$ready)>Simpan terjemahan Inggris</button>
    </form>
</main>
<script>
document.querySelectorAll('[data-translation-tab]').forEach(button => button.addEventListener('click', () => {
    document.querySelectorAll('[data-translation-panel]').forEach(panel => panel.hidden = panel.dataset.translationPanel !== button.dataset.translationTab);
    document.querySelectorAll('[data-translation-tab]').forEach(tab => {
        tab.setAttribute('aria-pressed', String(tab === button));
        tab.classList.toggle('btn-primary', tab === button);
        tab.classList.toggle('btn-outline-primary', tab !== button);
    });
}));
document.querySelectorAll('.translation-rich-text').forEach(element => {
    if (typeof ClassicEditor !== 'undefined') ClassicEditor.create(element).catch(() => {});
});
</script>
@endsection
