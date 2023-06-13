<?php

namespace Maatwebsite\Sidebar\Tests;

use Illuminate\Events\Dispatcher;
use Maatwebsite\Sidebar\Domain\DefaultMenu;
use Orchestra\Testbench\TestCase as Orchestra;


class TestCase extends Orchestra
{
  protected function setUp(): void
  {
    parent::setUp();
  }
  
  protected function getPackageProviders($app)
  {
    return [
    ];
  }
  
  public function getEnvironmentSetUp($app)
  {
    config()->set('database.default', 'testing');
  }
}