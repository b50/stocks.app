<?php use Illuminate\Database\Seeder;

class KeyValueTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('key_value')->delete();
        \App\Models\KeyValue::create([
            'key' => 'eotm_why',
            'value' => 'Did something good...',
        ]);
        \App\Models\KeyValue::create([
            'key' => 'eotm_user_id',
            'value' => 2
        ]);
        \App\Models\KeyValue::create([
            'key' => 'eotm_month',
            'value' => 2
        ]);
    }

}