<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Qustion;
use Exception;
use Illuminate\Http\Request;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $forms = Form::all();

            return response()->json([
                "success" => true,
                "data" => $forms
            ]);
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
                "slug" => uniqid(),
                "name" => $request->get("name"),
                "description" => $request->get("description"),
            ]);
            
            $form->share_url = $base_url . "/" . $form->slug;

            $questions = $request->get("questions", []);

            foreach( $questions as $question )
            {
                $qus = Qustion::create($question);
                $form->qustion_id = $qus->id;
            }
            
            $form->save();

            return response()->json();
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
    public function show(string $id)
    {
        //
        try{
            return response()->json();
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            return response()->json();
        } catch( Exception $e ){
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            return response()->json();
        } catch( Exception $e ){
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }
}
