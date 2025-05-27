document.addEventListener("DOMContentLoaded", function () {
    // すべての「いいね」ボタンにイベントリスナーを追加
    const likeButtons = document.querySelectorAll(".like-button");

    likeButtons.forEach(button => {
        button.addEventListener("click", function () {
            // ボタンに関連付けられた投稿IDを取得
            const postId = button.getAttribute("data-post-id");

            // 非同期通信（Fetch API）でlike.phpにリクエストを送信
            fetch(`like.php?id=${postId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        // 「いいね」数を更新
                        const likeCountElement = document.querySelector(`#likes-count-${postId}`);
                        likeCountElement.textContent = data.likes;

                        // ボタンのスタイルを変更（例えば色を変える）
                        button.classList.add("liked");
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("通信エラーが発生しました。");
                });
        });
    });
});
