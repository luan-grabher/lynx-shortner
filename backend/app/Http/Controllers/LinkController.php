<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
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
            'user_id' => auth()->user()->id
        ]);

        return response()->json(['message' => 'Link criado com sucesso!', 'link' => $link], 201);
    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'nullable|integer',
            'per_page' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $page = $request->input('page') ?? 1;
        $perPage = $request->input('per_page') ?? 10;

        $links = Link::where('user_id', $request->user()->id)
            ->orderBy('id', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json($links, 200);
    }
}
