@extends('layouts.app', ['title' => 'Welcome Messages '])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @foreach ($sambutans as $sambutan)
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">
                                                Welcome Message
                                            </h4>
                                            <p class="m-0 subtitle">{{ $sambutan->name }} | {{ $sambutan->title }}</p>
                                            <div class="card-text">
                                                @if ($sambutan->video)
                                                    <iframe width="100%" height="315"
                                                        src="https://www.youtube.com/embed/{{ $sambutan->video }}"
                                                        title="Sambutan" frameborder="0"
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                        allowfullscreen></iframe>
                                                @else
                                                    
                                                @endif
                                                <div class="mt-4">
                                                    {!! $sambutan->description !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <img src="{{ asset('storage/identities/' . $sambutan->image) }}" alt=""
                                                class="thumbnails">
                                        </div>
                                    </div>
                                </div>
                                <div class="btn-center mt-4 mb-4">
                                    <div class="flex">
                                        <a href="{{ route('admin.sambutan.edit', $sambutan->id) }}"
                                            class="btn btn-primary btn btn-rounded"><span
                                                class="btn-icon-left text-primary"><i
                                                    class="fa-solid fa-pen-to-square"></i></span>Edit</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
