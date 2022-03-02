<?php

use Tests\TestCase;

class PlayerControllerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->playesRepository = Mockery::mock('App\Repositories\PlayerRepository');
        $this->controller = new App\Http\Controllers\PlayerController($this->playesRepository);
    }
    public function tearDown()
    {
        Mockery::close();
    }
    public function test_index()
    {


        $this->playesRepository->shouldReceive('search')->once()->andReturn('search_players');

        //$response = $controller->index();

    }
}
