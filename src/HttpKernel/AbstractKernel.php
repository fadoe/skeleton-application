<?php
namespace FaDoe\HttpKernel;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\HttpKernel;
use Zend\ModuleManager\ModuleManager;

abstract class AbstractKernel implements HttpKernelInterface
{
    private $booted = false;

    /**
     * @var ModuleManager
     */
    private $moduleManager;

    /**
     * Handles a Request to convert it to a Response.
     *
     * When $catch is true, the implementation must catch all exceptions
     * and do its best to convert them to a Response instance.
     *
     * @param Request $request A Request instance
     * @param int     $type    The type of the request
     *                         (one of HttpKernelInterface::MASTER_REQUEST or HttpKernelInterface::SUB_REQUEST)
     * @param bool    $catch   Whether to catch exceptions or not
     *
     * @return Response A Response instance
     *
     * @throws \Exception When an Exception occurs during processing
     *
     * @api
     */
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        if (false === $this->booted) {
            $this->boot();
        }

        return $this->getHttpKernel()->handle($request, $type, $catch);
    }

    public function boot()
    {
        if (true === $this->booted) {
            return;
        }

        // init modules
        $this->initializeModules();
//
//        // init container
//        $this->initializeContainer();

        $this->booted = true;
    }

    public function getModules()
    {
        return $this->moduleManager->getModules();
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getModule($name)
    {
        return $this->moduleManager->getModule($name);
    }

    /**
     * Gets a HTTP kernel from the container.
     *
     * @return HttpKernel
     */
    protected function getHttpKernel()
    {
        $eventDispatcher = new EventDispatcher();
        $controllerResolver = new ControllerResolver();
        $requestStack = null;

        $httpKernel = new HttpKernel($eventDispatcher, $controllerResolver, $requestStack);

        return $httpKernel;
    }

    protected function initializeModules()
    {
        $this->moduleManager = new ModuleManager($this->registerModules());
    }

}
