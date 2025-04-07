<nav class="navbar navbar-expand-sm bg-light">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="./">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./even">Even Numbers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./prime">Prime Numbers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./multable">Multiplication Table</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('products_list')}}">Products</a>
            </li>
            @auth
                @if(auth()->user()->hasRole('Customer'))
                <li class="nav-item">
                    <a class="nav-link" href="{{route('purchases.index')}}">My Purchases</a>
                </li>
                @endif
                @can('manage_customers')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('customers.index')}}">Customers Cridits</a>
                </li>
                @endcan
                @can('admin_users')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('users')}}">Users</a>
                </li>
                @endcan
            @endauth
        </ul>
        <ul class="navbar-nav">
            @auth
            <li class="nav-item">
                @if(auth()->user()->hasRole('Customer'))
                <a class="nav-link" href="{{route('profile')}}">
                    {{auth()->user()->name}}
                    <span class="badge bg-success">${{number_format(auth()->user()->customer->credit, 2)}}</span>
                </a>
                @else
                <a class="nav-link" href="{{route('profile')}}">{{auth()->user()->name}}</a>
                @endif
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('do_logout')}}">Logout</a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{route('login')}}">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('register')}}">Register</a>
            </li>
            @endauth
        </ul>
    </div>
</nav>
