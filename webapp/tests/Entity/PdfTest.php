<?php
namespace App\Tests\Entity;

use App\Entity\Pdf;
use PHPUnit\Framework\TestCase;

class PdfTest extends TestCase
{
    public function testGetterAndSetter()
    {
        $pdf = new Pdf();

        // Defining pdf data
        $title = 'Pdf title';
        $created_at = new \DateTimeImmutable();

        // Setting pdf data
        $pdf->setTitle($title);
        $pdf->setCreatedAt($created_at);

        // Checking pdf data
        $this->assertEquals($title, $pdf->getTitle());
        $this->assertEquals($created_at, $pdf->getCreatedAt());

        // Checking pdf data type
        $this->assertIsString($pdf->getTitle());
        $this->assertInstanceOf(\DateTimeImmutable::class, $pdf->getCreatedAt());
    }
}