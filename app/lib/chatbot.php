<?php

class Chatbot
{
    private $chatbotModel;

    public function __construct()
    {
        $this->chatbotModel = new ChatbotModel();  // Crear una instancia del modelo
    }
    public function chat()
    {
        if (isset($_POST['message'])) {
            $userMessage = trim($_POST['message']);
            $userMessage = strtolower($userMessage);


            // Guardamos el mensaje del usuario en la base de datos
            // $this->chatbotModel->agregarMensaje($userMessage, "Mensaje del usuario");

            // Intentamos encontrar una respuesta en la base de datos
            $respuestas = $this->chatbotModel->responderMensaje($userMessage);

            if (!empty($respuestas)) {
                // Si encontramos una respuesta relacionada, la mostramos
                echo $respuestas[0]['contenido']; // O lo que desees de la base de datos
                // $this->chatbotModel->agregarMensaje($respuestas[0]['contenido'], "Respuesta del bot");
            } else {
                // Si no encontramos respuesta, respondemos de forma predeterminada
                echo "Lo siento, no entiendo esa pregunta. ¿Puedes intentar de nuevo?";
                // $this->chatbotModel->agregarMensaje("Lo siento, no entiendo esa pregunta. ¿Puedes intentar de nuevo?", "Respuesta del bot");
            }
        }

        // if (isset($_POST['message'])) {
        //     $userMessage = trim($_POST['message']);
        //     $userMessage = strtolower($userMessage);

        //     // Aquí, guardamos el mensaje del usuario en la base de datos
        //     $this->chatbotModel->agregarMensaje($userMessage, "Mensaje del usuario");

        //     // Lógica para responder en función del mensaje
        //     if (strpos($userMessage, 'hola') !== false) {
        //         echo "¡Hola! ¿Cómo puedo ayudarte hoy?";
        //         $this->chatbotModel->agregarMensaje("¡Hola! ¿Cómo puedo ayudarte hoy?", "Respuesta del bot");
        //     } elseif (strpos($userMessage, 'adios') !== false) {
        //         echo "¡Adiós! ¡Que tengas un buen día!";
        //         $this->chatbotModel->agregarMensaje("¡Adiós! ¡Que tengas un buen día!", "Respuesta del bot");
        //     } elseif (strpos($userMessage, 'clima') !== false) {
        //         echo "El clima está soleado hoy, perfecto para salir.";
        //         $this->chatbotModel->agregarMensaje("El clima está soleado hoy, perfecto para salir.", "Respuesta del bot");
        //     } elseif (strpos($userMessage, 'nombre') !== false) {
        //         echo "Mi nombre es Cenfi, tu asistente virtual.";
        //         $this->chatbotModel->agregarMensaje("Mi nombre es Cenfi, tu asistente virtual.", "Respuesta del bot");
        //     } elseif (strpos($userMessage, 'hora') !== false) {
        //         echo "La hora actual es: " . date('H:i:s');
        //         $this->chatbotModel->agregarMensaje("La hora actual es: " . date('H:i:s'), "Respuesta del bot");
        //     } elseif (strpos($userMessage, '¿quién eres?') !== false) {
        //         echo "Soy un bot creado para ayudarte en lo que necesites.";
        //         $this->chatbotModel->agregarMensaje("Soy un bot creado para ayudarte en lo que necesites.", "Respuesta del bot");
        //     } else {
        //         echo "Lo siento, no entiendo esa pregunta. ¿Puedes intentar de nuevo?";
        //         $this->chatbotModel->agregarMensaje("Lo siento, no entiendo esa pregunta. ¿Puedes intentar de nuevo?", "Respuesta del bot");
        //     }
        // }
    }
}
