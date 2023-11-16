<!-- need to remove -->

<li class="nav-item">
    <a href="{{ route('home.index') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>


@if (in_array('Admin', array_column(Auth::user()->roles->toArray(), 'name')))
    <li class="nav-item">
        <a href="{{ route('users.index') }}" class="nav-link {{ Request::is('user') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user"></i>
            <p>User</p>
        </a>
    </li>
@endif

<li class="nav-item">
    <a href="{{ route('category.index') }}" class="nav-link {{ Request::is('category') ? 'active' : '' }}">
        <i class="nav-icon fas fa-th"></i>
        <p>Category</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('topic.index') }}" class="nav-link {{ Request::is('topic') ? 'active' : '' }}">
        <i class="nav-icon fas fa-th"></i>
        <p>Topic</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('course.index') }}" class="nav-link {{ Request::is('course') ? 'active' : '' }}">
        <i class="nav-icon fas fa-th"></i>
        <p>Course</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('blogs.index') }}" class="nav-link {{ Request::is('blogs') ? 'active' : '' }}">
        <i class="nav-icon fas fa-th"></i>
        <p>Blog</p>
    </a>
</li>
@if (in_array('Admin', array_column(Auth::user()->roles->toArray(), 'name')))
    <li class="nav-item">
        <a href="{{ route('tag.index') }}" class="nav-link {{ Request::is('tag') ? 'active' : '' }}">
            <i class="nav-icon fas fa-th"></i>
            <p>Tag</p>
        </a>
    </li>
@endif
@if (in_array('Admin', array_column(Auth::user()->roles->toArray(), 'name')))
    <li class="nav-item">
        <a href="{{ route('roles.index') }}" class="nav-link {{ Request::is('roles') ? 'active' : '' }}">
            <i class="nav-icon fas fa-th"></i>
            <p>Role</p>
        </a>
    </li>
@endif
@if (in_array('Admin', array_column(Auth::user()->roles->toArray(), 'name')))
    <li class="nav-item">
        <a href="{{ route('permission.index') }}" class="nav-link {{ Request::is('permission') ? 'active' : '' }}">
            <i class="nav-icon fas fa-th"></i>
            <p>Permission</p>
        </a>
    </li>
@endif
@if (in_array('Admin', array_column(Auth::user()->roles->toArray(), 'name')))
    <li class="nav-item">
        <a href="{{ route('module.index') }}" class="nav-link {{ Request::is('module') ? 'active' : '' }}">
            <i class="nav-icon fas fa-th"></i>
            <p>Module</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('jobs.index') }}" class="nav-link {{ Request::is('jobs') ? 'active' : '' }}">
            <i class="nav-icon fas fa-th"></i>
            <p>Jobs</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('failed_jobs.index') }}" class="nav-link {{ Request::is('failed_jobs') ? 'active' : '' }}">
            <i class="nav-icon fas fa-th"></i>
            <p>Failed_Jobs</p>
        </a>
    </li>
@endif
