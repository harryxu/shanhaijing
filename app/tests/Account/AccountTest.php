<?php

class AccountTest extends TestCase {

    public function testLogin()
    {
        $response = $this->call('POST', 'account/login', array(
            'login' => 'admin',
            'password' => '111111',
        ));

        $this->assertEquals(url('/'), $response->getTargetUrl());
    }
}
