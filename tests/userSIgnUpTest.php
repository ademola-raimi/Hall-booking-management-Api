<?php

use App\user;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserSignUpTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test that user sign up successfully
     */
    public function testForEmptyFields()
    {
        $user = factory('App\User')->create();

        $response = $this->call('POST', '/api/v1/register', [
            
        ]);

        $json = json_decode($response->getContent());

        $this->assertEquals(
            $this->response->getContent(), '{"username":["The username field is required."],"email":["The email field is required."],"password":["The password field is required."],"first_name":["The first name field is required."],"last_name":["The last name field is required."]}'
        );
    }

    public function testForSuccessfulSignup()
    {
        $user = factory('App\User')->create();

        $response = $this->call('POST', '/api/v1/register', [
            'username'     => 'Demo',
            'email'        => 'demola@gmail.com',
            'password'     => password_hash('london', PASSWORD_DEFAULT),
            'first_name'   => 'Demola',
            'last_name'    => 'Raimi',
            'avatar'       => 'https://en.gravatar.com/userimage/102347280/b3e9c138c1548147b7ff3f9a2a1d9bb0.png?size=200',
            'provider'     => '',
            'provider_id'  => '',
        ]);

        $json = json_decode($response->getContent());
        
        $this->seeStatusCode(201);
        $this->assertEquals(
            $this->response->getContent(), '{"username":["The username field is required."],"email":["The email field is required."],"password":["The password field is required."],"first_name":["The first name field is required."],"last_name":["The last name field is required."]}'
        );
    }
}
