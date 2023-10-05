<!-- need to remove -->
{{-- <li class="nav-item">
    <a href="" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li> --}}
<li class="nav-item">
    <a href="{{ route('users.index') }}" class="nav-link {{ Request::is('user') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user"></i>
        <p>User</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('category.index') }}" class="nav-link {{ Request::is('category') ? 'active' : '' }}">
        <i class="nav-icon fas fa-th"></i>
        <p>Category</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('blogs.index') }}" class="nav-link {{ Request::is('blogs') ? 'active' : '' }}">
        <i class="nav-icon fas fa-th"></i>
        <p>Blogs</p>
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
    <a href="{{ route('tag.index') }}" class="nav-link {{ Request::is('tag') ? 'active' : '' }}">
        <i class="nav-icon fas fa-th"></i>
        <p>Tags</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('permission.index') }}" class="nav-link {{ Request::is('permission') ? 'active' : '' }}">
        <i class="nav-icon fas fa-th"></i>
        <p>Permissions</p>
    </a>
</li>
