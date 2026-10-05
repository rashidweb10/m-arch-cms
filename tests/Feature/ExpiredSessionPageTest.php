<?php

it('renders recovery options when a request has an expired session', function () {
    $request = request();
    $request->headers->set('referer', 'http://localhost/courses');

    $response = app(\Illuminate\Contracts\Debug\ExceptionHandler::class)->render(
        $request,
        new \Symfony\Component\HttpKernel\Exception\HttpException(419)
    );

    expect($response->getStatusCode())->toBe(419)
        ->and($response->getContent())->toContain('Your session has expired')
        ->and($response->getContent())->toContain('Go back and try again')
        ->and($response->getContent())->toContain('Return to the page you came from')
        ->and($response->getContent())->toContain('href="http://localhost/courses"')
        ->and($response->getContent())->not->toContain('Go to login')
        ->and($response->getContent())->toContain('Go to home');
});
