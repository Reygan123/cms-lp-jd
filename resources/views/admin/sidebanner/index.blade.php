@extends('layouts.app', ['title' => 'Side Banner'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto">
    <div class="container mx-auto px-6 py-8">
    @foreach ($sidebanners as $q)
        <div class="row mt-4 ">
            <div class="col-md-4 text-center">
                <a href="@foreach($linkdaftars as $ld){{$ld->link}}@endforeach">
                <img src="{{asset('storage/identities/'.$q->image)}}" alt="" class="thumbnails">
                </a>
            </div>
        </div>
    </div>
    <div class="flex mx-10 my-4 justify-end">
    <a href="{{ route('admin.sidebanner.edit', $q->id) }}" class="flex align-items-start bg-indigo-600 px-4 py-2 mx-2 rounded shadow-sm text-xs text-white focus:outline-none"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg><h6 class="mx-2">Edit</h6></a>
    </div>
    @endforeach
</main>

@endsection