{*Đây chỉ là Demo, vui lòng không lạm dụng*}

<img id="gemini-icon" src="https://static.vecteezy.com/system/resources/thumbnails/046/861/646/small_2x/gemini-icon-on-a-transparent-background-free-png.png" width="50" height="50" onclick="toggleChatBox()">
<div id="chat-box">
    <button id="close-chat-box">x</button>
    <div id="name-input-area" style="display: none;">
        <p class="txt_entername mb-3">{$core->get_Lang('Hello, please enter your name')}.</p>
        <input type="text" id="user-name-input" placeholder="{$core->get_Lang('Enter your name')}">
        <button id="confirm-name-button">{$core->get_Lang('Confirm')}</button>
    </div>
    <div id="messages">
        <div class="message bot-message" id="welcome-message">
            <div class="message-content">
                {$core->get_Lang('Hello')}
                <span id="user-display-name">
                {if $loggedIn eq '1'}
                    {$oneProfile.full_name}
                {else}
                    {$core->get_Lang('User')}
                {/if}
                </span>, {$core->get_Lang('May I help you')}?
            </div>
        </div>
    </div>
    <div id="input-area">
        <button id="add-image">+</button>
        <input type="text" id="user-input">
        <button id="send-button">
            <i class="fas fa-microphone"></i>
            <i id="send-icon" class="fas fa-paper-plane" style="display: none;"></i>
        </button>
    </div>
</div>

<script>
    var loggedIn = "{$loggedIn}";
    var user1 = "{$core->get_Lang('User')}";
    var user2 = "{$oneProfile.full_name}";
    var user;
    var userName = user1;
    var helloLang = "{$core->get_Lang('Hello')}";
    var mayIHelpLang = "{$core->get_Lang('May I help you')}";
</script>

