<?php

class Session
{

    public function setflash($message)
    {
        if (isset($_SESSION['information'])): { ?>
            <div class="row">
                <center>
                    <div class="col s6 offset-s3">
                        <div class="card blue-grey darken-1">
                            <div class="card-content white-text">
                                <span
                                    class="card-title"><h4>Bonjour <?= $_SESSION['information']['nom'] ?> </h4> </span>
                                <p>En vous connectant à notre Application, vous pouvez mettre tous vos bar en
                                    Favoris,</br>
                                    mais également les trier suivant les favoris des différents utilisateurs ! </br>
                                    Faite vous plaisir et profiter des meilleurs bar du moment !
                                </p>
                            </div>
                            <div class="card-action">
                                <a href="../../index.php">Revenir à l'acceuil </a>
                            </div>
                        </div>
                    </div>
                </center>
            </div>
            <?php
        } endif;

    }
}
