@extends('layouts.frontapp', ['title' => 'Berita Terkini'])

@section('content')
@include('front.component.breadcrumb')

<section class="section-lgx pbmit-blog-column-three">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 blog-right-col">
                <div class="row pbmit-element-posts-wrapper">
                    @foreach($posts as $a)
                    <article class="pbmit-blog-style-1 col-md-6">
                        <div class="post-item">
                            <div class="pbminfotech-box-content">
                                <div class="pbmit-featured-container">
                                    <div class="pbmit-featured-img-wrapper">
                                        <div class="pbmit-featured-wrapper">
                                            <img src="{{asset('/storage/posts/'.$a->image)}}" class="img-fluid" alt="{{$a->title}}">
                                        </div>
                                    </div>
                                    <a class="pbmit-blog-btn" href="{{route('post.post.show',$a->slug)}}">
                                        <span class="pbmit-button-icon-wrapper">
                                            <span class="pbmit-button-icon">
                                                <i class="pbmit-base-icon-black-arrow-1"></i>
                                            </span>
                                        </span>
                                    </a>
                                    <div class="pbmit-meta-cat-wrapper pbmit-meta-line">
                                        <div class="pbmit-meta-category">
                                            <a href="{{route('post.post.index',['category'=>$a->category->slug])}}"
                                                rel="category tag">{{ $a->category->name }}</a>
                                        </div>
                                    </div>
                                    <a class="pbmit-link" href="{{route('post.post.show',$a->slug)}}"></a>
                                </div>
                                <div class="pbmit-category-date-wraper d-flex align-items-center">
                                    <div class="pbmit-meta-date-wrapper pbmit-meta-line">
                                        <div class="pbmit-meta-date">
                                            <span class="pbmit-post-date">
                                                <i
                                                    class="pbmit-base-icon-calendar-3"></i>{{date('d M Y', strtotime($a->pub_date))}}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="pbmit-meta-author pbmit-meta-line">
                                        <span class="pbmit-post-author">
                                            <i class="pbmit-base-icon-user-3"></i>{{$a->user->name}}
                                        </span>
                                    </div>
                                </div>
                                <div class="pbmit-content-wrapper">
                                    <h3 class="pbmit-post-title">
                                        <a href="{{route('post.post.show',$a->slug)}}">{{$a->title}}</a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </article>
                    @endforeach

                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        {{ $posts->links() }}
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3 blog-left-col">
                <aside class="sidebar">
                    <aside class="widget widget-search">
                        <h2 class="widget-title">Search</h2>
                        <form class="search-form">
                            <input type="search" name="q" value="{{ request()->query('q') }}"
                                placeholder="Key Words here" required="">
                            <i class="fa fa-search"></i>
                            <button type="submit" class="search-submit"></button>
                        </form>
                    </aside>
                    <aside class="widget widget-categories">
                        <h2 class="widget-title">Categories</h2>
                        <ul>
                           <li>
                           <span class="pbmit-cat-li">
                                    <a href="{{route('post.post.index')}}">All</a>
                                </span>
                           </li>
                           @foreach($categories as $category)
                            <li>
                                <span class="pbmit-cat-li">
                                    <a href="{{route('post.post.index',['category'=>$category->slug])}}">{{$category->name}}</a>
                                </span>
                            </li>
                            @endforeach
                        </ul>
                    </aside>
                    <aside class="widget widget-recent-post">
                        <h2 class="widget-title">Agenda Terdekat </h2>
                        <ul class="recent-post-list">
                            @foreach($agendas as $agenda)
                            <li class="recent-post-list-li">
                                <a class="recent-post-thum" href="{{route('agenda.agenda.show',$agenda->slug)}}">
                                    <img src="{{asset('storage/agendas/'.$agenda->image)}}" class="img-fluid" alt="">
                                </a>
                                <div class="pbmit-rpw-content">
                                    <span class="pbmit-rpw-date">
                                        <a
                                            href="{{route('agenda.agenda.show',$agenda->slug)}}">{{date('d M Y', strtotime($agenda->start_date))}}</a>
                                    </span>
                                    <span class="pbmit-rpw-title">
                                        <a href="{{route('agenda.agenda.show',$agenda->slug)}}">{{$agenda->title}}</a>
                                    </span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </aside>
                    <div class="mt-4">
                        @include('front.component.banner')
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>



@endsection