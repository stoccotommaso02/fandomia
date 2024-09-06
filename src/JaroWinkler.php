<?php
function jaro_winkler($str1, $str2) {
    $jaro_distance = jaro($str1, $str2);
    $prefix_scale = 0.1; // Costante per la scala di Jaro-Winkler (valore standard 0.1)
    $prefix_length = 0;

    // Calcola il prefisso comune fino a 4 caratteri
    for ($i = 0; $i < min(4, strlen($str1), strlen($str2)); $i++) {
        if ($str1[$i] === $str2[$i]) {
            $prefix_length++;
        } else {
            break;
        }
    }

    return $jaro_distance + ($prefix_length * $prefix_scale * (1.0 - $jaro_distance));
}

function jaro($str1, $str2) {
    $str1_len = strlen($str1);
    $str2_len = strlen($str2);

    if ($str1_len === 0 && $str2_len === 0) return 1.0;

    $match_distance = (int) floor(max($str1_len, $str2_len) / 2) - 1;

    $str1_matches = array_fill(0, $str1_len, false);
    $str2_matches = array_fill(0, $str2_len, false);

    $matches = 0;
    $transpositions = 0;

    // Controlla le corrispondenze tra i caratteri
    for ($i = 0; $i < $str1_len; $i++) {
        $start = max(0, $i - $match_distance);
        $end = min($i + $match_distance + 1, $str2_len);

        for ($j = $start; $j < $end; $j++) {
            if ($str2_matches[$j]) continue;
            if ($str1[$i] !== $str2[$j]) continue;
            $str1_matches[$i] = true;
            $str2_matches[$j] = true;
            $matches++;
            break;
        }
    }

    if ($matches === 0) return 0.0;

    $k = 0;
    for ($i = 0; $i < $str1_len; $i++) {
        if (!$str1_matches[$i]) continue;
        while (!$str2_matches[$k]) $k++;
        if ($str1[$i] !== $str2[$k]) $transpositions++;
        $k++;
    }

    return (
        (($matches / $str1_len) + ($matches / $str2_len) + (($matches - $transpositions / 2) / $matches)) / 3.0
    );
}

