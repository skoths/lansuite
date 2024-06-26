<?php

/**
 * @return bool
 */
function CheckExistingClan()
{
    global $auth, $database, $func;

    $clanuser = $database->queryWithOnlyFirstRow("SELECT clanid FROM %prefix%user WHERE userid = ?", [$auth['userid']]);
    if ($clanuser["clanid"] == null || $clanuser["clanid"] == 0) {
        return true;
    } else {
        $func->error(t('Bevor du einen neuen Clan anlegen kannst, musst du aus deinem aktuellen Clan austreten.'), "index.php?mod=clanmgr");
        return false;
    }
}
