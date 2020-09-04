</header>

<!-- 회원 리스트 -->
<div class="container padding">
    <div class="pt-4 sticky-top bg-white">
        <span class="text-muted">회원 리스트</span>
        <div class="title">USERLIST</div>
        <div class="table-head mt-3">
            <div class="cell-30">등급</div>
            <div class="cell-40">회원 정보</div>
            <div class="cell-30">+</div>
        </div>
    </div>
    <div class="list">
        <?php foreach($users as $user):?>
        <div class="table-item">
            <div class="cell-30">
                <?php if($user->auth):?>
                    <span class="fx-n3 px-3 py-2 rounded-pill bg-gold text-white">전문가</span>
                <?php else:?>
                    <span class="fx-n3 px-3 py-2 rounded-pill bg-gold text-white">일반 회원</span>
                <?php endif;?>
            </div>
            <div class="cell-40">
                <span><?=$user->user_name?></span>
                <small class="text-muted">(<?=$user->user_id?>)</small>
            </div>
            <div class="cell-30">
                <?php if($user->auth):?>
                    <button class="p-2 text-white bg-blue fx-n3" data-target="#downgrade-modal" data-toggle="modal" data-id="<?=$user->id?>">강등</button>
                <?php else :?>
                    <button class="p-2 text-white bg-blue fx-n3" data-target="#upgrade-modal" data-toggle="modal" data-id="<?=$user->id?>">전문가 승급</button>
                <?php endif;?>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>
<!-- 회원 리스트 -->

<!-- 승급 모달 -->
<div id="upgrade-modal" class="modal fade">
    <div class="modal-dialog">
        <form action="/users/upgrade" method="post">
            <input type="hidden" id="up_uid" name="uid">
            <div class="modal-content">
                <div class="modal-body py-4 px-4">
                    <div class="text-muted text-center">해당 회원을 전문가로 승급시키겠습니까?</div>
                    <div class="mt-4 text-center">
                        <button class="button-label py-2 bg-gold mr-2">확인</button>
                        <button class="button-label py-2 cancel">취소</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /승급 모달 -->

<!-- 강등 모달 -->
<div id="downgrade-modal" class="modal fade">
    <div class="modal-dialog">
        <form action="/users/downgrade" method="post">
            <input type="hidden" id="down_uid" name="uid">
            <div class="modal-content">
                <div class="modal-body py-4 px-4">
                    <div class="text-muted text-center">해당 회원을 일반회원으로 강등시키겠습니까?</div>
                    <div class="mt-4 text-center">
                        <button class="button-label py-2 bg-gold mr-2">확인</button>
                        <button class="button-label py-2 cancel">취소</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /강등 모달 -->


<script>
    $(function(){
        $("[data-target='#upgrade-modal']").on("click", e => {
            $("#up_uid").val(e.currentTarget.dataset.id);
        });

        $("[data-target='#downgrade-modal']").on("click", e => {
            $("#down_uid").val(e.currentTarget.dataset.id);
        });

        $(".cancel").on("click", e => {
            e.preventDefault();
            $(e.target).closest(".modal").modal("hide");
            return false;
        });
    });
</script>
