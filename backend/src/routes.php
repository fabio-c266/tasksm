<?php

use src\Core\Routes;

try {
    Routes::post("/user", "UserController::create");
    Routes::post("/auth/login", "AuthController::login");

    Routes::post("/task", "TaskController::create", true);
    Routes::get("/tasks", "TaskController::get", true);
    Routes::get("/tasks/all", "TaskController::getAll", true);
    Routes::get("/tasks/status", "TaskController::getAllStatus", true);
    Routes::put("/tasks", "TaskController::update", true);
    Routes::delete("/tasks", "TaskController::delete", true);

} catch (Exception $except) {
//    die($except->getMessage());
}
