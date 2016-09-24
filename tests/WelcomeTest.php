<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->get('/api/v1');

        $this->assertEquals(
            $this->response->getContent(), '{"message":"Welcome to Hall Bookings and management platform"}'
        );
    }
}
