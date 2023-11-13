<?php

namespace Maatwebsite\Sidebar\Tests\Traits;

use Maatwebsite\Sidebar\Traits\AuthorizableTrait;
use PHPUnit\Framework\TestCase as TestCase;

class AuthorizableTraitTest extends TestCase
{
    /**
     * @var StubItemableClass
     */
    protected $routeable;

    protected function setUp(): void
    {
        $this->routeable = new StubAuthorizableClass();
    }

    public function test_can_authorize()
    {
        $this->routeable->authorize(true);
        $this->assertTrue($this->routeable->isAuthorized());

        $this->routeable->authorize(false);
        $this->assertFalse($this->routeable->isAuthorized());
    }
}

class StubAuthorizableClass
{
    use AuthorizableTrait;
}