{literal}
    <script>

        let nameInputArea = document.getElementById("name-input-area");
        let userNameInput = document.getElementById("user-name-input");
        let confirmNameButton = document.getElementById("confirm-name-button");
        let userDisplayName = document.getElementById("user-display-name");
        let welcomeMessage = document.getElementById("welcome-message");
        let inputArea = document.getElementById("input-area");
        let addImageButton = document.getElementById("add-image");
        let userInputField = document.getElementById("user-input");
        let sendButtonElement = document.getElementById("send-button");


        let chatBox = document.getElementById("chat-box");
        let messagesDiv = document.getElementById("messages");
        const addButton = document.getElementById('add-image');
        const sendButton = document.getElementById('send-button');
        const userInput = document.getElementById('user-input');
        const micIcon = document.querySelector('#send-button .fas.fa-microphone');
        const sendIcon = document.getElementById('send-icon');

        addButton.addEventListener('click', addImage);
        sendButton.addEventListener('click', handleSendOrMic); // Sửa tên hàm
        userInput.addEventListener('input', toggleIcon);


        function toggleIcon() {
            if (userInput.value.trim() !== '') {
                micIcon.style.display = 'none';
                sendIcon.style.display = 'inline-block';
            } else {
                micIcon.style.display = 'inline-block';
                sendIcon.style.display = 'none';
            }
        }

        function addImage() {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*'; // Chỉ cho phép chọn file ảnh

            input.onchange = (event) => {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const imgContainer = document.createElement('div'); // Tạo div để chứa ảnh và nút xóa
                        imgContainer.style.position = 'relative';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '150px';

                        const deleteButton = document.createElement('i');
                        deleteButton.classList.add('fas', 'fa-times'); // Thêm class Font Awesome
                        deleteButton.style.position = 'absolute';
                        deleteButton.style.top = '0';
                        deleteButton.style.right = '0';
                        deleteButton.style.cursor = 'pointer'; // Thêm cursor

                        deleteButton.onclick = () => {
                            messagesDiv.removeChild(imgContainer); // Xóa container
                        };

                        imgContainer.appendChild(img);
                        imgContainer.appendChild(deleteButton);
                        messagesDiv.appendChild(imgContainer);
                        messagesDiv.scrollTop = messagesDiv.scrollHeight;
                    };

                    reader.readAsDataURL(file);
                }
            };

            input.click(); // Mở hộp thoại chọn file
        }

        function handleSendOrMic() {
            const inputValue = userInput.value.replace(/\s/g, ''); // Loại bỏ khoảng trắng
            if (userInput.value.trim() !== '') {
                sendMessage(); // Gửi tin nhắn nếu input không trống
            } else {
                // Thêm logic ghi âm ở đây nếu cần
                alert('Chức năng ghi âm chưa được triển khai.');
            }
        }

        function toggleChatBox() {
            if (chatBox.style.display === "flex") {
                chatBox.style.display = "none";
            } else {
                chatBox.style.display = "flex";
                if (loggedIn != '1' && !userName) {
                    nameInputArea.style.display = "block";
                }
            }
        }

        userNameInput.addEventListener('keypress', function(event) {
            if (event.key === "Enter") {
                confirmName();
            }
        });

        sendButton.addEventListener('click', sendMessage);
        userInput.addEventListener('keypress', (event) => {
            if (event.key === 'Enter') {
                sendMessage();
            }
        });

        function initializeChat() {
            if (loggedIn == '1') {
                user = user2;
                userName = user2;
                inputArea.style.display = "flex";
                enableInput();
            } else {
                const storedUserName = sessionStorage.getItem('userName');
                if (storedUserName) {
                    user = storedUserName;
                    userName = storedUserName;
                    userDisplayName.textContent = storedUserName;
                    nameInputArea.style.display = "none";
                    inputArea.style.display = "flex";
                    enableInput();
                    welcomeMessage.style.display = "none";
                } else {
                    user = user1;
                    userName = user1;
                    nameInputArea.style.display = "block";
                    welcomeMessage.style.display = "none";
                    disableInput();
                }
            }

            // Tải lại tin nhắn từ sessionStorage
            const storedMessages = sessionStorage.getItem('chatHistory');
            if (storedMessages) {
                const messagesArray = JSON.parse(storedMessages);
                messagesArray.forEach(message => {
                    displayMessage(message.sender, message.message);
                });
            }
        }

        initializeChat(); // Gọi hàm initializeChat() sau khi loggedIn được gán giá trị

        confirmNameButton.addEventListener('click', function() {
            const userName = userNameInput.value.trim();
            if (userName !== '') {
                sessionStorage.setItem('userName', userName);
                userDisplayName.textContent = userName;
                nameInputArea.style.display = "none";
                inputArea.style.display = "flex";
                enableInput();
                welcomeMessage.style.display = "none";

                user = userName; // Lưu trữ biến user

                let formattedMessage = helloLang + " " + userName + ", " + mayIHelpLang + "?";
                displayMessage('bot', formattedMessage, true); // Gọi hàm với người gửi là 'bot'
            }
        });



        function sendMessage() {
            const userInput = document.getElementById('user-input');
            const message = userInput.value;
            if (message.trim() === '') return;

            displayMessage(user, message);
            userInput.value = '';

            // Lưu trữ tin nhắn vào sessionStorage
            const storedMessages = sessionStorage.getItem('chatHistory');
            if (storedMessages) {
                const messagesArray = JSON.parse(storedMessages);
                messagesArray.push({ sender: user, message: message }); // Thêm sender
                sessionStorage.setItem('chatHistory', JSON.stringify(messagesArray));
            } else {
                const messagesArray = [{ sender: user, message: message }]; // Thêm sender
                sessionStorage.setItem('chatHistory', JSON.stringify(messagesArray));
            }

            // Gửi tin nhắn đến server
            let loadingDiv = document.createElement('div');
            loadingDiv.classList.add('loading');
            messagesDiv.appendChild(loadingDiv);

            $.ajax({
                url: `${path_ajax_script}index.php?mod=home&act=ajai_test2025`,
                type: 'POST',
                contentType: 'application/json', // Set content type to JSON
                data: JSON.stringify({ message: message }), // Send JSON data
                success: function(data) {
                    loadingDiv.remove();
                    try {
                        const jsonData = JSON.parse(data);
                        if (jsonData.candidates && jsonData.candidates[0].content && jsonData.candidates[0].content.parts && jsonData.candidates[0].content.parts[0].text) {
                            const geminiResponse = jsonData.candidates[0].content.parts[0].text;
                            // Kiểm tra nếu có kết quả tìm kiếm từ PHP
                            if (jsonData.searchResults && jsonData.searchResults.length > 0) {
                                let searchResultsHtml = "Kết quả tìm kiếm:\n";
                                jsonData.searchResults.forEach(result => {
                                    searchResultsHtml += `- <a href="${result.slug}">${result.title}</a>\n`; // Tạo liên kết đến trang chi tiết
                                });
                                displayTypingEffect('gemini', geminiResponse + "\n" + searchResultsHtml); // Hiển thị kết quả tìm kiếm cùng với phản hồi từ Gemini
                            } else {
                                displayTypingEffect('gemini', geminiResponse);
                            }
                            // Lưu trữ tin nhắn của bot vào sessionStorage
                            const storedMessages = sessionStorage.getItem('chatHistory');
                            if (storedMessages) {
                                const messagesArray = JSON.parse(storedMessages);
                                messagesArray.push({ sender: 'gemini', message: geminiResponse });
                                sessionStorage.setItem('chatHistory', JSON.stringify(messagesArray));
                            } else {
                                const messagesArray = [{ sender: 'gemini', message: geminiResponse }];
                                sessionStorage.setItem('chatHistory', JSON.stringify(messagesArray));
                            }
                        } else {
                            displayMessage('gemini', "Gemini API trả về kết quả không mong muốn");
                            // Lưu trữ tin nhắn của bot vào sessionStorage
                            const storedMessages = sessionStorage.getItem('chatHistory');
                            if (storedMessages) {
                                const messagesArray = JSON.parse(storedMessages);
                                messagesArray.push({ sender: 'gemini', message: "Gemini API trả về kết quả không mong muốn" });
                                sessionStorage.setItem('chatHistory', JSON.stringify(messagesArray));
                            } else {
                                const messagesArray = [{ sender: 'gemini', message: "Gemini API trả về kết quả không mong muốn" }];
                                sessionStorage.setItem('chatHistory', JSON.stringify(messagesArray));
                            }
                        }
                    } catch (e) {
                        console.error("JSON parsing error:", e);
                        displayMessage('gemini', "Lỗi phân tích JSON");
                        // Lưu trữ tin nhắn của bot vào sessionStorage
                        const storedMessages = sessionStorage.getItem('chatHistory');
                        if (storedMessages) {
                            const messagesArray = JSON.parse(storedMessages);
                            messagesArray.push({ sender: 'gemini', message: "Lỗi phân tích JSON" });
                            sessionStorage.setItem('chatHistory', JSON.stringify(messagesArray));
                        } else {
                            const messagesArray = [{ sender: 'gemini', message: "Lỗi phân tích JSON" }];
                            sessionStorage.setItem('chatHistory', JSON.stringify(messagesArray));
                        }
                    }
                },
                error: function(xhr, status, error) {
                    loadingDiv.remove();
                    console.error('Error:', error);
                    displayMessage('gemini', 'An error occurred.');
                    // Lưu trữ tin nhắn của bot vào sessionStorage
                    const storedMessages = sessionStorage.getItem('chatHistory');
                    if (storedMessages) {
                        const messagesArray = JSON.parse(storedMessages);
                        messagesArray.push({ sender: 'gemini', message: 'An error occurred.' });
                        sessionStorage.setItem('chatHistory', JSON.stringify(messagesArray));
                    } else {
                        const messagesArray = [{ sender: 'gemini', message: 'An error occurred.' }];
                        sessionStorage.setItem('chatHistory', JSON.stringify(messagesArray));
                    }
                }
            });
        }


        function displayMessage(sender, message, isBot = false) {
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('message');

            if (sender === 'gemini') { // Kiểm tra sender để xác định lớp CSS
                messageDiv.classList.add('bot-message');
            } else {
                messageDiv.classList.add('user-message');
            }

            // Chuyển đổi Markdown sang HTML
            message = message.replace(/\*\*(.*?)\*\*/g, '<b>$1</b>'); // In đậm
            message = message.replace(/\*(.*?)\*/g, '<i>$1</i>'); // In nghiêng

            messageDiv.innerHTML = `<div class="message-content">${sender}: ${message}</div>`;


            messagesDiv.appendChild(messageDiv);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        function decodeHtml(html) {
            var txt = document.createElement("textarea");
            txt.innerHTML = html;
            return txt.value;
        }

        async function displayTypingEffect(sender, message) {
            let messageDiv = document.createElement('div');
            messageDiv.classList.add('message', 'bot-message');

            let contentSpan = document.createElement('span');
            contentSpan.classList.add('message-content');

            messageDiv.appendChild(contentSpan);
            messagesDiv.appendChild(messageDiv);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;

            let decodedMessage = decodeHtml(message);

            // Xử lý Markdown: in đậm, in nghiêng
            decodedMessage = decodedMessage.replace(/\*\*(.*?)\*\*/g, '<b>$1</b>'); // In đậm
            decodedMessage = decodedMessage.replace(/\*(.*?)\*/g, '<i>$1</i>'); // In nghiêng

            let i = 0;
            let interval = setInterval(() => {
                if (i < decodedMessage.length) {
                    contentSpan.innerHTML += decodedMessage.charAt(i);
                    i++;
                    messagesDiv.scrollTop = messagesDiv.scrollHeight;
                } else {
                    clearInterval(interval);
                    messageDiv.classList.add('show');
                }
            }, 10);
        }

        function enableInput() {
            addImageButton.disabled = false;
            userInputField.disabled = false;
            sendButtonElement.disabled = false;
        }

        function disableInput() {
            addImageButton.disabled = true;
            userInputField.disabled = true;
            sendButtonElement.disabled = true;
        }

        // Lấy element của nút đóng
        const closeChatBoxButton = document.getElementById('close-chat-box');

        // Thêm event listener cho sự kiện click
        closeChatBoxButton.addEventListener('click', function() {
            chatBox.style.display = "none"; // Ẩn chat box khi click vào icon "x"
        });

    </script>


    <style>
        #gemini-icon {
            position: fixed;
            bottom: 20px;
            left: 20px;
            cursor: pointer;
            z-index: 99;
            /* Thêm animation cho icon ở đây (ví dụ: xoay, nhấp nháy) */
            width: 100%;
            max-width: 50px;
        }

        #chat-box {
            position: fixed;
            bottom: 80px;
            left: 20px;
            /*width: 400px;*/
            height: 450px;
            border: 1px solid #ccc;
            padding: 10px 28px 10px 10px;
            display: none; /* Ẩn ban đầu */
            flex-direction: column;
            z-index: 99;
            background: #FFF;
            border-radius: 10px; /* Bo góc */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Tạo bóng đổ */


        }

        .message.bot-message {
            background-color: #f0f0f0;
            padding: 8px 12px;
            border-radius: 10px;
            margin-bottom: 5px;
            align-self: flex-start;
            line-height: 25px;
        }

        .message.user-message {
            background-color: #e0e0ff; /* Màu nền khác biệt */
            padding: 8px 12px;
            border-radius: 10px;
            margin-bottom: 5px;
            align-self: flex-end;
            line-height: 25px;
        }

        .message-content {
            word-wrap: break-word; /* Cho phép chữ xuống dòng nếu quá dài */
        }

        #messages {
            flex-grow: 1;
            overflow-y: auto;
            padding: 10px;
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 400px;
        }

        #input-area {
            display: flex;
            align-items: center;
            border-top: 1px solid #eee;
            border-radius: 0 0 10px 10px; /* Bo góc dưới */
            padding: 10px;
            margin-top: 10px;

        }

        #input-area input[type="text"] {
            flex-grow: 1;
            padding: 8px;
            border: 1px solid #ccc;
        }

        #input-area button {
            padding: 8px 12px;
            border: none;
            color: #0a0a0a;
            cursor: pointer;
        }


        #user-input {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 5px;
        }

        #send-button {
            background: none;
            border: none;
            padding: 0px;
            cursor: pointer;
        }

        #send-button i {
            font-size: 1.5em; /* Tăng kích thước icon */
            color: #0a0a0a; /* Màu icon */
        }

        #add-image {
            background: none;
            border: none;
            padding: 8px;
            cursor: pointer;
            font-size: 1.2em;
            margin-right: 5px;
        }


        .loading {
            /* Animation loading */
            border: 4px solid rgba(0, 0, 0, 0.1);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border-left-color: #09f;
            animation: spin 1s ease infinite;
        }

        #messages div[style*="position: relative;"] { /* Chọn imgContainer */
            display: inline-block; /* Hoặc block, tùy thuộc vào cách bạn muốn hiển thị */
            margin-right: 5px; /* Thêm khoảng cách giữa các ảnh */
        }

        #messages div[style*="position: relative;"] i.fas.fa-times { /* Chọn icon X */
            top: 5px; /* Điều chỉnh vị trí */
            right: 5px; /* Điều chỉnh vị trí */
        }

        #name-input-area {
            display: none;
            margin: 20px auto; /* Căn giữa nếu muốn */
        }

        #user-name-input {
            width: 100%; /* Tính toán độ rộng để trừ đi padding và border */
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box; /* Đảm bảo padding và border không làm tăng kích thước */
        }

        #confirm-name-button {
            width: 100%;
            padding: 10px;
            background-color: #008cba; /* Màu xanh dương, bạn có thể thay đổi */
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease; /* Hiệu ứng chuyển màu khi hover */
        }

        #confirm-name-button:hover {
            background-color: #0056b3; /* Màu xanh đậm hơn khi hover */
        }

        .txt_entername {
            margin-bottom: 10px;
            font-size: 16px;
            color: #333;
        }


        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #close-chat-box {
            position: absolute;
            right: 8px;
            background-color: transparent;
            border: none;
            font-size: 18px;
            cursor: pointer;
        }

        .bot-message .message-content {
            transition: opacity 0.3s ease-in-out;
        }

    </style>

{/literal}
