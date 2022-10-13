@extends('administration.dashboard')
@section('main-content')   

      @if (Auth::user()->role_id === 2)
            
            @if (session('error'))
                  <div class="alert alert-danger" role="alert">{{ session('error') }}</div> 
            @else
                  @if ($submitted == true)
                    <h3 style="color:green">Your Survey Allready Submiited</h3>    
                  @endif
            @endif
            
            <div class="container"> 
            <div class="row">
                  <div class="col-md-6">
                        
                        <div class="card">
                        <div class="card-header">
                              Survey Form  
                        </div>
                        <div class="card-body"> 
                              <form action="{{route('survey.post')}}" method="POST">
                                    @csrf
                                    
                                    <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                                    @foreach ($questions as $item)
                                        <div class="mb-3"> 
                                          
                                                <label class="form-label">{{ $item->question }}</label><br>
                                                
                                                @if($item->type == 'select')
                                                    <select name="answer[{{$item->id}}]" class="form-control">
                                                        @foreach ($item->answer as $itm)
                                                            @if($itm->question_id == $item->id && $item->type == 'select')   
                                                                    <option value="{{ $itm->id }}">{{ $itm->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                @endif

                                                @foreach ($item->answer as $itm)
                                                        @if($itm->question_id == $item->id && $item->type == 'checkbox')   
                                                            <input type="checkbox" name="answer[{{$item->id}}][]" value="{{ $itm->id }}" class="form-check-control" >{{ $itm->name }}<br>
                                                        @endif
                                                @endforeach
                                                
                                                @if($item->type == 'text')   
                                                        <input type="text" value="" name="answer[{{$item->id}}]" class="form-control" />        
                                                @elseif($item->type == 'date')   
                                                        <input type="date" value="" name="answer[{{$item->id}}]" class="form-control" />
                                                @elseif($item->type == 'textarea')   
                                                        <textarea class="form-control" rows="3" name="answer[{{$item->id}}]"></textarea>
                                                @endif
                                        </div>        
                                    @endforeach
                                                
                                          @if ($submitted === true)
                                                {{-- <b style="color:green">Your Survey Allready Submiited</b> --}}
                                          @else
                                                  <input type="submit" name="post" value="Submit">
                                          @endif      
                                              
                              </form>
                        </div>
                        </div>
                  </div>
            </div>
            </div>  

      @elseif(Auth::user()->role_id === 1) 
    
            <div class="container">
                <div class="col-md-5 ">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-success table-striped" border="1px">
                                <thead>
                                    <tr style="text-align: center;">
                                        <th scope="col"><b>Question Name</b></th>
                                        <th scope="col"><b>Attempted Users</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach ($quesAttemptByUser as $question => $Attuser)
                                    <tr  style="text-align: center;">
                                          <td><b style="color: green"> Question {{$question}}</b></td>
                                          <td><b style="color: green">{{$Attuser}}</b></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
      @endif        

@endsection
