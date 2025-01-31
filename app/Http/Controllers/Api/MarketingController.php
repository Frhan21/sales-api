<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Marketing;
use Illuminate\Http\Request;

class MarketingController extends Controller
{
    public function index()
    {
        $marketing = Marketing::all();
        return $marketing;
    }

    public function show($id)
    {
        $marketing = Marketing::find($id);
        return $marketing;
    }

    public function update(Request $request)
    {
        $id = $request->param('id');
        $marketing = Marketing::find($id);
        $marketing->update($request->all());
        return $marketing;
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
        ]);
        $marketing = Marketing::create($request->all());
        return $marketing;
    }
}
