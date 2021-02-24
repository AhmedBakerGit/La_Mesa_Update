<div id="left-sidebar" class="sidebar">
    <div class="sidebar-scroll">

        <div class="tab-content p-l-0 p-r-0">
            <div class="tab-pane active" id="menu">
                <nav id="left-sidebar-nav" class="sidebar-nav">
                    <ul id="main-menu" class="metismenu">                        
                        <li class="{{ Request::segment(2) === 'menu' ? 'active' : null }}">
                            <a href="{{route('cashier.menu')}}"><i class="icon-grid"></i> <span>Menu</span></a>
                        </li>
                        <li class="{{ Request::segment(2) === 'orders' ? 'active' : null }}">
                            <a href="{{route('cashier.orders')}}"><i class="icon-grid"></i> <span>Orders</span></a>
                        </li>
                        <li class="{{ Request::segment(2) === 'request' ? 'active' : null }}">
                            <a href="{{route('cashier.request')}}"><i class="icon-grid"></i> <span>Requests</span></a>
                        </li>
                        <li class="{{ Request::segment(2) === 'bills' ? 'active' : null }}">
                            <a href="{{route('cashier.bills')}}"><i class="icon-grid"></i> <span>Billed Orders</span></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>          
    </div>
</div>
