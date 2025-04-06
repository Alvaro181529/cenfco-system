<style>
    /* Estilos para la ventana de chat */
    #messages {
        display: flex;
        flex-direction: column;
        width: 100%;
        /* Asegura que el formulario ocupe todo el ancho disponible */
    }

    #chatbot {
        position: fixed;
        bottom: 20px;
        right: 100px;
        width: 300px;
        height: 400px;
        background-color: #fff;
        border-radius: 10px;
        border: #000;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        display: none;
        /* Inicialmente oculto */
        flex-direction: column;
        padding: 10px;
        z-index: 1000;
    }

    /* Estilos para el círculo */
    #chatbot-btn {
        position: fixed;
        bottom: 80px;
        right: 15px;
        width: 60px;
        height: 60px;
        background-color: #c4971d;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        z-index: 1001;
    }

    /* Estilo del icono dentro del círculo */
    #chatbot-btn i {
        color: white;
        font-size: 30px;
    }

    /* Estilos para el área del chat */
    #chat-area {
        flex-grow: 1;
        overflow-y: auto;
        margin-bottom: 10px;
    }

    /* Estilos para la entrada de texto */
    #chat-input {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 100%;
    }

    /* Estilos para el botón de enviar */
    #send-btn {
        background-color: #c4971d;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }


    #send-btn:hover {
        background-color: rgb(172, 134, 30);
    }
</style>

<div id="chatbot-btn">
    <i>💬</i>
</div>

<div id="chatbot">
    <div id="chat-area">
    </div>
    <form id="messages">
        <textarea type="text" id="chat-input" placeholder="Escribe un mensaje..." name="message"></textarea>
        <button id="send-btn" type="submit">Enviar</button>
    </form>
</div>

<script>
    const chatbot = document.getElementById('chatbot');
    const messages = document.getElementById('messages');
    const chatbotBtn = document.getElementById('chatbot-btn');
    const sendBtn = document.getElementById('send-btn');
    const chatArea = document.getElementById('chat-area');
    const chatInput = document.getElementById('chat-input');



    chatbotBtn.addEventListener('click', () => {
        if (chatbot.style.display === 'none' || chatbot.style.display === '') {
            chatbot.style.display = 'flex';
        } else {
            chatbot.style.display = 'none';
        }
    });

    messages.addEventListener('submit', async (e) => {
        e.preventDefault();
        const userMessage = chatInput.value.trim();
        if (userMessage) {
            const userMessageDiv = document.createElement('div');
            userMessageDiv.textContent = `Tú: ${userMessage}`;
            chatArea.appendChild(userMessageDiv);

            chatInput.value = '';
            const response = await fetch('/chatbot', {
                method: 'POST',
                body: new URLSearchParams({
                    message: userMessage
                }),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            });

            const botMessage = await response.text(); // La respuesta del bot
            setTimeout(() => {
                const botMessageDiv = document.createElement('div');
                botMessageDiv.textContent = `Cenfi: ${botMessage}`;
                chatArea.appendChild(botMessageDiv);

                chatArea.scrollTop = chatArea.scrollHeight;

            }, 1000);
        }
    });
</script>