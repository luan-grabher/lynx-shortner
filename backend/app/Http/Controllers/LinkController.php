<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LinkController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url',
            'identifier' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Resto do código para criar o link
        $link = Link::create([
            'url' => $request->input('url'),
            'identifier' => $request->input('identifier') ?? Link::generateIdentifier(),
            'user_id' => $request->user()->id
        ]);

        return response()->json(['message' => 'Link criado com sucesso!', 'link' => $link], 201);
    }
}
