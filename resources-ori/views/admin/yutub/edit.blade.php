@extends('layouts.app', ['title' => 'Edit link Youtube - Admin'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <div class="container mx-auto px-6 py-8">

        <div class="p-6 bg-white rounded-md shadow-md">
            <h2 class="text-lg text-gray-700 font-semibold capitalize">EDIT Link Youtube</h2>
            <hr class="mt-4">
            <form action="{{ route('admin.yutub.update', $yutub->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-6 mt-4">

                <div class="row">
                        <div class="col-sm-7">
                            <div>
                                <label class="text-gray-700" for="title">Link Youtube</label>
                                <input class="form-input w-full mt-2 rounded-md bg-gray-200 focus:bg-white" type="text" name="link" value="{{ old('link', $yutub->link) }}">
                                @error('link')
                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                        <div class="px-4 py-2">
                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                        </div>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    
                </div>
                
                <br>

                     

            <br>
        </div>
        <div class="mt-4">
                    <button type="submit" class="px-4 py-2 bg-green-500  text-white rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700">UPDATE</button>
                </div>
            </form>
        </div>
</div>
</div>
        
    </div>
</main>
<script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            });
    </script>
@endsection