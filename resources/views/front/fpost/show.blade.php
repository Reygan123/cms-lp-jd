@extends('layouts.frontapp', ['title' => $post->title])

@section('content')
@include('front.component.breadcrumb')

<section class="site_content blog-details">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 blog-right-col">
                <div class="row">
                    <div class="col-md-12">
                        <article>
                            <div class="post blog-classic">
                                <div class="pbmit-featured-img-wrapper">
                                    <div class="pbmit-featured-wrapper">
                                        <img src="{{asset('/storage/posts/'.$post->image)}}" class="img-fluid" alt="">
                                    </div>
                                    <span class="pbmit-meta pbmit-meta-cat">
                                        <a href="{{route('post.post.index',['category'=>$post->category->slug])}}"
                                            rel="category tag">{{$post->category->name}}</a>
                                    </span>
                                </div>
                                <div class="pbmit-blog-classic-inner">
                                    <div class="pbmit-blog-meta pbmit-blog-meta-top">
                                        <span class="pbmit-meta pbmit-meta-date">
                                            <i class="pbmit-base-icon-calendar-3"></i>
                                            <time class="entry-date published"
                                                datetime="2023-08-29T09:05:54+00:00">{{date('d M Y', strtotime($post->pub_date))}}</time>
                                        </span>
                                        <span class="pbmit-meta pbmit-meta-author">
                                            <i class="pbmit-base-icon-user-3"></i>by
                                            <a class="pbmit-author-link"
                                                href="blog-details.html">{{$post->user->name}}</a>
                                        </span>
                                    </div>
                                    <div class="pbmit-entry-content">
                                        <h2 class="pbmit-post-title">{{$post->title}}</h2>
                                        <div class="list-endar">{!!$post->content!!}</p>
                                        </div>
                                    </div>
                                    <nav class="navigation post-navigation" aria-label="Posts">
                                        <div class="nav-links">
                                            <div class="nav-previous">
                                                @if ($previousPost)
                                                <a href="{{ route('post.post.show', $previousPost->slug) }}" rel="prev">
                                                    <span class="pbmit-post-nav-icon">
                                                        <i class="pbmit-base-icon-left-arrow-1"></i>
                                                        <span class="pbmit-post-nav-head">Previous Post</span>
                                                    </span>
                                                    <span class="pbmit-post-nav-wrapper">
                                                        <span
                                                            class="pbmit-post-nav nav-title">{{ $previousPost->title }}</span>
                                                    </span>
                                                </a>
                                                @endif
                                            </div>
                                            <div class="nav-next">
                                                @if ($nextPost)
                                                <a href="{{ route('post.post.show', $nextPost->slug) }}" rel="next">
                                                    <span class="pbmit-post-nav-icon">
                                                        <span class="pbmit-post-nav-head">Next Post</span>
                                                        <i class="pbmit-base-icon-next"></i>
                                                    </span>
                                                    <span class="pbmit-post-nav-wrapper">
                                                        <span
                                                            class="pbmit-post-nav nav-title">{{ $nextPost->title }}</span>
                                                    </span>
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                    </nav>
                        </article>

                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3 blog-left-col">
                <aside class="sidebar">
                    <div class="mb-5">
                        @include('front.component.banner')
                    </div>
                    <aside class="widget widget-recent-post">
                        <h2 class="widget-title">Blog Terkini </h2>
                        <ul class="recent-post-list">
                            @foreach($posts as $p)
                            <li class="recent-post-list-li">
                                <a class="recent-post-thum" href="{{route('post.post.show',$p->slug)}}">
                                    <img src="{{asset('storage/posts/'.$p->image)}}" class="img-fluid" alt="">
                                </a>
                                <div class="pbmit-rpw-content">
                                    <span class="pbmit-rpw-date">
                                        <a
                                            href="{{route('post.post.show',$p->slug)}}">{{date('d M Y', strtotime($p->pub_date))}}</a>
                                    </span>
                                    <span class="pbmit-rpw-title">
                                        <a href="{{route('post.post.show',$p->slug)}}">{{$p->title}}</a>
                                    </span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
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
                                    <a
                                        href="{{route('post.post.index',['category'=>$category->slug])}}">{{$category->name}}</a>
                                </span>
                            </li>
                            @endforeach
                        </ul>
                    </aside>


                    <aside class="widget widget-recent-post mt-4">
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
            </div>
        </div>
    </div>
</section>


@endsection