<?php

function load_template($name){
    include __DIR__."/../__templates/$name.php";
    
}

function include_class($name){
    include __DIR__."/../include_class/$name.class.php";
}
