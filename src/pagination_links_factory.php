<?php

$products_per_page = 10;

function get_pagination_links(int $page, int $total_products , string $category = '') : string {
global $products_per_page;
$total_pages = $total_products / $products_per_page;
$total_pages = ceil($total_pages);

// Visualizza i link di paginazione
$pagination_links =  "<nav role='navigation' aria-label='Pagination Navigation'><ul>";
$next = $previous = "";

    if ($page > 1) {
        $previous = "<li><a href='?page=" . ($page - 1) .
                    ($category != null? "&category=$category": '') .
                    "' aria-label='Vai alla pagina precedente,Pagina " . ($page-1) . "'>Precedente</a></li>";
    } else {
        $previous = "<span>Precedente</span> "; // Disabled state
    }
$pagination_links .= $previous;
for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        $pagination_links .= "<li><a href='/page=$i' aria-label='Pagina attuale,Pagina $i' aria current='true'><strong>$i</strong></a></li>"; // Pagina corrente senza link
    } else {
        $pagination_links .= "<li><a href='?page=$i aria-label='Vai a pagina $i'" . 
                             ($category != null? "&category=$category": '') .
                             "'>$i</a></li> "; // Altre pagine con link
    }
}

if ($page < $total_pages) {
    $next = "<li><a href='?page=" . ($page + 1) .
            ($category != null? "&category=$category": '') .
            "' aria-label='Vai alla pagina successiva,Pagina " . ($page+1) . "'>Prossimo</a></li>";
} else {
    $next = "<span>Prossimo</span>"; // Disabled state
}
$pagination_links .= $next;
$pagination_links .=  "</ul>";

return $pagination_links;
}
?>

<li>
          <a href="/page-3" aria-label="Current Page, Page 3" aria-current="true">3</a>
        </li>

        <nav role="navigation" aria-label="Pagination Navigation">
    <ul>
        <li><a href="/page-1" aria-label="Goto Page 1">1</a></li>
        <li><a href="/page-2" aria-label="Goto Page 2">2</a></li>
        <li><a href="/page-3" aria-label="Goto Page 3">3</a></li>
        <li><a href="/page-4" aria-label="Goto Page 4">4</a></li>
        <li><a href="/page-5" aria-label="Goto Page 5">5</a></li>
    </ul>
</nav>