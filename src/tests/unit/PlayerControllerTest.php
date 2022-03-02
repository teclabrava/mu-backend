<?php

use PHPUnit\Framework\TestCase as PHPUnit_Framework_TestCase;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\ProvidesConvenienceMethods;

class PlayerControllerTest extends PHPUnit_Framework_TestCase
{
    public function setUp(): void

    {
        $this->player = Mockery::mock('App\Models\Player');
        $this->playesRepository = Mockery::mock('App\Repositories\Players');
        $this->response = Mockery::mock('Illuminate\Http\JsonResponse');
        $this->controller = new App\Http\Controllers\PlayerController($this->playesRepository, $this->response);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function test_index()
    {
        $players = [];
        $this->playesRepository->shouldReceive('search')->withNoArgs()->once()->andReturn($players);
        $this->response->shouldReceive('setData')->with($players)->once();
        $this->response->shouldReceive('setStatusCode')->with(206)->once();
        $this->controller->index();
    }

    public function test_show()
    {
        $id = 1;
        $this->playesRepository->shouldReceive('findById')->with($id)->once()->andReturn($this->player);
        $this->response->shouldReceive('setStatusCode')->with(Mockery::anyOf(200, 404))->between(1, 2);
        $this->response->shouldReceive('setData')->with($this->player)->once();
        $this->controller->show($id);
    }

    public function test_destroy()
    {
        $id = 1;
        $statusCode = 204;
        $this->playesRepository->shouldReceive('destroy')->with($id)->once()->andReturn($statusCode);
        $this->response->shouldReceive('setStatusCode')->with($statusCode)->once();
        $this->response->shouldReceive('setData')->with([])->once();
        $this->controller->destroy($id);
    }
}
