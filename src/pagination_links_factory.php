<?php

function get_pagination_links(int $page, int $total_products, int $products_per_page = 12, string $category = '') : string {
$total_pages = $total_products / $products_per_page;
$total_pages = ceil($total_pages);

$pagination_links =  "<nav class='pagination' aria-label='Navigazione pagine di risultati'><ul>";
$next = $previous = "";

    if ($page > 1) {
        $previous = "<li><a href='?page=" . ($page - 1) .
                    ($category != null? "&category=$category": '') .
                    "' aria-label='Vai alla pagina precedente, pagina " . ($page-1) . "'>Precedente</a></li>";
    } else {
        $previous = "<li class='disabled'><span aria-hidden='true'>Precedente</span></li>"; 
    }
$pagination_links .= $previous;
for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        $pagination_links .= "<li><a href='?page=$i' aria-label='Pagina attuale, pagina $i' aria-current='true'><strong>$i</strong></a></li>"; // Pagina corrente senza link
    } else {
        $pagination_links .= "<li><a aria-label='Vai a pagina $i' href='?page=$i" . 
                             ($category != null? "&category=$category": '') .
                             "'>$i</a></li> "; 
    }
}

if ($page < $total_pages) {
    $next = "<li><a href='?page=" . ($page + 1) .
            ($category != null? "&category=$category": '') .
            "' aria-label='Vai alla pagina successiva, pagina " . ($page+1) . "'>Successiva</a></li>";
} else {
    $next = "<li class='disabled'><span aria-hidden='true'>Successiva</span></li>"; 
}
$pagination_links .= $next;
$pagination_links .=  "</ul></nav>";

return $pagination_links;
}
?>