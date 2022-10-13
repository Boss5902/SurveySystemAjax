@extends('administration.dashboard')
@section('main-content')   

      @if (Auth::user()->role_id === 2)
            
            @if (session('error'))
                  <div class="alert alert-danger" role="alert">{{ session('error') }}</div> 
            @else
                  @if ($submitted == true)
                    {{-- <h3 style="color:green">Your Survey Allready Submiited</h3>     --}}
                  @endif
            @endif

            <div class="alert alert-success" id="alertDiv" role="alert" style="display:none">
                <a type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
                <strong id="msg"></strong>
            </div>
            
            <div class="container"> 
            <div class="row">
                  <div class="col-md-6">
                        
                        <div class="card">
                        <div class="card-header">
                              Survey Form  
                        </div>
                        <div class="card-body"> 
                              <form  id="ajax">
                                 
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
                                                
                                          {{-- @if ($submitted === true) --}}
                                                {{-- <b style="color:green">Your Survey Allready Submiited</b> --}}
                                          {{-- @else --}}
                                                  <input type="submit" name="post" value="Submit" id="post">
                                          {{-- @endif       --}}
                                              
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

     

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" 
integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

<script>

$(document).on('click','#post',function(){ 
  // $("#msg").remove();
});

    $(document).ready(function(){
       
         $("#ajax").on('submit', function(event) { 
            event.preventDefault();
           //  $(".alert").remove();
            // $(".alert").hide();
            $.ajax({
                type: "post",
                url: "{{route('survey.post')}}",
                dataType: "json",
                data: $('#ajax').serialize(),
                success: function(result){
                   // $('#msg').remove(); 
                    let submitted = result['submitted'];
                    let error = result['error'];
                    let success = result['success'];

                    $('#msg').append(submitted);
                    $(".alert").fadeIn();

                    setInterval(function(){
                        $(".alert").fadeOut();   
                    }, 5000);
                }
            });
           
        });
        
    });
    
   
</script>

@endsection
