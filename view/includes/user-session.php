<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    date_default_timezone_set('Europe/Paris');
    setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
    if (!isset($_SESSION['START'])) {
        $_SESSION['START'] = false;
    }
}

// Initialisation des variables de session
if (!isset($_SESSION['notif-modal'])) {
    $_SESSION['notif-modal'] = [];
}
/**
 * Méthode qui ajoute une notification dans la session
 * @param $type // C'est le type de la notification (success, info, warning, danger) (couleur de la notification)
 * @param $title // C'est le titre de la notification
 * @param $message // C'est le message de la notification
 */
function add_notif_modal($type, $title, $message)
{
    $_SESSION['notif-modal'][] = array(
        'type' => $type,
        'title' => $title,
        'message' => $message
    );
}

/**
 * Méthode qui vérifie si l'utilisateur a le niveau d'accès requis
 * @param $level // C'est le niveau d'accès requis
 * @return bool // Retourne true si l'utilisateur a le niveau d'accès requis, false sinon
 * Les niveaux d'accès surpérieurs ont aussi accès aux niveaux inférieurs
 * niveau d'accès :
 * 0 = visiteur (non connecté) & l'inscription (L'utilisateur à un accès à 0 lors de son inscription)
 * 10 = professeur
 * 100 = accès total
 */
function hasAccess($level)
{
    // vérifier si un session est démarré
    if (!UserConnected()) {
        return false;
    }

    // on vérifie si l'utilisateur a le niveau d'accès requis
    // dans $_SESSION['Permission'] on à un varchar : 1,20,30
    if (strpos($_SESSION['Permission'], $level) !== false || strpos($_SESSION['Permission'], 100) !== false) {
        return true;
    } else {
        return false;
    }
}


/**
 * Méthode qui vérifie si l'utilisateur est connecté
 * @return bool // Retourne true si l'utilisateur est connecté, false sinon
 */
function UserConnected()
{
    return $_SESSION['START'];
}