<?php

namespace App\Http\Controllers;

use App\Models\AccessMetric;
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

    public function update(Request $request, $id)
    {
        $link = Link::find($id);
        if (!$link) {
            return response()->json(['message' => 'Link não encontrado.'], 404);
        }

        // Verificar se o usuário autenticado possui permissão para remover o link
        if ($link->user_id !== auth()->user()->id) {
            return response()->json(['message' => 'Você não tem permissão para atualizar este link.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'url' => 'nullable|url',
            'identifier' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $link->url = $request->input('url') ?? $link->url;
        $link->identifier = $request->input('identifier') ?? $link->identifier ?? Link::generateIdentifier();
        $link->save();

        return response()->json(['message' => 'Link atualizado com sucesso!', 'link' => $link], 200);
    }

    public function redirect($identifier)
    {
        $link = Link::where('identifier', $identifier)->first();

        if (!$link) return response()->json(['message' => 'Link não encontrado.'], 404);

        $link->increment('access_count');
        $link->save();

        $accessData = [
            'link_id'       => $link->id,
            'ip'            => request()->ip(),
            'user_agent'    => request()->header('User-Agent'),
        ];
        AccessMetric::create($accessData);

        return redirect($link->url);
    }
}
