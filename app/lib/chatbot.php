<?php
class Chatbot
{
    public function chat()
    {
        if (isset($_POST['message'])) {
            $userMessage = trim($_POST['message']);
            $userMessage = strtolower($userMessage);
            if (strpos($userMessage, 'hola') !== false) {
                echo "¡Hola! ¿Cómo puedo ayudarte hoy?";
            } elseif (strpos($userMessage, 'adios') !== false) {
                echo "¡Adiós! ¡Que tengas un buen día!";
            } elseif (strpos($userMessage, 'clima') !== false) {
                echo "El clima está soleado hoy, perfecto para salir.";
            } elseif (strpos($userMessage, 'nombre') !== false) {
                echo "Mi nombre es Cenfi, tu asistente virtual.";
            } elseif (strpos($userMessage, 'hora') !== false) {
                echo "La hora actual es: " . date('H:i:s');
            } elseif (strpos($userMessage, '¿quién eres?') !== false) {
                echo "Soy un bot creado para ayudarte en lo que necesites.";
            } else {
                echo "Lo siento, no entiendo esa pregunta. ¿Puedes intentar de nuevo?";
            }
        }
    }
}
