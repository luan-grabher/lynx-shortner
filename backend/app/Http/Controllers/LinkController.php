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

    public function list(Request $request)
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

    public function destroy($id)
    {
        $link = Link::find($id);
        if (!$link) {
            return response()->json(['message' => 'Link não encontrado.'], 404);
        }

        // Verificar se o usuário autenticado possui permissão para remover o link
        if ($link->user_id !== auth()->user()->id) {
            return response()->json(['message' => 'Você não tem permissão para remover este link.'], 403);
        }

        $link->delete();

        return response()->json(['message' => 'Link removido com sucesso!']);
    }
}
