<?php
header('Content-Type: text/html; charset=utf-8');
$hash = isset($_GET['hash']) ? strtolower(trim($_GET['hash'])) : '';
$valid = preg_match('/^[a-f0-9]{32}$/', $hash);
$dataFile = __DIR__ . DIRECTORY_SEPARATOR . 'data.json';
$store = [];
if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $decoded = json_decode($json, true);
    if (is_array($decoded)) { $store = $decoded; }
}
$content = '';
if ($valid && isset($store[$hash]['content'])) {
    $content = (string)$store[$hash]['content'];
}
$textToType = '';
$wishes = [];
if ($content !== '') {
    // Tách theo dòng: Dòng 1 = textToType, các dòng còn lại = wishes
    $lines = preg_split("/\r\n|\r|\n/", $content);
    $lines = array_map('trim', $lines);
    $lines = array_values(array_filter($lines, function($l){ return $l !== ''; }));
    if (!empty($lines)) {
        $textToType = array_shift($lines);
        $wishes = $lines;
    }
}
if ($textToType === '' && $content !== '') { $textToType = $content; }
if ($textToType === '' && empty($wishes)) {
    $textToType = "Nhân dịp ngày Quốc tế Phụ nữ 20/10, tôi xin gửi đến bạn những lời chúc tốt đẹp nhất! Mỗi người phụ nữ là một bông hoa tuyệt đẹp, tô điểm cho cuộc sống này thêm rực rỡ.";
    $wishes = [
        "🌸 Chúc bạn luôn xinh đẹp, rạng ngời như những đóa hoa tươi thắm",
        "✨ Chúc bạn thành công rực rỡ trên con đường sự nghiệp",
        "❤️ Chúc bạn tìm được hạnh phúc trọn vẹn trong tình yêu",
        "☀️ Chúc bạn luôn vui vẻ, tràn đầy năng lượng mỗi ngày"
    ];
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chúc Mừng 20/10</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

    <style>
        /* Cài đặt chung */
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden;
            height: 100%;
            width: 100%;
        }

        /* Ẩn/Hiện các màn hình */
        .screen {
            display: none;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            transition: opacity 0.5s ease;
        }

        .screen.active {
            display: flex;
        }

        .fancy-font {
            font-family: 'Pacifico', 'Brush Script MT', 'cursive';
        }


        /* Màn hình 1: Bắt đầu */
        #start-screen {
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
            color: white;
            text-align: center;
            z-index: 10;
        }

        #start-screen h1 {
            font-size: 3.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            margin-bottom: 10px;
        }

        #start-button {
            padding: 12px 25px;
            font-size: 1.2rem;
            border: 2px solid white;
            background-color: transparent;
            color: white;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        #start-button:hover {
            background-color: white;
            color: #ff9a9e;
        }

        #loading-text {
            font-size: 1rem;
            color: white;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        /* Màn hình 2: Bức thư (Nền hồng) */
        #main-screen {
            z-index: 5;
            overflow: hidden;
            background-color: #fdf6f6;
            /* Nền hồng nhạt ổn định */
        }

        #envelope {
            position: relative;
            width: 200px;
            height: 130px;
            background-color: #ff7b7b;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.3s ease;
            z-index: 10;
        }

        #envelope:hover {
            transform: scale(1.1);
        }

        .flap {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 70px;
            background-color: #ff9a9e;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            clip-path: polygon(0 0, 100% 0, 50% 100%);
        }

        /* ---- Hiệu ứng hạt bay ---- */
        @keyframes float {
            0% {
                transform: translateY(0) scale(1);
                opacity: 0.8;
            }

            100% {
                transform: translateY(-100vh) scale(1.5);
                opacity: 0;
            }
        }

        .particle {
            position: absolute;
            bottom: -50px;
            left: var(--x-pos);
            animation: float 8s linear infinite;
            animation-delay: var(--delay);
            z-index: 1;
            user-select: none;
        }

        .heart {
            width: 20px;
            height: 20px;
            background-color: #ff7b7b;
            border-radius: 50%;
        }

        .heart::before,
        .heart::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background-color: #ff7b7b;
            border-radius: 50%;
        }

        .heart::before {
            top: -10px;
            left: 0;
        }

        .heart::after {
            top: 0;
            left: -10px;
        }

        .circle-heart {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            border: 3px solid #77dd77;
            opacity: 0.5;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .circle-heart::after {
            content: '❤';
            font-size: 12px;
            color: #77dd77;
        }

        .sparkle {
            width: 6px;
            height: 6px;
            background-color: #ffb3c1;
            border-radius: 50%;
            box-shadow: 0 0 10px 2px #ffb3c1, 0 0 5px 1px #fff;
            opacity: 0.8;
        }

        .flower {
            font-size: 20px;
            opacity: 0.7;
        }


        /* Màn hình 3: Thiệp chúc (Modal) */
        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            justify-content: center;
            align-items: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            width: 90%;
            max-width: 500px;
            text-align: center;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f0f0;
            animation: zoomIn 0.5s ease-out;
        }

        .modal-content h2 {
            font-size: 2rem;
            color: #d6336c;
            margin-top: 0;
        }

        .modal-content .date {
            color: #888;
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.3);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .close-button {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 30px;
            color: #aaa;
            cursor: pointer;
        }

        .close-button:hover {
            color: #333;
        }

        .message {
            text-align: left;
            /* Căn trái cho nội dung */
            min-height: 120px;
            margin: 20px 0;
            line-height: 1.6;
            color: #333;
        }

        /* Hiệu ứng con trỏ đánh máy */
        #typed-text {
            color: #333;
        }

        #typed-text::after {
            content: '|';
            color: #555;
            animation: blink 0.7s infinite;
        }

        #typed-text.typing-done::after {
            content: none;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }
        }

        .wishes {
            text-align: left;
            /* Căn trái cho lời chúc */
            margin-top: 20px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .wish-item {
            margin-bottom: 12px;
            font-size: 0.95rem;
            color: #555;
            opacity: 0;
            animation: fadeInUp 0.5s ease forwards;
            animation-delay: var(--delay);
        }

        .signature {
            text-align: left;
            /* Căn trái cho chữ ký */
            margin-top: 30px;
            color: #777;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .signature-name {
            font-weight: bold;
            color: #555;
        }
    </style>
</head>

<body>

    <div id="start-screen" class="screen active">
        <div class="content">
            <h1 id="start-title" class="fancy-font">Happy Women's Day</h1>
            <p id="start-subtitle">Chạm để mở món quà đặc biệt</p>
            <p id="loading-text">Đang chuẩn bị điều bất ngờ...</p>
            <button id="start-button">Bắt đầu</button>
        </div>
    </div>

    <div id="main-screen" class="screen">

        <div class="particle heart"></div>
        <div class="particle circle-heart"></div>
        <div class="particle heart"></div>
        <div class="particle sparkle"></div>
        <div class="particle flower">🌸</div>
        <div class="particle circle-heart"></div>
        <div class="particle flower">🌼</div>
        <div class="particle sparkle"></div>
        <div class="particle heart"></div>
        <div class="particle sparkle"></div>
        <div class="particle heart"></div>
        <div class="particle circle-heart"></div>
        <div class="particle heart"></div>
        <div class="particle sparkle"></div>
        <div class="particle heart"></div>
        <div class="particle circle-heart"></div>
        <div class="particle heart"></div>
        <div class="particle circle-heart"></div>
        <div class="particle heart"></div>
        <div class="particle sparkle"></div>
        <div class="particle flower">🌸</div>
        <div class="particle circle-heart"></div>
        <div class="particle flower">🌼</div>
        <div class="particle sparkle"></div>
        <div class="particle heart"></div>
        <div class="particle sparkle"></div>
        <div class="particle heart"></div>
        <div class="particle circle-heart"></div>
        <div class="particle heart"></div>
        <div class="particle sparkle"></div>
        <div class="particle heart"></div>
        <div class="particle circle-heart"></div>

        <div id="envelope">
            <div class="flap"></div>
            <div class="body"></div>
        </div>
    </div>

    <div id="card-modal" class="modal">
        <div class="modal-content">
            <span id="close-button" class="close-button">&times;</span>
            <h2 class="fancy-font">Happy Women's Day 2025! 💖</h2>
            <p class="date">Ngày 20 tháng 10 năm 2025</p>

            <div class="message">
                <p style="color: #555;">Thân gửi người phụ nữ tuyệt vời,</p>
                <p id="typed-text"></p>
            </div>

            <div id="wishes-list" class="wishes">
            </div>

            <div class="signature">
                <p>Thân <br> | <br> With love and appreciation, <br>
                    <span class="signature-name">Team Đom Đóm IT</span>
                </p>
            </div>

        </div>
    </div>

    <audio id="bg-music" src="path/to/your/music.mp3" loop></audio>


    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // Lấy các phần tử
            const startButton = document.getElementById('start-button');
            const startScreen = document.getElementById('start-screen');
            const mainScreen = document.getElementById('main-screen');
            const envelope = document.getElementById('envelope');
            const cardModal = document.getElementById('card-modal');
            const closeButton = document.getElementById('close-button');
            const bgMusic = document.getElementById('bg-music');
            const typedTextElement = document.getElementById('typed-text');
            const wishesListElement = document.getElementById('wishes-list');
            const loadingText = document.getElementById('loading-text');

            // Ẩn nút "Bắt đầu" và hiện chữ "Đang chuẩn bị"
            startButton.style.display = 'none';
            loadingText.style.opacity = '1';

            // Giả lập thời gian tải
            setTimeout(() => {
                loadingText.style.opacity = '0';
                startButton.style.display = 'inline-block';
            }, 1500);


            // ----- NỘI DUNG ĐƯỢC TRUYỀN TỪ PHP (data.json theo md5) -----
            const textToType = <?php echo json_encode($textToType, JSON_UNESCAPED_UNICODE); ?>;
            const wishes = <?php echo json_encode(array_values($wishes), JSON_UNESCAPED_UNICODE); ?>;
            // --------------------------------------------------------------


            let isMusicPlaying = false; // Ban đầu nhạc tắt

            //
            // ========================================================
            // ===        ĐÃ SỬA LẠI LOGIC VỀ GIỐNG VIDEO GỐC       ===
            // ========================================================
            //

            // 1. Nhấn nút "Bắt đầu"
            startButton.addEventListener('click', () => {
                // Ẩn màn hình bắt đầu
                startScreen.style.opacity = '0';
                setTimeout(() => startScreen.classList.remove('active'), 500);

                // Kích hoạt nền hạt bay (màn hình 2)
                mainScreen.classList.add('active');
                startFloatingParticles();

                // Phát nhạc
                if (!isMusicPlaying) {
                    bgMusic.play().catch(e => console.log("Lỗi phát nhạc"));
                    isMusicPlaying = true;
                }

                // === ĐÃ XÓA CODE TỰ ĐỘNG MỞ THIỆP CHÚC ===
                // Giờ người dùng phải tự bấm vào bức thư
            });

            // 2. Nhấn nút "X" (đóng thiệp)
            closeButton.addEventListener('click', () => {
                // Ẩn thiệp chúc
                cardModal.classList.remove('active');
                // Người dùng sẽ thấy mainScreen (có bức thư và hạt bay)
            });

            // 3. Nhấn vào Bức thư (để mở lại)
            envelope.addEventListener('click', () => {
                // Hiện thiệp chúc
                cardModal.classList.add('active');
                startTyping(); // Bắt đầu gõ chữ (reset lại)
            });

            // ========================================================
            // ===            KẾT THÚC PHẦN SỬA LOGIC             ===
            // ========================================================


            // 4. Hàm hiệu ứng Đánh máy
            let charIndex = 0;
            function startTyping() {
                // Reset lại khi gọi
                typedTextElement.textContent = '';
                typedTextElement.classList.remove('typing-done');
                wishesListElement.innerHTML = '';
                charIndex = 0;

                typeChar();
            }

            function typeChar() {
                if (charIndex < textToType.length) {
                    typedTextElement.textContent += textToType.charAt(charIndex);
                    charIndex++;
                    setTimeout(typeChar, 40); // Tốc độ gõ
                } else {
                    typedTextElement.classList.add('typing-done'); // Xóa con trỏ
                    showWishes();
                }
            }

            // 5. Hàm làm hiện các lời chúc
            function showWishes() {
                wishesListElement.innerHTML = ''; // Xóa lời chúc cũ
                wishes.forEach((wish, index) => {
                    const wishElement = document.createElement('p');
                    wishElement.className = 'wish-item';
                    wishElement.innerHTML = wish;
                    wishElement.style.setProperty('--delay', `${index * 0.4}s`);
                    wishesListElement.appendChild(wishElement);
                });
            }

            // 6. Hàm tạo hạt bay
            function startFloatingParticles() {
                const particles = document.querySelectorAll('.particle');
                particles.forEach(particle => {
                    particle.style.setProperty('--x-pos', `${Math.random() * 100}vw`);
                    particle.style.animationDuration = `${5 + Math.random() * 5}s`; // Bay từ 5-10s
                    particle.style.setProperty('--delay', `${Math.random() * 8}s`);
                });
            }

        });
    </script>
</body>

</html>