<?php

namespace App\Http\Controllers;

use App\Http\Requests\TermRequestPost;
use App\Http\Resources\TermResource;
use App\Models\Term;
use App\Services\term\CreateTermService;
use Illuminate\Http\Request;

class TermController extends Controller
{
    public function index()
    {
        //
    }

    public function store(TermRequestPost $request, CreateTermService $createTermService)
    {
        $term = $createTermService->create($request->all());

        return new TermResource($term);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function show(Term $term)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function edit(Term $term)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Term $term)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function destroy(Term $term)
    {
        //
    }
}
