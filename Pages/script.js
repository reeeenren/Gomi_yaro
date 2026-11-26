// 【解説】HTML内の要素をCSSセレクタ（.クラス名 や #ID名）で探して変数に保存する
const headerContainer = document.querySelector(".header-container");

// 【入力】 const sellSection = document.querySelector("#sell-form");

const requestSection = document.querySelector("#request-form");
const productsSection = document.querySelector(".products-section");

// 【解説】querySelectorAllは、条件に合う要素を「配列のようなリスト」で全部まとめて取得する
// 【入力】 const forms = document.querySelectorAll(".form-section");

const productCards = document.querySelectorAll(".product-card");

const sellSectionGotoButton = document.querySelector("#button-goto-sell-section");
const productListGotoButton = document.querySelector("#button-goto-product-list");
const requestSectionGotoButton = document.querySelector("#button-goto-request-section");

// 【解説】固定ヘッダーの高さを取得する関数。スクロール時にヘッダーの裏に目的のセクションが隠れないよう差し引くために使う
const getHeaderHeight = () => headerContainer.offsetHeight;

// 【解説】指定したセクションの位置まで滑らかにスクロールする関数
// 画面上の位置(getBoundingClientRect().top) + 現在のスクロール量(window.scrollY) - ヘッダーの高さ - 少しの余白
const scrollToSection = (section) => {
    const scrollCoord = section.getBoundingClientRect().top + window.scrollY - getHeaderHeight() - (window.innerHeight * 0.025);
    // 【入力】 window.scrollTo({ top: scrollCoord, behavior: "smooth" });

};

// 【解説】フォームを開く関数。CSSの .expand クラスを付与することで高さがautoになり中身が表示される
const openSection = (section) => {
    section.querySelector(".btn-container-expand").classList.add("expand");
    // 【入力】 section.querySelector(".container-generic-item").classList.add("expand");

};

// 【解説】ナビゲーションの「出品する」ボタンがクリックされた時の処理
sellSectionGotoButton.addEventListener("click", () => {
    scrollToSection(sellSection);
    // 【入力】 openSection(sellSection);

});

productListGotoButton.addEventListener("click", () => {
    scrollToSection(productsSection);
});

requestSectionGotoButton.addEventListener("click", () => {
    scrollToSection(requestSection);
    openSection(requestSection);
});

// 【解説】各フォームの見出し(containerHeader)をクリックした時に開閉を切り替える
forms.forEach(element => {
    const containerHeader = element.querySelector(".container-header");
    const containerExpandIcon = element.querySelector(".btn-container-expand");
    const containerItem = element.querySelector(".container-generic-item");

    containerHeader.addEventListener("click", () => {
        containerExpandIcon.classList.toggle("expand");
        // 【解説】toggleは「クラスが無ければ追加、すでに有れば削除」する便利な命令
        // 【入力】 containerItem.classList.toggle("expand");

    });
});

// 【解説】商品カードを1枚ずつ順番にふわっと表示させるための遅延時間(--delay)をCSS変数にセットする
productCards.forEach((element, index) => {
    // 【入力】 element.style.setProperty("--delay", `${index * 0.25}s`);

});