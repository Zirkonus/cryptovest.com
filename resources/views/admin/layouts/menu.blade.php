@if ($currentUser->isAdmin() || $currentUser->isSuperAdmin() || $currentUser->isEditor() || $currentUser->isAuthor())
    <li {!! (Request::is('admin') ? 'class="active"' : '') !!}>
    <a href="/admin">
        <i class="fa fa-dashboard fa-lg"></i>
        <span class="title">Dashboard</span>
    </a>
</li>
@endif
@if ($currentUser->isAdmin() || $currentUser->isSuperAdmin() || $currentUser->isEditor() || $currentUser->isAuthor())
    <li {!! (Request::is('/admin/site-statistics') ? 'class="active"' : '') !!}>
    <a href="/admin/site-statistics">
        <i class="fa fa-bar-chart fa-lg"></i>
        <span class="title">Statistic</span>
    </a>
</li>
@endif
@if (!$currentUser->isEmptyRole())

@if ($currentUser->isAdmin() || $currentUser->isSuperAdmin() || $currentUser->isEditor() || $currentUser->isAuthor())
    <li {!! (Request::is('admin/categories') || Request::is('admin/categories/create') || Request::is('admin/categories/*') ? 'class="active"' : '') !!}>
    <a href="#">
        <i class="fa fa-list fa-lg"></i>
        <span class="title">Categories</span>
        <span class="fa arrow"></span>
    </a>
    <ul class="sub-menu">
        <li {!! (Request::is('admin/categories') ? 'class="active" id="active"' : '') !!}>
            <a href="{{ URL::to('admin/categories') }}">
                <i class="fa fa-angle-double-right"></i>
                List
            </a>
        </li>
        <li {!! (Request::is('admin/categories/create') ? 'class="active" id="active"' : '') !!}>
            <a href="{{ URL::to('admin/categories/create') }}">
                <i class="fa fa-angle-double-right"></i>
                Add New
            </a>
        </li>
    </ul>
</li>
@endif

@if ($currentUser->isAdmin() || $currentUser->isSuperAdmin() || $currentUser->isEditor() || $currentUser->isAuthor())
    <li {!! (Request::is('admin/tags') || Request::is('admin/tags/create') || Request::is('admin/tags/*') ? 'class="active"' : '') !!}>
    <a href="#">
        <i class="fa fa-tags  fa-lg"></i>
        <span class="title">Tags</span>
        <span class="fa arrow"></span>
    </a>
    <ul class="sub-menu">
        <li {!! (Request::is('admin/tags') ? 'class="active" id="active"' : '') !!}>
            <a href="{{ URL::to('admin/tags') }}">
                <i class="fa fa-angle-double-right"></i>
                List
            </a>
        </li>
        <li {!! (Request::is('admin/tags/create') ? 'class="active" id="active"' : '') !!}>
            <a href="{{ URL::to('admin/tags/create') }}">
                <i class="fa fa-angle-double-right"></i>
                Add New
            </a>
        </li>
    </ul>
</li>
@endif

@if ($currentUser->isAdmin() || $currentUser->isSuperAdmin() || $currentUser->isEditor() || $currentUser->isAuthor())
    <li {!! (Request::is('admin/posts') || Request::is('admin/posts/create') || Request::is('admin/labels') || Request::is('admin/posts/*') ? 'class="active"' : '') !!}>
    <a href="#">
        <i class="fa fa-edit"></i>
        <span class="title">Posts</span>
        <span class="fa arrow"></span>
    </a>
    <ul class="sub-menu">
        <li {!! (Request::is('admin/posts') ? 'class="active" id="active"' : '') !!}>
            <a href="{{ URL::to('admin/posts') }}">
                <i class="fa fa-angle-double-right"></i>
                List
            </a>
        </li>
        <li {!! (Request::is('admin/posts/create') ? 'class="active" id="active"' : '') !!}>
            <a href="{{ URL::to('admin/posts/create') }}">
                <i class="fa fa-angle-double-right"></i>
                Add New
            </a>
        </li>
        <li {!! (Request::is('admin/labels') ? 'class="active" id="active"' : '') !!}>
            <a href="{{ URL::to('admin/labels') }}">
                <i class="fa fa-angle-double-right"></i>
                Labels
            </a>
        </li>
    </ul>
</li>
@endif

