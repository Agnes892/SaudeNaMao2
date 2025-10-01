<?php

class Url {

    public static function redirecionar($url){
        //header - Envia um cabeçalho HTTP
        
        // Verifica se headers já foram enviados
        if (headers_sent($filename, $linenum)) {
            // Se headers já foram enviados, usa JavaScript
            echo '<script type="text/javascript">';
            echo 'window.location.href="'.URL.'/'.$url.'";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url='.URL.'/'.$url.'" />';
            echo '</noscript>';
            exit();
        }
        
        // Limpa todos os buffers de output
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        header("Location: ".URL."/".$url);
        exit(); // Importante: parar a execução após o redirecionamento
    }

}