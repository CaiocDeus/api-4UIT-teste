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
    private Transaction $transactionModel;

    public function __construct(Transaction $transactionModel) {
        $this->transactionModel = $transactionModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $perPage = $request->integer('per_page', 20);
        $transactionType = $request->enum('tipo', TransactionTypes::class);
        $transactionDate = $request->date('data_transacao');

        return JsonResource::collection($this->transactionModel->getTransactionsFromUser($user, $perPage, $transactionType, $transactionDate));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionStoreRequest $request)
    {
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

        $relatorio = $this->transactionModel->getRelatorioFromUser($user);

        return response()->json($relatorio);
    }
}
