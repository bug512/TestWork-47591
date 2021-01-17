<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SiteCardTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Testing the function of displaying the list of site cards.
     *
     * @return void
     */
    public function testListSiteCards()
    {
        $response = $this->get('/api/sitecard');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'url',
                        'description',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }

    /**
     * Testing the function of creating site cards.
     */
    public function testCreateSiteCard()
    {
        $data = [
            'data' => [
                'type' => 'site_card',
                'attributes' => [
                    'action' => 'create',
                    'title' => 'test',
                    'url' => 'http://test.com',
                    'description' => 'test',
                ],
            ],
        ];

        $headers = [
            'Content-Type' => 'application/vnd.api+json',
        ];

        $response = $this->json('POST', 'api/sitecard', $data, $headers);

        $response
            ->assertStatus(200)
            ->assertJson(['message' => 'Successfully created']);
    }

    /**
     * Testing the function of updating site cards.
     */
    public function testUpdateSiteCard()
    {
        $data = [
            'data' => [
                'type' => 'site_card',
                'attributes' => [
                    'action' => 'update',
                    'title' => 'test',
                    'url' => 'http://test.com',
                    'description' => 'test',
                ],
            ],
        ];

        $headers = [
            'Content-Type' => 'application/vnd.api+json',
        ];

        $response = $this->json('PUT', 'api/sitecard/1', $data, $headers);

        $response
            ->assertStatus(200)
            ->assertJson(['message' => 'Successfully updated']);
    }

    /**
     * Testing the function of removing site cards.
     */
    public function testDestroySiteCard()
    {
        $response = $this->delete('/api/sitecard/1');

        $response
            ->assertStatus(200)
            ->assertJson(['message' => 'Removed successfully']);
    }
}
