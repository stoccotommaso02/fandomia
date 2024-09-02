<?php

$products_per_page = 10;

function get_pagination_links(int $page, int $total_products) : string {
global $products_per_page;
$total_pages = $total_products / $products_per_page;
$total_pages = ceil($total_pages);

// Visualizza i link di paginazione
$pagination_links =  "<div class='pagination'>";
$next = $previous = "";

    if ($page > 1) {
        $previous = "<a href='products_page.php?page=" . ($page - 1) . "&category=$category'" . ">Previous</a>";
    } else {
        $previous = "<span>Previous</span> "; // Disabled state
    }
$pagination_links .= $previous;
for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $page) {
        $pagination_links .= "<strong>$i</strong> "; // Pagina corrente senza link
    } else {
        $pagination_links .= "<a href='products_page.php?page=$i&category=$category'>$i</a> "; // Altre pagine con link
    }
}

if ($page < $total_pages) {
    $next = "<a href='products_page.php?page=" . ($page + 1) . "&category=$category'" . ">Next</a>";
} else {
    $next = "<span>Next</span>"; // Disabled state
}
$pagination_links .= $next;
$pagination_links .=  "</div>";

return $pagination_links;
}
?>