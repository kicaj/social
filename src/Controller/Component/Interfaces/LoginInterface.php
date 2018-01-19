<?php
namespace Social\Controller\Component\Interfaces;

interface LoginInterface
{
    public function login($code = null);
}