<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Review;
use Laravel\Sanctum\Sanctum;

use function PHPUnit\Framework\assertJson;

class ReviewTest extends TestCase
{
    use RefreshDatabase;


    public function test_user_can_list_all_review()
    {
     $count = 5;
     Review::factory()->count($count)->create();

     $user = User::factory()->createOne();
     Sanctum::actingAs($user);
  
     $this->getJson(route('reviews.index'))
          ->assertOk()
          ->assertJsonCount($count);
    }
  
    public function test_user_can_create_review()
    {
     $data = Review::factory()->makeOne()->toArray();

     $user = User::factory()->createOne();
     Sanctum::actingAs($user);
  
     $this->postJson(route('reviews.store'),$data)
          ->assertCreated()
          ->assertJsonStructure(array_keys($data));
         
    }
  
    public function test_user_can_show_review()
    {
      $data = Review::factory()->createOne();

      $user = User::factory()->createOne();
      Sanctum::actingAs($user);
  
      $this->getJson(route('reviews.show', $data))
           ->assertOk()
           ->assertJsonStructure(array_keys($data->toArray()));
    }
  
    public function test_user_can_edit_review()
    {
      $updateData = Review::factory()->makeOne()->toArray();
  
      $data = Review::factory()->createOne();

      $user = User::factory()->createOne();
      Sanctum::actingAs($user);
  
      $this->patchJson(route('reviews.update', $data), $updateData )
           ->assertOk()
           ->assertJsonStructure(array_keys($updateData));
  
    }
  
    public function test_user_can_delete_review()
    {
      $data = Review::factory()->createOne();

      $user = User::factory()->createOne();
      Sanctum::actingAs($user);
  
      $this->patchJson(route('reviews.destroy', $data))
           ->assertOk()
           ->assertJsonStructure(array_keys($data->toArray()));
    }
    
}
