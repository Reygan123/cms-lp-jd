<section class="side-news-event">
    <h5 class="sidebar-title">Berita & Artikel</h5>
    @foreach($posts as $post)
    <a href="{{route('post.post.show',['post'=>$post])}}">{{$post->title}}</a>
                 
                 <hr>
    @endforeach
    <h5 class="sidebar-title">Event Terdekat</h5>
    @foreach($agendas as $agenda)
    <a href="{{route('agenda.agenda.show',['agenda'=>$agenda])}}">{{$agenda->title}}</a>
                 <hr>
    @endforeach
</section>