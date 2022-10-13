@extends('administration.dashboard')

@section('main-content')   
       
    @if(Auth::user()->role_id === 2)

             <b style="color:green">Welcome to Staff Area</b>

    @elseif(Auth::user()->role_id === 1) 
            <div class="container">
                <div class="col-md-5 ">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-success table-striped" border="1px">
                                <thead>
                                    <tr style="text-align: center;">
                                        <th scope="col">Total Questions</th>
                                        <th scope="col">Total Users</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: center;"> 
                                            @foreach ($questions as $item)
                                                <b style="color: green">{{$item->total_que}}</b>   
                                            @endforeach
                                        </td>
                                        <td style="text-align: center;"> 
                                            @foreach ($users as $item)
                                               <b style="color: green;"> {{$item->total_user}}</b>   
                                            @endforeach
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
     @endif   
    
@endsection
