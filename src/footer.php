<?php 

function buildFooter() : string {
    
    $footerTemplate = file_get_contents("./templates/footer.html");

    return $footerTemplate;
}

?>