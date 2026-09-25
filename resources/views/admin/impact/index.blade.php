@extends('layouts.app', ['title' => 'impact - Admin'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <div class="container mx-auto px-6 py-8">
        <div class="flex items-center">
            <div class="relative mx-4">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                    <svg class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>
                <form action="{{ route('admin.impact.index') }}" method="GET">
                    <input class="form-input w-full rounded-lg pl-10 pr-4" type="text" name="q" value="{{ request()->query('q') }}"
                    placeholder="Search">
                </form>
            </div>
        </div>

        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block min-w-full shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full table-auto">
                    <thead class="justify-between">
                        <tr class="bg-gray-900 w-full">
                            <th class="px-16 py-2">
                                <span class="text-white">Title 1</span>
                            </th>
                            <th class="px-16 py-2" style="width: 40%">
                                <span class="text-white">Number 1</span>
                            </th>
                            <th class="px-16 py-2" style="width: 40%">
                                <span class="text-white">Title 2</span>
                            </th>
                            <th class="px-16 py-2" style="width: 40%">
                                <span class="text-white">Number 2</span>
                            </th>
                            <th class="px-16 py-2" style="width: 40%">
                                <span class="text-white">Title 3</span>
                            </th>
                            <th class="px-16 py-2" style="width: 40%">
                                <span class="text-white">Number 3</span>
                            </th>
                            <th class="px-16 py-2" style="width: 40%">
                                <span class="text-white">Title 4</span>
                            </th>
                            <th class="px-16 py-2" style="width: 40%">
                                <span class="text-white">Number 4</span>
                            </th>
                            <th class="px-16 py-2">
                                <span class="text-white">AKSI</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-200">
                        @forelse($impact as $item)
                            <tr class="border bg-white">
                                <td class="px-10 py-2 flex justify-center">
                                    {{$item -> title1}}
                                </td>
        
                                <td class="px-5 py-2">
                                    <b>{{ $item-> number1 }}</b>
                                </td>

                                <td class="px-16 py-2">
                                    {{ $item -> title2 }}
                                </td>

                                <td class="px-5 py-2">
                                    <b>{{ $item-> number2 }}</b>
                                </td>

                                <td class="px-16 py-2">
                                    {{ $item-> title3 }}
                                </td>
                                
                                <td class="px-5 py-2">
                                    <b>{{ $item-> number3 }}</b>
                                </td>
                                
                                <td class="px-16 py-2">
                                    {{ $item -> title4 }}
                                </td>
                                
                                <td class="px-5 py-2">
                                    <b>{{ $item-> number4 }}</b>
                                </td>
                                <td class="px-10 py-2 text-center">
                                    <div class="flex">
                                        <a href="{{ route('admin.impact.edit', $item->id) }}" class="bg-indigo-600 px-2 py-2 rounded shadow-sm text-xs text-white focus:outline-none"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg></a>
                                        <button onClick="destroy(this.id)" id="{{ $item->id }}" class="bg-red-600 px-2 py-2 mx-2 rounded shadow-sm text-xs text-white focus:outline-none"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <div class="bg-red-500 text-white text-center p-3 rounded-sm shadow-md">
                                Data Belum Tersedia!
                            </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<script>
    //ajax delete
    function destroy(id) {
        var id = id;
        var token = $("meta[name='csrf-token']").attr("content");

        Swal.fire({
            title: 'APAKAH KAMU YAKIN ?',
            text: "INGIN MENGHAPUS DATA INI!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'BATAL',
            confirmButtonText: 'YA, HAPUS!',
        }).then((result) => {
            if (result.isConfirmed) {
                //ajax delete
                jQuery.ajax({
                    url: `/admin/impact/${id}`,
                    data: {
                        "id": id,
                        "_token": token
                    },
                    type: 'DELETE',
                    success: function (response) {
                        if (response.status == "success") {
                            Swal.fire({
                                icon: 'success',
                                title: 'BERHASIL!',
                                text: 'DATA BERHASIL DIHAPUS!',
                                showConfirmButton: false,
                                timer: 3000
                            }).then(function () {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'GAGAL!',
                                text: 'DATA GAGAL DIHAPUS!',
                                showConfirmButton: false,
                                timer: 3000
                            }).then(function () {
                                location.reload();
                            });
                        }
                    }
                });
            }
        })
    }
</script>

@endsection