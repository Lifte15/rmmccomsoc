<?php
/*
logout.php and Session Logout
Authors:
  - Lowie Jay Orillo (lowie.jaymier@gmail.com)
  - Caryl Mae Subaldo (subaldomae29@gmail.com)
  - Brian Angelo Bognot (c09651052069@gmail.com)
Last Modified: May 15, 2024
Overview: This file unsets and destroys the session, 
  preventing the user from accessing home or navigating back after clicking the logout button.
*/
session_start();

session_unset();
session_destroy();

header("Location: ../login.php");