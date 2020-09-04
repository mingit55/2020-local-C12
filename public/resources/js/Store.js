class Store {
    $storeList = $("#store-list");
    $cartList = $("#cart-list");
    $dropArea = $("#drop-area");
    keyword = "";
    cartList = [];
    history = [];

    constructor(){
        this.init();
        this.setEvents();
    }

    async init(){
        this.products = await this.loadProducts();
        
        this.loadHistory();
        this.storeUpdate();
    }

    // 상품 가져오기
    getProducts(){
        return fetch("/resources/store.json")
            .then(res => res.json())
            .then(jsonList => jsonList.map(json => new Product(this, json)));
    }

    // 스토어 업데이트
    storeUpdate(){
        let viewList = this.products.map(item => item.init());
        
        if(this.keyword !== ""){
            let regex = new RegExp(this.keyword, "g");
            viewList = viewList.filter(item => regex.test(item.json.product_name) || regex.test(item.json.brand))
                .map(item => {
                    item.brand = item.json.brand.replace(regex, m1 => `<span class="bg-gold text-white">${m1}</span>`);
                    item.product_name = item.json.product_name.replace(regex, m1 => `<span class="bg-gold text-white">${m1}</span>`);
                    return item;
                });
        }

        if(viewList.length > 0){
            this.$storeList.html("");
            viewList.forEach(item => {
                item.storeUpdate();
                this.$storeList.append(item.$storeElem);
            });
        } else {
            this.$storeList.html(`<div class="py-4 text-center text-muted fx-n2 w-100">일치하는 상품이 없습니다.</div>`);
        }
    }

    get totalPrice(){
        return this.cartList.reduce((p, c) => p + c.totalPrice, 0);
    }
    
    // 장바구니 업데이트
    cartUpdate(){
        if(this.cartList.length > 0){
            this.$cartList.html("");
            this.cartList.forEach(item => {
                item.cartUpdate();
                this.$cartList.append(item.$cartElem);
            });
        } else {
            this.$cartList.html(`<div class="py-4 text-center text-muted fx-n2 w-100">장바구니에 담긴 상품이 없습니다.</div>`);
        }

        $(".total-price").text(this.totalPrice.toLocaleString());
    }

    // 이벤트 설정
    setEvents(){
        // 상품 추가
        let dragTarget, startPoint, timeout;
        this.$storeList.on("dragstart", ".image", e => {
            e.preventDefault();
            
            dragTarget = e.currentTarget;
            startPoint = [e.pageX, e.pageY];

            $(dragTarget).css({
                transition: "none",
                zIndex: "2000",
                position: "relative"
            });
        });    
        
        $(window).on("mousemove", e => {
            if(!dragTarget || !startPoint || e.which !== 1) return;

            $(dragTarget).css({
                left: e.pageX - startPoint[0] + "px",
                top: e.pageY - startPoint[1] + "px"
            });
        });

        $(window).on("mouseup", e => {
            if(!dragTarget || !startPoint || e.which !== 1) return;
            
            let {left, top} = this.$dropArea.offset();
            let width = this.$dropArea.width();
            let height = this.$dropArea.height();

            if(left <= e.pageX && e.pageX <= left + width && top <= e.pageY && e.pageY <= top + height){   
                // 드롭영역 안에 드롭됨
                if(timeout) {
                    clearTimeout(timeout);
                }
                this.$dropArea.removeClass("success");
                this.$dropArea.removeClass("error");
                
                
                let product = this.products.find(item => item.id == dragTarget.dataset.id);
                
                if(this.cartList.some(item => item == product)){
                    // 상품이 이미 장바구니에 있음
                    this.$dropArea.addClass("error");
                    $(dragTarget).animate({
                        left: 0,
                        top: 0
                    }, 350, function(){
                        this.style.zIndex = 0;
                    });
                } else {
                    // 상품이 장바구니에 없음
                    this.$dropArea.addClass("success");

                    product.buyCount = 1;
                    this.cartList.push(product);
                    this.cartUpdate();

                    let target = dragTarget;
                    $(target).css({
                        transition: "transform 0.35s",
                        transform : "scale(0)"
                    });
                    setTimeout(() => {
                        $(target).css({
                            left: 0,
                            top: 0,
                            transform: "scale(1)",
                            zIndex: 0
                        });
                    }, 350);
                }

                // 일정 시간후 원상태 복귀
                timeout = setTimeout(() => {
                    this.$dropArea.removeClass("success");
                    this.$dropArea.removeClass("error");
                }, 1500);
            } else {
                // 드롭 영역 이외에 드롭됨
                $(dragTarget).animate({
                    left: 0,
                    top: 0
                }, 350, function(){
                    this.style.zIndex = 0;
                });
            }
            
            dragTarget = startPoint = null;
        });

        
        // 장바구니 수량 조절
        this.$cartList.on("input", ".buy-count", e => {
            let value = parseInt(e.target.value);

            if(isNaN(value) || !value || value < 1){
                value = 1;
            }

            let product = this.cartList.find(item => item.id == e.target.dataset.id);
            product.buyCount = value;

            this.cartUpdate();

            e.target.focus();
        });

        // 장바구니 삭제
        this.$cartList.on("click", ".remove", e => {
            let idx = this.cartList.findIndex(item => item.id == e.target.dataset.id);
            if(idx >= 0){
                let product = this.cartList[idx];
                product.buyCount = 0;
                this.cartList.splice(idx, 1);
                this.cartUpdate();
            }
        });

        // 구매하기
        $("#buy-modal form").on("submit", e => {
            e.preventDefault();

            const PADDING = 30;
            const TEXT_SIZE = 18;
            const TEXT_GAP = 20;
            
            let canvas = document.createElement("canvas");
            let ctx = canvas.getContext("2d");
            ctx.font = `${TEXT_SIZE}px 나눔스퀘어, sans-serif`;

            let now = new Date();
            let text_time = `구매일시           ${now.getFullYear()}-${now.getMonth()}-${now.getDate()} ${now.getHours()}:${now.getMinutes()}:${now.getSeconds()}`;
            let text_price = `총 합계           ${this.totalPrice.toLocaleString()}원`;
            
            let viewList = [
                ...this.cartList.map(item => {
                    let text = `${item.product_name}            ${item.json.price.toLocaleString()}원 × ${item.buyCount.toLocaleString()}개 = ${item.totalPrice.toLocaleString()}원`;
                    let width = ctx.measureText(text).width;
                    return {text, width};
                }),
                { text: text_time, width: ctx.measureText(text_time).width },
                { text: text_price, width: ctx.measureText(text_price).width },
            ];

            let max_w = viewList.reduce((p, c) => Math.max(p, c.width), viewList[0].width);

            canvas.width = max_w + PADDING * 2;
            canvas.height = (TEXT_SIZE + TEXT_GAP) * viewList.length + PADDING * 2;
            
            ctx.fillStyle = "#fff";
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = "#333";
            ctx.font = `${TEXT_SIZE}px 나눔스퀘어, sans-serif`;
            
            viewList.forEach(({text}, i) => {
                ctx.fillText(text, PADDING, PADDING + TEXT_GAP * i + TEXT_SIZE * (i + 1));
            });

            let src = canvas.toDataURL("image/jpeg");
            $("#view-modal img").attr("src", src);
            $("#view-modal").modal("show");
            $("#buy-modal").modal("hide");

            this.pushHistory({
                image: src,
                buyCount: this.cartList.length,
                created_at: `${now.getFullYear()}-${now.getMonth()}-${now.getDate()} ${now.getHours()}:${now.getMinutes()}:${now.getSeconds()}`,
                totalPrice: this.totalPrice
            });

            this.cartList.forEach(item => item.buyCount = 0);
            this.cartList = [];
            this.cartUpdate();
            
            $("#buy-modal input").val('');
        });


        // 검색
        $(".search input").on("input", e => {
            this.keyword = e.target.value
                .replace(/([\^$\.+*?\[\]\(\)\\\\\\/])/g, "\\$1")
                .replace(/(ㄱ)/g, "[가-깋]")
                .replace(/(ㄴ)/g, "[나-닣]")
                .replace(/(ㄷ)/g, "[다-딯]")
                .replace(/(ㄹ)/g, "[라-맇]")
                .replace(/(ㅁ)/g, "[마-밓]")
                .replace(/(ㅂ)/g, "[바-빟]")
                .replace(/(ㅅ)/g, "[사-싷]")
                .replace(/(ㅇ)/g, "[아-잏]")
                .replace(/(ㅈ)/g, "[자-짛]")
                .replace(/(ㅊ)/g, "[차-칳]")
                .replace(/(ㅋ)/g, "[카-킿]")
                .replace(/(ㅌ)/g, "[타-팋]")
                .replace(/(ㅍ)/g, "[파-핗]")
                .replace(/(ㅎ)/g, "[하-힣]");
            this.storeUpdate();
        });



        // 구매 리스트 보기
        $("[data-target='#history-modal']").on("click", e => {
            console.log(this.history);
            $("#history-modal .list").html("");
            this.history.forEach(item => {
                let $elem = $(`<div class="table-item" style="cursor: pointer;">
                                    <div class="cell-20">
                                        <span>${parseInt(item.buyCount).toLocaleString()}</span>
                                        <small class="text-muted">개</small>
                                    </div>
                                    <div class="cell-30">
                                        <span>${parseInt(item.totalPrice).toLocaleString()}</span>
                                        <small class="text-muted">원</small>
                                    </div>
                                    <div class="cell-50">
                                        <span class="text-muted fx-n2">${item.created_at}</span>
                                    </div>
                                </div>`);
                $elem.on("click", e => {
                    let a = document.createElement("a");
                    a.href = item.image;
                    a.download = "영수증 이미지";
                    document.body.append(a);
                    a.click();
                    a.remove();
                }); 
                $("#history-modal .list").append($elem);
            });

            if(this.history.length === 0) $("#history-modal .list").html(`<div class="py-4 text-center text-muted px-n2">구매한 내역이 없습니다.</div>`);
        });
        // 구매 리스트 초기화
        $("#reset-history").on("click", e => {
            this.history = [];
            localStorage.removeItem("history");
            alert("초기화 되었습니다.");
            console.log(this.history);
        });


        $("#photo").on("change", e => {
            if(e.target.files.length > 0){
                $(e.target).siblings("label").text(e.target.files[0].name);
            } else {
                $(e.target).siblings("label").text("상품 이미지를 업로드 하세요");
            }
        });


        $("#add-modal form").on("submit", e => {
            e.preventDefault();
            let [photo, product_name, brand, price] = Array.from(e.target).slice(0, 4);

            let file = photo.files[0];
            if(file.size > 1024 * 1024 * 10) {
                alert("이미지는 최대 10Mb까지만 업로드 할 수 있습니다!");
                return;
            }

            let reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => {
                let json = {
                    id: new Date().getTime(),
                    photo: reader.result,
                    product_name: product_name.value,
                    brand: brand.value,
                    price: price.value
                };
                this.products.push( new Product(this, json, true) );
                this.saveProducts();
                this.storeUpdate();
    
    
                $("#add-modal").modal("hide");
            };
            
        });


        // 상품 삭제
        this.$storeList.on("click", ".remove", e => {
            let idx = this.products.findIndex(item => item.id == e.currentTarget.dataset.id);
            if(idx >= 0){
                this.products.splice(idx, 1);
                this.saveProducts();
                this.storeUpdate();
            }
        });
    }


    // 구매 리스트 추가
    pushHistory(item){
        this.history.push(item);
        localStorage.setItem("history", JSON.stringify(this.history) );
    }

    // 구매 리스트 불러오기
    loadHistory(){
        let list = localStorage.getItem("history");
        list = list ? JSON.parse(list) : [];
        this.history = list;
    }

   
    // 사용자 커스텀 리스트 불러오기
    async loadProducts(){
        let customList = localStorage.getItem("customList");
        customList = customList ? JSON.parse(customList) : [];

        let products = await this.getProducts();
        products = products.concat(customList.map(json => new Product(this, json, true)));
        console.log(products, customList);
        return products;
    }
    
    saveProducts(){
        let list = this.products.filter(item => item.deletable).map(item => item.json);
        localStorage.setItem("customList", JSON.stringify(list));
    }
    
}

window.onload = function(){
    window.store = new Store();
}