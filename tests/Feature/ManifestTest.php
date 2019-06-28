<?php

namespace Tests\Feature;

use App\Manifest;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManifestTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function can_see_the_manifest()
	{
		$response = $this->get('/manifest');

        $response->assertStatus(200)
                ->assertSeeText('Manifest');
	}

	/** @test */
	public function can_return_collection_of_manifest()
	{
		$this->withoutExceptionHandling();

		$this->post('/manifest', [
        	'name' => 'Emmanuel',
        	'gender' => 'male',
        	'seat_number' => 7,
        	'phone' => '424755432',
        	'address' => '12 Fasoro, surulere',
        ]);
        $this->post('/manifest', [
        	'name' => 'Emmanuel2',
        	'gender' => 'male',
        	'seat_number' => 3,
        	'phone' => '424755432',
        	'address' => '13 Fasoro, surulere',
        ]);

        $response = $this->get('/manifest');
        $this->assertCount(2, Manifest::all());

        $response->assertOk();
	}

    /** @test */
    public function passengers_details_can_be_added()
    {
    	$this->withoutExceptionHandling();

        $response = $this->post('/manifest', [
        	'name' => 'Emmanuel',
        	'gender' => 'male',
        	'seat_number' => 7,
        	'phone' => '424755432',
        	'address' => '12 Fasoro, surulere',
        ]);

        $this->assertCount(1, Manifest::all());
        $this->assertDatabaseHas('manifests', [
    		'name' => 'Emmanuel',
        	'gender' => 'male',
        	'seat_number' => 7,
        	'phone' => '424755432',
        	'address' => '12 Fasoro, surulere',
    	]);

        $response->assertRedirect('/manifest');
    }

    /** @test */
    public function all_inputs_must_be_validated()
    {
    	// $this->withoutExceptionHandling();

    	$response = $this->post('/manifest', [
    		'name' => '',
        	'gender' => '',
        	'seat_number' => '',
        	'phone' => '',
        	'address' => '',
    	]);

    	$response->assertSessionHasErrors(['name','gender','seat_number','phone','address']);
    }

    /** @test */
    public function passengers_details_can_be_updated()
    {
    	$this->withoutExceptionHandling();

    	$this->post('/manifest', [
        	'name' => 'Emmanuel',
        	'gender' => 'male',
        	'seat_number' => 7,
        	'phone' => '424755432',
        	'address' => '12 Fasoro, surulere',
        ]);

        $passenger = Manifest::first();
        $response = $this->put('/manifest/'.$passenger->id, [
        	'name' => 'John',
        	'gender' => 'female',
        	'seat_number' => 4,
        	'phone' => '0804245432',
        	'address' => '12 johnson, canada',
        ]);

        $this->assertDatabaseHas('manifests', [
    		'name' => 'John',
        	'gender' => 'female',
        	'seat_number' => 4,
        	'phone' => '0804245432',
        	'address' => '12 johnson, canada',
    	]);

        $response->assertRedirect('/manifest');
    }

    /** @test */
    public function passengers_details_can_be_deleted()
    {
    	$this->withoutExceptionHandling();

    	$this->post('/manifest', [
        	'name' => 'Emmanuel',
        	'gender' => 'male',
        	'seat_number' => 7,
        	'phone' => '424755432',
        	'address' => '12 Fasoro, surulere',
        ]);

    	$passenger = Manifest::first();
        $response = $this->delete('/manifest/'.$passenger->id, [
        	'name' => 'John',
        	'gender' => 'female',
        	'seat_number' => 4,
        	'phone' => '0804245432',
        	'address' => '12 johnson, canada',
        ]);

        $this->assertCount(0, Manifest::all());
        $response->assertRedirect('/manifest');
    }
}
