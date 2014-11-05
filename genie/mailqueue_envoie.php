<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function genie_mailqueue_envoie_dist($t) {
    $envoyer_lot = charger_fonction('envoyer_lot', 'action');
    $envoyer_lot();
}