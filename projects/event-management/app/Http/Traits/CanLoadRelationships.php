<?php

namespace App\Http\Traits;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait CanLoadRelationships 
{
    public function loadRelationships (Model|Builder|QueryBuilder $for, ?array $relations = null) : Model|Builder|QueryBuilder 
    {   
        $relations = $relations ?? $this->relations ?? [];

        foreach ($relations as $relation) 
        {
            $for->when(
                $this->shouldIncludeRelaion($relation),
                fn ($q) => $for instanceof Model ? $for->load($relation) : $q->with($relation)
            );
        }

        return $for;
    }

    protected function shouldIncludeRelaion(string $relation): bool
    {
        $include = request()->query('include');

        if(!$include) {
            return false;
        }

        $relations = array_map('trim', explode(',', $include));

        return in_array($relation, $relations);
    }
}
