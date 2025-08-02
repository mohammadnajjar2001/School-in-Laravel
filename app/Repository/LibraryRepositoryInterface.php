<?php

namespace App\Repository;

interface LibraryRepositoryInterface
{
    public function index();

    public function create();

    public function store(\Illuminate\Http\Request $request);

    public function edit($id);

    public function update($request);

    public function destroy($request);

    public function download($filename);
}
