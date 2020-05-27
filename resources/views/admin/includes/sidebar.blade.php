<nav class="sidebar sidebar-sticky">
    <div class="sidebar-content  js-simplebar">
        <a class="sidebar-brand px-5" href="{{ url('dashboard') }}">
            <img class="img-fluid" src="{{ asset('assets/img/mpesa.png') }}" alt="mpesa">
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Main
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link font-weight-bold" href="{{ url('dashboard') }}">
                    <i class="align-middle" data-feather="home"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link font-weight-bold" href="{{ url('shortcode') }}">
                    <i class="align-middle" data-feather="pocket"></i> <span class="align-middle">Shortcode</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link font-weight-bold" href="{{ url('services') }}">
                    <i class="align-middle" data-feather="layers"></i> <span class="align-middle">Services</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link font-weight-bold" href="{{ url('transaction') }}">
                    <i class="align-middle" data-feather="briefcase"></i>
                    <span class="align-middle">Transactions</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#dashboards" data-toggle="collapse" class="font-weight-bold sidebar-link collapsed">
                    <i class="align-middle" data-feather="shield"></i>
                    <span class="align-middle">Financial Services</span>
                </a>
                <ul id="dashboards" class="sidebar-dropdown list-unstyled collapse ">
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ url("bulk_dispersement") }}">Bulk Dispersment</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ url("refund") }}">Refund</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ url("account_balance") }}">Account Balance</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" href="{{ url("b2b") }}">B2B</a></li>
                </ul>
            </li>
            <li class="sidebar-header">
               Users
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link font-weight-bold" href="{{ url("users") }}">
                    <i class="align-middle" data-feather="book-open"></i> <span class="align-middle">User Management</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link font-weight-bold" href="{{ url("profile") }}">
                    <i class="align-middle" data-feather="book-open"></i> <span class="align-middle">Profile</span>
                </a>
            </li>
            <li class="sidebar-header">
                Settings
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link font-weight-bold" href="{{ url("documentation") }}">
                    <i class="align-middle" data-feather="book-open"></i> <span class="align-middle">Documentation</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
