<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedBackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // showing all response
        try{
            if( Auth::user() ){
                $feedbacks = Feedback::where()->get();
            } else{
                return response()->json([
                    "success" => false,
                    "message" => "Not authorized!"
                ],403);
            }

        } catch( \Exception $e ){
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 500);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
