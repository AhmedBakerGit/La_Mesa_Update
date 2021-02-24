<div id="left-sidebar" class="sidebar">
    <div class="sidebar-scroll">

        <div class="tab-content p-l-0 p-r-0">
            <div class="tab-pane active" id="menu">
                <nav id="left-sidebar-nav" class="sidebar-nav">
                    <ul id="main-menu" class="metismenu">
                        <li class="{{ Request::segment(2) === 'menu' ? 'active' : null }}">
                            <a href="{{route('kitchen.menu')}}"><i class="icon-grid"></i> <span>Menu</span></a>
                        </li>
                        <li class="{{ Request::segment(2) === 'orders' ? 'active' : null }}">
                            <a href="{{route('kitchen.orders')}}"><i class="icon-grid"></i> <span>Orders</span></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>          
    </div>
</div>
