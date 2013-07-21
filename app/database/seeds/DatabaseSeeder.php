<?php

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call('UserTableSeeder');
    }

}

class UserTableSeeder extends Seeder {

    public function run()
    {
        $admin = Sentry::getUserProvider()->create(array(
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => '111111',
            'activated' => 1,
            'permissions' => array(
                'superuser' => 1,
            ),
        ));
    }
}
