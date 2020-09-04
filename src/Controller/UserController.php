<?php
namespace Controller;

use App\DB;

class UserController {
    function signIn(){
        checkInput();
        extract($_POST);

        $user = DB::who($user_id);

        if(!$user || $user->password !== hash('sha256', $password)) back("아이디 또는 비밀번호가 일치하지 않습니다.");
        
        $_SESSION['user'] = $user;
        go("/", "로그인 되었습니다.");
    }
    function signUp(){
        checkInput();
        extract($_POST);

        $user = DB::who($user_id);

        if($user) back("중복되는 아이디입니다. 다른 아이디를 사용해주세요.");
        if($cap_input !== $cap_answer) back("자동입력방지 문자를 잘못 입력하였습니다.");


        $photo = $_FILES['photo'];
        $filename = time().extname($photo);
        move_uploaded_file($photo['tmp_name'], _UPLOADS."/users/$filename");

        
        DB::query("INSERT INTO users(user_id, password, user_name, photo) VALUES (?, ?, ?, ?)", [$user_id, hash('sha256', $password), $user_name, $filename]);

        go("/", "회원가입 되었습니다.");
    }

    function logout(){
        unset($_SESSION['user']);
        go("/", "로그아웃 되었습니다.");
    }

    function sessionUpdate(){
        $user = DB::who(user()->user_id);
        $_SESSION['user'] = $user;
    }

    // 관리자 페이지
    function expertPage(){
        $sql = "SELECT DISTINCT U.*, IFNULL(score, 0) score
                FROM users U
                LEFT JOIN (SELECT FLOOR(AVG(score)) score, eid FROM expert_reviews GROUP BY eid) R ON R.eid = U.id
                WHERE U.auth = 1";
        $experts = DB::fetchAll($sql);

        $sql = "SELECT DISTINCT R.*, U.user_name, U.user_id, E.user_name e_name, E.user_id e_id
                FROM expert_reviews R
                LEFT JOIN users U ON U.id = R.uid
                LEFT JOIN users E ON E.id = R.eid";
        $reviews = DB::fetchAll($sql);

        view("expert", ["experts" => $experts, "reviews" => $reviews]);
    }

    function reviewExpert(){
        checkInput();
        extract($_POST);

        DB::query("INSERT INTO expert_reviews(uid, eid, price, score, contents) VALUES (?, ?, ?, ?, ?)", [user()->id, $eid, $price, $score, $contents]);
        go("/experts", "후기가 작성되었습니다.");
    }


    // 관리자 페이지
    function managePage(){
        $sql = "SELECT * FROM users WHERE user_id <> 'admin'";
        $users = DB::fetchAll($sql);
        view("management", ["users" => $users]);
    }

    function upgradeUser(){
        checkInput();
        extract($_POST);

        DB::query("UPDATE users SET auth = 1 WHERE id = ?", [$uid]);
        go("/management", "전문가로 승급되었습니다.");
    }

    function downgradeUser(){
        checkInput();
        extract($_POST);
        
        DB::query("UPDATE users SET auth = 0 WHERE id = ?", [$uid]);   // 해당 전문가 강등
        DB::query("DELETE FROM expert_reviews WHERE eid = ?", [$uid]); // 해당 전문가 후기 삭제
        DB::query("UPDATE requests SET sid = NULL WHERE sid IN (SELECT id FROM responses WHERE uid = ?)", [$uid]); // 해당 전문가의 견적를 선택한 모든 요청을 취소
        DB::query("DELETE FROM responses WHERE uid = ?", [$uid]); // 해당 전문가가 보낸 견적 삭제

        go("/management", "일반회원으로 강등되었습니다.");
    }
}