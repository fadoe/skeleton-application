<?php
namespace FaDoe\HttpKernel;

use Symfony\Component\HttpKernel\HttpKernelInterface as KernelInterface;

interface HttpKernelInterface extends KernelInterface
{
    /**
     * @return array
     */
    public function registerModules();

    /**
     * @return array
     */
    public function getModules();

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getModule($name);
}
