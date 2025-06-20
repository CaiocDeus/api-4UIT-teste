<?php

namespace App\Enums;

enum TransactionTypes: string
{
    case RECEITA = 'receita';
    case DESPESA = 'despesa';
}
