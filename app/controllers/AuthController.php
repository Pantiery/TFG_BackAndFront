<?php

class AuthController {

    public function login() {
        echo json_encode([
            "status" => "ok",
            "message" => "Login funciona 🔥"
        ]);
    }
}