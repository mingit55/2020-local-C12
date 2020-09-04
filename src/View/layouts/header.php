<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내집꾸미기</title>
    <script src="/resources/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="/resources/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <script src="/resources/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/resources/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/resources/css/style.css">
    <script>
        $(function(){
            $(".custom-file-input").on("change", function(){
                if(this.files.length > 0){
                    $(this).siblings(".custom-file-label").text(this.files[0].name);
                } else {
                    $(this).siblings(".custom-file-label").text("파일을 업로드 해 주세요");
                }
            });

            $("[data-target='#sign-up']").on("click", function(){
                let canvas = $("#cap_canvas")[0];
                let ctx = canvas.getContext("2d");
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.font = "50px 나눔스퀘어, sans-serif";
                
                let text = Math.random().toString(36).substr(2, 5).split("").map(item => parseInt( Math.random() * 10 ) % 2 === 0 ? item.toUpperCase() : item).join("");
                let width = ctx.measureText(text).width;
                
                ctx.fillText(text, canvas.width / 2 - width / 2, canvas.height / 2 + 20);
                $("#cap_answer").val(text);
            });

            <?php if(user()):?>
            $.get("/session/update");
            <?php endif;?>
        });
    </script>
</head>
<body>
    <!-- 로그인 -->
    <div id="sign-in" class="modal fade">
        <div class="modal-dialog">
            <form method="post" action="/sign-in">
                <div class="modal-content">
                    <div class="modal-body px-4 pt-4 pb-3">
                        <div class="text-center title">
                            SIGN IN
                        </div>
                        <div class="mt-3">  
                            <div class="form-group">
                                <label for="login_id">아이디</label>
                                <input type="text" id="login_id" class="form-control" name="user_id" placeholder="아이디를 입력하세요" required>
                            </div>
                            <div class="form-group">
                                <label for="login_pw">비밀번호</label>
                                <input type="password" id="login_pw" class="form-control" name="password" placeholder="비밀번호를 입력하세요" required>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="w-100 py-3 text-white bg-blue">로그인</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /로그인 -->

    <!-- 회원가입 -->
    <div id="sign-up" class="modal fade">
        <div class="modal-dialog">
            <form action="sign-up" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-body px-4 pt-4 pb-3">
                        <div class="text-center title">
                            SIGN UP
                        </div>
                        <div class="mt-3">  
                            <div class="form-group">
                                <label for="join_id">아이디</label>
                                <input type="text" id="join_id" class="form-control" name="user_id" placeholder="아이디를 입력하세요" required>
                            </div>
                            <div class="form-group">
                                <label for="join_pw">비밀번호</label>
                                <input type="password" id="join_pw" class="form-control" name="password" placeholder="비밀번호를 입력하세요" required>
                            </div>
                            <div class="form-group">
                                <label for="join_name">이름</label>
                                <input type="text" id="join_name" class="form-control" name="user_name" placeholder="이름을 입력하세요" required>
                            </div>
                            <div class="form-group">
                                <label for="join_photo">사진</label>
                                <div class="custom-file">
                                    <input type="file" id="join_photo" class="custom-file-input" name="photo" required>
                                    <label for="join_photo" class="custom-file-label">파일을 업로드 해 주세요</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" id="cap_answer" name="cap_answer">
                                <canvas id="cap_canvas" class="w-100 border" width="450" height="100"></canvas>
                                <input type="text" id="cap_input" class="form-control" name="cap_input" placeholder="상단의 문자열을 입력하세요" required>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="w-100 py-3 text-white bg-blue">가입 완료</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /회원가입 -->


    <!-- 헤더 영역 -->
    <header <?= $currentURL !== "/" ? "class='no-visual'" : "" ?>>
        <!-- GNB -->
        <div id="gnb">
            <div class="d-between align-items-lg-end h-100 px-4 py-3">
                <a href="/">
                    <img src="/resources/images/logo.svg" alt="내집꾸미기" title="내집꾸미기" height="60">
                </a>
                <div class="nav position-center mt-3 d-none d-lg-flex">
                    <a href="/">
                        <span class="icon mb-2">
                            <i class="fa fa-home fa-2x"></i>
                        </span>    
                        홈
                    </a>
                    <a href="/online-party">
                        <span class="icon mb-2">
                            <i class="fa fa-search fa-2x"></i>
                        </span>    
                        온라인 집들이
                    </a>
                    <a href="/store">
                        <span class="icon mb-2">
                            <i class="fa fa-shopping-cart fa-2x"></i>
                        </span>    
                        스토어
                    </a>
                    <a href="/experts">
                        <span class="icon mb-2">
                            <i class="fa fa-user-secret fa-2x"></i>
                        </span>    
                        전문가
                    </a>
                    <a href="/estimates">
                        <span class="icon mb-2">
                            <i class="fa fa-file-text fa-2x"></i>
                        </span>    
                        시공 견적
                    </a>
                    <?php if(admin()):?>
                    <a href="/management">
                        <span class="icon mb-2">
                            <i class="fa fa-user fa-2x"></i>
                        </span>    
                        관리자 메뉴
                    </a>
                    <?php endif;?>
                </div>
                <div>
                    <div class="auth d-none d-lg-flex">
                        <?php if(user()):?>
                            <span class="text-gold fx-n2">&lt;<?=user()->user_name?>&gt;(&lt;<?=user()->user_id?>&gt;)</span>
                            <a href="/logout">로그아웃</a>
                        <?php else:?>
                            <a href="#" data-toggle="modal" data-target="#sign-in">로그인</a>
                            <a href="#" data-toggle="modal" data-target="#sign-up">회원가입</a>
                        <?php endif;?>
                    </div>
                    <div class="menu-icon d-lg-none mr-4">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <div class="menu d-lg-none">
                        <div class="inner">
                            <div class="m-nav">
                                <a href="/">홈</a>
                                <a href="/online-party">온라인 집들이</a>
                                <a href="/store">스토어</a>
                                <a href="/experts">전문가</a>
                                <a href="/estimates">시공 견적</a>
                                <?php if(admin()):?>
                                    <a href="/management">관리자 메뉴</a>
                                <?php endif;?>
                            </div>
                            <div class="m-auth">
                                <?php if(user()):?>
                                    <span class="text-gold fx-n2"><<?=user()->user_name?>>(<<?=user()->user_id?>>)</span>
                                    <a href="/logout">로그아웃</a>
                                <?php else:?>
                                    <a href="#" data-toggle="modal" data-target="#sign-in">로그인</a>
                                    <a href="#" data-toggle="modal" data-target="#sign-up">회원가입</a>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /GNB -->