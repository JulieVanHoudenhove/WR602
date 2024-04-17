<?php
namespace App\Tests\Entity;

use App\Entity\Subscription;
use PHPUnit\Framework\TestCase;

class SubscriptionTest extends TestCase
{
    public function testGetterAndSetter()
    {
        $subscription = new Subscription();

        // Defining subscription data
        $title = 'Subscription title';
        $description = 'Subscription description';
        $pdf_limit = 10;
        $price = 10.0;
        $media = 'Subscription media';

        // Setting subscription data
        $subscription->setTitle($title);
        $subscription->setDescription($description);
        $subscription->setPdfLimit($pdf_limit);
        $subscription->setPrice($price);
        $subscription->setMedia($media);

        // Checking subscription data
        $this->assertEquals($title, $subscription->getTitle());
        $this->assertEquals($description, $subscription->getDescription());
        $this->assertEquals($pdf_limit, $subscription->getPdfLimit());
        $this->assertEquals($price, $subscription->getPrice());
        $this->assertEquals($media, $subscription->getMedia());

        // Checking subscription data type
        $this->assertIsString($subscription->getTitle());
        $this->assertIsString($subscription->getDescription());
        $this->assertIsInt($subscription->getPdfLimit());
        $this->assertIsFloat($subscription->getPrice());
        $this->assertIsString($subscription->getMedia());
    }
}