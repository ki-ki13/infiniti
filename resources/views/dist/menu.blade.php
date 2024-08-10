<ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
        <a class="nav-link collapsed <?= Request::segment(1) == 'inbound' ? 'active' : '' ?>" href="{{ url('/inbound') }}">
            <i class="bi bi-arrow-down-left-square-fill"></i>
            <span>Inbound</span>
        </a>
    </li><!-- End Inbound -->

    <li class="nav-item">
        <a class="nav-link collapsed <?= Request::segment(1) == 'outbound' ? 'active' : '' ?>" href="{{ url('/outbound') }}">
            <i class="bi bi-arrow-down-right-square-fill"></i>
            <span>Outbound</span>
        </a>
    </li><!-- End Outbound -->
</ul>
