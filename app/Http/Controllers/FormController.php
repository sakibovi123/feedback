<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Form;
use App\Models\Question;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            if ( Auth::user() )
            {
                $forms = Form::where("user_id", Auth::user()->id)->with("questions")->paginate(15);
                return response()->json([
                    "success" => true,
                    "data" => $forms,
                ]);
            }
            else{
                return response()->json([
                    "success" => false,
                    "message" => "You are not logged in!"
                ], 403);
            }
        } catch( Exception $e ) {
            return response()->json([
                "success" => "false",
                "message" => $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $base_url = env("APP_URL");
            $form = Form::create([
                "slug" => Str::slug(uniqid()),
                "name" => $request->get("name"),
                "user_id" => Auth::user()->id,
                "description" => $request->get("description"),
            ]);

            $form->share_url = $base_url . "/api/form-details/" . $form->slug;
            $form->save();
            $question_titles = $request->get("question_titles", []);
            $attachedQuestions = [];
            foreach ($question_titles as $question_title)
            {
                $question = Question::create([
                    "question_title" => $question_title
                ]);
                $attachedQuestions[] = $question;
                $form->questions()->attach($question->id);
            }

            $form->setRelation("questions", collect($attachedQuestions));

            return response()->json([
                "success" => true,
                "data" => $form
            ]);
        } catch( Exception $e ){
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug, Request $request)
    {
        try{
            $form = Form::where("slug", $slug)->first();
            $formWithQuestion = $form->with("questions")->get();
            $questions = $form->questions;
            $formWithFeedback = $form->feedback()->get();
            return response()->json([
                "success" => true,
                "data" => $form,
                "feedbacks" => $formWithFeedback
            ]);
        } catch( Exception $e ){
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * post the feedback to specified form in storage.
     */
    public function post_feedback(Request $request, string $slug)
    {
        try{
            $form = Form::where("slug", $slug)->first();
            $formWithQuestion = $form->with("questions")->get();
            $questions = $form->questions;
            $answers = $request->get("answers");
            foreach( $questions as $index => $question )
            {
                $feedback = Feedback::create([
                    "form_id" => $form->id,
                    "name" => $request->get("name"),
                    "email" => $request->get("email"),
                    "question_id" => $question->id,
                    "answer" => $answers[$index]
                ]);
            }
            return response()->json([
                "success" => true,
                "message" => "Response Submitted"
            ]);
        } catch( Exception $e ){
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }


    /**
        showing form wise feedbacks
     */
    public function show_form_wise_feedback(string $slug)
    {
        $form = Form::where("slug", $slug)->firstOrFail();
        $questions = $form->questions;
        $feedbacks = Feedback::where("form_id", $form->id)->get();
        return response()->json([
            "success" => true,
            "questions" => $questions,
            "feedbacks" => $feedbacks
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $form = Form::find($id);
            $form->delete();
            return response()->json([
                "success" => true,
                "message" => "Form removed!"
            ], 200);
        } catch( Exception $e ){
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
