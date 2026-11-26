@extends('layouts.app', ['title' => 'Terjemahan Konten'])
@section('content')
<main class="container py-4">
    <h1>Terjemahan Konten</h1>
    <p>Pilih data yang sudah dibuat, lalu isi versi Inggris. Data Indonesia tetap dikelola melalui menu konten asal.</p>
    @unless($ready)<div class="alert alert-warning">Migrasi bilingual belum diterapkan. Editor belum dapat menyimpan terjemahan.</div>@endunless
    <form method="GET" class="mb-4">
        <label for="translation-resource">Jenis konten</label>
        <select id="translation-resource" name="resource" class="form-control">
            @foreach($resources as $name => $definition)
                <option value="{{ $name }}" @selected($table === $name)>{{ config('content_translation_labels.'.$name, $name) }}</option>
            @endforeach
        </select>
        <label for="translation-search" class="mt-2">Cari teks Indonesia</label>
        <input id="translation-search" class="form-control" name="q" value="{{ request('q') }}" maxlength="200">
        <button class="btn btn-primary mt-2" type="submit">Tampilkan</button>
    </form>
    <div class="table-responsive"><table class="table">
        <thead><tr><th scope="col">Konten Indonesia</th><th scope="col">Status Inggris</th><th scope="col">Tindakan</th></tr></thead>
        <tbody>
        @forelse($records as $record)
            @php($status = \App\Support\ContentTranslation::metadata($record, $fields))
            <tr>
                <td>{{ \Illuminate\Support\Str::limit(strip_tags((string)($record->title ?? $record->name ?? $record->question ?? $record->source ?? $record->description ?? 'Data #'.$record->id)), 100) }}</td>
                <td>{{ count($status['fallback_fields']) ? 'Belum lengkap' : 'Lengkap' }}{{ $status['needs_review'] ? ' · Perlu diperiksa' : '' }}</td>
                <td><a href="{{ route('admin.translations.edit', [$table, $record->id]) }}">Edit terjemahan #{{ $record->id }}</a></td>
            </tr>
        @empty<tr><td colspan="3">Belum ada konten.</td></tr>@endforelse
        </tbody>
    </table></div>
    {{ $records->links() }}
</main>
@endsection
