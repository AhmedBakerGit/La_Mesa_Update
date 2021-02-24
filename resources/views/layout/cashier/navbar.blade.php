<nav class="navbar navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-btn">
            <button type="button" class="btn-toggle-offcanvas"><i class="lnr lnr-menu fa fa-bars"></i></button>
        </div>

        <div class="navbar-brand">
            <a href="#"><img src="{{ asset('assets/img/logo.png') }}" alt="La Mesa Logo" class="img-responsive logo"></a>                
        </div>
        
        <div class="navbar-right">
            <div id="navbar-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                            <i class="fa fa-credit-card"></i>
                            <span id="newBillCount"></span>
                        </a>
                        <ul id="billDropdownList" class="dropdown-menu notifications" style="width: 400px; background: #e6efec;">
                            
                        </ul>
                    </li>
                    <li>
                        <a class="dropdown-toggle icon-menu" id="newOrderCountWrapper">
                            <i class="fa fa-shopping-cart"></i>
                            <span id="newOrderCount"></span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-toggle icon-menu" id="newRequestCountWrapper">
                            <i class="icon-bell"></i>
                            <span id="newRequestCount"></span>
                        </a>
                        
                    </li>
                  <li>
                      <a href="{{route('logout')}}" class="icon-menu"><i class="icon-login"></i></a>
                  </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
