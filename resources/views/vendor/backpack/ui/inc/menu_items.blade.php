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
<x-backpack::menu-item title="Advertisements" icon="la la-question" :link="backpack_url('advertisement')" />
<x-backpack::menu-item title="Users" icon="la la-question" :link="backpack_url('user')" />
<x-backpack::menu-item title="Advertisement media" icon="la la-question" :link="backpack_url('advertisement-media')" />

<x-backpack::menu-item title="Contactuses" icon="la la-question" :link="backpack_url('contactus')" />
<x-backpack::menu-item title="Newsletters" icon="la la-question" :link="backpack_url('newsletter')" />
<x-backpack::menu-item title="Payment transactions" icon="la la-question" :link="backpack_url('payment-transaction')" />
<x-backpack::menu-item title="Premium user settings" icon="la la-question" :link="backpack_url('premium-user-setting')" />
<x-backpack::menu-item title="Premium user subscriptions" icon="la la-question" :link="backpack_url('premium-user-subscription')" />
<x-backpack::menu-item title="User ads comments" icon="la la-question" :link="backpack_url('user-ads-comment')" />
<x-backpack::menu-item title="User ads comment follows" icon="la la-question" :link="backpack_url('user-ads-comment-follow')" />
<x-backpack::menu-item title="User ads comment reports" icon="la la-question" :link="backpack_url('user-ads-comment-report')" />
<x-backpack::menu-item title="User ads favourites" icon="la la-question" :link="backpack_url('user-ads-favourite')" />
<x-backpack::menu-item title="User ads offers" icon="la la-question" :link="backpack_url('user-ads-offer')" />
<x-backpack::menu-item title="User ads reports" icon="la la-question" :link="backpack_url('user-ads-report')" />
<x-backpack::menu-item title="User advertisement actions" icon="la la-question" :link="backpack_url('user-advertisement-action')" />
<x-backpack::menu-item title="User commissions" icon="la la-question" :link="backpack_url('user-commission')" />
<x-backpack::menu-item title="Wallet transactions" icon="la la-question" :link="backpack_url('wallet-transaction')" />
<x-backpack::menu-item title="Chats" icon="la la-question" :link="backpack_url('chat')" />
<x-backpack::menu-item title="Chat messages" icon="la la-question" :link="backpack_url('chat-message')" />
<x-backpack::menu-item title="Notifications" icon="la la-question" :link="backpack_url('notification')" />

<x-backpack::menu-dropdown title="Add-ons" icon="la la-puzzle-piece">
    <x-backpack::menu-dropdown-header title="Authentication" />
    <x-backpack::menu-dropdown-item title="Admins" icon="la la-user-secret" :link="backpack_url('admin')" />
    <x-backpack::menu-dropdown-item title="Roles" icon="la la-group" :link="backpack_url('role')" />
    <x-backpack::menu-dropdown-item title="Permissions" icon="la la-key" :link="backpack_url('permission')" />
</x-backpack::menu-dropdown>
<x-backpack::menu-item title='Backups' icon='la la-hdd-o' :link="backpack_url('backup')" />