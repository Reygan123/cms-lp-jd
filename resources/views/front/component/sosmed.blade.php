<div class="topnav">
    @foreach ($identities as $q)
    <a href="https://www.facebook.com/{{$q->fb}}"><i class="fa-brands fa-facebook"></i></a>
    <a href="https://www.instagram.com/{{$q->ig}}"><i class="fa-brands fa-instagram"></i></a>
    <a href="https://www.tiktok.com/{{$q->tt}}"><i class="fa-brands fa-youtube"></i></a>
    <a href="https://www.youtube.com/{{$q->yt}}"><i class="fa-brands fa-tiktok"></i></a>
    @endforeach
   
</div>