<?php

namespace App\Http\Controllers;

use App\Enums\TransactionTypes;
use App\Http\Requests\Transaction\TransactionStoreRequest;
use App\Http\Requests\Transaction\TransactionUpdateRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->integer('per_page', 20);
        $transactionType = $request->enum('tipo', TransactionTypes::class);
        $data_transacao = $request->date('data_transacao');

        $query = Transaction::query();

        if (!empty($transactionType)) {
            $query->where('type', $transactionType);
        }

        if (!empty($data_transacao)) {
            $query->where('transaction_date', $data_transacao);
        }

        return JsonResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionStoreRequest $request)
    {
        $request['transaction_date'] = date("Y-m-d");
        $request['user_id'] = $request->user()->id;
        $transaction = Transaction::create($request->all());

        return response()->json([
            "id" => $transaction->id,
            "message" => "Transação criada"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return new JsonResource(Transaction::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    // TODO Permitir alterar o campo transaction_date?
    public function update(TransactionUpdateRequest $request, int $id)
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->fill($request->all());
        $transaction->save();

        return response()->json([
            "message" => 'Transação atualizada'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->delete();

        return response()->json([
            "message" => "Transação deletada"
        ]);
    }

    public function relatorio(Request $request)
    {
        $user = $request->user();
        // $id = Auth::id();

        $relatorio = Transaction::whereBelongsTo($user)
            ->selectRaw('SUM(CASE WHEN type = ? THEN amount ELSE 0 END) AS total_receitas', ['receita'])
            ->selectRaw('SUM(CASE WHEN type = ? THEN amount ELSE 0 END) AS total_despesas', ['despesa'])
            ->groupBy('user_id')
            // ->with('user')
            ->first();

        $relatorio['saldo_total'] = number_format($relatorio['total_receitas'] - $relatorio['total_despesas'], 2);

        return response()->json([
            $relatorio
        ]);
    }
}
