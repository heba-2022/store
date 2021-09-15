<?php

namespace App\Repositories;


interface CartRepository{

    function all();

    function add($itam,$quantity=1);

    function total();
    function empty();
}
?>