{{-- <nav class="mt-5">
<div class="accordion accordion-program d-none d-sm-block" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button1 ">
          <a class="flex menu items-center py-2 mx-4 hover:bg-opacity-25 hover:text-dark-600 {{ Request::is('admin/dashboard*') ? '  text-dark-100' :  'text-dark-600' }}" href="{{ route('admin.dashboard.index') }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"> 
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
              </path>
            </svg>

            <span class="mx-3">Dashboard</span>
          </a>
        </button>
    </h2>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <span class="flex">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                      </svg>

            <span class="mx-4">Pendaftaran</span>
          </span>
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse {{ (request()->is('admin/infodaftar*','admin/prosedur*','admin/tanggalpenting*','admin/faq*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <li class="menu py-2"><a class="menu mt-4 py-2 {{ Request::is('admin/infodaftar*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.infodaftar.index') }}">Info Pendaftaran</a></li>
        <li class="menu py-2"><a class="menu mt-4 py-2 {{ Request::is('admin/prosedur*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.prosedur.index') }}">Prosedur Pendaftaran</a></li>
        <li class="menu py-2"><a class="menu mt-4 py-2 {{ Request::is('admin/tanggalpenting*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.tanggalpenting.index') }}">Tanggal Penting</a></li>
        <li class="menu py-2"><a class="menu mt-4 py-2 {{ Request::is('admin/faq*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.faq.index') }}">FAQ</a></li>
          
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          <span class="flex">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" /></svg>
            <span class="mx-4">Publikasi</span>
          </span>
        </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse {{ (request()->is('admin/category*','admin/post*','admin/agenda*','admin/catatan*')) ? 'show' : '' }}" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
      <div class="accordion-body">
          <li class="menu py-2"><a class="menu mt-4 py-2 {{ Request::is('admin/post*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.post.index') }}">Berita & Artikel</a></li>
          <li class="menu py-2"><a class="menu mt-4 mb-4 py-2 {{ Request::is('admin/agenda*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.agenda.index') }}">Agenda Sekolah </a></li>  
          <li class="menu py-2"><a class="menu mt-4 mb-4 py-2 {{ Request::is('admin/catatan*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.catatan.index') }}">Catatan Ketua Umum </a></li>  
      </div>
    </div>
  </div>

  <div class="accordion-item">
    <h2 class="accordion-header" id="heading4">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
        <span class="flex">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
          </svg>
          <span class="mx-4">Profile</span>
        </span>
      </button>
    </h2>
    <div id="collapse4" class="accordion-collapse collapse {{ (request()->is('admin/sambutan*','admin/unggulan*','admin/about*','admin/visi*','admin/misi*','admin/prestasi*','admin/categoriprestasi*','admin/facility*','admin/program*','admin/testimony*','admin/svg*','admin/ourteam*','admin/seragam*','admin/legal*','admin/partner*' )) ? 'show' : '' }}" aria-labelledby="heading4" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <li class="menu py-2"><a class="menu mt-4 py-2 {{ Request::is('admin/sambutan*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.sambutan.index') }}">Sambutan</a></li>
        <li class="menu py-2"><a class="menu mt-4 py-2 {{ Request::is('admin/about*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.about.index') }}">Tentang Kami</a></li>
        <li class="menu py-2"><a class="menu mt-4 py-2 {{ Request::is('admin/unggulan*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.unggulan.index') }}">Keunggulan</a></li>
        <li class="menu py-2"><a class="menu mt-4 py-2 {{ Request::is('admin/prestasi*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.prestasi.index') }}">Prestasi</a></li>
        <li class="menu py-2"><a class="menu mt-4 py-2 {{ Request::is('admin/facility*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.facility.index') }}">Fasilitas</a></li>
        <li class="menu py-2"><a class="menu mt-4 mb-4 py-2 {{ Request::is('admin/testimony*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.testimony.index') }}">Kata Mereka</a></li>
        <li class="menu py-2"><a class="menu mt-4 mb-4 py-2 {{ Request::is('admin/svg*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.svg.index') }}">Data</a></li>
        <li class="menu py-2"><a class="menu mt-4 mb-4 py-2 {{ Request::is('admin/program*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.program.index') }}">Program</a></li>
        <li class="menu py-2"><a class="menu mt-4 py-2 {{ Request::is('admin/ourteam*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.ourteam.index') }}">Data Tim</a></li>
        <li class="menu py-2"><a class="menu mt-4 mb-4 py-2 {{ Request::is('admin/seragam*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.seragam.index') }}">Seragam Sekolah</a></li>
        <li class="menu py-2"><a class="menu mt-4 mb-4 py-2 {{ Request::is('admin/legal*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.legal.index') }}">Legalitas</a></li>
        <li class="menu py-2"><a class="menu mt-4 mb-4 py-2 {{ Request::is('admin/partner*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.partner.index') }}">Mitra</a></li>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="heading5">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
        <span class="flex">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          <span class="mx-4">Settings</span>
        </span>
      </button>
    </h2>
    <div id="collapse5" class="accordion-collapse collapse {{ (request()->is('admin/identity*','admin/profile*','admin/pixel*','admin/header*','admin/slider*','admin/sidebanner*','admin/ganalytics*','admin/welcomechat*' )) ? 'show' : '' }}" aria-labelledby="heading5" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <li class="menu py-2"><a class="menu mt-4 py-2 {{ Request::is('admin/identity*') ? ' bg-opacity-25 ' :  'text-gray-500' }}"href="{{ route('admin.identity.index') }}">Identitas Lembaga</a></li>
        <li class="menu py-2"><a class="menu mt-4 py-2 {{ Request::is('admin/profile*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.profile.index') }}">Profil Admin</a></li>
        <li class="menu py-2"><a class="menu mt-4 py-2 {{ Request::is('admin/header*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.header.index') }}">Header</a></li>
        <li class="menu py-2"><a class="menu mt-4 py-2 {{ Request::is('admin/slider*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.slider.index') }}">Slider</a></li>
        <li class="menu py-2"><a class="menu mt-4 py-2 {{ Request::is('admin/sidebanner*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.sidebanner.index') }}">Banner</a></li>
        <li class="menu py-2"><a class="menu mt-4 py-2 {{ Request::is('admin/pixel*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.pixel.edit', 1) }}">Kode Pixel</a></li>
        <li class="menu py-2"><a class="menu mt-4 py-2 {{ Request::is('admin/ganalytics*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.ganalytics.edit', 1) }}">Google Analytics</a></li>
        <li class="menu py-2"><a class="menu mt-4 py-2 {{ Request::is('admin/welcomechat*') ? ' bg-opacity-25 ' :  'text-gray-500' }}" href="{{ route('admin.welcomechat.edit', 1) }}">Sapaan WA</a></li>
      </div>
    </div>
  </div>
</div>
</nav>

             --}}


<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label">Navigation</li>
            <li><a href="{{ route('admin.dashboard.index') }}"><i class="mdi mdi-home"></i><span
                        class="nav-text">Home</span></a></li>


            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="mdi mdi-file-document-box"></i><span class="nav-text">Blog & Agenda</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.post.index') }}">Posts</a></li>
                    <li><a href="{{ route('admin.agenda.index') }}">Agenda</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-widgets"></i><span
                        class="nav-text">Services</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.program.index') }}">Programs</a></li>
                    <li><a href="{{ route('admin.unggulan.index') }}">Features</a></li>
                    <li><a href="{{ route('admin.facility.index') }}">Assessments</a></li>
                    <li><a href="{{ route('admin.pricing.index') }}">Pricing</a></li>
                    <li><a href="{{ route('admin.benefit.index') }}">Benefits</a></li>
                    <li><a href="{{ route('admin.testimony.index') }}">Testimonies</a></li>
                    <li><a href="{{ route('admin.portofolio.index') }}">Portofolio</a></li>
                    <li><a href="{{ route('admin.dukungan.index') }}">Supports</a></li>
                    <li><a href="{{ route('admin.faq.index') }}">FAQs</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-widgets"></i><span
                        class="nav-text">Profil</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.about.index') }}">About Us</a></li>
                    <li><a href="{{ route('admin.ourteam.index') }}">Our Teams</a></li>
                    <li><a href="{{ route('admin.svg.edit', 1) }}">Data</a></li>
                    <li><a href="{{ route('admin.legal.index') }}">Legals Document</a></li>
                    <li><a href="{{ route('admin.partner.index') }}">Partners</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="mdi mdi-power-plug"></i><span class="nav-text">Setting</span></a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.identity.edit', 1) }}">Identity</a></li>
                    <li><a href="{{ route('admin.header.index') }}">Header</a></li>
                    <li><a href="{{ route('admin.sidebanner.edit', 1) }}">Side Banner</a></li>
                    <li><a href="{{ route('admin.slider.index') }}">Slider</a></li>
                    <li><a href="{{ route('admin.pixel.edit', 1) }}">Meta Pixel</a></li>
                    <li><a href="{{ route('admin.ganalytics.edit', 1) }}">Google Analytics</a></li>
                    <li><a href="{{ route('admin.welcomechat.edit', 1) }}">Welcome Chat</a></li>
                    <li><a href="{{ route('admin.profile.index') }}">User</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
