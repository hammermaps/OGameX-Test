<?php

namespace Tests\Unit\Services\AiPlayer;

use Mockery;
use OGame\Models\Resources;
use OGame\Services\AiPlayer\Strategies\AbstractStrategy;
use OGame\Services\PlanetService;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the resource-affordability helpers introduced on AbstractStrategy.
 *
 * These tests focus on the pure helper methods (canAffordSoon, getMissingResources)
 * and use a Mockery-mocked PlanetService so they don't need a database connection.
 */
class AbstractStrategyAffordabilityTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Build an anonymous concrete subclass exposing AbstractStrategy's helpers.
     */
    private function makeStrategy(): AbstractStrategy
    {
        return new class () extends AbstractStrategy {
            public function getBuildingPriorityList(): array { return []; }
            public function getResearchPriorityList(): array { return []; }
            public function getResourceColonyBuildingPriorityList(): array { return []; }
            public function decideUnitBuild(PlanetService $planet): array { return []; }
            public function decideFleetAction(\OGame\Services\PlayerService $player, PlanetService $planet): ?array { return null; }
            public function isResourceColony(PlanetService $planet, \OGame\Services\PlayerService $player): bool { return false; }
            public function shouldExpand(\OGame\Services\PlayerService $player): bool { return false; }
        };
    }

    /**
     * Stub a PlanetService with the given resource and production levels.
     */
    private function mockPlanet(float $metal, float $crystal, float $deuterium, float $metalPs, float $crystalPs, float $deutPs): PlanetService
    {
        $planet = Mockery::mock(PlanetService::class);

        $metalRes   = Mockery::mock();
        $metalRes->shouldReceive('get')->andReturn($metal);
        $crystalRes = Mockery::mock();
        $crystalRes->shouldReceive('get')->andReturn($crystal);
        $deutRes    = Mockery::mock();
        $deutRes->shouldReceive('get')->andReturn($deuterium);

        $planet->shouldReceive('metal')->andReturn($metalRes);
        $planet->shouldReceive('crystal')->andReturn($crystalRes);
        $planet->shouldReceive('deuterium')->andReturn($deutRes);
        $planet->shouldReceive('getMetalProductionPerSecond')->andReturn($metalPs);
        $planet->shouldReceive('getCrystalProductionPerSecond')->andReturn($crystalPs);
        $planet->shouldReceive('getDeuteriumProductionPerSecond')->andReturn($deutPs);

        return $planet;
    }

    public function testAffordableWhenResourcesAreAlreadyAvailable(): void
    {
        $strategy = $this->makeStrategy();
        $planet = $this->mockPlanet(1000, 1000, 1000, 0, 0, 0);
        $cost = new Resources(500, 500, 100, 0);

        $this->assertTrue($strategy->canAffordSoon($cost, $planet, 3600));
    }

    public function testAffordableWhenProductionFillsTheGapInTime(): void
    {
        $strategy = $this->makeStrategy();
        // Need 1000m, have 100, produce 1m/s ⇒ 900s ≤ 3600s ⇒ affordable.
        $planet = $this->mockPlanet(100, 100, 100, 1, 1, 1);
        $cost = new Resources(1000, 1000, 1000, 0);

        $this->assertTrue($strategy->canAffordSoon($cost, $planet, 3600));
    }

    public function testNotAffordableWhenProductionIsZeroAndResourceMissing(): void
    {
        $strategy = $this->makeStrategy();
        $planet = $this->mockPlanet(0, 0, 0, 0, 0, 0);
        $cost = new Resources(100, 0, 0, 0);

        $this->assertFalse($strategy->canAffordSoon($cost, $planet, 86400));
    }

    public function testNotAffordableWhenWaitExceedsThreshold(): void
    {
        $strategy = $this->makeStrategy();
        // Need 10000m, have 0, produce 1m/s ⇒ 10000s > 3600s ⇒ NOT affordable.
        $planet = $this->mockPlanet(0, 1_000_000, 1_000_000, 1, 1000, 1000);
        $cost = new Resources(10000, 0, 0, 0);

        $this->assertFalse($strategy->canAffordSoon($cost, $planet, 3600));
    }

    public function testGetMissingResourcesClampsAtZero(): void
    {
        $strategy = $this->makeStrategy();
        $planet = $this->mockPlanet(800, 100, 0, 0, 0, 0);
        $cost = new Resources(500, 300, 200, 0);

        $missing = $strategy->getMissingResources($cost, $planet);

        $this->assertSame(0.0, $missing['metal']);     // surplus → 0
        $this->assertSame(200.0, $missing['crystal']);
        $this->assertSame(200.0, $missing['deuterium']);
    }
}
