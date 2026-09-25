<section class="profil-menu">
    <div class="container">
        <ul id="menu-profil" class="profil-menu-ul">
            <li class="{{ (request()->is('benefit')) ? 'current-menu-item' : '' }}">
                <a href="{{route('home')}}/benefit">Manfaat</a>
            </li>
            <li class="{{ (request()->is('story')) ? 'current-menu-item' : '' }}">
                <a href="{{route('home')}}/story">Kisah Sukses</a>
            </li>
            <li class="{{ (request()->is('member')) ? 'current-menu-item' : '' }}">
                <a href="{{route('home')}}/member">Data Anggota</a>
            </li>
            <li class="{{ (request()->is('formdaftar')) ? 'current-menu-item' : '' }}">
                <a href="{{route('home')}}/formdaftar">Join Anggota</a>
            </li>
        </ul>
    </div>
</section>