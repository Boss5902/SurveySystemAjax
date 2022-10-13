
@extends('administration.app')

@section('sidebar')
            <div class="sidebar-sticky">            
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <a class="d-flex align-items-center text-muted" href="{{ route('subdash') }}">

                        @if (Auth::user()->role_id === 2)
                            <span data-feather="plus-circle">STAFF Dashboard</span>
                        @elseif(Auth::user()->role_id === 1)
                            <span data-feather="plus-circle">Management Dashboard</span>
                        @endif
                        
                    </a>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('survey') }}">
                            <span data-feather="file-text"></span>
                            Survey Module
                        </a>
                    </li>
                </ul>
            </div>   
@endsection


@section('content')
              @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
              @endif              
              @yield('main-content')    
@endsection
