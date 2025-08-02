<?php

namespace App\Repository;

use Illuminate\Http\Request;


interface QuizzRepositoryInterface
{
    public function index();

    public function create();

    public function store(Request $request);

    public function edit($id);

    public function update($request);

    public function destroy($request);
}
