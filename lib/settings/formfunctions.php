<?php


$FF = array(

	"sections" => array(
	
		"title" => array(
		
			"trim" => true,
			"in_array" => false,
			"test_array" => array(),
			"null" => false,
			"pattern" => true,
			"pattern_string" => "#[^А-Яа-я\-]+#u"
			
		),
		
		"parent_id" => array(
		
			"trim" => true,
			"in_array" => false,
			"test_array" => array(),
			"null" => false,
			"pattern" => true,
			"pattern_string" => "#[0-9]+#u"
			
		)
		
	),
	
	"products" => array(
		
		"parent_category" => array(
		
			"trim" => true,
			"in_array" => false,
			"test_array" => array(),
			"null" => false,
			"pattern" => true,
			"pattern_string" => "#[0-9]+#u"
			
		),
		
		"type_product" => array(
		
			"trim" => true,
			"in_array" => true,
			"test_array" => array(1,2),
			"null" => false,
			"pattern" => false,
			"pattern_string" => ""
			
		),
		
		"title" => array(
		
			"trim" => true,
			"in_array" => false,
			"test_array" => array(),
			"null" => false,
			"pattern" => true,
			"pattern_string" => "#[^А-Яа-я\-]+#u"
			
		),
		
		"price" => array(
		
			"trim" => true,
			"in_array" => false,
			"test_array" => array(),
			"null" => false,
			"pattern" => true,
			"pattern_string" => "#[0-9\.]+#u"
			
		),
		
		"color" => array(
		
			"trim" => true,
			"in_array" => true,
			"test_array" => array("Красный","Черный","Белый","Зеленый","Желтый"),
			"null" => false,
			"pattern" => false,
			"pattern_string" => "",
			"exeption" => array(
				"type_product/1/in_array",
				"type_product/1/trim"
			)
			
		),
		
		"url_brand" => array(
		
			"trim" => true,
			"in_array" => false,
			"test_array" => array(),
			"null" => true,
			"pattern" => true,
			"pattern_string" => "#[^А-Яа-я\-]+#u",
			"exeption" => array(
				"type_product/1/trim",
				"type_product/1/pattern"
			)
			
		)
		
	)
);