<?php

namespace Reliv\AssetManagerExpressive\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\AssetManagerExpressive\Service\AssetManager;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class AssetManagerMiddleware implements MiddlewareInterface
{
    /**
     * @var \Reliv\AssetManagerExpressive\Service\AssetManager
     */
    protected $assetManager;

    /**
     * @param AssetManager $assetManager
     */
    public function __construct(
        AssetManager $assetManager
    ) {
        $this->assetManager = $assetManager;
    }

    /**
     * process
     *
     * @param ServerRequestInterface $request
     * @param DelegateInterface|null $delegate
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate = null
    ) {
        if (!$this->assetManager->resolvesToAssetPsr($request)) {
            return $delegate->process($request);
        }

        return $this->assetManager->setAssetOnResponsePsr();
    }
}
