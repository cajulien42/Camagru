<?php
	// Set timezone
	date_default_timezone_set("Europe/paris");

	// Create connection to host
	if (!($pdo = new PDO($db_dsn, $db_user, $db_pass)))
		die("Failed to connect to host ($db_host)\n" . $err->getMessage());
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->exec("SET CHARACTER SET utf8");

	// Create DB it doesn't exist
	if (!($stmt = $pdo->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :db")))
		die("Failed to check information schema.");
	$stmt->execute(array(':db'=>$db_name));
	if ($stmt->rowCount() === 0)
		$pdo->exec("CREATE DATABASE $db_name;");
	$pdo->exec("USE $db_name;");
	$stmt->closeCursor();
	
	// Create user table
	if (!tableExists($pdo, "users"))
	{
		$pdo->exec("CREATE TABLE `users` (
		`user_id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
		`login` VARCHAR(20) NOT NULL,
		`email` VARCHAR(40) NOT NULL,
		`password` VARCHAR(255) NOT NULL,
		`lvl`INT NOT NULL DEFAULT 0,
		`confirmation` INT NOT NULL DEFAULT 0,
		`notify` INT NOT NULL DEFAULT 1,
		UNIQUE (`email`));");
		$pdo->exec("INSERT INTO `users` (`user_id`, `login`, `email`, `password`,`lvl`, `confirmation`) VALUES
				(NULL, 'camille', 'cajulien@student.42.fr', 'E250A178B443EE5AF2709A29A202F3994717E070F846B1C4DA96EC5E68AC8D082AD3AE5F3C34DA0AD7E9DED63F504807B714DD52767819EDCC6BE047D77D048B', 2, 1),
				(NULL, 'test', 'tetest@hotmail.fr', 'B913D5BBB8E461C2C5961CBE0EDCDADFD29F068225CEB37DA6DEFCF89849368F8C6C2EB6A4C4AC75775D032A0ECFDFE8550573062B653FE92FC7B8FB3B7BE8D6', 0, 1);");
	}

	// Create registration key table
	if (!tableExists($pdo, "registration_keys"))
	{
		$pdo->exec("CREATE TABLE `registration_keys` (
		`uid` INT NOT NULL,	
		`id` VARCHAR(255) NOT NULL,
		`key` VARCHAR(255) NOT NULL);");
	}

	// Create Gallery table
	if (!tableExists($pdo, "gallery"))
	{
		$pdo->exec("CREATE TABLE `gallery` (
		`img_id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL ,
		`img_url` VARCHAR(255) NOT NULL,	
		`login` VARCHAR(20) NOT NULL,
		`img_name` VARCHAR(255) NOT NULL,
		`filter_id` INT NOT NULL,
		`creation_date` INT NOT NULL,
		`likes` INT NOT NULL DEFAULT '0');");
	}

		// Create Filter table
		if (!tableExists($pdo, "filters"))
		{
			$pdo->exec("CREATE TABLE `filters` (
			`filter_id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,	
			`filter_name` VARCHAR(255) NOT NULL,
			`filter_cat` VARCHAR(255) NOT NULL,
			`filter_url` VARCHAR(255) NOT NULL);");
			$pdo->exec("INSERT INTO `filters` (`filter_id`, `filter_name`, `filter_cat`, `filter_url`) VALUES
				(NULL, 'worms', 'worms', 'img/worms.png'),
				(NULL, 'worms2', 'worms', 'img/worms2.png'),
				(NULL, 'worms3', 'worms', 'img/worms3.png'),
				(NULL, 'pickle1', 'rick_morty', 'img/Pickle_rick.png'),
				(NULL, 'rick1', 'rick_morty', 'img/rick1.png'),
				(NULL, 'rick2', 'rick_morty', 'img/rick2.png'),
				(NULL, 'beard', 'beards', 'img/beard.png'),
				(NULL, 'beard3', 'beards', 'img/beard3.png'),
				(NULL, 'ariana', 'chars', 'img/ariana.png'),
				(NULL, 'trump', 'chars', 'img/trump.png'),
				(NULL, 'pikachu', 'chars', 'img/pikachu.png'),
				(NULL, 'chewie', 'chars', 'img/chewie.png'),
				(NULL, 'keanu', 'chars', 'img/keanu.png');");
		}

		// Create F_Categories table
		if (!tableExists($pdo, "f_categories"))
		{
			$pdo->exec("CREATE TABLE `f_categories` (
			`cat_id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,	
			`cat_name` VARCHAR(255) NOT NULL);");
			$pdo->exec("INSERT INTO `f_categories` (`cat_id`, `cat_name`) VALUES
			(NULL, 'worms'),
			(NULL, 'chars'),
			(NULL, 'rick_morty'),
			(NULL, 'beards');");
		}

		// Create Comment table
		if (!tableExists($pdo, "Comments"))
		{
			$pdo->exec("CREATE TABLE `Comments` (
			`com_id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,	
			`com_login` VARCHAR(20) NOT NULL,
			`com_date` INT NOT NULL,
			`img_id` INT NOT NULL,
			`text` VARCHAR(255) NOT NULL);");
		}

		// Create likes table
		if (!tableExists($pdo, "likes"))
		{
			$pdo->exec("CREATE TABLE `likes` (
			`like_id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
			`user_id` INT NOT NULL,	
			`img_id` INT NOT NULL,
			`like_date` INT NOT NULL);");
		}

		// Create reset password table
		if (!tableExists($pdo, "resetpwd"))
		{
			$pdo->exec("CREATE TABLE `resetpwd` (
			`kid` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
			`login` VARCHAR(20) NOT NULL,
			`mail` VARCHAR(255) NOT NULL,
			`key` VARCHAR(255) NOT NULL);");
		}




