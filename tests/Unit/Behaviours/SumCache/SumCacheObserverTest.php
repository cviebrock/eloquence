<?php
namespace Tests\Unit\Behaviours\SumCache;

use Eloquence\Behaviours\SumCache\SumCacheObserver;
use Mockery as m;
use Tests\Unit\Stubs\RealModelStub;
use Tests\Unit\TestCase;

class SumCacheObserverTest extends TestCase
{
    private $model;
    private $mockManager;
    private $observer;

    public function init()
    {
        $this->mockManager = m::spy('Eloquence\Behaviours\SumCache\SumCacheManager');
        $this->observer = new SumCacheObserver;
        $this->observer->setManager($this->mockManager);
        $this->model = new RealModelStub;
    }

    public function testCreated()
    {
        $this->observer->created($this->model);
        $this->mockManager->shouldHaveReceived('increase')->with($this->model)->once();
    }

    public function testUpdated()
    {
        $this->observer->updated($this->model);
        $this->mockManager->shouldHaveReceived('updateCache')->with($this->model)->once();
    }

    public function testDeleted()
    {
        $this->observer->deleted($this->model);
        $this->mockManager->shouldHaveReceived('decrease')->with($this->model)->once();
    }

    public function testRestored()
    {
        $this->observer->restored($this->model);
        $this->mockManager->shouldHaveReceived('increase')->with($this->model)->once();
    }
}
