<?php 

function buildFooter() : string {
    
    session_start();

    $footerTemplate = file_get_contents("./templates/footer.html");

    return $footerTemplate;
}

?>