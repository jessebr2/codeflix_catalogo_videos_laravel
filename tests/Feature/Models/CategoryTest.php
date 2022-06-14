<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        factory(Category::class, 1)->create();
        $categories = Category::all();
        $this->assertCount(1, $categories);
        $categoryKeys = array_keys($categories->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            [
                'id', 
                'name', 
                'description', 
                'is_active',
                'created_at', 
                'updated_at', 
                'deleted_at'
            ],
            $categoryKeys
        );
    }

    public function testCreate()
    {
        $category = Category::create([
            'name' => 'test1'
        ]);
        $category->refresh();

        $this->assertEquals('test1', $category->name);
        $this->assertNull($category->description);
        $this->assertTrue($category->is_active);

        $category = Category::create([
            'name' => 'test1',
            'description' => null
        ]);
        $this->assertNull($category->description);

        $category = Category::create([
            'name' => 'test1',
            'description' => 'test_description'
        ]);
        $this->assertequals('test_description', $category->description);

        $category = Category::create([
            'name' => 'test1',
            'is_active' => false
        ]);
        $this->assertFalse($category->is_active);

        $category = Category::create([
            'name' => 'test1',
            'is_active' => true
        ]);
        $this->assertTrue($category->is_active);

        $this->assertTrue((bool)preg_match( // check if $category->id is uuid like
            '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', // regex uuid
            $category->id
        ));
    }

    public function testUpdate()
    {
        /** @var Category $category */

        $category = factory(Category::class)->create([
            'description' => 'test_description'
        ])->first();

        $data = [
            'name' => 'test_name_updated',
            'description' => 'test_description_updated',
            'is_active' => true
        ];

        $category->update($data);

        foreach($data as $key => $value){
            $this->assertEquals($value, $category->{$key});
        }
    }

    public function testDelete()
    {
        /** @var Category $category */

        $category = factory(Category::class)->create([
            'description' => 'test_description'
        ])->first();
        $categories = Category::all();
        $this->assertCount(1, $categories);

        $category->delete();

        $categories = Category::all();
        $this->assertCount(0, $categories);

        $category->restore();
        $this->assertNotNull(Category::find($category->id));
    }
}