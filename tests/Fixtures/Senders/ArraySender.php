<?php

declare(strict_types=1);

namespace Saloon\Tests\Fixtures\Senders;

use Saloon\Http\Response;
use Saloon\Contracts\Sender;
use GuzzleHttp\Psr7\HttpFactory;
use Saloon\Data\FactoryCollection;
use Saloon\Contracts\PendingRequest;
use GuzzleHttp\Promise\PromiseInterface;
use Saloon\Helpers\GuzzleMultipartBodyFactory;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class ArraySender implements Sender
{
    /**
     * Get the factory collection
     *
     * @return FactoryCollection
     */
    public function getFactoryCollection(): FactoryCollection
    {
        $factory = new HttpFactory;

        return new FactoryCollection(
            requestFactory: $factory,
            uriFactory: $factory,
            streamFactory: $factory,
            responseFactory: $factory,
            multipartBodyFactory: new GuzzleMultipartBodyFactory,
        );
    }

    /**
     * Send the request synchronously
     *
     * @param PendingRequest $pendingRequest
     * @return \Saloon\Contracts\Response
     */
    public function send(PendingRequest $pendingRequest): \Saloon\Contracts\Response
    {
        /** @var class-string<\Saloon\Contracts\Response> $responseClass */
        $responseClass = $pendingRequest->getResponseClass();

        return $responseClass::fromPsrResponse(new GuzzleResponse(200, ['X-Fake' => true], 'Default'), $pendingRequest, $pendingRequest->createPsrRequest());
    }

    /**
     * Send the request asynchronously
     *
     * @param PendingRequest $pendingRequest
     * @return PromiseInterface
     */
    public function sendAsync(PendingRequest $pendingRequest): PromiseInterface
    {
        //
    }
}