@if ($currentUser->isAdmin() || $currentUser->isSuperAdmin())
    <li {!! (Request::is('admin/pages') || Request::is('admin/pages/create') || Request::is('admin/pages/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="fa fa-file fa-lg"></i>
            <span class="title">Pages</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/pages') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/pages') }}">
                    <i class="fa fa-angle-double-right"></i>
                    List
                </a>
            </li>
            <li {!! (Request::is('admin/pages/create') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/pages/create') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add New
                </a>
            </li>
        </ul>
    </li>
@endif

@if ($currentUser->isAdmin() || $currentUser->isSuperAdmin() || $currentUser->isEditor())
    <li {!! (Request::is('admin/ico/*') ? 'class="active"' : '') !!}>
        <a href="{{ URL::to('admin/ico/projects') }}">
            <i class="fa fa-money"></i>
            <span class="title">ICO</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/ico/projects') || Request::is('admin/ico/projects/create') || Request::is('admin/ico/projects/*') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/ico/projects') }}">
                    <i class="fa fa-spinner"></i>
                    Projects
                </a>
            </li>
            <li {!! (Request::is('admin/ico/project-types') || Request::is('admin/ico/project-types/create') || Request::is('admin/ico/project-types/*') ? 'class="active"' : '') !!}>
                <a href="{{URL::to('admin/ico/project-types')}}">
                    <i class="fa fa-file fa-lg"></i>
                    Project-types
                </a>
            </li>
            <li {!! (Request::is('admin/ico/money') || Request::is('admin/ico/money/create') || Request::is('admin/ico/money/*') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/ico/money') }}">
                    <i class="fa fa-usd"></i>
                    Money
                </a>
            </li>
            <li {!! (Request::is('admin/ico/category') || Request::is('admin/ico/category/create') || Request::is('admin/ico/category/*') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/ico/category') }}">
                    <i class="fa fa-list fa-lg"></i>
                    ICO Categories
                </a>
            </li>
            <li {!! (Request::is('admin/ico/platform') || Request::is('admin/ico/platform/create') || Request::is('admin/ico/platform/*') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/ico/platform') }}">
                    <i class="fa-archive"></i>
                    ICO Platforms
                </a>
            </li>
            {{--<li {!! (Request::is('admin/ico/promotion') || Request::is('admin/ico/promotion/create') || Request::is('admin/ico/promotion/*') ? 'class="active" id="active"' : '') !!}>--}}
                {{--<a href="{{ URL::to('admin/ico/promotion') }}">--}}
                    {{--<i class="fa fa-star"></i>--}}
                    {{--ICO Promotion--}}
                {{--</a>--}}
            {{--</li>--}}

            <li {!! (Request::is('admin/ico/members') || Request::is('admin/ico/members/create') || Request::is('admin/ico/members/*') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/ico/members') }}">
                    <i class="fa fa-user"></i>
                    Members
                </a>
            </li>
            <li {!! (Request::is('admin/ico/comments') || Request::is('admin/ico/comments/create') || Request::is('admin/ico/comments/*') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/ico/comments') }}">
                    <i class="fa fa-comments"></i>
                    Comments
                </a>
            </li>
        </ul>
    </li>
@endif

@if ($currentUser->isAdmin() || $currentUser->isSuperAdmin())
    <li {!! (Request::is('admin/users') || Request::is('admin/users/create') || Request::is('admin/users/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="fa fa-user"></i>
            <span class="title">Users</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/users') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/users') }}">
                    <i class="fa fa-angle-double-right"></i>
                    List
                </a>
            </li>
            <li {!! (Request::is('admin/users/create') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/users/create') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add New
                </a>
            </li>
        </ul>
    </li>
@endif

@if ($currentUser->isAdmin() || $currentUser->isSuperAdmin() || $currentUser->isEditor() || $currentUser->isExecutiveEditor())
    <li {!! (Request::is('admin/executives') || Request::is('admin/executives/create') || Request::is('admin/executives/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="fa fa-users"></i>
            <span class="title">Executives</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/executives') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/executives') }}">
                    <i class="fa fa-angle-double-right"></i>
                    List
                </a>
            </li>
            <li {!! (Request::is('admin/executives/roles') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/executives/roles') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Executive roles
                </a>
            </li>
            <li {!! (Request::is('admin/executives/supports') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/executives/supports') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Executive supports
                </a>
            </li>
            {{--<li {!! (Request::is('admin/executives/create') ? 'class="active" id="active"' : '') !!}>--}}
            {{--<a href="{{ URL::to('admin/executives/create') }}">--}}
            {{--<i class="fa fa-angle-double-right"></i>--}}
            {{--Add New--}}
            {{--</a>--}}
            {{--</li>--}}
        </ul>
    </li>
@endif

@if ($currentUser->isAdmin() || $currentUser->isSuperAdmin())
    <li {!! (Request::is('admin/comments') || Request::is('admin/comments/create') || Request::is('admin/comments/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="fa fa-comments"></i>
            <span class="title">Comments</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/comments') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/comments') }}">
                    <i class="fa fa-angle-double-right"></i>
                    List
                </a>
            </li>
            <li {!! (Request::is('admin/comments/create') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/comments/create') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add New
                </a>
            </li>
        </ul>
    </li>
@endif

@if ($currentUser->isAdmin() || $currentUser->isSuperAdmin())
    <li {!! (Request::is('admin/banner') ? 'class="active" id="active"' : '') !!}>
        <a href="#">
            <i class="fa fa-picture-o"></i>
            <span class="title">Banner</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/banner') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/banner') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Main
                </a>
            </li>
        </ul>
    </li>
@endif

@if ($currentUser->isAdmin() || $currentUser->isSuperAdmin())
    <li {!! (Request::is('admin/subscribers') || Request::is('admin/contact-form') ? 'class="active" id="active"' : '') !!}>
        <a href="#">
            <i class="fa fa-comment-o"></i>
            <span class="title">Subscribers and Posts</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/subscribers') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/subscribers') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Subscribers
                </a>
            </li>
            <li {!! (Request::is('admin/contact-form') ? 'class="active" id="active"' : '') !!}>
            <a href="{{ URL::to('admin/contact-form') }}">
            <i class="fa fa-angle-double-right"></i>
            Contact form
            </a>
            </li>
        </ul>
    </li>
@endif

@if ($currentUser->isAdmin() || $currentUser->isSuperAdmin())
    <li {!! (Request::is('admin/languages') || Request::is('admin/languages/create') || Request::is('admin/languages/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="fa fa-language"></i>
            <span class="title">Languages</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/languages') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/languages') }}">
                    <i class="fa fa-angle-double-right"></i>
                    List
                </a>
            </li>
            <li {!! (Request::is('admin/languages/create') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/languages/create') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add New
                </a>
            </li>
            <li {!! (Request::is('admin/language-keys/*') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/language-keys/') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Language Keys
                </a>
            </li>
        </ul>
    </li>
@endif

@if ($currentUser->isAdmin() || $currentUser->isSuperAdmin())
    <li {!! (Request::is('admin/redirects') || Request::is('admin/redirects/create') || Request::is('admin/redirects/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="fa fa-external-link"></i>
            <span class="title">Redirects</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/redirects') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/redirects') }}">
                    <i class="fa fa-angle-double-right"></i>
                    List
                </a>
            </li>
            <li {!! (Request::is('admin/redirects/create') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/redirects/create') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add New
                </a>
            </li>
        </ul>
    </li>
@endif

@if ($currentUser->isAdmin() || $currentUser->isSuperAdmin() || $currentUser->isEditor())
    <li {!! (Request::is('admin/events') || Request::is('admin/events/create') || Request::is('admin/events/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="fa fa-calendar"></i>
            <span class="title">Events</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/events') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/events') }}">
                    <i class="fa fa-angle-double-right"></i>
                    List
                </a>
            </li>
            <li {!! (Request::is('admin/events/create') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/events/create') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add New
                </a>
            </li>
        </ul>
    </li>
@endif

@if ($currentUser->isAdmin() || $currentUser->isSuperAdmin() || $currentUser->isEditor())
    <li {!! (Request::is('admin/locations') || Request::is('admin/locations/create') || Request::is('admin/locations/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="fa fa-location-arrow"></i>
            <span class="title">Locations</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/locations') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/locations') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Cities and countries
                </a>
            </li>
            <li {!! (Request::is('admin/locations/create') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/locations/create') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add city
                </a>
            </li>
        </ul>
    </li>
@endif

@if ($currentUser->isAdmin() || $currentUser->isSuperAdmin() || $currentUser->isEditor())
    <li {!! (Request::is('admin/coins') || Request::is('admin/coins/create') || Request::is('admin/coins/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="fa fa-bitcoin"></i>
            <span class="title">Coins</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/coins') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/coins') }}">
                    <i class="fa fa-angle-double-right"></i>
                    List
                </a>
            </li>
            {{--<li {!! (Request::is('admin/coins/create') ? 'class="active" id="active"' : '') !!}>--}}
                {{--<a href="{{ URL::to('admin/coins/create') }}">--}}
                    {{--<i class="fa fa-angle-double-right"></i>--}}
                    {{--Add New--}}
                {{--</a>--}}
            {{--</li>--}}
        </ul>
    </li>
@endif
@if ($currentUser->isAdmin() || $currentUser->isSuperAdmin() || $currentUser->isEditor())
    <li {!! (Request::is('admin/glossary/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="fa fa-book"></i>
            <span class="title">Glossary</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/glossary/categories') || Request::is('admin/glossary/categories/*') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/glossary/categories') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Categories
                </a>
            </li>
            <li {!! (Request::is('admin/glossary/items') || Request::is('admin/glossary/items/*') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/glossary/items') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Items
                </a>
            </li>
        </ul>
    </li>
@endif

@endif