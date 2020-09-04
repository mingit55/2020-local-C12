</header>

<!-- 온라인 집들이 영역 -->
<div class="container padding">
    <div class="d-between align-items-end border-bottom mb-4">
        <div class="pb-3">
            <span class="text-muted">온라인 집들이</span>
            <div class="title">KNOWHOWS</div>
        </div>
        <button class="button-label" data-toggle="modal" data-target="#write-modal">
            글쓰기
            <i class="fa fa-pencil ml-3"></i>
        </button>
    </div>
    <div class="row">
        <?php foreach($knowhows as $knowhow):?>
        <div class="col-lg-4 col-md-6 mb-5">
            <div class="knowhow-item border">
                <div class="image">
                    <img src="/uploads/knowhows/<?=$knowhow->before_img?>" alt="Before 사진" title="Before 사진" class="fit-cover">
                    <img src="/uploads/knowhows/<?=$knowhow->after_img?>" alt="After 사진" title="After 사진" class="fit-cover">
                </div>
                <div class="px-3 py-3">
                    <div class="d-between">
                        <div>
                            <span><?=$knowhow->user_name?></span>
                            <small class="text-muted">(<?=$knowhow->user_id?>)</small>
                            <small class="text-muted ml-3"><?=date("Y-m-d", strtotime($knowhow->created_at))?></small>
                        </div>
                        <div class="text-gold score-value"><i class="mr-1 fa fa-star<?= $knowhow->score == 0 ? '-o' : '' ?>"></i><?= $knowhow->score ?></div>
                    </div>
                    <div class="mt-3">
                        <p class="text-muted fx-n2"><?=nl2br($knowhow->contents)?></p>
                    </div>
                    <?php if(user()->id !== $knowhow->uid && ! $knowhow->reviewed):?>
                        <div class="score-label mt-3 d-between">
                            <small class="text-muted">이 글이 마음에 드시나요?</small>
                            <button class="p-2 text-white fx-n3 bg-blue" data-toggle="modal" data-target="#review-modal" data-id="<?=$knowhow->id?>">평점 주기</button>
                        </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>
<!-- /온라인 집들이 영역 -->

<div id="write-modal" class="modal fade">
    <div class="modal-dialog">
        <form action="/knowhows" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-body px-4 pt-4 pb-3">
                    <div class="text-center title">
                        KNOWHOW
                    </div>
                    <div class="mt-3">  
                        <div class="form-group">
                            <label for="before_img">Before 사진</label>
                            <div class="custom-file">
                                <input type="file" id="before_img" class="custom-file-input" name="before_img" required>
                                <label for="before_img" class="custom-file-label">파일을 업로드 해 주세요</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="after_img">After 사진</label>
                            <div class="custom-file">
                                <input type="file" id="after_img" class="custom-file-input" name="after_img" required>
                                <label for="after_img" class="custom-file-label">파일을 업로드 해 주세요</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea name="contents" id="contents" cols="30" rows="10" placeholder="내용을 입력하세요" require class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button class="w-100 py-3 text-white bg-blue">작성 완료</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div id="review-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body py-3 px-4">
                <div class="text-center text-muted">이 게시글의 평점을 매겨주세요!</div>
                <div class="d-flex justify-content-center mt-3">
                    <button data-value="1" class="border text-gold px-3 py-2 mx-3"><i class="fa fa-star"></i>1</button>
                    <button data-value="2" class="border text-gold px-3 py-2 mx-3"><i class="fa fa-star"></i>2</button>
                    <button data-value="3" class="border text-gold px-3 py-2 mx-3"><i class="fa fa-star"></i>3</button>
                    <button data-value="4" class="border text-gold px-3 py-2 mx-3"><i class="fa fa-star"></i>4</button>
                    <button data-value="5" class="border text-gold px-3 py-2 mx-3"><i class="fa fa-star"></i>5</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        // 글 작성 Escape 처리
        $("#write-modal form").on("submit", e => {
            e.preventDefault();
            $("#write-modal").hide();

            let value = $("#contents").val();

            let arrowedList = ["a", "img"];
            let coupleTags = value.matchAll(/<(?<start>[^\s]+)(?<attributes>[^>]*)>[^<]+<\/(?<end>[^>\s]+)>/g);
            let singleTags = value.matchAll(/<(?<tagName>[^\s\/]+)(?<attributes>[^>]*)\/?>/g);

            let tagList = [...coupleTags, ...singleTags];
            tagList.forEach(tag => {
                const {tagName, start, end, attributes} = tag.groups;

                let matches = !attributes ? false : tagName == "img" ? attributes.match(/src=["'](.+)["']/) : attributes.match(/href=["'](.+)["']/);
                let url = matches ? matches[1] : false;


                try {
                    let checkURL = new URL(url); // 잘못된 링크면 에러가 터진다.
                    if(arrowedList.includes(tagName) || (arrowedList.includes(start) && arrowedList.includes(end))){
                        let replace = tag[0].replace(/</g, "⊆").replace(/>/g, "⊇")      /// 임시로 절대 안쓸법한 기호로 변경해둠
                        value = value.replace(tag[0], replace);   
                    }
                } catch {
                    return;     // 에러가 터지면 다음을 검사
                }
            });

            value = value
                .replace(/</g, "&lt;").replace(/>/g, "&gt;") // 모든 꺽쇠는 이스케이프 처리.
                .replace(/⊆/g, "<").replace(/⊇/g, ">");  // 안쓸법한 문자를 다시 원상복구 시킴

            $("#contents").val(value);
            e.target.submit();
        });


        // 평점 주기
        let kid, score, target;
        $("[data-target='#review-modal']").on("click", e => {
            kid = e.currentTarget.dataset.id;
            target = $(e.target).closest(".knowhow-item");
        });

        $("#review-modal button").on("click", e => {
            score = e.currentTarget.dataset.value;

            $.post("/knowhows/reviews", {kid, score}, function(res){
                if(res.score){
                    target.find(".score-value").html(`<i class="fa fa-star mr-1"></i>${res.score}`);
                    target.find(".score-label").remove();
                    $("#review-modal").modal("hide");
                }
            });
        });
    });
</script>