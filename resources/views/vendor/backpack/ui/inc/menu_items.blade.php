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

<x-backpack::menu-item title="Nationalities" icon="la la-question" :link="backpack_url('nationality')" />
<x-backpack::menu-item title="States" icon="la la-question" :link="backpack_url('state')" />
<x-backpack::menu-item title="Cities" icon="la la-question" :link="backpack_url('city')" />
<x-backpack::menu-item title="Categories" icon="la la-question" :link="backpack_url('category')" />
<x-backpack::menu-item title="Premium commissions" icon="la la-question" :link="backpack_url('premium-commission')" />
<x-backpack::menu-item title="Free commissions" icon="la la-question" :link="backpack_url('free-commission')" />
<x-backpack::menu-item title="Dynamic pages" icon="la la-question" :link="backpack_url('dynamic-page')" />
<x-backpack::menu-item title="Banners" icon="la la-question" :link="backpack_url('banner')" />