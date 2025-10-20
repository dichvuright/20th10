<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>QR Trái Tim + Link MD5 — DichVuRight</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-b from-blue-50 to-indigo-50 p-4 md:p-8 font-[Inter]">
    <div class="postBody" id="postBody" style="height: auto !important;">
        <div class="mx-auto w-full max-w-2xl bg-white rounded-2xl shadow-xl p-6 md:p-10 text-center" style="height: auto !important;">
            <h4 id="Công_Cụ_Tạo_QR_Trái_Tim_Miễn_Phí_(Heart_Shapes)" class="text-lg md:text-xl font-semibold text-slate-800 mb-2 md:mb-4">Công Cụ Tạo QR Trái Tim Miễn Phí (Heart Shapes)</h4>

            <div class="hero mb-4 text-center">
                <h1 class="hero-title text-2xl md:text-3xl font-bold text-slate-900">Tạo QR Trái Tim + Liên Kết MD5</h1>
                <p class="hero-sub text-slate-600">Nhập nội dung, hệ thống tạo liên kết https://20t10.dichvuright.com/domdomit/:md5 và hiển thị QR ngay.</p>
            </div>

            <div class="card bg-white border border-slate-200 rounded-xl p-4 mb-6" id="md5-card">
                <div class="input-group">
                    <label class="block mb-2 text-slate-700 font-medium">Nội dung để tạo liên kết MD5:</label>
                    <textarea id="raw-content" class="w-full p-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-slate-700" placeholder="Sẽ tự gợi ý nội dung chúc 20/10 xinh xắn cho bạn..." rows="4"></textarea>
                    <small class="hint">Bạn có thể nhập bất kỳ nội dung nào (lời chúc, thư, URL,...). Hệ thống sẽ băm MD5 và tạo liên kết.</small>
                </div>
                <div class="controls flex flex-col gap-4 md:flex-row md:justify-center my-6">
                    <button id="make-md5-link" class="px-4 py-3 rounded-lg bg-gradient-to-tr from-teal-400 to-blue-500 text-white font-semibold shadow hover:shadow-lg transition disabled:opacity-50">Tạo liên kết MD5 + Hiển thị QR</button>
                </div>
                <div id="md5-result" class="md5-result bg-slate-50 border border-slate-200 rounded-lg p-3 mt-3 text-left" style="display:none;"></div>
            </div>

            <div class="input-section">
                <div class="input-group">
                    <label>Nội dung QR (URL, văn bản,...):</label>
                    <textarea id="qr-url" class="w-full p-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-slate-700"
                        placeholder="VD: https://www.example.com">https://20t10.dichvuright.com</textarea>
                </div>
                <details class="advanced bg-slate-50 border border-slate-200 rounded-xl p-3 mb-4" id="advanced-options">
                    <summary class="cursor-pointer font-semibold text-slate-800">Tùy chọn nâng cao</summary>
                    <div class="advanced-grid">
                        <div class="input-group">
                            <label>Kích thước mỗi ô QR (px): <span id="size-val">150</span></label>
                            <input id="qr-size" type="range" min="120" max="170" step="5" value="150" />
                            <small class="hint">Khung xem trước 300x300. Chọn 120–170 để không bị tràn.</small>
                        </div>
                        <div class="input-group">
                            <label>Viền trắng (quiet zone):</label>
                            <input id="qr-margin" type="number" min="0" max="8" step="1" value="2" />
                            <small class="hint">Viền trắng bao quanh QR, giúp máy quét dễ hơn.</small>
                        </div>
                        <div class="input-group">
                            <label>Mức sửa lỗi (ECC):</label>
                            <select id="qr-ecc">
                                <option value="H" selected>Cao (H)</option>
                                <option value="Q">Khá (Q)</option>
                                <option value="M">Trung bình (M)</option>
                                <option value="L">Thấp (L)</option>
                            </select>
                            <small class="hint">Mức sửa lỗi cao giúp gắn logo/che phủ nhưng mã sẽ dày hơn.</small>
                        </div>
                        <div class="input-group">
                            <label>Logo giữa QR (tùy chọn):</label>
                            <input id="qr-logo" type="file" accept="image/*" />
                            <small class="hint">Logo sẽ hiển thị ở QR trung tâm.</small>
                        </div>
                    </div>
                </details>

                <div class="input-group">
                    <label>Màu Mã QR:</label>
                    <div class="color-picker-wrapper">
                        <input id="qr-color" type="color" value="#000000" class="w-16 h-12 p-1" >
                        <span class="color-hex-display" id="qr-color-hex">#C02121</span>
                    </div>
                </div>
                <div class="input-group">
                    <label>Màu Nền QR:</label>
                    <div class="color-picker-wrapper">
                        <input id="bg-color" type="color" value="#FFFFFF" style="opacity: 1;" class="w-16 h-12 p-1">
                        <span class="color-hex-display" id="bg-color-hex">#FFFFFF</span>
                    </div>
                    <div class="checkbox-container flex items-center gap-3 mt-3 p-3 bg-slate-50 rounded border border-slate-200">
                        <input id="transparent-bg" type="checkbox">
                        <label>Nền trong suốt (cho file PNG)</label>
                    </div>
                </div>
                <!--Đã loại bỏ input-group cho qr-size-->
            </div>

            <div class="controls flex flex-col gap-4 md:flex-row md:justify-center my-6">
                <button id="generate-qr" class="px-5 py-3 rounded-lg bg-gradient-to-tr from-teal-400 to-blue-500 text-white font-semibold shadow hover:shadow-lg transition disabled:opacity-50">Tạo Mã QR</button>
                <button id="download-qr" class="px-5 py-3 rounded-lg bg-gradient-to-tr from-sky-500 to-indigo-500 text-white font-semibold shadow hover:shadow-lg transition disabled:opacity-50">Tải Mã QR (PNG)</button>
            </div>
            <div class="google-auto-placed ap_container"
                style="width: 100%; height: auto; clear: both; text-align: center;"><ins data-ad-format="auto"
                    class="adsbygoogle adsbygoogle-noablate" data-ad-client="ca-pub-3156025796030783"
                    data-adsbygoogle-status="done"
                    style="display: block; margin: auto; background-color: transparent; height: 0px;"
                    data-ad-status="unfilled">
                    <div id="aswift_3_host"
                        style="border: none; height: 0px; width: 780px; margin: 0px; padding: 0px; position: relative; visibility: visible; background-color: transparent; display: inline-block; overflow: hidden; opacity: 0;">
                        <iframe id="aswift_3" name="aswift_3" browsingtopics="true"
                            style="left: 0px; position: absolute; top: 0px; border: 0px; width: 780px; height: 0px; min-height: auto; max-height: none; min-width: auto; max-width: none;"
                            sandbox="allow-forms allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts allow-top-navigation-by-user-activation"
                            width="780" height="0" frameborder="0" marginwidth="0" marginheight="0" vspace="0"
                            hspace="0" allowtransparency="true" scrolling="no"
                            allow="attribution-reporting; run-ad-auction"
                            src="https://googleads.g.doubleclick.net/pagead/ads?gdpr=0&amp;client=ca-pub-3156025796030783&amp;output=html&amp;h=280&amp;adk=1381393909&amp;adf=3917706645&amp;w=780&amp;fwrn=4&amp;fwrnh=100&amp;lmt=1760874699&amp;num_ads=1&amp;rafmt=1&amp;armr=3&amp;sem=mc&amp;pwprc=7708201098&amp;ad_type=text_image&amp;format=780x280&amp;url=https%3A%2F%2Fcuongbokit.blogspot.com%2F2025%2F06%2Fcong-cu-tao-ma-qr-trai-tim-tinh-yeu-heart-shape.html&amp;host=ca-host-pub-1556223355139109&amp;fwr=0&amp;pra=3&amp;rh=195&amp;rw=780&amp;rpe=1&amp;resp_fmts=3&amp;wgl=1&amp;fa=27&amp;uach=WyJXaW5kb3dzIiwiMTkuMC4wIiwieDg2IiwiIiwiMTQxLjAuNzM5MC4xMDgiLG51bGwsMCxudWxsLCI2NCIsW1siR29vZ2xlIENocm9tZSIsIjE0MS4wLjczOTAuMTA4Il0sWyJOb3Q_QV9CcmFuZCIsIjguMC4wLjAiXSxbIkNocm9taXVtIiwiMTQxLjAuNzM5MC4xMDgiXV0sMF0.&amp;abgtt=6&amp;dt=1760884971881&amp;bpp=1&amp;bdt=406&amp;idt=-M&amp;shv=r20251016&amp;mjsv=m202510140101&amp;ptt=9&amp;saldr=aa&amp;abxe=1&amp;cookie=ID%3Df03b52dce0d15401%3AT%3D1760884943%3ART%3D1760884943%3AS%3DALNI_Mb5rZoznZdQc0LryRX2YPfbP_uPhQ&amp;gpic=UID%3D000012b7ded8f52f%3AT%3D1760884943%3ART%3D1760884943%3AS%3DALNI_MZl9mCcCKxtbImbMLNekivtONDtBQ&amp;eoidce=1&amp;prev_fmts=0x0%2C780x280%2C780x280&amp;nras=3&amp;correlator=4038140505148&amp;frm=20&amp;pv=1&amp;u_tz=420&amp;u_his=4&amp;u_h=865&amp;u_w=1536&amp;u_ah=817&amp;u_aw=1536&amp;u_cd=24&amp;u_sd=1.25&amp;dmc=8&amp;adx=386&amp;ady=2242&amp;biw=1532&amp;bih=730&amp;scr_x=0&amp;scr_y=0&amp;eid=31095216%2C31095217%2C95371225%2C95373013%2C95374042%2C95374289%2C95374626%2C95374745&amp;oid=2&amp;pvsid=8432919210472856&amp;tmod=898288934&amp;uas=0&amp;nvt=1&amp;ref=https%3A%2F%2Fcuongbokit.blogspot.com%2Fsearch%3Fq%3Dt%25E1%25BA%25A1o%2Bqr&amp;fc=1408&amp;brdim=1919%2C5%2C1919%2C5%2C1536%2C6%2C1538%2C819%2C1536%2C730&amp;vis=1&amp;rsz=%7C%7Cs%7C&amp;abl=NS&amp;fu=128&amp;bc=31&amp;bz=1&amp;td=1&amp;tdf=2&amp;psd=W251bGwsW251bGwsbnVsbCxudWxsLCJkZXByZWNhdGVkX2thbm9uIl0sbnVsbCwzXQ..&amp;nt=1&amp;pgls=CAA.~CAA.&amp;ifi=4&amp;uci=a!4&amp;btvi=2&amp;fsb=1&amp;dtd=94"
                            data-google-container-id="a!4" tabindex="0" title="Advertisement" aria-label="Advertisement"
                            data-load-complete="true" data-google-query-id="CO-0iNq_sJADFXnsTAId5owDTg"></iframe></div>
                </ins></div>

            <div class="message-area mt-4 hidden" id="message-area"></div>

            <div class="qr-preview-section mt-6 p-4 border-2 border-dashed border-blue-300 rounded-xl bg-blue-50 min-h-[300px] flex flex-col items-center justify-center">
                <h4 id="Xem_Trước_Heart_QR">Xem Trước Heart QR</h4>
                <div id="qr-composite-wrapper" class="w-[300px] h-[300px] mx-auto relative" style="background-color: rgb(255, 255, 255);">
                    <div class="qr-individual-part qr-tai" id="qr-part-1" title=""
                        style="width: 150px; height: 150px; top: 20px; left: 20px;"><canvas width="150" height="150"
                            style="display: none;"></canvas><img src="data:image/png;" style="display: block;"></div>
                    <div class="qr-individual-part qr-main" id="qr-part-2" title="https://dichvuright.comcccc"
                        style="width: 150px; height: 150px; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(0deg); z-index: 10;">
                        <canvas width="150" height="150" style="display: none;"></canvas><img style="display: block;"
                            src="data:image/png;base64,"></div>
                    <div class="qr-individual-part qr-tai" id="qr-part-3" title="https://dichvuright.comcccc"
                        style="width: 150px; height: 150px; top: 20px; right: 20px;"><canvas width="150" height="150"
                            style="display: none;"></canvas><img src="data:image/png;base64," style="display: block;">
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

        <script>
        document.addEventListener('DOMContentLoaded', () => {
            const urlInput = document.getElementById('qr-url');
            const qrColorInput = document.getElementById('qr-color');
            const qrColorHexDisplay = document.getElementById('qr-color-hex');
            const bgColorInput = document.getElementById('bg-color');
            const bgColorHexDisplay = document.getElementById('bg-color-hex');
            const transparentBgCheckbox = document.getElementById('transparent-bg');
            // const qrSizeInput = document.getElementById('qr-size'); // Đã loại bỏ
            const generateBtn = document.getElementById('generate-qr');
            const downloadBtn = document.getElementById('download-qr');

            const qrCompositeWrapper = document.getElementById('qr-composite-wrapper');
            const qrPart1Div = document.getElementById('qr-part-1');
            const qrPart2Div = document.getElementById('qr-part-2');
            const qrPart3Div = document.getElementById('qr-part-3');

            // Advanced controls
            const sizeRange = document.getElementById('qr-size');
            const sizeVal = document.getElementById('size-val');
            const marginInput = document.getElementById('qr-margin');
            const eccSelect = document.getElementById('qr-ecc');
            const logoInput = document.getElementById('qr-logo');

            const messageArea = document.getElementById('message-area');

            // Prefill helper content
            const textToType = "Nhân dịp ngày Quốc tế Phụ nữ 20/10, tôi xin gửi đến bạn những lời chúc tốt đẹp nhất! Mỗi người phụ nữ là một bông hoa tuyệt đẹp, tô điểm cho cuộc sống này thêm rực rỡ.";
            const wishes = [
                "🌸 Chúc bạn luôn xinh đẹp, rạng ngời như những đóa hoa tươi thắm",
                "✨ Chúc bạn thành công rực rỡ trên con đường sự nghiệp",
                "❤️ Chúc bạn tìm được hạnh phúc trọn vẹn trong tình yêu",
                "☀️ Chúc bạn luôn vui vẻ, tràn đầy năng lượng mỗi ngày"
            ];
            const rawContentEl = document.getElementById('raw-content');
            const makeMd5Btn = document.getElementById('make-md5-link');
            const md5ResultEl = document.getElementById('md5-result');

            if (rawContentEl) {
                // Dòng 1: textToType, các dòng tiếp theo: wishes (mỗi dòng một wish)
                rawContentEl.value = `${textToType}\n${wishes.join('\n')}`;
            }

            // State for logo overlay
            let logoDataURL = null;

            let qrCodeLibraryReady = false;
            let htmlToCanvasLibraryReady = false;
            const defaultQrPartSize = 150; // Kích thước mặc định cho mỗi QR part

            function showMessage(message, type = 'error') {
                if (!messageArea) return;
                messageArea.innerHTML = message;
                messageArea.className = `message-area ${type}`;
            }

            function clearMessage() {
                if (!messageArea) return;
                messageArea.textContent = '';
                messageArea.className = 'message-area';
            }

            function updateColorHexDisplay(colorInput, hexDisplay) {
                hexDisplay.textContent = colorInput.value.toUpperCase();
            }

            function eccToCorrectLevel(val) {
                if (!window.QRCode || !QRCode.CorrectLevel) return undefined;
                const m = { H: QRCode.CorrectLevel.H, Q: QRCode.CorrectLevel.Q, M: QRCode.CorrectLevel.M, L: QRCode.CorrectLevel.L };
                return m[val] ?? QRCode.CorrectLevel.H;
            }

            function setBtnLoading(btn, loading) {
                if (!btn) return;
                if (loading) {
                    btn.dataset.prevText = btn.innerHTML;
                    btn.innerHTML = `Đang xử lý<svg class="spinner" height="12" style="text-align: center; margin-left:8px" viewBox="0 0 50 50" width="16"><circle cx="25" cy="25" r="20" stroke="#fff" stroke-width="6" fill="none" stroke-linecap="round" stroke-dasharray="31.4 31.4"><animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="0.9s" repeatCount="indefinite"/></circle></svg>`;
                    btn.disabled = true;
                } else {
                    btn.innerHTML = btn.dataset.prevText || btn.innerHTML;
                    btn.disabled = false;
                }
            }

            async function createMd5LinkAndQr() {
                const content = (rawContentEl?.value || '').trim();
                if (!content) {
                    showMessage('Vui lòng nhập nội dung trước khi tạo liên kết MD5.', 'error');
                    return;
                }
                clearMessage();
                try {
                    setBtnLoading(makeMd5Btn, true);
                    const res = await fetch('api.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ content })
                    });
                    const json = await res.json();
                    if (!res.ok || json.status !== 'ok') throw new Error(json.message || 'Không tạo được liên kết.');

                    const { md5, url } = json;
                    // Hiển thị kết quả + hành động
                    md5ResultEl.style.display = 'block';
                    md5ResultEl.innerHTML = `
                        <div class="result-title">Đã tạo liên kết</div>
                        <div class="result-line"><span class="badge">MD5</span> <code>${md5}</code></div>
                        <div class="result-line"><span class="badge">URL</span> <a href="${url}" target="_blank" class="url">${url}</a></div>
                        <div class="actions">
                            <button class="btn-secondary" id="copy-url">Sao chép URL</button>
                            <a class="btn-secondary" href="${url}" target="_blank">Mở liên kết</a>
                        </div>
                    `;

                    // Gán vào input QR và sinh QR
                    if (urlInput) urlInput.value = url;
                    if (qrCodeLibraryReady) generateCompositeQRCode();

                    // Copy handler
                    const copyBtn = document.getElementById('copy-url');
                    copyBtn?.addEventListener('click', async () => {
                        try {
                            await navigator.clipboard.writeText(url);
                            showMessage('Đã sao chép liên kết vào clipboard.', 'success');
                        } catch (e) {
                            showMessage('Không thể sao chép liên kết.', 'error');
                        }
                    });

                } catch (e) {
                    console.error(e);
                    showMessage(e.message || 'Có lỗi xảy ra khi tạo liên kết.', 'error');
                } finally {
                    setBtnLoading(makeMd5Btn, false);
                }
            }

            function initializeCoreApp() {
                qrCodeLibraryReady = true;
                console.log("Thư viện QRCode (qrcode.js) đã tải. Khởi tạo ứng dụng.");
                if (generateBtn) generateBtn.disabled = false;

                // Bind MD5 create button
                makeMd5Btn?.addEventListener('click', createMd5LinkAndQr);

                updateColorHexDisplay(qrColorInput, qrColorHexDisplay);
                updateColorHexDisplay(bgColorInput, bgColorHexDisplay);

                transparentBgCheckbox.addEventListener('change', function() {
                    bgColorInput.disabled = this.checked;
                    bgColorInput.style.opacity = this.checked ? 0.5 : 1;
                    if (!this.checked) {
                        updateColorHexDisplay(bgColorInput, bgColorHexDisplay);
                    } else {
                        bgColorHexDisplay.textContent = 'TRONG SUỐT';
                    }
                    if (qrCodeLibraryReady) generateCompositeQRCode();
                });

                qrColorInput.addEventListener('input', () => {
                    updateColorHexDisplay(qrColorInput, qrColorHexDisplay);
                    if (qrCodeLibraryReady) generateCompositeQRCode();
                });
                bgColorInput.addEventListener('input', () => {
                    if (!transparentBgCheckbox.checked) {
                        updateColorHexDisplay(bgColorInput, bgColorHexDisplay);
                        if (qrCodeLibraryReady) generateCompositeQRCode();
                    }
                });
                urlInput.addEventListener('input', () => {
                    if (qrCodeLibraryReady) generateCompositeQRCode();
                });
                // qrSizeInput event listener đã được loại bỏ
                if (generateBtn) generateBtn.addEventListener('click', () => {
                    if (qrCodeLibraryReady) generateCompositeQRCode();
                });

                if (downloadBtn) {
                    downloadBtn.disabled = true;
                    downloadBtn.addEventListener('click', () => {
                        downloadBtn.innerHTML = `Đang tải ảnh<svg class="spinner" height="12" style="text-align: center;" viewbox="-1 0 33 12" width="34">
    <circle class="loading-dot" cx="4" cy="6" fill="#ee4d2d" r="4"></circle>
    <circle class="loading-dot" cx="16" cy="6" fill="#ee4d2d" r="4"></circle>
    <circle class="loading-dot" cx="28" cy="6" fill="#ee4d2d" r="4"></circle></svg>`;
                        if (!htmlToCanvasLibraryReady) {
                            showMessage(
                                "Lỗi: Chức năng tải xuống không khả dụng do thư viện chuyển đổi HTML (html2canvas) chưa được tải. Vui lòng kiểm tra kết nối mạng và thử làm mới trang.",
                                'error');
                            return;
                        }
                        if (qrCompositeWrapper && qrCompositeWrapper.querySelector(
                                '.qr-individual-part canvas, .qr-individual-part img')) {
                            clearMessage();
                            const filename = "dichvuright-heart-qrcode.png";

                            // Lấy màu nền thực tế của wrapper để html2canvas sử dụng
                            const wrapperBgColor = transparentBgCheckbox.checked ? null :
                                qrCompositeWrapper.style.backgroundColor || bgColorInput.value;

                            html2canvas(qrCompositeWrapper, {
                                backgroundColor: wrapperBgColor,
                                useCORS: true,
                                width: qrCompositeWrapper.offsetWidth,
                                height: qrCompositeWrapper.offsetHeight,
                                scale: 2
                            }).then(canvas => {
                                const imageURL = canvas.toDataURL('image/png');
                                console.log("Composite QR Code Image Data URL:", imageURL);
                                const downloadLink = document.createElement('a');
                                downloadLink.href = imageURL;
                                downloadLink.download = filename;
                                document.body.appendChild(downloadLink);
                                downloadLink.click();
                                document.body.removeChild(downloadLink);
                                showMessage(`Đã tải về ${filename} thành công!`, 'success');
                            }).catch(error => {
                                console.error("Lỗi khi tạo ảnh từ div với html2canvas:", error);
                                showMessage(`Không thể tải xuống mã QR: ${error.message}.`);
                            });
                        } else {
                            showMessage("Vui lòng tạo mã QR trước khi tải về.");
                        }
                        downloadBtn.innerHTML = `Tải Mã QR (PNG)`
                    });
                }

                bgColorInput.disabled = transparentBgCheckbox.checked;
                bgColorInput.style.opacity = transparentBgCheckbox.checked ? 0.5 : 1;
                if (transparentBgCheckbox.checked) bgColorHexDisplay.textContent = 'TRONG SUỐT';

                generateCompositeQRCode();
                checkHtmlToCanvasLibrary();
            }

            function createSingleQRCode(targetDiv, data, options) {
                if (!targetDiv) {
                    console.error("Target div không tồn tại:", targetDiv);
                    return false;
                }
                targetDiv.innerHTML = '';
                targetDiv.style.width = options.width + 'px';
                targetDiv.style.height = options.height + 'px';
                try {
                    new QRCode(targetDiv, options);
                    return true;
                } catch (error) {
                    console.error("Lỗi khi tạo QR cho div:", targetDiv.id, error);
                    targetDiv.innerHTML = '<p style="font-size:10px; color:red;">Lỗi</p>';
                    return false;
                }
            }

            function generateCompositeQRCode() {
                clearMessage();
                if (!qrCodeLibraryReady) {
                    showMessage("Lỗi: Thư viện QRCode (qrcode.js) chưa sẵn sàng.");
                    if (downloadBtn) downloadBtn.disabled = true;
                    return;
                }

                const data = urlInput.value.trim();
                if (!data) {
                    showMessage("Vui lòng nhập nội dung cho mã QR.");
                    if (downloadBtn) downloadBtn.disabled = true;
                    [qrPart1Div, qrPart2Div, qrPart3Div].forEach(div => {
                        if (div) div.innerHTML = '';
                    });
                    return;
                }

                const fgColor = qrColorInput.value;
                let effectiveBgColorForQR = bgColorInput.value; // Màu nền cho từng QR code
                let wrapperBgForDisplay = bgColorInput.value; // Màu nền cho wrapper hiển thị trên trang

                if (transparentBgCheckbox.checked) {
                    effectiveBgColorForQR =
                    "#ffffff"; // qrcode.js cần màu cụ thể, trắng là phổ biến cho nền "trong suốt"
                    wrapperBgForDisplay = "transparent"; // Wrapper hiển thị trong suốt
                }

                // Cập nhật màu nền cho qr-composite-wrapper
                if (qrCompositeWrapper) {
                    qrCompositeWrapper.style.backgroundColor = wrapperBgForDisplay;
                }

                const size = defaultQrPartSize; // Sử dụng kích thước mặc định

                let correctLevelValue = undefined;
                if (typeof QRCode !== 'undefined' && typeof QRCode.CorrectLevel !== 'undefined' && typeof QRCode
                    .CorrectLevel.H !== 'undefined') {
                    correctLevelValue = QRCode.CorrectLevel.H;
                } else {
                    console.warn(
                        "QRCode.CorrectLevel.H không được định nghĩa, sử dụng mức sửa lỗi mặc định của thư viện."
                        );
                }

                const qrOptions = {
                    text: data,
                    width: size,
                    height: size,
                    colorDark: fgColor,
                    colorLight: effectiveBgColorForQR // Dùng màu này cho qrcode.js
                };
                if (correctLevelValue !== undefined) {
                    qrOptions.correctLevel = correctLevelValue;
                }

                let success1 = createSingleQRCode(qrPart1Div, data, qrOptions);
                let success2 = createSingleQRCode(qrPart2Div, data, qrOptions);
                let success3 = createSingleQRCode(qrPart3Div, data, qrOptions);

                // Định vị ví dụ (có thể điều chỉnh thêm)

                if (qrPart1Div) {
                    qrPart1Div.style.top = '20px';
                    qrPart1Div.style.left = '20px'; /*qrPart1Div.style.transform = 'rotate(-10deg)';*/
                }
                if (qrPart2Div) {
                    qrPart2Div.style.top = '50%';
                    qrPart2Div.style.left = '50%';
                    qrPart2Div.style.transform = 'translate(-50%, -50%) rotate(0deg)';
                    qrPart2Div.style.zIndex = '10';
                }
                if (qrPart3Div) {
                    qrPart3Div.style.top = '20px';
                    qrPart3Div.style.right = '20px'; /*qrPart3Div.style.transform = 'rotate(10deg)';*/
                }


                if (success1 && success2 && success3 && downloadBtn && htmlToCanvasLibraryReady) {
                    downloadBtn.disabled = false;
                } else {
                    if (downloadBtn) downloadBtn.disabled = true;
                    if (!(success1 && success2 && success3)) {
                        showMessage("Lỗi khi tạo một hoặc nhiều phần của mã QR.", 'error');
                    }
                }
            }

            let qrAttempts = 0;
            const maxQrAttempts = 50;

            function checkQrCodeLibrary() {
                qrAttempts++;
                if (typeof QRCode !== 'undefined') {
                    initializeCoreApp();
                } else if (qrAttempts < maxQrAttempts) {
                    setTimeout(checkQrCodeLibrary, 100);
                } else {
                    console.error("Không thể tải thư viện QRCode (qrcode.js) sau " + maxQrAttempts +
                        " lần thử.");
                    let errorMsg = `Lỗi nghiêm trọng: Không thể tải thư viện QRCode (từ cdnjs.cloudflare.com) sau ${maxQrAttempts} lần thử.<br>Ứng dụng không thể khởi tạo.<br>
                                    Nguyên nhân có thể là vấn đề kết nối mạng hoặc CDN bị chặn.<br>
                                    Vui lòng kiểm tra và thử làm mới trang.`;
                    showMessage(errorMsg);
                    if (generateBtn) generateBtn.disabled = true;
                    if (downloadBtn) downloadBtn.disabled = true;
                }
            }

            let htmlToCanvasAttempts = 0;
            const maxHtmlToCanvasAttempts = 30;

            function checkHtmlToCanvasLibrary() {
                htmlToCanvasAttempts++;
                if (typeof html2canvas !== 'undefined') {
                    htmlToCanvasLibraryReady = true;
                    console.log(
                        "Thư viện html2canvas đã tải. Chức năng tải xuống được kích hoạt (nếu QR đã được tạo)."
                        );
                    if (qrCodeLibraryReady && qrCompositeWrapper && qrCompositeWrapper.querySelector(
                            '.qr-individual-part canvas, .qr-individual-part img')) {
                        if (downloadBtn) downloadBtn.disabled = false;
                    }
                } else if (htmlToCanvasAttempts < maxHtmlToCanvasAttempts) {
                    setTimeout(checkHtmlToCanvasLibrary, 100);
                } else {
                    htmlToCanvasLibraryReady = false;
                    console.warn("Thư viện html2canvas (từ cdnjs.cloudflare.com) không tải được sau " +
                        maxHtmlToCanvasAttempts + " lần thử.");
                    if (qrCodeLibraryReady) {
                        showMessage(
                            "Lưu ý: Không thể tải thư viện lưu ảnh (html2canvas). Chức năng tạo QR vẫn hoạt động, nhưng tải xuống sẽ không khả dụng. <br>Nguyên nhân có thể do kết nối mạng hoặc CDN (cdnjs.cloudflare.com) gặp sự cố/bị chặn.",
                            'error');
                    }
                    if (downloadBtn) downloadBtn.disabled = true;
                }
            }

            if (generateBtn) generateBtn.disabled = true;
            if (downloadBtn) downloadBtn.disabled = true;

            checkQrCodeLibrary();
        });

        //parram url

        var params = new URLSearchParams(window.location.search);
        var extractedUrl = params.get("url");

        try {
            // Kiểm tra xem extractedUrl có phải URL hợp lệ hay không
            if (extractedUrl) {
                new URL(extractedUrl); // Nếu không hợp lệ sẽ ném lỗi
                document.querySelector("#qr-url").value = extractedUrl;
            }
        } catch (e) {
            console.warn("Giá trị không phải là URL hợp lệ:", extractedUrl);
        }

        console.log(extractedUrl); // https://shopee.vn/some-product
        </script>


        <style>
        .container {
            background-color: #ffffff;
            padding: 35px 45px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
            width: 100%;
            max-width: 520px;
            text-align: center;
        }

        h1 {
            color: #1e293b;
            margin-bottom: 30px;
            font-weight: 700;
            font-size: 2em;
        }
        body { font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji"; background: linear-gradient(180deg, #f8fbff 0%, #f2f6ff 100%); padding: 30px 12px; }
        .hero { margin-bottom: 20px; text-align: center; }
        .hero-title { margin: 0 0 6px; font-size: 22px; color: #0f172a; }
        .hero-sub { margin: 0; color: #475569; font-size: 14px; }
        .card { background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 16px; margin-bottom: 24px; }
        .md5-result { background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 12px; margin-top: 12px; text-align: left; }
        .result-title { font-weight: 700; color: #0f172a; margin-bottom: 8px; }
        .result-line { display: flex; align-items: center; gap: 8px; color: #1e293b; margin: 6px 0; word-break: break-all; }
        .result-line code { background:#e2e8f0; padding:2px 6px; border-radius:6px; }
        .result-line .url { color:#2563eb; text-decoration: none; }
        .result-line .url:hover { text-decoration: underline; }
        .badge { display:inline-block; font-size:12px; padding:2px 8px; border-radius:999px; background:#e0f2fe; color:#0369a1; font-weight:600; }
        .actions { margin-top: 10px; display:flex; gap:10px; }
        .btn-secondary { background:#0ea5e9; color:#fff; border:none; padding:10px 14px; border-radius:8px; cursor:pointer; font-weight:600; font-size:14px; }
        .btn-secondary:hover { background:#0284c7; }
        .hint { display:block; margin-top:6px; color:#64748b; }

        /* Advanced */
        details.advanced { background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:10px 12px; margin-bottom:18px; }
        details.advanced > summary { cursor:pointer; font-weight:600; color:#0f172a; outline:none; }
        .advanced-grid { display:grid; grid-template-columns: 1fr; gap:14px; margin-top:10px; }
        @media(min-width:600px){ .advanced-grid { grid-template-columns: 1fr 1fr; } }

        .qr-individual-part { position:absolute; }
        .qr-individual-part.padded { background: transparent; }
        .qr-logo-overlay { position:absolute; top:50%; left:50%; transform: translate(-50%, -50%); width:35%; height:35%; object-fit:contain; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,.15); background:#fff; padding:6px; }

        .input-section { margin-bottom: 30px; }

        .input-group {
            margin-bottom: 22px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 10px;
            color: #475569;
            font-weight: 500;
            font-size: 0.9em;
        }

        .input-group textarea,
        .input-group input[type="number"],
        /* Mặc dù qr-size bị loại bỏ, giữ lại style nếu cần dùng input number khác */
        .input-group .color-picker-wrapper input[type="color"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            box-sizing: border-box;
            font-size: 0.95em;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            color: #334155;
        }

        .input-group textarea {
            min-height: 80px;
            resize: vertical;
        }

        .input-group textarea:focus,
        .input-group input[type="number"]:focus,
        .input-group .color-picker-wrapper input[type="color"]:focus {
            border-color: #60a5fa;
            outline: none;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.2);
        }

        .color-picker-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .color-picker-wrapper input[type="color"] {
            width: 60px;
            height: 48px;
            padding: 5px;
            min-width: 60px;
        }

        .color-hex-display {
            font-family: 'Roboto Mono', monospace;
            font-size: 0.9em;
            color: #475569;
            background-color: #f1f5f9;
            padding: 8px 10px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-top: 12px;
            padding: 10px;
            background-color: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .checkbox-container input[type="checkbox"] {
            margin-right: 10px;
            width: auto;
            transform: scale(1.1);
            accent-color: #60a5fa;
        }

        .checkbox-container label {
            margin: 0;
            font-weight: 400;
            color: #475569;
            font-size: 0.85em;
        }

        .controls {
            margin-top: 35px;
            margin-bottom: 35px;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        @media (min-width: 480px) {
            .controls {
                flex-direction: row;
                justify-content: center;
            }
        }

        .controls button {
            background: linear-gradient(135deg, #5eead4 0%, #60a5fa 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1em;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .controls button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(96, 165, 250, 0.3);
        }

        .controls button:active {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(96, 165, 250, 0.2);
        }

        .controls button:disabled {
            background: #cbd5e1;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
            color: #94a3b8;
        }

        .qr-preview-section {
            margin-top: 25px;
            padding: 10px;
            border: 2px dashed #93c5fd;
            border-radius: 16px;
            background-color: #f3f8ff;
            min-height: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .qr-preview-section h2 {
            margin-top: 0;
            margin-bottom: 25px;
            color: #1e293b;
            font-size: 1.5em;
            font-weight: 600;
        }

        #qr-composite-wrapper {
            width: 300px;
            height: 300px;
            margin: 0 auto;
            position: relative;

            /* background-color sẽ được đặt bởi JS */
        }

        .qr-individual-part {
            position: absolute;
            /* Kích thước sẽ được đặt bởi JS là 150px x 150px */
        }

        .qr-individual-part canvas,
        .qr-individual-part img {
            width: 100% !important;
            height: 100% !important;
            object-fit: contain;
            display: block;
        }

        .message-area {
            margin-top: 20px;
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 0.9em;
            display: none;
            text-align: left;
            line-height: 1.6;
        }

        .message-area.error {
            background-color: #fff1f2;
            color: #ef4444;
            border: 1px solid #fecaca;
            display: block;
        }

        .message-area.success {
            background-color: #f0fdf4;
            color: #22c55e;
            border: 1px solid #bbf7d0;
            display: block;
        }

        .qr-tai img {
            border-radius: 50%;
        }

        .qr-main img {
            transform: rotate(45deg);
        }
        </style>
    </div>

</body>

</html>