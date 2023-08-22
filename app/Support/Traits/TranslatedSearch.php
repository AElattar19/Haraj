<?php

namespace App\Support\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * @method static Builder searchColumn(string $name, string $value)
 * */
trait TranslatedSearch
{
    public function scopeSearchColumn(Builder $builder, string $name, string $value)
    {
        if ($value === '') {
            return;
        }
        $value = str_replace("'", "\\'", strtolower($value));
        $values = explode(' ', $value);
        foreach ($values as $string) {
            $builder->orWhereRaw("JSON_EXTRACT({$name}, '$.ar') like '%{$string}%'")
                    ->orWhereRaw("lower(JSON_EXTRACT({$name}, '$.en')) like '%{$string}%'");
        }
        $score = $this->matchedScore($name, $values);
        $builder->select(['*'])->addSelect($score);
        $builder->orderBy('score', 'desc');
    }

    private function matchedScore(string $name, array $values)
    {
        $str = collect([]);
        foreach ($values as $value) {
            $str->add("if(ISNULL(json_search(lower({$name}), 'one', '%{$value}%')), 0, 1)");
        }

        return DB::raw($str->implode('+').' +1 as score');
    }
}
