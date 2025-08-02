<?php

namespace App\Repository;

interface QuestionRepositoryInterface
{
    public function index();

    public function create(\Illuminate\Http\Request $request);

    public function store(\Illuminate\Http\Request $request);

    public function edit($id);

    public function update($request);

    public function destroy($request);
}
