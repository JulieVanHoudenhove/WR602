<?php
namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetterAndSetter()
    {
        $user = new User();

        // Defining user data
        $email = 'test@test.com';
        $password = 'password';
        $roles = ['ROLE_USER'];
        $firstname = 'John';
        $lastname = 'Doe';
        $created_at = new \DateTimeImmutable();
        $subscription_end_at = new \DateTimeImmutable();

        // Setting user data
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setRoles($roles);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setCreatedAt($created_at);
        $user->setSubscriptionEndAt($subscription_end_at);

        // Checking user data
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($password, $user->getPassword());
        $this->assertEquals($roles, $user->getRoles());
        $this->assertEquals($firstname, $user->getFirstname());
        $this->assertEquals($lastname, $user->getLastname());
        $this->assertEquals($created_at, $user->getCreatedAt());
        $this->assertEquals($subscription_end_at, $user->getSubscriptionEndAt());

        // Checking user data type
        $this->assertIsString($user->getEmail());
        $this->assertIsString($user->getPassword());
        $this->assertIsArray($user->getRoles());
        $this->assertIsString($user->getFirstname());
        $this->assertIsString($user->getLastname());
        $this->assertInstanceOf(\DateTimeImmutable::class, $user->getCreatedAt());
        $this->assertInstanceOf(\DateTimeImmutable::class, $user->getSubscriptionEndAt());
    }
}