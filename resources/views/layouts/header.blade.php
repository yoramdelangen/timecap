<section class="hero is-medium is-primary is-bold">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Timecap register
            </h1>
            <h2 class="subtitle">
                {{ $title ??'' }}
            </h2>
        </div>
    </div>
</section>
<nav class="nav has-shadow">
    <div class="container">
        <div class="nav-left">
            <a href="/login" class="nav-item is-tab{{ $login ?? '' }}">Login</a>
            <a href="/register" class="nav-item is-tab{{ $register ?? '' }}">Register</a>
        </div>
    </div>
</nav>