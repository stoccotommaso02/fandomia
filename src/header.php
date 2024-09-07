<?php 
function buildHeader() : string {

    $current_page = basename($_SERVER['REQUEST_URI']);

    // Array di link del menu
    $menu_items = array(
        'index.php' => 'Home',
        'products_page.php?category=Libro' => 'Libri',
        'products_page.php?category=Musica' => 'Musica',
        'products_page.php?category=Fumetto' => 'Fumetti',
        'products_page.php?category=Videogioco' => 'Videogiochi',
        'reservationList.php' => 'Le tue prenotazioni'
    );

    // Crea un array che indica se un link deve essere disabilitato
    $links_state = [];
    $headerTemplate = file_get_contents("./templates/header.html");
    foreach ($menu_items as $action => $name) { 
        
        if($action == $current_page){
            if($name == 'Home'){
                $links_state[$action] = "<li id='current_link'><span lang='en'>$name</span></li>";
            }
            else{
                $links_state[$action] = "<li id='current_link'><span>$name</span></li>";
            }
            
        }
        else{
            if($name == 'Home'){
                $links_state[$action] = "<li><a href='$action' lang='en'>$name</a></li>";
            }
            else{
                $links_state[$action] = "<li><a href='$action'>$name</a></li>";
            }
        }

        $headerTemplate = str_replace("{{$name}}",$links_state[$action],$headerTemplate);
    }

    if (isset($_SESSION['loggedUser'])) {
        $logout = '<a href="logout.php">Logout</a>';
        $headerTemplate = str_replace('{{login/logout}}',$logout,$headerTemplate);
    } else {
        $login = $current_page == 'login.php' ? '<a href="#content" aria-label="Vai al form di login" id="login">Login</a>' : '<a href="login.php" id="login">Login</a>';
        $headerTemplate = str_replace('{{login/logout}}',$login,$headerTemplate);
    }

    return $headerTemplate;
}

