<div id="left-sidebar" class="sidebar">
    <div class="sidebar-scroll">

        <div class="tab-content p-l-0 p-r-0">
            <div class="tab-pane active" id="menu">
                <nav id="left-sidebar-nav" class="sidebar-nav">
                    <ul id="main-menu" class="metismenu">                        
                        <li class="{{ Request::segment(2) === 'restaurants' || Request::segment(3) ? 'active' : null }}">
                            <a class="has-arrow"><i class="icon-home"></i> <span id="id-restaurant-sidebar">Restaurants</span></a>
                            <ul>
                                @foreach ($restaurants as $restuarant)
                                <li class="{{ Request::segment(3) == $restuarant->id ? 'active' : null }}"><a href="{{route('admin.restcontent', ['id'=>$restuarant->id])}}">{{ $restuarant->restName }}</a></li>                                        
                                @endforeach
                            </ul>
                        </li>
                        <li class="{{ Request::segment(2) === 'staff' ? 'active' : null }}">
                            <a href="{{route('admin.staff')}}"><i class="icon-grid"></i> <span>Staff</span></a>
                        </li>
                        <li class="{{ Request::segment(2) === 'sales' ? 'active' : null }}">
                            <a href="{{route('admin.sales')}}"><i class="icon-grid"></i> <span>Review Sales</span></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>          
    </div>
</div>
