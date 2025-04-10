<?php

namespace Labi9\Elegan\Contracts;

use Labi9\Elegan\Structures\{
    AuthStructure,
    BasicStructure,
    ParamsStructure,
};

abstract class Action
{
    protected AuthStructure $authStructure;
    protected BasicStructure $basicStructure;
    protected ParamsStructure $paramsStructure;

    public function __construct()
    {
        $this->authStructure = new AuthStructure();
        $this->basicStructure = new BasicStructure();
        $this->paramsStructure = new ParamsStructure();
    }
}
