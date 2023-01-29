<header class="p-3 text-bg-dark">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <!-- <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-4">ThisMemeExists</span>
        </a> -->

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="#" class="nav-link px-2 text-secondary">Создать</a></li>
          <li><a href="#" class="nav-link px-2 text-white">Features</a></li>
          <li><a href="#" class="nav-link px-2 text-white">Pricing</a></li>
          <li><a href="#" class="nav-link px-2 text-white">FAQs</a></li>
          <li><a href="#" class="nav-link px-2 text-white">About</a></li>
        </ul>

        <div class="text-end">
            @guest("web")
                <a href="{{ route("login") }}" class="btn btn-outline-light me-2">Войти</a>
                <a href="{{ route("register") }}" class="btn btn-warning">Регистрация</a>
            @endguest

            @auth("web")
                <a href="{{ route("logout") }}" class="btn btn-outline-light me-2">Выйти</a>
            @endauth
        </div>
      </div>
    </div>
</header>