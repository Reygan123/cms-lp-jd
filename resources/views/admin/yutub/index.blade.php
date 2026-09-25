@extends('layouts.app', ['title' => 'Video - Admin'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <div class="container mx-auto px-6 py-8">
        <h4 class="text-grey">Video Profil</h4>
            <hr>
        <div class="card mb-5">
            <div class="row">
            @foreach ($yutub as $item)
                <div class="col-md-6 mt-5 p-4">
                    <iframe id="ais" width="100%" height="100%" src="https://www.youtube-nocookie.com/embed/{{$item->link}}" title="YouTube video player" frameborder="5" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; " allowfullscreen></iframe>
                    <div class="card-body">
                        <a href="{{ route('admin.yutub.edit', $item->id) }}" class="flex align-items-start bg-indigo-600 px-4 py-2 mx-2 rounded shadow-sm text-xs text-white focus:outline-none"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg><h6 class="mx-2">Edit</h6></a>
                     </div>
             </div>
             @endforeach
         </div> 
    </div>
</main>

@endsection