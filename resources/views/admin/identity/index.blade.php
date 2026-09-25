@extends('layouts.app', ['title' => 'Data Identitas'])

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto min-h-screen">
    <div class="container mx-auto py-8">
    <div class="flex items-center justify-center mt-2">
                <div class="flex items-center">
                    @foreach ($identities as $q)
                    <img src="{{asset('storage/identities/'.$q->image)}}" alt="{{$q->name}}" class="thumbnails" style="width:250px;height:auto;">
                    @endforeach
                </div>
            </div>
      @foreach ($identities as $q)
      <h3 class="text-grey uppercase text-center mt-4">{{$q->name}}</h3>
        <hr>
        <div class="text-center">{!! $q->description !!}</div>
        <div class="row">
          <div class="col-md-5 py-4">
            <table class="table table-striped">
              <tbody>
                <tr>
                  <th scope="row">Phone</th>
                  <td>{{$q->phone}}</td>
                </tr>
                <tr>
                  <th scope="row">Email</th>
                  <td>{{$q->email}}</td>
                </tr>
                <tr>
                  <th scope="row">ID Facebook</th>
                  <td><a href="https://www.facebook.com/{{$q->fb}}">{{$q->fb}}</a></td>
                </tr>
                <tr>
                  <th scope="row">ID Instagram</th>
                  <td><a href="https://www.instagram.com/{{$q->ig}}">{{$q->ig}}</a></td>
                </tr>
                <tr>
                  <th scope="row">ID Tiktok</th>
                  <td><a href="https://www.tiktok.com/{{$q->tt}}">{{$q->tt}}</a></td>
                </tr>
                <tr> 
                  <th scope="row">ID Youtube</th>
                  <td><a href="https://www.youtube.com/{{$q->yt}}">{{$q->yt}}</a></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-7 py-4">
            <h5><b>Alamat:</b></h5>
            <div class="">{!!$q->address!!}</div>
            {!! $q->gmap !!}
          </div>
        </div>
          
        <div class="flex py-4 mx-10 my-4 justify-end">
          <a href="{{ route('admin.identity.edit', $q->id) }}" class="flex align-items-start bg-dark-green px-4 py-2 mx-2 rounded shadow-sm text-xs text-white focus:outline-none"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg><h6 class="mx-2">Edit</h6></a>
        </div>
        @endforeach 
    </div>
</main>

@endsection