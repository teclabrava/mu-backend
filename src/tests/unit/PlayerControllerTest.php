<?php

use Tests\TestCase;

class PlayerControllerTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }
    public function test_index()
    {
        $playesRepository = Mockery::mock('App\Repositories\PlayerRepository');
        $controller = new App\Http\Controllers\PlayerController($playesRepository);

        $playesRepository->shouldReceive('search')->once()->andReturn('search_players');

        $response = $controller->index();

    }
}
