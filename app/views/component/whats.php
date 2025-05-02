<style>
    .whatsapp-button {
        position: fixed;
        bottom: 20px;
        left: 20px;
        /* El contenedor sigue en la parte izquierda */
        z-index: 1000;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .whatsapp-icon {
        font-size: 50px;
        padding: 7px;
        color: #c4971d;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        background-color: #f1f1f1;
        transition: transform 0.2s ease;
    }

    .whatsapp-icon:hover {
        transform: scale(1.1);
    }
</style>


<div class="whatsapp-button" data-aos="zoom-out" data-aos-delay="50">
    <a href="https://api.whatsapp.com/send/?phone=59169975329&text&type=phone_number&app_absent=0" target="_blank">
        <i class="bi bi-whatsapp whatsapp-icon"></i>
    </a>
</div>