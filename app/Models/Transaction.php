<?php

namespace App\Models;

use App\Enums\TransactionTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'type',
        'description',
        'amount',
        'transaction_date'
    ];

    /**
     * Get the user that owns the transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => TransactionTypes::class
        ];
    }

    public function getTransactionsFromUser(User $user, int $perPage, TransactionTypes|null $transactionType, string|null $transactionDate) {
        $query = Transaction::whereBelongsTo($user);

        if (!empty($transactionType)) {
            $query->where('type', $transactionType);
        }

        if (!empty($transactionDate)) {
            $query->where('transaction_date', $transactionDate);
        }

        return $query->paginate($perPage);
    }

    public function getRelatorioFromUser(User $user) {
        $relatorio = Transaction::whereBelongsTo($user)
            ->selectRaw('SUM(CASE WHEN type = ? THEN amount ELSE 0 END) AS total_receitas', ['receita'])
            ->selectRaw('SUM(CASE WHEN type = ? THEN amount ELSE 0 END) AS total_despesas', ['despesa'])
            ->groupBy('user_id')
            ->first();

        $relatorio['saldo_total'] = number_format($relatorio['total_receitas'] - $relatorio['total_despesas'], 2, '.', '');

        return $relatorio;
    }
}
