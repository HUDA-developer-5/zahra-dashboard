<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('dashboard') }}">
        <i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('admin') }}">
        <i class="la la-home nav-icon"></i> Admins
    </a>
</li>
<x-backpack::menu-item title="Users" icon="la la-question" :link="backpack_url('user')"/>
