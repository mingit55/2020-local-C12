</header>
<!-- /헤더 영역 -->

<!-- 장바구니 영역 -->
<div class="container padding">
    <div class="pt-4 sticky-top bg-white">
        <div>
            <span class="text-muted">장바구니</span>
            <div class="title">CART</div>
        </div>
        <div class="mt-3 table-head">
            <div class="cell-50">상품 정보</div>
            <div class="cell-15">가격</div>
            <div class="cell-10">수량</div>
            <div class="cell-15">합계</div>
            <div class="cell-10">+</div>
        </div>
    </div>
    <div id="cart-list">
        <div class="py-4 text-center text-muted fx-n2 w-100">장바구니에 담긴 상품이 없습니다.</div>
    </div>
    <div class="mt-3 d-between">
        <div>
            <span class="text-muted">총합계</span>
            <span class="total-price ml-3 fx-3 text-gold">0</span>
            <small class="text-muted">원</small>
        </div>
        <div>
            <button data-target="#history-modal" data-toggle="modal" class="button-label bg-gold mr-2">구매리스트 보기</button>
            <button id="reset-history" class="button-label bg-gold mr-2">구매리스트 초기화</button>
            <button class="button-label" data-toggle="modal" data-target="#buy-modal">구매하기</button>
        </div>
    </div>
</div>
<!-- /장바구니 영역 -->

<!-- 스토어 영역 -->
<div class="bg-gray">
    <div class="container padding">
        <div class="pt-4 sticky-top bg-gray mb-4 pb-3 d-between align-items-end border-bottom">
            <div>
                <span class="text-muted">인테리어 스토어</span>
                <div class="title">STORE</div>
            </div>
            <div class="d-flex align-items-center">
                <input type="checkbox" hidden="hidden" id="open-cart" checked>
                <div class="search">
                    <span class="icon">
                        <i class="fa fa-search"></i>
                    </span>
                    <input type="text" placeholder="검색어를 입력하세요">
                </div>
                <label for="open-cart" class="ml-4 mr-5 text-blue">
                    <i class="fa fa-shopping-cart fa-lg"></i>
                </label>
                <button class="button-label bg-gold gray" data-toggle="modal" data-target="#add-modal">상품등록</button>
                <div id="drop-area">
                    <div class="text-center text-white">
                        <div class="success position-center">
                            <i class="fa fa-check fa-3x"></i>
                            <p class="mt-4 fx-n2 text-nowrap">상품이 장바구니에 등록되었습니다!</p>
                        </div>
                        <div class="error position-center">
                            <i class="fa fa-times fa-3x"></i>
                            <p class="mt-4 fx-n2 text-nowrap">이미 장바구니에 담긴 상품입니다.</p>
                        </div>
                        <div class="normal position-center">
                            <i class="fa fa-shopping-cart fa-3x"></i>
                            <p class="mt-4 fx-n2 text-nowrap">이곳에 상품을 넣어주세요.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="store-list" class="row">
            <div class="py-4 text-center text-muted fx-n2 w-100">일치하는 상품이 없습니다.</div>
        </div>
    </div>
</div>
<!-- /스토어 영역 -->

<script src="./resources/js/Store.js"></script>
<script src="./resources/js/Product.js"></script>

<div id="view-modal" class="modal fade">
    <div class="modal-dialog"></div>
    <img alt="구매 내역" class="mw-100 mx-2 position-center">
</div>

<div id="buy-modal" class="modal fade">
    <div class="modal-dialog">
        <form>
            <div class="modal-content">
                <div class="modal-body px-4 pt-4 pb-3">
                    <div class="text-center title">
                        BUY ITEM
                    </div>
                    <div class="mt-3">  
                        <div class="form-group">
                            <label for="user_name">구매자 이름</label>
                            <input type="text" id="user_name" class="form-control" name="user_name" placeholder="구매자 이름을 입력하세요" required>
                        </div>
                        <div class="form-group">
                            <label for="address">주소</label>
                            <input type="text" id="address" class="form-control" name="address" placeholder="주소를 입력하세요" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button class="w-100 py-3 text-white bg-blue">구매 완료</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="history-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body px-4 pt-4 pb-3">
                <div class="text-center title">
                    HISTORY
                </div>
                <div class="table-head mt-3">
                    <div class="cell-20">상품 개수</div>
                    <div class="cell-30">총가격</div>
                    <div class="cell-50">구매 일시</div>
                </div>
                <div class="list">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div id="add-modal" class="modal fade">
    <div class="modal-dialog">
        <form>
            <div class="modal-content">
                <div class="modal-body px-4 pt-4 pb-3">
                    <div class="text-center title">
                        ADD ITEM
                    </div>
                    <div class="mt-3">  
                        <div class="form-group">
                            <label for="photo">이미지</label>
                            <div class="custom-file">
                                <input type="file" id="photo" class="custom-file-input" required>
                                <label for="photo" class="custom-file-label">상품 이미지를 업로드 하세요</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="product_name">상품명</label>
                            <input type="text" id="product_name" class="form-control" placeholder="상품명을 입력하세요" required>
                        </div>
                        <div class="form-group">
                            <label for="brand">브랜드명</label>
                            <input type="text" id="brand" class="form-control" placeholder="브랜드명를 입력하세요" required>
                        </div>
                        <div class="form-group">
                            <label for="price">가격</label>
                            <input type="number" id="price" class="form-control" min="0" value="10000" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button class="w-100 py-3 text-white bg-blue">구매 완료</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>