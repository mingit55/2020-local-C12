<?php
require __DIR__."/App/DB.php";


use App\DB;

for($i = 1; $i <= 4; $i++){
    DB::query("INSERT INTO users (user_id, password, user_name, photo, auth) VALUES (?, ?, ?, ?, 1)", ["specialist$i", hash('sha256', '1234'), "전문가$i", "specialist$i.jpg"]);
}

DB::query("INSERT INTO users(user_id, password, user_name, photo) VALUES (?, ?, ?, ?)", ["admin", hash("sha256", "1234"), "관리자", "specialist3.jpg"]);