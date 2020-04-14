<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" 
                data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1"
                aria-expanded="false">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/')}}">LaravelApp</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                @if (!empty($halaman) && $halaman == 'siswa')
                <li class="active"><a href="{{url('siswa')}}">Siswa <span class="sr-only">(current)</span></a></li>
                @else
                <li><a href="{{url('siswa')}}">Siswa</a></li> 
                @endif
                
                @if (Auth::check())
                @if (!empty($halaman) && $halaman == 'kelas')
                <li class="active"><a href="{{url('kelas')}}">Kelas <span class="sr-only">(current)</span></a></li>
                @else
                <li><a href="{{url('kelas')}}">Kelas</a></li> 
                @endif
                @endif

                @if (Auth::check())
                @if (!empty($halaman) && $halaman == 'hobi')
                <li class="active"><a href="{{url('hobi')}}">Kelas <span class="sr-only">(current)</span></a></li>
                @else
                <li><a href="{{url('hobi')}}">Hobi</a></li> 
                @endif
                @endif

                <li><a href="{{ url('about') }}">About</a></li>

                @if (Auth::check() && Auth::user()->level == 'admin')
                @if (!empty($halaman) && $halaman == 'user')
                <li class="active"><a href="{{url('user')}}">User <span class="sr-only">(current)</span></a></li>
                @else
                <li><a href="{{url('user')}}">User</a></li> 
                @endif
                @endif
                
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <!-- <li><a href="#">Login</a></li> -->
                @if (Auth::check())
                <li class="dropdown">
                    <a id="navbarDropdown" class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{Auth::user()->name}} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{url('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{url('logout')}}" method="POST" style="display:none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
                @else 
                <li class="nav-item">
                    <a class="nav-link" href="{{url('login')}}">Login</a>
                </li>
                @endif
                <li class="dropdown"></li>
            </ul>
        </div>
    </div>
</nav>