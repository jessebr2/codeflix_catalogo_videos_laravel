<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuid;


class CategoryTest extends TestCase
{
    private $category;

    public static function setUpBeforeClass(): void // executado apenas uma vez
    {
        parent::setUpBeforeClass();

    }
    
    protected function setUp(): void //Antes do teste de cada método
    {
        parent::setUp();
        $this->category = new Category();
    }

    protected function tearDown(): void //Após o teste de cada método
    {

        parent::tearDown();

    }

    public static function tearDownAfterClass(): void //Executado uma vez após os testes
    {
        parent::tearDownAfterClass(); 
    }

    public function testFillableAttribute()
    {
        $fillable = ['name', 'description', 'is_active'];
        $this->assertEquals($fillable, $this->category->getFillable());
    }

    public function testIfUseTraits()
    {
        $traits_required = [SoftDeletes::class, Uuid::class];
        $category_traits = array_keys(class_uses(Category::class));
        $this->assertEquals($traits_required, $category_traits);
    }

    public function testCasts()
    {
        $casts = [
            'id' => 'string',
            'is_active' => 'boolean'
            ];
        $this->assertEquals($casts, $this->category->getCasts());
    }

    public function testIncrementing()
    {
        $this->assertFalse($this->category->incrementing);
    }

    public function testDatesAttribute()
    {
        $dates = ['deleted_at', 'created_at', 'updated_at'];
        foreach ($dates as $date) {
            $this->assertContains($date, $this->category->getDates());
        }
        $this->assertCount(count($dates), $this->category->getDates());
    }

}
