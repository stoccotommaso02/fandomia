<?php

$prices = array("1-2","2-3");

        $prices_conditions = $params = array();
        $types = '';
    foreach($prices as $price_filter) {
        list($min, $max) = explode('-', $price_filter);
        $prices_conditions[] = "price BETWEEN ? and ?";
        $types .= "ii"; // Tipo intero per prezzo minimo e massimo
        $params[] = $min;
        $params[] = $max;
    }

    $sql = '';
    if (!empty($price_conditions)) {
        $sql .= " AND (" . implode(" OR ", $prices_conditions) . ")";
    }
    print_r($sql);
    print_r($types);
    print_r($params);

    $platform_inputs = array("Nintendo");

        $platforms = $params = array();
        $types = '';
    foreach($platform_inputs as $platform_input) {
        $platform_filter[] = "platform = ?";
        $types .= "s"; // Tipo intero per prezzo minimo e massimo
        $params[] = $platform_input;
    }

    $sql = '';
    if (!empty($platform_filter)) {
        $sql .= " AND (" . implode(" OR ", $platform_filter) . ")";
    }
    print_r($sql);
    print_r($types);
    print_r($params);

