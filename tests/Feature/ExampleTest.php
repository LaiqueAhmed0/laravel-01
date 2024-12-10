<?php

use function Pest\Laravel\{get};

test('basic test', function () {
    get('/')->assertRedirect();
});
