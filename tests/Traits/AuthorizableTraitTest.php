<?php

use Maatwebsite\Sidebar\Traits\AuthorizableTrait;

class AuthorizableTraitTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var StubItemableClass
     */
    protected $routeable;

    protected function setUp()
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
