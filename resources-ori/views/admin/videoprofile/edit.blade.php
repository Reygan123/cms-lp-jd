@extends('layouts.app', ['title' => 'Edit Video Profil - Admin'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <div class="container mx-auto px-6 py-8">

        <div class="p-6 bg-white rounded-md shadow-md">
            <h2 class="text-lg text-gray-700 font-semibold capitalize">EDIT VIDEO PROFIL</h2>
            <hr class="mt-4">
            <form action="{{ route('admin.videoprofile.update',$videoprofile->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-6 mt-4">

                <div class="row">
                        <div class="">
                            <div class="mb-4">
                                <label class="text-gray-700" for="videoprofile">ID Video Profile</label>
                                <input class="form-input w-full mt-2 rounded-md bg-gray-200 focus:bg-white" type="text" name="videoprofile" value="{{ old('videoprofile', $videoprofile->videoprofile) }}">
                                @error('videoprofile')
                                    <div class="w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                                        <div class="px-4 py-2">
                                            <p class="text-gray-600 text-sm">{{ $message }}</p>
                                        </div>
                                    </div>
                                @enderror
                            </div>
                            <div class="mt-4">
                            <iframe id="ais" width="100%" height="450px" src="https://www.youtube-nocookie.com/embed/{{$videoprofile->videoprofile}}" title="YouTube video player" frameborder="5" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; " allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>

                    
                </div>
                
                <br>

                     

            <br>
        </div>
        <div class="flex justify-end mt-4">
                    <button type="submit" class="px-4 py-2 bg-indigo-600  text-white rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700">UPDATE</button>
                </div>
            </form>
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