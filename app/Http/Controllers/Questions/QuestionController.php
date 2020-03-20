<?php

namespace App\Http\Controllers\Questions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Questions\Question;
use App\Models\Questions\QuestionsResult;
use App\Models\Personalities\PersonalitiesResult;

class QuestionController extends Controller
{
    public function setQuestions ()
    {
        $questions = Question::all();

        foreach ($questions as $key => $value) {
            QuestionsResult::create([
                'question_id' => $value->id,
                'name' => $value->name,
                'personality_id' => $value->personality_id,
                'user_id' => Auth::id()
            ]);
        }

        return 'true';
    }

    public function getQuestions ()
    {
        $count = QuestionsResult::whereNotNull('answer')->count();

        if ($count < 80) {
            $questions = QuestionsResult::where('user_id', Auth::id())->whereNull('answer')->orderByRaw("RAND()")->take(5)->get();
            return ['count' => $count, 'questions' => $questions, 'personalities' => []];
        } else {
            $personality = PersonalitiesResult::where('user_id', Auth::id())->first();
            if (is_null($personality)) {
                $this->setPersonalitiesResults();
            }
            $max = PersonalitiesResult::where('user_id', Auth::id())->max('result');
            $personalities = $this->getPersonalitiesResults();
            return ['count' => $count, 'questions' => [], 'max' => $max, 'personalities' => $personalities];
        }
    }

    public function saveQuestions (Request $request)
    {
        foreach ($request->all() as $key => $value) {
            $question = QuestionsResult::find($value['id']);
            $question->answer = $value['answer'];
            $question->save();
        }

        return $this->getQuestions();
    }

    private function setPersonalitiesResults ()
    {
        $questions = DB::table('questions_results')
                        ->select('personality_id', DB::raw('MAX(user_id) as user_id, count(*) as result'))
                        ->where('user_id', Auth::id())
                        ->where('answer', 'no')
                        ->groupBy('personality_id')
                        ->get();

        foreach ($questions as $key => $value) {

            PersonalitiesResult::create([
                'result' => $value->result,
                'personality_id' => $value->personality_id,
                'user_id' => $value->user_id
            ]);
            
        }

        return 'true';
    }

    private function getPersonalitiesResults ()
    {
        return PersonalitiesResult::with('personality')->where('user_id', Auth::id())->get();
    }
}