<?php
session_start();

if(!isset($_SESSION["uid"])){
    echo "-1";
}