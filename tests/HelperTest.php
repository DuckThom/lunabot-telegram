<?php

namespace Tests;

/**
 * Helper tests
 *
 * @package Tests
 */
class HelperTest extends TestCase
{
    /**
     * @test
     */
    public function envTest()
    {
        $this->assertEquals("blaat", env('TEST', 'blaat'));
    }

    /**
     * @test
     */
    public function basePathTest()
    {
        $this->assertEquals(realpath(__DIR__.'/../'), base_path());
        $this->assertEquals(realpath(__DIR__), base_path('tests'));
    }

    /**
     * @test
     */
    public function botPathTest()
    {
        $this->assertEquals(realpath(__DIR__.'/../bot'), bot_path());
        $this->assertEquals(realpath(__DIR__.'/../bot/foo'), bot_path('foo'));
    }

    /**
     * @test
     */
    public function storagePathTest()
    {
        $this->assertEquals(realpath(__DIR__.'/../storage'), storage_path());
        $this->assertEquals(realpath(__DIR__.'/../storage/foo'), storage_path('foo'));
    }
}