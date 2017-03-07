
<div class="menu">
    <div class="menu-toggle pull-left">
        <a class="click-hide"><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span></a>
    </div>
    
    <div class="collapse navbar-collapse" id="app-navbar-collapse">
        <!-- Left Side Of Navbar -->
        <ul class="nav navbar-nav">
           <li class="title" >@yield('title')</li>
        </ul>
        <ul class="nav navbar-nav">
        @if(Session::has('flash_message'))
            <div class="alert alert-{{ Session::get('flash_level') }}">
                {{ Session::get('flash_message') }}
            </div>
        @endif
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="nav navbar-nav navbar">
            <!-- Authentication Links -->
            @if (Auth::guest())
                <li><a href="{{ url('/login') }}">Login</a></li>
                <li><a href="{{ url('/register') }}">Register</a></li>
            @else
            <?php $user_data_sidebar = Session::get('user_data'); ?>
            <?php if($user_data_sidebar['role_name'] == 'admin' ):?>
                <!-- <li>Only admin</li> -->
            <?php endif; ?>
                <li class="dropdown">
                    <a href="#"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ Auth::user()->full_name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="{{ url('/logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                        <li><a href="{!! url('/password/reset') !!}">Reset Password</a></li>
                        <li><a href='/editProfiles/{!! Auth::user()->id !!}'>Change Profile</a></li>
                    </ul>
                </li>

                <?php 
                $url = 'http://dmstraining.herokuapp.com/';
                $url = 'http://10.121.79.81:8000/';
                $visiable_search = false;
                    if(Request::url() === $url.'devices/histories'){
                        $visiable_search = true;
                    }elseif(Request::url() === $url.'dashboard'){
                        $visiable_search = true;
                    }elseif(Request::url() === $url.'users/list_users'){
                        $visiable_search = true;
                    }elseif(Request::url() === $url.'borrowers/devices'){
                        $visiable_search = true;
                    }elseif(Request::url() === $url.'borrowers/devices/histories'){
                        $visiable_search = true;
                    }elseif(Request::url() === $url.'borrowers/devices'){
                        $visiable_search = true;
                    }elseif(Request::url() === $url.'borrowers/devices/dashboard'){
                        $visiable_search = true;
                    }elseif(Request::url() === $url.'users'){
                        $visiable_search = true;
                    }elseif(Request::url() === $url.'users/list_users'){
                        $visiable_search = true;
                    }else{
                        $visiable_search = false;
                    }
                ?>
                <?php
                if($visiable_search){?>
                    <li class="search">
                        <form method="get" action="">
                           <div id="custom-search-input">
                                <div class="input-group" style="float: right;">
                                    <input type="text" id="search" name="search" class="  search-query form-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-danger" type="submit" id="search">
                                            <span class=" glyphicon glyphicon-search"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                
                        </form>
                    </li>
                <?php }?>
                
            @endif
        </ul>
    </div>
</div>

