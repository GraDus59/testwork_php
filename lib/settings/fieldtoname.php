<?php

/* $FIELDS = array(
	"products" => array(
		"id" => "ID",
		"parent_category" => false,
		"type_product" => "Тип",
		"title" => "Название",
		"price" => "Цена",
		"color" => "Цвет",
		"url_brand" => "URL Бренда"
	),
	"sections" => array(
		"id" => "ID",
		"title" => "Название",
		"parent_id" => "Родительская категория",
	)
); */

$FIELDS = array(

	"products" => array(
	
		"id" => array(
			"name" => "ID",
			"form" => false
		),
		
		"parent_category" => array(
			"name" => false,
			"label" => "Род.Кат.",
			"form" => true,
			"type" => "select",
			"function" => "getAllParentSelectForm"
		),
		
		"type_product" => array(
			"name" => "Тип",
			"form" => true,
			"type" => "enum",
			"function" => "getTypeProducts"
		),
		
		"title" => array(
			"name" => "Название",
			"form" => true,
			"type" => "text"
		),
		
		"price" => array(
			"name" => "Цена",
			"form" => true,
			"type" => "text"
		),
		
		"color" => array(
			"name" => "Цвет",
			"form" => true,
			"type" => "enum",
			"function" => "getEnums"
		),
		
		"url_brand" => array(
			"name" => "URL Бренда",
			"form" => true,
			"type" => "text"
		)
	),
	
	"sections" => array(
	
		"id" => array(
			"name" => "ID",
			"form" => false
		),
		"title" => array(
			"name" => "Название",
			"form" => true,
			"type" => "text"
		),
		"parent_id" => array(
			"name" => "Родительская категория",
			"form" => true,
			"type" => "select",
			"function" => "getAllParentSelectForm",
			"parent_show" => true
		),
	)
);