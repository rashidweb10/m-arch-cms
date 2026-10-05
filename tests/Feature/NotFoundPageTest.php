<?php

it('renders recovery options when a page is not found', function () {
    $request = request();
    $request->headers->set('referer', 'http://localhost/courses');

    $response = app(\Illuminate\Contracts\Debug\ExceptionHandler::class)->render(
        $request,
        new \Symfony\Component\HttpKernel\Exception\HttpException(404)
    );

    expect($response->getStatusCode())->toBe(404)
        ->and($response->getContent())->toContain('Page not found')
        ->and($response->getContent())->toContain('Go back')
        ->and($response->getContent())->toContain('Return to the page you came from')
        ->and($response->getContent())->toContain('href="http://localhost/courses"')
        ->and($response->getContent())->toContain('Go to home');
});
