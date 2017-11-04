<?php
defined('BASEPATH') OR exit('No direct script access allowed');
interface Serializablee
{
    function toArray();
    function getClassName();
}