<?php

namespace denbora\R_T_G_Services\examples\REST\Account;

use denbora\R_T_G_Services\casino\CasinoRest;

class PutChangePassword
{
    /**
     * PutChangePassword constructor.
     * @param CasinoRest $casino
     */
    public function __construct($casino)
    {
        try {
            $query = '{
                "player": {
                    "player_id": "10025123"
                },
                "current_password": "porter_12356",
                "new_password": "porter_12356"
            }';
            $result = $casino->account->putChangePassword($query);

            echo "<pre>";
            var_dump($result);
            echo "</pre>";
        } catch (\Exception $e) {
            echo "<pre>";
            var_dump($e);
            echo "</pre>";
        }
    }
}
