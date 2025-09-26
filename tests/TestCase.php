<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    // DIESE ZEILE HINZUFÜGEN
    use CreatesApplication;
}