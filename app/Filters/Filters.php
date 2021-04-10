<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    /**
     * @var Request
     */
    protected $request;

    protected $builder;

    protected $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        // $this->getFilters()
        //     ->filter(function ($filter){
        //         return method_exists($this, $filter);
        //     })
        //     ->each(function ($filter){
        //         $this->$filter($value);
        //     });

        foreach($this->getFilters() as $filter)
        {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    public function getFilters()
    {
        return collect($this->intersect($this->filters))->flip();
    }

    public function intersect($keys)
    {
        return array_filter($this->request->only(is_array($keys) ? $keys : func_get_args()));
    }
}
