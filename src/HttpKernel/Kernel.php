<?php
namespace FaDoe\HttpKernel;

class Kernel extends AbstractKernel
{
    /**
     * @return array
     */
    public function registerModules()
    {
        return [
            'Application'
        ];
    }
}
