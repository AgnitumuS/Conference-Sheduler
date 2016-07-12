<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Event;
use App\Room;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call('RoomTableSeeder');
        $this->call('EventTableSeeder');
        $this->command->info('Data created');
    }
}

/**
 *
 */
 class RoomTableSeeder extends Seeder
 {
   public function run()
   {
     //DB:table('rooms')->delete();

     Room::Create([
       'name' => 'Большой зал'
     ]);
     Room::Create([
       'name' => 'Малый зал'
     ]);
     Room::Create([
       'name' => 'Филиал'
     ]);
   }
 }


class EventTableSeeder extends Seeder
{
  public function run()
  {
    //DB:table('events')->delete();

    Event::Create([
      'title' => 'Событие 1',
      'room_id' => '1',
      'user_id' => '1',
      'start' => '2016-07-07 08:00',
      'stop' => '2016-07-07 11:00',
      'description' => 'Описание события'
    ]);
    Event::Create([
      'title' => 'Событие 2',
      'room_id' => '1',
      'user_id' => '1',
      'start' => '2016-07-07 15:00',
      'stop' => '2016-07-07 16:30',
      'description' => 'Описание события'
    ]);
    Event::Create([
      'title' => 'Событие 3',
      'room_id' => '1',
      'user_id' => '1',
      'start' => '2016-07-08 12:00',
      'stop' => '2016-07-08 13:00',
      'description' => 'Описание события'
    ]);
  }
}
