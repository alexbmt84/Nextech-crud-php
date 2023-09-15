<?php

    if (isset($_GET['err'])) {

        $err = htmlspecialchars($_GET['err']);

        switch ($err) {

            case 'password':
?>
            <div class="alert alert-danger mt-3">
                <strong>Error</strong> invalid email or password.
            </div>
<?php
            break;

            case 'email':
?>
            <div class="alert alert-danger mt-3">
                <strong>Error</strong> please enter a valid email adress.
            </div>
<?php
            break;

            case 'already':
?>
            <div class="alert alert-danger">
                <strong>Error</strong> account creation failed.
            </div>
<?php
            break;

            case 'confirmation':
?>
            <div class="alert alert-danger mt-3">
                <strong>Error</strong> passwords must be the same.
            </div>
<?php
            break;

            case 'pseudo':
?>
            <div class="alert alert-danger mt-3">
                <strong>Error</strong> invalid pseudo.
            </div>
<?php
            break;

            case 'update':
?>
            <div class="alert alert-danger mt-3">
                <strong>Error</strong> cannot update profile.
            </div>
<?php
            break;

        }

    }

?>