<div id="left-sidebar" class="sidebar">
    <div class="sidebar-scroll">

        <div class="tab-content p-l-0 p-r-0">
            <div class="tab-pane active" id="menu">
                <nav id="left-sidebar-nav" class="sidebar-nav">
                    <ul id="main-menu" class="metismenu">                        
                        <li class="{{ Request::segment(2) === 'staffs' ? 'active' : null }}">
                            <a href="{{route('manager.staffs')}}"><i class="icon-grid"></i> <span>Staffs</span></a>
                        </li>
                        <li class="{{ Request::segment(2) === 'menu' ? 'active' : null }}">
                            <a href="{{route('manager.menu')}}"><i class="icon-grid"></i> <span>Menu</span></a>
                        </li>
                        <li class="{{ Request::segment(2) === 'orders' ? 'active' : null }}">
                            <a href="{{route('manager.orders')}}"><i class="icon-grid"></i> <span>Orders</span></a>
                        </li>
                        <li class="{{ Request::segment(2) === 'request' ? 'active' : null }}">
                            <a href="{{route('manager.request')}}"><i class="icon-grid"></i> <span>Requests</span></a>
                        </li>
                        <li class="{{ Request::segment(2) === 'bills' ? 'active' : null }}">
                            <a href="{{route('manager.bills')}}"><i class="icon-grid"></i> <span>Billed Orders</span></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>          
    </div>
</div>
