<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class ApiTest extends TestCase
{

    protected $passwords = [
        'good' => 'Test1234@',
        'bad' => 'mypass'
    ];

    public static $token;

    /**
     *
     * @return string
     */
    protected function getEmail()
    {
        static $email;

        if (is_null($email)) {
            $rnd = str_pad((string) rand(1, 999999999999), 12, '0', STR_PAD_LEFT);
            $email = "{$rnd}@gmail.com";
        }

        return $email;
    }

    /**
     * Test validation error - bad password (too short)
     */
    public function testUserRegisterErrorBadPassword()
    {
        $response = $this->postJson('/api/user/register', [
            'email' => $this->getEmail(),
            'password' => $this->passwords['bad'],
            'password_confirmation' => $this->passwords['bad']
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrorFor('password');
    }

    /**
     * Test validation error - not equal password confirmation
     */
    public function testUserRegisterErrorPasswordConfirmation()
    {
        $response = $this->postJson('/api/user/register', [
            'email' => $this->getEmail(),
            'password' => $this->passwords['good'],
            'password_confirmation' => $this->passwords['good'] . '123' // Make pass confirmation unequal
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrorFor('password_confirmation');
    }

    /**
     * Test validation error - wrong email domain
     */
    public function testUserRegisterErrorBadEmailDomain()
    {
        $response = $this->postJson('/api/user/register', [
            'email' => $this->getEmail() . '123', // Make email domain unexist
            'password' => $this->passwords['good'],
            'password_confirmation' => $this->passwords['good']
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrorFor('email');
    }

    /**
     * Test validation error - no password
     */
    public function testUserRegisterErrorNoPassword()
    {
        $response = $this->postJson('/api/user/register', [
            'email' => $this->getEmail(),
            // 'password' => ,
            'password_confirmation' => $this->passwords['good']
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrorFor('password');
    }

    /**
     * Test succes user registration
     */
    public function testUserRegisterSuccess()
    {
        $response = $this->postJson('/api/user/register', [
            'email' => $this->getEmail(),
            'password' => $this->passwords['good'],
            'password_confirmation' => $this->passwords['good']
        ]);

        $response->assertStatus(201);
    }

    /**
     * Test error - Email already exists
     */
    public function testUserRegisterErrorEmailAlreadyExists()
    {
        $response = $this->postJson('/api/user/register', [
            'email' => $this->getEmail(),
            'password' => $this->passwords['good'],
            'password_confirmation' => $this->passwords['good']
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test auth token error - Invalide credentials
     */
    public function testAuthTokenErrorInvalideCredentials()
    {
        $response = $this->postJson('/api/auth/token', [
            'email' => $this->getEmail(),
            'password' => $this->passwords['good'] . '123'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrorFor('email');
    }

    /**
     *
     */
    public function testAuthTokenSuccess()
    {
        $response = $this->postJson('/api/auth/token', [
            'email' => $this->getEmail(),
            'password' => $this->passwords['good']
        ]);

        $response->assertStatus(200);

        self::$token = json_decode($response->getContent(), false)->token;
    }

    /**
     *
     */
    public function testUserOptionEditErrorUnauthenticated()
    {
        $response = $this->postJson('/api/user/option/edit', [
            'language' => 'en',
            'timezone' => 'Europe/Moscow',
        ]);

        $response->assertStatus(401);
    }

    /**
     *
     */
    public function testUserOptionEditErrorBadLanguage()
    {
        $response = $this->postJson('/api/user/option/edit', [
            'language' => 'xx',
            'timezone' => 'Europe/Moscow',
        ], [
            'Authorization' => 'Bearer ' . self::$token,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrorFor('language');
    }

    /**
     *
     */
    public function testUserOptionEditErrorBadTimezone()
    {
        $response = $this->postJson('/api/user/option/edit', [
            'language' => 'ru',
            'timezone' => 'Asia/Moscow',
        ], [
            'Authorization' => 'Bearer ' . self::$token,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrorFor('timezone');
    }

    /**
     *
     */
    public function testUserOptionEditSuccess()
    {
        $response = $this->postJson('/api/user/option/edit', [
            'language' => 'fr',
            'timezone' => 'Europe/Paris',
        ], [
            'Authorization' => 'Bearer ' . self::$token,
        ]);

        $response->assertStatus(200)->assertJsonPath('updated', true);
    }

    /**
     *
     */
    public function testUserOptionEditSuccessWithoutModification()
    {
        $response = $this->postJson('/api/user/option/edit', [
            'language' => 'fr',
            'timezone' => 'Europe/Paris',
        ], [
            'Authorization' => 'Bearer ' . self::$token,
        ]);

        $response->assertStatus(200)->assertJsonPath('updated', false);
    }

    /**
     *
     */
    public function finalCleaning()
    {
        $user = User::where('email', $this->getEmail())->first();
        $this->assertNotNull($user)
            ->accertTrue($user->languageOption == 'fr')
            ->accertTrue($user->timezoneOption == 'Europe/Paris');
        $user->delete();

    }
}
