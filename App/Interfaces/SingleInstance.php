<?php namespace App\Interfaces;

interface SingleInstance
{
    /**
     * @return self
     */
    public static function getInstance();
}