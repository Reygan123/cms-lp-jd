@extends('layouts.app', ['title' => 'content - Admin'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <div class="container mx-auto px-6 py-8">
        <div class="row">
        @foreach ($content as $item)
        <div class="flex justify-between">
            <h2 class="t-purplee"></h2><a href="{{ route('admin.content.edit', $item->id) }}" class="bg-indigo-600 px-2 py-2 rounded shadow-sm text-xs text-white focus:outline-none"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linecontent="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg></a>
        </div>
          <div class="col-md-7">
            <h1 class="big mb-50">{{$item->title}}</h1>
            <hr>
            {!! $item ->description !!}
            <hr>
          </div>
          <div class="col-md-5">
            <img src="{{asset('storage/contents/'.$item->image)}}" alt="{{$item->title}}" class="thubnails">
          </div>
        @endforeach 
        </div>
    </div>
</main>

@endsection