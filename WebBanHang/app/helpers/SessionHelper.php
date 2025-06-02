<?php 

class SessionHelper {
    public static function start() { 
        if (session_status() == PHP_SESSION_NONE) { 
            session_start(); 
        } 
    }

    public static function isLoggedIn() { 
        return isset($_SESSION['username']); 
    } 

    public static function isAdmin() { 
        return isset($_SESSION['username']) && $_SESSION['role'] === 'admin'; 
    } 

    public static function getRole() {
        self::start();
        return $_SESSION['role'] ?? 'guest';
    } 

    // Phương thức kiểm tra role cụ thể
    public static function hasRole($role) {
        self::start();
        return isset($_SESSION['role']) && $_SESSION['role'] === $role;
    }
}