<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Survey;

use App\Models\Questions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SurveyController extends Controller
{
    
    public function dashboard()
    {
        if (Auth::check()) {
            return view('administration.dashboard');
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    public function survey()
    {
        $user = auth()->user();
        $questions = Questions::with(['answer' => function ($q) {
            $q->inRandomOrder();
        }])->inRandomOrder()->get();

        $questions_all = Questions::all(); 
        $ques_arr = array();
        $user_arr = array();
        foreach ($questions_all as $item) {
            $que_id = $item->id;
            // DB::enableQueryLog();
            $atte_que_by_usr = DB::table('surveys')
                ->selectRaw('`question_id`')
                ->selectRaw('COUNT(`user_id`) as attUser')
                ->where('answers', '!=', "NULL")
                ->where('question_id', '=', $que_id)
                ->groupBy('question_id')
                ->get();
            // Log::info(DB::getQueryLog());
            $result = json_decode($atte_que_by_usr, true);
            array_push($ques_arr, $result[0]['question_id']);
            array_push($user_arr, $result[0]['attUser']);
        }
        $quesAttemptByUser = array_combine($ques_arr, $user_arr);

         
            $surM = Survey::all();
            $submitted = false;
            foreach($surM as $obj){
                if($obj->user_id == $user->id){
                    $submitted = true;
                }
            }
            
        return view('administration.survey', compact('questions', 'quesAttemptByUser','submitted'));

    }

    public function subDash()
    {
            $questions = DB::table('questions')
                ->selectRaw('count(*) as total_que')
                ->get();
            
            // DB::enableQueryLog();   
            $users = DB::table('users')
                ->selectRaw('count(*) as total_user')
                ->get();
            // Log::info(DB::getQueryLog());    
            return view('administration.subdash', compact('users', 'questions'));
    }

    public function surveypost(Request $request)
    {
       
            $user = auth()->user();
            $surM = Survey::all();
            foreach($surM as $obj){
                if($obj->user_id == $user->id){
                    // $submitted = true;
                    return back()->withError('You have already Submited the survey');
                }
            }
            
            foreach ($request->answer as $question => $answer) {

                if (is_array($answer)) {
                    $answer = implode(",", $answer);
                }            
                $survey  = new Survey();
                $survey->question_id = $question;
                $survey->answers = $answer;
                $survey->user_id = $user->id;
                $survey->save();
            }
            return redirect()->back()->withSuccess('Survey successfully submited');
    
    }

}
