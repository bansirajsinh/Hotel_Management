<?php
/**
 * Common Header
 * 
 * Shared HTML <head> section included by all pages.
 * Set $pageTitle before including this file.
 * 
 * @package Booker
 */

// Default page title if not set
if (!isset($pageTitle)) {
    $pageTitle = 'Booker - Hotel Management';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Booker - A complete hotel management and booking system for rooms, tables, banquets, and transport services.">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
</head>
