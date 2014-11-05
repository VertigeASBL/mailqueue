<?php
/**
 * Options du plugin API Mailqueueau chargement
 *
 * @plugin     API Mailqueue
 * @copyright  2014
 * @author     Vertige (Didier)
 * @licence    GNU/GPL
 * @package    SPIP\Mailqueue\Options
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

// Taille d'un lot de mail. (Nombre de mail envoyer)
define(MAILQUEUE_CADENCE, 10);

// Nombre de seconde entre chaque l'envoie (Dépendant du Cron de SPIP cenpendant)
define(MAILQUEUE_FREQUENCE, 120);
