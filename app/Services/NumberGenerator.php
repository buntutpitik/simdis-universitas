<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class NumberGenerator
{
    public const INCOMING = 'SM';

    public const OUTGOING = 'SK';

    public const DISPOSITION = 'DSP';
    
    public static function generate(
        string $prefix,
        string $table,
        string $column = 'agenda_number'
    ): string {

        $year = now()->year;

        $lastNumber = DB::table($table)
            ->whereYear('created_at', $year)
            ->where($column, 'like', $prefix . '-' . $year . '-%')
            ->max($column);

        if (!$lastNumber) {
            $sequence = 1;
        } else {

            $sequence = (int) substr($lastNumber, -6) + 1;

        }

        return sprintf(
            '%s-%s-%06d',
            $prefix,
            $year,
            $sequence
        );
    }
}